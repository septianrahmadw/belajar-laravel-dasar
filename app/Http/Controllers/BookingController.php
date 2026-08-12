<?php

namespace App\Http\Controllers;

use App\Mail\BookingCreated;
use App\Mail\BookingPin;
use App\Mail\BookingStatusChanged;
use App\Models\Booking;
use App\Models\BookingAccessToken;
use App\Models\Room;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Mail\Mailable;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class BookingController extends Controller
{
    private function sendBookingNotification(string $email, Mailable $mail): void
    {
        try {
            Mail::to($email)->queue($mail);

            Log::info('Notifikasi booking dijadwalkan ke antrian', [
                'email' => $email,
                'mailable' => class_basename($mail),
            ]);
        } catch (\Throwable $e) {
            Log::error('Gagal memasukkan notifikasi booking ke antrian', [
                'email' => $email,
                'error' => $e->getMessage(),
            ]);
        }
    }

    private function isBot(): bool
    {
        if (request()->input('website_url') !== null && request()->input('website_url') !== '') {
            return true;
        }

        $openedAt = request()->input('opened_at');
        if ($openedAt) {
            $elapsed = time() - (int) $openedAt;
            if ($elapsed < 1) {
                return true;
            }
        }

        return false;
    }

    private function botResponse()
    {
        $room = Room::where('is_active', true)->first();

        return redirect()
            ->route('rooms.show', $room)
            ->with('success', 'Booking berhasil diajukan! Menunggu persetujuan admin.');
    }

    public function store(Request $request)
    {
        if ($this->isBot()) {
            return $this->botResponse();
        }

        $validated = $request->validate([
            'room_id' => 'required|exists:rooms,id',
            'booker_name' => 'required|string|max:255',
            'booker_email' => 'required|email|max:255',
            'booker_phone' => 'required|string|max:20',
            'jurusan' => 'required|string|max:255',
            'prodi_id' => 'required|exists:prodis,id',
            'purpose' => 'required|in:Kuliah,Praktikum',
            'mata_kuliah' => 'required|string|max:255',
            'semester' => 'required|integer|min:1|max:6',
            'kelas' => 'required|in:A,B,C,D,E',
            'dosen' => 'required|string|max:255',
            'teknisi' => 'nullable|string|max:255',
            'date' => 'required|date|after_or_equal:today',
            'start_time' => 'required|date_format:H:i|after_or_equal:07:00|before_or_equal:21:00',
            'end_time' => 'required|date_format:H:i|after:start_time|before_or_equal:21:00',
            'notes' => 'nullable|string|max:1000',
            'is_recurring' => 'nullable|boolean',
            'recurrence_end_date' => 'nullable|required_if:is_recurring,1|date|after_or_equal:date',
        ]);

        $room = Room::findOrFail($validated['room_id']);
        $isRecurring = ! empty($validated['is_recurring']);

        if ($isRecurring) {
            $startDate = Carbon::parse($validated['date']);
            $endDate = Carbon::parse($validated['recurrence_end_date']);

            $totalWeeks = $startDate->diffInWeeks($endDate) + 1;
            if ($totalWeeks > 16) {
                return back()->withErrors([
                    'recurrence_end_date' => 'Maksimal perulangan adalah 16 minggu (4 bulan).',
                ])->withInput();
            }

            $recurrenceId = (string) Str::uuid();
            $bookingsCreated = [];
            $conflictDate = null;
            $currentDate = $startDate->copy();

            while ($currentDate <= $endDate) {
                if (! $room->isAvailableForTime($currentDate->format('Y-m-d'), $validated['start_time'], $validated['end_time'])) {
                    $conflictDate = $currentDate->format('d M Y');
                    break;
                }
                $currentDate->addWeek();
            }

            if ($conflictDate) {
                return back()->withErrors([
                    'schedule' => "Ruangan sudah terbooking pada {$conflictDate} di jam yang sama. Silakan pilih waktu lain.",
                ])->withInput();
            }

            $currentDate = $startDate->copy();
            while ($currentDate <= $endDate) {
                $booking = Booking::create(array_merge($validated, [
                    'date' => $currentDate->format('Y-m-d'),
                    'is_recurring' => true,
                    'recurrence_id' => $recurrenceId,
                    'recurrence_end_date' => $endDate->format('Y-m-d'),
                ]));
                $bookingsCreated[] = $booking;
                $currentDate->addWeek();
            }

            $this->sendBookingNotification($validated['booker_email'], new BookingCreated($bookingsCreated[0]));

            $count = count($bookingsCreated);

            return redirect()
                ->route('rooms.show', ['room' => $room, 'date' => $bookingsCreated[0]->date->format('Y-m-d')])
                ->with('success', "{$count} jadwal booking berulang berhasil diajukan dan menunggu persetujuan admin. Silakan cek status booking di menu \"Booking Saya\" menggunakan email {$validated['booker_email']}.");

        } else {
            if (! $room->isAvailableForTime($validated['date'], $validated['start_time'], $validated['end_time'])) {
                return back()->withErrors([
                    'schedule' => 'Ruangan sudah terbooking pada waktu yang dipilih. Silakan pilih waktu lain.',
                ])->withInput();
            }

            $booking = Booking::create($validated);

            $this->sendBookingNotification($booking->booker_email, new BookingCreated($booking));

            return redirect()
                ->route('rooms.show', ['room' => $room, 'date' => $booking->date->format('Y-m-d')])
                ->with('success', "Booking ruangan {$room->name} untuk tanggal {$booking->date->format('d M Y')} jam {$booking->formatted_start_time} - {$booking->formatted_end_time} berhasil diajukan. Silakan cek status booking di menu \"Booking Saya\" menggunakan email {$booking->booker_email}.");
        }
    }

    public function myBookings(Request $request)
    {
        if ($request->query('logout')) {
            session()->forget(['booking_verified_email', 'booking_verified_at', 'booking_pin_email']);

            return redirect()->route('bookings.my');
        }

        $email = session('booking_verified_email');
        $verifiedAt = session('booking_verified_at');

        $verified = $email
            && $verifiedAt
            && Carbon::parse($verifiedAt)->addMinutes(30)->isFuture();

        if (! $verified) {
            session()->forget(['booking_verified_email', 'booking_verified_at']);

            return view('bookings.my-bookings', [
                'bookings' => collect(),
                'email' => null,
                'pinEmail' => session('booking_pin_email'),
                'verified' => false,
            ]);
        }

        $bookings = Booking::where('booker_email', $email)
            ->with('room')
            ->orderByDesc('date')
            ->orderByDesc('created_at')
            ->get();

        return view('bookings.my-bookings', compact('bookings', 'email') + [
            'pinEmail' => null,
            'verified' => true,
        ]);
    }

    public function sendPin(Request $request)
    {
        $validated = $request->validate([
            'email' => 'required|email|max:255',
        ]);

        $email = mb_strtolower($validated['email']);

        if (Booking::where('booker_email', $email)->exists()) {
            BookingAccessToken::where('email', $email)->delete();

            $pin = (string) random_int(100000, 999999);

            BookingAccessToken::create([
                'email' => $email,
                'pin_hash' => hash('sha256', $pin),
                'expires_at' => now()->addMinutes(10),
            ]);

            $this->sendBookingNotification($email, new BookingPin($email, $pin));

            session()->put('booking_pin_email', $email);
        } else {
            session()->forget('booking_pin_email');
        }

        return redirect()
            ->route('bookings.my')
            ->with('success', 'Jika email tersebut terdaftar pada booking, kode verifikasi telah dikirim. Silakan cek kotak masuk (atau folder spam) email Anda.')
            ->with('success_title', 'Kode Verifikasi Terkirim');
    }

    public function verifyPin(Request $request)
    {
        $validated = $request->validate([
            'email' => 'required|email|max:255',
            'pin' => 'required|string|size:6',
        ]);

        $email = mb_strtolower($validated['email']);

        $record = BookingAccessToken::where('email', $email)
            ->whereNull('used_at')
            ->where('expires_at', '>', now())
            ->latest()
            ->first();

        if (! $record) {
            return back()->withErrors([
                'pin' => 'Kode tidak ditemukan atau sudah kedaluwarsa. Silakan minta kode baru.',
            ])->withInput();
        }

        if ($record->attempts >= 5) {
            $record->delete();

            session()->forget('booking_pin_email');

            return back()->withErrors([
                'pin' => 'Terlalu banyak percobaan salah. Kode telah dinonaktifkan, silakan minta kode baru.',
            ])->withInput();
        }

        if (! hash_equals($record->pin_hash, hash('sha256', $validated['pin']))) {
            $record->increment('attempts');
            $remaining = 5 - $record->fresh()->attempts;

            return back()->withErrors([
                'pin' => "Kode salah. Sisa {$remaining} percobaan.",
            ])->withInput();
        }

        $record->update(['used_at' => now()]);

        session([
            'booking_verified_email' => $record->email,
            'booking_verified_at' => now(),
        ]);
        session()->forget('booking_pin_email');

        return redirect()->route('bookings.my');
    }

    private function assertBookingOwner(Booking $booking): void
    {
        $email = session('booking_verified_email');
        $verifiedAt = session('booking_verified_at');

        $verified = $email
            && $verifiedAt
            && $email === $booking->booker_email
            && Carbon::parse($verifiedAt)->addMinutes(30)->isFuture();

        if (! $verified) {
            abort(403);
        }
    }

    public function cancel(Booking $booking)
    {
        $this->assertBookingOwner($booking);

        if ($booking->status !== 'pending' && $booking->status !== 'approved') {
            return back()->withErrors(['error' => 'Booking tidak dapat dibatalkan.']);
        }

        $oldStatus = $booking->status;
        $booking->update(['status' => 'cancelled']);

        $this->sendBookingNotification($booking->booker_email, new BookingStatusChanged($booking, $oldStatus));

        return back()->with('success', 'Booking berhasil dibatalkan.')
            ->with('success_title', 'Booking Dibatalkan');
    }

    public function cancelRecurrence(Booking $booking)
    {
        $this->assertBookingOwner($booking);

        if (! $booking->recurrence_id) {
            return back()->withErrors(['error' => 'Booking ini bukan bagian dari jadwal berulang.']);
        }

        $recurrenceBookings = Booking::where('recurrence_id', $booking->recurrence_id)
            ->whereIn('status', ['pending', 'approved'])
            ->get();

        foreach ($recurrenceBookings as $recBooking) {
            $oldStatus = $recBooking->status;
            $recBooking->update(['status' => 'cancelled']);
            $this->sendBookingNotification($recBooking->booker_email, new BookingStatusChanged($recBooking, $oldStatus));
        }

        return back()->with('success', 'Semua jadwal berulang berhasil dibatalkan.')
            ->with('success_title', 'Booking Dibatalkan');
    }
}

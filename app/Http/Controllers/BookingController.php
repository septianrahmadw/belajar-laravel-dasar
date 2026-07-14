<?php

namespace App\Http\Controllers;

use App\Mail\BookingCreated;
use App\Models\Booking;
use App\Models\Room;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class BookingController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'room_id' => 'required|exists:rooms,id',
            'booker_name' => 'required|string|max:255',
            'booker_email' => 'required|email|max:255',
            'booker_phone' => 'nullable|string|max:20',
            'booker_nim' => 'nullable|string|max:20',
            'purpose' => 'required|string|max:255',
            'date' => 'required|date|after_or_equal:today',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
            'notes' => 'nullable|string|max:1000',
            'is_recurring' => 'nullable|boolean',
            'recurrence_end_date' => 'nullable|required_if:is_recurring,1|date|after_or_equal:date',
        ]);

        $room = Room::findOrFail($validated['room_id']);
        $isRecurring = !empty($validated['is_recurring']);

        if ($isRecurring) {
            $startDate = \Carbon\Carbon::parse($validated['date']);
            $endDate = \Carbon\Carbon::parse($validated['recurrence_end_date']);

            $totalWeeks = $startDate->diffInWeeks($endDate) + 1;
            if ($totalWeeks > 12) {
                return back()->withErrors([
                    'recurrence_end_date' => 'Maksimal perulangan adalah 12 minggu (3 bulan).',
                ])->withInput();
            }

            $recurrenceId = (string) Str::uuid();
            $bookingsCreated = [];
            $conflictDate = null;
            $currentDate = $startDate->copy();

            while ($currentDate <= $endDate) {
                if (!$room->isAvailableForTime($currentDate->format('Y-m-d'), $validated['start_time'], $validated['end_time'])) {
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

            Mail::to($validated['booker_email'])->send(new BookingCreated($bookingsCreated[0]));

            $count = count($bookingsCreated);
            return redirect()
                ->route('rooms.show', $room)
                ->with('success', "Booking berulang berhasil diajukan! {$count} jadwal akan menunggu persetujuan admin.");

        } else {
            if (!$room->isAvailableForTime($validated['date'], $validated['start_time'], $validated['end_time'])) {
                return back()->withErrors([
                    'schedule' => 'Ruangan sudah terbooking pada waktu yang dipilih. Silakan pilih waktu lain.',
                ])->withInput();
            }

            $booking = Booking::create($validated);

            Mail::to($booking->booker_email)->send(new BookingCreated($booking));

            return redirect()
                ->route('rooms.show', $room)
                ->with('success', 'Booking berhasil diajukan! Menunggu persetujuan admin.');
        }
    }

    public function myBookings(Request $request)
    {
        $email = $request->get('email');

        if (!$email) {
            return view('bookings.my-bookings', ['bookings' => collect(), 'email' => null]);
        }

        $bookings = Booking::where('booker_email', $email)
            ->with('room')
            ->orderByDesc('date')
            ->orderByDesc('created_at')
            ->get();

        return view('bookings.my-bookings', compact('bookings', 'email'));
    }

    public function cancel(Booking $booking)
    {
        if ($booking->status !== 'pending' && $booking->status !== 'approved') {
            return back()->withErrors(['error' => 'Booking tidak dapat dibatalkan.']);
        }

        $oldStatus = $booking->status;
        $booking->update(['status' => 'cancelled']);

        Mail::to($booking->booker_email)->send(new \App\Mail\BookingStatusChanged($booking, $oldStatus));

        return back()->with('success', 'Booking berhasil dibatalkan.');
    }

    public function cancelRecurrence(Booking $booking)
    {
        if (!$booking->recurrence_id) {
            return back()->withErrors(['error' => 'Booking ini bukan bagian dari jadwal berulang.']);
        }

        $recurrenceBookings = Booking::where('recurrence_id', $booking->recurrence_id)
            ->whereIn('status', ['pending', 'approved'])
            ->get();

        foreach ($recurrenceBookings as $recBooking) {
            $oldStatus = $recBooking->status;
            $recBooking->update(['status' => 'cancelled']);
            Mail::to($recBooking->booker_email)->send(new \App\Mail\BookingStatusChanged($recBooking, $oldStatus));
        }

        return back()->with('success', 'Semua jadwal berulang berhasil dibatalkan.');
    }
}

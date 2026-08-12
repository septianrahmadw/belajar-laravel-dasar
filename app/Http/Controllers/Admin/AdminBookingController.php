<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Mail\BookingCreated;
use App\Mail\BookingStatusChanged;
use App\Models\Booking;
use App\Models\Prodi;
use App\Models\Room;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Mail\Mailable;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;
use League\Csv\Writer;

class AdminBookingController extends Controller
{
    public function index(Request $request)
    {
        $query = Booking::with('room', 'prodi');

        if ($status = $request->get('status')) {
            $query->where('status', $status);
        }

        if ($search = $request->get('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('booker_name', 'like', "%{$search}%")
                  ->orWhere('booker_email', 'like', "%{$search}%")
                  ->orWhere('purpose', 'like', "%{$search}%")
                  ->orWhere('jurusan', 'like', "%{$search}%")
                  ->orWhere('mata_kuliah', 'like', "%{$search}%")
                  ->orWhere('dosen', 'like', "%{$search}%");
            });
        }

        if ($date = $request->get('date')) {
            $query->whereDate('date', $date);
        }

        $bookings = $query->orderByDesc('date')->orderByDesc('created_at')->paginate(15)->withQueryString();

        return view('admin.bookings.index', compact('bookings'));
    }

    public function schedule(Request $request)
    {
        $rooms = Room::where('is_active', true)
            ->withCount('bookings as booking_count')
            ->orderBy('name')
            ->get();

        return view('admin.schedule.index', compact('rooms'));
    }

    public function roomSchedule(Request $request, Room $room)
    {
        $date = $request->get('date', Carbon::today()->format('Y-m-d'));
        $carbonDate = Carbon::parse($date);

        $weekStart = $carbonDate->copy()->startOfWeek(Carbon::MONDAY);
        $weekEnd = $carbonDate->copy()->startOfWeek(Carbon::MONDAY)->addDays(4);

        $bookings = Booking::with('room', 'prodi')
            ->where('room_id', $room->id)
            ->whereBetween('date', [$weekStart->format('Y-m-d'), $weekEnd->format('Y-m-d')])
            ->whereIn('status', ['approved', 'pending'])
            ->orderBy('start_time')
            ->get();

        $days = [];
        for ($i = 0; $i < 5; $i++) {
            $day = $weekStart->copy()->addDays($i)->format('Y-m-d');
            $days[$day] = $bookings
                ->filter(fn (Booking $b) => $b->date->format('Y-m-d') === $day)
                ->values();
        }

        $schedule = ['room' => $room, 'days' => $days];

        $weekDates = [];
        for ($i = 0; $i < 5; $i++) {
            $d = $weekStart->copy()->addDays($i);
            $weekDates[] = [
                'date' => $d->format('Y-m-d'),
                'label' => $d->locale('id')->isoFormat('ddd'),
                'dayNum' => $d->format('d'),
                'month' => $d->format('M'),
                'isToday' => $d->isToday(),
            ];
        }

        $prevWeek = $weekStart->copy()->subWeek()->format('Y-m-d');
        $nextWeek = $weekStart->copy()->addWeek()->format('Y-m-d');

        return view('admin.schedule.show', compact('schedule', 'weekDates', 'carbonDate', 'prevWeek', 'nextWeek'));
    }

    public function show(Booking $booking)
    {
        $booking->load('room', 'prodi');
        return view('admin.bookings.show', compact('booking'));
    }

    public function approve(Booking $booking)
    {
        if ($booking->status !== 'pending') {
            return back()->withErrors(['error' => 'Hanya booking dengan status menunggu yang dapat disetujui.']);
        }

        if ($booking->recurrence_id) {
            $series = Booking::with('room')
                ->where('recurrence_id', $booking->recurrence_id)
                ->where('status', 'pending')
                ->orderBy('date')
                ->get();

            $seriesIds = $series->pluck('id')->all();

            $conflicts = $series->filter(function (Booking $occ) use ($seriesIds) {
                return !$occ->room->isAvailableForTime($occ->date->format('Y-m-d'), $occ->start_time, $occ->end_time, $seriesIds);
            });

            if ($conflicts->isNotEmpty()) {
                $dates = $conflicts->map(fn (Booking $occ) => $occ->date->format('d M Y'))->join(', ');

                return back()->withErrors(['error' => "Tidak dapat menyetujui seluruh jadwal berulang karena terdapat konflik pada: {$dates}."]);
            }

            foreach ($series as $occ) {
                $oldStatus = $occ->status;
                $occ->update(['status' => 'approved']);
                $this->sendBookingNotification($occ->booker_email, new BookingStatusChanged($occ, $oldStatus));
            }

            $count = $series->count();

            return back()->with('success', "{$count} jadwal berulang berhasil disetujui sekaligus.");
        }

        $room = $booking->room;
        if (!$room->isAvailableForTime($booking->date->format('Y-m-d'), $booking->start_time, $booking->end_time, $booking->id)) {
            return back()->withErrors(['error' => 'Waktu sudah disetujui oleh booking lain. Tidak dapat menyetujui booking ini.']);
        }

        $oldStatus = $booking->status;
        $booking->update(['status' => 'approved']);

        $this->sendBookingNotification($booking->booker_email, new BookingStatusChanged($booking, $oldStatus));

        return back()->with('success', 'Booking berhasil disetujui.');
    }

    public function edit(Booking $booking)
    {
        $booking->load('room', 'prodi');

        if (!in_array($booking->status, ['approved', 'pending'])) {
            return back()->withErrors(['error' => 'Hanya booking dengan status disetujui atau menunggu yang dapat diedit.']);
        }

        $rooms = Room::where('is_active', true)->orderBy('name')->get();
        $prodis = Prodi::where('is_active', true)->orderBy('jurusan')->orderBy('name')->get();
        $timeSlots = $this->getTimeSlots();
        $jurusans = $this->getJurusans();

        return view('admin.bookings.edit', compact('booking', 'rooms', 'prodis', 'timeSlots', 'jurusans'));
    }

    public function update(Request $request, Booking $booking)
    {
        if (!in_array($booking->status, ['approved', 'pending'])) {
            return back()->withErrors(['error' => 'Hanya booking dengan status disetujui atau menunggu yang dapat diedit.']);
        }

        $validated = $request->validate([
            'room_id' => 'required|exists:rooms,id',
            'booker_name' => 'required|string|max:255',
            'booker_email' => 'required|email|max:255',
            'booker_phone' => 'required|string|max:20',
            'jurusan' => 'required|string|max:255',
            'prodi_id' => 'nullable|exists:prodis,id',
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
        ]);

        $room = Room::findOrFail($validated['room_id']);
        if (!$room->isAvailableForTime($validated['date'], $validated['start_time'], $validated['end_time'], $booking->id)) {
            return back()->withErrors(['error' => 'Waktu dan ruangan sudah terpakai oleh booking lain. Silakan pilih waktu atau ruangan lain.'])
                ->withInput();
        }

        $oldDate = $booking->date->format('d M Y');
        $oldTime = $booking->formatted_start_time . ' - ' . $booking->formatted_end_time;
        $oldRoom = $booking->room->name;

        $booking->update($validated);

        $booking->load('room');

        $this->sendBookingNotification($booking->booker_email, new BookingStatusChanged($booking, $booking->status));

        return redirect()->route('admin.bookings.show', $booking)
            ->with('success', "Booking berhasil diperbarui dari {$oldRoom} ({$oldDate}, {$oldTime}) ke {$booking->room->name} ({$booking->date->format('d M Y')}, {$booking->formatted_start_time} - {$booking->formatted_end_time}).");
    }

    private function getJurusans(): array
    {
        return [
            'Budidaya Tanaman Pangan',
            'Budidaya Tanaman Perkebunan',
            'Teknologi Pertanian',
            'Peternakan',
            'Ekonomi dan Bisnis',
            'Teknik',
            'Perikanan dan Kelautan',
            'Teknologi Informasi',
        ];
    }

    private function getTimeSlots(): array
    {
        $slots = [];
        for ($h = 7; $h < 21; $h++) {
            $slots[] = sprintf('%02d:00', $h);
            $slots[] = sprintf('%02d:30', $h);
        }
        $slots[] = '21:00';
        return $slots;
    }

    private function sendBookingNotification(string $email, Mailable $mail): void
    {
        try {
            \Mail::to($email)->send($mail);
        } catch (\Throwable $e) {
            Log::error('Gagal mengirim notifikasi booking', [
                'email' => $email,
                'error' => $e->getMessage(),
            ]);
        }
    }

    public function reject(Request $request, Booking $booking)
    {
        if ($booking->status !== 'pending') {
            return back()->withErrors(['error' => 'Hanya booking dengan status menunggu yang dapat ditolak.']);
        }

        $request->validate([
            'rejection_reason' => 'required|string|max:500',
        ]);

        $rejectionReason = $request->input('rejection_reason');

        if ($booking->recurrence_id) {
            $series = Booking::where('recurrence_id', $booking->recurrence_id)
                ->where('status', 'pending')
                ->get();

            foreach ($series as $occ) {
                $oldStatus = $occ->status;
                $occ->update([
                    'status'           => 'rejected',
                    'rejection_reason' => $rejectionReason,
                ]);
                $this->sendBookingNotification($occ->booker_email, new BookingStatusChanged($occ, $oldStatus, $rejectionReason));
            }

            $count = $series->count();

            return back()->with('success', "{$count} jadwal berulang berhasil ditolak sekaligus.");
        }

        $oldStatus = $booking->status;
        $booking->update([
            'status'           => 'rejected',
            'rejection_reason' => $rejectionReason,
        ]);

        $this->sendBookingNotification($booking->booker_email, new BookingStatusChanged($booking, $oldStatus, $rejectionReason));

        return back()->with('success', 'Booking berhasil ditolak.');
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
            $this->sendBookingNotification($recBooking->booker_email, new BookingStatusChanged($recBooking, $oldStatus));
        }

        return back()->with('success', 'Semua jadwal berulang berhasil dibatalkan.');
    }

    public function destroy(Booking $booking)
    {
        $oldStatus = $booking->status;
        $booking->update(['status' => 'cancelled']);

        $this->sendBookingNotification($booking->booker_email, new BookingStatusChanged($booking, $oldStatus));

        return redirect()->route('admin.bookings.index')->with('success', 'Booking berhasil dibatalkan.');
    }

    public function forceDestroy(Booking $booking)
    {
        $booking->delete();

        return redirect()->route('admin.bookings.index')->with('success', 'Data booking berhasil dihapus permanen.');
    }

    public function exportPdf(Request $request)
    {
        $query = Booking::with('room', 'prodi');

        if ($status = $request->get('status')) {
            $query->where('status', $status);
        }
        if ($search = $request->get('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('booker_name', 'like', "%{$search}%")
                  ->orWhere('booker_email', 'like', "%{$search}%")
                  ->orWhere('purpose', 'like', "%{$search}%")
                  ->orWhere('jurusan', 'like', "%{$search}%")
                  ->orWhere('mata_kuliah', 'like', "%{$search}%")
                  ->orWhere('dosen', 'like', "%{$search}%");
            });
        }
        if ($date = $request->get('date')) {
            $query->whereDate('date', $date);
        }

        $bookings = $query->orderByDesc('date')->orderByDesc('created_at')->get();

        $search = $request->get('search');
        $date = $request->get('date');
        $status = $request->get('status');

        $pdf = Pdf::loadView('admin.bookings.export-pdf', compact('bookings', 'search', 'date', 'status'))
            ->setPaper('a4', 'landscape');

        return $pdf->download('laporan-booking-' . now()->format('Y-m-d') . '.pdf');
    }

    public function exportCsv(Request $request)
    {
        $query = Booking::with('room', 'prodi');

        if ($status = $request->get('status')) {
            $query->where('status', $status);
        }
        if ($search = $request->get('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('booker_name', 'like', "%{$search}%")
                  ->orWhere('booker_email', 'like', "%{$search}%")
                  ->orWhere('purpose', 'like', "%{$search}%")
                  ->orWhere('jurusan', 'like', "%{$search}%")
                  ->orWhere('mata_kuliah', 'like', "%{$search}%")
                  ->orWhere('dosen', 'like', "%{$search}%");
            });
        }
        if ($date = $request->get('date')) {
            $query->whereDate('date', $date);
        }

        $bookings = $query->orderByDesc('date')->orderByDesc('created_at')->get();

        $csv = Writer::createFromFileObject(new \SplTempFileObject());
        $csv->insertOne(['No', 'Nama Peminjam', 'Email', 'No. HP', 'Jurusan', 'Prodi', 'Keperluan', 'Mata Kuliah', 'Semester', 'Kelas', 'Dosen', 'Teknisi', 'Ruangan', 'Tanggal', 'Jam Mulai', 'Jam Selesai', 'Status', 'Catatan', 'Diajukan Pada']);

        foreach ($bookings as $i => $b) {
            $csv->insertOne([
                $i + 1,
                $b->booker_name,
                $b->booker_email,
                $b->booker_phone ?? '-',
                $b->jurusan ?? '-',
                $b->prodi?->name ?? '-',
                $b->purpose,
                $b->mata_kuliah ?? '-',
                $b->semester ?? '-',
                $b->kelas ?? '-',
                $b->dosen ?? '-',
                $b->teknisi ?? '-',
                $b->room->name,
                $b->date->format('d/m/Y'),
                $b->formatted_start_time,
                $b->formatted_end_time,
                $b->statusLabel,
                $b->notes ?? '-',
                $b->created_at->format('d/m/Y H:i'),
            ]);
        }

        $csv->output('laporan-booking-' . now()->format('Y-m-d') . '.csv');
    }
}

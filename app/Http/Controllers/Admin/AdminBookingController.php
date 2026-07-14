<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Mail\BookingCreated;
use App\Mail\BookingStatusChanged;
use App\Models\Booking;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use League\Csv\Writer;

class AdminBookingController extends Controller
{
    public function index(Request $request)
    {
        $query = Booking::with('room');

        if ($status = $request->get('status')) {
            $query->where('status', $status);
        }

        if ($search = $request->get('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('booker_name', 'like', "%{$search}%")
                  ->orWhere('booker_email', 'like', "%{$search}%")
                  ->orWhere('purpose', 'like', "%{$search}%")
                  ->orWhere('booker_nim', 'like', "%{$search}%");
            });
        }

        if ($date = $request->get('date')) {
            $query->whereDate('date', $date);
        }

        $bookings = $query->orderByDesc('date')->orderByDesc('created_at')->paginate(15)->withQueryString();

        return view('admin.bookings.index', compact('bookings'));
    }

    public function show(Booking $booking)
    {
        $booking->load('room');
        return view('admin.bookings.show', compact('booking'));
    }

    public function approve(Booking $booking)
    {
        if ($booking->status !== 'pending') {
            return back()->withErrors(['error' => 'Hanya booking dengan status menunggu yang dapat disetujui.']);
        }

        $room = $booking->room;
        if (!$room->isAvailableForTime($booking->date->format('Y-m-d'), $booking->start_time, $booking->end_time, $booking->id)) {
            return back()->withErrors(['error' => 'Waktu sudah disetujui oleh booking lain. Tidak dapat menyetujui booking ini.']);
        }

        $oldStatus = $booking->status;
        $booking->update(['status' => 'approved']);

        \Mail::to($booking->booker_email)->send(new BookingStatusChanged($booking, $oldStatus));

        return back()->with('success', 'Booking berhasil disetujui.');
    }

    public function reject(Booking $booking)
    {
        if ($booking->status !== 'pending') {
            return back()->withErrors(['error' => 'Hanya booking dengan status menunggu yang dapat ditolak.']);
        }

        $oldStatus = $booking->status;
        $booking->update(['status' => 'rejected']);

        \Mail::to($booking->booker_email)->send(new BookingStatusChanged($booking, $oldStatus));

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
            \Mail::to($recBooking->booker_email)->send(new BookingStatusChanged($recBooking, $oldStatus));
        }

        return back()->with('success', 'Semua jadwal berulang berhasil dibatalkan.');
    }

    public function destroy(Booking $booking)
    {
        $oldStatus = $booking->status;
        $booking->update(['status' => 'cancelled']);

        \Mail::to($booking->booker_email)->send(new BookingStatusChanged($booking, $oldStatus));

        return redirect()->route('admin.bookings.index')->with('success', 'Booking berhasil dibatalkan.');
    }

    public function exportPdf(Request $request)
    {
        $query = Booking::with('room');

        if ($status = $request->get('status')) {
            $query->where('status', $status);
        }
        if ($search = $request->get('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('booker_name', 'like', "%{$search}%")
                  ->orWhere('booker_email', 'like', "%{$search}%")
                  ->orWhere('purpose', 'like', "%{$search}%")
                  ->orWhere('booker_nim', 'like', "%{$search}%");
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
        $query = Booking::with('room');

        if ($status = $request->get('status')) {
            $query->where('status', $status);
        }
        if ($search = $request->get('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('booker_name', 'like', "%{$search}%")
                  ->orWhere('booker_email', 'like', "%{$search}%")
                  ->orWhere('purpose', 'like', "%{$search}%")
                  ->orWhere('booker_nim', 'like', "%{$search}%");
            });
        }
        if ($date = $request->get('date')) {
            $query->whereDate('date', $date);
        }

        $bookings = $query->orderByDesc('date')->orderByDesc('created_at')->get();

        $csv = Writer::createFromFileObject(new \SplTempFileObject());
        $csv->insertOne(['No', 'Nama Peminjam', 'Email', 'No. HP', 'NIM', 'Ruangan', 'Tanggal', 'Jam Mulai', 'Jam Selesai', 'Keperluan', 'Status', 'Catatan', 'Diajukan Pada']);

        foreach ($bookings as $i => $b) {
            $csv->insertOne([
                $i + 1,
                $b->booker_name,
                $b->booker_email,
                $b->booker_phone ?? '-',
                $b->booker_nim ?? '-',
                $b->room->name,
                $b->date->format('d/m/Y'),
                $b->formatted_start_time,
                $b->formatted_end_time,
                $b->purpose,
                $b->statusLabel,
                $b->notes ?? '-',
                $b->created_at->format('d/m/Y H:i'),
            ]);
        }

        $csv->output('laporan-booking-' . now()->format('Y-m-d') . '.csv');
    }
}

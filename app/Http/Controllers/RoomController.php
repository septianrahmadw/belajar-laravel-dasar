<?php

namespace App\Http\Controllers;

use App\Models\Prodi;
use App\Models\Room;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class RoomController extends Controller
{
    public function index()
    {
        $today = Carbon::today()->format('Y-m-d');
        $now = Carbon::now();
        $currentHour = (int) $now->format('H');

        $rooms = Room::with('allowedProdis')->where('is_active', true)->get()->map(function ($room) use ($today, $now, $currentHour) {
            $allTodayBookings = $room->bookings()
                ->whereDate('date', $today)
                ->whereNotIn('status', ['rejected', 'cancelled'])
                ->orderBy('start_time')
                ->get();

            $approvedBookings = $allTodayBookings->where('status', 'approved');
            $pendingBookings = $allTodayBookings->where('status', 'pending');

            $totalSlots = 14;
            $operatingStart = 7;
            $operatingEnd = 21;

            $bookedHours = $approvedBookings->sum(function ($b) {
                $start = max((int) explode(':', $b->formatted_start_time)[0], 7);
                $end = min((int) explode(':', $b->formatted_end_time)[0], 21);
                return max(0, $end - $start);
            });

            $availableHours = max(0, $totalSlots - $bookedHours);

            $timeline = [];
            for ($h = $operatingStart; $h < $operatingEnd; $h++) {
                $slotStart = sprintf('%02d:00', $h);
                $slotEnd = sprintf('%02d:00', $h + 1);

                $approvedBooking = $approvedBookings->first(function ($b) use ($slotStart, $slotEnd) {
                    return $b->formatted_start_time < $slotEnd && $b->formatted_end_time > $slotStart;
                });

                $pendingBooking = null;
                if (!$approvedBooking) {
                    $pendingBooking = $pendingBookings->first(function ($b) use ($slotStart, $slotEnd) {
                        return $b->formatted_start_time < $slotEnd && $b->formatted_end_time > $slotStart;
                    });
                }

                $booking = $approvedBooking ?? $pendingBooking;

                $timeline[] = [
                    'hour' => $h,
                    'label' => $slotStart,
                    'status' => $approvedBooking ? 'approved' : ($pendingBooking ? 'pending' : 'available'),
                    'isPast' => $h < $currentHour,
                    'purpose' => $booking?->purpose,
                    'booker' => $booking?->booker_name,
                ];
            }

            $isFullyBooked = $bookedHours >= $totalSlots;

            $upcomingBookings = $approvedBookings->filter(function ($b) use ($now) {
                return $b->formatted_start_time > $now->format('H:i') || Carbon::parse($b->date)->isFuture();
            });

            return [
                'room' => $room,
                'all_today_bookings' => $allTodayBookings,
                'approved_count' => $approvedBookings->count(),
                'pending_count' => $pendingBookings->count(),
                'booked_hours' => $bookedHours,
                'available_hours' => $availableHours,
                'total_slots' => $totalSlots,
                'timeline' => $timeline,
                'is_fully_booked' => $isFullyBooked,
                'status' => $isFullyBooked ? 'full' : ($bookedHours > 0 ? 'partial' : 'available'),
                'next_booking' => $upcomingBookings->first(),
                'is_restricted' => $room->is_restricted(),
                'allowed_prodis' => $room->allowedProdis->map(fn ($p) => ['id' => $p->id, 'name' => $p->name, 'jurusan' => $p->jurusan]),
            ];
        });

        $allProdis = Prodi::where('is_active', true)->orderBy('jurusan')->orderBy('name')->get();

        return view('rooms.index', compact('rooms', 'allProdis'));
    }

    public function show(Room $room, Request $request)
    {
        if ($room->is_restricted()) {
            $verifiedProdiId = session("room_{$room->id}_verified_prodi");
            if (!$verifiedProdiId || !$room->isProdiAllowed($verifiedProdiId)) {
                return redirect()->route('rooms.index')
                    ->with('error', 'Anda tidak memiliki akses ke lab ini. Silakan verifikasi prodi Anda terlebih dahulu.');
            }
        }

        $date = $request->get('date', Carbon::today()->format('Y-m-d'));
        $carbonDate = Carbon::parse($date);

        $bookings = $room->bookings()
            ->whereDate('date', $date)
            ->whereNotIn('status', ['rejected', 'cancelled'])
            ->orderBy('start_time')
            ->get();

        $weekStart = $carbonDate->copy()->startOfWeek(Carbon::MONDAY);
        $weekDates = [];
        for ($i = 0; $i < 7; $i++) {
            $d = $weekStart->copy()->addDays($i);
            $weekDates[] = [
                'date' => $d->format('Y-m-d'),
                'day' => $d->locale('id')->isoFormat('ddd'),
                'dayNum' => $d->format('d'),
                'isToday' => $d->isToday(),
                'isPast' => $d->isPast() && !$d->isToday(),
            ];
        }

        $timeSlots = [];
        for ($hour = 7; $hour <= 17; $hour++) {
            $timeSlots[] = sprintf('%02d:00', $hour);
        }

        $prodis = Prodi::where('is_active', true)->orderBy('jurusan')->orderBy('name')->get();

        $monthStart = $carbonDate->copy()->startOfMonth()->startOfWeek(Carbon::MONDAY);
        $monthEnd = $carbonDate->copy()->endOfMonth()->endOfWeek(Carbon::SUNDAY);
        $monthBookings = $room->bookings()
            ->whereBetween('date', [$monthStart->format('Y-m-d'), $monthEnd->format('Y-m-d')])
            ->whereNotIn('status', ['rejected', 'cancelled'])
            ->orderBy('date')
            ->orderBy('start_time')
            ->get()
            ->groupBy(fn ($b) => Carbon::parse($b->date)->format('Y-m-d'))
            ->map(function ($items) {
                return $items->map(fn ($b) => [
                    'date' => $b->date,
                    'start' => $b->formatted_start_time,
                    'end' => $b->formatted_end_time,
                    'purpose' => $b->purpose,
                    'booker_name' => $b->booker_name,
                    'status' => $b->status,
                ]);
            });

        $verifiedProdiId = session("room_{$room->id}_verified_prodi");
        $verifiedProdi = $verifiedProdiId ? Prodi::find($verifiedProdiId) : null;

        return view('rooms.show', compact('room', 'date', 'bookings', 'weekDates', 'timeSlots', 'carbonDate', 'prodis', 'monthBookings', 'verifiedProdi'));
    }

    public function schedule(Room $room, Request $request)
    {
        $date = $request->get('date', Carbon::today()->format('Y-m-d'));

        $bookings = $room->bookings()
            ->whereDate('date', $date)
            ->whereNotIn('status', ['rejected', 'cancelled'])
            ->orderBy('start_time')
            ->get();

        return response()->json([
            'date' => $date,
            'bookings' => $bookings->map(fn ($b) => [
                'id' => $b->id,
                'start_time' => $b->start_time,
                'end_time' => $b->end_time,
                'purpose' => $b->purpose,
                'booker_name' => $b->booker_name,
                'booker_email' => $b->booker_email,
                'booker_phone' => $b->booker_phone,
                'jurusan' => $b->jurusan,
                'prodi' => $b->prodi->name ?? '-',
                'mata_kuliah' => $b->mata_kuliah,
                'semester' => $b->semester,
                'kelas' => $b->kelas,
                'dosen' => $b->dosen,
                'teknisi' => $b->teknisi,
                'status' => $b->status,
            ]),
        ]);
    }

    public function monthSchedule(Room $room, Request $request)
    {
        $request->validate([
            'month' => 'required|date_format:Y-m',
        ]);

        $carbonMonth = Carbon::parse($request->month . '-01');

        $monthStart = $carbonMonth->copy()->startOfMonth()->startOfWeek(Carbon::MONDAY);
        $monthEnd = $carbonMonth->copy()->endOfMonth()->endOfWeek(Carbon::SUNDAY);

        $monthBookings = $room->bookings()
            ->whereBetween('date', [$monthStart->format('Y-m-d'), $monthEnd->format('Y-m-d')])
            ->whereNotIn('status', ['rejected', 'cancelled'])
            ->orderBy('date')
            ->orderBy('start_time')
            ->get()
            ->groupBy(fn ($b) => Carbon::parse($b->date)->format('Y-m-d'))
            ->map(function ($items) {
                return $items->map(fn ($b) => [
                    'date' => $b->date,
                    'start' => $b->formatted_start_time,
                    'end' => $b->formatted_end_time,
                    'purpose' => $b->purpose,
                    'booker_name' => $b->booker_name,
                    'status' => $b->status,
                ]);
            });

        return response()->json([
            'month' => $request->month,
            'bookings' => $monthBookings,
        ]);
    }

    public function checkAvailability(Room $room, Request $request)
    {
        $request->validate([
            'date' => 'required|date',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
        ]);

        $isAvailable = $room->isAvailableForTime(
            $request->date,
            $request->start_time,
            $request->end_time
        );

        $conflictingBookings = [];
        if (!$isAvailable) {
            $conflictingBookings = $room->bookings()
                ->whereDate('date', $request->date)
                ->whereIn('status', ['approved', 'pending'])
                ->where('start_time', '<', $request->end_time)
                ->where('end_time', '>', $request->start_time)
                ->get()
                ->map(fn ($b) => [
                    'start' => $b->formatted_start_time,
                    'end' => $b->formatted_end_time,
                    'status' => $b->status,
                    'purpose' => $b->purpose,
                ]);
        }

        return response()->json([
            'available' => $isAvailable,
            'conflicts' => $conflictingBookings,
        ]);
    }

    public function verifyProdi(Room $room, Request $request)
    {
        $request->validate([
            'prodi_id' => 'required|exists:prodis,id',
        ]);

        $prodiId = (int) $request->prodi_id;

        if (!$room->isProdiAllowed($prodiId)) {
            return response()->json([
                'success' => false,
                'message' => 'Prodi Anda tidak memiliki akses ke lab ini.',
            ], 403);
        }

        session(["room_{$room->id}_verified_prodi" => $prodiId]);

        return response()->json([
            'success' => true,
            'redirect' => route('rooms.show', $room),
        ]);
    }
}

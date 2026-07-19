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

        $rooms = Room::where('is_active', true)->get()->map(function ($room) use ($today, $now, $currentHour) {
            $allTodayBookings = $room->bookings()
                ->whereDate('date', $today)
                ->whereNotIn('status', ['rejected', 'cancelled'])
                ->orderBy('start_time')
                ->get();

            $approvedBookings = $allTodayBookings->where('status', 'approved');
            $pendingBookings = $allTodayBookings->where('status', 'pending');

            $totalSlots = 11;
            $operatingStart = 7;
            $operatingEnd = 18;

            $bookedHours = $approvedBookings->sum(function ($b) {
                $start = max((int) explode(':', $b->formatted_start_time)[0], 7);
                $end = min((int) explode(':', $b->formatted_end_time)[0], 18);
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
            ];
        });

        return view('rooms.index', compact('rooms'));
    }

    public function show(Room $room, Request $request)
    {
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
            ->groupBy('date')
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

        return view('rooms.show', compact('room', 'date', 'bookings', 'weekDates', 'timeSlots', 'carbonDate', 'prodis', 'monthBookings'));
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
                'status' => $b->status,
            ]),
        ]);
    }
}

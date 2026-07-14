<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Room;
use App\Models\User;
use Illuminate\Support\Carbon;

class AdminDashboardController extends Controller
{
    public function index()
    {
        $today = Carbon::today();
        $now = now();
        $lastMonth = $now->copy()->subMonth();

        $stats = [
            'total_rooms' => Room::count(),
            'active_rooms' => Room::where('is_active', true)->count(),
            'total_bookings' => Booking::count(),
            'pending_bookings' => Booking::where('status', 'pending')->count(),
            'approved_bookings' => Booking::where('status', 'approved')->count(),
            'rejected_bookings' => Booking::where('status', 'rejected')->count(),
            'cancelled_bookings' => Booking::where('status', 'cancelled')->count(),
            'today_bookings' => Booking::whereDate('date', $today)->whereNotIn('status', ['cancelled', 'rejected'])->count(),
            'total_users' => User::where('role', 'user')->count(),
            'total_admins' => User::where('role', 'admin')->count(),
            'total_operators' => User::where('role', 'operator')->count(),
            'this_month_bookings' => Booking::whereDate('date', '>=', $now->startOfMonth())
                ->whereDate('date', '<=', $now->endOfMonth())
                ->count(),
            'last_month_bookings' => Booking::whereDate('date', '>=', $lastMonth->startOfMonth())
                ->whereDate('date', '<=', $lastMonth->endOfMonth())
                ->count(),
            'total_hours_booked' => Booking::where('status', 'approved')
                ->select(['start_time', 'end_time'])
                ->get()
                ->sum(function ($b) {
                    $start = strtotime($b->start_time);
                    $end = strtotime($b->end_time);
                    return max(0, ($end - $start)) / 3600;
                }),
        ];

        $monthlyBookings = Booking::whereDate('date', '>=', now()->subMonths(11)->startOfMonth())
            ->get()
            ->groupBy(fn ($b) => $b->date->format('Y-m'))
            ->map(function ($group, $key) {
                return [
                    'label' => Carbon::parse($key . '-01')->format('M Y'),
                    'total' => $group->count(),
                ];
            })
            ->values()
            ->sortBy(fn ($item) => $item['label'])
            ->values();

        $statusDistribution = Booking::select('status')
            ->get()
            ->groupBy('status')
            ->map(fn ($group) => $group->count());

        $roomUtilization = Booking::whereNotIn('status', ['cancelled', 'rejected'])
            ->with('room')
            ->get()
            ->groupBy(fn ($b) => $b->room->name)
            ->map(fn ($group) => ['name' => $group->first()->room->name, 'total' => $group->count()])
            ->sortByDesc('total')
            ->take(5)
            ->values();

        $peakHours = Booking::whereNotIn('status', ['cancelled', 'rejected'])
            ->get()
            ->groupBy(fn ($b) => (int) date('H', strtotime($b->start_time)))
            ->map(fn ($group, $hour) => ['hour' => (int) $hour, 'total' => $group->count()])
            ->sortBy('hour')
            ->values();

        $recentBookings = Booking::with('room')
            ->orderByDesc('created_at')
            ->limit(10)
            ->get();

        $todayBookings = Booking::with('room')
            ->whereDate('date', $today)
            ->whereNotIn('status', ['cancelled', 'rejected'])
            ->orderBy('start_time')
            ->get();

        return view('admin.dashboard', compact(
            'stats',
            'recentBookings',
            'todayBookings',
            'monthlyBookings',
            'statusDistribution',
            'roomUtilization',
            'peakHours'
        ));
    }
}

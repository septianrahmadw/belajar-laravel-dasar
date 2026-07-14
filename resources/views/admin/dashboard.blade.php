@extends('admin.layouts.app')

@section('title', 'Dashboard')
@section('header', 'Dashboard')

@section('content')
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5 mb-8">
    <div class="bg-white rounded-xl border border-gray-100 p-5">
        <div class="flex items-center justify-between mb-3">
            <div class="w-10 h-10 bg-indigo-50 rounded-lg flex items-center justify-center">
                <svg class="w-5 h-5 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 21v-7.5a.75.75 0 01.75-.75h3a.75.75 0 01.75.75V21m-4.5 0H2.36m11.14 0H18m0 0h3.64m-1.39 0V9.349m-16.5 11.65V9.35m0 0a3.001 3.001 0 003.75-.615A2.993 2.993 0 009.75 9.75c.896 0 1.7-.393 2.25-1.016a2.993 2.993 0 002.25 1.016c.896 0 1.7-.393 2.25-1.016a3.001 3.001 0 003.75.614m-16.5 0a3.004 3.004 0 01-.621-4.72L4.318 3.44A1.5 1.5 0 015.378 3h13.243a1.5 1.5 0 011.06.44l1.19 1.189a3 3 0 01-.621 4.72m-13.5 8.65h3.75a.75.75 0 00.75-.75V13.5a.75.75 0 00-.75-.75H6.75a.75.75 0 00-.75.75v3.75c0 .415.336.75.75.75z" /></svg>
            </div>
            <span class="text-2xl font-bold text-gray-900">{{ $stats['total_rooms'] }}</span>
        </div>
        <p class="text-sm text-gray-500">Total Ruangan</p>
        <p class="text-xs text-green-600 font-medium mt-1">{{ $stats['active_rooms'] }} aktif</p>
    </div>

    <div class="bg-white rounded-xl border border-gray-100 p-5">
        <div class="flex items-center justify-between mb-3">
            <div class="w-10 h-10 bg-amber-50 rounded-lg flex items-center justify-center">
                <svg class="w-5 h-5 text-amber-600" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
            </div>
            <span class="text-2xl font-bold text-gray-900">{{ $stats['pending_bookings'] }}</span>
        </div>
        <p class="text-sm text-gray-500">Menunggu Persetujuan</p>
        <p class="text-xs text-amber-600 font-medium mt-1">Perlu ditindaklanjuti</p>
    </div>

    <div class="bg-white rounded-xl border border-gray-100 p-5">
        <div class="flex items-center justify-between mb-3">
            <div class="w-10 h-10 bg-green-50 rounded-lg flex items-center justify-center">
                <svg class="w-5 h-5 text-green-600" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
            </div>
            <span class="text-2xl font-bold text-gray-900">{{ $stats['approved_bookings'] }}</span>
        </div>
        <p class="text-sm text-gray-500">Total Disetujui</p>
        <p class="text-xs text-green-600 font-medium mt-1">{{ $stats['today_bookings'] }} hari ini</p>
    </div>

    <div class="bg-white rounded-xl border border-gray-100 p-5">
        <div class="flex items-center justify-between mb-3">
            <div class="w-10 h-10 bg-purple-50 rounded-lg flex items-center justify-center">
                <svg class="w-5 h-5 text-purple-600" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z" /></svg>
            </div>
            <span class="text-2xl font-bold text-gray-900">{{ $stats['this_month_bookings'] }}</span>
        </div>
        <p class="text-sm text-gray-500">Booking Bulan Ini</p>
        @php $change = $stats['last_month_bookings'] > 0 ? round((($stats['this_month_bookings'] - $stats['last_month_bookings']) / $stats['last_month_bookings']) * 100) : 0; @endphp
        <p class="text-xs {{ $change >= 0 ? 'text-green-600' : 'text-red-600' }} font-medium mt-1">
            {{ $change >= 0 ? '+' : '' }}{{ $change }}% dari bulan lalu
        </p>
    </div>
</div>

<div class="grid grid-cols-2 sm:grid-cols-4 gap-4 mb-8">
    <div class="bg-white rounded-xl border border-gray-100 p-4 text-center">
        <p class="text-2xl font-bold text-amber-600">{{ $stats['pending_bookings'] }}</p>
        <p class="text-xs text-gray-500 mt-1">Menunggu</p>
    </div>
    <div class="bg-white rounded-xl border border-gray-100 p-4 text-center">
        <p class="text-2xl font-bold text-green-600">{{ $stats['approved_bookings'] }}</p>
        <p class="text-xs text-gray-500 mt-1">Disetujui</p>
    </div>
    <div class="bg-white rounded-xl border border-gray-100 p-4 text-center">
        <p class="text-2xl font-bold text-red-600">{{ $stats['rejected_bookings'] }}</p>
        <p class="text-xs text-gray-500 mt-1">Ditolak</p>
    </div>
    <div class="bg-white rounded-xl border border-gray-100 p-4 text-center">
        <p class="text-2xl font-bold text-gray-600">{{ $stats['cancelled_bookings'] }}</p>
        <p class="text-xs text-gray-500 mt-1">Dibatalkan</p>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
    <div class="lg:col-span-2 bg-white rounded-xl border border-gray-100 overflow-hidden">
        <div class="p-5 border-b border-gray-100">
            <h3 class="font-bold text-gray-900">Booking 12 Bulan Terakhir</h3>
        </div>
        <div class="p-5">
            <canvas id="monthlyChart" height="100"></canvas>
        </div>
    </div>

    <div class="bg-white rounded-xl border border-gray-100 overflow-hidden">
        <div class="p-5 border-b border-gray-100">
            <h3 class="font-bold text-gray-900">Status Booking</h3>
        </div>
        <div class="p-5">
            <canvas id="statusChart" height="200"></canvas>
        </div>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
    <div class="bg-white rounded-xl border border-gray-100 overflow-hidden">
        <div class="p-5 border-b border-gray-100">
            <h3 class="font-bold text-gray-900">Top 5 Ruangan Paling Sering Dipinjam</h3>
        </div>
        <div class="p-5">
            <canvas id="roomChart" height="150"></canvas>
        </div>
    </div>

    <div class="bg-white rounded-xl border border-gray-100 overflow-hidden">
        <div class="p-5 border-b border-gray-100">
            <h3 class="font-bold text-gray-900">Jam Sibuk Peminjaman</h3>
        </div>
        <div class="p-5">
            <canvas id="peakHoursChart" height="150"></canvas>
        </div>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
    <div class="bg-white rounded-xl border border-gray-100 overflow-hidden">
        <div class="p-5 border-b border-gray-100 flex items-center justify-between">
            <h3 class="font-bold text-gray-900">Booking Hari Ini</h3>
            <a href="{{ route('admin.bookings.index', ['date' => now()->format('Y-m-d')]) }}" class="text-sm text-indigo-600 hover:text-indigo-700 font-medium">Lihat Semua</a>
        </div>
        <div class="divide-y divide-gray-50">
            @forelse ($todayBookings as $booking)
            <div class="p-4 hover:bg-gray-50 transition-colors">
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <div class="w-2 h-2 rounded-full {{ $booking->status === 'approved' ? 'bg-green-500' : 'bg-amber-500' }}"></div>
                        <div>
                            <p class="text-sm font-medium text-gray-900">{{ $booking->purpose }}</p>
                            <p class="text-xs text-gray-500">{{ $booking->booker_name }} &middot; {{ $booking->room->name }}</p>
                        </div>
                    </div>
                    <span class="text-xs text-gray-500 font-mono">{{ $booking->formatted_start_time }}-{{ $booking->formatted_end_time }}</span>
                </div>
            </div>
            @empty
            <div class="p-8 text-center">
                <p class="text-sm text-gray-400">Tidak ada booking hari ini</p>
            </div>
            @endforelse
        </div>
    </div>

    <div class="bg-white rounded-xl border border-gray-100 overflow-hidden">
        <div class="p-5 border-b border-gray-100 flex items-center justify-between">
            <h3 class="font-bold text-gray-900">Booking Terbaru</h3>
            <a href="{{ route('admin.bookings.index') }}" class="text-sm text-indigo-600 hover:text-indigo-700 font-medium">Lihat Semua</a>
        </div>
        <div class="divide-y divide-gray-50">
            @forelse ($recentBookings as $booking)
            <a href="{{ route('admin.bookings.show', $booking) }}" class="block p-4 hover:bg-gray-50 transition-colors">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-900">{{ $booking->booker_name }}</p>
                        <p class="text-xs text-gray-500">{{ $booking->purpose }} &middot; {{ $booking->room->name }}</p>
                    </div>
                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-bold uppercase
                        {{ $booking->status === 'approved' ? 'bg-green-100 text-green-700' :
                           ($booking->status === 'pending' ? 'bg-amber-100 text-amber-700' :
                           ($booking->status === 'rejected' ? 'bg-red-100 text-red-700' : 'bg-gray-100 text-gray-600')) }}">
                        {{ $booking->statusLabel }}
                    </span>
                </div>
            </a>
            @empty
            <div class="p-8 text-center">
                <p class="text-sm text-gray-400">Belum ada booking</p>
            </div>
            @endforelse
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.7/dist/chart.umd.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const monthlyData = @json($monthlyBookings);
    const statusData = @json($statusDistribution);
    const roomData = @json($roomUtilization);
    const peakData = @json($peakHours);

    new Chart(document.getElementById('monthlyChart'), {
        type: 'bar',
        data: {
            labels: monthlyData.map(d => d.label),
            datasets: [{
                label: 'Jumlah Booking',
                data: monthlyData.map(d => d.total),
                backgroundColor: 'rgba(79, 70, 229, 0.8)',
                borderRadius: 6,
                barThickness: 24,
            }]
        },
        options: {
            responsive: true,
            plugins: { legend: { display: false } },
            scales: {
                y: { beginAtZero: true, ticks: { stepSize: 1 }, grid: { color: '#f3f4f6' } },
                x: { grid: { display: false }, ticks: { font: { size: 10 } } }
            }
        }
    });

    const statusColors = { pending: '#f59e0b', approved: '#10b981', rejected: '#ef4444', cancelled: '#6b7280' };
    const statusLabels = { pending: 'Menunggu', approved: 'Disetujui', rejected: 'Ditolak', cancelled: 'Dibatalkan' };

    new Chart(document.getElementById('statusChart'), {
        type: 'doughnut',
        data: {
            labels: Object.keys(statusData).map(k => statusLabels[k] || k),
            datasets: [{
                data: Object.values(statusData),
                backgroundColor: Object.keys(statusData).map(k => statusColors[k] || '#9ca3af'),
                borderWidth: 0,
            }]
        },
        options: {
            responsive: true,
            cutout: '60%',
            plugins: { legend: { position: 'bottom', labels: { boxWidth: 12, padding: 12, font: { size: 11 } } } }
        }
    });

    new Chart(document.getElementById('roomChart'), {
        type: 'bar',
        data: {
            labels: roomData.map(d => d.name),
            datasets: [{
                label: 'Kali Dipinjam',
                data: roomData.map(d => d.total),
                backgroundColor: ['#4f46e5', '#7c3aed', '#2563eb', '#0891b2', '#059669'],
                borderRadius: 6,
                barThickness: 20,
            }]
        },
        options: {
            indexAxis: 'y',
            responsive: true,
            plugins: { legend: { display: false } },
            scales: {
                x: { beginAtZero: true, ticks: { stepSize: 1 }, grid: { color: '#f3f4f6' } },
                y: { grid: { display: false } }
            }
        }
    });

    const hours = Array.from({length: 24}, (_, i) => i);
    const peakMap = {};
    peakData.forEach(d => { peakMap[d.hour] = d.total; });

    new Chart(document.getElementById('peakHoursChart'), {
        type: 'line',
        data: {
            labels: hours.map(h => h.toString().padStart(2, '0') + ':00'),
            datasets: [{
                label: 'Booking',
                data: hours.map(h => peakMap[h] || 0),
                borderColor: '#4f46e5',
                backgroundColor: 'rgba(79, 70, 229, 0.1)',
                fill: true,
                tension: 0.4,
                pointRadius: 3,
                pointBackgroundColor: '#4f46e5',
            }]
        },
        options: {
            responsive: true,
            plugins: { legend: { display: false } },
            scales: {
                y: { beginAtZero: true, ticks: { stepSize: 1 }, grid: { color: '#f3f4f6' } },
                x: { grid: { display: false }, ticks: { font: { size: 9 }, maxRotation: 45 } }
            }
        }
    });
});
</script>
@endpush

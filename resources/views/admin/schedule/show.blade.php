@extends('admin.layouts.app')

@section('title', 'Jadwal ' . $schedule['room']->name)
@section('header', 'Jadwal Ruangan')

@section('actions')
<div class="flex items-center gap-2">
    <a href="{{ route('admin.schedule') }}" class="p-1.5 rounded-lg border border-gray-200 text-gray-500 hover:text-blue-600 hover:border-blue-300 hover:bg-blue-50 transition-colors" title="Kembali ke daftar ruangan">
        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L4.5 12l6-7.5" /></svg>
    </a>
    <span class="text-sm font-semibold text-gray-700">{{ $schedule['room']->name }}</span>
    <div class="flex items-center gap-1.5 text-xs font-semibold ml-auto">
        <span class="inline-flex items-center gap-1 text-green-700"><span class="w-2 h-2 rounded-full bg-green-500"></span>Disetujui</span>
        <span class="inline-flex items-center gap-1 text-amber-700"><span class="w-2 h-2 rounded-full bg-amber-500"></span>Menunggu</span>
    </div>
</div>
@endsection

@section('content')
<div class="bg-white rounded-xl border border-gray-100 overflow-hidden mb-6">
    <div class="p-4 flex flex-col sm:flex-row items-center justify-between gap-3">
        <div class="flex items-center gap-2">
            <a href="{{ route('admin.schedule.room', [$schedule['room'], 'date' => $prevWeek]) }}" class="p-2 rounded-lg border border-gray-200 text-gray-500 hover:text-blue-600 hover:border-blue-300 hover:bg-blue-50 transition-colors" title="Minggu sebelumnya">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5L8.25 12l7.5-7.5" /></svg>
            </a>
            <div class="text-center min-w-[180px]">
                <p class="text-sm font-bold text-gray-900">{{ $carbonDate->locale('id')->isoFormat('MMMM YYYY') }}</p>
                <p class="text-xs text-gray-500">
                    {{ $weekDates[0]['date'] }} s/d {{ $weekDates[4]['date'] }}
                </p>
            </div>
            <a href="{{ route('admin.schedule.room', [$schedule['room'], 'date' => $nextWeek]) }}" class="p-2 rounded-lg border border-gray-200 text-gray-500 hover:text-blue-600 hover:border-blue-300 hover:bg-blue-50 transition-colors" title="Minggu berikutnya">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5" /></svg>
            </a>
            <a href="{{ route('admin.schedule.room', $schedule['room']) }}" class="ml-1 px-3 py-1.5 rounded-lg text-xs font-semibold text-gray-600 border border-gray-200 hover:bg-gray-50 transition-colors">Minggu Ini</a>
        </div>

        <form action="{{ route('admin.schedule.room', $schedule['room']) }}" method="GET" class="flex items-center gap-2">
            <input type="date" name="date" value="{{ $carbonDate->format('Y-m-d') }}"
                   class="rounded-lg border-gray-200 border px-3 py-2 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none">
            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-lg text-sm font-semibold hover:bg-blue-700 transition-colors">Tampilkan</button>
        </form>
    </div>
</div>

<div class="bg-white rounded-xl border border-gray-100 overflow-hidden">
    <div class="px-5 py-3 border-b border-gray-100 flex items-center justify-between">
        <div>
            <h4 class="font-semibold text-gray-900">{{ $schedule['room']->name }}</h4>
            <p class="text-xs text-gray-500">{{ $schedule['room']->code }} @if ($schedule['room']->location) &middot; {{ $schedule['room']->location }} @endif</p>
        </div>
        <span class="text-xs text-gray-500">{{ $schedule['room']->capacity ? $schedule['room']->capacity . ' kapasitas' : '' }}</span>
    </div>

    @php
        $pxPerHour = 56;
        $startHour = 7;
        $endHour = 21;
        $dayHeight = ($endHour - $startHour) * $pxPerHour;
    @endphp
    <div class="overflow-x-auto">
        <div class="flex" style="min-width: 900px;">
            <div class="sticky left-0 z-20 w-[72px] shrink-0 bg-white border-r border-gray-100">
                <div class="h-14"></div>
                <div class="relative" style="height: {{ $dayHeight }}px;">
                    @for ($h = $startHour; $h <= $endHour; $h++)
                    <div class="absolute right-2 -translate-y-1/2 font-mono text-xs text-gray-500" style="top: {{ ($h - $startHour) * $pxPerHour }}px;">
                        {{ sprintf('%02d:00', $h) }}
                    </div>
                    @endfor
                </div>
            </div>

            @foreach ($weekDates as $day)
            <div class="flex-1 min-w-[140px]">
                <div class="h-14 border-b border-gray-100 {{ $day['isToday'] ? 'bg-blue-50/40' : 'bg-gray-50/50' }} flex flex-col items-center justify-center">
                    <span class="text-xs uppercase tracking-wide {{ $day['isToday'] ? 'text-blue-600' : 'text-gray-500' }}">{{ $day['label'] }}</span>
                    <span class="text-lg font-bold leading-none {{ $day['isToday'] ? 'text-blue-600' : 'text-gray-900' }}">{{ $day['dayNum'] }}</span>
                    <span class="text-[11px] font-medium {{ $day['isToday'] ? 'text-blue-500' : 'text-gray-400' }}">{{ $day['month'] }}</span>
                </div>

                @php
                    $dayBookings = $schedule['days'][$day['date']] ?? collect();
                    $positioned = [];
                    $laneEnds = [];
                    foreach ($dayBookings as $b) {
                        $startMin = ((int) substr($b->start_time, 0, 2)) * 60 + (int) substr($b->start_time, 3, 2);
                        $endMin = ((int) substr($b->end_time, 0, 2)) * 60 + (int) substr($b->end_time, 3, 2);
                        if ($endMin <= $startMin) {
                            $endMin = $startMin + 60;
                        }
                        $lane = 0;
                        while (isset($laneEnds[$lane]) && $laneEnds[$lane] > $startMin) {
                            $lane++;
                        }
                        $laneEnds[$lane] = $endMin;
                        $positioned[] = [
                            'booking' => $b,
                            'top' => ($startMin - $startHour * 60) * $pxPerHour / 60,
                            'height' => ($endMin - $startMin) * $pxPerHour / 60,
                            'lane' => $lane,
                        ];
                    }
                    $maxLanes = count($laneEnds) ?: 1;
                    $laneWidth = 100 / $maxLanes;
                @endphp

                <div class="relative {{ $day['isToday'] ? 'bg-blue-50/30' : '' }}" style="height: {{ $dayHeight }}px;">
                    @for ($h = $startHour; $h <= $endHour; $h++)
                    <div class="absolute inset-x-0 border-t {{ $h === $startHour ? 'border-gray-200' : 'border-gray-100' }}" style="top: {{ ($h - $startHour) * $pxPerHour }}px;"></div>
                    @endfor
                    @for ($h = $startHour; $h < $endHour; $h++)
                    <div class="absolute inset-x-0 border-t border-dashed border-gray-100/60" style="top: {{ ($h - $startHour) * $pxPerHour + 28 }}px;"></div>
                    @endfor

                    @foreach ($positioned as $p)
                    @php $booking = $p['booking']; @endphp
                    <div class="absolute px-0.5" style="top: {{ $p['top'] }}px; height: {{ $p['height'] }}px; left: {{ $p['lane'] * $laneWidth }}%; width: {{ $laneWidth }}%;">
                        <a href="{{ route('admin.bookings.show', $booking) }}"
                           class="block h-full rounded-lg border px-1.5 py-1 overflow-hidden transition-colors
                               {{ $booking->status === 'approved'
                                   ? 'bg-green-50 border-green-200 hover:bg-green-100'
                                   : 'bg-amber-50 border-amber-200 hover:bg-amber-100' }}">
                            <div class="flex items-center justify-between gap-1">
                                <span class="font-mono text-[11px] font-semibold {{ $booking->status === 'approved' ? 'text-green-700' : 'text-amber-700' }}">{{ $booking->formatted_start_time }}-{{ $booking->formatted_end_time }}</span>
                                <span class="w-1.5 h-1.5 rounded-full shrink-0 {{ $booking->status === 'approved' ? 'bg-green-500' : 'bg-amber-500' }}"></span>
                            </div>
                            <p class="text-xs font-medium text-gray-800 truncate leading-tight">{{ $booking->purpose }}</p>
                            <div class="flex items-center justify-between gap-1">
                                <p class="text-[11px] text-gray-500 truncate">@if($booking->prodi){{ $booking->prodi->name }}@else-@endif</p>
                                <p class="text-[11px] text-gray-500 shrink-0">Kelas {{ $booking->kelas ?? '-' }}</p>
                            </div>
                            @if ($p['height'] >= 112)
                            <p class="text-[11px] text-gray-500 truncate">{{ $booking->mata_kuliah ?? '-' }}</p>
                            @endif
                        </a>
                    </div>
                    @endforeach
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>
@endsection

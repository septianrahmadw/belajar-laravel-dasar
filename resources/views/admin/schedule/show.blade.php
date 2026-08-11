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

    <div class="overflow-x-auto">
        <table class="w-full text-sm" style="min-width: 1000px;">
            <thead>
                <tr class="bg-gray-50 border-b border-gray-100">
                    <th class="text-left px-5 py-3 font-semibold text-gray-600 min-w-[100px]">Jam</th>
                    @foreach ($weekDates as $day)
                    <th class="text-center px-3 py-3 font-semibold text-gray-600 min-w-[130px]">
                        <span class="text-xs uppercase tracking-wide {{ $day['isToday'] ? 'text-blue-600' : 'text-gray-500' }}">{{ $day['label'] }}</span>
                        <span class="block text-lg font-bold {{ $day['isToday'] ? 'text-blue-600' : 'text-gray-900' }}">{{ $day['dayNum'] }}</span>
                        <span class="block text-[11px] font-medium {{ $day['isToday'] ? 'text-blue-500' : 'text-gray-400' }}">{{ $day['month'] }}</span>
                    </th>
                    @endforeach
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
                @php $timeSlots = ['07:00','08:00','09:00','10:00','11:00','12:00','13:00','14:00','15:00','16:00','17:00','18:00','19:00','20:00','21:00']; @endphp
                @foreach ($timeSlots as $slot)
                <tr class="hover:bg-gray-50/50 transition-colors">
                    <td class="px-5 py-2 sticky left-0 bg-white font-mono text-xs text-gray-500 border-r border-gray-100">{{ $slot }}</td>
                    @foreach ($weekDates as $day)
                    <td class="px-2 py-3 align-top {{ $day['isToday'] ? 'bg-blue-50/40' : '' }}">
                        @php $dayBookings = $schedule['days'][$day['date']] ?? collect(); @endphp
                        @php
                            $slotNum = ((int) explode(':', $slot)[0]) * 2 + ((int) explode(':', $slot)[1]) / 60 * 2;
                            $matching = $dayBookings->filter(function ($b) use ($slotNum) {
                                $startNum = ((int) explode(':', $b->start_time)[0]) * 2 + ((int) explode(':', $b->start_time)[1]) / 60 * 2;
                                $endNum = ((int) explode(':', $b->end_time)[0]) * 2 + ((int) explode(':', $b->end_time)[1]) / 60 * 2;
                                return $startNum === $slotNum;
                            });
                        @endphp
                        @foreach ($matching as $booking)
                        <a href="{{ route('admin.bookings.show', $booking) }}"
                           class="block rounded-lg px-2 py-1.5 border transition-colors
                               {{ $booking->status === 'approved'
                                   ? 'bg-green-50 border-green-200 hover:bg-green-100'
                                   : 'bg-amber-50 border-amber-200 hover:bg-amber-100' }}">
                            <div class="flex items-center justify-between gap-1">
                                <span class="font-mono text-[11px] font-semibold {{ $booking->status === 'approved' ? 'text-green-700' : 'text-amber-700' }}">{{ $booking->formatted_start_time }}-{{ $booking->formatted_end_time }}</span>
                                <span class="w-1.5 h-1.5 rounded-full shrink-0 {{ $booking->status === 'approved' ? 'bg-green-500' : 'bg-amber-500' }}"></span>
                            </div>
                            <p class="text-xs font-medium text-gray-800 truncate">{{ $booking->purpose }}</p>
                            <p class="text-[11px] text-gray-500 truncate">Kelas {{ $booking->kelas ?? '-' }} @if($booking->prodi) &middot; {{ $booking->prodi->name }} @else &middot; - @endif</p>
                            <p class="text-[11px] text-gray-500 truncate">{{ $booking->mata_kuliah ?? '-' }}</p>
                        </a>
                        @endforeach
                    </td>
                    @endforeach
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection

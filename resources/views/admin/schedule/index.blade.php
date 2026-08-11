@extends('admin.layouts.app')

@section('title', 'Jadwal Ruangan')
@section('header', 'Jadwal Ruangan')

@section('actions')
<div class="flex items-center gap-2">
    <div class="flex items-center gap-1.5 text-xs font-semibold">
        <span class="inline-flex items-center gap-1 text-green-700"><span class="w-2 h-2 rounded-full bg-green-500"></span>Disetujui</span>
        <span class="inline-flex items-center gap-1 text-amber-700"><span class="w-2 h-2 rounded-full bg-amber-500"></span>Menunggu</span>
    </div>
</div>
@endsection

@section('content')
@if ($rooms->isEmpty())
<div class="bg-white rounded-xl border border-gray-100 overflow-hidden">
    <div class="px-5 py-12 text-center">
        <p class="text-gray-400">Belum ada ruangan aktif.</p>
    </div>
</div>
@else
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-5">
    @foreach ($rooms as $room)
    <a href="{{ route('admin.schedule.room', $room) }}"
       class="group block bg-white rounded-xl border border-gray-200 overflow-hidden shadow-sm hover:shadow-md hover:border-blue-300 transition-all text-left">
        <div class="p-4">
            <div class="flex items-start justify-between gap-2">
                <div class="min-w-0 flex-1">
                    <h3 class="font-semibold text-gray-900 group-hover:text-blue-700 transition-colors truncate">{{ $room->name }}</h3>
                    @if ($room->code)
                    <p class="text-xs text-gray-500 mt-0.5 truncate">{{ $room->code }}</p>
                    @endif
                    @if ($room->location)
                    <p class="text-xs text-gray-500 mt-0.5 truncate">{{ $room->location }}</p>
                    @endif
                </div>
                <span class="inline-flex shrink-0 items-center justify-center w-9 h-9 rounded-lg bg-gray-50 text-gray-600 group-hover:bg-blue-50 group-hover:text-blue-600 transition-colors">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" /></svg>
                </span>
            </div>

            @if ($room->capacity)
            <p class="text-xs text-gray-500 mt-2">Kapasitas: {{ $room->capacity }} orang</p>
            @endif
            @if ($room->facilities && count($room->facilities))
            <p class="text-xs text-gray-500 mt-1 truncate">{{ collect($room->facilities)->join(', ') }}</p>
            @endif

            <div class="mt-3 flex items-center justify-between">
                <span class="text-xs px-2 py-1 rounded-full bg-gray-100 text-gray-600">
                    {{ $room->booking_count }} booking
                </span>
                <span class="text-xs font-medium text-blue-600 group-hover:translate-x-0.5 transition-transform">
                    Lihat Jadwal
                </span>
            </div>
        </div>
    </a>
    @endforeach
</div>
@endif
@endsection

@extends('admin.layouts.app')

@php
    $statusMeta = [
        'pending' => ['label' => 'Menunggu', 'badge' => 'bg-amber-100 text-amber-700', 'bar' => 'bg-amber-500', 'dot' => 'bg-amber-500', 'text' => 'text-amber-600'],
        'approved' => ['label' => 'Disetujui', 'badge' => 'bg-green-100 text-green-700', 'bar' => 'bg-green-500', 'dot' => 'bg-green-500', 'text' => 'text-green-600'],
        'rejected' => ['label' => 'Ditolak', 'badge' => 'bg-red-100 text-red-700', 'bar' => 'bg-red-500', 'dot' => 'bg-red-500', 'text' => 'text-red-600'],
        'cancelled' => ['label' => 'Dibatalkan', 'badge' => 'bg-gray-100 text-gray-600', 'bar' => 'bg-gray-400', 'dot' => 'bg-gray-400', 'text' => 'text-gray-500'],
    ];
@endphp

@section('title', 'Manajemen Booking')
@section('header', 'Booking')

@section('actions')
<div class="flex items-center gap-2">
    <a href="{{ route('admin.bookings.export.pdf', request()->only(['search', 'date', 'status'])) }}" class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-sm font-semibold text-white bg-red-600 hover:bg-red-700 transition-colors">
        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m.75 12l3 3m0 0l3-3m-3 3v-6m-1.5-9H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" /></svg>
        PDF
    </a>
    <a href="{{ route('admin.bookings.export.csv', request()->only(['search', 'date', 'status'])) }}" class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-sm font-semibold text-white bg-green-600 hover:bg-green-700 transition-colors">
        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5M16.5 12L12 16.5m0 0L7.5 12m4.5 4.5V3" /></svg>
        CSV
    </a>
</div>
@endsection

@section('content')
@php
    $hasFilter = request()->hasAny(['search', 'date', 'status']);
@endphp

<div class="bg-white rounded-xl border border-gray-100 overflow-hidden mb-6">
    <div class="p-4">
        <form action="{{ route('admin.bookings.index') }}" method="GET" class="flex flex-col sm:flex-row gap-3">
            <div class="flex-1 relative">
                <svg class="w-4 h-4 text-gray-400 absolute left-3.5 top-1/2 -translate-y-1/2" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" /></svg>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama, email, jurusan, mata kuliah, dosen..."
                       class="w-full rounded-lg border-gray-200 border pl-10 pr-4 py-2 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none">
            </div>
            <input type="date" name="date" value="{{ request('date') }}"
                   class="rounded-lg border-gray-200 border px-3 py-2 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none">
            <select name="status" class="rounded-lg border-gray-200 border px-3 py-2 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none bg-white">
                <option value="">Semua Status</option>
                <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>Menunggu</option>
                <option value="approved" {{ request('status') === 'approved' ? 'selected' : '' }}>Disetujui</option>
                <option value="rejected" {{ request('status') === 'rejected' ? 'selected' : '' }}>Ditolak</option>
                <option value="cancelled" {{ request('status') === 'cancelled' ? 'selected' : '' }}>Dibatalkan</option>
            </select>
            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-lg text-sm font-semibold hover:bg-blue-700 transition-colors">Filter</button>
            @if ($hasFilter)
                <a href="{{ route('admin.bookings.index') }}" class="text-gray-500 hover:text-gray-700 text-sm font-medium px-3 py-2">Reset</a>
            @endif
        </form>
    </div>
</div>

@if ($recent->isNotEmpty())
<div class="mb-8">
    <div class="flex items-center justify-between mb-3">
        <h2 class="text-sm font-bold uppercase tracking-wider text-gray-700 flex items-center gap-2">
            <svg class="w-4 h-4 text-blue-600" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M8.25 6.75h12M8.25 12h12m-12 5.25h12M3.75 6.75h.007v.008H3.75V6.75zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0zM3.75 12h.007v.008H3.75V12zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0zm-.375 5.25h.007v.008H3.75v-.008zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z" /></svg>
            Antrian Booking Terbaru
        </h2>
        <span class="text-xs text-gray-500">Urut berdasarkan waktu pengajuan</span>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4">
        @foreach ($recent as $item)
        @php
            $b = $item['booking'];
            $meta = $statusMeta[$b->status] ?? $statusMeta['cancelled'];
            $group = $item['group'];
        @endphp
        <a href="{{ route('admin.bookings.show', $b) }}" class="group w-full flex flex-col bg-white rounded-xl border border-gray-200 overflow-hidden shadow-sm hover:shadow-md hover:border-blue-300 transition-all">
            <div class="h-1 {{ $meta['bar'] }}"></div>
            <div class="p-4 flex flex-col flex-1">
                <div class="flex items-start justify-between gap-2">
                    <div class="w-9 h-9 rounded-full {{ $meta['bar'] }} flex items-center justify-center text-white text-sm font-bold shrink-0">
                        {{ substr($b->booker_name, 0, 1) }}
                    </div>
                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-bold uppercase tracking-wide {{ $meta['badge'] }}">{{ $meta['label'] }}</span>
                </div>
                <p class="mt-3 text-sm font-semibold text-gray-900 line-clamp-1">{{ $b->purpose }}</p>
                <p class="text-xs text-gray-500 truncate">{{ $b->booker_name }}</p>
                <p class="text-xs text-gray-400 truncate mt-1">{{ $b->mata_kuliah ?? '-' }}</p>

                <div class="mt-3 flex flex-wrap items-center gap-1.5">
                    <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-md bg-gray-50 border border-gray-100 text-[11px] font-medium text-gray-600">
                        <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 21v-7.5a.75.75 0 01.75-.75h3a.75.75 0 01.75.75V21m-4.5 0H2.36m11.14 0H18m0 0h3.64m-1.39 0V9.349m-16.5 11.65V9.35m0 0a3.001 3.001 0 003.75-.615A2.993 2.993 0 009.75 9.75c.896 0 1.7-.393 2.25-1.016a2.993 2.993 0 002.25 1.016c.896 0 1.7-.393 2.25-1.016a3.001 3.001 0 003.75.614m-16.5 0a3.004 3.004 0 01-.621-4.72L4.318 3.44A1.5 1.5 0 015.378 3h13.243a1.5 1.5 0 011.06.44l1.19 1.189a3 3 0 01-.621 4.72m-13.5 8.65h3.75a.75.75 0 00.75-.75V13.5a.75.75 0 00-.75-.75H6.75a.75.75 0 00-.75.75v3.75c0 .415.336.75.75.75z" /></svg>
                        {{ $b->room->name }}
                    </span>
                    @if ($group)
                    <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-md bg-blue-50 border border-blue-100 text-[11px] font-medium text-blue-700">
                        <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 12c0-1.232-.046-2.453-.138-3.662a4.006 4.006 0 00-3.7-3.7 48.678 48.678 0 00-7.324 0 4.006 4.006 0 00-3.7 3.7c-.017.22-.032.441-.046.662M19.5 12l3-3m-3 3l-3-3m-12 3c0 1.232.046 2.453.138 3.662a4.006 4.006 0 003.7 3.7 48.656 48.656 0 007.324 0 4.006 4.006 0 003.7-3.7c.017-.22.032-.441.046-.662M4.5 12l3 3m-3-3l-3 3" /></svg>
                        {{ $group['total'] }}x
                    </span>
                    @endif
                </div>

                <div class="mt-auto pt-3 flex items-center justify-between gap-2">
                    <span class="text-[11px] text-gray-500 font-mono">
                        @if ($group)
                            {{ $group['start_date']->format('d M') }} – {{ $group['end_date']->format('d M') }}
                        @else
                            {{ $b->date->format('d M') }} &middot; {{ $b->formatted_start_time }}-{{ $b->formatted_end_time }}
                        @endif
                    </span>
                    <span class="text-[11px] text-gray-400 shrink-0">{{ $b->created_at->diffForHumans() }}</span>
                </div>
            </div>
        </a>
        @endforeach
    </div>
</div>
@endif

<div class="flex items-center justify-between mb-3">
    <h2 class="text-sm font-bold uppercase tracking-wider text-gray-700 flex items-center gap-2">
        <svg class="w-4 h-4 text-blue-600" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" /></svg>
        Daftar Booking
    </h2>
    <span class="text-xs text-gray-500">{{ $bookings->total() }} entri</span>
</div>

@if ($bookings->isEmpty())
<div class="bg-white rounded-xl border border-gray-100 overflow-hidden">
    <div class="px-5 py-12 text-center">
        <p class="text-gray-400">Tidak ada data booking ditemukan.</p>
    </div>
</div>
@else
<div class="space-y-4">
    @foreach ($bookings as $booking)
    @php
        $meta = $statusMeta[$booking->status] ?? $statusMeta['cancelled'];
        $group = $booking->recurrence_id ? ($recurrenceGroups->get((string) $booking->recurrence_id) ?? null) : null;
    @endphp

    @if ($group)
    <div class="bg-white rounded-xl border border-gray-200 overflow-hidden shadow-sm">
        <div class="flex">
            <div class="w-1.5 {{ $meta['bar'] }}"></div>
            <div class="flex-1 p-5">
                <div class="flex flex-col lg:flex-row lg:items-start lg:justify-between gap-4">
                    <div class="min-w-0">
                        <div class="flex flex-wrap items-center gap-2">
                            <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-[10px] font-bold bg-blue-100 text-blue-700">
                                <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 12c0-1.232-.046-2.453-.138-3.662a4.006 4.006 0 00-3.7-3.7 48.678 48.678 0 00-7.324 0 4.006 4.006 0 00-3.7 3.7c-.017.22-.032.441-.046.662M19.5 12l3-3m-3 3l-3-3m-12 3c0 1.232.046 2.453.138 3.662a4.006 4.006 0 003.7 3.7 48.656 48.656 0 007.324 0 4.006 4.006 0 003.7-3.7c.017-.22.032-.441.046-.662M4.5 12l3 3m-3-3l-3 3" /></svg>
                                Berulang {{ $group['total'] }}x
                            </span>
                            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-bold uppercase tracking-wide {{ $meta['badge'] }}">{{ $meta['label'] }}</span>
                        </div>
                        <h3 class="mt-2 text-base font-bold text-gray-900">{{ $booking->purpose }}</h3>
                        <div class="mt-1.5 flex flex-wrap items-center gap-x-4 gap-y-1 text-sm text-gray-600">
                            <span class="font-medium text-gray-800">{{ $booking->booker_name }}</span>
                            <span class="text-gray-400">{{ $booking->booker_email }}</span>
                            <span class="inline-flex items-center gap-1 text-xs px-2 py-0.5 rounded-md bg-gray-50 border border-gray-100">
                                <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 21v-7.5a.75.75 0 01.75-.75h3a.75.75 0 01.75.75V21m-4.5 0H2.36m11.14 0H18m0 0h3.64m-1.39 0V9.349m-16.5 11.65V9.35m0 0a3.001 3.001 0 003.75-.615A2.993 2.993 0 009.75 9.75c.896 0 1.7-.393 2.25-1.016a2.993 2.993 0 002.25 1.016c.896 0 1.7-.393 2.25-1.016a3.001 3.001 0 003.75.614m-16.5 0a3.004 3.004 0 01-.621-4.72L4.318 3.44A1.5 1.5 0 015.378 3h13.243a1.5 1.5 0 011.06.44l1.19 1.189a3 3 0 01-.621 4.72m-13.5 8.65h3.75a.75.75 0 00.75-.75V13.5a.75.75 0 00-.75-.75H6.75a.75.75 0 00-.75.75v3.75c0 .415.336.75.75.75z" /></svg>
                                {{ $booking->room->name }}
                            </span>
                            <span class="inline-flex items-center gap-1 text-xs px-2 py-0.5 rounded-md bg-gray-50 border border-gray-100 font-mono">
                                <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5" /></svg>
                                {{ $booking->formatted_start_time }} - {{ $booking->formatted_end_time }}
                            </span>
                            <span class="inline-flex items-center gap-1 text-xs px-2 py-0.5 rounded-md bg-gray-50 border border-gray-100">
                                <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5" /></svg>
                                {{ $group['start_date']->format('d M Y') }} – {{ $group['end_date']->format('d M Y') }}
                            </span>
                        </div>
                        <div class="mt-3 flex flex-wrap gap-1.5">
                            @foreach ($group['statuses'] as $status => $count)
                            <span class="inline-flex items-center gap-1.5 text-[11px] font-semibold px-2 py-0.5 rounded-full {{ ($statusMeta[$status]['badge'] ?? $statusMeta['cancelled']['badge']) }}">
                                <span class="w-1.5 h-1.5 rounded-full {{ ($statusMeta[$status]['dot'] ?? $statusMeta['cancelled']['dot']) }}"></span>
                                {{ $count }} {{ $statusMeta[$status]['label'] ?? $status }}
                            </span>
                            @endforeach
                        </div>
                    </div>

                    <div class="flex items-center gap-1.5 shrink-0 flex-wrap">
                        <button type="button" data-expand-target="group-{{ $booking->id }}" class="inline-flex items-center gap-1.5 px-3 py-2 rounded-lg text-sm font-semibold text-gray-600 border border-gray-200 hover:bg-gray-50 transition-colors">
                            <svg class="w-4 h-4 group-chevron transition-transform" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5" /></svg>
                            Jadwal
                        </button>
                        @if ($booking->status === 'pending' || $group['statuses']->has('pending'))
                        <form action="{{ route('admin.bookings.approve', $booking) }}" method="POST" onsubmit="return confirm('Yakin ingin menyetujui SEMUA jadwal berulang ini? ({{ $group['total'] }} jadwal)')">
                            @csrf
                            <button type="submit" class="inline-flex items-center gap-1.5 px-3 py-2 rounded-lg text-sm font-semibold text-white bg-green-600 hover:bg-green-700 transition-colors">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                                Setujui Semua
                            </button>
                        </form>
                        @endif
                        @if ($group['statuses']->has('pending'))
                        <button type="button" data-reject-url="{{ route('admin.bookings.reject', $booking) }}" data-recurring-count="{{ $group['total'] }}" class="inline-flex items-center gap-1.5 px-3 py-2 rounded-lg text-sm font-semibold text-red-600 bg-white border border-red-200 hover:bg-red-50 transition-colors">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" /></svg>
                            Tolak Semua
                        </button>
                        @endif
                        @if ($group['statuses']->has('pending') || $group['statuses']->has('approved'))
                        <form action="{{ route('admin.bookings.cancel-recurrence', $booking) }}" method="POST" onsubmit="return confirm('Yakin ingin membatalkan SEMUA jadwal berulang ini?')">
                            @csrf
                            <button type="submit" class="inline-flex items-center gap-1.5 px-3 py-2 rounded-lg text-sm font-semibold text-orange-600 bg-white border border-orange-200 hover:bg-orange-50 transition-colors" title="Batalkan Semua">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M9.75 9.75l4.5 4.5m0-4.5l-4.5 4.5M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                                Batalkan
                            </button>
                        </form>
                        @endif
                        <a href="{{ route('admin.bookings.show', $booking) }}" class="inline-flex items-center gap-1.5 px-3 py-2 rounded-lg text-sm font-semibold text-blue-600 bg-blue-50 hover:bg-blue-100 transition-colors">
                            Detail
                        </a>
                    </div>
                </div>

                <div id="group-{{ $booking->id }}" class="hidden mt-4 border-t border-gray-100 pt-4">
                    <div class="bg-gray-50 rounded-lg overflow-hidden">
                        <div class="divide-y divide-gray-100">
                            @foreach ($group['occurrences'] as $occ)
                            @php $occMeta = $statusMeta[$occ->status] ?? $statusMeta['cancelled']; @endphp
                            <a href="{{ route('admin.bookings.show', $occ) }}" class="flex items-center justify-between gap-3 px-4 py-2.5 hover:bg-gray-100 transition-colors {{ $occ->status === 'cancelled' ? 'opacity-60' : '' }}">
                                <div class="flex items-center gap-3 min-w-0">
                                    <span class="w-2 h-2 rounded-full shrink-0 {{ $occMeta['dot'] }}"></span>
                                    <span class="text-sm font-semibold text-gray-800 whitespace-nowrap">{{ $occ->date->format('l') }}</span>
                                    <span class="text-sm text-gray-600">{{ $occ->date->format('d M Y') }}</span>
                                    <span class="text-xs font-mono text-gray-500 whitespace-nowrap">{{ $occ->formatted_start_time }}-{{ $occ->formatted_end_time }}</span>
                                </div>
                                <div class="flex items-center gap-2 shrink-0">
                                    <span class="text-xs text-gray-500 hidden sm:inline">{{ $occ->kelas ? 'Kelas ' . $occ->kelas : '' }}</span>
                                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-bold uppercase tracking-wide {{ $occMeta['badge'] }}">{{ $occMeta['label'] }}</span>
                                </div>
                            </a>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @else
    <div class="bg-white rounded-xl border border-gray-200 overflow-hidden shadow-sm">
        <div class="flex">
            <div class="w-1.5 {{ $meta['bar'] }}"></div>
            <div class="flex-1 p-5">
                <div class="flex flex-col lg:flex-row lg:items-start lg:justify-between gap-4">
                    <div class="min-w-0">
                        <div class="flex flex-wrap items-center gap-2">
                            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-bold uppercase tracking-wide {{ $meta['badge'] }}">{{ $meta['label'] }}</span>
                        </div>
                        <h3 class="mt-2 text-base font-bold text-gray-900">{{ $booking->purpose }}</h3>
                        <div class="mt-1.5 flex flex-wrap items-center gap-x-4 gap-y-1 text-sm text-gray-600">
                            <span class="font-medium text-gray-800">{{ $booking->booker_name }}</span>
                            <span class="text-gray-400">{{ $booking->booker_email }}</span>
                            <span class="inline-flex items-center gap-1 text-xs px-2 py-0.5 rounded-md bg-gray-50 border border-gray-100">
                                <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 21v-7.5a.75.75 0 01.75-.75h3a.75.75 0 01.75.75V21m-4.5 0H2.36m11.14 0H18m0 0h3.64m-1.39 0V9.349m-16.5 11.65V9.35m0 0a3.001 3.001 0 003.75-.615A2.993 2.993 0 009.75 9.75c.896 0 1.7-.393 2.25-1.016a2.993 2.993 0 002.25 1.016c.896 0 1.7-.393 2.25-1.016a3.001 3.001 0 003.75.614m-16.5 0a3.004 3.004 0 01-.621-4.72L4.318 3.44A1.5 1.5 0 015.378 3h13.243a1.5 1.5 0 011.06.44l1.19 1.189a3 3 0 01-.621 4.72m-13.5 8.65h3.75a.75.75 0 00.75-.75V13.5a.75.75 0 00-.75-.75H6.75a.75.75 0 00-.75.75v3.75c0 .415.336.75.75.75z" /></svg>
                                {{ $booking->room->name }}
                            </span>
                            <span class="inline-flex items-center gap-1 text-xs px-2 py-0.5 rounded-md bg-gray-50 border border-gray-100">
                                <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5" /></svg>
                                {{ $booking->date->format('d M Y') }}
                            </span>
                            <span class="inline-flex items-center gap-1 text-xs px-2 py-0.5 rounded-md bg-gray-50 border border-gray-100 font-mono">
                                <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                                {{ $booking->formatted_start_time }} - {{ $booking->formatted_end_time }}
                            </span>
                            <span class="inline-flex items-center gap-1 text-xs px-2 py-0.5 rounded-md bg-gray-50 border border-gray-100">
                                <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25" /></svg>
                                {{ $booking->mata_kuliah ?? '-' }}
                            </span>
                        </div>
                    </div>

                    <div class="flex items-center gap-1.5 shrink-0 flex-wrap">
                        @if (in_array($booking->status, ['approved', 'pending']))
                        <a href="{{ route('admin.bookings.edit', $booking) }}" class="inline-flex items-center gap-1.5 px-3 py-2 rounded-lg text-sm font-semibold text-amber-600 bg-white border border-amber-200 hover:bg-amber-50 transition-colors" title="Edit / Pindahkan Jadwal">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M7.5 21L3 16.5m0 0L7.5 12M3 16.5h13.5m0-13.5L21 7.5m0 0L16.5 12M21 7.5H7.5" /></svg>
                            Edit
                        </a>
                        <form action="{{ route('admin.bookings.destroy', $booking) }}" method="POST" onsubmit="return confirm('Yakin ingin membatalkan booking ini? Data tetap tersimpan dengan status dibatalkan.')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="inline-flex items-center gap-1.5 px-3 py-2 rounded-lg text-sm font-semibold text-orange-600 bg-white border border-orange-200 hover:bg-orange-50 transition-colors" title="Batalkan">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M9.75 9.75l4.5 4.5m0-4.5l-4.5 4.5M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                                Batalkan
                            </button>
                        </form>
                        @endif
                        @if ($booking->status === 'pending')
                        <form action="{{ route('admin.bookings.approve', $booking) }}" method="POST">
                            @csrf
                            <button type="submit" class="inline-flex items-center gap-1.5 px-3 py-2 rounded-lg text-sm font-semibold text-white bg-green-600 hover:bg-green-700 transition-colors">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                                Setujui
                            </button>
                        </form>
                        <button type="button" data-reject-url="{{ route('admin.bookings.reject', $booking) }}" class="inline-flex items-center gap-1.5 px-3 py-2 rounded-lg text-sm font-semibold text-red-600 bg-white border border-red-200 hover:bg-red-50 transition-colors">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" /></svg>
                            Tolak
                        </button>
                        @endif
                        <form action="{{ route('admin.bookings.force-destroy', $booking) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus PERMANEN data booking ini? Tindakan ini tidak dapat dibatalkan.')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="inline-flex items-center gap-1.5 px-3 py-2 rounded-lg text-sm font-semibold text-red-600 bg-white border border-red-200 hover:bg-red-50 transition-colors" title="Hapus Permanen">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" /></svg>
                                Hapus
                            </button>
                        </form>
                        <a href="{{ route('admin.bookings.show', $booking) }}" class="inline-flex items-center gap-1.5 px-3 py-2 rounded-lg text-sm font-semibold text-blue-600 bg-blue-50 hover:bg-blue-100 transition-colors">
                            Detail
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif
    @endforeach
</div>

@if ($bookings->hasPages())
<div class="mt-6">
    {{ $bookings->links() }}
</div>
@endif
@endif

<div id="rejectModal" class="fixed inset-0 bg-black/50 flex items-center justify-center z-50 hidden">
    <div class="bg-white rounded-xl shadow-xl w-full max-w-lg mx-4 p-6">
        <h3 class="text-lg font-semibold text-gray-900 mb-4">Tolak Booking</h3>

        <form action="" method="POST" id="rejectForm">
            @csrf
            <div class="mb-4">
                <label for="rejection_reason" class="block text-sm font-medium text-gray-700 mb-1">Alasan Penolakan</label>
                <textarea name="rejection_reason" id="rejection_reason" rows="4" required
                          class="w-full rounded-lg border-gray-300 border px-3 py-2 text-sm focus:ring-2 focus:ring-red-500 focus:border-red-500 outline-none"></textarea>
            </div>

            <div class="flex justify-end gap-3 pt-4 border-t border-gray-100">
                <button type="button" id="closeRejectModal" class="px-4 py-2 text-sm font-medium text-gray-600 border border-gray-200 rounded-lg hover:bg-gray-50 transition-colors">
                    Batal
                </button>
                <button type="submit" id="confirmReject" class="px-4 py-2 text-sm font-semibold text-white bg-red-600 rounded-lg hover:bg-red-700 transition-colors flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" /></svg>
                    Tolak
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
(function() {
    var rejectModal = document.getElementById('rejectModal');
    var rejectForm = document.getElementById('rejectForm');
    var confirmReject = document.getElementById('confirmReject');

    function openReject(url, recurringCount) {
        rejectForm.action = url;
        confirmReject.onclick = function() {
            var label = recurringCount ? 'Yakin ingin menolak SEMUA jadwal berulang ini? (' + recurringCount + ' jadwal)' : 'Yakin ingin menolak booking ini?';
            return confirm(label);
        };
        rejectModal.classList.remove('hidden');
    }

    document.querySelectorAll('[data-reject-url]').forEach(function(btn) {
        btn.addEventListener('click', function() {
            openReject(this.dataset.rejectUrl, this.dataset.recurringCount || null);
        });
    });

    document.getElementById('closeRejectModal').addEventListener('click', function() {
        rejectModal.classList.add('hidden');
    });

    document.querySelectorAll('[data-expand-target]').forEach(function(btn) {
        btn.addEventListener('click', function() {
            var target = document.getElementById(this.dataset.expandTarget);
            var chevron = this.querySelector('.group-chevron');
            target.classList.toggle('hidden');
            if (chevron) {
                chevron.classList.toggle('rotate-90');
            }
        });
    });
})();
</script>
@endpush

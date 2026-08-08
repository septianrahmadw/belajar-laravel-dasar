@extends('layouts.app')

@section('title', 'Beranda')

@section('content')
<div class="bg-gradient-to-b from-blue-50 via-white to-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="text-center max-w-2xl mx-auto mb-12">
            <div class="inline-flex items-center gap-2 bg-blue-100 text-blue-700 px-4 py-1.5 rounded-full text-sm font-medium mb-6">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5" /></svg>
                Sistem Peminjaman Ruangan
            </div>
            <h1 class="text-4xl sm:text-5xl font-bold text-gray-900 mb-4 leading-tight">
                Peminjaman <span class="text-blue-600">Lab Komputer Smart Food Security</span>
            </h1>
            <p class="text-lg text-gray-500 leading-relaxed">
                Lihat ketersediaan ruangan laboratorium secara real-time dan lakukan peminjaman secara online. Cepat, mudah, dan transparan.
            </p>
            <div class="flex flex-col sm:flex-row gap-3 justify-center mt-8">
                <a href="#rooms" class="inline-flex items-center justify-center gap-2 bg-blue-600 text-white px-6 py-3 rounded-xl font-semibold hover:bg-blue-700 transition-colors shadow-lg shadow-blue-200">
                <svg class="w-4 h-4 inline-block mr-1 -mt-0.5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6A2.25 2.25 0 016 3.75h2.25A2.25 2.25 0 0110.5 6v2.25a2.25 2.25 0 01-2.25 2.25H6a2.25 2.25 0 01-2.25-2.25V6zM3.75 15.75A2.25 2.25 0 016 13.5h2.25a2.25 2.25 0 012.25 2.25V18a2.25 2.25 0 01-2.25 2.25H6A2.25 2.25 0 013.75 18v-2.25zM13.5 6a2.25 2.25 0 012.25-2.25H18A2.25 2.25 0 0120.25 6v2.25A2.25 2.25 0 0118 10.5h-2.25a2.25 2.25 0 01-2.25-2.25V6zM13.5 15.75a2.25 2.25 0 012.25-2.25H18a2.25 2.25 0 012.25 2.25V18A2.25 2.25 0 0118 20.25h-2.25A2.25 2.25 0 0113.5 18v-2.25z" /></svg>
                    Lihat Ruangan
                </a>
                <a href="{{ route('bookings.my') }}" class="inline-flex items-center justify-center gap-2 bg-white text-gray-700 px-6 py-3 rounded-xl font-semibold border border-gray-200 hover:bg-gray-50 transition-colors">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                    Cek Booking Saya
                </a>
            </div>
        </div>

        <div class="max-w-4xl mx-auto">
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-6 sm:gap-0 sm:divide-x sm:divide-blue-100">
                <div class="flex items-start gap-3 sm:px-6 first:pl-0 last:pr-0">
                    <div class="w-10 h-10 shrink-0 rounded-full bg-green-100 flex items-center justify-center">
                        <svg class="w-5 h-5 text-green-600" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                    </div>
                    <div>
                        <h3 class="font-semibold text-gray-900 mb-0.5 text-sm">Cek Ketersediaan</h3>
                        <p class="text-xs text-gray-500 leading-relaxed">Lihat jadwal kosong ruangan secara real-time sebelum melakukan peminjaman.</p>
                    </div>
                </div>
                <div class="flex items-start gap-3 sm:px-6 first:pl-0 last:pr-0">
                    <div class="w-10 h-10 shrink-0 rounded-full bg-blue-100 flex items-center justify-center">
                        <svg class="w-5 h-5 text-blue-600" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5" /></svg>
                    </div>
                    <div>
                        <h3 class="font-semibold text-gray-900 mb-0.5 text-sm">Booking Online</h3>
                        <p class="text-xs text-gray-500 leading-relaxed">Isi form peminjaman seperti Google Booking. Pilih tanggal dan jam yang tersedia.</p>
                    </div>
                </div>
                <div class="flex items-start gap-3 sm:px-6 first:pl-0 last:pr-0">
                    <div class="w-10 h-10 shrink-0 rounded-full bg-blue-100 flex items-center justify-center">
                        <svg class="w-5 h-5 text-blue-600" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12c0 1.268-.63 2.39-1.593 3.068a3.745 3.745 0 01-1.043 3.296 3.745 3.745 0 01-3.296 1.043A3.745 3.745 0 0112 21c-1.268 0-2.39-.63-3.068-1.593a3.746 3.746 0 01-3.296-1.043 3.745 3.745 0 01-1.043-3.296A3.745 3.745 0 013 12c0-1.268.63-2.39 1.593-3.068a3.745 3.745 0 011.043-3.296 3.746 3.746 0 013.296-1.043A3.746 3.746 0 0112 3c1.268 0 2.39.63 3.068 1.593a3.746 3.746 0 013.296 1.043 3.746 3.746 0 011.043 3.296A3.745 3.745 0 0121 12z" /></svg>
                    </div>
                    <div>
                        <h3 class="font-semibold text-gray-900 mb-0.5 text-sm">Konfirmasi Instan</h3>
                        <p class="text-xs text-gray-500 leading-relaxed">Status booking langsung terlihat. Pantau persetujuan dan riwayat peminjaman Anda.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div id="rooms" class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <div class="flex flex-col sm:flex-row sm:items-end sm:justify-between gap-4 mb-10">
        <div>
            <h2 class="text-2xl font-bold text-gray-900 mb-1">Laboratorium Hari Ini</h2>
            <p class="text-gray-500">Status ketersediaan setiap ruangan per {{ now()->format('d M Y') }}</p>
        </div>
        <div class="flex items-center gap-4 text-xs">
            <span class="flex items-center gap-1.5"><span class="w-2.5 h-2.5 rounded-full bg-green-500"></span> Disetujui (terkunci)</span>
            <span class="flex items-center gap-1.5"><span class="w-2.5 h-2.5 rounded-full bg-amber-400"></span> Menunggu (belum terkunci)</span>
            <span class="flex items-center gap-1.5"><span class="w-2.5 h-2.5 rounded bg-gray-100 border border-gray-200"></span> Kosong</span>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse ($rooms as $data)
        @php
            $room = $data['room'];
            $status = $data['status'];
            $timeline = $data['timeline'];
            $availableHours = $data['available_hours'];
            $totalSlots = $data['total_slots'];
        @endphp
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden hover:shadow-md transition-shadow duration-200 flex flex-col">
            <div class="bg-gradient-to-br from-blue-500 via-blue-500 to-blue-600 relative p-5">
                <div class="absolute inset-0 opacity-10">
                    <svg class="w-full h-full" viewBox="0 0 400 300" fill="none"><rect x="30" y="20" width="70" height="50" rx="6" fill="white"/><rect x="120" y="20" width="70" height="50" rx="6" fill="white"/><rect x="210" y="20" width="70" height="50" rx="6" fill="white"/><rect x="300" y="20" width="70" height="50" rx="6" fill="white"/><rect x="30" y="90" width="70" height="50" rx="6" fill="white"/><rect x="120" y="90" width="70" height="50" rx="6" fill="white"/><rect x="210" y="90" width="70" height="50" rx="6" fill="white"/><rect x="300" y="90" width="70" height="50" rx="6" fill="white"/><rect x="30" y="160" width="70" height="50" rx="6" fill="white"/><rect x="120" y="160" width="70" height="50" rx="6" fill="white"/><rect x="210" y="160" width="70" height="50" rx="6" fill="white"/><rect x="300" y="160" width="70" height="50" rx="6" fill="white"/><rect x="20" y="230" width="360" height="30" rx="6" fill="white"/></svg>
                </div>
                <div class="relative">
                    <div class="flex items-start justify-between gap-3 mb-3">
                        <span class="inline-flex items-center bg-white/20 backdrop-blur-sm text-white px-3 py-1 rounded-full text-xs font-semibold">
                            {{ $room->code }}
                        </span>
                        @if ($status === 'available')
                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-white/20 backdrop-blur-sm text-white">
                            <span class="w-1.5 h-1.5 bg-green-400 rounded-full animate-pulse"></span>
                            Tersedia
                        </span>
                        @elseif ($status === 'partial')
                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-white/20 backdrop-blur-sm text-white">
                            <span class="w-1.5 h-1.5 bg-amber-400 rounded-full"></span>
                            Sebagian
                        </span>
                        @else
                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-white/20 backdrop-blur-sm text-white">
                            <span class="w-1.5 h-1.5 bg-red-400 rounded-full"></span>
                            Penuh
                        </span>
                        @endif
                    </div>
                    <h3 class="text-xl font-bold text-white drop-shadow-lg mb-1.5">{{ $room->name }}</h3>
                    <div class="flex items-center gap-3 text-white/80 text-sm flex-wrap">
                        <span class="flex items-center gap-1">
                            <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1115 0z" /></svg>
                            {{ $room->location }}
                        </span>
                        <span class="flex items-center gap-1">
                            <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z" /></svg>
                            {{ $room->capacity }} orang
                        </span>
                    </div>
                </div>
            </div>

            <div class="flex-1 p-5 flex flex-col">
                @if ($room->description)
                <p class="text-sm text-gray-600 leading-relaxed mb-3">{{ $room->description }}</p>
                @endif
                @if ($room->facilities)
                <div class="flex flex-wrap gap-1.5 mb-4">
                    @foreach (array_slice($room->facilities, 0, 5) as $facility)
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-lg text-xs font-medium bg-blue-50 text-blue-700">{{ $facility }}</span>
                    @endforeach
                    @if (count($room->facilities) > 5)
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-lg text-xs font-medium bg-gray-100 text-gray-600">+{{ count($room->facilities) - 5 }}</span>
                    @endif
                </div>
                @endif

                <div class="mt-auto">
                    <div class="flex items-center justify-between mb-2">
                        <span class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Jadwal Hari Ini</span>
                        <span class="text-xs text-gray-400">{{ $availableHours }}/{{ $totalSlots }} jam tersisa</span>
                    </div>
                    <div class="flex gap-[3px]">
                        @foreach ($timeline as $slot)
                            @if ($slot['status'] === 'approved')
                                <div class="flex-1 h-5 rounded bg-green-600 hover:bg-green-700 transition-colors cursor-pointer" title="{{ $slot['label'] }}: {{ $slot['purpose'] ?? 'Disetujui' }} ({{ $slot['booker'] ?? '' }}) — TIDAK BISA DIBOOKING"></div>
                            @elseif ($slot['status'] === 'pending')
                                <div class="flex-1 h-5 rounded bg-amber-400 border-2 border-dashed border-amber-500 hover:bg-amber-500 transition-colors cursor-pointer" title="{{ $slot['label'] }}: {{ $slot['purpose'] ?? 'Menunggu' }} ({{ $slot['booker'] ?? '' }}) — Masih bisa dibooking"></div>
                            @elseif ($slot['isPast'])
                                <div class="flex-1 h-5 rounded bg-gray-100" title="{{ $slot['label'] }}: Lewat"></div>
                            @else
                                <div class="flex-1 h-5 rounded bg-green-100 border border-green-200 hover:bg-green-200 transition-colors cursor-pointer" title="{{ $slot['label'] }}: Kosong — Bisa dibooking"></div>
                            @endif
                        @endforeach
                    </div>
                    <div class="flex justify-between mt-1 mb-4">
                        <span class="text-[10px] text-gray-400 font-mono">07:00</span>
                        <span class="text-[10px] text-gray-400 font-mono">12:00</span>
                        <span class="text-[10px] text-gray-400 font-mono">17:00</span>
                        <span class="text-[10px] text-gray-400 font-mono">18:00</span>
                    </div>

                    <a href="{{ route('rooms.show', $room) }}" class="w-full inline-flex items-center justify-center gap-2 bg-blue-600 text-white px-5 py-2.5 rounded-xl text-sm font-semibold hover:bg-blue-700 transition-colors shadow-md shadow-blue-200">
                        @if ($status === 'full')
                        Lihat Jadwal Lengkap
                        @else
                        Lihat Jadwal & Booking
                        @endif
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3" /></svg>
                    </a>
                </div>
            </div>
        </div>
        @empty
        <div class="text-center py-16 bg-white rounded-2xl border border-gray-100">
            <svg class="w-16 h-16 text-gray-300 mx-auto mb-4" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 21v-7.5a.75.75 0 01.75-.75h3a.75.75 0 01.75.75V21m-4.5 0H2.36m11.14 0H18m0 0h3.64m-1.39 0V9.349m-16.5 11.65V9.35m0 0a3.001 3.001 0 003.75-.615A2.993 2.993 0 009.75 9.75c.896 0 1.7-.393 2.25-1.016a2.993 2.993 0 002.25 1.016c.896 0 1.7-.393 2.25-1.016a3.001 3.001 0 003.75.614m-16.5 0a3.004 3.004 0 01-.621-4.72L4.318 3.44A1.5 1.5 0 015.378 3h13.243a1.5 1.5 0 011.06.44l1.19 1.189a3 3 0 01-.621 4.72m-13.5 8.65h3.75a.75.75 0 00.75-.75V13.5a.75.75 0 00-.75-.75H6.75a.75.75 0 00-.75.75v3.75c0 .415.336.75.75.75z" /></svg>
            <h3 class="text-lg font-semibold text-gray-900 mb-1">Belum ada ruangan</h3>
            <p class="text-gray-500">Ruangan laboratorium akan segera tersedia.</p>
        </div>
        @endforelse
    </div>
</div>
@endsection

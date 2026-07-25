@extends('admin.layouts.app')

@section('title', 'Detail Booking')
@section('header', 'Detail Booking #' . $booking->id)

@section('content')
<div class="max-w-3xl">
    <div class="bg-white rounded-xl border border-gray-100 overflow-hidden">
        <div class="p-6 border-b border-gray-100">
            <div class="flex items-start justify-between">
                <div>
                    <h3 class="text-lg font-bold text-gray-900">{{ $booking->purpose }}</h3>
                    <p class="text-sm text-gray-500 mt-1">Diajukan pada {{ $booking->created_at->format('d M Y, H:i') }}</p>
                </div>
                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold uppercase tracking-wide
                    {{ $booking->status === 'approved' ? 'bg-green-100 text-green-700' :
                       ($booking->status === 'pending' ? 'bg-amber-100 text-amber-700' :
                       ($booking->status === 'rejected' ? 'bg-red-100 text-red-700' : 'bg-gray-100 text-gray-600')) }}">
                    {{ $booking->statusLabel }}
                </span>
            </div>
        </div>

        <div class="p-6 space-y-6">
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                <div>
                    <h4 class="text-xs font-bold uppercase tracking-wider text-gray-400 mb-2">Data Peminjam</h4>
                    <div class="space-y-2">
                        <div class="flex items-center gap-2">
                            <svg class="w-4 h-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z" /></svg>
                            <span class="text-sm text-gray-700">{{ $booking->booker_name }}</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <svg class="w-4 h-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-1.07 1.916l-7.5 4.615a2.25 2.25 0 01-2.36 0L3.32 8.91a2.25 2.25 0 01-1.07-1.916V6.75" /></svg>
                            <span class="text-sm text-gray-700">{{ $booking->booker_email }}</span>
                        </div>
                        @if ($booking->booker_phone)
                        <div class="flex items-center gap-2">
                            <svg class="w-4 h-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M10.5 1.5H8.25A2.25 2.25 0 006 3.75v16.5a2.25 2.25 0 002.25 2.25h7.5A2.25 2.25 0 0018 20.25V3.75a2.25 2.25 0 00-2.25-2.25H13.5m-3 0V3h3V1.5m-3 0h3m-3 18.75h3" /></svg>
                            <span class="text-sm text-gray-700">{{ $booking->booker_phone }}</span>
                        </div>
                        @endif
                        <div class="flex items-center gap-2">
                            <svg class="w-4 h-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M4.26 10.147a60.436 60.436 0 00-.491 6.347A48.627 48.627 0 0112 20.904a48.627 48.627 0 018.232-4.41 60.46 60.46 0 00-.491-6.347m-15.482 0a50.57 50.57 0 00-2.658-.813A59.905 59.905 0 0112 3.493a59.902 59.902 0 0110.399 5.84c-.896.248-1.783.52-2.658.814m-15.482 0A50.697 50.697 0 0112 13.489a50.702 50.702 0 017.74-3.342M6.75 15a.75.75 0 100-1.5.75.75 0 000 1.5zm0 0v-3.675A55.378 55.378 0 0112 8.443m-7.007 11.55A5.981 5.981 0 006.75 15.75v-1.5" /></svg>
                            <span class="text-sm text-gray-700">{{ $booking->jurusan }}</span>
                        </div>
                        @if ($booking->prodi)
                        <div class="flex items-center gap-2">
                            <svg class="w-4 h-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M4.26 10.147a60.436 60.436 0 00-.491 6.347A48.627 48.627 0 0112 20.904a48.627 48.627 0 018.232-4.41 60.46 60.46 0 00-.491-6.347m-15.482 0a50.57 50.57 0 00-2.658-.813A59.905 59.905 0 0112 3.493a59.902 59.902 0 0110.399 5.84c-.896.248-1.783.52-2.658.814m-15.482 0A50.697 50.697 0 0112 13.489a50.702 50.702 0 017.74-3.342M6.75 15a.75.75 0 100-1.5.75.75 0 000 1.5zm0 0v-3.675A55.378 55.378 0 0112 8.443m-7.007 11.55A5.981 5.981 0 006.75 15.75v-1.5" /></svg>
                            <span class="text-sm text-gray-700">{{ $booking->prodi->name }}</span>
                        </div>
                        @endif
                        <div class="flex items-center gap-2">
                            <svg class="w-4 h-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25" /></svg>
                            <span class="text-sm text-gray-700">{{ $booking->purpose }}</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <svg class="w-4 h-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25" /></svg>
                            <span class="text-sm text-gray-700">{{ $booking->mata_kuliah }}</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <svg class="w-4 h-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5" /></svg>
                            <span class="text-sm text-gray-700">Semester {{ $booking->semester }} - Kelas {{ $booking->kelas }}</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <svg class="w-4 h-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z" /></svg>
                            <span class="text-sm text-gray-700">{{ $booking->dosen }}</span>
                        </div>
                        @if ($booking->teknisi)
                        <div class="flex items-center gap-2">
                            <svg class="w-4 h-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M11.42 15.17l-5.384 3.18A1.5 1.5 0 014.5 17.09V5.91a1.5 1.5 0 011.536-1.26l5.384 3.18a1.5 1.5 0 010 2.58z" /></svg>
                            <span class="text-sm text-gray-700">{{ $booking->teknisi }}</span>
                        </div>
                        @endif
                    </div>
                </div>

                <div>
                    <h4 class="text-xs font-bold uppercase tracking-wider text-gray-400 mb-2">Detail Peminjaman</h4>
                    <div class="space-y-2">
                        <div class="flex items-center gap-2">
                            <svg class="w-4 h-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 21v-7.5a.75.75 0 01.75-.75h3a.75.75 0 01.75.75V21m-4.5 0H2.36m11.14 0H18m0 0h3.64m-1.39 0V9.349m-16.5 11.65V9.35m0 0a3.001 3.001 0 003.75-.615A2.993 2.993 0 009.75 9.75c.896 0 1.7-.393 2.25-1.016a2.993 2.993 0 002.25 1.016c.896 0 1.7-.393 2.25-1.016a3.001 3.001 0 003.75.614m-16.5 0a3.004 3.004 0 01-.621-4.72L4.318 3.44A1.5 1.5 0 015.378 3h13.243a1.5 1.5 0 011.06.44l1.19 1.189a3 3 0 01-.621 4.72m-13.5 8.65h3.75a.75.75 0 00.75-.75V13.5a.75.75 0 00-.75-.75H6.75a.75.75 0 00-.75.75v3.75c0 .415.336.75.75.75z" /></svg>
                            <span class="text-sm text-gray-700">{{ $booking->room->name }} ({{ $booking->room->code }})</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <svg class="w-4 h-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5" /></svg>
                            <span class="text-sm text-gray-700">{{ $booking->date->format('l, d M Y') }}</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <svg class="w-4 h-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                            <span class="text-sm text-gray-700">{{ $booking->formatted_start_time }} - {{ $booking->formatted_end_time }} ({{ $booking->duration }} menit)</span>
                        </div>
                    </div>
                </div>
            </div>

            @if ($booking->notes)
            <div>
                <h4 class="text-xs font-bold uppercase tracking-wider text-gray-400 mb-2">Catatan</h4>
                <p class="text-sm text-gray-700 bg-gray-50 rounded-lg p-3">{{ $booking->notes }}</p>
            </div>
            @endif

            @if ($booking->is_recurring)
            <div>
                <h4 class="text-xs font-bold uppercase tracking-wider text-gray-400 mb-2">Jadwal Berulang</h4>
                <div class="bg-blue-50 rounded-lg p-4">
                    <div class="flex items-center gap-2 mb-2">
                        <svg class="w-5 h-5 text-blue-600" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 12c0-1.232-.046-2.453-.138-3.662a4.006 4.006 0 00-3.7-3.7 48.678 48.678 0 00-7.324 0 4.006 4.006 0 00-3.7 3.7c-.017.22-.032.441-.046.662M19.5 12l3-3m-3 3l-3-3m-12 3c0 1.232.046 2.453.138 3.662a4.006 4.006 0 003.7 3.7 48.656 48.656 0 007.324 0 4.006 4.006 0 003.7-3.7c.017-.22.032-.441.046-.662M4.5 12l3 3m-3-3l-3 3" /></svg>
                        <span class="text-sm font-semibold text-blue-800">Booking Berulang Mingguan</span>
                    </div>
                    <p class="text-xs text-blue-600 mb-2">
                        Berakhir pada: {{ $booking->recurrence_end_date->format('d M Y') }}
                    </p>
                    @php $relatedBookings = $booking->recurrenceBookings; @endphp
                    @if ($relatedBookings->isNotEmpty())
                    <div class="mt-3 space-y-1">
                        <p class="text-xs font-semibold text-blue-700">Jadwal lainnya:</p>
                        @foreach ($relatedBookings as $related)
                        <div class="flex items-center gap-2 text-xs {{ $related->status === 'cancelled' ? 'text-gray-400 line-through' : 'text-blue-700' }}">
                            <span class="w-1.5 h-1.5 rounded-full {{ $related->status === 'approved' ? 'bg-green-500' : ($related->status === 'pending' ? 'bg-amber-400' : 'bg-gray-300') }}"></span>
                            {{ $related->date->format('d M Y') }} ({{ $related->dayName }})
                            <span class="font-mono">{{ $related->formatted_start_time }}-{{ $related->formatted_end_time }}</span>
                            - {{ $related->statusLabel }}
                        </div>
                        @endforeach
                    </div>
                    @endif
                    @if (in_array($booking->status, ['pending', 'approved']))
                    <form action="{{ route('admin.bookings.cancel-recurrence', $booking) }}" method="POST" class="mt-3" onsubmit="return confirm('Yakin ingin membatalkan SEMUA jadwal berulang ini?')">
                        @csrf
                        <button type="submit" class="px-4 py-2 rounded-lg text-xs font-semibold text-red-600 bg-white border border-red-200 hover:bg-red-50 transition-colors flex items-center gap-1.5">
                            <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" /></svg>
                            Batalkan Semua Jadwal Berulang
                        </button>
                    </form>
                    @endif
                </div>
            </div>
            @endif
        </div>

        @if ($booking->status === 'pending')
        <div class="p-6 border-t border-gray-100 bg-gray-50 flex items-center gap-3 justify-end">
            <form action="{{ route('admin.bookings.reject', $booking) }}" method="POST" onsubmit="return confirm('Yakin ingin menolak booking ini?')">
                @csrf
                <button type="submit" class="px-5 py-2.5 rounded-xl text-sm font-semibold text-red-600 bg-white border border-red-200 hover:bg-red-50 transition-colors flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" /></svg>
                    Tolak
                </button>
            </form>
            <form action="{{ route('admin.bookings.approve', $booking) }}" method="POST" onsubmit="return confirm('Yakin ingin menyetujui booking ini?')">
                @csrf
                <button type="submit" class="px-5 py-2.5 rounded-xl text-sm font-semibold text-white bg-green-600 hover:bg-green-700 transition-colors shadow-lg shadow-green-200 flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                    Setujui
                </button>
            </form>
        </div>
        @endif

        @if (in_array($booking->status, ['approved', 'pending']))
        <div class="p-6 border-t border-gray-100 bg-indigo-50/50 flex items-center gap-3 justify-end">
            <a href="{{ route('admin.bookings.edit', $booking) }}" class="px-5 py-2.5 rounded-xl text-sm font-semibold text-white bg-indigo-600 hover:bg-indigo-700 transition-colors shadow-lg shadow-indigo-200 flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M7.5 21L3 16.5m0 0L7.5 12M3 16.5h13.5m0-13.5L21 7.5m0 0L16.5 12M21 7.5H7.5" />
                </svg>
                Edit / Pindahkan Jadwal
            </a>
        </div>
        @endif
    </div>

    <div class="mt-4">
        <a href="{{ route('admin.bookings.index') }}" class="inline-flex items-center gap-1.5 text-sm text-gray-500 hover:text-indigo-600 transition-colors">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5L8.25 12l7.5-7.5" /></svg>
            Kembali ke Daftar Booking
        </a>
    </div>
</div>
@endsection

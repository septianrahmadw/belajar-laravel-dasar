@extends('layouts.app')

@section('title', $room->name)

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="mb-6">
        <a href="{{ route('rooms.index') }}" class="inline-flex items-center gap-1.5 text-sm text-gray-500 hover:text-indigo-600 transition-colors">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5L8.25 12l7.5-7.5" /></svg>
            Kembali ke Daftar Ruangan
        </a>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <div class="lg:col-span-2 space-y-6">
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
                <div class="h-48 bg-gradient-to-br from-indigo-500 via-blue-500 to-indigo-600 relative">
                    <div class="absolute inset-0 opacity-15">
                        <svg class="w-full h-full" viewBox="0 0 800 200" fill="none"><rect x="50" y="30" width="80" height="55" rx="6" fill="white"/><rect x="160" y="30" width="80" height="55" rx="6" fill="white"/><rect x="270" y="30" width="80" height="55" rx="6" fill="white"/><rect x="380" y="30" width="80" height="55" rx="6" fill="white"/><rect x="490" y="30" width="80" height="55" rx="6" fill="white"/><rect x="600" y="30" width="80" height="55" rx="6" fill="white"/><rect x="50" y="110" width="80" height="55" rx="6" fill="white"/><rect x="160" y="110" width="80" height="55" rx="6" fill="white"/><rect x="270" y="110" width="80" height="55" rx="6" fill="white"/><rect x="380" y="110" width="80" height="55" rx="6" fill="white"/><rect x="490" y="110" width="80" height="55" rx="6" fill="white"/><rect x="600" y="110" width="80" height="55" rx="6" fill="white"/></svg>
                    </div>
                    <div class="absolute top-4 left-4 bg-white/20 backdrop-blur-sm text-white px-3 py-1 rounded-full text-sm font-semibold">
                        {{ $room->code }}
                    </div>
                    <div class="absolute bottom-4 left-4 right-4">
                        <h1 class="text-3xl font-bold text-white drop-shadow-lg">{{ $room->name }}</h1>
                    </div>
                </div>
                <div class="p-6">
                    <div class="grid grid-cols-2 sm:grid-cols-4 gap-4 mb-6">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 bg-indigo-50 rounded-lg flex items-center justify-center">
                                <svg class="w-5 h-5 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1115 0z" /></svg>
                            </div>
                            <div>
                                <p class="text-xs text-gray-500">Lokasi</p>
                                <p class="text-sm font-semibold text-gray-900">{{ $room->location }}</p>
                            </div>
                        </div>
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 bg-green-50 rounded-lg flex items-center justify-center">
                                <svg class="w-5 h-5 text-green-600" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z" /></svg>
                            </div>
                            <div>
                                <p class="text-xs text-gray-500">Kapasitas</p>
                                <p class="text-sm font-semibold text-gray-900">{{ $room->capacity }} orang</p>
                            </div>
                        </div>
                    </div>
                    @if ($room->description)
                    <p class="text-gray-600 text-sm leading-relaxed mb-6">{{ $room->description }}</p>
                    @endif
                    @if ($room->facilities)
                    <div>
                        <h4 class="text-sm font-semibold text-gray-900 mb-2">Fasilitas</h4>
                        <div class="flex flex-wrap gap-2">
                            @foreach ($room->facilities as $facility)
                            <span class="inline-flex items-center gap-1 px-3 py-1 rounded-lg text-xs font-medium bg-indigo-50 text-indigo-700">
                                <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" /></svg>
                                {{ $facility }}
                            </span>
                            @endforeach
                        </div>
                    </div>
                    @endif
                </div>
            </div>

            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
                <div class="p-6 border-b border-gray-100">
                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                        <div>
                            <h2 class="text-lg font-bold text-gray-900">Jadwal Harian</h2>
                            <p class="text-sm text-gray-500 mt-0.5" id="schedule-date-label">{{ \Carbon\Carbon::parse($date)->locale('id')->isoFormat('dddd, D MMMM YYYY') }}</p>
                        </div>
                        <div class="flex items-center gap-2">
                            <button type="button" onclick="navigateWeek(-1)" class="p-2 rounded-lg hover:bg-gray-100 transition-colors shrink-0">
                                <svg class="w-4 h-4 text-gray-500" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5L8.25 12l7.5-7.5" /></svg>
                            </button>
                            <div class="flex items-center gap-1 bg-gray-50 rounded-xl p-1" id="week-bar"></div>
                            <button type="button" onclick="navigateWeek(1)" class="p-2 rounded-lg hover:bg-gray-100 transition-colors shrink-0">
                                <svg class="w-4 h-4 text-gray-500" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5" /></svg>
                            </button>
                        </div>
                    </div>
                </div>
                <div class="p-6">
                    @if ($carbonDate->isPast() && !$carbonDate->isToday())
                    <div class="text-center py-8">
                        <svg class="w-12 h-12 text-gray-300 mx-auto mb-3" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                        <p class="text-gray-500 text-sm">Tanggal ini sudah lewat. Pilih tanggal hari ini atau yang akan datang.</p>
                    </div>
                    @else
                    <div class="space-y-1" id="schedule-grid">
                        @foreach ($timeSlots as $slot)
                            @php
                                $hour = (int) explode(':', $slot)[0];
                                $nextHour = $hour + 1;
                                $slotEnd = sprintf('%02d:00', $nextHour);
                                $booking = $bookings->first(function ($b) use ($slot, $slotEnd) {
                                    return $b->formatted_start_time <= $slot && $b->formatted_end_time > $slot;
                                });
                                $isStart = $booking && $booking->formatted_start_time === $slot;
                            @endphp
                            @if ($booking && !$isStart)
                                @continue
                            @endif

                            @if ($booking && $isStart)
                                @php
                                    $bookingStart = (int) explode(':', $booking->formatted_start_time)[0];
                                    $bookingEnd = (int) explode(':', $booking->formatted_end_time)[0];
                                    $spanHours = max(1, $bookingEnd - $bookingStart);
                                @endphp
                            <div class="flex items-stretch gap-3 min-h-[56px]" style="grid-row: span {{ $spanHours }};">
                                <div class="w-16 shrink-0 flex items-start pt-1.5">
                                    <span class="text-xs font-semibold text-gray-400">{{ $slot }}</span>
                                </div>
                                <div class="flex-1 rounded-xl px-4 py-3 border-l-4 {{ $booking->status === 'approved' ? 'bg-green-50 border-green-500' : ($booking->status === 'pending' ? 'bg-amber-50 border-amber-500' : 'bg-gray-50 border-gray-400') }}" style="min-height: {{ $spanHours * 56 }}px;">
                                    <div class="flex items-start justify-between">
                                        <div>
                                            <p class="font-semibold text-sm {{ $booking->status === 'approved' ? 'text-green-800' : ($booking->status === 'pending' ? 'text-amber-800' : 'text-gray-800') }}">
                                                {{ $booking->purpose }}
                                            </p>
                                            <p class="text-xs {{ $booking->status === 'approved' ? 'text-green-600' : ($booking->status === 'pending' ? 'text-amber-600' : 'text-gray-600') }} mt-0.5">
                                                {{ $booking->booker_name }} &middot; {{ $booking->formatted_start_time }} - {{ $booking->formatted_end_time }}
                                            </p>
                                        </div>
                                        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-bold uppercase tracking-wide {{ $booking->status === 'approved' ? 'bg-green-100 text-green-700' : ($booking->status === 'pending' ? 'bg-amber-100 text-amber-700' : 'bg-gray-100 text-gray-600') }}">
                                            {{ $booking->statusLabel }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                            @else
                            <div class="flex items-stretch gap-3">
                                <div class="w-16 shrink-0 flex items-center pt-1.5">
                                    <span class="text-xs font-semibold text-gray-400">{{ $slot }}</span>
                                </div>
                                <div class="flex-1 h-14 rounded-xl border-2 border-dashed border-gray-100 hover:border-indigo-200 hover:bg-indigo-50/30 transition-all flex items-center justify-center px-4">
                                    <span class="text-sm text-green-600 font-semibold flex items-center gap-1.5">
                                        <span class="w-2 h-2 bg-green-400 rounded-full"></span>
                                        Tersedia
                                    </span>
                                </div>
                            </div>
                            @endif
                        @endforeach
                    </div>

                    <div class="flex items-center gap-6 mt-6 pt-4 border-t border-gray-100">
                        <div class="flex items-center gap-2">
                            <div class="w-4 h-4 rounded border-2 border-dashed border-gray-200"></div>
                            <span class="text-xs text-gray-500">Tersedia</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <div class="w-4 h-4 rounded bg-green-50 border-l-2 border-green-500"></div>
                            <span class="text-xs text-gray-500">Disetujui</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <div class="w-4 h-4 rounded bg-amber-50 border-l-2 border-amber-500"></div>
                            <span class="text-xs text-gray-500">Menunggu</span>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>

        <div class="lg:col-span-1">
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden sticky top-24">
                <div class="p-4 border-b border-gray-100 bg-gradient-to-r from-indigo-50 to-blue-50 flex items-center justify-between">
                    <div>
                        <h2 class="text-lg font-bold text-gray-900">Kalender</h2>
                        <p class="text-sm text-gray-500 mt-0.5">Lihat jadwal sebulan penuh</p>
                    </div>
                    <button onclick="openBookingModal()"
                            class="inline-flex items-center gap-1.5 px-4 py-2 bg-indigo-600 text-white text-sm font-semibold rounded-xl hover:bg-indigo-700 transition-all shadow-lg shadow-indigo-200">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" /></svg>
                        Booking
                    </button>
                </div>

                <div class="p-4">
                    <div class="flex items-center justify-between mb-4">
                        <button onclick="navigateMonth(-1)" class="p-2 rounded-lg hover:bg-gray-100 transition-colors">
                            <svg class="w-5 h-5 text-gray-600" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5L8.25 12l7.5-7.5" /></svg>
                        </button>
                        <h3 class="text-base font-bold text-gray-900" id="calendar-month-label">{{ \Carbon\Carbon::parse($date)->locale('id')->isoFormat('MMMM YYYY') }}</h3>
                        <button onclick="navigateMonth(1)" class="p-2 rounded-lg hover:bg-gray-100 transition-colors">
                            <svg class="w-5 h-5 text-gray-600" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5" /></svg>
                        </button>
                    </div>

                    <div class="grid grid-cols-7 gap-0.5 text-center mb-2">
                        @php $dayHeaders = ['Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab', 'Min']; @endphp
                        @foreach ($dayHeaders as $dh)
                        <div class="text-[11px] font-semibold text-gray-400 py-1.5">{{ $dh }}</div>
                        @endforeach
                    </div>

                    <div id="calendar-grid" class="grid grid-cols-7 gap-0.5">
                    </div>

                    <div class="flex items-center gap-1.5 mt-1">
                        <span class="inline-flex items-center gap-1 text-[10px] text-gray-400">
                            <span class="w-2 h-2 rounded-full bg-green-500"></span> Ada jadwal disetujui
                        </span>
                        <span class="inline-flex items-center gap-1 text-[10px] text-gray-400 ml-2">
                            <span class="w-2 h-2 rounded-full bg-amber-500"></span> Ada jadwal menunggu
                        </span>
                    </div>

                    <div class="mt-4 pt-3 border-t border-gray-100" id="calendar-selected-info">
                        <p class="text-xs text-gray-400 text-center">Klik tanggal untuk melihat jadwal</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Modal Form Peminjaman --}}
<div id="booking-modal" class="fixed inset-0 z-50 hidden" aria-modal="true" role="dialog">
    <div class="absolute inset-0 bg-black/50 backdrop-blur-sm" onclick="closeBookingModal()"></div>
    <div class="absolute inset-0 flex items-center justify-center p-4">
        <div class="bg-white rounded-2xl shadow-2xl w-full max-w-lg max-h-[90vh] overflow-y-auto">
            <div class="sticky top-0 z-10 bg-white rounded-t-2xl border-b border-gray-100">
                <div class="flex items-center justify-between p-5">
                    <div>
                        <h2 class="text-lg font-bold text-gray-900">Form Peminjaman</h2>
                        <p class="text-sm text-gray-500 mt-0.5">Isi data diri untuk melakukan booking</p>
                    </div>
                    <button type="button" onclick="closeBookingModal()" class="p-2 rounded-lg hover:bg-gray-100 transition-colors">
                        <svg class="w-5 h-5 text-gray-500" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" /></svg>
                    </button>
                </div>
            </div>
            <form action="{{ route('bookings.store') }}" method="POST" class="p-5 pt-2 space-y-4">
                @csrf
                <input type="hidden" name="room_id" value="{{ $room->id }}">

                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label for="modal_booker_name" class="block mb-2 text-sm font-semibold text-gray-900">Nama Lengkap <span class="text-red-500">*</span></label>
                        <input type="text" name="booker_name" id="modal_booker_name" value="{{ old('booker_name') }}" required
                               class="block w-full px-3 py-2.5 bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-indigo-500 focus:border-indigo-500 shadow-sm placeholder:text-gray-400"
                               placeholder="Nama lengkap">
                    </div>
                    <div>
                        <label for="modal_booker_email" class="block mb-2 text-sm font-semibold text-gray-900">Email <span class="text-red-500">*</span></label>
                        <input type="email" name="booker_email" id="modal_booker_email" value="{{ old('booker_email') }}" required
                               class="block w-full px-3 py-2.5 bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-indigo-500 focus:border-indigo-500 shadow-sm placeholder:text-gray-400"
                               placeholder="email@...">
                    </div>
                </div>

                <div>
                    <label for="modal_booker_phone" class="block mb-2 text-sm font-semibold text-gray-900">No. WhatsApp <span class="text-red-500">*</span></label>
                    <input type="tel" name="booker_phone" id="modal_booker_phone" value="{{ old('booker_phone') }}" required
                           class="block w-full px-3 py-2.5 bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-indigo-500 focus:border-indigo-500 shadow-sm placeholder:text-gray-400"
                           placeholder="08xxxxxxxxxx">
                </div>

                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label for="modal_jurusan" class="block mb-2 text-sm font-semibold text-gray-900">Jurusan <span class="text-red-500">*</span></label>
                        <select name="jurusan" id="modal_jurusan" required
                                class="block w-full px-3 py-2.5 bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-indigo-500 focus:border-indigo-500 shadow-sm">
                            <option value="">Pilih</option>
                            <option value="Budidaya Tanaman Pangan">Budidaya Tanaman Pangan</option>
                            <option value="Budidaya Tanaman Perkebunan">Budidaya Tanaman Perkebunan</option>
                            <option value="Teknologi Pertanian">Teknologi Pertanian</option>
                            <option value="Peternakan">Peternakan</option>
                            <option value="Ekonomi dan Bisnis">Ekonomi dan Bisnis</option>
                            <option value="Teknik">Teknik</option>
                            <option value="Perikanan dan Kelautan">Perikanan dan Kelautan</option>
                            <option value="Teknologi Informasi">Teknologi Informasi</option>
                        </select>
                    </div>
                    <div>
                        <label for="modal_prodi_id" class="block mb-2 text-sm font-semibold text-gray-900">Prodi <span class="text-red-500">*</span></label>
                        <select name="prodi_id" id="modal_prodi_id" required
                                class="block w-full px-3 py-2.5 bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-indigo-500 focus:border-indigo-500 shadow-sm">
                            <option value="">Pilih</option>
                            @foreach ($prodis as $prodi)
                            <option value="{{ $prodi->id }}" data-jurusan="{{ $prodi->jurusan }}">{{ $prodi->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label for="modal_purpose" class="block mb-2 text-sm font-semibold text-gray-900">Keperluan <span class="text-red-500">*</span></label>
                        <select name="purpose" id="modal_purpose" required
                                class="block w-full px-3 py-2.5 bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-indigo-500 focus:border-indigo-500 shadow-sm">
                            <option value="">Pilih</option>
                            <option value="Kuliah">Kuliah</option>
                            <option value="Praktikum">Praktikum</option>
                        </select>
                    </div>
                    <div>
                        <label for="modal_mata_kuliah" class="block mb-2 text-sm font-semibold text-gray-900">Mata Kuliah <span class="text-red-500">*</span></label>
                        <input type="text" name="mata_kuliah" id="modal_mata_kuliah" value="{{ old('mata_kuliah') }}" required
                               class="block w-full px-3 py-2.5 bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-indigo-500 focus:border-indigo-500 shadow-sm placeholder:text-gray-400"
                               placeholder="Nama MK">
                    </div>
                </div>

                <div class="grid grid-cols-3 gap-3">
                    <div>
                        <label for="modal_semester" class="block mb-2 text-sm font-semibold text-gray-900">Semester <span class="text-red-500">*</span></label>
                        <select name="semester" id="modal_semester" required
                                class="block w-full px-3 py-2.5 bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-indigo-500 focus:border-indigo-500 shadow-sm">
                            <option value="">Pilih</option>
                            @for ($s = 1; $s <= 6; $s++)
                            <option value="{{ $s }}">Semester {{ $s }}</option>
                            @endfor
                        </select>
                    </div>
                    <div>
                        <label for="modal_kelas" class="block mb-2 text-sm font-semibold text-gray-900">Kelas <span class="text-red-500">*</span></label>
                        <select name="kelas" id="modal_kelas" required
                                class="block w-full px-3 py-2.5 bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-indigo-500 focus:border-indigo-500 shadow-sm">
                            <option value="">Pilih</option>
                            <option value="A">Kelas A</option>
                            <option value="B">Kelas B</option>
                            <option value="C">Kelas C</option>
                            <option value="D">Kelas D</option>
                        </select>
                    </div>
                    <div>
                        <label for="modal_dosen" class="block mb-2 text-sm font-semibold text-gray-900">Dosen <span class="text-red-500">*</span></label>
                        <input type="text" name="dosen" id="modal_dosen" value="{{ old('dosen') }}" required
                               class="block w-full px-3 py-2.5 bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-indigo-500 focus:border-indigo-500 shadow-sm placeholder:text-gray-400"
                               placeholder="Nama dosen">
                    </div>
                </div>

                <div>
                    <label for="modal_teknisi" class="block mb-2 text-sm font-semibold text-gray-900">Teknisi (Opsional)</label>
                    <input type="text" name="teknisi" id="modal_teknisi" value="{{ old('teknisi') }}"
                           class="block w-full px-3 py-2.5 bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-indigo-500 focus:border-indigo-500 shadow-sm placeholder:text-gray-400"
                           placeholder="Nama teknisi">
                </div>

                <div>
                    <label for="modal_date" class="block mb-2 text-sm font-semibold text-gray-900">Tanggal Mulai <span class="text-red-500">*</span></label>
                    <input type="date" name="date" id="modal_date" value="{{ old('date', $date) }}" required min="{{ now()->format('Y-m-d') }}"
                           class="block w-full px-3 py-2.5 bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-indigo-500 focus:border-indigo-500 shadow-sm">
                </div>

                <div class="bg-gray-50 rounded-xl p-4 border border-gray-100">
                    <label class="flex items-center gap-3 cursor-pointer">
                        <input type="checkbox" name="is_recurring" id="modal_is_recurring" value="1"
                               class="w-4 h-4 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500">
                        <div>
                            <span class="text-sm font-semibold text-gray-700">Booking Berulang</span>
                            <p class="text-[11px] text-gray-400">Setiap minggu di hari yang sama</p>
                        </div>
                    </label>
                    <div id="modal_recurrence_options" class="hidden mt-4 space-y-3">
                        <div class="flex items-center gap-2 text-sm">
                            <svg class="w-4 h-4 text-indigo-500" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                            <span class="text-gray-600">Setiap</span>
                            <span class="font-semibold text-gray-900" id="modal_recurrence_day_display">-</span>
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-gray-600 mb-1.5">Berakhir pada</label>
                            <input type="date" name="recurrence_end_date" id="modal_recurrence_end_date"
                                   min="{{ now()->format('Y-m-d') }}"
                                   class="block w-full px-3 py-2.5 bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-indigo-500 focus:border-indigo-500 shadow-sm">
                            <p class="text-[11px] text-gray-400 mt-1">Maksimal 12 minggu (3 bulan)</p>
                        </div>
                        <div id="modal_recurrence_preview" class="hidden bg-indigo-50 rounded-lg p-3">
                            <p class="text-xs font-semibold text-indigo-700 mb-1">Preview Jadwal:</p>
                            <div id="modal_recurrence_dates" class="text-[11px] text-indigo-600 space-y-0.5"></div>
                        </div>
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label for="modal_start_time" class="block mb-2 text-sm font-semibold text-gray-900">Jam Mulai <span class="text-red-500">*</span></label>
                        <select name="start_time" id="modal_start_time" required
                                class="block w-full px-3 py-2.5 bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-indigo-500 focus:border-indigo-500 shadow-sm">
                            <option value="">Pilih jam</option>
                            @for ($h = 7; $h <= 17; $h++)
                            <option value="{{ sprintf('%02d:00', $h) }}">{{ sprintf('%02d:00', $h) }}</option>
                            @endfor
                        </select>
                    </div>
                    <div>
                        <label for="modal_end_time" class="block mb-2 text-sm font-semibold text-gray-900">Jam Selesai <span class="text-red-500">*</span></label>
                        <select name="end_time" id="modal_end_time" required
                                class="block w-full px-3 py-2.5 bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-indigo-500 focus:border-indigo-500 shadow-sm">
                            <option value="">Pilih jam</option>
                            @for ($h = 8; $h <= 18; $h++)
                            <option value="{{ sprintf('%02d:00', $h) }}">{{ sprintf('%02d:00', $h) }}</option>
                            @endfor
                        </select>
                    </div>
                </div>

                <div id="modal_time_conflict_warning" class="hidden bg-red-50 border border-red-200 rounded-xl p-3">
                    <div class="flex items-center gap-2">
                        <svg class="w-4 h-4 text-red-500 shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z" /></svg>
                        <p class="text-xs text-red-700 font-medium">Waktu ini bentrok dengan jadwal yang sudah ada!</p>
                    </div>
                </div>

                <div>
                    <label for="modal_notes" class="block mb-2 text-sm font-semibold text-gray-900">Catatan (Opsional)</label>
                    <textarea name="notes" id="modal_notes" rows="2"
                              class="block w-full px-3 py-2.5 bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-indigo-500 focus:border-indigo-500 shadow-sm placeholder:text-gray-400 resize-none"
                              placeholder="Tulis catatan jika diperlukan...">{{ old('notes') }}</textarea>
                </div>

                <button type="submit" id="modal_submit_btn"
                        class="w-full bg-indigo-600 text-white py-3 rounded-xl font-semibold hover:bg-indigo-700 transition-all shadow-lg shadow-indigo-200 disabled:opacity-50 disabled:cursor-not-allowed disabled:shadow-none flex items-center justify-center gap-2">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M6 12L3.269 3.126A59.768 59.768 0 0121.485 12 59.77 59.77 0 013.27 20.876L5.999 12zm0 0h7.5" /></svg>
                    Ajukan Booking
                </button>
                <p class="text-[11px] text-gray-400 text-center">Booking akan menunggu persetujuan admin</p>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
const monthBookings = @json($monthBookings);
let calendarDate = new Date('{{ $date }}T00:00:00');

const rootDate = new Date('{{ $date }}T00:00:00');
let weekStartDate = new Date(rootDate);
weekStartDate.setDate(rootDate.getDate() - ((rootDate.getDay() + 6) % 7));
let selectedDateStr = '{{ $date }}';
const dayNames = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
const shortDayNames = ['Min', 'Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab'];
const bookerName = document.getElementById('modal_booker_name');
const bookerEmail = document.getElementById('modal_booker_email');
const bookerPhone = document.getElementById('modal_booker_phone');
const jurusanSelect = document.getElementById('modal_jurusan');
const prodiSelect = document.getElementById('modal_prodi_id');
const purposeSelect = document.getElementById('modal_purpose');
const mataKuliah = document.getElementById('modal_mata_kuliah');
const semesterSelect = document.getElementById('modal_semester');
const kelasSelect = document.getElementById('modal_kelas');
const dosen = document.getElementById('modal_dosen');
const teknisi = document.getElementById('modal_teknisi');
const dateInput = document.getElementById('modal_date');
const startTime = document.getElementById('modal_start_time');
const endTime = document.getElementById('modal_end_time');
const warning = document.getElementById('modal_time_conflict_warning');
const submitBtn = document.getElementById('modal_submit_btn');
const isRecurring = document.getElementById('modal_is_recurring');
const recurrenceOptions = document.getElementById('modal_recurrence_options');
const recurrenceEndDate = document.getElementById('modal_recurrence_end_date');
const recurrenceDayDisplay = document.getElementById('modal_recurrence_day_display');
const recurrencePreview = document.getElementById('modal_recurrence_preview');
const recurrenceDates = document.getElementById('modal_recurrence_dates');

function formatDateStr(d) {
    return d.getFullYear() + '-' + String(d.getMonth() + 1).padStart(2, '0') + '-' + String(d.getDate()).padStart(2, '0');
}

function renderWeekBar() {
    const bar = document.getElementById('week-bar');
    const today = new Date();
    today.setHours(0, 0, 0, 0);
    let html = '';
    for (let i = 0; i < 7; i++) {
        const d = new Date(weekStartDate);
        d.setDate(weekStartDate.getDate() + i);
        const dateStr = formatDateStr(d);
        const dayName = shortDayNames[d.getDay()];
        const dayNum = d.getDate();
        const isActive = dateStr === selectedDateStr;
        const isPast = d < today;
        const isTodayDate = d.getTime() === today.getTime();

        html += '<button type="button" onclick="selectDate(\'' + dateStr + '\')"';
        html += ' class="flex flex-col items-center px-3 py-2 rounded-lg text-center transition-all week-day-btn';
        if (isActive) {
            html += ' bg-indigo-600 text-white shadow-md';
        } else if (isPast) {
            html += ' text-gray-300 cursor-not-allowed';
        } else {
            html += ' text-gray-600 hover:bg-gray-100';
        }
        html += '" data-date="' + dateStr + '"' + (isPast ? ' disabled' : '') + '>';
        html += '<span class="text-[10px] font-bold uppercase">' + dayName + '</span>';
        html += '<span class="text-lg font-bold leading-tight">' + dayNum + '</span>';
        if (isTodayDate && !isActive) {
            html += '<span class="w-1 h-1 rounded-full bg-indigo-500 mt-0.5"></span>';
        } else if (isTodayDate && isActive) {
            html += '<span class="w-1 h-1 rounded-full bg-white mt-0.5"></span>';
        }
        html += '</button>';
    }
    bar.innerHTML = html;
}

function navigateWeek(delta) {
    weekStartDate.setDate(weekStartDate.getDate() + delta * 7);
    const monday = formatDateStr(weekStartDate);
    selectDate(monday);
}

function renderCalendar() {
    const year = calendarDate.getFullYear();
    const month = calendarDate.getMonth();
    const today = new Date();
    today.setHours(0, 0, 0, 0);

    const monthLabel = document.getElementById('calendar-month-label');
    monthLabel.textContent = calendarDate.toLocaleDateString('id-ID', { month: 'long', year: 'numeric' });

    const firstDay = new Date(year, month, 1);
    const lastDay = new Date(year, month + 1, 0);
    const startDay = firstDay.getDay();
    const startOffset = startDay === 0 ? 6 : startDay - 1;

    const grid = document.getElementById('calendar-grid');
    grid.innerHTML = '';

    for (let i = 0; i < startOffset; i++) {
        const empty = document.createElement('div');
        grid.appendChild(empty);
    }

    for (let d = 1; d <= lastDay.getDate(); d++) {
        const cellDate = new Date(year, month, d);
        cellDate.setHours(0, 0, 0, 0);
        const dateStr = cellDate.getFullYear() + '-' +
            String(cellDate.getMonth() + 1).padStart(2, '0') + '-' +
            String(d).padStart(2, '0');

        const btn = document.createElement('button');
        btn.type = 'button';
        btn.textContent = d;

        let classes = 'relative w-full aspect-square rounded-lg text-xs font-semibold transition-all ';

        if (cellDate < today) {
            classes += 'text-gray-300 cursor-not-allowed ';
        } else if (dateStr === dateInput.value) {
            classes += 'bg-indigo-600 text-white shadow-md ';
        } else {
            classes += 'text-gray-700 hover:bg-gray-100 ';
        }

        const dayBookings = monthBookings[dateStr];
        if (dayBookings && dayBookings.length > 0 && dateStr !== dateInput.value) {
            const approvedCount = dayBookings.filter(b => b.status === 'approved').length;
            const pendingCount = dayBookings.filter(b => b.status === 'pending').length;
            if (approvedCount > 0 && pendingCount === 0) {
                classes += 'bg-green-100 text-green-800 font-bold ';
            } else if (pendingCount > 0 && approvedCount === 0) {
                classes += 'bg-amber-100 text-amber-800 font-bold ';
            } else {
                classes += 'bg-gradient-to-br from-green-100 to-amber-100 text-gray-800 font-bold ';
            }
        }

        btn.className = classes;

        if (cellDate >= today) {
            btn.addEventListener('click', function() {
                selectDate(dateStr);
            });
        }

        if (dayBookings && dayBookings.length > 0) {
            const indicator = document.createElement('div');
            indicator.className = 'flex justify-center gap-1 mt-1';
            const hasApproved = dayBookings.some(b => b.status === 'approved');
            const hasPending = dayBookings.some(b => b.status === 'pending');
            if (hasApproved) {
                const dot = document.createElement('span');
                dot.className = 'w-1.5 h-1.5 rounded-full bg-green-500 shadow-sm';
                indicator.appendChild(dot);
            }
            if (hasPending) {
                const dot = document.createElement('span');
                dot.className = 'w-1.5 h-1.5 rounded-full bg-amber-500 shadow-sm';
                indicator.appendChild(dot);
            }
            btn.appendChild(indicator);
        }

        grid.appendChild(btn);
    }
}

function selectDate(dateStr) {
    const d = new Date(dateStr + 'T00:00:00');
    const today = new Date();
    today.setHours(0, 0, 0, 0);
    if (d < today) return;

    dateInput.value = dateStr;
    selectedDateStr = dateStr;

    const newWeekStart = new Date(d);
    newWeekStart.setDate(d.getDate() - ((d.getDay() + 6) % 7));
    weekStartDate = newWeekStart;

    const params = new URLSearchParams(window.location.search);
    params.set('date', dateStr);
    const newUrl = window.location.pathname + '?' + params.toString();
    history.replaceState({}, '', newUrl);

    renderWeekBar();
    renderCalendar();
    updateSelectedInfo(dateStr);
    refreshSchedule(dateStr);
    updateScheduleDateLabel(dateStr);
}

function updateScheduleDateLabel(dateStr) {
    const d = new Date(dateStr + 'T00:00:00');
    const dayName = dayNames[d.getDay()];
    const formatted = d.toLocaleDateString('id-ID', { day: 'numeric', month: 'long', year: 'numeric' });
    const label = document.getElementById('schedule-date-label');
    if (label) label.textContent = dayName + ', ' + formatted;
}

function updateSelectedInfo(dateStr) {
    const info = document.getElementById('calendar-selected-info');
    const d = new Date(dateStr + 'T00:00:00');
    const dayName = dayNames[d.getDay()];
    const formatted = d.toLocaleDateString('id-ID', { day: 'numeric', month: 'long', year: 'numeric' });
    const dayBookings = monthBookings[dateStr] || [];

    let html = '<div class="text-center">';
    html += '<p class="text-sm font-bold text-gray-900">' + dayName + ', ' + formatted + '</p>';

    if (dayBookings.length === 0) {
        html += '<p class="text-xs text-green-600 mt-1 font-medium">Tidak ada jadwal &middot; Tersedia</p>';
    } else {
        html += '<div class="mt-2 space-y-1">';
        dayBookings.forEach(function(b) {
            const isApproved = b.status === 'approved';
            html += '<div class="flex items-center justify-between text-xs px-2 py-1 rounded-lg ' +
                (isApproved ? 'bg-green-50' : 'bg-amber-50') + '">';
            html += '<span class="text-gray-700">' + b.start + '-' + b.end + ' &middot; ' + b.purpose + '</span>';
            html += '<span class="font-semibold ' + (isApproved ? 'text-green-700' : 'text-amber-700') + '">' +
                (isApproved ? 'Disetujui' : 'Pending') + '</span>';
            html += '</div>';
        });
        html += '</div>';
    }
    html += '<button type="button" onclick="openBookingModal()" class="mt-3 w-full bg-indigo-600 text-white text-xs font-semibold py-2 rounded-lg hover:bg-indigo-700 transition-all">Ajukan Peminjaman</button>';
    html += '</div>';
    info.innerHTML = html;
}

function refreshSchedule(dateStr) {
    fetch('{{ route("rooms.schedule", $room) }}?date=' + dateStr)
        .then(function(r) { return r.json(); })
        .then(function(data) {
            const scheduleGrid = document.getElementById('schedule-grid');
            if (!scheduleGrid) return;
            const slots = [];
            for (let h = 7; h <= 17; h++) {
                slots.push(String(h).padStart(2, '0') + ':00');
            }

            let html = '';
            slots.forEach(function(slot) {
                const hour = parseInt(slot);
                const nextHour = hour + 1;
                const slotEnd = String(nextHour).padStart(2, '0') + ':00';
                const booking = data.bookings.find(function(b) {
                    const bs = b.start_time.substring(0, 5);
                    const be = b.end_time.substring(0, 5);
                    return bs < slotEnd && be > slot;
                });
                const bs = booking ? booking.start_time.substring(0, 5) : null;
                const isStart = booking && bs === slot;

                if (booking && !isStart) return;

                if (booking && isStart) {
                    const bs = booking.start_time.substring(0, 5);
                    const be = booking.end_time.substring(0, 5);
                    const bookingStart = parseInt(bs);
                    const bookingEnd = parseInt(be);
                    const spanHours = Math.max(1, bookingEnd - bookingStart);
                    html += '<div class="flex items-stretch gap-3 min-h-[56px]" style="grid-row: span ' + spanHours + ';">';
                    html += '<div class="w-16 shrink-0 flex items-start pt-1.5"><span class="text-xs font-semibold text-gray-400">' + slot + '</span></div>';
                    const isApproved = booking.status === 'approved';
                    html += '<div class="flex-1 rounded-xl px-4 py-3 border-l-4 ' +
                        (isApproved ? 'bg-green-50 border-green-500' : 'bg-amber-50 border-amber-500') +
                        '" style="min-height: ' + (spanHours * 56) + 'px;">';
                    html += '<div class="flex items-start justify-between">';
                    html += '<div><p class="font-semibold text-sm ' +
                        (isApproved ? 'text-green-800' : 'text-amber-800') + '">' + booking.purpose + '</p>';
                    html += '<p class="text-xs ' + (isApproved ? 'text-green-600' : 'text-amber-600') + ' mt-0.5">' +
                        booking.booker_name + ' &middot; ' + bs + ' - ' + be + '</p></div>';
                    html += '<span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-bold uppercase tracking-wide ' +
                        (isApproved ? 'bg-green-100 text-green-700' : 'bg-amber-100 text-amber-700') + '">' +
                        (isApproved ? 'Disetujui' : 'Pending') + '</span>';
                    html += '</div></div></div>';
                } else {
                    html += '<div class="flex items-stretch gap-3">';
                    html += '<div class="w-16 shrink-0 flex items-center pt-1.5"><span class="text-xs font-semibold text-gray-400">' + slot + '</span></div>';
                    html += '<div class="flex-1 h-14 rounded-xl border-2 border-dashed border-gray-100 hover:border-indigo-200 hover:bg-indigo-50/30 transition-all flex items-center justify-center px-4">';
                    html += '<span class="text-sm text-green-600 font-semibold flex items-center gap-1.5"><span class="w-2 h-2 bg-green-400 rounded-full"></span>Tersedia</span>';
                    html += '</div></div>';
                }
            });

            scheduleGrid.innerHTML = html;
        });
}

function navigateMonth(delta) {
    calendarDate.setMonth(calendarDate.getMonth() + delta);
    renderCalendar();
}

function openBookingModal() {
    document.getElementById('booking-modal').classList.remove('hidden');
    document.body.style.overflow = 'hidden';
    renderCalendar();
}

function closeBookingModal() {
    document.getElementById('booking-modal').classList.add('hidden');
    document.body.style.overflow = '';
}

function checkModalConflict() {
    const date = dateInput.value;
    const start = startTime.value;
    const end = endTime.value;

    if (!date || !start || !end || start >= end) {
        warning.classList.add('hidden');
        submitBtn.disabled = false;
        return;
    }

    const dayBookings = monthBookings[date] || [];
    const hasConflict = dayBookings.some(function(b) {
        return b.start < end && b.end > start;
    });

    if (hasConflict) {
        warning.classList.remove('hidden');
        submitBtn.disabled = true;
    } else {
        warning.classList.add('hidden');
        submitBtn.disabled = false;
    }
}

function updateModalRecurrenceDay() {
    const date = dateInput.value;
    if (date) {
        const d = new Date(date + 'T00:00:00');
        recurrenceDayDisplay.textContent = dayNames[d.getDay()] + ' (' + date + ')';
    }
}

function toggleModalRecurrence() {
    if (isRecurring.checked) {
        recurrenceOptions.classList.remove('hidden');
        updateModalRecurrenceDay();
        updateModalRecurrencePreview();
    } else {
        recurrenceOptions.classList.add('hidden');
    }
}

function updateModalRecurrencePreview() {
    const startDate = dateInput.value;
    const endDate = recurrenceEndDate.value;

    if (!startDate || !endDate) {
        recurrencePreview.classList.add('hidden');
        return;
    }

    const start = new Date(startDate + 'T00:00:00');
    const end = new Date(endDate + 'T00:00:00');
    const dates = [];
    let current = new Date(start);

    while (current <= end && dates.length < 12) {
        dates.push(new Date(current));
        current.setDate(current.getDate() + 7);
    }

    if (dates.length === 0) {
        recurrencePreview.classList.add('hidden');
        return;
    }

    recurrenceDates.innerHTML = dates.map(function(d, i) {
        const formatted = d.toLocaleDateString('id-ID', { day: 'numeric', month: 'short', year: 'numeric' });
        return '<div>' + (i + 1) + '. ' + dayNames[d.getDay()] + ', ' + formatted + '</div>';
    }).join('');

    recurrencePreview.classList.remove('hidden');
}

function filterModalProdi() {
    const selectedJurusan = jurusanSelect.value;
    const options = prodiSelect.querySelectorAll('option[data-jurusan]');

    prodiSelect.value = '';

    options.forEach(function(opt) {
        if (!selectedJurusan || opt.dataset.jurusan === selectedJurusan) {
            opt.style.display = '';
        } else {
            opt.style.display = 'none';
        }
    });

    const placeholder = prodiSelect.querySelector('option[value=""]');
    if (placeholder) {
        placeholder.style.display = '';
    }
}

document.addEventListener('DOMContentLoaded', function() {
    jurusanSelect.addEventListener('change', filterModalProdi);
    filterModalProdi();

    startTime.addEventListener('change', checkModalConflict);
    endTime.addEventListener('change', checkModalConflict);
    dateInput.addEventListener('change', function() {
        checkModalConflict();
        updateModalRecurrenceDay();
        updateModalRecurrencePreview();
    });
    isRecurring.addEventListener('change', toggleModalRecurrence);
    recurrenceEndDate.addEventListener('change', updateModalRecurrencePreview);

    renderWeekBar();
    renderCalendar();
    updateSelectedInfo(dateInput.value);

    window.navigateMonth = navigateMonth;
    window.navigateWeek = navigateWeek;
    window.openBookingModal = openBookingModal;
    window.closeBookingModal = closeBookingModal;
});
</script>
@endpush
@endsection

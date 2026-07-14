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
                <div class="h-48 bg-gradient-to-br from-indigo-500 via-purple-500 to-indigo-600 relative">
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
                            <p class="text-sm text-gray-500 mt-0.5">Lihat ketersediaan ruangan per jam</p>
                        </div>
                        <div class="flex items-center gap-2 bg-gray-50 rounded-xl p-1">
                            @foreach ($weekDates as $wd)
                            <a href="{{ route('rooms.show', ['room' => $room, 'date' => $wd['date']]) }}"
                               class="flex flex-col items-center px-3 py-2 rounded-lg text-center transition-all {{ $wd['date'] === $date ? 'bg-indigo-600 text-white shadow-md' : ($wd['isPast'] ? 'text-gray-300' : 'text-gray-600 hover:bg-gray-100') }}">
                                <span class="text-[10px] font-semibold uppercase">{{ $wd['day'] }}</span>
                                <span class="text-lg font-bold leading-tight">{{ $wd['dayNum'] }}</span>
                                @if ($wd['isToday'])
                                <span class="w-1 h-1 rounded-full {{ $wd['date'] === $date ? 'bg-white' : 'bg-indigo-500' }} mt-0.5"></span>
                                @endif
                            </a>
                            @endforeach
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
                                <div class="flex-1 h-14 rounded-xl border-2 border-dashed border-gray-100 hover:border-indigo-200 hover:bg-indigo-50/30 transition-all flex items-center px-4">
                                    <span class="text-xs text-green-600 font-medium flex items-center gap-1.5">
                                        <span class="w-1.5 h-1.5 bg-green-400 rounded-full"></span>
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
                <div class="p-6 border-b border-gray-100 bg-gradient-to-r from-indigo-50 to-purple-50">
                    <h2 class="text-lg font-bold text-gray-900">Form Peminjaman</h2>
                    <p class="text-sm text-gray-500 mt-0.5">Isi data diri Anda untuk melakukan booking</p>
                </div>
                <form action="{{ route('bookings.store') }}" method="POST" class="p-6 space-y-4">
                    @csrf
                    <input type="hidden" name="room_id" value="{{ $room->id }}">

                    <div>
                        <label for="booker_name" class="block text-sm font-semibold text-gray-700 mb-1.5">Nama Lengkap <span class="text-red-500">*</span></label>
                        <input type="text" name="booker_name" id="booker_name" value="{{ old('booker_name') }}" required
                               class="w-full rounded-xl border-gray-200 border px-4 py-2.5 text-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition-shadow"
                               placeholder="Masukkan nama lengkap">
                    </div>

                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <label for="booker_email" class="block text-sm font-semibold text-gray-700 mb-1.5">Email <span class="text-red-500">*</span></label>
                            <input type="email" name="booker_email" id="booker_email" value="{{ old('booker_email') }}" required
                                   class="w-full rounded-xl border-gray-200 border px-4 py-2.5 text-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition-shadow"
                                   placeholder="email@...">
                        </div>
                        <div>
                            <label for="booker_nim" class="block text-sm font-semibold text-gray-700 mb-1.5">NIM / ID</label>
                            <input type="text" name="booker_nim" id="booker_nim" value="{{ old('booker_nim') }}"
                                   class="w-full rounded-xl border-gray-200 border px-4 py-2.5 text-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition-shadow"
                                   placeholder="NIM / ID">
                        </div>
                    </div>

                    <div>
                        <label for="booker_phone" class="block text-sm font-semibold text-gray-700 mb-1.5">No. WhatsApp</label>
                        <input type="tel" name="booker_phone" id="booker_phone" value="{{ old('booker_phone') }}"
                               class="w-full rounded-xl border-gray-200 border px-4 py-2.5 text-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition-shadow"
                               placeholder="08xxxxxxxxxx">
                    </div>

                    <div>
                        <label for="purpose" class="block text-sm font-semibold text-gray-700 mb-1.5">Keperluan <span class="text-red-500">*</span></label>
                        <input type="text" name="purpose" id="purpose" value="{{ old('purpose') }}" required
                               class="w-full rounded-xl border-gray-200 border px-4 py-2.5 text-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition-shadow"
                               placeholder="Contoh: Praktikum Pemrograman Web">
                    </div>

                    <div>
                        <label for="date" class="block text-sm font-semibold text-gray-700 mb-1.5">Tanggal <span class="text-red-500">*</span></label>
                        <input type="date" name="date" id="date" value="{{ old('date', $date) }}" required min="{{ now()->format('Y-m-d') }}"
                               class="w-full rounded-xl border-gray-200 border px-4 py-2.5 text-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition-shadow">
                    </div>

                    <div class="bg-gray-50 rounded-xl p-4 border border-gray-100">
                        <label class="flex items-center gap-3 cursor-pointer">
                            <input type="checkbox" name="is_recurring" id="is_recurring" value="1" {{ old('is_recurring') ? 'checked' : '' }}
                                   class="w-4 h-4 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500">
                            <div>
                                <span class="text-sm font-semibold text-gray-700">Booking Berulang</span>
                                <p class="text-[11px] text-gray-400">Pilih jika ingin meminjam di hari yang sama setiap minggu</p>
                            </div>
                        </label>
                        <div id="recurrence-options" class="hidden mt-4 space-y-3">
                            <div class="flex items-center gap-2 text-sm">
                                <svg class="w-4 h-4 text-indigo-500" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                                <span class="text-gray-600">Setiap</span>
                                <span class="font-semibold text-gray-900" id="recurrence-day-display">-</span>
                            </div>
                            <div>
                                <label class="block text-xs font-semibold text-gray-600 mb-1.5">Berakhir pada</label>
                                <input type="date" name="recurrence_end_date" id="recurrence_end_date"
                                       value="{{ old('recurrence_end_date') }}"
                                       min="{{ now()->format('Y-m-d') }}"
                                       class="w-full rounded-xl border-gray-200 border px-4 py-2.5 text-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition-shadow">
                                <p class="text-[11px] text-gray-400 mt-1">Maksimal 12 minggu (3 bulan)</p>
                            </div>
                            <div id="recurrence-preview" class="hidden bg-indigo-50 rounded-lg p-3">
                                <p class="text-xs font-semibold text-indigo-700 mb-1">Preview Jadwal:</p>
                                <div id="recurrence-dates" class="text-[11px] text-indigo-600 space-y-0.5"></div>
                            </div>
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <label for="start_time" class="block text-sm font-semibold text-gray-700 mb-1.5">Jam Mulai <span class="text-red-500">*</span></label>
                            <select name="start_time" id="start_time" required
                                    class="w-full rounded-xl border-gray-200 border px-4 py-2.5 text-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition-shadow bg-white">
                                <option value="">Pilih jam</option>
                                @for ($h = 7; $h <= 17; $h++)
                                    <option value="{{ sprintf('%02d:00', $h) }}" {{ old('start_time') === sprintf('%02d:00', $h) ? 'selected' : '' }}>
                                        {{ sprintf('%02d:00', $h) }}
                                    </option>
                                @endfor
                            </select>
                        </div>
                        <div>
                            <label for="end_time" class="block text-sm font-semibold text-gray-700 mb-1.5">Jam Selesai <span class="text-red-500">*</span></label>
                            <select name="end_time" id="end_time" required
                                    class="w-full rounded-xl border-gray-200 border px-4 py-2.5 text-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition-shadow bg-white">
                                <option value="">Pilih jam</option>
                                @for ($h = 8; $h <= 18; $h++)
                                    <option value="{{ sprintf('%02d:00', $h) }}" {{ old('end_time') === sprintf('%02d:00', $h) ? 'selected' : '' }}>
                                        {{ sprintf('%02d:00', $h) }}
                                    </option>
                                @endfor
                            </select>
                        </div>
                    </div>

                    <div id="time-conflict-warning" class="hidden bg-red-50 border border-red-200 rounded-xl p-3">
                        <div class="flex items-center gap-2">
                            <svg class="w-4 h-4 text-red-500 shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z" /></svg>
                            <p class="text-xs text-red-700 font-medium">Waktu ini bentrok dengan jadwal yang sudah ada!</p>
                        </div>
                    </div>

                    <div>
                        <label for="notes" class="block text-sm font-semibold text-gray-700 mb-1.5">Catatan (Opsional)</label>
                        <textarea name="notes" id="notes" rows="3"
                                  class="w-full rounded-xl border-gray-200 border px-4 py-2.5 text-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition-shadow resize-none"
                                  placeholder="Tulis catatan jika diperlukan...">{{ old('notes') }}</textarea>
                    </div>

                    <button type="submit" id="submit-btn"
                            class="w-full bg-indigo-600 text-white py-3 rounded-xl font-semibold hover:bg-indigo-700 transition-all shadow-lg shadow-indigo-200 disabled:opacity-50 disabled:cursor-not-allowed disabled:shadow-none flex items-center justify-center gap-2">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M6 12L3.269 3.126A59.768 59.768 0 0121.485 12 59.77 59.77 0 013.27 20.876L5.999 12zm0 0h7.5" /></svg>
                        Ajukan Booking
                    </button>
                    <p class="text-[11px] text-gray-400 text-center">Booking akan menunggu persetujuan admin</p>
                </form>
            </div>
        </div>
    </div>
</div>

@php
    $bookingsJson = $bookings->map(function ($b) {
        return ['start' => $b->formatted_start_time, 'end' => $b->formatted_end_time, 'status' => $b->status];
    })->values();
@endphp

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const bookings = @json($bookingsJson);

    const startTime = document.getElementById('start_time');
    const endTime = document.getElementById('end_time');
    const dateInput = document.getElementById('date');
    const warning = document.getElementById('time-conflict-warning');
    const submitBtn = document.getElementById('submit-btn');
    const isRecurring = document.getElementById('is_recurring');
    const recurrenceOptions = document.getElementById('recurrence-options');
    const recurrenceEndDate = document.getElementById('recurrence_end_date');
    const recurrenceDayDisplay = document.getElementById('recurrence-day-display');
    const recurrencePreview = document.getElementById('recurrence-preview');
    const recurrenceDates = document.getElementById('recurrence-dates');

    const dayNames = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];

    function checkConflict() {
        const date = dateInput.value;
        const start = startTime.value;
        const end = endTime.value;

        if (!date || !start || !end || start >= end) {
            warning.classList.add('hidden');
            submitBtn.disabled = false;
            return;
        }

        const hasConflict = bookings.some(b => {
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

    function updateRecurrenceDay() {
        const date = dateInput.value;
        if (date) {
            const d = new Date(date + 'T00:00:00');
            recurrenceDayDisplay.textContent = dayNames[d.getDay()] + ' (' + dateInput.value + ')';
        }
    }

    function toggleRecurrence() {
        if (isRecurring.checked) {
            recurrenceOptions.classList.remove('hidden');
            updateRecurrenceDay();
            updateRecurrencePreview();
        } else {
            recurrenceOptions.classList.add('hidden');
        }
    }

    function updateRecurrencePreview() {
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

        recurrenceDates.innerHTML = dates.map((d, i) => {
            const formatted = d.toLocaleDateString('id-ID', { day: 'numeric', month: 'short', year: 'numeric' });
            const dayName = dayNames[d.getDay()];
            return '<div>' + (i + 1) + '. ' + dayName + ', ' + formatted + '</div>';
        }).join('');

        recurrencePreview.classList.remove('hidden');
    }

    startTime.addEventListener('change', checkConflict);
    endTime.addEventListener('change', checkConflict);
    dateInput.addEventListener('change', function() {
        checkConflict();
        updateRecurrenceDay();
        updateRecurrencePreview();
    });
    isRecurring.addEventListener('change', toggleRecurrence);
    recurrenceEndDate.addEventListener('change', updateRecurrencePreview);

    checkConflict();
    toggleRecurrence();
});
</script>
@endpush
@endsection

@extends('admin.layouts.app')

@section('title', 'Edit Booking #' . $booking->id)
@section('header', 'Edit / Pindahkan Booking')

@section('content')
<div class="max-w-3xl">
    <div class="bg-white rounded-xl border border-gray-100 overflow-hidden">
        <div class="p-6 border-b border-gray-100">
            <div class="flex items-start justify-between">
                <div>
                    <h3 class="text-lg font-bold text-gray-900">{{ $booking->purpose }}</h3>
                    <p class="text-sm text-gray-500 mt-1">
                        Status:
                        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-bold uppercase
                            {{ $booking->status === 'approved' ? 'bg-green-100 text-green-700' : 'bg-amber-100 text-amber-700' }}">
                            {{ $booking->statusLabel }}
                        </span>
                    </p>
                </div>
            </div>
        </div>

        <form action="{{ route('admin.bookings.update', $booking) }}" method="POST" class="p-6 space-y-6">
            @csrf
            @method('PUT')

            <div>
                <h4 class="text-xs font-bold uppercase tracking-wider text-gray-400 mb-3">Informasi Peminjam (Tidak dapat diubah)</h4>
                <div class="bg-gray-50 rounded-lg p-4 grid grid-cols-1 sm:grid-cols-2 gap-3 text-sm">
                    <div>
                        <span class="text-gray-500">Nama:</span>
                        <span class="text-gray-900 font-medium">{{ $booking->booker_name }}</span>
                    </div>
                    <div>
                        <span class="text-gray-500">Email:</span>
                        <span class="text-gray-900 font-medium">{{ $booking->booker_email }}</span>
                    </div>
                    <div>
                        <span class="text-gray-500">Keperluan:</span>
                        <span class="text-gray-900 font-medium">{{ $booking->purpose }}</span>
                    </div>
                    @if ($booking->mata_kuliah)
                    <div>
                        <span class="text-gray-500">Mata Kuliah:</span>
                        <span class="text-gray-900 font-medium">{{ $booking->mata_kuliah }}</span>
                    </div>
                    @endif
                </div>
            </div>

            <div>
                <h4 class="text-xs font-bold uppercase tracking-wider text-gray-400 mb-3">Ubah Jadwal & Ruangan</h4>
                <div class="space-y-4">
                    <div>
                        <label for="room_id" class="block text-sm font-semibold text-gray-700 mb-1">Ruangan</label>
                        <select name="room_id" id="room_id" class="w-full rounded-lg border-gray-300 border px-3 py-2.5 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none bg-white @error('room_id') border-red-300 @enderror">
                            @foreach ($rooms as $room)
                                <option value="{{ $room->id }}" {{ old('room_id', $booking->room_id) == $room->id ? 'selected' : '' }}>
                                    {{ $room->name }} ({{ $room->code }}) - {{ $room->location }}
                                </option>
                            @endforeach
                        </select>
                        @error('room_id')
                            <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="date" class="block text-sm font-semibold text-gray-700 mb-1">Tanggal</label>
                        <input type="date" name="date" id="date" value="{{ old('date', $booking->date->format('Y-m-d')) }}"
                            class="w-full rounded-lg border-gray-300 border px-3 py-2.5 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none @error('date') border-red-300 @enderror">
                        @error('date')
                            <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label for="start_time" class="block text-sm font-semibold text-gray-700 mb-1">Jam Mulai</label>
                            <select name="start_time" id="start_time" class="w-full rounded-lg border-gray-300 border px-3 py-2.5 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none bg-white @error('start_time') border-red-300 @enderror">
                                @foreach ($timeSlots as $slot)
                                    <option value="{{ $slot }}" {{ old('start_time', $booking->formatted_start_time) == $slot ? 'selected' : '' }}>
                                        {{ $slot }}
                                    </option>
                                @endforeach
                            </select>
                            @error('start_time')
                                <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label for="end_time" class="block text-sm font-semibold text-gray-700 mb-1">Jam Selesai</label>
                            <select name="end_time" id="end_time" class="w-full rounded-lg border-gray-300 border px-3 py-2.5 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none bg-white @error('end_time') border-red-300 @enderror">
                                @foreach ($timeSlots as $slot)
                                    <option value="{{ $slot }}" {{ old('end_time', $booking->formatted_end_time) == $slot ? 'selected' : '' }}>
                                        {{ $slot }}
                                    </option>
                                @endforeach
                            </select>
                            @error('end_time')
                                <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>

            <div class="p-6 border-t border-gray-100 bg-gray-50 flex items-center gap-3 justify-end">
                <a href="{{ route('admin.bookings.show', $booking) }}" class="px-5 py-2.5 rounded-xl text-sm font-semibold text-gray-600 bg-white border border-gray-200 hover:bg-gray-50 transition-colors">
                    Batal
                </a>
                <button type="submit" class="px-5 py-2.5 rounded-xl text-sm font-semibold text-white bg-blue-600 hover:bg-blue-700 transition-colors shadow-lg shadow-blue-200 flex items-center gap-2"
                    onclick="return confirm('Yakin ingin memindahkan jadwal booking ini?')">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M7.5 21L3 16.5m0 0L7.5 12M3 16.5h13.5m0-13.5L21 7.5m0 0L16.5 12M21 7.5H7.5" />
                    </svg>
                    Simpan & Pindahkan
                </button>
            </div>
        </form>
    </div>

    <div class="mt-4">
        <a href="{{ route('admin.bookings.show', $booking) }}" class="inline-flex items-center gap-1.5 text-sm text-gray-500 hover:text-blue-600 transition-colors">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5L8.25 12l7.5-7.5" /></svg>
            Kembali ke Detail Booking
        </a>
    </div>
</div>
@endsection

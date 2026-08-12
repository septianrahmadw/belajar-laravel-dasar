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
                <h4 class="text-xs font-bold uppercase tracking-wider text-gray-400 mb-3">Data Peminjam</h4>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label for="booker_name" class="block text-sm font-semibold text-gray-700 mb-1">Nama Lengkap</label>
                        <input type="text" name="booker_name" id="booker_name" value="{{ old('booker_name', $booking->booker_name) }}"
                            class="w-full rounded-lg border-gray-300 border px-3 py-2.5 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none @error('booker_name') border-red-300 @enderror">
                        @error('booker_name')
                            <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label for="booker_email" class="block text-sm font-semibold text-gray-700 mb-1">Email</label>
                        <input type="email" name="booker_email" id="booker_email" value="{{ old('booker_email', $booking->booker_email) }}"
                            class="w-full rounded-lg border-gray-300 border px-3 py-2.5 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none @error('booker_email') border-red-300 @enderror">
                        @error('booker_email')
                            <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label for="booker_phone" class="block text-sm font-semibold text-gray-700 mb-1">No. WhatsApp</label>
                        <input type="tel" name="booker_phone" id="booker_phone" value="{{ old('booker_phone', $booking->booker_phone) }}"
                            class="w-full rounded-lg border-gray-300 border px-3 py-2.5 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none @error('booker_phone') border-red-300 @enderror">
                        @error('booker_phone')
                            <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <div>
                <h4 class="text-xs font-bold uppercase tracking-wider text-gray-400 mb-3">Data Akademik</h4>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label for="jurusan" class="block text-sm font-semibold text-gray-700 mb-1">Jurusan</label>
                        <select name="jurusan" id="jurusan" class="w-full rounded-lg border-gray-300 border px-3 py-2.5 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none bg-white @error('jurusan') border-red-300 @enderror">
                            @foreach ($jurusans as $j)
                                <option value="{{ $j }}" {{ old('jurusan', $booking->jurusan) == $j ? 'selected' : '' }}>{{ $j }}</option>
                            @endforeach
                        </select>
                        @error('jurusan')
                            <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label for="prodi_id" class="block text-sm font-semibold text-gray-700 mb-1">Prodi</label>
                        <select name="prodi_id" id="prodi_id" class="w-full rounded-lg border-gray-300 border px-3 py-2.5 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none bg-white @error('prodi_id') border-red-300 @enderror">
                            <option value="">- Pilih Prodi -</option>
                            @foreach ($prodis as $prodi)
                                <option value="{{ $prodi->id }}" data-jurusan="{{ $prodi->jurusan }}" {{ old('prodi_id', $booking->prodi_id) == $prodi->id ? 'selected' : '' }}>
                                    {{ $prodi->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('prodi_id')
                            <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label for="purpose" class="block text-sm font-semibold text-gray-700 mb-1">Keperluan</label>
                        <select name="purpose" id="purpose" class="w-full rounded-lg border-gray-300 border px-3 py-2.5 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none bg-white @error('purpose') border-red-300 @enderror">
                            <option value="Kuliah" {{ old('purpose', $booking->purpose) == 'Kuliah' ? 'selected' : '' }}>Kuliah</option>
                            <option value="Praktikum" {{ old('purpose', $booking->purpose) == 'Praktikum' ? 'selected' : '' }}>Praktikum</option>
                        </select>
                        @error('purpose')
                            <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label for="mata_kuliah" class="block text-sm font-semibold text-gray-700 mb-1">Mata Kuliah</label>
                        <input type="text" name="mata_kuliah" id="mata_kuliah" value="{{ old('mata_kuliah', $booking->mata_kuliah) }}"
                            class="w-full rounded-lg border-gray-300 border px-3 py-2.5 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none @error('mata_kuliah') border-red-300 @enderror">
                        @error('mata_kuliah')
                            <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label for="semester" class="block text-sm font-semibold text-gray-700 mb-1">Semester</label>
                        <select name="semester" id="semester" class="w-full rounded-lg border-gray-300 border px-3 py-2.5 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none bg-white @error('semester') border-red-300 @enderror">
                            @for ($s = 1; $s <= 6; $s++)
                                <option value="{{ $s }}" {{ (int) old('semester', $booking->semester) === $s ? 'selected' : '' }}>Semester {{ $s }}</option>
                            @endfor
                        </select>
                        @error('semester')
                            <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label for="kelas" class="block text-sm font-semibold text-gray-700 mb-1">Kelas</label>
                        <select name="kelas" id="kelas" class="w-full rounded-lg border-gray-300 border px-3 py-2.5 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none bg-white @error('kelas') border-red-300 @enderror">
                            @foreach (['A','B','C','D','E'] as $k)
                                <option value="{{ $k }}" {{ old('kelas', $booking->kelas) == $k ? 'selected' : '' }}>Kelas {{ $k }}</option>
                            @endforeach
                        </select>
                        @error('kelas')
                            <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label for="dosen" class="block text-sm font-semibold text-gray-700 mb-1">Dosen</label>
                        <input type="text" name="dosen" id="dosen" value="{{ old('dosen', $booking->dosen) }}"
                            class="w-full rounded-lg border-gray-300 border px-3 py-2.5 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none @error('dosen') border-red-300 @enderror">
                        @error('dosen')
                            <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label for="teknisi" class="block text-sm font-semibold text-gray-700 mb-1">Teknisi <span class="text-gray-400 font-normal">(Opsional)</span></label>
                        <input type="text" name="teknisi" id="teknisi" value="{{ old('teknisi', $booking->teknisi) }}"
                            class="w-full rounded-lg border-gray-300 border px-3 py-2.5 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none @error('teknisi') border-red-300 @enderror">
                        @error('teknisi')
                            <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                        @enderror
                    </div>
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

            <div>
                <h4 class="text-xs font-bold uppercase tracking-wider text-gray-400 mb-3">Catatan</h4>
                <textarea name="notes" id="notes" rows="3"
                    class="w-full rounded-lg border-gray-300 border px-3 py-2.5 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none resize-none @error('notes') border-red-300 @enderror">{{ old('notes', $booking->notes) }}</textarea>
                @error('notes')
                    <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="p-6 border-t border-gray-100 bg-gray-50 flex items-center gap-3 justify-end">
                <a href="{{ route('admin.bookings.show', $booking) }}" class="px-5 py-2.5 rounded-xl text-sm font-semibold text-gray-600 bg-white border border-gray-200 hover:bg-gray-50 transition-colors">
                    Batal
                </a>
                <button type="submit" class="px-5 py-2.5 rounded-xl text-sm font-semibold text-white bg-blue-600 hover:bg-blue-700 transition-colors shadow-lg shadow-blue-200 flex items-center gap-2"
                    onclick="return confirm('Yakin ingin menyimpan perubahan booking ini?')">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M7.5 21L3 16.5m0 0L7.5 12M3 16.5h13.5m0-13.5L21 7.5m0 0L16.5 12M21 7.5H7.5" />
                    </svg>
                    Simpan Perubahan
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

<script>
document.addEventListener('DOMContentLoaded', function () {
    const jurusanEl = document.getElementById('jurusan');
    const prodiEl = document.getElementById('prodi_id');
    if (!jurusanEl || !prodiEl) return;

    const allOptions = Array.from(prodiEl.options).filter(o => o.value !== '');

    function filterProdi() {
        const selected = jurusanEl.value;
        allOptions.forEach(opt => {
            const match = !selected || opt.dataset.jurusan === selected;
            opt.style.display = match ? '' : 'none';
            if (!match && opt.selected) {
                opt.selected = false;
            }
        });
    }

    jurusanEl.addEventListener('change', filterProdi);
    filterProdi();
});
</script>
@endsection

@extends('admin.layouts.app')

@section('title', 'Tambah Ruangan')
@section('header', 'Tambah Ruangan Baru')

@section('content')
<div class="max-w-2xl">
    <div class="bg-white rounded-xl border border-gray-100 overflow-hidden">
        <div class="p-6">
            <form action="{{ route('admin.rooms.store') }}" method="POST" class="space-y-5">
                @csrf

                <div>
                    <label for="name" class="block text-sm font-semibold text-gray-700 mb-1.5">Nama Ruangan <span class="text-red-500">*</span></label>
                    <input type="text" name="name" id="name" value="{{ old('name') }}" required
                           class="w-full rounded-xl border-gray-200 border px-4 py-2.5 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none"
                           placeholder="Contoh: Lab Komputer A">
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label for="code" class="block text-sm font-semibold text-gray-700 mb-1.5">Kode Ruangan <span class="text-red-500">*</span></label>
                        <input type="text" name="code" id="code" value="{{ old('code') }}" required
                               class="w-full rounded-xl border-gray-200 border px-4 py-2.5 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none"
                               placeholder="Contoh: LAB-A">
                    </div>
                    <div>
                        <label for="capacity" class="block text-sm font-semibold text-gray-700 mb-1.5">Kapasitas <span class="text-red-500">*</span></label>
                        <input type="number" name="capacity" id="capacity" value="{{ old('capacity', 30) }}" required min="1"
                               class="w-full rounded-xl border-gray-200 border px-4 py-2.5 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none">
                    </div>
                </div>

                <div>
                    <label for="location" class="block text-sm font-semibold text-gray-700 mb-1.5">Lokasi <span class="text-red-500">*</span></label>
                    <input type="text" name="location" id="location" value="{{ old('location') }}" required
                           class="w-full rounded-xl border-gray-200 border px-4 py-2.5 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none"
                           placeholder="Contoh: Gedung Teknologi Lantai 2">
                </div>

                <div>
                    <label for="description" class="block text-sm font-semibold text-gray-700 mb-1.5">Deskripsi</label>
                    <textarea name="description" id="description" rows="3"
                              class="w-full rounded-xl border-gray-200 border px-4 py-2.5 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none resize-none"
                              placeholder="Deskripsi singkat mengenai ruangan...">{{ old('description') }}</textarea>
                </div>

                <div>
                    <label for="facilities" class="block text-sm font-semibold text-gray-700 mb-1.5">Fasilitas</label>
                    <input type="text" name="facilities" id="facilities" value="{{ old('facilities') }}"
                           class="w-full rounded-xl border-gray-200 border px-4 py-2.5 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none"
                           placeholder="Pisahkan dengan koma: AC, Projector, Whiteboard">
                    <p class="text-xs text-gray-400 mt-1">Pisahkan setiap fasilitas dengan tanda koma</p>
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1.5">Batasan Prodi</label>
                    <p class="text-xs text-gray-400 mb-3">Pilih prodi yang diizinkan mengakses lab ini. Kosongkan jika semua prodi boleh mengakses.</p>
                    @php
                        $groupedProdis = $prodis->groupBy('jurusan');
                        $selectedProdis = old('allowed_prodis', []);
                    @endphp
                    <div class="border border-gray-200 rounded-xl p-4 max-h-60 overflow-y-auto space-y-4">
                        @forelse ($groupedProdis as $jurusan => $jurusanProdis)
                        <div>
                            <p class="text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">{{ $jurusan }}</p>
                            <div class="space-y-1.5">
                                @foreach ($jurusanProdis as $prodi)
                                <label class="flex items-center gap-2.5 cursor-pointer group">
                                    <input type="checkbox" name="allowed_prodis[]" value="{{ $prodi->id }}"
                                           {{ in_array($prodi->id, $selectedProdis) ? 'checked' : '' }}
                                           class="rounded-lg border-gray-300 text-blue-600 focus:ring-blue-500">
                                    <span class="text-sm text-gray-700 group-hover:text-gray-900">{{ $prodi->name }}</span>
                                </label>
                                @endforeach
                            </div>
                        </div>
                        @empty
                        <p class="text-xs text-gray-400 text-center">Belum ada prodi tersedia</p>
                        @endforelse
                    </div>
                </div>

                <div class="flex items-center gap-3">
                    <input type="checkbox" name="is_active" id="is_active" value="1" {{ old('is_active', '1') ? 'checked' : '' }}
                           class="rounded-lg border-gray-300 text-blue-600 focus:ring-blue-500">
                    <label for="is_active" class="text-sm font-medium text-gray-700">Aktifkan ruangan ini</label>
                </div>

                <div class="flex items-center gap-3 pt-4 border-t border-gray-100">
                    <a href="{{ route('admin.rooms.index') }}" class="px-5 py-2.5 rounded-xl text-sm font-semibold text-gray-600 bg-gray-100 hover:bg-gray-200 transition-colors">Batal</a>
                    <button type="submit" class="px-6 py-2.5 rounded-xl text-sm font-semibold text-white bg-blue-600 hover:bg-blue-700 transition-colors shadow-lg shadow-blue-200">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@extends('admin.layouts.app')

@section('title', 'Tambah Prodi')
@section('header', 'Tambah Program Studi Baru')

@section('content')
<div class="max-w-2xl">
    <div class="bg-white rounded-xl border border-gray-100 overflow-hidden">
        <div class="p-6">
            <form action="{{ route('admin.prodis.store') }}" method="POST" class="space-y-5">
                @csrf

                <div>
                    <label for="name" class="block text-sm font-semibold text-gray-700 mb-1.5">Nama Prodi <span class="text-red-500">*</span></label>
                    <input type="text" name="name" id="name" value="{{ old('name') }}" required
                           class="w-full rounded-xl border-gray-200 border px-4 py-2.5 text-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none"
                           placeholder="Contoh: Teknik Informatika">
                </div>

                <div>
                    <label for="jurusan" class="block text-sm font-semibold text-gray-700 mb-1.5">Jurusan <span class="text-red-500">*</span></label>
                    <select name="jurusan" id="jurusan" required
                            class="w-full rounded-xl border-gray-200 border px-4 py-2.5 text-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none bg-white">
                        <option value="">Pilih Jurusan</option>
                        @foreach ($jurusans as $j)
                            <option value="{{ $j }}" {{ old('jurusan') === $j ? 'selected' : '' }}>{{ $j }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="flex items-center gap-3">
                    <input type="checkbox" name="is_active" id="is_active" value="1" {{ old('is_active', '1') ? 'checked' : '' }}
                           class="rounded-lg border-gray-300 text-indigo-600 focus:ring-indigo-500">
                    <label for="is_active" class="text-sm font-medium text-gray-700">Aktifkan prodi ini</label>
                </div>

                <div class="flex items-center gap-3 pt-4 border-t border-gray-100">
                    <a href="{{ route('admin.prodis.index') }}" class="px-5 py-2.5 rounded-xl text-sm font-semibold text-gray-600 bg-gray-100 hover:bg-gray-200 transition-colors">Batal</a>
                    <button type="submit" class="px-6 py-2.5 rounded-xl text-sm font-semibold text-white bg-indigo-600 hover:bg-indigo-700 transition-colors shadow-lg shadow-indigo-200">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

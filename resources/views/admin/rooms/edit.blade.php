@extends('admin.layouts.app')

@section('title', 'Edit Ruangan')
@section('header', 'Edit: ' . $room->name)

@section('content')
<div class="max-w-2xl">
    <div class="bg-white rounded-xl border border-gray-100 overflow-hidden">
        <div class="p-6">
            <form action="{{ route('admin.rooms.update', $room) }}" method="POST" class="space-y-5">
                @csrf
                @method('PUT')

                <div>
                    <label for="name" class="block text-sm font-semibold text-gray-700 mb-1.5">Nama Ruangan <span class="text-red-500">*</span></label>
                    <input type="text" name="name" id="name" value="{{ old('name', $room->name) }}" required
                           class="w-full rounded-xl border-gray-200 border px-4 py-2.5 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none">
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label for="code" class="block text-sm font-semibold text-gray-700 mb-1.5">Kode Ruangan <span class="text-red-500">*</span></label>
                        <input type="text" name="code" id="code" value="{{ old('code', $room->code) }}" required
                               class="w-full rounded-xl border-gray-200 border px-4 py-2.5 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none">
                    </div>
                    <div>
                        <label for="capacity" class="block text-sm font-semibold text-gray-700 mb-1.5">Kapasitas <span class="text-red-500">*</span></label>
                        <input type="number" name="capacity" id="capacity" value="{{ old('capacity', $room->capacity) }}" required min="1"
                               class="w-full rounded-xl border-gray-200 border px-4 py-2.5 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none">
                    </div>
                </div>

                <div>
                    <label for="location" class="block text-sm font-semibold text-gray-700 mb-1.5">Lokasi <span class="text-red-500">*</span></label>
                    <input type="text" name="location" id="location" value="{{ old('location', $room->location) }}" required
                           class="w-full rounded-xl border-gray-200 border px-4 py-2.5 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none">
                </div>

                <div>
                    <label for="description" class="block text-sm font-semibold text-gray-700 mb-1.5">Deskripsi</label>
                    <textarea name="description" id="description" rows="3"
                              class="w-full rounded-xl border-gray-200 border px-4 py-2.5 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none resize-none">{{ old('description', $room->description) }}</textarea>
                </div>

                <div>
                    <label for="facilities" class="block text-sm font-semibold text-gray-700 mb-1.5">Fasilitas</label>
                    <input type="text" name="facilities" id="facilities" value="{{ old('facilities', is_array($room->facilities) ? implode(', ', $room->facilities) : '') }}"
                           class="w-full rounded-xl border-gray-200 border px-4 py-2.5 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none"
                           placeholder="Pisahkan dengan koma: AC, Projector, Whiteboard">
                    <p class="text-xs text-gray-400 mt-1">Pisahkan setiap fasilitas dengan tanda koma</p>
                </div>

                <div class="flex items-center gap-3">
                    <input type="checkbox" name="is_active" id="is_active" value="1" {{ old('is_active', $room->is_active) ? 'checked' : '' }}
                           class="rounded-lg border-gray-300 text-blue-600 focus:ring-blue-500">
                    <label for="is_active" class="text-sm font-medium text-gray-700">Aktifkan ruangan ini</label>
                </div>

                <div class="flex items-center gap-3 pt-4 border-t border-gray-100">
                    <a href="{{ route('admin.rooms.index') }}" class="px-5 py-2.5 rounded-xl text-sm font-semibold text-gray-600 bg-gray-100 hover:bg-gray-200 transition-colors">Batal</a>
                    <button type="submit" class="px-6 py-2.5 rounded-xl text-sm font-semibold text-white bg-blue-600 hover:bg-blue-700 transition-colors shadow-lg shadow-blue-200">Perbarui</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

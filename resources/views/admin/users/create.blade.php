@extends('admin.layouts.app')

@section('title', 'Tambah Pengguna')
@section('header', 'Tambah Pengguna Baru')

@section('content')
<div class="max-w-lg">
    <div class="bg-white rounded-xl border border-gray-100 overflow-hidden">
        <div class="p-6">
            <form action="{{ route('admin.users.store') }}" method="POST" class="space-y-5">
                @csrf

                <div>
                    <label for="name" class="block text-sm font-semibold text-gray-700 mb-1.5">Nama Lengkap <span class="text-red-500">*</span></label>
                    <input type="text" name="name" id="name" value="{{ old('name') }}" required
                           class="w-full rounded-xl border-gray-200 border px-4 py-2.5 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none"
                           placeholder="Masukkan nama lengkap">
                </div>

                <div>
                    <label for="email" class="block text-sm font-semibold text-gray-700 mb-1.5">Email <span class="text-red-500">*</span></label>
                    <input type="email" name="email" id="email" value="{{ old('email') }}" required
                           class="w-full rounded-xl border-gray-200 border px-4 py-2.5 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none"
                           placeholder="email@example.com">
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label for="password" class="block text-sm font-semibold text-gray-700 mb-1.5">Password <span class="text-red-500">*</span></label>
                        <input type="password" name="password" id="password" required
                               class="w-full rounded-xl border-gray-200 border px-4 py-2.5 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none"
                               placeholder="Min. 6 karakter">
                    </div>
                    <div>
                        <label for="password_confirmation" class="block text-sm font-semibold text-gray-700 mb-1.5">Konfirmasi <span class="text-red-500">*</span></label>
                        <input type="password" name="password_confirmation" id="password_confirmation" required
                               class="w-full rounded-xl border-gray-200 border px-4 py-2.5 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none"
                               placeholder="Ulangi password">
                    </div>
                </div>

                <div>
                    <label for="role" class="block text-sm font-semibold text-gray-700 mb-1.5">Role</label>
                    <select name="role" id="role"
                            class="w-full rounded-xl border-gray-200 border px-4 py-2.5 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none bg-white">
                        <option value="user" {{ old('role') === 'user' ? 'selected' : '' }}>User</option>
                        <option value="operator" {{ old('role') === 'operator' ? 'selected' : '' }}>Operator Lab</option>
                        <option value="admin" {{ old('role') === 'admin' ? 'selected' : '' }}>Administrator</option>
                    </select>
                    <p class="text-xs text-gray-400 mt-1">Admin: full akses | Operator: kelola ruangan & booking | User: hanya booking</p>
                </div>

                <div class="flex items-center gap-3 pt-4 border-t border-gray-100">
                    <a href="{{ route('admin.users.index') }}" class="px-5 py-2.5 rounded-xl text-sm font-semibold text-gray-600 bg-gray-100 hover:bg-gray-200 transition-colors">Batal</a>
                    <button type="submit" class="px-6 py-2.5 rounded-xl text-sm font-semibold text-white bg-blue-600 hover:bg-blue-700 transition-colors shadow-lg shadow-blue-200">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

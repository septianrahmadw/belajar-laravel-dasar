@extends('admin.layouts.app')

@section('title', 'Manajemen Prodi')
@section('header', 'Program Studi')

@section('actions')
<a href="{{ route('admin.prodis.create') }}" class="bg-indigo-600 text-white px-4 py-2 rounded-lg text-sm font-semibold hover:bg-indigo-700 transition-colors flex items-center gap-2">
    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" /></svg>
    Tambah Prodi
</a>
@endsection

@section('content')
<div class="bg-white rounded-xl border border-gray-100 overflow-hidden mb-6">
    <div class="p-4">
        <form action="{{ route('admin.prodis.index') }}" method="GET" class="flex flex-col sm:flex-row gap-3">
            <select name="jurusan" class="rounded-lg border-gray-200 border px-3 py-2 text-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none bg-white">
                <option value="">Semua Jurusan</option>
                @foreach ($jurusans as $j)
                    <option value="{{ $j }}" {{ request('jurusan') === $j ? 'selected' : '' }}>{{ $j }}</option>
                @endforeach
            </select>
            <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded-lg text-sm font-semibold hover:bg-indigo-700 transition-colors">Filter</button>
            @if (request()->has('jurusan'))
                <a href="{{ route('admin.prodis.index') }}" class="text-gray-500 hover:text-gray-700 text-sm font-medium px-3 py-2">Reset</a>
            @endif
        </form>
    </div>
</div>

<div class="bg-white rounded-xl border border-gray-100 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead>
                <tr class="bg-gray-50 border-b border-gray-100">
                    <th class="text-left px-5 py-3 font-semibold text-gray-600">Nama Prodi</th>
                    <th class="text-left px-5 py-3 font-semibold text-gray-600">Jurusan</th>
                    <th class="text-center px-5 py-3 font-semibold text-gray-600">Status</th>
                    <th class="text-right px-5 py-3 font-semibold text-gray-600">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
                @forelse ($prodis as $prodi)
                <tr class="hover:bg-gray-50 transition-colors">
                    <td class="px-5 py-4">
                        <div class="font-semibold text-gray-900">{{ $prodi->name }}</div>
                    </td>
                    <td class="px-5 py-4">
                        <span class="inline-flex items-center px-2 py-0.5 rounded-md text-xs font-bold bg-indigo-50 text-indigo-700">{{ $prodi->jurusan }}</span>
                    </td>
                    <td class="px-5 py-4 text-center">
                        <form action="{{ route('admin.prodis.toggle', $prodi) }}" method="POST" class="inline">
                            @csrf
                            <button type="submit" class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-bold cursor-pointer transition-colors
                                {{ $prodi->is_active ? 'bg-green-100 text-green-700 hover:bg-green-200' : 'bg-red-100 text-red-700 hover:bg-red-200' }}">
                                <span class="w-1.5 h-1.5 rounded-full mr-1.5 {{ $prodi->is_active ? 'bg-green-500' : 'bg-red-500' }}"></span>
                                {{ $prodi->is_active ? 'Aktif' : 'Nonaktif' }}
                            </button>
                        </form>
                    </td>
                    <td class="px-5 py-4 text-right">
                        <div class="flex items-center justify-end gap-1">
                            <a href="{{ route('admin.prodis.edit', $prodi) }}" class="p-2 text-gray-400 hover:text-indigo-600 hover:bg-indigo-50 rounded-lg transition-colors" title="Edit">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" /></svg>
                            </a>
                            <form action="{{ route('admin.prodis.destroy', $prodi) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus prodi {{ $prodi->name }}?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="p-2 text-gray-400 hover:text-red-600 hover:bg-red-50 rounded-lg transition-colors" title="Hapus">
                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" /></svg>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="px-5 py-12 text-center">
                        <p class="text-gray-400">Belum ada data prodi. Klik "Tambah Prodi" untuk menambahkan.</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection

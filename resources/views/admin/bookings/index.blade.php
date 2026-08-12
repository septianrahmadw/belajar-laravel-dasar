@extends('admin.layouts.app')

@section('title', 'Manajemen Booking')
@section('header', 'Booking')

@section('actions')
<div class="flex items-center gap-2">
    <a href="{{ route('admin.bookings.export.pdf', request()->only(['search', 'date', 'status'])) }}" class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-sm font-semibold text-white bg-red-600 hover:bg-red-700 transition-colors">
        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m.75 12l3 3m0 0l3-3m-3 3v-6m-1.5-9H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" /></svg>
        PDF
    </a>
    <a href="{{ route('admin.bookings.export.csv', request()->only(['search', 'date', 'status'])) }}" class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-sm font-semibold text-white bg-green-600 hover:bg-green-700 transition-colors">
        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5M16.5 12L12 16.5m0 0L7.5 12m4.5 4.5V3" /></svg>
        CSV
    </a>
</div>
@endsection

@section('content')
<div class="bg-white rounded-xl border border-gray-100 overflow-hidden mb-6">
    <div class="p-4">
        <form action="{{ route('admin.bookings.index') }}" method="GET" class="flex flex-col sm:flex-row gap-3">
            <div class="flex-1 relative">
                <svg class="w-4 h-4 text-gray-400 absolute left-3.5 top-1/2 -translate-y-1/2" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" /></svg>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama, email, jurusan, mata kuliah, dosen..."
                       class="w-full rounded-lg border-gray-200 border pl-10 pr-4 py-2 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none">
            </div>
            <input type="date" name="date" value="{{ request('date') }}"
                   class="rounded-lg border-gray-200 border px-3 py-2 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none">
            <select name="status" class="rounded-lg border-gray-200 border px-3 py-2 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none bg-white">
                <option value="">Semua Status</option>
                <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>Menunggu</option>
                <option value="approved" {{ request('status') === 'approved' ? 'selected' : '' }}>Disetujui</option>
                <option value="rejected" {{ request('status') === 'rejected' ? 'selected' : '' }}>Ditolak</option>
                <option value="cancelled" {{ request('status') === 'cancelled' ? 'selected' : '' }}>Dibatalkan</option>
            </select>
            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-lg text-sm font-semibold hover:bg-blue-700 transition-colors">Filter</button>
            @if (request()->hasAny(['search', 'date', 'status']))
                <a href="{{ route('admin.bookings.index') }}" class="text-gray-500 hover:text-gray-700 text-sm font-medium px-3 py-2">Reset</a>
            @endif
        </form>
    </div>
</div>

<div class="bg-white rounded-xl border border-gray-100 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead>
                <tr class="bg-gray-50 border-b border-gray-100">
                    <th class="text-left px-5 py-3 font-semibold text-gray-600">Peminjam</th>
                    <th class="text-left px-5 py-3 font-semibold text-gray-600">Prodi</th>
                    <th class="text-left px-5 py-3 font-semibold text-gray-600">Ruangan</th>
                    <th class="text-left px-5 py-3 font-semibold text-gray-600">Tanggal</th>
                    <th class="text-left px-5 py-3 font-semibold text-gray-600">Waktu</th>
                    <th class="text-left px-5 py-3 font-semibold text-gray-600">Keperluan</th>
                    <th class="text-left px-5 py-3 font-semibold text-gray-600">Mata Kuliah</th>
                    <th class="text-center px-5 py-3 font-semibold text-gray-600">Status</th>
                    <th class="text-right px-5 py-3 font-semibold text-gray-600">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
                @forelse ($bookings as $booking)
                <tr class="hover:bg-gray-50 transition-colors">
                    <td class="px-5 py-4">
                        <div class="font-medium text-gray-900">{{ $booking->booker_name }}</div>
                        <p class="text-xs text-gray-400">{{ $booking->booker_email }}</p>
                        @if ($booking->is_recurring)
                        <span class="inline-flex items-center gap-1 mt-1 px-2 py-0.5 rounded-full text-[10px] font-bold bg-blue-100 text-blue-700">
                            <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 12c0-1.232-.046-2.453-.138-3.662a4.006 4.006 0 00-3.7-3.7 48.678 48.678 0 00-7.324 0 4.006 4.006 0 00-3.7 3.7c-.017.22-.032.441-.046.662M19.5 12l3-3m-3 3l-3-3m-12 3c0 1.232.046 2.453.138 3.662a4.006 4.006 0 003.7 3.7 48.656 48.656 0 007.324 0 4.006 4.006 0 003.7-3.7c.017-.22.032-.441.046-.662M4.5 12l3 3m-3-3l-3 3" /></svg>
                            Berulang
                        </span>
                        @endif
                    </td>
                    <td class="px-5 py-4">
                        <span class="text-gray-700">{{ $booking->prodi?->name ?? '-' }}</span>
                    </td>
                    <td class="px-5 py-4">
                        <span class="text-gray-700">{{ $booking->room->name }}</span>
                    </td>
                    <td class="px-5 py-4 text-gray-600">
                        {{ $booking->date->format('d M Y') }}
                    </td>
                    <td class="px-5 py-4">
                        <span class="font-mono text-gray-700">{{ $booking->formatted_start_time }} - {{ $booking->formatted_end_time }}</span>
                    </td>
                    <td class="px-5 py-4">
                        <span class="text-gray-700 line-clamp-1 max-w-[200px] block">{{ $booking->purpose }}</span>
                    </td>
                    <td class="px-5 py-4">
                        <span class="text-gray-700 line-clamp-1 max-w-[200px] block">{{ $booking->mata_kuliah ?? '-' }}</span>
                    </td>
                    <td class="px-5 py-4 text-center">
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[10px] font-bold uppercase tracking-wide
                            {{ $booking->status === 'approved' ? 'bg-green-100 text-green-700' :
                               ($booking->status === 'pending' ? 'bg-amber-100 text-amber-700' :
                               ($booking->status === 'rejected' ? 'bg-red-100 text-red-700' : 'bg-gray-100 text-gray-600')) }}">
                            {{ $booking->statusLabel }}
                        </span>
                    </td>
                    <td class="px-5 py-4 text-right">
                        <div class="flex items-center justify-end gap-1">
                            <a href="{{ route('admin.bookings.show', $booking) }}" class="p-2 text-gray-400 hover:text-blue-600 hover:bg-blue-50 rounded-lg transition-colors" title="Detail">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" /><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /></svg>
                            </a>
                            @if (in_array($booking->status, ['approved', 'pending']))
                            <a href="{{ route('admin.bookings.edit', $booking) }}" class="p-2 text-gray-400 hover:text-amber-600 hover:bg-amber-50 rounded-lg transition-colors" title="Edit / Pindahkan Jadwal">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M7.5 21L3 16.5m0 0L7.5 12M3 16.5h13.5m0-13.5L21 7.5m0 0L16.5 12M21 7.5H7.5" /></svg>
                            </a>
                            <form action="{{ route('admin.bookings.destroy', $booking) }}" method="POST" class="inline" onsubmit="return confirm('Yakin ingin membatalkan booking ini? Data tetap tersimpan dengan status dibatalkan.')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="p-2 text-gray-400 hover:text-orange-600 hover:bg-orange-50 rounded-lg transition-colors" title="Batalkan">
                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M9.75 9.75l4.5 4.5m0-4.5l-4.5 4.5M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                                </button>
                            </form>
                            @endif
                            <form action="{{ route('admin.bookings.force-destroy', $booking) }}" method="POST" class="inline" onsubmit="return confirm('Yakin ingin menghapus PERMANEN data booking ini? Tindakan ini tidak dapat dibatalkan.')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="p-2 text-gray-400 hover:text-red-600 hover:bg-red-50 rounded-lg transition-colors" title="Hapus Permanen">
                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" /></svg>
                                </button>
                            </form>
                            @if ($booking->status === 'pending')
                            <form action="{{ route('admin.bookings.approve', $booking) }}" method="POST" class="inline" @if ($booking->is_recurring) onsubmit="return confirm('Yakin ingin menyetujui SEMUA jadwal berulang ini? ({{ $booking->recurrenceCount }} jadwal)')" @endif>
                                @csrf
                                <button type="submit" class="p-2 text-gray-400 hover:text-green-600 hover:bg-green-50 rounded-lg transition-colors" title="Setujui">
                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                                </button>
                            </form>
                            @endif
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="9" class="px-5 py-12 text-center">
                        <p class="text-gray-400">Tidak ada data booking ditemukan.</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if ($bookings->hasPages())
    <div class="px-5 py-4 border-t border-gray-100">
        {{ $bookings->links() }}
    </div>
    @endif
</div>
@endsection

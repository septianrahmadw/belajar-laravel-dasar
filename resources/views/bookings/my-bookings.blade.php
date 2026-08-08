@extends('layouts.app')

@section('title', 'Booking Saya')

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="mb-8">
        <h1 class="text-2xl font-bold text-gray-900">Booking Saya</h1>
        <p class="text-sm text-gray-500 mt-1">Cek dan kelola peminjaman ruangan Anda secara aman</p>
    </div>

    @if (!($verified ?? false))
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6 mb-8">
            <form id="verify-send-form" action="{{ route('bookings.verify.send') }}" method="POST" class="flex flex-col sm:flex-row gap-3">
                @csrf
                <div class="flex-1">
                    <label for="email" class="block text-sm font-semibold text-gray-700 mb-1.5">Email yang digunakan saat booking</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                            <svg class="w-5 h-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-1.07 1.916l-7.5 4.615a2.25 2.25 0 01-2.36 0L3.32 8.91a2.25 2.25 0 01-1.07-1.916V6.75" /></svg>
                        </div>
                        <input type="email" name="email" id="email" value="{{ old('email', $pinEmail ?? '') }}" required
                               class="w-full rounded-xl border-gray-200 border pl-11 pr-4 py-2.5 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition-shadow"
                               placeholder="Masukkan email Anda">
                    </div>
                    @error('email')
                        <p class="text-xs text-red-600 mt-1.5">{{ $message }}</p>
                    @enderror
                </div>
                <div class="flex items-end">
                    <button id="verify-send-btn" type="submit" class="bg-blue-600 text-white px-6 py-2.5 rounded-xl font-semibold hover:bg-blue-700 transition-colors flex items-center gap-2 text-sm whitespace-nowrap">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-1.07 1.916l-7.5 4.615a2.25 2.25 0 01-2.36 0L3.32 8.91a2.25 2.25 0 01-1.07-1.916V6.75" /></svg>
                        Kirim Kode Verifikasi
                    </button>
                </div>
            </form>
        </div>

        @if ($pinEmail ?? null)
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6 mb-8">
            <h2 class="text-lg font-semibold text-gray-900 mb-1">Masukkan Kode Verifikasi</h2>
            <p class="text-sm text-gray-500 mb-5">Kode 6 digit telah dikirim ke <strong class="text-gray-700">{{ $pinEmail }}</strong>. Cek inbox atau folder spam.</p>

            <form id="verify-pin-form" action="{{ route('bookings.verify.pin') }}" method="POST" class="flex flex-col sm:flex-row gap-3">
                @csrf
                <input type="hidden" name="email" value="{{ $pinEmail }}">
                <div class="flex-1">
                    <div class="relative">
                        <input type="text" name="pin" id="pin" value="{{ old('pin') }}" required maxlength="6" inputmode="numeric" autocomplete="one-time-code"
                               class="w-full rounded-xl border-gray-200 border px-4 py-2.5 text-sm tracking-[0.5em] text-center text-lg font-bold focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition-shadow"
                               placeholder="••••••">
                    </div>
                    @error('pin')
                        <p class="text-xs text-red-600 mt-1.5">{{ $message }}</p>
                    @enderror
                    @error('rate_limit')
                        <p class="text-xs text-red-600 mt-1.5">{{ $message }}</p>
                    @enderror
                </div>
                <div class="flex items-end">
                    <button id="verify-pin-btn" type="submit" class="bg-blue-600 text-white px-6 py-2.5 rounded-xl font-semibold hover:bg-blue-700 transition-colors flex items-center gap-2 text-sm whitespace-nowrap">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                        Verifikasi
                    </button>
                </div>
            </form>

            <div class="mt-4 flex items-center gap-4 text-xs text-gray-500">
                <span>Kode berlaku 10 menit, 5x percobaan.</span>
                <a href="{{ route('bookings.my') }}?logout=1" class="text-blue-600 hover:text-blue-700 font-medium">Ganti email</a>
            </div>
        </div>
        @endif
    @else
        <div class="flex items-center justify-between mb-6 p-4 bg-white rounded-2xl border border-gray-100 shadow-sm">
            <p class="text-sm text-gray-600">
                Terverifikasi sebagai <strong class="text-gray-900">{{ $email }}</strong>
            </p>
            <a href="{{ route('bookings.my') }}?logout=1" class="text-xs text-red-600 hover:text-red-700 font-medium px-3 py-1.5 rounded-lg hover:bg-red-50 transition-colors whitespace-nowrap">
                Ganti email / Keluar
            </a>
        </div>

        @if ($bookings->isEmpty())
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-12 text-center">
            <svg class="w-16 h-16 text-gray-300 mx-auto mb-4" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5" /></svg>
            <h3 class="text-lg font-semibold text-gray-900 mb-1">Tidak ada booking ditemukan</h3>
            <p class="text-gray-500 text-sm mb-6">Belum ada peminjaman dengan email <strong>{{ $email }}</strong></p>
            <a href="{{ route('rooms.index') }}" class="inline-flex items-center gap-2 bg-blue-600 text-white px-5 py-2.5 rounded-xl font-semibold hover:bg-blue-700 transition-colors text-sm">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" /></svg>
                Booking Sekarang
            </a>
        </div>
        @else
        <div class="space-y-4">
            <p class="text-sm text-gray-500">Ditemukan <strong class="text-gray-900">{{ $bookings->count() }}</strong> booking</p>

            @foreach ($bookings as $booking)
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden hover:shadow-md transition-shadow">
                <div class="p-5">
                    <div class="flex flex-col sm:flex-row sm:items-start justify-between gap-4">
                        <div class="flex items-start gap-4">
                            <div class="w-12 h-12 rounded-xl flex items-center justify-center shrink-0 {{ $booking->status === 'approved' ? 'bg-green-100' : ($booking->status === 'pending' ? 'bg-amber-100' : ($booking->status === 'rejected' ? 'bg-red-100' : 'bg-gray-100')) }}">
                                @if ($booking->status === 'approved')
                                    <svg class="w-6 h-6 text-green-600" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                                @elseif ($booking->status === 'pending')
                                    <svg class="w-6 h-6 text-amber-600" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                                @elseif ($booking->status === 'rejected')
                                    <svg class="w-6 h-6 text-red-600" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M9.75 9.75l4.5 4.5m0-4.5l-4.5 4.5M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                                @else
                                    <svg class="w-6 h-6 text-gray-600" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636" /></svg>
                                @endif
                            </div>
                            <div>
                                <div class="flex items-center gap-2 mb-1">
                                    <h3 class="font-semibold text-gray-900">{{ $booking->purpose }}</h3>
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[11px] font-bold uppercase tracking-wide
                                        {{ $booking->status === 'approved' ? 'bg-green-100 text-green-700' :
                                           ($booking->status === 'pending' ? 'bg-amber-100 text-amber-700' :
                                           ($booking->status === 'rejected' ? 'bg-red-100 text-red-700' : 'bg-gray-100 text-gray-600')) }}">
                                        {{ $booking->statusLabel }}
                                    </span>
                                    @if ($booking->is_recurring)
                                    <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-[10px] font-bold bg-blue-100 text-blue-700">
                                        <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 12c0-1.232-.046-2.453-.138-3.662a4.006 4.006 0 00-3.7-3.7 48.678 48.678 0 00-7.324 0 4.006 4.006 0 00-3.7 3.7c-.017.22-.032.441-.046.662M19.5 12l3-3m-3 3l-3-3m-12 3c0 1.232.046 2.453.138 3.662a4.006 4.006 0 003.7 3.7 48.656 48.656 0 007.324 0 4.006 4.006 0 003.7-3.7c.017-.22.032-.441.046-.662M4.5 12l3 3m-3-3l-3 3" /></svg>
                                        Berulang ({{ $booking->recurrenceCount }}x)
                                    </span>
                                    @endif
                                </div>
                                <p class="text-sm text-gray-500">
                                    <span class="font-medium text-gray-700">{{ $booking->room->name }}</span>
                                    ({{ $booking->room->code }})
                                </p>
                                <div class="flex items-center gap-4 mt-2 text-xs text-gray-500">
                                    <span class="flex items-center gap-1">
                                        <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5" /></svg>
                                        {{ \Carbon\Carbon::parse($booking->date)->translatedFormat('d M Y') }}
                                    </span>
                                    <span class="flex items-center gap-1">
                                        <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                                        {{ $booking->formatted_start_time }} - {{ $booking->formatted_end_time }}
                                    </span>
                                </div>
                            </div>
                        </div>
                        @if (in_array($booking->status, ['pending', 'approved']))
                        <div class="flex flex-col gap-1.5 items-end">
                            @if ($booking->is_recurring)
                            <form action="{{ route('bookings.cancel-recurrence', $booking) }}" method="POST" onsubmit="return confirm('Yakin ingin membatalkan SEMUA jadwal berulang ini?')">
                                @csrf
                                <button type="submit" class="text-xs text-blue-600 hover:text-blue-700 font-medium px-3 py-1.5 rounded-lg hover:bg-blue-50 transition-colors flex items-center gap-1 whitespace-nowrap">
                                    <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 12c0-1.232-.046-2.453-.138-3.662a4.006 4.006 0 00-3.7-3.7 48.678 48.678 0 00-7.324 0 4.006 4.006 0 00-3.7 3.7c-.017.22-.032.441-.046.662M19.5 12l3-3m-3 3l-3-3m-12 3c0 1.232.046 2.453.138 3.662a4.006 4.006 0 003.7 3.7 48.656 48.656 0 007.324 0 4.006 4.006 0 003.7-3.7c.017-.22.032-.441.046-.662M4.5 12l3 3m-3-3l-3 3" /></svg>
                                    Batalkan Semua
                                </button>
                            </form>
                            @endif
                            <form action="{{ route('bookings.cancel', $booking) }}" method="POST" onsubmit="return confirm('Yakin ingin membatalkan booking ini saja?')">
                                @csrf
                                <button type="submit" class="text-sm text-red-600 hover:text-red-700 font-medium px-3 py-1.5 rounded-lg hover:bg-red-50 transition-colors flex items-center gap-1 whitespace-nowrap">
                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" /></svg>
                                    Batalkan
                                </button>
                            </form>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        @endif
    @endif
</div>
@endsection

@push('scripts')
<script>
(function () {
    const setupSpinner = (formId, btnId, loadingText) => {
        const form = document.getElementById(formId);
        const btn = document.getElementById(btnId);
        if (!form || !btn) return;

        form.addEventListener('submit', () => {
            if (btn.dataset.loading === '1') return;
            btn.dataset.loading = '1';
            btn.disabled = true;
            btn.classList.add('opacity-70', 'cursor-not-allowed');
            btn.innerHTML = `
                <svg class="w-4 h-4 animate-spin" viewBox="0 0 24 24" fill="none">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                ${loadingText}
            `;
        });
    };

    setupSpinner('verify-send-form', 'verify-send-btn', 'Mengirim...');
    setupSpinner('verify-pin-form', 'verify-pin-btn', 'Memverifikasi...');
})();
</script>
@endpush

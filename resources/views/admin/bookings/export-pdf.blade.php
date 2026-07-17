<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Booking - {{ now()->format('d M Y') }}</title>
    <style>
        body { font-family: sans-serif; font-size: 11px; color: #333; margin: 15px; }
        h1 { font-size: 16px; margin-bottom: 5px; }
        .meta { color: #666; font-size: 10px; margin-bottom: 15px; }
        table { width: 100%; border-collapse: collapse; margin-top: 8px; }
        th, td { border: 1px solid #ddd; padding: 4px 6px; text-align: left; }
        th { background: #4f46e5; color: #fff; font-size: 9px; text-transform: uppercase; }
        td { font-size: 9px; }
        tr:nth-child(even) { background: #f9fafb; }
        .status { padding: 2px 4px; border-radius: 8px; font-size: 8px; font-weight: bold; text-transform: uppercase; }
        .status-pending { background: #fef3c7; color: #92400e; }
        .status-approved { background: #d1fae5; color: #065f46; }
        .status-rejected { background: #fee2e2; color: #991b1b; }
        .status-cancelled { background: #e5e7eb; color: #374151; }
        .footer { margin-top: 15px; font-size: 9px; color: #999; text-align: center; }
    </style>
</head>
<body>
    <h1>Laporan Data Booking</h1>
    <div class="meta">
        Filter: @if($search) Pencarian "{{ $search }}" | @endif @if($date) Tanggal: {{ $date }} | @endif @if($status) Status: {{ ucfirst($status) }} | @endif
        Dicetak: {{ now()->format('d M Y, H:i') }}
    </div>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Peminjam</th>
                <th>Email</th>
                <th>Jurusan</th>
                <th>Prodi</th>
                <th>Keperluan</th>
                <th>Mata Kuliah</th>
                <th>Sem/Kelas</th>
                <th>Dosen</th>
                <th>Ruangan</th>
                <th>Tanggal</th>
                <th>Waktu</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @forelse($bookings as $i => $booking)
            <tr>
                <td>{{ $i + 1 }}</td>
                <td>{{ $booking->booker_name }}</td>
                <td>{{ $booking->booker_email }}</td>
                <td>{{ $booking->jurusan }}</td>
                <td>{{ $booking->prodi?->name ?? '-' }}</td>
                <td>{{ $booking->purpose }}</td>
                <td>{{ $booking->mata_kuliah }}</td>
                <td>S{{ $booking->semester }} / {{ $booking->kelas }}</td>
                <td>{{ $booking->dosen }}</td>
                <td>{{ $booking->room->name }}</td>
                <td>{{ $booking->date->format('d/m/Y') }}</td>
                <td>{{ $booking->formatted_start_time }} - {{ $booking->formatted_end_time }}</td>
                <td><span class="status status-{{ $booking->status }}">{{ $booking->statusLabel }}</span></td>
            </tr>
            @empty
            <tr>
                <td colspan="13" style="text-align: center;">Tidak ada data</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <div class="footer">LabBooking - Sistem Peminjaman Ruang Lab Komputer | {{ now()->year }}</div>
</body>
</html>

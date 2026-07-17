<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <style>
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background: #f4f5f7; margin: 0; padding: 20px; }
        .container { max-width: 600px; margin: 0 auto; background: #fff; border-radius: 12px; overflow: hidden; box-shadow: 0 2px 10px rgba(0,0,0,0.08); }
        .header { background: #4f46e5; color: #fff; padding: 24px 30px; }
        .header h1 { margin: 0; font-size: 20px; font-weight: 600; }
        .header p { margin: 4px 0 0; font-size: 13px; opacity: 0.85; }
        .body { padding: 30px; }
        .info-box { background: #f0f0ff; border-left: 4px solid #4f46e5; padding: 16px; border-radius: 0 8px 8px 0; margin-bottom: 20px; }
        .info-box p { margin: 4px 0; font-size: 13px; color: #333; }
        .info-box strong { color: #1e1b4b; }
        .detail { margin-bottom: 16px; }
        .detail h3 { font-size: 13px; text-transform: uppercase; color: #999; margin: 0 0 8px; letter-spacing: 0.5px; }
        .detail table { width: 100%; font-size: 13px; }
        .detail td { padding: 4px 0; color: #555; }
        .detail td:first-child { font-weight: 600; color: #333; width: 140px; }
        .badge { display: inline-block; padding: 4px 12px; border-radius: 20px; font-size: 12px; font-weight: 600; }
        .badge-pending { background: #fef3c7; color: #92400e; }
        .footer { background: #f9fafb; padding: 20px 30px; text-align: center; font-size: 11px; color: #999; border-top: 1px solid #eee; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Booking Berhasil Diajukan</h1>
            <p>Menunggu persetujuan admin</p>
        </div>
        <div class="body">
            <div class="info-box">
                <p>Halo <strong>{{ $booking->booker_name }}</strong>,</p>
                <p>Booking Anda untuk ruangan <strong>{{ $booking->room->name }}</strong> telah berhasil diajukan dan menunggu persetujuan admin.</p>
            </div>

            <div class="detail">
                <h3>Detail Booking</h3>
                <table>
                    <tr><td>Ruangan</td><td>{{ $booking->room->name }} ({{ $booking->room->code }})</td></tr>
                    <tr><td>Tanggal</td><td>{{ $booking->date->format('d M Y') }}</td></tr>
                    <tr><td>Waktu</td><td>{{ $booking->formatted_start_time }} - {{ $booking->formatted_end_time }}</td></tr>
                    <tr><td>Jurusan</td><td>{{ $booking->jurusan }}</td></tr>
                    <tr><td>Prodi</td><td>{{ $booking->prodi?->name ?? '-' }}</td></tr>
                    <tr><td>Keperluan</td><td>{{ $booking->purpose }}</td></tr>
                    <tr><td>Mata Kuliah</td><td>{{ $booking->mata_kuliah }}</td></tr>
                    <tr><td>Semester / Kelas</td><td>Semester {{ $booking->semester }} - Kelas {{ $booking->kelas }}</td></tr>
                    <tr><td>Dosen</td><td>{{ $booking->dosen }}</td></tr>
                    @if ($booking->teknisi)
                    <tr><td>Teknisi</td><td>{{ $booking->teknisi }}</td></tr>
                    @endif
                    <tr><td>Status</td><td><span class="badge badge-pending">Menunggu Persetujuan</span></td></tr>
                </table>
            </div>

            @if ($booking->notes)
            <div class="detail">
                <h3>Catatan</h3>
                <p style="font-size:13px;color:#555;background:#f9fafb;padding:10px;border-radius:6px;">{{ $booking->notes }}</p>
            </div>
            @endif
        </div>
        <div class="footer">
            Email ini dikirim otomatis oleh sistem LabBooking.<br>
            Mohon tidak membalas email ini.
        </div>
    </div>
</body>
</html>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <style>
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background: #f4f5f7; margin: 0; padding: 20px; }
        .container { max-width: 600px; margin: 0 auto; background: #fff; border-radius: 12px; overflow: hidden; box-shadow: 0 2px 10px rgba(0,0,0,0.08); }
        .header { padding: 24px 30px; color: #fff; }
        .header.approved { background: #059669; }
        .header.rejected { background: #dc2626; }
        .header.cancelled { background: #6b7280; }
        .header h1 { margin: 0; font-size: 20px; font-weight: 600; }
        .header p { margin: 4px 0 0; font-size: 13px; opacity: 0.85; }
        .body { padding: 30px; }
        .info-box { border-left: 4px solid; padding: 16px; border-radius: 0 8px 8px 0; margin-bottom: 20px; }
        .info-box.approved { background: #ecfdf5; border-color: #059669; }
        .info-box.rejected { background: #fef2f2; border-color: #dc2626; }
        .info-box.cancelled { background: #f3f4f6; border-color: #6b7280; }
        .info-box p { margin: 4px 0; font-size: 13px; color: #333; }
        .info-box strong { color: #1e1b4b; }
        .detail { margin-bottom: 16px; }
        .detail h3 { font-size: 13px; text-transform: uppercase; color: #999; margin: 0 0 8px; letter-spacing: 0.5px; }
        .detail table { width: 100%; font-size: 13px; }
        .detail td { padding: 4px 0; color: #555; }
        .detail td:first-child { font-weight: 600; color: #333; width: 140px; }
        .badge { display: inline-block; padding: 4px 12px; border-radius: 20px; font-size: 12px; font-weight: 600; }
        .badge-approved { background: #d1fae5; color: #065f46; }
        .badge-rejected { background: #fee2e2; color: #991b1b; }
        .badge-cancelled { background: #e5e7eb; color: #374151; }
        .footer { background: #f9fafb; padding: 20px 30px; text-align: center; font-size: 11px; color: #999; border-top: 1px solid #eee; }
    </style>
</head>
<body>
    @php
        $statusText = match($booking->status) {
            'approved' => 'Disetujui',
            'rejected' => 'Ditolak',
            'cancelled' => 'Dibatalkan',
            default => 'Diperbarui',
        };
        $messages = [
            'approved' => 'Booking Anda telah disetujui oleh admin. Anda dapat menggunakan ruangan sesuai jadwal yang telah ditentukan.',
            'rejected' => 'Maaf, booking Anda tidak dapat disetujui oleh admin. Silakan hubungi admin untuk informasi lebih lanjut.',
            'cancelled' => 'Booking Anda telah dibatalkan. Jika ada pertanyaan, silakan hubungi admin.',
        ];
    @endphp

    <div class="container">
        <div class="header {{ $booking->status }}">
            <h1>Booking {{ $statusText }}</h1>
            <p>{{ $booking->room->name }} - {{ $booking->date->format('d M Y') }}</p>
        </div>
        <div class="body">
            <div class="info-box {{ $booking->status }}">
                <p>Halo <strong>{{ $booking->booker_name }}</strong>,</p>
                <p>{{ $messages[$booking->status] }}</p>
            </div>

            <div class="detail">
                <h3>Detail Booking</h3>
                <table>
                    <tr><td>Ruangan</td><td>{{ $booking->room->name }} ({{ $booking->room->code }})</td></tr>
                    <tr><td>Lokasi</td><td>{{ $booking->room->location }}</td></tr>
                    <tr><td>Tanggal</td><td>{{ $booking->date->format('l, d M Y') }}</td></tr>
                    <tr><td>Waktu</td><td>{{ $booking->formatted_start_time }} - {{ $booking->formatted_end_time }}</td></tr>
                    <tr><td>Keperluan</td><td>{{ $booking->purpose }}</td></tr>
                    <tr><td>Status</td><td><span class="badge badge-{{ $booking->status }}">{{ $statusText }}</span></td></tr>
                </table>
            </div>
        </div>
        <div class="footer">
            Email ini dikirim otomatis oleh sistem LabBooking.<br>
            Mohon tidak membalas email ini.
        </div>
    </div>
</body>
</html>

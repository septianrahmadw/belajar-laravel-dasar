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
        .pin-box { background: #eef2ff; border: 2px dashed #4f46e5; border-radius: 12px; padding: 24px; text-align: center; margin: 20px 0; }
        .pin-box .label { font-size: 12px; text-transform: uppercase; letter-spacing: 1.5px; color: #6b7280; margin: 0 0 8px; }
        .pin-box .pin { font-size: 42px; font-weight: 700; letter-spacing: 12px; color: #1e1b4b; margin: 0; font-family: 'Courier New', monospace; }
        .pin-box .timer { font-size: 12px; color: #6b7280; margin: 12px 0 0; }
        .note { background: #f9fafb; border: 1px solid #e5e7eb; border-radius: 8px; padding: 12px; font-size: 12px; color: #666; margin-top: 16px; }
        .footer { background: #f9fafb; padding: 20px 30px; text-align: center; font-size: 11px; color: #999; border-top: 1px solid #eee; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Kode Verifikasi</h1>
            <p>Untuk mengakses Booking Saya</p>
        </div>
        <div class="body">
            <div class="info-box">
                <p>Halo,</p>
                <p>Kami menerima permintaan untuk mengakses daftar booking melalui email <strong>{{ $email }}</strong>.</p>
            </div>

            <div class="pin-box">
                <p class="label">Kode Verifikasi Anda</p>
                <p class="pin">{{ $pin }}</p>
                <p class="timer">Berlaku selama 10 menit</p>
            </div>

            <div class="note">
                <strong>Catatan keamanan:</strong> Kode ini hanya berlaku <strong>10 menit</strong>, hanya bisa dipakai <strong>satu kali</strong>, dan maksimal <strong>5 kali percobaan</strong>.<br><br>
                Jika Anda tidak merasa melakukan permintaan ini, abaikan email ini. Jangan bagikan kode ini kepada siapa pun.
            </div>
        </div>
        <div class="footer">
            Email ini dikirim otomatis oleh sistem LabBooking.<br>
            Mohon tidak membalas email ini.
        </div>
    </div>
</body>
</html>

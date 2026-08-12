# Cara Update Project ke Server Aapanel

---

## Setup Awal (Pertama Kali)

**1. Login ke server via SSH**
```bash
ssh septian@192.168.21.58
```

**2. Clone project**
```bash
git config --global --add safe.directory /www/wwwroot/labkom.test
sudo chown -R septian:septian /www/wwwroot
cd /www/wwwroot && git clone git@github.com:septianrahmadw/belajar-laravel-dasar.git labkom.test
```

**3. Install dependensi**
```bash
cd /www/wwwroot/labkom.test
composer install --no-dev --ignore-platform-req=ext-fileinfo
npm install
npm run build
```

**4. Setup environment**
```bash
cp .env.example .env
php artisan key:generate
# Edit .env: atur DB_DATABASE, DB_USERNAME, DB_PASSWORD, APP_URL
```

**5. Migrasi & seeder**
```bash
php artisan migrate
php artisan db:seed --class=ProdiSeeder
```

**6. Set permission**
```bash
sudo chown -R www:www /www/wwwroot/labkom.test
sudo chmod -R 755 /www/wwwroot/labkom.test
sudo chmod -R 775 /www/wwwroot/labkom.test/storage
sudo chmod -R 775 /www/wwwroot/labkom.test/bootstrap/cache
```

---

## Update Setelah Perubahan di Local (Setiap Kali)

### Di Komputer Lokal
```bash
git add .
git commit -m "pesan perubahan"
git push
```

### Di Server
```bash
ssh septian@192.168.21.58
```

```bash
git config --global --add safe.directory /www/wwwroot/labkom.test
cd /www/wwwroot/labkom.test
sudo git pull
composer install --no-dev --ignore-platform-req=ext-fileinfo
sudo npm run build
php artisan migrate
```

> Jika ada error permission, jalankan ulang:
> ```bash
> sudo chown -R septian:septian /www/wwwroot/labkom.test/storage /www/wwwroot/labkom.test/bootstrap/cache
> sudo chmod -R 775 /www/wwwroot/labkom.test/storage /www/wwwroot/labkom.test/bootstrap/cache
> ```

---

## Informasi Server

| Item | Detail |
|------|--------|
| IP Lokal | 192.168.21.58 |
| Tailscale | 100.106.184.58 |
| Domain | jadwal.labsfs.my.id |
| User SSH | septian |
| Directory | /www/wwwroot/labkom.test |
| Database | labkom |
| Repo | git@github.com:septianrahmadw/belajar-laravel-dasar.git |

---

## Email & Queue Worker

Email (notifikasi booking & PIN verifikasi) dikirim lewat antrian database (`QUEUE_CONNECTION=database`).
Tanpa worker, email hanya menumpuk di tabel `jobs` dan **tidak pernah terkirim**.

### Di Lokal (Development)
Jalankan worker bersamaan dengan server:
```bash
composer run dev   # otomatis: serve + queue:listen + npm run dev
```
Atau buka terminal kedua:
```bash
php artisan queue:listen --tries=3 --timeout=60
```

### Di Server (aaPanel / cPanel)
Proses antrian otomatis setiap menit lewat scheduler. Tambahkan **Cron Job**:

aaPanel:
```
* * * * * /www/server/php/83/bin/php /www/wwwroot/labkom.test/artisan schedule:run >> /dev/null 2>&1
```
> Sesuaikan versi PHP (mis. `php/83`) dan path project.

cPanel (Cron Jobs → Add New Cron Job):
```
* * * * * /usr/local/bin/php /home/USER/path/labkom.test/artisan schedule:run >/dev/null 2>&1
```
> Sesuaikan path php dan project.

Scheduler ini memproses semua job yang ada lalu berhenti (terdaftar di `routes/console.php`), jadi aman untuk shared hosting tanpa daemon.

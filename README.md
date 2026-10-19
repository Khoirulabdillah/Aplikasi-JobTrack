# JobTrack

JobTrack adalah aplikasi manajemen lamaran kerja berbasis Laravel untuk mencatat, memantau, dan mengelola proses lamaran kerja pribadi dalam satu workspace tanpa autentikasi.

## Fitur utama

- Dashboard statistik lamaran kerja real-time
- CRUD lamaran kerja
- Status lamaran: Dikirim, Ditinjau, Diterima, Ditolak
- Riwayat perubahan status dan timeline
- Pencarian, filter, sort, dan paginasi
- Kalender follow-up dan reminder
- Antarmuka responsif dengan Tailwind CSS

## Persyaratan

- PHP 8.3+
- Composer
- MySQL 8+
- Node.js 18+
- NPM

## Instalasi

1. Clone repositori.
2. Salin file `.env.example` menjadi `.env`.
3. Sesuaikan konfigurasi database MySQL pada `.env`.
4. Jalankan perintah:

```bash
composer install
npm install
php artisan key:generate
php artisan migrate
php artisan db:seed
npm run build
```

## Konfigurasi database MySQL

Contoh konfigurasi yang umum digunakan:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=jobtrack
DB_USERNAME=root
DB_PASSWORD=
```

Pastikan database `jobtrack` sudah dibuat di MySQL sebelumnya.

## Menjalankan aplikasi

```bash
php artisan serve
```

Aplikasi akan tersedia di:

```text
http://localhost:8000
```

## Menjalankan test

```bash
php artisan test
```

## Catatan keamanan

Aplikasi ini dirancang untuk satu workspace pribadi tanpa login, sehingga data lamaran akan langsung terlihat bagi siapa pun yang dapat mengakses URL aplikasi. Pastikan deployment dilakukan di lingkungan yang terbatas atau privat.

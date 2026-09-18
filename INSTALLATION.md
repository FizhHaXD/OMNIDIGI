# Panduan Instalasi dan Menjalankan Proyek

Dokumen ini menjelaskan langkah-langkah instalasi, konfigurasi environment, migrasi database, dan cara menjalankan aplikasi OMNIDIGI di lingkungan lokal.

---

## 1. Prasyarat Sistem

Pastikan sistem telah memenuhi persyaratan berikut sebelum melakukan instalasi:

- **PHP**: Versi 8.2 atau 8.4 (dengan ekstensi `pdo`, `sqlite3` atau `pdo_mysql`, `mbstring`, `openssl`, `curl`)
- **Composer**: Versi 2.x
- **Node.js**: Versi 18.x / 20.x atau lebih baru, beserta NPM
- **Database**: SQLite (default) atau MySQL 5.7 / 8.0
- **Git**: Versi terbaru

---

## 2. Langkah-Langkah Instalasi

### Langkah 1: Kloning Repositori
```bash
git clone https://github.com/FizhHaXD/OMNIDIGI.git
cd OMNIDIGI
```

### Langkah 2: Instal Dependensi PHP
```bash
composer install
```

### Langkah 3: Instal Dependensi Node.js
```bash
npm install
```

### Langkah 4: Konfigurasi File Environment
Salin file `.env.example` ke `.env`:

Untuk Windows PowerShell:
```powershell
copy .env.example .env
```

Untuk Linux / macOS / Git Bash:
```bash
cp .env.example .env
```

### Langkah 5: Generate Application Key
```bash
php artisan key:generate
```

### Langkah 6: Konfigurasi Database

#### Opsi 1: Menggunakan SQLite (Default)
Secara default, Laravel dikonfigurasi menggunakan SQLite. Pastikan pengaturan di file `.env`:

```env
DB_CONNECTION=sqlite
```

#### Opsi 2: Menggunakan MySQL
Buat database baru bernama `plndigi` pada server MySQL Anda, kemudian sesuaikan parameter di file `.env`:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=plndigi
DB_USERNAME=root
DB_PASSWORD=
```

### Langkah 7: Eksekusi Migrasi dan Seeder
Jalankan perintah berikut untuk membuat struktur tabel dan mengisi data awal:

```bash
php artisan migrate:fresh --seed
```

Data awal mencakup akun admin, akun user pengujian, master tarif, metode pembayaran, pelanggan, dan transaksi contoh.

### Langkah 8: Konfigurasi Storage Link
```bash
php artisan storage:link
```

### Langkah 9: Build Asset Frontend
Untuk mode pengembangan:
```bash
npm run dev
```

Atau untuk build file produksi:
```bash
npm run build
```

### Langkah 10: Jalankan Server Laravel
Buka terminal baru dan jalankan:
```bash
php artisan serve
```

Aplikasi dapat diakses melalui browser di alamat: `http://127.0.0.1:8000`

---

## 3. Informasi Akun Demo

| Role | Email | Password | URL Akses |
|---|---|---|---|
| Administrator | `admin@plndigi.com` | `password` | `http://127.0.0.1:8000/admin` |
| Pengguna | `hafizh@mail.com` | `password` | `http://127.0.0.1:8000/dashboard` |

---

## 4. Troubleshooting

### Kasus 1: "No application encryption key has been specified"
Jalankan perintah:
```bash
php artisan key:generate
```

### Kasus 2: "Vite manifest not found"
Jalankan perintah build frontend:
```bash
npm run build
```

### Kasus 3: "Database table not found"
Jalankan ulang migrasi dan seeder:
```bash
php artisan migrate:fresh --seed
```

### Kasus 4: Permission Denied pada direktori storage (Linux / macOS)
Berikan hak akses tulis:
```bash
chmod -R 775 storage bootstrap/cache
```

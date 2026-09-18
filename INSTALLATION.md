# 🛠️ Panduan Instalasi & Menjalankan OMNIDIGI (PLN DIGI)

Panduan ini berisi instruksi lengkap langkah demi langkah untuk mengkloning, mengonfigurasi, dan menjalankan aplikasi **OMNIDIGI** di lingkungan lokal (*Local Development Environment*).

---

## 📋 1. Prasyarat Sistem (*Prerequisites*)

Pastikan perangkat Anda telah terpasang perangkat lunak berikut sebelum memulai:

| Perangkat Lunak | Versi Minimal | Keterangan |
|---|---|---|
| **PHP** | `^8.2` atau `^8.4` | Direkomendasikan PHP 8.4 dengan ekstensi: `pdo`, `sqlite3` / `pdo_mysql`, `mbstring`, `openssl`, `curl` |
| **Composer** | `v2.x` | Dependency manager untuk PHP |
| **Node.js & NPM** | `Node >= 18.x` / `NPM >= 9.x` | Untuk kompilasi aset frontend (Vite & Tailwind CSS) |
| **Database** | **SQLite** (Bawaan) atau **MySQL** `5.7+` / `8.0+` | SQLite tidak memerlukan instalasi server tambahan |
| **Git** | Versi terbaru | Untuk kontrol versi |

---

## ⚙️ 2. Langkah-Langkah Instalasi

### Langkah 1: Kloning Repositori
Buka terminal (Git Bash, Command Prompt, atau PowerShell) dan jalankan:

```bash
git clone https://github.com/FizhHaXD/OMNIDIGI.git
cd OMNIDIGI
```

---

### Langkah 2: Pasang Dependensi Backend (Composer)
Unduh seluruh pustaka dan *package* PHP yang dibutuhkan Laravel:

```bash
composer install
```

---

### Langkah 3: Pasang Dependensi Frontend (NPM)
Unduh seluruh dependensi JavaScript dan CSS:

```bash
npm install
```

---

### Langkah 4: Konfigurasi File Environment (`.env`)
Salin file `.env.example` menjadi `.env`:

```bash
# Windows PowerShell
copy .env.example .env

# Linux / macOS / Git Bash
cp .env.example .env
```

---

### Langkah 5: Generate Application Key
Buat kunci enkripsi unik untuk aplikasi:

```bash
php artisan key:generate
```

---

### Langkah 6: Konfigurasi Database

Pilih salah satu metode database di bawah ini:

#### 🔹 Pilihan A: Menggunakan SQLite (Paling Cepat & Mudah — Direkomendasikan)
Secara default, Laravel sudah dikonfigurasi menggunakan SQLite. Jika file database belum ada, Anda bisa membuatnya secara otomatis:

Pastikan konfigurasi di file `.env`:
```env
DB_CONNECTION=sqlite
# DB_HOST, DB_PORT, DB_DATABASE, DB_USERNAME, DB_PASSWORD biarkan dikomentari / kosong
```

Jika diminta membuat file `database.sqlite` saat migrasi, tekan `yes`.

#### 🔹 Pilihan B: Menggunakan MySQL (XAMPP / Laragon / Native MySQL)
1. Buka MySQL server Anda dan buat database baru bernama `plndigi` atau `omnidigi`.
2. Buka file `.env` dan sesuaikan konfigurasi database:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=plndigi
DB_USERNAME=root
DB_PASSWORD=
```

---

### Langkah 7: Jalankan Migrasi & Database Seeder
Jalankan migrasi tabel sekaligus mengisi data awal (pengguna demo, tarif listrik, pelanggan, tagihan, berita, dan laporan gangguan):

```bash
php artisan migrate:fresh --seed
```

> **Data yang Dihasilkan Seeder:**
> - Akun Admin & Akun Pengguna Demo
> - Kategori & Daftar Tarif Listrik (Rumah Tangga, Bisnis, Industri, Sosial)
> - Metode Pembayaran (QRIS, E-Wallet, Transfer Bank)
> - Data Pelanggan, Meter Reading, Tagihan (*Bills*), Transaksi, & Berita

---

### Langkah 8: Hubungkan Storage Public
Pastikan direktori storage terhubung ke direktori publik untuk aset berkas:

```bash
php artisan storage:link
```

---

### Langkah 9: Kompilasi Aset Frontend

Jalankan server Vite untuk mode pengembangan (*development mode*):

```bash
npm run dev
```

*Atau jika ingin membuat bundle produksi siap pakai tanpa perlu menjalankan Vite terus-menerus:*

```bash
npm run build
```

---

### Langkah 10: Jalankan Server Lokal Laravel

Buka tab terminal baru dan jalankan server pengembangan Laravel:

```bash
php artisan serve
```

Aplikasi sekarang siap diakses melalui browser pada alamat:  
👉 **[http://127.0.0.1:8000](http://127.0.0.1:8000)** atau **[http://localhost:8000](http://localhost:8000)**

---

## 🔐 3. Kredensial Akun untuk Pengujian

Setelah menjalankan `php artisan migrate:fresh --seed`, Anda dapat langsung login menggunakan akun berikut:

### 👤 Akun Administrator
- **URL Login**: `http://127.0.0.1:8000/login`
- **Email**: `admin@plndigi.com`
- **Password**: `password`
- **Akses**: Menu Backoffice Administrator (`/admin`), Manajemen Pelanggan, Monitoring Transaksi.

### 👥 Akun Pelanggan (User)
- **Email**: `hafizh@mail.com`
- **Password**: `password`
- **Akses**: Dashboard Pelanggan, Pembayaran Tagihan, Beli Token, Catat Meter Mandiri, Lapor Gangguan, PLN Reward.

---

## ⚡ 4. Perintah Cepat (*Quick Command Reference*)

| Perintah | Fungsi |
|---|---|
| `php artisan serve` | Menjalankan web server lokal Laravel |
| `npm run dev` | Menjalankan Vite live-reload watcher untuk Tailwind & JS |
| `npm run build` | Melakukan build bundle aset frontend untuk produksi |
| `php artisan migrate:fresh --seed` | Me-reset seluruh tabel dan mengisi ulang data dummy |
| `php artisan optimize:clear` | Membersihkan cache konfigurasi, route, dan view |

---

## ❓ 5. Pemecahan Masalah (*Troubleshooting*)

### 1. `No application encryption key has been specified`
**Solusi**: Jalankan perintah `php artisan key:generate`.

### 2. `Vite manifest not found at: .../public/build/manifest.json`
**Solusi**: Jalankan `npm run build` sekali untuk menghasilkan bundle aset produksi, atau pastikan `npm run dev` sedang aktif di terminal.

### 3. `General error: 1 no such table`
**Solusi**: Skema database belum termigrasi. Jalankan `php artisan migrate:fresh --seed`.

### 4. `The stream or file ".../storage/logs/laravel.log" could not be opened: failed to open stream: Permission denied` (Linux/macOS)
**Solusi**: Berikan izin akses tulis ke folder storage:
```bash
chmod -R 775 storage bootstrap/cache
```

---

*Selamat menggunakan **OMNIDIGI**! Jika mengalami kendala lainnya, silakan buat tiket isu di repositori ini.*

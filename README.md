# OMNIDIGI (PLN DIGI)

Aplikasi web layanan kelistrikan digital terpadu berbasis Laravel. Platform ini menyediakan sistem self-service bagi pelanggan PLN untuk mengelola transaksi listrik, monitoring pemakaian, pencatatan meter mandiri, dan pelaporan gangguan.

---

## Daftar Isi
- [Gambaran Proyek](#gambaran-proyek)
- [Fitur Utama](#fitur-utama)
- [Teknologi yang Digunakan](#teknologi-yang-digunakan)
- [Struktur Direktori](#struktur-direktori)
- [Akun Demo](#akun-demo)
- [Instalasi dan Menjalankan Proyek](#instalasi-dan-menjalankan-proyek)
- [Dokumentasi Terkait](#dokumentasi-terkait)
- [Lisensi](#lisensi)

---

## Gambaran Proyek

OMNIDIGI dikembangkan untuk memfasilitasi kebutuhan operasional dan administrasi kelistrikan secara digital. Sistem ini mencakup layanan pelanggan (front-office) dan panel administrasi (backoffice) untuk memantau data pelanggan, riwayat transaksi, dan laporan operasional.

---

## Fitur Utama

### 1. Layanan Produk & Pembayaran
- **Tagihan Listrik Pascabayar**: Pengecekan tagihan berdasarkan ID Pelanggan, rincian penggunaan daya (kWh), biaya beban, denda keterlambatan, dan status pembayaran.
- **Token Listrik Prabayar**: Pembelian token listrik prabayar dengan nominal fleksibel (Rp 20.000 hingga Rp 1.000.000) dan generate 20 digit nomor token listrik.
- **Simulasi Pembayaran**: Mendukung simulasi channel pembayaran QRIS, e-wallet (GoPay, OVO, DANA), dan transfer bank (BCA, Mandiri, BNI).

### 2. Catat Meter Mandiri (Self-Metering) & Monitoring
- **Input Angka Meter Mandiri**: Pelanggan dapat memasukkan angka stand meteran secara berkala untuk keperluan verifikasi dan estimasi tagihan.
- **Monitoring Konsumsi Energi**: Rekapitulasi pemakaian listrik bulanan dan riwayat konsumsi kWh.

### 3. Pelaporan Gangguan Listrik (Outage Report)
- **Pelaporan Insiden**: Form pelaporan pemadaman listrik, kendala tegangan, atau kerusakan fisik meteran.
- **Pelacakan Status**: Monitoring progres tiket aduan dari status dilaporkan, diproses, hingga selesai.

### 4. Simulasi Pasang Baru & Perubahan Daya
- **Kalkulator Tarif Listrik**: Perhitungan estimasi biaya pasang baru atau tambah daya berdasarkan kategori tarif (Rumah Tangga, Bisnis, Industri, Sosial) dan kapasitas daya VA.

### 5. PLN Reward & Program Loyalitas
- **Akumulasi Poin**: Sistem poin dari transaksi pembayaran dan pencatatan meter.
- **Penukaran Reward**: Katalog penukaran poin untuk voucher diskon token listrik dan merchandise.

### 6. Berita & Informasi Pemeliharaan
- Publikasi artikel edukasi efisiensi energi, informasi pemadaman terjadwal, dan promo.

### 7. Panel Administrasi Backoffice
- **Manajemen Data Pelanggan**: Pengelolaan data master pelanggan (CRUD).
- **Monitoring Transaksi**: Rekapitulasi dan audit status transaksi pembayaran tagihan dan pembelian token.
- **Dashboard Analitik**: Ringkasan statistik operasional, pendapatan, dan status tiket gangguan.

---

## Teknologi yang Digunakan

- **Backend**: PHP 8.4, Laravel 13
- **Frontend**: Blade Template, Tailwind CSS, Vite, JavaScript
- **Database**: SQLite / MySQL (Skema relasional 3NF)
- **Autentikasi**: Laravel Breeze (Role: `admin` dan `user`)

---

## Struktur Direktori

```text
OMNIDIGI/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── Admin/          # Controller backoffice admin
│   │   │   ├── DashboardController.php
│   │   │   ├── HomeController.php
│   │   │   ├── NewsController.php
│   │   │   ├── OutageController.php
│   │   │   ├── ProdukController.php
│   │   │   ├── RewardController.php
│   │   │   └── SimulasiController.php
│   │   └── Middleware/         # AdminMiddleware (Role Protection)
│   └── Models/                 # Eloquent Models
├── database/
│   ├── migrations/             # Skema migrasi database
│   └── seeders/                # Database seeder untuk data awal
├── resources/
│   ├── css/                    # Tailwind CSS configuration & custom styles
│   └── views/                  # Blade templates (Admin, Dashboard, Produk, Layouts)
├── routes/
│   ├── web.php                 # Rute publik, user, dan admin
│   └── auth.php                # Rute autentikasi
├── DATABASE_ERD.md             # Dokumentasi Entity Relationship Diagram
├── INSTALLATION.md             # Panduan instalasi dan deployment
└── README.md
```

---

## Akun Demo

Untuk keperluan pengujian, database seeder telah menyediakan akun berikut:

| Role | Email | Password | Akses |
|---|---|---|---|
| Admin | `admin@plndigi.com` | `password` | Panel Admin (`/admin`) |
| User | `hafizh@mail.com` | `password` | Dashboard Pelanggan (`/dashboard`) |

Contoh ID Pelanggan untuk pengujian:
- `531200012345` (Rumah Tangga R1/1300 VA)
- `531200026789` (Rumah Tangga R1/2200 VA)
- `531200043344` (Bisnis B1/6600 VA)

---

## Instalasi dan Menjalankan Proyek

Panduan langkah demi langkah tersedia pada file [INSTALLATION.md](INSTALLATION.md).

Ringkasan perintah untuk menjalankan proyek:

```bash
git clone https://github.com/FizhHaXD/OMNIDIGI.git
cd OMNIDIGI
composer install
npm install
cp .env.example .env
php artisan key:generate
php artisan migrate:fresh --seed
npm run build
php artisan serve
```

---

## Dokumentasi Terkait

- [Panduan Instalasi Lengkap (INSTALLATION.md)](INSTALLATION.md)
- [Dokumentasi Database & ERD (DATABASE_ERD.md)](DATABASE_ERD.md)

---

## Lisensi

Proyek ini dirilis di bawah lisensi [MIT](LICENSE).

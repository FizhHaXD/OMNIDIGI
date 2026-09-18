# OMNIDIGI

Aplikasi web portal layanan kelistrikan digital terpadu berbasis Laravel 13 dan Tailwind CSS. Platform ini dirancang untuk memudahkan pelanggan dalam melakukan transaksi kelistrikan (pembayaran tagihan pascabayar dan pembelian token prabayar), pencatatan meter mandiri (*self-metering*), pelaporan gangguan (*outage report*), kalkulator simulasi tarif, serta menyediakan panel backoffice CRM untuk manajemen pelanggan dan audit transaksi.

---

## Daftar Isi

1. [Arsitektur Sistem](#arsitektur-sistem)
2. [Modul dan Fitur](#modul-dan-fitur)
3. [Daftar Rute & Endpoint](#daftar-rute--endpoint)
4. [Tech Stack](#tech-stack)
5. [Struktur Direktori](#struktur-direktori)
6. [Data Uji & Akun Demo](#data-uji--akun-demo)
7. [Panduan Cepat Menjalankan Proyek](#panduan-cepat-menjalankan-proyek)
8. [Dokumentasi Lanjutan](#dokumentasi-lanjutan)
9. [Lisensi](#lisensi)

---

## Arsitektur Sistem

Aplikasi dibangun dengan pola arsitektur **Model-View-Controller (MVC)** pada Laravel, memisahkan modul publik, dashboard pelanggan terautentikasi, dan panel backoffice admin.

```text
+-----------------------------------------------------------------------+
|                             OMNIDIGI WEB                              |
+-----------------------------------+-----------------------------------+
|            Klien Publik           |       Pelanggan Terdaftar         |
|  - Cek Tagihan & Beli Token       |  - Riwayat Tagihan & Pembayaran   |
|  - Simulasi Pasang Baru           |  - Self-Metering & Monitoring     |
|  - Portal Berita & Informasi      |  - Tiket Pelaporan Gangguan       |
|                                   |  - PLN Reward Poin                |
+-----------------------------------+-----------------------------------+
                                    |
                                    v
+-----------------------------------------------------------------------+
|                      BACKEND LAYER (LARAVEL 13)                       |
|  - Authentication & Role Middleware (admin / user)                    |
|  - Business Logic Controllers (Produk, Dashboard, Outage, Admin CRM)  |
|  - Eloquent ORM & Query Scopes                                        |
+-----------------------------------------------------------------------+
                                    |
                                    v
+-----------------------------------------------------------------------+
|                    DATABASE LAYER (3NF NORMALIZED)                    |
|  users | customers | tariffs | meter_readings | bills | transactions   |
+-----------------------------------------------------------------------+
```

---

## Modul dan Fitur

### 1. Transaksi Kelistrikan
* **Pembayaran Tagihan Pascabayar**: Cek detail tagihan bulanan menggunakan ID Pelanggan, menampilkan rincian stand meter, daya (VA), pemakaian kWh, tarif per kWh, biaya admin, serta status tunggakan atau denda.
* **Pembelian Token Prabayar**: Pemilihan nominal token listrik (Rp 20.000 s/d Rp 1.000.000) dengan generate otomatis nomor token 20 digit unik.
* **Channel Pembayaran**: Simulasi transaksi instan melalui QRIS, E-Wallet (GoPay, OVO, DANA), dan Virtual Account (BCA, Mandiri, BNI).

### 2. Layanan Mandiri (Self-Service)
* **Catat Meter Mandiri (*Self-Metering*)**: Form pelaporan angka stand meteran mandiri oleh pelanggan untuk transparansi tagihan bulanan.
* **Monitoring Konsumsi**: Visualisasi riwayat penggunaan daya listrik dan grafik konsumsi kWh dari bulan ke bulan.
* **Kalkulator Simulasi Tarif**: Perhitungan estimasi biaya pemasangan baru atau tambah daya berdasarkan kategori tarif (Rumah Tangga, Bisnis, Industri, Sosial) dan besaran daya VA.

### 3. Layanan Pengaduan & Informasi
* **Pelaporan Gangguan (*Outage Report*)**: Input laporan pemadaman, tegangan tidak stabil, atau kerusakan meteran dengan riwayat pelacakan status penanganan (*Dilaporkan*, *Diproses*, *Selesai*).
* **Portal Berita & Edukasi**: Artikel tips efisiensi energi listrik rumah tangga, informasi promo cashback, dan jadwal pemeliharaan jaringan terencana.
* **PLN Reward**: Sistem loyalitas poin dari setiap aktivitas pembayaran tagihan yang dapat ditukarkan dengan voucher diskon listrik.

### 4. Backoffice CRM & Manajemen Data (Admin)
* **Manajemen Pelanggan**: Pencarian, penambahan, edit, dan audit data pelanggan beserta golongan tarif dan daya.
* **Monitoring Transaksi**: Rekapitulasi seluruh arus transaksi pembayaran tagihan dan pembelian token secara real-time.

---

## Daftar Rute & Endpoint

| Modul | Endpoint | Method | Hak Akses | Deskripsi |
|---|---|---|---|---|
| **Beranda** | `/` | `GET` | Publik | Landing page dan pengenalan layanan |
| **Produk** | `/produk` | `GET` | Publik | Menu utama produk kelistrikan |
| **Tagihan** | `/produk/tagihan` | `GET`, `POST` | Publik | Cek tagihan pascabayar per ID Pelanggan |
| **Token** | `/produk/token` | `GET` | Publik | Form pembelian token listrik |
| **Simulasi** | `/simulasi` | `GET`, `POST` | Publik | Kalkulator estimasi biaya pasang baru |
| **Berita** | `/news` | `GET` | Publik | Daftar berita dan tips kelistrikan |
| **Dashboard** | `/dashboard` | `GET` | Auth (User) | Rangkuman status akun, tagihan, & poin |
| **Self-Metering**| `/dashboard/metering` | `GET`, `POST` | Auth (User) | Catat angka stand meteran mandiri |
| **Gangguan** | `/dashboard/outage` | `GET`, `POST` | Auth (User) | Form dan daftar tiket pengaduan gangguan |
| **Reward** | `/dashboard/reward` | `GET` | Auth (User) | Katalog penukaran poin loyalitas |
| **Admin CRM** | `/admin` | `GET` | Auth (Admin) | Dashboard statistik & ringkasan operasional |
| **Admin Data**| `/admin/customers` | `GET`, `POST`, `PUT`, `DELETE` | Auth (Admin) | Manajemen data master pelanggan |
| **Admin Transaksi**| `/admin/transactions` | `GET` | Auth (Admin) | Log dan monitoring seluruh transaksi |

---

## Tech Stack

* **Server-side**: PHP 8.4
* **Framework**: Laravel 13
* **Frontend**: Blade Templating, Tailwind CSS 3.4, Alpine.js / Vanilla JS
* **Build Tool**: Vite 6
* **Database**: SQLite (default) / MySQL 8.0+
* **Autentikasi**: Laravel Breeze (Role-Based Middleware)

---

## Struktur Direktori

```text
OMNIDIGI/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── Admin/                  # Controller panel administrasi backoffice
│   │   │   ├── DashboardController.php # Dashboard user, self-metering, monitoring
│   │   │   ├── HomeController.php      # Landing page publik
│   │   │   ├── NewsController.php      # Modul berita & artikel
│   │   │   ├── OutageController.php    # Modul pelaporan gangguan
│   │   │   ├── ProdukController.php    # Transaksi tagihan & token
│   │   │   ├── RewardController.php    # Modul PLN reward
│   │   │   └── SimulasiController.php  # Modul kalkulator tarif pasang baru
│   │   └── Middleware/
│   │       └── AdminMiddleware.php     # Proteksi rute backoffice admin
│   └── Models/                         # Model Eloquent (Customer, Bill, Transaction, dll)
├── database/
│   ├── migrations/                     # File migrasi skema tabel
│   └── seeders/                        # Seeder data awal & akun demo
├── resources/
│   ├── css/app.css                     # Custom styling & utility classes
│   ├── js/app.js                       # Script inisialisasi frontend
│   └── views/                          # Blade view templates
├── routes/
│   ├── web.php                         # Definisi rute aplikasi
│   └── auth.php                        # Rute autentikasi Breeze
├── DATABASE_ERD.md                     # Dokumentasi skema relasi database (3NF)
├── INSTALLATION.md                     # Panduan setup & deployment lokal
└── README.md                           # Dokumentasi utama proyek
```

---

## Data Uji & Akun Demo

Database seeder telah menyediakan data awal yang siap digunakan untuk keperluan demo atau pengujian:

### 1. Akun Pengguna

| Role | Email | Password | Akses URL |
|---|---|---|---|
| **Admin** | `admin@plndigi.com` | `password` | `/admin` |
| **User (Pelanggan)** | `hafizh@mail.com` | `password` | `/dashboard` |

### 2. Contoh ID Pelanggan untuk Pengujian Transaksi

| ID Pelanggan | Nama | Golongan Tarif | Daya | Status Tagihan Contoh |
|---|---|---|---|---|
| `531200012345` | Hafizh Wijdan | R1 (Rumah Tangga) | 1300 VA | Memiliki tagihan berjalan |
| `531200026789` | Budi Santoso | R1 (Rumah Tangga) | 2200 VA | Memiliki tagihan berjalan |
| `531200031122` | Siti Rahayu | R1 (Rumah Tangga) | 900 VA | Lunas |
| `531200043344` | Ahmad Fauzi | B1 (Bisnis) | 6600 VA | Menunggak + denda |

---

## Panduan Cepat Menjalankan Proyek

```bash
# 1. Clone repositori
git clone https://github.com/FizhHaXD/OMNIDIGI.git
cd OMNIDIGI

# 2. Install dependensi backend dan frontend
composer install
npm install

# 3. Konfigurasi file environment
cp .env.example .env
php artisan key:generate

# 4. Migrasi database dan isi data awal
php artisan migrate:fresh --seed

# 5. Build aset frontend
npm run build

# 6. Jalankan web server lokal
php artisan serve
```

Aplikasi dapat dibuka pada browser melalui tautan: `http://127.0.0.1:8000`

---

## Dokumentasi Lanjutan

* **[Panduan Instalasi Lengkap (INSTALLATION.md)](INSTALLATION.md)** — Berisi langkah instalasi mendalam, konfigurasi database MySQL/SQLite, dan solusi kendala teknis (*troubleshooting*).
* **[Dokumentasi Database & ERD (DATABASE_ERD.md)](DATABASE_ERD.md)** — Berisi detail struktur tabel, tipe data, relasi kunci (*foreign keys*), normalisasi 3NF, dan alur integritas data.

---

## Lisensi

Proyek ini didistribusikan di bawah lisensi [MIT](LICENSE).

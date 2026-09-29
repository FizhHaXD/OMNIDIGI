# 📘 Step 1: Panduan Instalasi dan Menjalankan Proyek

Dokumen ini menjelaskan langkah-langkah instalasi, konfigurasi environment, migrasi database, dan cara menjalankan aplikasi **PLN DIGI** di lingkungan lokal.

[⬅️ Kembali ke Indeks Dokumentasi](README.md) | [Lanjut ke Step 2: Database ERD ➡️](02-DATABASE-ERD.md)

---

## 1. Prasyarat Sistem

Pastikan sistem Anda telah terpasang:
- **PHP**: Versi 8.2 atau 8.4 (ekstensi `pdo_mysql`, `mbstring`, `openssl`, `curl`)
- **Composer**: Versi 2.x
- **Node.js**: Versi 18.x / 20.x atau lebih baru, beserta NPM
- **Database**: MySQL 5.7 / 8.0 (atau MariaDB)
- **Git**: Versi terbaru

---

## 2. Langkah-Langkah Instalasi Lengkap

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

### Langkah 6: Konfigurasi Database MySQL
Buat database baru bernama `pln_digi` (atau `plndigi`) pada server MySQL Anda, kemudian sesuaikan parameter di file `.env`:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=pln_digi
DB_USERNAME=root
DB_PASSWORD=
```

### Langkah 7: Migrasi & Isi Data Awal

#### Opsi A: Menggunakan Migration & Seeder Laravel (Direkomendasikan)
Jalankan perintah berikut untuk membuat struktur tabel dan mengisi data master serta 50 user dummy:
```bash
php artisan migrate:fresh --seed
php artisan db:seed --class=DummyUsers50Seeder
```

#### Opsi B: Import File SQL Langsung
Jika menggunakan phpMyAdmin / MySQL CLI / DBeaver:
```bash
mysql -u root -p pln_digi < database/dummy_50_users.sql
```

### Langkah 8: Konfigurasi Storage Link
```bash
php artisan storage:link
```

### Langkah 9: Build Asset Frontend
Mode pengembangan:
```bash
npm run dev
```

Atau untuk build produksi:
```bash
npm run build
```

### Langkah 10: Jalankan Server Laravel
Buka terminal dan jalankan:
```bash
php artisan serve
```
Aplikasi dapat diakses melalui browser di alamat: **`http://localhost:8000`**

---

## 3. Informasi Akun Default untuk Pengujian

| Role | Nama Pengguna | Alamat Email | Password | Akses URL |
|---|---|---|---|---|
| **Administrator** | Admin PLN | `admin@plndigi.com` | `password` | `/admin` |
| **User Utama** | Hafizh Wijdan | `hafizh@mail.com` | `password` | `/dashboard` |
| **50 User Dummy** | *(Lihat daftar lengkap)* | `bambang.s@plndigi.com` dll | `password` | `/dashboard` |

> 📌 *Daftar lengkap 50 akun dummy dan skenarionya dapat dilihat di [03-DUMMY-USERS.md](03-DUMMY-USERS.md).*

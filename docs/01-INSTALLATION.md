# 📘 Step 1: Panduan Instalasi dan Menjalankan Proyek (Installation Guide)

Dokumen ini menjelaskan langkah-langkah instalasi, konfigurasi environment, migrasi database (MySQL & SQLite), seeding data dummy, dan cara menjalankan aplikasi **PLN DIGI (OMNIDIGI)** di lingkungan lokal secara lengkap dan mudah dipahami.

[⬅️ Kembali ke Indeks Dokumentasi](README.md) | [Lanjut ke Step 2: Database ERD ➡️](02-DATABASE-ERD.md)

---

## 1. Prasyarat Sistem (System Requirements)

Sebelum memulai, pastikan perangkat Anda telah terpasang software berikut:

| Perangkat Lunak | Versi Minimal / Rekomendasi | Keterangan |
|---|---|---|
| **PHP** | `8.2` atau `8.4+` | Ekstensi wajib: `pdo_mysql`, `pdo_sqlite`, `mbstring`, `openssl`, `curl`, `fileinfo`, `bcmath` |
| **Composer** | `2.x+` | Package manager dependensi backend PHP |
| **Node.js & NPM** | `Node 18.x / 20.x / 22.x+` | Runtime JavaScript dan build tool asset frontend |
| **Database Server** | MySQL `8.0+` / MariaDB `10.4+` / SQLite | MySQL direkomendasikan untuk pengujian penuh |
| **Git** | Versi terbaru | Version control system |
| **Web Browser** | Chrome, Edge, Firefox, Safari | Mendukung modern JavaScript & CSS grid |

Cek versi instalasi di terminal Anda:
```bash
php -v
composer -V
node -v
npm -v
git --version
```

---

## 2. Panduan Instalasi Langkah Demi Langkah (Step-by-Step)

### Langkah 1: Kloning Repositori & Pilih Branch
Buka terminal / Git Bash / PowerShell, lalu jalankan:
```bash
# Clone repository
git clone https://github.com/FizhHaXD/OMNIDIGI.git

# Masuk ke direktori proyek
cd OMNIDIGI

# Pastikan Anda berada di branch aktif terbaru
git checkout feature/plndigi-v2
```

---

### Langkah 2: Instal Dependensi Backend (Composer)
Unduh seluruh package Laravel dan dependensinya:
```bash
composer install
```
> *Tips: Jika terjadi memory limit, gunakan `php -d memory_limit=-1 composer install`.*

---

### Langkah 3: Instal Dependensi Frontend (NPM)
Unduh package Tailwind CSS, Vite, Alpine.js, dan icon library:
```bash
npm install
```

---

### Langkah 4: Konfigurasi File Environment (`.env`)
Salin template konfigurasi `.env.example` menjadi `.env`:

* **Windows PowerShell:**
  ```powershell
  Copy-Item .env.example .env
  ```
* **Windows Command Prompt (CMD):**
  ```cmd
  copy .env.example .env
  ```
* **Linux / macOS / Git Bash:**
  ```bash
  cp .env.example .env
  ```

---

### Langkah 5: Generate Application Encryption Key
Jalankan perintah berikut untuk meng-generate key unik aplikasi di `.env`:
```bash
php artisan key:generate
```

---

### Langkah 6: Konfigurasi Database

Pilih salah satu metode database di bawah ini sesuai kebutuhan Anda:

#### Pilihan A: Menggunakan MySQL (Direkomendasikan)
1. Buka MySQL client Anda (phpMyAdmin, DBeaver, TablePlus, atau MySQL CLI).
2. Buat database baru bernama `pln_digi`:
   ```sql
   CREATE DATABASE pln_digi CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
   ```
3. Buka file `.env` di teks editor, lalu sesuaikan konfigurasi koneksi database:
   ```env
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=pln_digi
   DB_USERNAME=root
   DB_PASSWORD=
   ```
   *(Sesuaikan `DB_USERNAME` dan `DB_PASSWORD` dengan kredensial server MySQL Anda)*

#### Pilihan B: Menggunakan SQLite (Zero-Config / Praktis Cepat)
Jika tidak ingin mengaktifkan server MySQL lokal:
1. Buat file database kosong `database/database.sqlite`:
   - Windows PowerShell: `New-Item -ItemType File database/database.sqlite -Force`
   - Linux / macOS / Git Bash: `touch database/database.sqlite`
2. Buka file `.env` dan atur:
   ```env
   DB_CONNECTION=sqlite
   ```

---

### Langkah 7: Migrasi Tabel & Seeding Data Awal

Jalankan perintah migrasi Laravel untuk membuat seluruh skema tabel serta menyuntikkan data master dan akun demo:

```bash
# 1. Jalankan migrasi fresh beserta DatabaseSeeder bawaan
php artisan migrate:fresh --seed

# 2. Suntikkan 50 Akun Dummy dengan variasi skenario transaksi lengkap
php artisan db:seed --class=DummyUsers50Seeder
```

> **Alternatif Import SQL Langsung:**
> Jika Anda lebih memilih import langsung file database dump yang telah disediakan:
> ```bash
> # Import file SQL master lengkap
> mysql -u root -p pln_digi < database/pln_digi.sql
> 
> # Atau import 50 user dummy tambahan
> mysql -u root -p pln_digi < database/dummy_50_users.sql
> ```

---

### Langkah 8: Buat Symbolic Link Storage
Perintah ini menghubungkan folder `storage/app/public` ke folder `public/storage` agar file bukti pembayaran atau dokumen dapat diakses secara publik:
```bash
php artisan storage:link
```

---

### Langkah 9: Build Aset Frontend

* **Untuk Lingkungan Pengembangan (Development / Live Reload):**
  ```bash
  npm run dev
  ```
* **Untuk Build Bundle Produksi (Optimized Assets):**
  ```bash
  npm run build
  ```

---

### Langkah 10: Jalankan Server Lokal Laravel

Buka terminal dan jalankan server pengembangan:
```bash
php artisan serve
```

Aplikasi kini aktif dan dapat diakses melalui browser Anda di:
👉 **`http://localhost:8000`** atau **`http://127.0.0.1:8000`**

---

## 3. Akun Pengujian & Kredensial Demo

Seluruh akun demo memiliki password default yang sama: **`password`**

| Role / Skenario | Nama Pengguna | Email | Password | Akses URL | Fitur Utama |
|---|---|---|---|---|---|
| **Administrator** | Admin PLN | `admin@plndigi.com` | `password` | `/admin` | CRM pelanggan, audit tagihan, monitoring transaksi, generator AI surat dinas SP-1/SP-2 |
| **Pelanggan Utama** | Hafizh Wijdan | `hafizh@mail.com` | `password` | `/dashboard` | Dashboard interaktif, riwayat transaksi, simulasi, SwaCAM metering, tukar reward poin |
| **Demo Pascabayar Normal** | Bambang S. | `bambang.s@plndigi.com` | `password` | `/dashboard` | Tagihan aktif siap bayar, riwayat konsumsi kWh |
| **Demo Prabayar (Token)** | Bayu Wicaksono | `bayu.wicaksono@plndigi.com` | `password` | `/dashboard` | Riwayat pembelian token stroom 20 digit |
| **Demo Overdue (Menunggak)**| Agus Priyanto | `agus.priyanto@plndigi.com` | `password` | `/dashboard` | Tagihan menunggak & denda keterlambatan |

> 📌 *Daftar lengkap 50 akun dummy beserta nomor ID Pelanggan dan skenarionya dapat dilihat pada [03-DUMMY-USERS.md](03-DUMMY-USERS.md).*

---

## 4. Pemecahan Masalah (Troubleshooting & FAQ)

### 1. `Vite manifest not found at: .../public/build/manifest.json`
**Penyebab:** Aset frontend belum dikompilasi.  
**Solusi:** Jalankan perintah build:
```bash
npm run build
```

### 2. `No application encryption key has been specified`
**Penyebab:** Kunci `APP_KEY` di file `.env` masih kosong.  
**Solusi:** Jalankan:
```bash
php artisan key:generate
```

### 3. `SQLSTATE[HY000] [1049] Unknown database 'pln_digi'`
**Penyebab:** Database belum dibuat di server MySQL Anda.  
**Solusi:** Buat database terlebih dahulu via MySQL CLI atau phpMyAdmin:
```sql
CREATE DATABASE pln_digi;
```
Lalu jalankan `php artisan migrate:fresh --seed`.

### 4. Permasalahan Hak Akses Folder di Linux / macOS
Jika Anda mengalami masalah permission saat upload atau menulis session cache:
```bash
chmod -R 775 storage bootstrap/cache
chown -R www-data:www-data storage bootstrap/cache
```

### 5. Cara Mereset Seluruh Data ke Kondisi Semula
Cukup jalankan satu baris perintah berikut di terminal:
```bash
php artisan migrate:fresh --seed && php artisan db:seed --class=DummyUsers50Seeder
```

# 📘 Step 1: Panduan Instalasi Lengkap dari Nol (Zero to Hero)

Panduan ini disusun secara bertahap dan mendalam untuk siapa saja yang ingin menjalankan aplikasi **PLN DIGI (OMNIDIGI)**, **termasuk bagi pengguna yang baru pertama kali menyiapkan laptop/komputer baru dari 0** (belum memiliki PHP, Composer, Node.js, atau database server).

[⬅️ Kembali ke Indeks Dokumentasi](README.md) | [Lanjut ke Step 2: Database ERD ➡️](02-DATABASE-ERD.md)

---

## 🧭 Navigasi Panduan

1. [Bagian 1: Instalasi Perangkat Utama dari Nol (Prasyarat)](#bagian-1-instalasi-perangkat-utama-dari-nol-prasyarat)
   * [Pilihan A (Sangat Direkomendasikan untuk Pemula): Menggunakan Laragon](#pilihan-a-paling-mudah--cepat-menggunakan-laragon-windows)
   * [Pilihan B: Menggunakan XAMPP + Composer Manual (Windows)](#pilihan-b-instalasi-manual-menggunakan-xampp--composer-setup-windows)
   * [Pilihan C: Pengguna macOS atau Linux (Ubuntu/Debian)](#pilihan-c-pengguna-macos--linux)
2. [Bagian 2: Menjalankan Proyek PLN DIGI](#bagian-2-menjalankan-proyek-pln-digi)
3. [Bagian 3: Akun Demo & Data Pengujian](#bagian-3-akun-demo--data-pengujian)
4. [Bagian 4: Kamus Solusi Kendala (Troubleshooting Error dari Nol)](#bagian-4-kamus-solusi-kendala-troubleshooting)

---

## Bagian 1: Instalasi Perangkat Utama dari Nol (Prasyarat)

> 💡 **PENTING DIKETAHUI:**  
> Perintah `composer` atau `php` **bukanlah perintah bawaan Windows**. Jika di laptop Anda muncul pesan error:  
> `"'composer' is not recognized as an internal or external command"`  
> Itu artinya software **PHP** dan **Composer** belum terinstal atau belum didaftarkan ke sistem Windows (Environment Path).

Silakan pilih salah satu metode instalasi di bawah ini:

---

### Pilihan A (Paling Mudah & Cepat): Menggunakan Laragon (Windows)

Jika Anda ingin setup cepat dalam 5 menit tanpa ribet mengatur Environment Path atau konfigurasi file secara manual, **Laragon** adalah pilihan terbaik:

1. **Unduh Laragon:**  
   Buka situs resmi [laragon.org/download](https://laragon.org/download/) dan pilih **Download Laragon - Full** (versi yang menyertakan PHP 8.x, MySQL, dan Composer).
2. **Jalankan Installer:**  
   Install Laragon seperti biasa (umumnya di `C:\laragon`).
3. **Mulai Layanan:**  
   Buka aplikasi Laragon, lalu klik tombol **"Start All"**.
4. **Buka Terminal Bawaan:**  
   Klik tombol **"Terminal"** di dalam jendela Laragon. Terminal ini sudah otomatis mengenali perintah `php`, `composer`, `git`, dan `mysql` tanpa perlu setting apa pun lagi!
5. **Install Node.js (jika belum ada):**  
   Unduh installer Node.js LTS dari [nodejs.org](https://nodejs.org/) dan jalankan installer sampai selesai.

*(Setelah langkah ini, Anda bisa langsung melompat ke [Bagian 2: Menjalankan Proyek](#bagian-2-menjalankan-proyek-pln-digi)).*

---

### Pilihan B: Instalasi Manual Menggunakan XAMPP + Composer Setup (Windows)

Jika Anda sudah terbiasa dengan **XAMPP**, ikuti langkah demi langkah berikut secara berurutan:

#### 1. Install XAMPP (PHP Minimal 8.2)
1. Buka [apachefriends.org](https://www.apachefriends.org/download.html).
2. Unduh XAMPP untuk Windows dengan versi **PHP 8.2** atau **PHP 8.4**.
3. Install XAMPP (direkomendasikan di lokasi default: `C:\xampp`).

#### 2. Wajib: Aktifkan Ekstensi PHP di `php.ini`
Secara default, XAMPP menonaktifkan beberapa ekstensi yang dibutuhkan oleh Laravel. Untuk mengaktifkannya:
1. Buka XAMPP Control Panel.
2. Pada baris **Apache**, klik tombol **Config** lalu pilih **PHP (php.ini)** *(atau buka manual file `C:\xampp\php\php.ini` dengan Notepad)*.
3. Tekan `Ctrl + F`, lalu cari baris-baris berikut dan **hapus tanda titik koma (`;`) di depannya**:
   ```ini
   extension=pdo_mysql
   extension=curl
   extension=fileinfo
   extension=mbstring
   extension=openssl
   extension=sodium
   extension=gd
   ```
4. Simpan file (`Ctrl + S`), lalu pada XAMPP Control Panel klik **Stop** kemudian **Start** kembali Apache dan MySQL.

#### 3. Daftarkan PHP ke Windows Environment Variables (System PATH)
Agar perintah `php` bisa dikenali di Command Prompt / PowerShell mana pun:
1. Tekan tombol **Windows + R**, ketik `sysdm.cpl` lalu tekan **Enter**.
2. Masuk ke tab **Advanced**, lalu klik tombol **Environment Variables...** di kanan bawah.
3. Pada bagian **System variables** (kotak bawah), cari variabel bernama `Path`, lalu klik **Edit...**.
4. Klik tombol **New**, lalu ketikkan: `C:\xampp\php`
5. Klik **OK** pada semua jendela yang terbuka.

#### 4. Unduh & Install Composer Resmi untuk Windows
1. Buka halaman resmi unduhan Composer: [getcomposer.org/download](https://getcomposer.org/download/)
2. Klik link **[Composer-Setup.exe](https://getcomposer.org/Composer-Setup.exe)** untuk mengunduh installer otomatis.
3. Jalankan file `Composer-Setup.exe`:
   - Pada halaman *Installation Options*, klik **Next**.
   - Pada halaman *Settings Check*, pastikan jalur PHP sudah mengarah ke `C:\xampp\php\php.exe`. Klik **Next**.
   - Pada halaman *Proxy*, biarkan kosong, klik **Next** lalu klik **Install**.
4. **PENTING:** Setelah selesai, **tutup semua jendela terminal/Command Prompt/PowerShell yang sedang terbuka, lalu buka yang baru** agar sistem memuat PATH Composer yang baru.
5. Uji di terminal:
   ```cmd
   composer -V
   ```
   *Jika muncul teks seperti `Composer version 2.x.x`, berarti Composer telah berhasil terpasang sempurna!*

#### 5. Install Node.js & NPM
1. Kunjungi [nodejs.org](https://nodejs.org/) dan unduh versi **LTS**.
2. Jalankan installer `.msi` dan ikuti petunjuk hingga selesai.
3. Cek di terminal baru:
   ```cmd
   node -v
   npm -v
   ```

#### 6. Install Git for Windows
1. Kunjungi [git-scm.com/download/win](https://git-scm.com/download/win).
2. Unduh dan jalankan installer Git.
3. Cek di terminal: `git --version`

---

### Pilihan C: Pengguna macOS & Linux

#### Untuk macOS (via Homebrew):
```bash
# 1. Install Homebrew jika belum ada
/bin/bash -c "$(curl -fsSL https://raw.githubusercontent.com/Homebrew/install/HEAD/install.sh)"

# 2. Install PHP, Composer, Node.js, dan Git
brew install php composer node git
brew services start mysql
```

#### Untuk Linux (Ubuntu / Debian):
```bash
sudo apt update
sudo apt install -y php php-cli php-mysql php-mbstring php-xml php-curl php-zip php-bcmath unzip curl git mysql-server nodejs npm
# Install Composer resmi
curl -sS https://getcomposer.org/installer | php
sudo mv composer.phar /usr/local/bin/composer
```

---

## Bagian 2: Menjalankan Proyek PLN DIGI

Setelah semua perangkat di atas terpasang dan terverifikasi, ikuti langkah-langkah berikut untuk mengunduh dan menjalankan aplikasi PLN DIGI:

### Langkah 1: Kloning Repositori & Masuk ke Folder Proyek
Buka terminal baru (PowerShell / Command Prompt / Git Bash) di folder tempat Anda ingin menyimpan proyek (misalnya `D:\Coding` atau `C:\laragon\www`), lalu jalankan:

```bash
git clone https://github.com/FizhHaXD/OMNIDIGI.git
cd OMNIDIGI
git checkout feature/plndigi-v2
```

---

### Langkah 2: Unduh Dependensi Backend (Composer Install)
Jalankan perintah ini di dalam folder proyek:
```bash
composer install
```
> *Catatan: Proses ini memerlukan koneksi internet untuk mengunduh komponen Laravel. Tunggu hingga proses selesai dengan tulisan hijau.*

---

### Langkah 3: Unduh Dependensi Frontend (NPM Install)
```bash
npm install
```

---

### Langkah 4: Buat File Konfigurasi `.env`
Salin template konfigurasi:

* **Di Windows PowerShell:**
  ```powershell
  Copy-Item .env.example .env
  ```
* **Di Windows CMD:**
  ```cmd
  copy .env.example .env
  ```
* **Di Linux / macOS / Git Bash:**
  ```bash
  cp .env.example .env
  ```

Lalu generate Application Key unik:
```bash
php artisan key:generate
```

---

### Langkah 5: Setup Database MySQL

1. Pastikan server MySQL Anda aktif:
   - Jika memakai **XAMPP**: Buka XAMPP Control Panel, pastikan module **MySQL** berstatus *Running*.
   - Jika memakai **Laragon**: Pastikan sudah klik *Start All*.
2. Buka browser dan buka phpMyAdmin di **`http://localhost/phpmyadmin`**.
3. Buat database baru dengan nama: **`pln_digi`** (collation: `utf8mb4_unicode_ci` atau default).
4. Buka file `.env` di folder proyek menggunakan teks editor (VS Code, Notepad, dll), lalu pastikan konfigurasinya sebagai berikut:
   ```env
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=pln_digi
   DB_USERNAME=root
   DB_PASSWORD=
   ```
   *(Catatan: Jika MySQL Anda menggunakan password, isi pada baris `DB_PASSWORD`)*

---

### Langkah 6: Migrasi Tabel & Seeding Data Dummy Lengkap

Jalankan perintah migrasi Laravel untuk membangun struktur tabel serta menyuntikkan data akun demo dan 50 data dummy:

```bash
# 1. Jalankan migrasi tabel database dan master data
php artisan migrate:fresh --seed

# 2. Suntikkan 50 data dummy pelanggan & riwayat transaksi lengkap
php artisan db:seed --class=DummyUsers50Seeder
```

---

### Langkah 7: Hubungkan Storage & Compile Aset Frontend

```bash
# 1. Hubungkan storage folder agar file asset dapat diakses publik
php artisan storage:link

# 2. Kompilasi asset CSS & JS (Vite)
npm run build
```

---

### Langkah 8: Jalankan Server Lokal Aplikasi

Buka terminal dan ketik perintah:
```bash
php artisan serve
```

Terminal akan menampilkan:
```text
INFO  Server running on [http://127.0.0.1:8000].
```

Buka web browser Anda dan akses aplikasi di:  
👉 **`http://localhost:8000`** atau **`http://127.0.0.1:8000`**

---

## Bagian 3: Akun Demo & Data Pengujian

Semua akun demo di bawah ini menggunakan password default: **`password`**

| Role / Skenario | Nama Pengguna | Alamat Email | Password | Akses URL | Deskripsi Skenario |
|---|---|---|---|---|---|
| **Administrator** | Admin PLN | `admin@plndigi.com` | `password` | `/admin` | Akses panel CRM backoffice, monitoring pelanggan, data transaksi, dan generator AI surat dinas |
| **Pelanggan Utama** | Hafizh Wijdan | `hafizh@mail.com` | `password` | `/dashboard` | Akun demo lengkap dengan riwayat tagihan, token stroom, fitur SwaCAM, dan poin reward |
| **Pascabayar Normal** | Bambang S. | `bambang.s@plndigi.com` | `password` | `/dashboard` | Pengujian pembayaran tagihan listrik bulanan aktif |
| **Prabayar (Token)** | Bayu Wicaksono | `bayu.wicaksono@plndigi.com` | `password` | `/dashboard` | Pengujian pembelian token listrik 20 digit |
| **Pelanggan Overdue** | Agus Priyanto | `agus.priyanto@plndigi.com` | `password` | `/dashboard` | Simulasi tagihan menunggak & penambahan denda |

> 📌 *Daftar lengkap 50 akun dummy beserta ID Pelanggan dan skenarionya dapat dilihat pada [03-DUMMY-USERS.md](03-DUMMY-USERS.md).*

---

## Bagian 4: Kamus Solusi Kendala (Troubleshooting)

### 1. `'composer' is not recognized as an internal or external command`
* **Penyebab:** Composer belum terpasang atau jendela terminal belum dimuat ulang setelah instalasi.
* **Solusi:**
  1. Unduh dan jalankan installer [Composer-Setup.exe](https://getcomposer.org/Composer-Setup.exe).
  2. Saat ditanya letak `php.exe`, pilih lokasi PHP Anda (contoh: `C:\xampp\php\php.exe` atau `C:\laragon\bin\php\php-8.x\php.exe`).
  3. **Wajib tutup (close) jendela terminal atau VS Code Anda, lalu buka kembali**.

### 2. `'php' is not recognized as an internal or external command`
* **Penyebab:** Folder PHP belum terdaftar di Environment Variables Windows.
* **Solusi:** Buka `System Properties` ➔ `Environment Variables` ➔ Pilih `Path` ➔ `Edit` ➔ `New` ➔ Masukkan `C:\xampp\php` (jika menggunakan XAMPP) ➔ Klik `OK` dan restart terminal.

### 3. `The requested PHP extension pdo_mysql is missing from your system`
* **Penyebab:** Ekstensi database MySQL pada PHP belum diaktifkan di file konfigurasi.
* **Solusi:** Buka file `C:\xampp\php\php.ini`, cari baris `;extension=pdo_mysql`, lalu hapus tanda titik koma (`;`) di awal baris sehingga menjadi `extension=pdo_mysql`. Simpan dan restart Apache di XAMPP.

### 4. `Composer detected issues in your platform: Your Composer dependencies require a PHP version ">= 8.2.0"`
* **Penyebab:** Versi PHP di komputer Anda masih di bawah versi 8.2 (misalnya masih PHP 7.4 atau 8.0).
* **Solusi:** Update XAMPP Anda ke versi terbaru dengan PHP 8.2+ dari [apachefriends.org](https://www.apachefriends.org/) atau gunakan **Laragon**.

### 5. `Vite manifest not found at: .../public/build/manifest.json`
* **Penyebab:** Aset frontend (Tailwind CSS dan JavaScript) belum dikompilasi ke folder public.
* **Solusi:** Jalankan perintah `npm run build` di terminal proyek.

### 6. `SQLSTATE[HY000] [1049] Unknown database 'pln_digi'`
* **Penyebab:** Database dengan nama `pln_digi` belum dibuat di server MySQL.
* **Solusi:** Buka phpMyAdmin (`http://localhost/phpmyadmin`), buat database baru bernama `pln_digi`, lalu ulangi perintah `php artisan migrate:fresh --seed`.

### 7. Port 8000 Sudah Digunakan (`Failed to listen on 127.0.0.1:8000 (reason: Address already in use)`)
* **Penyebab:** Ada aplikasi lain atau terminal lain yang sedang menjalankan server di port 8000.
* **Solusi:** Jalankan Laravel di port berbeda dengan perintah:
  ```bash
  php artisan serve --port=8080
  ```
  Lalu buka `http://localhost:8080` di browser Anda.

# 🚀 Step 5: Feature Changelog & Catatan Perbaikan Sistem

Dokumen ini mencatat rekapitulasi seluruh perbaikan bug, penambahan fitur baru, serta peningkatan antarmuka (UX) yang telah diselesaikan pada aplikasi **PLN DIGI**.

[⬅️ Kembali ke Step 4: Color Palette](04-COLOR-PALETTE.md) | [Indeks Dokumentasi](README.md)

---

## 📋 Ringkasan Perubahan per Modul

### 1. Modul Catat Meter Mandiri (Self Metering / SwaCAM)
- **Status Enum MySQL Fix:** Memperbaiki status penyimpanan dari `'submitted'` menjadi `'pending'` sesuai definisi enum tabel database MySQL.
- **Pencegahan Error Duplikasi 1062:** Menambahkan validasi pengecekan stand meter bulan berjalan di controller. Jika pelanggan sudah mengirimkan angka meteran bulan ini, sistem menampilkan kartu status *"Menunggu Verifikasi Petugas"* dan menyembunyikan form input agar tidak terjadi duplikasi (`unique constraint violation`).
- **File Dimodifikasi:**
  - `app/Http/Controllers/DashboardController.php`
  - `resources/views/dashboard/metering.blade.php`

---

### 2. Modul PLN Reward & Tukar Poin
- **Migrasi & Model Baru:** Dibuat tabel `reward_claims` dan model `App\Models\RewardClaim` untuk mencatat voucher hasil penukaran poin.
- **Kalkulasi Sisa Poin:** Sistem menghitung perolehan poin dari akumulasi pembayaran tagihan/token dikurangi total poin yang telah ditukarkan.
- **Voucher Generator Unik:** Membuat method `redeem()` di `RewardController` untuk menghasilkan kode kupon unik (contoh: `PLN-DISC50-XXXXXX`).
- **Antarmuka Interaktif:** Tombol "Tukar Poin" kini berfungsi dengan dialog konfirmasi, dan menampilkan daftar *"Voucher Saya"* lengkap dengan tombol salin kode kupon instan.
- **File Terkait:**
  - `database/migrations/2026_09_28_000001_create_reward_claims_table.php`
  - `app/Models/RewardClaim.php`
  - `app/Http/Controllers/RewardController.php`
  - `resources/views/dashboard/reward.blade.php`
  - `routes/web.php`

---

### 3. Modul Monitoring Pemakaian Listrik
- **Sinkronisasi Data:** Menggabungkan data baca meteran, tagihan bulanan, dan transaksi pembelian token ke dalam satu urutan kronologis yang konsisten.
- **Penyelarasan Sumbu X:** Grafik konsumsi kWh dan pengeluaran Rupiah kini memiliki label periode yang sejajar dan presisi.
- **Empty State:** Menyediakan tampilan informatif yang ramah ketika pelanggan belum memiliki data pemakaian.
- **File Dimodifikasi:**
  - `app/Http/Controllers/DashboardController.php`
  - `resources/views/dashboard/monitoring.blade.php`

---

### 4. Modul Simulasi Keuangan & Estimasi Penggunaan
- **Kalkulator Peralatan Elektronik:** Ditambahkan fitur pemilihan peralatan rumah tangga (AC, kulkas, mesin cuci, TV, lampu LED, rice cooker) dengan tombol 1-klik yang langsung mengkalkulasi dan menerapkan estimasi kWh ke form utama.
- **Fallback Golongan Tarif:** Jika pengguna belum memiliki ID pelanggan, simulasi otomatis menggunakan golongan tarif default (R1-1300) dan memungkinkan pemilihan golongan tarif lain secara fleksibel.
- **File Dimodifikasi:**
  - `app/Http/Controllers/DashboardController.php`
  - `resources/views/dashboard/simulasi.blade.php`

---

### 5. Modul Pembayaran Tagihan Cepat (Fast-Pay)
- **Deteksi Otomatis ID Pelanggan:** Tombol "Bayar Sekarang" di halaman dashboard maupun tagihan kini membawa parameter `?id_pelanggan=...`.
- **Form Siap Bayar:** `ProdukController@tagihan` secara otomatis memeriksa apakah user memiliki ID pelanggan dan tagihan tertunggak, lalu langsung menampilkan kartu tagihan siap bayar tanpa meminta user mengetik ulang 12 digit ID-nya.
- **File Dimodifikasi:**
  - `app/Http/Controllers/ProdukController.php`
  - `resources/views/dashboard/tagihan.blade.php`

---

### 6. Widget Token Stroom Terakhir di Beranda Dashboard
- **Optimasi Query Controller:** Pemanggilan `$lastToken` dipindahkan ke luar blok pengecekan customer agar riwayat transaksi token berhasil milik user selalu diambil.
- **Kartu Sorotan Stroom:** Ditambahkan kartu banner khusus di beranda dashboard yang menampilkan 20 digit kode stroom (dikelompokkan per 4 digit), tanggal pembelian, daya, serta tombol *"Salin Kode"* yang responsif.
- **File Dimodifikasi:**
  - `app/Http/Controllers/DashboardController.php`
  - `resources/views/dashboard/index.blade.php`

---

### 7. Penyeragaman Layout Halaman Profil (`/profile`)
- **Migrasi Layout:** Mengganti `<x-app-layout>` bawaan Breeze menjadi `@extends('layouts.main')`.
- **Identitas Visual PLN DIGI:** Navbar biru PLN, footer lengkap, dan hero header gradient kini tampil utuh saat user membuka pengaturan profil.
- **Lokalisasi:** Seluruh formulir (Informasi Profil, Perbarui Kata Sandi, dan Konfirmasi Hapus Akun) diterjemahkan ke Bahasa Indonesia yang profesional.
- **File Dimodifikasi:**
  - `resources/views/profile/edit.blade.php`
  - `resources/views/profile/partials/update-profile-information-form.blade.php`
  - `resources/views/profile/partials/update-password-form.blade.php`
  - `resources/views/profile/partials/delete-user-form.blade.php`

---

### 8. Desain Baru Halaman Registrasi Akun (`/register`)
- **Split Layout Responsif:** Menyamakan desain registrasi dengan halaman login (panel kiri branding PLN, panel kanan formulir modern).
- **Komponen Interaktif:** Ditambahkan fitur toggle eye-icon (lihat/sembunyikan password) untuk input kata sandi dan konfirmasi kata sandi.
- **Bahasa Indonesia:** Semua placeholder, label, pesan validasi, dan syarat ketentuan disajikan dalam Bahasa Indonesia.
- **File Dimodifikasi:**
  - `resources/views/auth/register.blade.php`

---

### 9. Pembuatan 50 Data Dummy User & Skenario Kasus
- **8 Skenario Realistis:** Mencakup pelanggan pascabayar tertib, menunggak (overdue), prabayar aktif, pengguna baru (empty state), pelapor meter mandiri, kolektor reward, bisnis UMKM, dan pelapor gangguan.
- **Artefak SQL:** Diekspor ke file `database/dummy_50_users.sql` dan `database/seeders/DummyUsers50Seeder.php` siap pakai untuk transfer ke GitHub.

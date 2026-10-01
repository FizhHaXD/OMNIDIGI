# 📚 Dokumentasi Terpadu PLN DIGI (Step-by-Step Guide)

Selamat datang di pusat dokumentasi resmi **PLN DIGI**. Seluruh dokumentasi teknis, arsitektur, data uji coba, dan panduan penggunaan telah diorganisir secara rapi di dalam folder `docs/` ini agar Anda dapat memahami dan menguji aplikasi secara runtut langkah demi langkah (*step-by-step*).

---

## 🗺️ Peta Navigasi Dokumen

Urutan membaca dan implementasi yang direkomendasikan:

| Urutan | Dokumen | Topik & Deskripsi |
|:---:|---|---|
| **Step 1** | [📘 `01-INSTALLATION.md`](01-INSTALLATION.md) | **Instalasi & Menjalankan Aplikasi**<br>Prasyarat sistem, clone repository, composer & npm install, setup database, migrasi, dan menjalankan server lokal. |
| **Step 2** | [🗄️ `02-DATABASE-ERD.md`](02-DATABASE-ERD.md) | **Arsitektur Database & Relasi (ERD)**<br>Struktur 8 tabel utama, relasi foreign key, normalisasi 3NF, skema tarif, dan diagram alur bisnis. |
| **Step 3** | [👥 `03-DUMMY-USERS.md`](03-DUMMY-USERS.md) | **Data Uji Coba (50 User Dummy) & Skenario Kasus**<br>Daftar 50 akun siap pakai (password: `password`), 8 skenario pengujian (Pascabayar normal, overdue, token, user baru, self metering, reward, UMKM, outage), dan panduan import SQL. |
| **Step 4** | [🎨 `04-COLOR-PALETTE.md`](04-COLOR-PALETTE.md) | **Design System & Skema Warna PLN DIGI**<br>Palette warna korporat PLN (Biru `#00529C`, Kuning `#FDB813`), gradients, typography Plus Jakarta Sans, dan styling tokens. |
| **Step 5** | [🚀 `05-FEATURE-CHANGELOG.md`](05-FEATURE-CHANGELOG.md) | **Log Fitur & Perbaikan Sistem Terkini**<br>Dokumentasi penyelesaian bug Self Metering (SwaCAM), PLN Point Reward, Monitoring kWh & Biaya, Simulasi Keuangan, Alur Pembayaran Cepat, Widget Token Stroom, Halaman Profil Baru, dan Redesign Registrasi Akun. |
| **Step 6** | [🛡️ `06-ADMIN-DATA-GUIDE.md`](06-ADMIN-DATA-GUIDE.md) | **Panduan Data untuk Admin Dashboard**<br>Dokumentasi lengkap 11 tabel database, kolom, relasi, data yang masuk dari setiap CRUD user, contoh Eloquent query, dan status fitur admin yang sudah ada vs belum. Referensi utama untuk tim yang membangun dashboard admin. |
| **Step 7** | [⚡ `07-ADMIN-AI-DOCUMENT-SYSTEM.md`](07-ADMIN-AI-DOCUMENT-SYSTEM.md) | **Sistem Dashboard Admin & Integrasi AI Agent Surat Kedinasan**<br>Dokumentasi lengkap arsitektur klasifikasi operasional (Aging Overdue SP-1/SP-2/SPK, Severity Outages YANTEK, Anomali SwaCAM), jembatan AI Agent (Prompt & JSON Schema), preview cetak A4 resmi, dan bedah kode sumber controller & views. |
| **Step 8** | [📋 `08-BRANCH-V2-FULL-CHANGELOG.md`](08-BRANCH-V2-FULL-CHANGELOG.md) | **Full Changelog & Rekapitulasi Branch V2**<br>Dokumentasi komprehensif seluruh fitur baru, refactoring kode, peningkatan keamanan, perbaikan bug UI/UX, dan penyempurnaan database pada rilis v2. |

---

## ⚡ Quick Start: 3 Langkah Memulai

Jika Anda ingin langsung menguji aplikasi sekarang:

1. **Jalankan Aplikasi:**
   ```bash
   php artisan serve
   ```
   Aplikasi dapat diakses di: [`http://localhost:8000`](http://localhost:8000)

2. **Isi / Reset Data Dummy 50 User:**
   ```bash
   php artisan db:seed --class=DummyUsers50Seeder
   ```
   *(Atau import file SQL: [`database/dummy_50_users.sql`](../database/dummy_50_users.sql))*

3. **Login dengan Akun Uji Coba:**
   - **User Pascabayar:** `bambang.s@plndigi.com` / `password`
   - **User Prabayar (Token):** `bayu.wicaksono@plndigi.com` / `password`
   - **User Menunggak (Overdue):** `agus.priyanto@plndigi.com` / `password`
   - **Admin:** `admin@plndigi.com` / `password`

---

## 💡 Tips Penggunaan Dokumen

- Semua dokumen saling terhubung dengan hyperlink internal.
- Jika Anda memperbarui skema database atau menambah fitur baru, pastikan untuk memperbarui dokumen terkait di folder ini.

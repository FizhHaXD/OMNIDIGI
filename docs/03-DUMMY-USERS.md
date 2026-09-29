# 👥 Step 3: Dokumentasi Data Dummy 50 User — PLN DIGI

Dokumentasi ini berisi daftar lengkap **50 akun pengguna dummy** beserta data skenario pengujian realistis (*real-world test cases*) untuk aplikasi web **PLN DIGI**.

[⬅️ Kembali ke Step 2: Database ERD](02-DATABASE-ERD.md) | [Indeks Dokumentasi](README.md) | [Lanjut ke Step 4: Color Palette ➡️](04-COLOR-PALETTE.md)

---

## 🔐 Kredensial Akses

Semua akun dummy menggunakan kata sandi (*password*) yang seragam untuk mempermudah proses evaluasi dan presentasi lomba:

| Keterangan | Nilai |
|---|---|
| **URL Login** | `http://localhost:8000/login` (atau domain aplikasi) |
| **Password Default** | `password` |
| **Role Pengguna** | `user` |

---

## 📁 File Sumber Data

1. **File SQL Ekspor Langsung:** [`database/dummy_50_users.sql`](database/dummy_50_users.sql) *(Bisa di-import langsung di MySQL CLI, phpMyAdmin, DBeaver, atau CI/CD)*
2. **Class Laravel Seeder:** [`database/seeders/DummyUsers50Seeder.php`](database/seeders/DummyUsers50Seeder.php) *(Bisa dijalankan lewat `php artisan`)*
3. **Salinan Seeder SQL:** [`database/seeders/dummy_50_users.sql`](database/seeders/dummy_50_users.sql)

---

## 🎯 8 Skenario Kasus Pengujian (Test Cases)

### Case 1: Pascabayar Tertib (10 User | No. 1 – 10)
- **Karakteristik:** Pelanggan rumah tangga dengan tarif R1-450 s.d R1-2200 yang rajin membayar tepat waktu.
- **Kondisi Data:** 
  - Tagihan 2 bulan lalu: **Lunas (`paid`)** via QRIS / GoPay.
  - Tagihan bulan lalu: **Lunas (`paid`)**.
  - Tagihan bulan berjalan: **Belum Bayar (`unpaid`)**, jatuh tempo akhir bulan.
- **Fitur untuk Diuji:** Tombol *"Bayar Sekarang"* di dashboard/tagihan yang otomatis mendeteksi ID pelanggan tanpa perlu mengetik ulang.

---

### Case 2: Pascabayar Menunggak / Overdue (8 User | No. 11 – 18)
- **Karakteristik:** Pelanggan rumah tangga & CV usaha yang memiliki tagihan listrik belum diselesaikan lebih dari jatuh tempo.
- **Kondisi Data:**
  - Tagihan 2 bulan lalu: **Menunggak (`overdue`)** + denda Rp 50.000.
  - Tagihan bulan lalu: **Menunggak (`overdue`)** + denda Rp 25.000.
  - Tagihan bulan berjalan: **Belum Bayar (`unpaid`)**.
- **Fitur untuk Diuji:** Tampilan badge peringatan tagihan merah, perhitungan akumulasi denda, dan total tagihan tertunggak.

---

### Case 3: Pelanggan Prabayar / Token Aktif (8 User | No. 19 – 26)
- **Karakteristik:** Pelanggan dengan sistem listrik prabayar (stroom/token).
- **Kondisi Data:**
  - Memiliki riwayat 3 transaksi token sukses (`success`) dengan nominal Rp 50.000 – Rp 200.000.
  - Memiliki token terakhir lengkap dengan 20 digit kode stroom valid.
  - Tidak memiliki tagihan pascabayar (`bills` = 0).
- **Fitur untuk Diuji:** Kartu sorotan *"Token Listrik Terakhir"* di beranda dashboard dengan tombol interaktif *"Salin Kode Stroom"*.

---

### Case 4: Pengguna Baru / Onboarding Fresh (6 User | No. 27 – 32)
- **Karakteristik:** Pengguna yang baru saja melakukan registrasi akun di portal PLN DIGI.
- **Kondisi Data:**
  - Akun terdaftar (`users`), namun belum memiliki ID Pelanggan PLN terhubung (`customers` = null).
  - Belum ada riwayat transaksi.
- **Fitur untuk Diuji:** Tampilan antarmuka *empty state* pada dashboard utama, tombol CTA *"Pasang Baru"* atau *"Tautkan ID Pelanggan"*.

---

### Case 5: Pengguna Catat Meter Mandiri / SwaCAM (6 User | No. 33 – 38)
- **Karakteristik:** Pelanggan yang aktif menggunakan fitur pencatatan angka kWh meteran secara mandiri setiap bulan.
- **Kondisi Data:**
  - Status stand meter bulan berjalan: `pending` (menunggu verifikasi) dan `verified` (sudah diverifikasi petugas).
- **Fitur untuk Diuji:** Menu *"Catat Meter Mandiri"*, banner status laporan stand meter bulan berjalan, dan penguncian form agar tidak terjadi pengiriman ganda di bulan yang sama.

---

### Case 6: Kolektor Reward & Voucher Diskon (5 User | No. 39 – 43)
- **Karakteristik:** Pelanggan loyal dengan intensitas transaksi tinggi sehingga perolehan poin reward melimpah.
- **Kondisi Data:**
  - Memiliki transaksi sukses berkali-kali.
  - Memiliki riwayat voucher aktif (`active`) dan terpakai (`used`) di tabel `reward_claims`.
- **Fitur untuk Diuji:** Menu *"PLN Reward"*, kalkulator sisa poin, penukaran voucher, dan daftar *"Voucher Saya"* dengan tombol salin kode kupon.

---

### Case 7: Pelanggan Bisnis Komersial & Sosial (4 User | No. 44 – 47)
- **Karakteristik:** Pelanggan UMKM, kafe/resto, perkantoran, dan fasilitas sosial (klinik/sekolah).
- **Kondisi Data:**
  - Tarif Bisnis `B1-6600`, `B2-10K`, dan Sosial `S2-900`.
  - Konsumsi daya tinggi (> 1.000 kWh per bulan) dengan nominal tagihan jutaan rupiah.
- **Fitur untuk Diuji:** Tampilan nominal tagihan berdigit besar, monitoring pemakaian skala bisnis, dan simulasi tarif bisnis.

---

### Case 8: Pelapor Gangguan Listrik / Outage (3 User | No. 48 – 50)
- **Karakteristik:** Pelanggan yang pernah melaporkan insiden pemadaman atau trafo meledak di sekitar lokasinya.
- **Kondisi Data:**
  - Data pengaduan tercatat di tabel `outage_reports` dengan status `diproses` dan `selesai`.
- **Fitur untuk Diuji:** Pelacakan status laporan pengaduan gangguan listrik.

---

## 📋 Daftar Lengkap 50 Akun Pengguna Dummy

| No | Nama Lengkap | Alamat Email | ID Pelanggan | Tarif | Daya | Wilayah / Kota | Skenario Kasus |
|:---:|---|---|:---:|:---:|:---:|---|---|
| 1 | Bambang Sudarsono | `bambang.s@plndigi.com` | `531100000001` | R1-1300 | 1300 VA | Jakarta Selatan, DKI Jakarta | Case 1: Pascabayar Tertib |
| 2 | Siti Nurhaliza Putri | `siti.nur@plndigi.com` | `532100000002` | R1-900 | 900 VA | Bandung, Jawa Barat | Case 1: Pascabayar Tertib |
| 3 | Hendra Gunawan | `hendra.g@plndigi.com` | `533100000003` | R1-2200 | 2200 VA | Surabaya, Jawa Timur | Case 1: Pascabayar Tertib |
| 4 | Rina Agustina | `rina.agustina@plndigi.com` | `534100000004` | R1-1300 | 1300 VA | Semarang, Jawa Tengah | Case 1: Pascabayar Tertib |
| 5 | Dimas Arya Pratama | `dimas.arya@plndigi.com` | `534200000005` | R1-1300 | 1300 VA | Yogyakarta, DI Yogyakarta | Case 1: Pascabayar Tertib |
| 6 | Maya Indah Safitri | `maya.indah@plndigi.com` | `535100000006` | R1-900 | 900 VA | Medan, Sumatera Utara | Case 1: Pascabayar Tertib |
| 7 | Joko Tri Wahyudi | `joko.tri@plndigi.com` | `536100000007` | R1-2200 | 2200 VA | Makassar, Sulawesi Selatan | Case 1: Pascabayar Tertib |
| 8 | Sri Wahyuni | `sri.wahyuni@plndigi.com` | `537100000008` | R1-1300 | 1300 VA | Denpasar, Bali | Case 1: Pascabayar Tertib |
| 9 | Arif Budiman | `arif.budiman@plndigi.com` | `533200000009` | R1-450 | 450 VA | Malang, Jawa Timur | Case 1: Pascabayar Tertib |
| 10 | Nurmala Sari | `nurmala.sari@plndigi.com` | `538100000010` | R1-1300 | 1300 VA | Palembang, Sumatera Selatan | Case 1: Pascabayar Tertib |
| 11 | Agus Priyanto | `agus.priyanto@plndigi.com` | `532200000011` | R1-2200 | 2200 VA | Bekasi, Jawa Barat | Case 2: Pascabayar Overdue |
| 12 | Tri Handayani | `tri.handayani@plndigi.com` | `531300000012` | R1-1300 | 1300 VA | Jakarta Timur, DKI Jakarta | Case 2: Pascabayar Overdue |
| 13 | Wawan Kurniawan | `wawan.kurnia@plndigi.com` | `532100000013` | R2-3500 | 3500 VA | Bandung, Jawa Barat | Case 2: Pascabayar Overdue |
| 14 | Ratna Juwita | `ratna.juwita@plndigi.com` | `533100000014` | R1-900 | 900 VA | Surabaya, Jawa Timur | Case 2: Pascabayar Overdue |
| 15 | Dedi Iskandar | `dedi.iskandar@plndigi.com` | `531400000015` | R1-2200 | 2200 VA | Tangerang, Banten | Case 2: Pascabayar Overdue |
| 16 | Endang Sulastri | `endang.sulastri@plndigi.com` | `532300000016` | R1-1300 | 1300 VA | Cimahi, Jawa Barat | Case 2: Pascabayar Overdue |
| 17 | Ferry Andika | `ferry.andika@plndigi.com` | `535200000017` | R2-3500 | 3500 VA | Batam, Kepulauan Riau | Case 2: Pascabayar Overdue |
| 18 | CV Abadi Surya Makmur | `surya.abadi@plndigi.com` | `533100000018` | B1-6600 | 6600 VA | Surabaya, Jawa Timur | Case 2: Pascabayar Overdue Bisnis |
| 19 | Bayu Wicaksono | `bayu.wicaksono@plndigi.com` | `531500000019` | R1-1300 | 1300 VA | Jakarta Barat, DKI Jakarta | Case 3: Prabayar Token Aktif |
| 20 | Dian Kusuma Wardani | `dian.kusuma@plndigi.com` | `534300000020` | R1-900 | 900 VA | Surakarta, Jawa Tengah | Case 3: Prabayar Token Aktif |
| 21 | Fajar Nugroho | `fajar.nugroho@plndigi.com` | `532400000021` | R1-2200 | 2200 VA | Depok, Jawa Barat | Case 3: Prabayar Token Aktif |
| 22 | Gita Gutawa Putri | `gita.putri@plndigi.com` | `532500000022` | R1-1300 | 1300 VA | Bogor, Jawa Barat | Case 3: Prabayar Token Aktif |
| 23 | Ilham Maulana | `ilham.maulana@plndigi.com` | `535300000023` | R1-1300 | 1300 VA | Padang, Sumatera Barat | Case 3: Prabayar Token Aktif |
| 24 | Lestari Handoko | `lestari.handoko@plndigi.com` | `535400000024` | R1-900 | 900 VA | Pekanbaru, Riau | Case 3: Prabayar Token Aktif |
| 25 | Reza Fahlevi | `reza.fahlevi@plndigi.com` | `536200000025` | R1-2200 | 2200 VA | Balikpapan, Kalimantan Timur | Case 3: Prabayar Token Aktif |
| 26 | Sinta Maharani | `sinta.maharani@plndigi.com` | `536300000026` | R1-1300 | 1300 VA | Pontianak, Kalimantan Barat | Case 3: Prabayar Token Aktif |
| 27 | Kevin Sanjaya Sukamuljo | `kevin.sanjaya@plndigi.com` | *-* | - | - | Jakarta Utara, DKI Jakarta | Case 4: Fresh User (Belum ada ID) |
| 28 | Jessica Mila Agnesia | `jessica.mila@plndigi.com` | *-* | - | - | Jakarta Selatan, DKI Jakarta | Case 4: Fresh User (Belum ada ID) |
| 29 | Aditya Bagus Panuntun | `aditya.bagus@plndigi.com` | *-* | - | - | Bandung, Jawa Barat | Case 4: Fresh User (Belum ada ID) |
| 30 | Nadia Syahrini | `nadia.syahrini@plndigi.com` | *-* | - | - | Semarang, Jawa Tengah | Case 4: Fresh User (Belum ada ID) |
| 31 | Randi Ramadhan | `randi.ramadhan@plndigi.com` | *-* | - | - | Surabaya, Jawa Timur | Case 4: Fresh User (Belum ada ID) |
| 32 | Tiara Andini Permata | `tiara.andini@plndigi.com` | *-* | - | - | Jember, Jawa Timur | Case 4: Fresh User (Belum ada ID) |
| 33 | Eko Prasetyo | `eko.prasetyo@plndigi.com` | `531700000033` | R1-1300 | 1300 VA | Tangerang Selatan, Banten | Case 5: Catat Meter (Pending) |
| 34 | Yuni Shara Kusuma | `yuni.shara@plndigi.com` | `533400000034` | R1-2200 | 2200 VA | Batu, Jawa Timur | Case 5: Catat Meter (Pending) |
| 35 | Gunawan Wibisono | `gunawan.w@plndigi.com` | `532600000035` | R1-900 | 900 VA | Cirebon, Jawa Barat | Case 5: Catat Meter (Pending) |
| 36 | Dewi Persik Cahyani | `dewi.persik@plndigi.com` | `533500000036` | R1-1300 | 1300 VA | Sidoarjo, Jawa Timur | Case 5: Catat Meter (Verified) |
| 37 | Teguh Firmansyah | `teguh.f@plndigi.com` | `532700000037` | R2-3500 | 3500 VA | Sukabumi, Jawa Barat | Case 5: Catat Meter (Verified) |
| 38 | Mega Utami Putri | `mega.utami@plndigi.com` | `534400000038` | R1-1300 | 1300 VA | Magelang, Jawa Tengah | Case 5: Catat Meter (Pending) |
| 39 | Rizky Billar Pratama | `rizky.billar@plndigi.com` | `531200000039` | R1-2200 | 2200 VA | Jakarta Selatan, DKI Jakarta | Case 6: Reward & Voucher Kolektor |
| 40 | Anisa Rahmawati | `anisa.rahma@plndigi.com` | `532100000040` | R1-1300 | 1300 VA | Bandung, Jawa Barat | Case 6: Reward & Voucher Kolektor |
| 41 | Bagus Dwi Saputra | `bagus.dwi@plndigi.com` | `534200000041` | R1-1300 | 1300 VA | Yogyakarta, DI Yogyakarta | Case 6: Reward & Voucher Kolektor |
| 42 | Citra Kirana Sari | `citra.kirana@plndigi.com` | `533100000042` | R2-3500 | 3500 VA | Surabaya, Jawa Timur | Case 6: Reward & Voucher Kolektor |
| 43 | Danang Sutrisno | `danang.s@plndigi.com` | `534100000043` | R1-2200 | 2200 VA | Semarang, Jawa Tengah | Case 6: Reward & Voucher Kolektor |
| 44 | Farhan Kopi Kenangan | `kopi.kenangan@plndigi.com` | `531200000044` | B1-6600 | 6600 VA | Jakarta Selatan, DKI Jakarta | Case 7: Bisnis & Komersial |
| 45 | H. Syukur Resto Minang | `resto.minang@plndigi.com` | `532100000045` | B2-10K | 10600 VA | Bandung, Jawa Barat | Case 7: Bisnis & Komersial |
| 46 | Erwin Jaya Percetakan | `jaya.grafika@plndigi.com` | `533100000046` | B1-6600 | 6600 VA | Surabaya, Jawa Timur | Case 7: Bisnis & Komersial |
| 47 | dr. Maya Klinik Pratama | `klinik.sehat@plndigi.com` | `535100000047` | S2-900 | 900 VA | Medan, Sumatera Utara | Case 7: Fasilitas Sosial Klinik |
| 48 | Lukman Hakim | `lukman.hakim@plndigi.com` | `536100000048` | R1-1300 | 1300 VA | Makassar, Sulawesi Selatan | Case 8: Pengaduan (Diproses) |
| 49 | Widya Ningsih | `widya.ningsih@plndigi.com` | `537100000049` | R1-2200 | 2200 VA | Denpasar, Bali | Case 8: Pengaduan (Selesai) |
| 50 | Hasan Basri | `hasan.basri@plndigi.com` | `538100000050` | R1-1300 | 1300 VA | Palembang, Sumatera Selatan | Case 8: Pengaduan (Selesai) |

---

## 🛠️ Panduan Eksekusi

### 1. Eksekusi via Laravel Artisan (Pengembangan Lokal)
Jalankan perintah berikut di terminal root aplikasi:
```bash
php artisan db:seed --class=DummyUsers50Seeder
```

### 2. Eksekusi via Import MySQL Langsung (Production / Server Staging)
```bash
mysql -u <username> -p <nama_database> < database/dummy_50_users.sql
```

### 3. Commit dan Push ke Repositori GitHub
```bash
git add DUMMY_USERS.md database/dummy_50_users.sql database/seeders/DummyUsers50Seeder.php database/seeders/dummy_50_users.sql
git commit -m "docs: dokumentasi lengkap 50 user dummy dan skenario pengujian PLN DIGI"
git push origin main
```

# 🛡️ Step 6: Panduan Data untuk Admin Dashboard — PLN DIGI

Dokumentasi lengkap **seluruh data yang tersedia di database** untuk keperluan pembangunan **Dashboard Admin**. Dokumen ini menjelaskan 11 tabel, kolom-kolomnya, data apa yang masuk dari setiap operasi CRUD user, serta contoh query Eloquent untuk menampilkan data di admin.

[⬅️ Kembali ke Step 5: Feature Changelog](05-FEATURE-CHANGELOG.md) | [Indeks Dokumentasi](README.md)

---

## Daftar Isi
1. [Ringkasan Seluruh Tabel](#1-ringkasan-seluruh-tabel)
2. [Peta Data Masuk (CRUD Flow)](#2-peta-data-masuk-crud-flow)
3. [Detail Per Tabel](#3-detail-per-tabel)
   - [users](#31-users)
   - [customers](#32-customers)
   - [transactions](#33-transactions)
   - [bills](#34-bills)
   - [meter_readings](#35-meter_readings)
   - [outage_reports](#36-outage_reports)
   - [reward_claims](#37-reward_claims)
   - [news](#38-news)
   - [tariffs & tariff_categories](#39-tariffs--tariff_categories)
   - [payment_methods](#310-payment_methods)
4. [Statistik Dashboard yang Bisa Ditampilkan](#4-statistik-dashboard-yang-bisa-ditampilkan)
5. [Status CRUD Admin yang Sudah Ada vs Belum](#5-status-crud-admin-yang-sudah-ada-vs-belum)
6. [Contoh Eloquent Query untuk Admin](#6-contoh-eloquent-query-untuk-admin)

---

## 1. Ringkasan Seluruh Tabel

Aplikasi PLN DIGI memiliki **11 tabel** di database `pln_digi`. Berikut status setiap tabel:

| # | Tabel | Jumlah Kolom | Data Masuk Dari | Status di Admin Saat Ini |
|---|-------|:---:|---|---|
| 1 | `users` | 8 | Registrasi (Breeze) | ⚠️ Hanya count |
| 2 | `customers` | 10 | Admin form | ✅ Full CRUD sudah ada |
| 3 | `transactions` | 14 | Bayar tagihan, Beli token, QRIS | ✅ List + Stats sudah ada |
| 4 | `bills` | 12 | Seeder (perlu: generate dari meter reading) | ⚠️ Hanya count |
| 5 | `meter_readings` | 9 | User self metering (SwaCAM) | ❌ Belum ada di admin |
| 6 | `outage_reports` | 10 | User lapor gangguan | ❌ Belum ada di admin |
| 7 | `reward_claims` | 9 | User redeem poin | ❌ Belum ada di admin |
| 8 | `news` | 9 | Seeder (perlu: admin CRUD) | ❌ Belum ada di admin |
| 9 | `tariffs` | 11 | Seeder | ❌ Belum ada di admin |
| 10 | `tariff_categories` | 5 | Seeder | ❌ Belum ada di admin |
| 11 | `payment_methods` | 6 | Seeder | ❌ Belum ada di admin |

---

## 2. Peta Data Masuk (CRUD Flow)

Diagram ini menunjukkan **alur data dari aksi user masuk ke database** yang nantinya bisa ditarik oleh admin:

```
┌──────────────────────────────────────────────────────────────────────┐
│                    AKSI USER → DATA MASUK KE DB                      │
│                                                                      │
│  [Register/Login]                                                    │
│       └──→ users (Create)                                            │
│                                                                      │
│  [Bayar Tagihan Pascabayar]                                          │
│       └──→ transactions (Create, type='tagihan')                     │
│       └──→ bills (Update, status='paid')                             │
│                                                                      │
│  [Beli Token Prabayar]                                               │
│       └──→ transactions (Create, type='token')                       │
│                                                                      │
│  [Bayar via QRIS]                                                    │
│       └──→ transactions (Create + Update status)                     │
│                                                                      │
│  [Catat Meter Mandiri (SwaCAM)]                                      │
│       └──→ meter_readings (Create, status='pending')                 │
│                                                                      │
│  [Lapor Gangguan Listrik]                                            │
│       └──→ outage_reports (Create, status='dilaporkan')              │
│                                                                      │
│  [Tukar Poin Reward]                                                 │
│       └──→ reward_claims (Create, status='active')                   │
│                                                                      │
│  [Admin: Kelola Pelanggan]                                           │
│       └──→ customers (Create / Update / Delete)                      │
│                                                                      │
└──────────────────────────────────────────────────────────────────────┘
```

---

## 3. Detail Per Tabel

### 3.1 `users`
**Model:** `App\Models\User`  
**Fungsi:** Akun pengguna (admin & user biasa)

| Kolom | Tipe | Keterangan |
|---|---|---|
| `id` | bigint PK | Auto-increment |
| `name` | string | Nama lengkap |
| `email` | string UNIQUE | Email login |
| `password` | string | Hash bcrypt |
| `role` | enum | `admin` atau `user` |
| `email_verified_at` | timestamp nullable | Waktu verifikasi email |
| `created_at` | timestamp | Waktu registrasi |
| `updated_at` | timestamp | Terakhir diupdate |

**Relasi:**
- `hasMany(Customer::class)` — pelanggan milik user
- `hasMany(Transaction::class)` — transaksi milik user

**Data yang bisa ditarik admin:**
- Daftar semua user + role
- Jumlah user per role
- User baru per hari/minggu/bulan
- User yang belum punya customer (fresh user)

**Contoh Eloquent:**
```php
// Semua user biasa
User::where('role', 'user')->latest()->paginate(15);

// User yang belum terhubung ke pelanggan
User::where('role', 'user')->doesntHave('customers')->get();

// Statistik registrasi per bulan
User::selectRaw('MONTH(created_at) as bulan, COUNT(*) as total')
    ->whereYear('created_at', now()->year)
    ->groupBy('bulan')->get();
```

---

### 3.2 `customers`
**Model:** `App\Models\Customer`  
**Fungsi:** Data pelanggan PLN  
**Status Admin:** ✅ **Full CRUD sudah ada**

| Kolom | Tipe | Keterangan |
|---|---|---|
| `id` | bigint PK | Auto-increment |
| `user_id` | bigint FK nullable | Terhubung ke `users.id` |
| `tariff_id` | bigint FK | Terhubung ke `tariffs.id` |
| `id_pelanggan` | string(20) UNIQUE | Nomor ID pelanggan PLN (12 digit) |
| `nama` | string(100) | Nama lengkap pelanggan |
| `alamat` | text | Alamat instalasi |
| `nomor_telepon` | string(15) nullable | Nomor HP |
| `email` | string(100) nullable | Email pelanggan |
| `status_aktif` | boolean | `true` = aktif, `false` = diblokir/cabut |
| `created_at` | timestamp | Waktu pendaftaran |
| `updated_at` | timestamp | Terakhir diupdate |

**Relasi:**
- `belongsTo(User::class)` — pemilik akun
- `belongsTo(Tariff::class)` — jenis tarif
- `hasMany(MeterReading::class)` — data meteran
- `hasMany(Bill::class)` — tagihan
- `hasMany(Transaction::class)` — transaksi

**Data yang bisa ditarik admin:**
- Daftar pelanggan + tarif + user terkait
- Pelanggan aktif vs nonaktif
- Pelanggan per golongan tarif
- Pelanggan yang belum terhubung akun (user_id = null)
- Total tagihan belum lunas per pelanggan

**Contoh Eloquent:**
```php
// Daftar pelanggan dengan relasi lengkap
Customer::with(['user', 'tariff.category'])->latest()->paginate(15);

// Pelanggan per golongan tarif
Customer::select('tariff_id', DB::raw('COUNT(*) as total'))
    ->groupBy('tariff_id')->with('tariff')->get();

// Total tagihan belum lunas per pelanggan
Customer::withSum(['bills' => fn($q) => $q->whereIn('status', ['unpaid', 'overdue'])], 'total_biaya')->get();
```

**Controller yang sudah ada:** `App\Http\Controllers\Admin\AdminController`
- `customers()` — List paginate
- `createCustomer()` / `storeCustomer()` — Tambah pelanggan baru
- `editCustomer()` / `updateCustomer()` — Edit data pelanggan
- `deleteCustomer()` — Hapus pelanggan

---

### 3.3 `transactions`
**Model:** `App\Models\Transaction`  
**Fungsi:** Semua transaksi keuangan (bayar tagihan, beli token, pasang baru)  
**Status Admin:** ✅ **List + Stats sudah ada**

| Kolom | Tipe | Keterangan |
|---|---|---|
| `id` | bigint PK | Auto-increment |
| `user_id` | bigint FK | User yang bayar |
| `customer_id` | bigint FK nullable | Pelanggan terkait |
| `bill_id` | bigint FK nullable | Tagihan yang dibayar (jika type=tagihan) |
| `payment_method_id` | bigint FK | Metode pembayaran |
| `type` | enum | `tagihan`, `token`, `pasang_baru` |
| `amount` | decimal(15,2) | Jumlah yang dibayar (Rp) |
| `nominal` | string nullable | Nominal token (20000, 50000, dll) |
| `status` | enum | `pending`, `success`, `failed` |
| `no_meter` | string(30) nullable | No ID pelanggan/meteran |
| `ref_number` | string(50) UNIQUE | Nomor referensi (format: `TRX-YYYYMMDD-XXXXX`) |
| `token_listrik` | string(30) nullable | Token 20 digit (khusus type=token) |
| `keterangan` | text nullable | Catatan tambahan |
| `created_at` | timestamp | Waktu transaksi dibuat |
| `updated_at` | timestamp | Terakhir diupdate |

**Relasi:**
- `belongsTo(User::class)`
- `belongsTo(Customer::class)`
- `belongsTo(Bill::class)`
- `belongsTo(PaymentMethod::class)`

**Alur status:** `pending` → `success` atau `failed`

**Data yang bisa ditarik admin:**
- Riwayat semua transaksi + filter status/type
- Total pendapatan (sum amount where status=success)
- Transaksi per metode pembayaran
- Transaksi per hari/minggu/bulan (grafik)
- Transaksi pending (belum dikonfirmasi)
- Detail token listrik yang sudah diterbitkan

**Contoh Eloquent:**
```php
// Semua transaksi dengan relasi lengkap
Transaction::with(['user', 'customer', 'paymentMethod', 'bill'])->latest()->paginate(15);

// Total pendapatan
Transaction::where('status', 'success')->sum('amount');

// Pendapatan per bulan
Transaction::where('status', 'success')
    ->selectRaw('MONTH(created_at) as bulan, SUM(amount) as total')
    ->whereYear('created_at', now()->year)
    ->groupBy('bulan')->get();

// Transaksi per metode bayar
Transaction::where('status', 'success')
    ->select('payment_method_id', DB::raw('COUNT(*) as total, SUM(amount) as nominal'))
    ->groupBy('payment_method_id')->with('paymentMethod')->get();

// Transaksi per tipe (tagihan vs token)
Transaction::where('status', 'success')
    ->select('type', DB::raw('COUNT(*) as total, SUM(amount) as nominal'))
    ->groupBy('type')->get();
```

**Controller yang sudah ada:** `AdminController@transactions` — List paginate

---

### 3.4 `bills`
**Model:** `App\Models\Bill`  
**Fungsi:** Tagihan listrik pascabayar per bulan per pelanggan

| Kolom | Tipe | Keterangan |
|---|---|---|
| `id` | bigint PK | Auto-increment |
| `customer_id` | bigint FK | Pelanggan pemilik tagihan |
| `meter_reading_id` | bigint FK | Data meteran dasar tagihan |
| `bulan` | tinyint | Bulan tagihan (1–12) |
| `tahun` | smallint | Tahun tagihan |
| `total_kwh` | decimal(10,2) | Total pemakaian kWh |
| `total_biaya` | decimal(15,2) | Tagihan pokok (Rp) |
| `denda` | decimal(12,2) | Denda keterlambatan (default: 0) |
| `status` | enum | `unpaid`, `paid`, `overdue` |
| `tanggal_jatuh_tempo` | date | Batas waktu bayar |
| `tanggal_bayar` | date nullable | Diisi saat lunas |
| `created_at` | timestamp | Waktu tagihan dibuat |
| `updated_at` | timestamp | Terakhir diupdate |

**Relasi:**
- `belongsTo(Customer::class)`
- `belongsTo(MeterReading::class)`
- `hasMany(Transaction::class)`

**Alur status:** `unpaid` → `paid` (setelah bayar) atau `overdue` (lewat jatuh tempo)

**Data yang bisa ditarik admin:**
- Daftar semua tagihan + filter status
- Total tagihan belum lunas (unpaid + overdue)
- Tagihan overdue + total denda
- Tagihan per pelanggan
- Riwayat pembayaran tagihan (paid)
- Generate tagihan baru dari meter_reading yang verified

**Contoh Eloquent:**
```php
// Semua tagihan dengan relasi
Bill::with(['customer.tariff', 'meterReading'])->latest('tahun')->latest('bulan')->paginate(15);

// Tagihan belum lunas
Bill::whereIn('status', ['unpaid', 'overdue'])->with('customer')->get();

// Total piutang
Bill::whereIn('status', ['unpaid', 'overdue'])->sum('total_biaya');

// Total denda
Bill::where('status', 'overdue')->sum('denda');

// Tagihan overdue yang perlu follow-up
Bill::where('status', 'unpaid')
    ->where('tanggal_jatuh_tempo', '<', now())
    ->with('customer')->get();
```

**⚠️ Belum ada di admin:** Perlu halaman list tagihan + kemampuan generate tagihan dari meter reading.

---

### 3.5 `meter_readings`
**Model:** `App\Models\MeterReading`  
**Fungsi:** Pencatatan angka kWh meter oleh user (Self Metering / SwaCAM)

| Kolom | Tipe | Keterangan |
|---|---|---|
| `id` | bigint PK | Auto-increment |
| `customer_id` | bigint FK | Pelanggan yang melapor |
| `bulan` | tinyint | Bulan pencatatan (1–12) |
| `tahun` | smallint | Tahun pencatatan |
| `meteran_awal` | int unsigned | Stand awal (kWh) |
| `meteran_akhir` | int unsigned | Stand akhir (kWh) |
| `total_kwh` | int **COMPUTED** | Otomatis: `meteran_akhir - meteran_awal` |
| `status` | enum | `pending`, `verified`, `billed` |
| `created_at` | timestamp | Waktu pelaporan |
| `updated_at` | timestamp | Terakhir diupdate |

**Constraint:** `UNIQUE(customer_id, bulan, tahun)` — 1 pelaporan per pelanggan per bulan.

**Relasi:**
- `belongsTo(Customer::class)`
- `hasOne(Bill::class)`

**Alur status:**
```
pending → verified → billed
  (User      (Admin       (Tagihan
  melapor)   verifikasi)  dibuat)
```

**Data yang bisa ditarik admin:**
- Semua pelaporan meter + filter status
- Pelaporan yang menunggu verifikasi (status=pending) ← **PRIORITAS TINGGI**
- Pelaporan yang sudah diverifikasi tapi belum dibuat tagihan (status=verified)
- Histori pemakaian kWh per pelanggan
- Deteksi anomali (lonjakan/penurunan pemakaian tidak wajar)

**Contoh Eloquent:**
```php
// Pelaporan menunggu verifikasi admin
MeterReading::where('status', 'pending')
    ->with('customer.tariff')
    ->latest()->paginate(15);

// Verifikasi dan update status
$reading = MeterReading::findOrFail($id);
$reading->update(['status' => 'verified']);

// Generate tagihan dari reading yang verified
$reading = MeterReading::with('customer.tariff')->findOrFail($id);
$tariff = $reading->customer->tariff;
Bill::create([
    'customer_id'       => $reading->customer_id,
    'meter_reading_id'  => $reading->id,
    'bulan'             => $reading->bulan,
    'tahun'             => $reading->tahun,
    'total_kwh'         => $reading->total_kwh,
    'total_biaya'       => ($reading->total_kwh * $tariff->harga_per_kwh) + $tariff->biaya_beban,
    'denda'             => 0,
    'status'            => 'unpaid',
    'tanggal_jatuh_tempo' => now()->endOfMonth()->addDays(10),
]);
$reading->update(['status' => 'billed']);

// Deteksi anomali: pemakaian > 2x rata-rata
MeterReading::whereRaw('(meteran_akhir - meteran_awal) > (
    SELECT AVG(meteran_akhir - meteran_awal) * 2 FROM meter_readings
)')->with('customer')->get();
```

**❌ Belum ada di admin.** Perlu dibuatkan:
- Halaman list meter_readings dengan tab/filter per status
- Tombol "Verifikasi" (pending → verified)
- Tombol "Buat Tagihan" (verified → billed + insert bills)

---

### 3.6 `outage_reports`
**Model:** `App\Models\OutageReport`  
**Fungsi:** Laporan gangguan/pemadaman listrik dari user

| Kolom | Tipe | Keterangan |
|---|---|---|
| `id` | bigint PK | Auto-increment |
| `user_id` | bigint FK | Pelapor |
| `customer_id` | bigint FK nullable | Pelanggan terkait |
| `kategori` | enum | `padam_total`, `tegangan_rendah`, `korsleting`, `meteran_rusak`, `lainnya` |
| `deskripsi` | text | Deskripsi masalah (min 10 karakter) |
| `lokasi` | string | Alamat/lokasi kejadian |
| `foto` | string nullable | Path foto bukti (storage/outages) |
| `status` | enum | `dilaporkan`, `diproses`, `selesai` |
| `catatan_petugas` | text nullable | Catatan/tindakan dari petugas PLN |
| `created_at` | timestamp | Waktu pelaporan |
| `updated_at` | timestamp | Terakhir diupdate |

**Relasi:**
- `belongsTo(User::class)`
- `belongsTo(Customer::class)`

**Alur status:**
```
dilaporkan → diproses → selesai
  (User        (Admin       (Admin
  melapor)     menangani)   menutup)
```

**Data yang bisa ditarik admin:**
- Semua laporan gangguan + filter status/kategori
- Laporan baru yang butuh tindakan (status=dilaporkan) ← **PRIORITAS TINGGI**
- Laporan sedang diproses
- Riwayat laporan yang selesai
- Statistik gangguan per kategori/wilayah
- Foto bukti gangguan
- Kolom catatan_petugas untuk respon admin

**Contoh Eloquent:**
```php
// Semua laporan dengan relasi
OutageReport::with(['user', 'customer'])->latest()->paginate(15);

// Laporan baru menunggu tindakan
OutageReport::where('status', 'dilaporkan')->latest()->get();

// Update status + catatan petugas
$report = OutageReport::findOrFail($id);
$report->update([
    'status' => 'diproses', // atau 'selesai'
    'catatan_petugas' => 'Teknisi sudah dikirim ke lokasi.',
]);

// Statistik per kategori
OutageReport::select('kategori', DB::raw('COUNT(*) as total'))
    ->groupBy('kategori')->get();

// Statistik per status
OutageReport::select('status', DB::raw('COUNT(*) as total'))
    ->groupBy('status')->get();
```

**❌ Belum ada di admin.** Perlu dibuatkan:
- Halaman list laporan gangguan dengan filter status
- Detail laporan + lihat foto
- Form update status + isi catatan_petugas

---

### 3.7 `reward_claims`
**Model:** `App\Models\RewardClaim`  
**Fungsi:** Klaim/penukaran poin reward oleh user

| Kolom | Tipe | Keterangan |
|---|---|---|
| `id` | bigint PK | Auto-increment |
| `user_id` | bigint FK | User yang menukar |
| `reward_id` | string | ID reward dari katalog (misal: `diskon_5`, `cashback_5k`) |
| `nama` | string | Nama reward yang ditukar |
| `poin` | int unsigned | Jumlah poin yang digunakan |
| `voucher_code` | string UNIQUE | Kode voucher unik (misal: `PLN-DISC5-AB12CD`) |
| `status` | enum | `active`, `used`, `expired` |
| `expired_at` | timestamp nullable | Tanggal kedaluwarsa voucher (+3 bulan) |
| `created_at` | timestamp | Waktu klaim |
| `updated_at` | timestamp | Terakhir diupdate |

**Relasi:**
- `belongsTo(User::class)`

**Katalog Reward yang tersedia (hardcoded di controller):**

| Reward ID | Nama | Poin | Prefix Voucher |
|---|---|---|---|
| `diskon_5` | Diskon Tagihan 5% | 100 | `PLN-DISC5-` |
| `cashback_5k` | Cashback Token Rp 5.000 | 150 | `PLN-CB5K-` |
| `free_admin` | Gratis Biaya Admin 1x | 200 | `PLN-NOADM-` |
| `voucher_50k` | Voucher Belanja Rp 50.000 | 500 | `PLN-SHOP50-` |

**Perhitungan poin user:**
```
Poin per transaksi sukses = 10 poin + floor(amount / 100.000) × 5 poin bonus
Sisa poin = Total poin diperoleh − Total poin sudah ditukar
```

**Data yang bisa ditarik admin:**
- Daftar semua klaim voucher + user
- Voucher aktif vs terpakai vs expired
- Total poin yang sudah ditukarkan
- Reward paling populer
- Update status voucher (active → used / expired)

**Contoh Eloquent:**
```php
// Semua klaim dengan relasi user
RewardClaim::with('user')->latest()->paginate(15);

// Voucher aktif
RewardClaim::where('status', 'active')->get();

// Voucher yang sudah expired tapi belum diupdate
RewardClaim::where('status', 'active')
    ->where('expired_at', '<', now())->get();

// Reward terpopuler
RewardClaim::select('reward_id', 'nama', DB::raw('COUNT(*) as total'))
    ->groupBy('reward_id', 'nama')
    ->orderByDesc('total')->get();

// Update status voucher
RewardClaim::where('id', $id)->update(['status' => 'used']);
```

**❌ Belum ada di admin.** Perlu dibuatkan:
- Halaman list voucher/klaim
- Filter status (active/used/expired)
- Tombol update status

---

### 3.8 `news`
**Model:** `App\Models\News`  
**Fungsi:** Berita/informasi yang ditampilkan di halaman publik

| Kolom | Tipe | Keterangan |
|---|---|---|
| `id` | bigint PK | Auto-increment |
| `judul` | string | Judul berita |
| `slug` | string UNIQUE | URL-friendly slug |
| `konten` | text | Isi berita (HTML) |
| `gambar` | string nullable | Path gambar cover |
| `kategori` | enum | `info`, `promo`, `gangguan`, `tips` |
| `is_published` | boolean | `true` = tampil di publik |
| `published_at` | timestamp nullable | Tanggal terbit |
| `created_at` | timestamp | Waktu dibuat |
| `updated_at` | timestamp | Terakhir diupdate |

**Relasi:** Tidak ada (standalone)

**Label Kategori:**

| Kode | Label |
|---|---|
| `info` | Informasi |
| `promo` | Promo |
| `gangguan` | Gangguan |
| `tips` | Tips & Trik |

**Data yang bisa ditarik admin:**
- Daftar semua berita (published & draft)
- CRUD berita baru
- Publish/unpublish berita
- Filter per kategori

**Contoh Eloquent:**
```php
// Semua berita
News::latest('published_at')->paginate(15);

// Create berita baru
News::create([
    'judul'        => 'Judul Berita',
    'slug'         => Str::slug('Judul Berita'),
    'konten'       => '<p>Isi berita...</p>',
    'kategori'     => 'info', // info, promo, gangguan, tips
    'is_published' => true,
    'published_at' => now(),
]);

// Publish/unpublish
News::where('id', $id)->update(['is_published' => true, 'published_at' => now()]);

// Delete
News::findOrFail($id)->delete();
```

**❌ Belum ada di admin.** Perlu dibuatkan full CRUD.

---

### 3.9 `tariffs` & `tariff_categories`
**Model:** `App\Models\Tariff`, `App\Models\TariffCategory`  
**Fungsi:** Master data tarif listrik PLN

**Tabel `tariff_categories`:**

| Kolom | Tipe | Keterangan |
|---|---|---|
| `id` | bigint PK | Auto-increment |
| `kode` | string(10) UNIQUE | R, B, I, S |
| `nama` | string(100) | Rumah Tangga, Bisnis, dll |
| `deskripsi` | text nullable | Penjelasan kategori |

**Tabel `tariffs`:**

| Kolom | Tipe | Keterangan |
|---|---|---|
| `id` | bigint PK | Auto-increment |
| `tariff_category_id` | bigint FK | Relasi ke kategori |
| `kode` | string(20) UNIQUE | R1-450, R1-900, B1-6600, dll |
| `nama` | string(100) | Nama lengkap tarif |
| `daya_va` | integer | Kapasitas daya (VA) |
| `harga_per_kwh` | decimal(10,2) | Tarif per kWh (Rp) |
| `biaya_beban` | decimal(12,2) | Biaya beban bulanan |
| `biaya_pasang` | decimal(12,2) | Biaya pasang baru |
| `biaya_admin` | decimal(12,2) | Biaya admin pasang |
| `is_subsidi` | boolean | Apakah bersubsidi |

**Data saat ini (dari seeder):**

| Kode | Daya | Harga/kWh | Subsidi |
|---|---|---|---|
| R1-450 | 450 VA | Rp 415 | ✅ |
| R1-900 | 900 VA | Rp 605 | ✅ |
| R1-1300 | 1.300 VA | Rp 1.444,70 | ❌ |
| R1-2200 | 2.200 VA | Rp 1.444,70 | ❌ |
| R2-3500 | 3.500 VA | Rp 1.699,53 | ❌ |
| R3-6600 | 6.600 VA | Rp 1.699,53 | ❌ |
| B1-6600 | 6.600 VA | Rp 1.444,70 | ❌ |
| B2-10K | 10.600 VA | Rp 1.699,53 | ❌ |
| S2-900 | 900 VA | Rp 605 | ✅ |

**Contoh Eloquent:**
```php
Tariff::with('category')->orderBy('daya_va')->get();
Tariff::where('is_subsidi', true)->get();
```

**❌ Belum ada di admin.** Prioritas rendah (data jarang berubah).

---

### 3.10 `payment_methods`
**Model:** `App\Models\PaymentMethod`  
**Fungsi:** Master data metode pembayaran

| Kolom | Tipe | Keterangan |
|---|---|---|
| `id` | bigint PK | Auto-increment |
| `kode` | string(30) UNIQUE | qris, gopay, ovo, dana, bca, mandiri, bni, cash |
| `nama` | string(100) | Nama tampilan (QRIS, GoPay, dll) |
| `icon` | string nullable | Path ikon / CSS class |
| `is_active` | boolean | Aktif/nonaktif |

**Data saat ini:**

| Kode | Nama | Aktif |
|---|---|---|
| qris | QRIS | ✅ |
| gopay | GoPay | ✅ |
| ovo | OVO | ✅ |
| dana | DANA | ✅ |
| bca | Transfer BCA | ✅ |
| mandiri | Transfer Mandiri | ✅ |
| bni | Transfer BNI | ✅ |
| cash | Tunai | ❌ |

**Contoh Eloquent:**
```php
// Semua metode bayar
PaymentMethod::all();

// Aktifkan/nonaktifkan
PaymentMethod::where('id', $id)->update(['is_active' => false]);
```

**❌ Belum ada di admin.** Prioritas rendah.

---

## 4. Statistik Dashboard yang Bisa Ditampilkan

Berikut ringkasan data-data yang bisa ditampilkan di dashboard utama admin:

### Kartu Statistik (Summary Cards)
```php
$stats = [
    'total_pelanggan'       => Customer::count(),
    'pelanggan_aktif'       => Customer::where('status_aktif', true)->count(),
    'total_user'            => User::where('role', 'user')->count(),
    'total_transaksi'       => Transaction::count(),
    'transaksi_sukses'      => Transaction::where('status', 'success')->count(),
    'pendapatan_total'      => Transaction::where('status', 'success')->sum('amount'),
    'pendapatan_bulan_ini'  => Transaction::where('status', 'success')
                                ->whereMonth('created_at', now()->month)->sum('amount'),
    'tagihan_belum_lunas'   => Bill::whereIn('status', ['unpaid', 'overdue'])->count(),
    'total_piutang'         => Bill::whereIn('status', ['unpaid', 'overdue'])->sum('total_biaya'),
    'meter_pending'         => MeterReading::where('status', 'pending')->count(),
    'laporan_gangguan_baru' => OutageReport::where('status', 'dilaporkan')->count(),
    'voucher_aktif'         => RewardClaim::where('status', 'active')->count(),
    'berita_published'      => News::where('is_published', true)->count(),
];
```

### Grafik / Chart
```php
// Pendapatan per bulan (12 bulan terakhir)
$revenueByMonth = Transaction::where('status', 'success')
    ->selectRaw("DATE_FORMAT(created_at, '%Y-%m') as periode, SUM(amount) as total")
    ->where('created_at', '>=', now()->subMonths(12))
    ->groupBy('periode')->orderBy('periode')->get();

// Transaksi per tipe
$transactionByType = Transaction::where('status', 'success')
    ->select('type', DB::raw('COUNT(*) as total'))
    ->groupBy('type')->get();

// Gangguan per kategori
$outageByCategory = OutageReport::select('kategori', DB::raw('COUNT(*) as total'))
    ->groupBy('kategori')->get();
```

---

## 5. Status CRUD Admin yang Sudah Ada vs Belum

| Tabel | Route | Controller Method | Status |
|---|---|---|---|
| `customers` | `GET /admin/customers` | `AdminController@customers` | ✅ List |
| `customers` | `GET /admin/customers/create` | `AdminController@createCustomer` | ✅ Create form |
| `customers` | `POST /admin/customers` | `AdminController@storeCustomer` | ✅ Store |
| `customers` | `GET /admin/customers/{id}/edit` | `AdminController@editCustomer` | ✅ Edit form |
| `customers` | `PUT /admin/customers/{id}` | `AdminController@updateCustomer` | ✅ Update |
| `customers` | `DELETE /admin/customers/{id}` | `AdminController@deleteCustomer` | ✅ Delete |
| `transactions` | `GET /admin/transactions` | `AdminController@transactions` | ✅ List |
| `users` | — | — | ❌ Belum ada |
| `bills` | — | — | ❌ Belum ada (hanya count di stats) |
| `meter_readings` | — | — | ❌ Belum ada |
| `outage_reports` | — | — | ❌ Belum ada |
| `reward_claims` | — | — | ❌ Belum ada |
| `news` | — | — | ❌ Belum ada |
| `tariffs` | — | — | ❌ Belum ada |
| `payment_methods` | — | — | ❌ Belum ada |

---

## 6. Contoh Eloquent Query untuk Admin

### Import Model yang Dibutuhkan
```php
use App\Models\User;
use App\Models\Customer;
use App\Models\Transaction;
use App\Models\Bill;
use App\Models\MeterReading;
use App\Models\OutageReport;
use App\Models\RewardClaim;
use App\Models\News;
use App\Models\Tariff;
use App\Models\TariffCategory;
use App\Models\PaymentMethod;
```

### Quick Reference: Ambil Semua Data Per Tabel
```php
// 1. Users
User::where('role', 'user')->with('customers')->latest()->paginate(15);

// 2. Customers (sudah ada)
Customer::with(['user', 'tariff.category'])->latest()->paginate(15);

// 3. Transactions (sudah ada)
Transaction::with(['user', 'customer', 'paymentMethod', 'bill'])->latest()->paginate(15);

// 4. Bills
Bill::with(['customer.tariff', 'meterReading'])->latest('tahun')->latest('bulan')->paginate(15);

// 5. Meter Readings
MeterReading::with('customer.tariff')->latest('tahun')->latest('bulan')->paginate(15);

// 6. Outage Reports
OutageReport::with(['user', 'customer'])->latest()->paginate(15);

// 7. Reward Claims
RewardClaim::with('user')->latest()->paginate(15);

// 8. News
News::latest('published_at')->paginate(15);

// 9. Tariffs
Tariff::with('category')->orderBy('daya_va')->get();

// 10. Payment Methods
PaymentMethod::all();
```

---

> 📝 **Dokumen ini dibuat untuk tim admin dashboard agar bisa menarik semua data dari database PLN DIGI.**  
> Setiap data yang masuk dari operasi CRUD user **sudah terkirim ke database** dan siap digunakan.  
> Terakhir diperbarui: September 2026 | Versi: 1.0

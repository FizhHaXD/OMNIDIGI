# DOKUMENTASI SISTEM & PANDUAN LENGKAP FITUR USER
## Landing Page Publik, Layanan Produk, Simulasi Kelistrikan, Portal Berita, dan User Dashboard (PLN DIGI)

---

### Informasi Dokumen
* **Topik:** Bedah Lengkap Fitur Pengguna (User Features & Public Pages)
* **Aplikasi:** PLN DIGI (OMNIDIGI) — Platform Layanan Kelistrikan Digital Terpadu
* **Framework Backend:** Laravel 13 MVC
* **Framework Frontend:** Blade Templating, Tailwind CSS 3.4, Alpine.js Reactive Components
* **Format Penulisan:** Formal, terstruktur, mendalam, tanpa elemen emoji, siap dijadikan acuan materi presentasi dan demo aplikasi.

---

## DAFTAR ISI MODUL
1. [Modul 1: Landing Page Publik & Entry Point Layanan Kelistrikan](#modul-1-landing-page-publik--entry-point-layanan-kelistrikan)
2. [Modul 2: Portal Produk & Alur Transaksi Pembayaran](#modul-2-portal-produk--alur-transaksi-pembayaran)
3. [Modul 3: Kalkulator Simulasi Tarif & Beban Perangkat Elektronik](#modul-3-kalkulator-simulasi-tarif--beban-perangkat-elektronik)
4. [Modul 4: Portal Berita, Tips Edukasi & Pengumuman Jaringan](#modul-4-portal-berita-tips-edukasi--pengumuman-jaringan)
5. [Modul 5: User Dashboard Utama & Smart Promo Carousel](#modul-5-user-dashboard-utama--smart-promo-carousel)
6. [Modul 6: Layanan Mandiri Terintegrasi di Dashboard](#modul-6-layanan-mandiri-terintegrasi-di-dashboard)
7. [Naskah Bicara Lengkap Presenter Sisi User (Verbatim Speech)](#naskah-bicara-lengkap-presenter-sisi-user-verbatim-speech)

---

## MODUL 1: LANDING PAGE PUBLIK & ENTRY POINT LAYANAN KELISTRIKAN
* **URL Akses:** `/`
* **Controller:** `App\Http\Controllers\HomeController`
* **View Template:** `resources/views/home.blade.php`

### 1.1 Filosofi Zero Friction & Hero Section Fast Lookup
Landing page utama dirancang agar calon pelanggan maupun pelanggan terdaftar dapat memperoleh informasi penting secara instan tanpa hambatan autentikasi awal. Di area Hero Section, disediakan widget pencarian berbasis 12 digit ID Pelanggan atau nomor meteran fisik. Sistem melakukan kueri asinkron untuk mencocokkan nomor identitas pelanggan dan menampilkan ringkasan status rekening aktif.

### 1.2 Katalog Layanan Terpadu & Accordion FAQ Interaktif
Menyajikan lima pilar layanan kelistrikan:
* Pembayaran Tagihan Listrik Pascabayar
* Pembelian Token Listrik Prabayar (Stroom)
* Simulasi Pasang Sambungan Baru & Tambah Daya
* SwaCAM Catat Meter Mandiri
* Layanan Pengaduan Gangguan 24 Jam Contact Center 123

Komponen FAQ di bagian bawah halaman menggunakan reactive state Alpine.js (`x-data="{ open: null }"`), memungkinkan transisi buka-tutup akordeon berjalan mulus tanpa membebani browser dengan library eksternal.

#### Cuplikan Implementasi Kode:
```php
// File: app/Http/Controllers/HomeController.php
public function index()
{
    $news = News::published()->latest()->take(3)->get();
    $tariffs = Tariff::with('category')->orderBy('daya_va')->take(6)->get();
    return view('home', compact('news', 'tariffs'));
}
```

---

## MODUL 2: PORTAL PRODUK & ALUR TRANSAKSI PEMBAYARAN
* **URL Akses:** `/produk`, `/produk/tagihan`, `/produk/token`
* **Controller:** `App\Http\Controllers\ProdukController` & `PembayaranController`
* **View Template:** `resources/views/produk/*`

### 2.1 Transaksi Tagihan Pascabayar
Modul `/produk/tagihan` menyajikan rincian lengkap dari tagihan rekening bulanan:
* ID Pelanggan dan Nama Pemilik Rekening
* Golongan Tarif (R-1, R-2, B-1, dll.) dan Kapasitas Daya (VA)
* Stand Meter Awal dan Stand Meter Akhir
* Total Pemakaian Energi Listrik (kWh) dan Tarif per kWh
* Komponen Biaya: Biaya Beban, Pajak Penerangan Jalan (PPJ), Biaya Admin Bank, serta Denda Keterlambatan jika melewati jatuh tempo tanggal 20.

### 2.2 Pembelian Token Listrik Prabayar
Modul `/produk/token` menyediakan variasi nominal pembelian: Rp 20.000, Rp 50.000, Rp 100.000, Rp 200.000, Rp 500.000, dan Rp 1.000.000. Sistem menghitung potongan PPJ daerah secara transparan dan mengkalkulasi jumlah kWh bersih yang didapatkan pelanggan, lalu menerbitkan 20 digit nomor token stroom berformat STS (Standard Transfer Specification).

### 2.3 Kanal Pembayaran Multi-Channel & Struk Digital Resmi
Mendukung tiga kanal pembayaran:
1. **QRIS Dinamis:** Disediakan simulasi pemindaian QRIS via endpoint `/bayar/qris/simulasi/{kode}` untuk demonstrasi pengujian instan.
2. **Virtual Account Bank:** Rekening penampung resmi (BCA, Mandiri, BNI, BRI).
3. **E-Wallet Terintegrasi:** Dompet digital (GoPay, OVO, DANA).

Setiap transaksi yang berhasil secara otomatis menerbitkan lembar Struk Bukti Pembayaran Digital berstandar perbankan yang dilengkapi QR verifikasi transaksi dan rincian transaksi lengkap.

#### Cuplikan Implementasi Kode:
```php
// File: app/Http/Controllers/ProdukController.php
// Pembentukan 20 Digit Nomor Token Format 4x5 Digit
$rawToken = '';
for ($i = 0; $i < 5; $i++) {
    $rawToken .= str_pad((string) random_int(1000, 9999), 4, '0', STR_PAD_LEFT) . ' ';
}
$tokenListrik = trim($rawToken);

// Perhitungan KWh Bersih Prabayar
$ppj = $amount * 0.05; // Pajak Penerangan Jalan 5%
$netAmount = $amount - $ppj - $adminFee;
$kwhEarned = round($netAmount / $tariff->harga_per_kwh, 1);
```

---

## MODUL 3: KALKULATOR SIMULASI TARIF & BEBAN PERANGKAT ELEKTRONIK
* **URL Akses:** `/simulasi` (Publik) & `/dashboard/simulasi` (Pengguna Terdaftar)
* **Controller:** `App\Http\Controllers\SimulasiController` & `DashboardController::simulasiKeuangan`

### 3.1 Simulasi Sambungan Pasang Baru & Tambah Daya
Mengacu pada penetapan tarif resmi Kementerian ESDM:
* Pengguna memilih golongan peruntukan: Rumah Tangga (R), Bisnis (B), Industri (I), atau Sosial (S).
* Memilih besaran daya mulai dari 450 VA bersubsidi hingga 66.000 VA industri.
* Sistem menghitung: Biaya Pasang (BP) + Biaya Administrasi + PPN 11% = Estimasi Total Investasi Sambungan Baru.

### 3.2 Appliance Calculator (Estimasi Penggunaan Alat Elektronik)
Pada menu `/dashboard/simulasi`, pengguna dapat menghitung estimasi biaya bulanan berdasarkan perangkat elektronik di rumah mereka:
* AC (Air Conditioner): 750 Watt x 8 Jam/Hari
* Kulkas 2 Pintu: 120 Watt x 24 Jam/Hari
* TV LED: 80 Watt x 5 Jam/Hari
* Mesin Cuci: 350 Watt x 2 Jam/Hari
* Pompa Air & Lampu Penerangan

Sistem mengalkulasikan proyeksi total konsumsi kWh dan tagihan rupiah bulanan, membantu pelanggan mengontrol anggaran energi keluarga.

#### Cuplikan Implementasi Kode:
```php
// File: app/Http/Controllers/SimulasiController.php
public function hitung(Request $request)
{
    $request->validate(['tariff_id' => 'required|exists:tariffs,id']);
    $tariff = Tariff::findOrFail($request->tariff_id);

    $biayaPasang = $tariff->biaya_pasang;
    $biayaAdmin = $tariff->biaya_admin;
    $ppn = round(($biayaPasang + $biayaAdmin) * 0.11, 2);
    $total = round(($biayaPasang + $biayaAdmin) * 1.11, 2);

    return view('simulasi.index', compact('tariff', 'result'));
}
```

---

## MODUL 4: PORTAL BERITA, TIPS EDUKASI & PENGUMUMAN JARINGAN
* **URL Akses:** `/news`, `/news/{slug}`
* **Controller:** `App\Http\Controllers\NewsController`
* **View Template:** `resources/views/news/*`

### 4.1 Edukasi Kelistrikan & Efisiensi Energi
Menyajikan artikel informatif mengenai tips penghematan listrik, penggunaan instalasi kabel berstandar SNI, serta panduan keselamatan ketenagalistrikan saat cuaca ekstrem.

### 4.2 Sosialisasi Promo & Jadwal Pemeliharaan Jaringan
Menyediakan publikasi resmi promo diskon tambah daya tahun 2026 dan transparansi pengumuman jadwal pemeliharaan jaringan terencana (planned outage) agar masyarakat dapat mempersiapkan diri sebelum pemadaman pemeliharaan berlangsung.

---

## MODUL 5: USER DASHBOARD UTAMA & SMART PROMO CAROUSEL
* **URL Akses:** `/dashboard` (Memerlukan Autentikasi Pengguna)
* **Controller:** `App\Http\Controllers\DashboardController::index`
* **View Template:** `resources/views/dashboard/index.blade.php`

### 5.1 Customer Command Center
Merangkum profil identitas pelanggan terintegrasi:
* Nomor ID Pelanggan 12 digit dan Nomor Seri KWh Meter fisik
* Golongan Tarif dan Daya Terpasang (VA)
* Status Sambungan Aktif

### 5.2 Widget Tagihan Aktif & Peringatan Jatuh Tempo
Menampilkan status tagihan bulan berjalan secara visual:
* Jika terdapat tagihan belum lunas, ditampilkan nominal rupiah, rincian biaya, tombol bayar instan, serta penanda jatuh tempo tanggal 20.
* Jika sudah lunas, ditampilkan status 'Tagihan Lunas' dengan verifikasi waktu pembayaran.

### 5.3 Smart Auto-Slide Promo Carousel
Komponen promosi interaktif pada kolom kanan dashboard:
* Memuat 4 slide materi edukasi resmi:
  1. Slide 1: KWh Meter Pintar (Advanced Metering Infrastructure - AMI)
  2. Slide 2: Promo Diskon Tambah Daya 2026 (Hemat s/d 50%)
  3. Slide 3: PLN DigiPoints & Reward Token Listrik
  4. Slide 4: Layanan Catat Meter Mandiri (SwaCAM)
* Fitur Interaktif:
  - Perpindahan otomatis setiap 5 detik dengan transisi horizontal CSS yang mulus.
  - Top progress bar animasi sebagai indikator waktu pergantian slide.
  - Mekanisme jeda otomatis (pause on hover) saat kursor mouse diarahkan ke kartu.
  - Navigasi dot indikator di bawah kartu yang dapat diklik langsung.
  - Tombol navigasi panah kiri dan kanan.
  - Dukungan sentuhan gestur geser (touch swipe) pada perangkat smartphone/tablet.

### 5.4 Widget Token Terakhir & Riwayat Transaksi
* Menampilkan kode 20 digit token listrik terakhir yang berhasil dibeli pelanggan beserta tanggal pembelian.
* Tabel riwayat 6 transaksi terakhir dengan status (Berhasil, Menunggu, Gagal) dan tautan cetak struk digital.

#### Cuplikan Implementasi Kode Carousel:
```html
<!-- File: resources/views/dashboard/index.blade.php -->
<div x-data="{
    active: 0,
    total: 4,
    progress: 0,
    duration: 5000,
    startAutoSlide() {
        this.progressTimer = setInterval(() => {
            this.progress += (50 / this.duration) * 100;
            if (this.progress >= 100) this.next();
        }, 50);
    },
    stopAutoSlide() { clearInterval(this.progressTimer); },
    next() { this.active = (this.active + 1) % this.total; this.progress = 0; }
}"
@mouseenter="stopAutoSlide()"
@mouseleave="startAutoSlide()">
    <!-- Track Flex Slide -->
    <div class="flex transition-transform duration-500 ease-out"
         :style="`transform: translateX(-${active * 100}%);`">
        <!-- Slide Items 1 s/d 4 -->
    </div>
</div>
```

---

## MODUL 6: LAYANAN MANDIRI TERINTEGRASI DI DASHBOARD

### 6.1 Catat Meter Mandiri / SwaCAM (`/dashboard/metering`)
Memungkinkan pelanggan pascabayar mengunggah foto angka stand meteran mandiri setiap tanggal 24 hingga 27 setiap bulannya. Menghilangkan ketergantungan pada petugas pencatat meter keliling dan meningkatkan transparansi perhitungan tagihan.

### 6.2 Monitoring Riwayat Konsumsi kWh & Biaya (`/dashboard/monitoring`)
Visualisasi riwayat pemakaian energi dalam grafik interaktif bulanan, memberikan evaluasi tren pemakaian listrik dan analisis efisiensi pengeluaran energi keluarga.

### 6.3 Program Loyalitas PLN DigiPoints & Voucher Reward (`/dashboard/reward`)
Sistem loyalitas otomatis: setiap transaksi pembayaran tagihan sebelum tanggal 20 menghasilkan poin reward. Poin yang terkumpul dapat ditukarkan langsung menjadi kupon diskon token listrik senilai Rp 10.000 hingga Rp 100.000.

### 6.4 Pelaporan Gangguan Kelistrikan / Outage Report (`/dashboard/outage`)
Fasilitas pelaporan pemadaman listrik atau kerusakan meteran dengan bukti foto lokasi. Pelanggan dapat memantau proses penanganan dari status Dilaporkan, Diproses, hingga Selesai oleh tim teknis lapangan.

---

## NASKAH BICARA LENGKAP PRESENTER SISI USER (VERBATIM SPEECH)
*Gunakan naskah di bawah ini sebagai panduan berbicara saat mempresentasikan modul sisi Pengguna dan Landing Page kepada dewan juri:*

> "Selamat pagi/siang Bapak dan Ibu Dewan Juri yang saya hormati. Pada sesi ini, saya akan membedah arsitektur antarmuka dan modul layanan pengguna pada platform PLN DIGI.
>
> Filosofi utama yang kami terapkan pada sisi publik dan pengguna adalah Zero Friction—memberikan akses layanan kelistrikan yang cepat, transparan, dan tanpa hambatan birokrasi.
>
> Dimulai dari Landing Page utama, masyarakat dapat langsung mengecek status rekening atau tagihan berjalan hanya dengan memasukkan 12 digit ID Pelanggan di Hero Section, tanpa diwajibkan melewati proses registrasi yang berbelit. Di halaman ini juga kami integrasikan portal berita edukasi efisiensi energi, informasi promo resmi, serta modul tanya-jawab interaktif berbasis Alpine.js yang sangat ringan.
>
> Masuk ke modul Produk dan Transaksi, kami menjawab permasalahan klasik ketidakterbukaan komponen tagihan. Pada layanan pascabayar, rincian stand meter awal, stand akhir, dan perhitungan tarif per kWh disajikan secara gamblang. Untuk pelanggan prabayar, sistem mengalkulasi potongan PPJ daerah dan mengonversi nominal rupiah menjadi kuota kWh bersih secara transparan, kemudian menerbitkan 20 digit kode stroom unik secara instan. Kanal pembayarannya sangat adaptif: mulai dari QRIS dinamis yang dilengkapi simulator pemindaian, hingga Virtual Account perbankan dan penerbitan struk transaksi resmi berstandar perbankan.
>
> Nilai tambah edukatif kami hadirkan melalui Kalkulator Simulasi Kelistrikan. Calon pelanggan dapat menghitung estimasi biaya penyambungan baru atau penambahan daya berdasarkan regulasi tarif resmi Kementerian ESDM secara transparan. Di dashboard pelanggan, kami bahkan menyediakan Appliance Calculator untuk memproyeksikan beban pemakaian alat elektronik rumah tangga seperti AC, kulkas, dan pompa air.
>
> Puncaknya pada Dashboard Pengguna Terdaftar, pelanggan memiliki kendali operasional mandiri: memantau hitung mundur jatuh tempo tagihan tanggal 20, mengecek token terakhir yang dibeli, serta menikmati Smart Promo Carousel interaktif di sisi kanan yang berpindah otomatis setiap 5 detik dengan kemampuan jeda saat di-hover. Pelanggan juga dapat mencatat angka meter mandiri lewat fitur SwaCAM pada tanggal 24 sampai 27, memantau grafik riwayat pemakaian energi di menu Monitoring, menukarkan poin loyalitas DigiPoints menjadi voucher diskon token, serta membuat tiket pengaduan gangguan listrik yang status perbaikannya terpantau secara real-time.
>
> Inilah wujud transformasi layanan digital kelistrikan yang mengedepankan transparansi, kemudahan, dan pemberdayaan konsumen. Sekian pemaparan dari sisi pengguna, terima kasih."

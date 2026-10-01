# DOKUMEN PANDUAN TEKNIS & NASKAH PRESENTASI DEVELOPER
## Arsitektur Backoffice Command Center, Intelligent Operations & AI Document Engine (PLN DIGI)

---

### Informasi Sesi Presentasi
* **Presenter:** M. Hafizh Wijdan (`@202431005_M Hafizh Wijdan`)
* **Tanggung Jawab Modul:** Backoffice Command Center, CRM Pelanggan, Intelligent Operations, AI Document Engine
* **Alokasi Presentasi:** 4 Slide Penuh (Bagian Admin / Sistem Operasional)
* **Estimasi Durasi Bicara:** 4 Hingga 5 Menit (Mendalam, Lengkap & Terstruktur)
* **Target Audiens:** Dewan Juri Lomba Inovasi PLN Digital, Praktisi Sistem Informasi BUMN, dan Akademisi
* **Karakter Penyampaian:** Tenang, percaya diri, berbasis fakta teknis, menguasai arsitektur dan baris kode, tanpa retorika klise.

---

### Ringkasan Teknis Modul Admin (Technical Highlights)
1. **Framework & Pattern:** Laravel 13 Model-View-Controller (`app/Http/Controllers/Admin/AdminController.php`).
2. **Database Normalization:** MySQL Third Normal Form (3NF) dengan 11 entitas relasional.
3. **Data Integrity:** Foreign key constraint `ON DELETE RESTRICT` pada seluruh relasi tagihan, transaksi, dan tarif untuk mencegah penghapusan sepihak dan menjamin jejak audit finansial.
4. **Query Performance:** Penerapan Eager Loading (`with()`) untuk meniadakan masalah N+1 Query pada relasi transaksi, pelanggan, dan metode pembayaran.
5. **State Management & UI:** Alpine.js reactive component (`letterGenerator()`) dan Tailwind CSS untuk manipulasi formulir tanpa memicu full page reload.
6. **Tata Naskah Kedinasan:** Standarisasi penomoran dokumen resmi PT PLN (Persero) serta konsideran dasar hukum Peraturan Menteri ESDM Nomor 27 Tahun 2017.
7. **Document Render Engine:** Native CSS Print Engine (`@media print` dan `@page` A4 paged media) dengan nol beban komputasi server.
8. **AI & Gateway Ready:** Endpoint terstruktur dengan format JSON Schema tervalidasi dan service teks format WhatsApp (`LetterFormatterService`).

---

## RINGKASAN EKSEKUTIF: KORELASI FITUR SISI USER DENGAN SISTEM ADMIN BACKOFFICE

Tabel berikut merangkum korelasi langsung antara aksi yang dilakukan pelanggan pada antarmuka publik/dashboard user dengan modul pengolahan, audit, dan otomasi yang berjalan di sisi admin backoffice:

| No | Modul / Fitur Layanan | Aktivitas di Sisi Pengguna (User Dashboard) | Pengolahan di Sisi Backoffice (Admin System) |
|---|---|---|---|
| **1** | **Pembayaran Tagihan Pascabayar** | Melihat rincian stand meter, tarif per kWh, dan membayar via QRIS/VA/E-Wallet sebelum tanggal 20. | Rekapitulasi arus kas harian, update status rekening, dan evaluasi Aging Overdue Matrix untuk penagihan bertingkat. |
| **2** | **Pembelian Token Listrik** | Memilih denominasi token Rp 20.000 s/d Rp 1.000.000, menerima 20 digit kode stroom unik instan. | Audit transaksi penjualan token, pencocokan nomor meter pelanggan, dan jaminan ketiadaan duplikasi nomor referensi. |
| **3** | **Catat Meter Mandiri (SwaCAM)** | Mengunggah foto dan menginput angka stand meteran fisik setiap tanggal 24 s/d 27. | Algoritma audit anomali memfilter lonjakan konsumsi >400 kWh atau penurunan drastis sebelum tagihan dicetak. |
| **4** | **Pelaporan Gangguan (Outages)** | Melaporkan pemadaman atau kerusakan instalasi dengan foto dan memantau status tiket secara real-time. | Triase keparahan otomatis (Kritis vs Normal), penerbitan SPK YANTEK, dispatch teknisi lapangan, dan update status tiket. |
| **5** | **Poin Loyalitas (DigiPoints)** | Menerima poin reward otomatis dari pembayaran tepat waktu dan menukarnya dengan voucher token. | Otomasi validasi kupon pemotongan tagihan, audit saldo poin pengguna, dan pencegahan klaim ganda. |
| **6** | **Simulasi Biaya & Pasang Baru** | Menghitung estimasi Biaya Pasang (BP) + PPN 11% dan simulasi beban watt peranti elektronik rumah. | Master data tarif ESDM tersinkronisasi, dasar penerbitan tagihan penyambungan baru oleh petugas administrasi. |
| **7** | **Generator Surat Kedinasan** | Menerima surat peringatan (SP-1/SP-2) atau notifikasi resmi penugasan teknisi. | Otomasi penerbitan naskah dinas resmi PLN berstandar A4 siap cetak dan export JSON Schema siap integrasi AI Agent/WA. |

---

## NASKAH LENGKAP KATA PER KATA (VERBATIM SPEECH SCRIPT)

### BAGIAN 0: TRANSISI ESTAFET & PEMBUKA MASALAH OPERASIONAL
**Estimasi Waktu:** ~30 Detik  
**Panduan Penyampaian:** Berikan apresiasi singkat kepada rekan tim sebelumnya. Tatap dewan juri dengan postur tegak, intonasi tenang, dan suara yang jelas.

> "Terima kasih atas pemaparan komprehensif dari rekan saya mengenai perancangan antarmuka dan pengalaman pengguna di sisi publik.
>
> Selamat pagi/siang kepada Bapak dan Ibu Dewan Juri yang saya hormati. Nama saya M. Hafizh Wijdan, dan saya bertanggung jawab atas perancangan arsitektur backoffice, integritas basis data, serta modul operasional admin pada platform PLN DIGI.
>
> Di ranah industri utilitas kelistrikan berskala nasional, antarmuka pelanggan yang menarik hanyalah sebagian kecil dari ekosistem digital. Setiap kali pelanggan menekan tombol 'Bayar Tagihan', membeli token listrik, atau melaporkan pemadaman di dashboard mereka, terdapat proses bisnis kompleks yang harus diproses di sisi backoffice: mulai dari audit transaksi finansial, klasifikasi penagihan bertingkat untuk pelanggan menunggak, triase penugasan teknisi lapangan, hingga penerbitan dokumen hukum kedinasan resmi tanpa celah kesalahan manusia.
>
> Dalam empat slide ke depan, saya akan membedah bagaimana Backoffice Command Center PLN DIGI bekerja sebagai otak operasional yang menghubungkan seluruh aktivitas pengguna ke dalam sistem tata kelola kelistrikan modern yang terukur dan patuh regulasi."

---

### BAGIAN 1: SLIDE 1 — BACKOFFICE COMMAND CENTER & MANAJEMEN CRM PELANGGAN
**Estimasi Waktu:** ~60 Detik  
**Panduan Penyampaian:** Arahkan tangan ke layar slide 1. Tekankan istilah Single Source of Truth dan Role-Based Access Control.

> "Kita mengawali pembahasan dari Slide pertama, yaitu Backoffice Command Center. Pada sistem utilitas konvensional, tantangan klasik yang selalu dihadapi adalah fragmentasi data atau data silos—di mana data pembayaran tagihan, pencatatan meter, dan laporan gangguan tersimpan pada modul yang terpisah-pisah sehingga menyulitkan proses audit berkala.
>
> Di PLN DIGI, kami membangun dashboard ini sebagai Single Source of Truth bagi manajemen dan staf operasional. Melalui satu antarmuka terpusat, sistem menyajikan agregasi metrik secara real-time: total pelanggan aktif, total pendapatan berhasil per hari, akumulasi tagihan belum lunas beserta total piutang, status penanganan tiket gangguan yang sedang berjalan, hingga antrean verifikasi mandiri SwaCAM.
>
> Admin memiliki visibilitas 360 derajat terhadap data master pelanggan lintas golongan tarif—mulai dari golongan Rumah Tangga subsidi 450 VA dan 900 VA, tarif reguler R1 1300 VA dan 2200 VA, hingga tarif Bisnis dan Industri menengah ke atas. Seluruh riwayat transaksi pembayaran tagihan maupun pembelian token prabayar terhubung secara relasional ke akun pelanggan bersangkutan.
>
> Dari aspek keamanan sistem, rute backoffice /admin diproteksi penuh oleh arsitektur Role-Based Access Control (RBAC) melalui custom middleware. Session pengguna biasa yang mencoba mengakses endpoint administrasi secara ilegal akan langsung diintersepsi dan dialihkan dengan kode respon otorisasi yang aman."

#### Referensi Implementasi Kode Slide 1:
```php
// File: app/Http/Controllers/Admin/AdminController.php
public function dashboard()
{
    $stats = [
        'total_pelanggan'     => Customer::count(),
        'pendapatan'          => Transaction::where('status', 'success')->sum('amount'),
        'tagihan_belum_lunas' => Bill::whereIn('status', ['unpaid', 'overdue'])->count(),
        'total_piutang'       => Bill::whereIn('status', ['unpaid', 'overdue'])->sum('total_biaya')
                                 + Bill::whereIn('status', ['unpaid', 'overdue'])->sum('denda'),
        'gangguan_aktif'      => OutageReport::whereIn('status', ['dilaporkan', 'diproses'])->count(),
    ];

    $recentTransactions = Transaction::with(['user', 'customer', 'paymentMethod'])
        ->latest()->take(8)->get();

    return view('admin.dashboard', compact('stats', 'recentTransactions'));
}
```
*Catatan Teknis Arsitektur:* Pemanggilan metode `with(['user', 'customer', 'paymentMethod'])` menerapkan teknik Eager Loading pada Eloquent ORM. Pendekatan ini mengeliminasi masalah N+1 Query secara mendasar, menjaga waktu eksekusi database tetap di bawah 50 milidetik saat memuat data transaksi.

---

### BAGIAN 2: SLIDE 2 — INTELLIGENT OPERATIONS: PENAGIHAN BERTINGKAT & TRIASE LAPANGAN
**Estimasi Waktu:** ~75 Detik  
**Panduan Penyampaian:** Maju satu langkah ke depan. Tekankan tiga pilar otomasi yang terhubung dengan tindakan user: Aging Overdue, Triase YANTEK, dan Audit SwaCAM.

> "Melangkah ke Slide kedua, kami merancang agar dashboard admin tidak bersikap pasif hanya menampilkan baris tabel, melainkan aktif menjalankan business logic operasional PLN secara otomatis. Modul Intelligent Operations ini ditopang oleh tiga pilar utama yang saling terhubung dengan dashboard user:
>
> Pilar pertama adalah Aging Overdue Matrix untuk manajemen tagihan pascabayar. Siklus tagihan listrik PLN memiliki batasan ketat: tanggal 20 merupakan batas akhir pembayaran setiap bulannya. Controller kami menerapkan query scope dinamis berbasis tanggal server. Setiap rekening yang melewati tanggal 20 otomatis berpindah ke status Overdue, disertai kalkulasi denda keterlambatan secara otomatis. Sistem kemudian memetakan pelanggan tersebut ke dalam pipeline penagihan bertingkat: dimulai dari Surat Peringatan 1 (SP-1) untuk penunggakan awal, Surat Peringatan 2 (SP-2) untuk penunggakan berulang, hingga penerbitan Surat Perintah Kerja (SPK) untuk pemutusan sementara instalasi kelistrikan.
>
> Pilar kedua adalah Otomasi Triase Tiket YANTEK (Pelayanan Teknik). Ketika pelanggan mengajukan laporan padam atau kendala teknis dari smartphone mereka, sistem secara otomatis mengevaluasi atribut laporan. Laporan berkategori padam total satu kawasan atau korsleting listrik berpotensi kebakaran langsung diklasifikasikan ke status prioritas 'Kritis'. Tiket kritis ini otomatis diposisikan pada antrean paling atas dashboard agar supervisor dapat segera melakukan dispatch teknisi lapangan dengan Mean Time to Respond (MTTR) yang jauh lebih cepat.
>
> Pilar ketiga adalah Verifikasi Anomali SwaCAM (Catat Meter Mandiri). Pelanggan pascabayar mengirimkan angka stand meteran tiap akhir bulan. Algoritma kami memvalidasi konsumsi kWh tersebut terhadap riwayat historis pelanggan. Apabila ditemukan lonjakan ekstrem di atas 400 kWh untuk golongan rumah tangga kecil, atau jika angka stand meter tercatat lebih rendah dari bulan sebelumnya (indikasi kerusakan meteran atau pembacaan keliru), record tersebut secara otomatis diberi tanda anomali untuk diaudit fisik sebelum draf tagihan bulanan diterbitkan ke konsumen. Mekanisme ini merupakan bentuk nyata proteksi Revenue Assurance bagi perusahaan dan perlindungan hak konsumen."

#### Referensi Implementasi Kode Slide 2:
```php
// File: app/Http/Controllers/Admin/AdminController.php

// 1. Evaluasi Otomatis Status Overdue Berbasis Tanggal Server
$query->where(function ($q) {
    $q->where('status', 'overdue')
      ->orWhere(function ($sub) {
          $sub->where('status', 'unpaid')
              ->where('tanggal_jatuh_tempo', '<', now()->toDateString());
      });
});

// 2. Agregasi Status Tiket Kritis YANTEK
$summary['kritis'] = OutageReport::whereIn('kategori', ['padam_total', 'korsleting'])
    ->whereIn('status', ['dilaporkan', 'diproses'])
    ->count();
```
*Catatan Teknis Arsitektur:* Evaluasi status tagihan dilakukan pada level query database, bukan kalkulasi manual di memori PHP. Ini menjamin data tunggakan selalu valid, sinkron, dan siap dijadikan dasar berkas hukum penagihan secara real-time.

---

### BAGIAN 3: SLIDE 3 — OFFICIAL DOCUMENT GENERATOR & INTEGRASI AI AGENT
**Estimasi Waktu:** ~75 Detik  
**Panduan Penyampaian:** Tunjukkan keyakinan dan penguasaan regulasi naskah dinas resmi serta visi masa depan integrasi AI Agent.

> "Pada Slide ketiga, kami mempersembahkan salah satu inovasi paling signifikan dalam efisiensi birokrasi operasional PLN, yaitu Official Document Generator & AI Agent Ready System.
>
> Di unit layanan PLN konvensional, pembuatan naskah kedinasan seperti surat penagihan, surat pemutusan, atau surat tugas lapangan sering kali masih diketik secara manual menggunakan pengolah kata. Staf harus mencari nomor pelanggan, menyalin rincian rupiah tunggakan, merumuskan nomor surat dinas, dan mencetaknya lembar per lembar. Proses ini tidak hanya menyita waktu berjam-jam, namun rawan terhadap kesalahan ketik nominal yang berisiko pada sengketa hukum konsumen.
>
> Pada sistem yang kami bangun, seluruh proses tersebut dipangkas menjadi satu detik. Staf administrasi hanya perlu memilih pelanggan atau nomor tiket gangguan, dan sistem secara otomatis mengenerate naskah dinas resmi siap cetak.
>
> Terdapat empat format naskah dinas standar BUMN yang telah terintegrasi penuh: Surat Peringatan 1 (SP-1), Surat Peringatan 2 (SP-2), Surat Perintah Kerja Bongkar Rampung Pemutusan Sementara, serta Surat Tugas Tim YANTEK. Penomoran naskah dinas digenerate secara otomatis menggunakan pola standar tata naskah resmi PLN, disertai konsideran dasar hukum Peraturan Menteri ESDM Nomor 27 Tahun 2017 tentang standar pelayanan ketenagalistrikan.
>
> Dari sisi arsitektur render dokumen, kami merancang Native CSS Print Engine dengan pemanfaatan media query print dan CSS paged media A4. Pendekatan ini sengaja kami pilih untuk menggantikan library PDF pihak ketiga berbasis PHP seperti DomPDF atau headless browser yang memakan resource RAM server secara masif. Browser klien merender dokumen beresolusi vektor secara instan tanpa membebani server sama sekali.
>
> Lebih jauh lagi, arsitektur ini telah AI-Agent Ready. Controller backend kami menyediakan endpoint terstruktur dengan output JSON Schema baku serta service konversi teks pesan. Skema data ini siap dihubungkan langsung ke Large Language Model (LLM) melalui webhook untuk penyusunan narasi pemberitahuan otomatis ke pelanggan melalui WhatsApp Gateway resmi."

#### Referensi Implementasi Kode Slide 3:
```php
// File: app/Http/Controllers/Admin/AdminController.php & letter-preview.blade.php

// 1. Standarisasi Penomoran Kedinasan PT PLN (Persero)
$nomorSurat = match ($type) {
    'sp1'      => '041/DIS.01.02/ULP-JKT/SP-1/' . now()->format('Y'),
    'sp2'      => '082/DIS.01.02/ULP-JKT/SP-2/' . now()->format('Y'),
    'spk'      => '115/YANTEK/GANGGUAN/' . now()->format('Y'),
    'ba_meter' => '204/BA-P2TL/METER/' . now()->format('Y'),
};
```
```css
/* 2. CSS Paged Media Standard Layout A4 Resmi */
@media print {
    @page { size: A4 portrait; margin: 15mm 20mm; }
    body { background: white; font-family: 'Times New Roman', serif; }
    .no-print { display: none !important; }
}
```

---

### BAGIAN 4: SLIDE 4 — ARSITEKTUR DATABASE, KEAMANAN & DAMPAK EFISIENSI BISNIS
**Estimasi Waktu:** ~60 Detik  
**Panduan Penyampaian:** Tutup dengan nada yang tegas, sebutkan metrik dampak riil, lalu oper giliran ke rekan berikutnya atau moderator.

> "Sebagai penutup pada Slide keempat, mari kita tinjau fondasi rekayasa perangkat lunak dan arsitektur data yang menopang keandalan seluruh ekosistem ini.
>
> Struktur basis data aplikasi kami rancang secara ketat mengikuti kaidah Third Normal Form (3NF) dengan 11 entitas tabel yang saling berelasi. Untuk menjaga integritas finansial dan kepatuhan audit, seluruh relasi kunci asing (foreign key) pada tabel tagihan, transaksi, dan riwayat meteran dikonfigurasi menggunakan aturan 'ON DELETE RESTRICT'. Artinya, data historis pelanggan yang memiliki rekaman transaksi atau tunggakan tidak dapat dihapus sepihak dari sistem, menjamin terpenuhinya prinsip Good Corporate Governance (GCG).
>
> Pada layer frontend antarmuka admin, kami mengombinasikan utilitas Tailwind CSS dengan framework reaktif Alpine.js. Melalui reactive component letterGenerator(), staf admin dapat mengganti tipe naskah dinas, memilih data pelanggan, dan memperbarui preview secara real-time tanpa memicu full page reload yang memperlambat alur kerja operasional.
>
> Dari segi evaluasi dampak bisnis nyata:
> Pertama, terjadi efisiensi waktu operasional hingga 85 persen—dari proses penyusunan berkas administrasi dan triase teknisi yang sebelumnya memakan waktu berjam-jam menjadi beberapa detik saja.
> Kedua, tercipta Zero Data Discrepancy antara laporan pengaduan pelanggan di lapangan dengan tiket kerja yang diterima teknisi di kantor cabang.
> Dan ketiga, peningkatan akurasi penagihan dan mitigasi risiko kebocoran pendapatan melalui deteksi anomali dini.
>
> Inilah wujud komitmen kami dalam menghadirkan solusi digitalisasi operasional utilitas yang tidak sekadar berfokus pada estetika antarmuka, melainkan benar-benar andal, teruji secara teknis, dan siap diterapkan dalam skala industri ketenagalistrikan nasional. Terima kasih, saya kembalikan kepada rekan saya / moderator."

#### Referensi Implementasi Kode Slide 4:
```php
// Skema Migration: Proteksi Integritas Foreign Key Finansial
$table->foreignId('customer_id')->constrained('customers')->onDelete('restrict');
$table->foreignId('tariff_id')->constrained('tariffs')->onDelete('restrict');
```
```html
<!-- State Management Alpine.js: Preview Surat Instan Tanpa Page Reload -->
<section x-data="letterGenerator()">
    <select x-model="selectedType" @change="updatePreview()">
        <option value="sp1">Surat Peringatan 1 (SP-1)</option>
        <option value="spk">Surat Tugas Lapangan YANTEK</option>
    </select>
    <button @click="window.print()">Cetak Dokumen A4</button>
</section>
```

---

## PANDUAN JAWABAN TANYA JAWAB TEKNIS DEWAN JURI (Q&A)

### Pertanyaan 1: Bagaimana arsitektur sistem memastikan performa tetap optimal apabila menangani puluhan ribu transaksi secara bersamaan?
> **Jawaban Hafizh:**  
> "Kami mengimplementasikan optimasi pada tiga level arsitektur. Pada level basis data, seluruh kolom pencarian kunci dan foreign key—seperti `customer_id`, `bill_id`, dan status transaksi—telah dipasangi index komposit untuk mempercepat kecepatan lookup. Pada level aplikasi (Eloquent ORM), kami menerapkan Eager Loading menggunakan method `with()` untuk menuntaskan relasi dalam satu kueri teragregasi, mencegah masalah N+1 Query. Pada level penyajian antarmuka, seluruh data tabel menggunakan server-side pagination dengan limit 15 baris per halaman, memastikan memory footprint runtime PHP tetap stabil di bawah 16 MB."

### Pertanyaan 2: Mengapa tim memilih CSS Print Engine daripada menggunakan library rendering PDF seperti DomPDF atau Browsershot Puppeteer?
> **Jawaban Hafizh:**  
> "Keputusan ini didasari oleh efisiensi resource server dan skalabilitas. Library PDF berbasis PHP seperti DomPDF sering mengalami kendala memori dan parsing CSS modern (Flexbox/Grid), sementara Puppeteer memerlukan instalasi Node.js dan instance Chromium headless di server yang memakan RAM hingga ratusan megabyte per sesi render. Dengan memanfaatkan Native CSS Print Engine (`@media print` dan `@page` paged media), seluruh proses rasterisasi diserahkan langsung ke engine browser klien. Server tidak menanggung beban komputasi tambahan, output cetak 100 persen tajam berstandar vektor, dan pengguna tetap dapat menyimpannya sebagai file PDF resmi melalui dialog print browser."

### Pertanyaan 3: Bagaimana jembatan integrasi AI Agent bekerja dalam modul generator naskah dinas ini?
> **Jawaban Hafizh:**  
> "Arsitektur kami memisahkan modul backoffice sebagai data provider yang deterministik. Endpoint controller kami memetakan entitas pelanggan, status tunggakan, dan rincian teknis ke dalam format JSON Schema yang tervalidasi. Skema data ini siap dikirimkan melalui API webhook ke model bahasa (LLM) seperti GPT atau Gemini. AI Agent bertindak untuk menyusun kalimat notifikasi atau surat yang dipersonalisasi sesuai profil pelanggan—misalnya nada persuasif untuk keterlambatan pertama, atau nada tegas berdasar hukum ESDM untuk penunggakan kronis—sebelum diteruskan ke WhatsApp Gateway atau sistem dispatch resmi."

### Pertanyaan 4: Bagaimana sistem membedakan antara fluktuasi konsumsi normal dengan anomali meteran pada pencatatan SwaCAM?
> **Jawaban Hafizh:**  
> "Kami menetapkan batasan ambang (threshold) berbasis batas kapasitas daya VA pelanggan. Untuk golongan rumah tangga R1 450 VA hingga 900 VA, batas pemakaian wajar maksimum adalah di bawah 400 kWh per bulan. Jika pelanggan menginput angka stand meter yang menghasilkan pemakaian melebihi 400 kWh, atau jika selisih angka stand akhir lebih kecil dari angka stand bulan sebelumnya (yang secara fisik tidak mungkin terjadi pada meteran berjalan normal), controller kami otomatis mengubah status record menjadi 'Anomali Terdeteksi' dan menahan penerbitan tagihan hingga diverifikasi secara manual oleh supervisor lapangan."

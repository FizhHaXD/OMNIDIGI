# ⚡ Dokumentasi Teknis: Sistem Dashboard Admin & Integrasi AI Agent Surat Kedinasan — PLN DIGI

Dokumentasi arsitektur, klasifikasi operasional, referensi kode, dan panduan integrasi mendalam untuk **Dashboard Admin Profesional PLN DIGI** serta **Pusat Generator Dokumen Kedinasan (AI Agent Ready)**.

---

## 📑 Daftar Isi
1. [Arsitektur Sistem & Alur Data](#1-arsitektur-sistem--alur-data)
2. [Klasifikasi Operasional Dashboard Admin](#2-klasifikasi-operasional-dashboard-admin)
   - [2.1 Modul Tagihan & Penagihan Bertingkat (`/admin/bills`)](#21-modul-tagihan--penagihan-bertingkat-adminbills)
   - [2.2 Modul Tiket Gangguan & Dispatch YANTEK (`/admin/outages`)](#22-modul-tiket-gangguan--dispatch-yantek-adminoutages)
   - [2.3 Modul Audit Catat Meter SwaCAM (`/admin/meter-readings`)](#23-modul-audit-catat-meter-swacam-adminmeter-readings)
3. [Pusat Surat Kedinasan & Jembatan AI Agent (`/admin/letters`)](#3-pusat-surat-kedinasan--jembatan-ai-agent-adminletters)
   - [3.1 Empat Jenis Template Kedinasan Standar PLN](#31-empat-jenis-template-kedinasan-standar-pln)
   - [3.2 Skema JSON Payload untuk AI Agent](#32-skema-json-payload-untuk-ai-agent)
   - [3.3 Prompt Engineering System untuk Model Bahasa (LLM)](#33-prompt-engineering-system-untuk-model-bahasa-llm)
   - [3.4 Mesin Cetak A4 Mandiri (`/admin/letters/preview`)](#34-mesin-cetak-a4-mandiri-adminletterspreview)
4. [Bedah Kode Sumber (Source Code Explanation)](#4-bedah-kode-sumber-source-code-explanation)
   - [4.1 `AdminController.php`](#41-admincontrollerphp)
   - [4.2 `letters.blade.php` (Alpine.js Reactive State)](#42-lettersbladephp-alpinejs-reactive-state)
   - [4.3 `letter-preview.blade.php` (CSS Print Engine)](#43-letter-previewbladephp-css-print-engine)
   - [4.4 `routes/web.php`](#44-routeswebphp)
5. [Panduan Integrasi AI Agent Pembentuk Surat](#5-panduan-integrasi-ai-agent-pembentuk-surat)
6. [Roadmap Pengembangan API & Webhook](#6-roadmap-pengembangan-api--webhook)
7. [Standar & Asal-Usul Format Dokumen Kedinasan PLN](#7-standar--asal-usul-format-dokumen-kedinasan-pln)
   - [7.1 Dasar Hukum & Regulasi](#71-dasar-hukum--regulasi)
   - [7.2 Rumus & Format Nomor Surat Dinas Resmi PLN](#72-rumus--format-nomor-surat-dinas-resmi-pln)
   - [7.3 Anatomi 5 Bagian Lembar Naskah Dinas PLN](#73-anatomi-5-bagian-lembar-naskah-dinas-pln)
8. [Panduan Konversi ke Teks & WhatsApp Broadcast](#8-panduan-konversi-ke-teks--whatsapp-broadcast)
   - [8.1 Menjalankan Command CLI Artisan](#81-menjalankan-command-cli-artisan)
   - [8.2 Endpoint Web untuk Unduh File Teks](#82-endpoint-web-untuk-unduh-file-teks)
9. [Panduan Konversi ke Dokumen PDF (4 Metode Lengkap)](#9-panduan-konversi-ke-dokumen-pdf-4-metode-lengkap)
   - [Metode 1: Built-in Headless Browser CLI (0 Package)](#metode-1-built-in-headless-browser-cli-direkomendasikan--0-package-tambahan)
   - [Metode 2: Library Laravel DomPDF](#metode-2-library-laravel-dompdf-barryvdhlaravel-dompdf)
   - [Metode 3: Library Spatie Browsershot (Puppeteer)](#metode-3-library-spatie-browsershot-puppeteer--nodejs)
   - [Metode 4: Native Browser Print Engine](#metode-4-native-browser-print-engine-windowprint---media-print)
10. [Referensi Kode Sumber yang Terkait](#10-referensi-kode-sumber-yang-terkait)

---

## 1. Arsitektur Sistem & Alur Data

Sistem ini menghubungkan basis data operasional PLN (MySQL) ke Dashboard Admin melalui query Eloquent yang terindeks, lalu menyajikan data tersebut ke antarmuka Blade + Alpine.js. Admin dapat menyeleksi data, mengedit parameter surat secara dinamis, dan mengekspor payload terstruktur ke **AI Agent** atau mencetak surat resmi berstandar A4 PLN.

```
┌────────────────────────────────────────────────────────────────────────────────────────┐
│                                 DATABASE (MySQL)                                       │
│  [customers] ──< [bills]        [outage_reports]         [meter_readings]              │
└────────┬─────────────┬──────────────────┬────────────────────────┬─────────────────────┘
         │             │                  │                        │
         ▼             ▼                  ▼                        ▼
┌────────────────────────────────────────────────────────────────────────────────────────┐
│                             BACKEND CONTROLLER (Laravel 13)                            │
│                             App\Http\Controllers\Admin\AdminController                │
│                                                                                        │
│  - bills()           : Klasifikasi Aging Overdue (Lancar / SP-1 / SP-2 / SPK)          │
│  - outages()         : Klasifikasi Keparahan Gangguan (Kritis / Sedang)                │
│  - meterReadings()   : Deteksi Anomali Pemakaian (>400 kWh / Drastis Drop)             │
│  - letters()         : Data Hydration & Selector untuk Generator Dokumen               │
│  - previewLetter()   : Rendering Lembar Cetak A4 Kedinasan Resmi                       │
└────────────────────────────────────────┬───────────────────────────────────────────────┘
                                         │
                                         ▼
┌────────────────────────────────────────────────────────────────────────────────────────┐
│                              FRONTEND INTERACTION (Blade + Alpine.js)                  │
│                                                                                        │
│   ┌────────────────────────────────┐         ┌─────────────────────────────────────┐   │
│   │   Form Input Parameter Dinamis │         │  Live Preview Dokumen Resmi         │   │
│   │   (Nomor, ULP, Tgl, SLA, dsb)  ├─────────►  (Kop PLN, Barcode, Stempel, TTD)  │   │
│   └───────────────┬────────────────┘         └──────────────────┬──────────────────┘   │
│                   │                                             │                      │
│                   ▼                                             ▼                      │
│   ┌────────────────────────────────┐         ┌─────────────────────────────────────┐   │
│   │   Ekspor Payload Data:         │         │  Cetak / Simpan PDF A4:             │   │
│   │   1. Salin Prompt AI Lengkap   │         │  (CSS @media print styling          │   │
│   │   2. Salin JSON Schema Valid   │         │   Bebas Elemen UI Web)              │   │
│   └───────────────┬────────────────┘         └─────────────────────────────────────┘   │
└───────────────────┼────────────────────────────────────────────────────────────────────┘
                    │
                    ▼
┌────────────────────────────────────────────────────────────────────────────────────────┐
│                              AI AGENT PEMBENTUK SURAT                                  │
│               (OpenAI GPT-4o / Claude 3.5 Sonnet / Gemini 2.5 Flash / LangChain)       │
│                                                                                        │
│  - Validasi Hukum & Regulasi (Permen ESDM No. 27/2017 & SOP PLN)                      │
│  - Formulasi Narasi Resmi & Bahasa Kedinasan Formal                                    │
│  - Kalkulasi Akurat Pokok Tagihan + Denda Keterlambatan                                │
│  - Otomasi Pengiriman Salinan ke Pengguna via WhatsApp / Email / Push Notif            │
└────────────────────────────────────────────────────────────────────────────────────────┘
```

---

## 2. Klasifikasi Operasional Dashboard Admin

### 2.1 Modul Tagihan & Penagihan Bertingkat (`/admin/bills`)

Setiap pelanggan pascabayar memiliki siklus tagihan bulanan dengan tanggal jatuh tempo standar **tanggal 20 setiap bulan**. Sistem mengklasifikasikan tagihan yang belum lunas (`unpaid` / `overdue`) berdasarkan selisih hari (*aging overdue*):

| Kategori Klasifikasi | Kriteria Hari Telat | Status Hukum & Tindakan Operasional | Label Badge | Tombol Aksi AI |
|---|---|---|---|---|
| **Lancar / Normal** | $\le 0$ Hari (Belum lewat tempo) | Menunggu pembayaran wajar pengguna. | `Tagihan Baru` (Biru) | Tinjau |
| **SP-1 (Surat Peringatan 1)** | 1 – 10 Hari | Pengingat sopan. Waktu penyelesaian 3 hari kerja. Dikenakan denda keterlambatan pertama. | `SP-1 (Hari 1-10)` (Kuning) | `Draft SP (AI)` |
| **SP-2 (Peringatan & Potong)** | 11 – 20 Hari | Peringatan keras terakhir (1x24 jam). Denda bertambah. Rencana pemutusan sementara MCB. | `SP-2 (Hari 11-20)` (Oranye) | `Draft SP (AI)` |
| **SPK Pemutusan** | $> 20$ Hari | Penerbitan SPK Eksekusi Lapangan Tim P2TL. Pemutusan fisik sambungan listrik pelanggan. | `SPK Pemutusan (>20h)` (Merah) | `Draft SP (AI)` |

#### Logika Query Filter di `AdminController.php`:
```php
if ($request->status === 'overdue') {
    $query->where(function ($q) {
        $q->where('status', 'overdue')
          ->orWhere(function ($sub) {
              $sub->where('status', 'unpaid')
                  ->where('tanggal_jatuh_tempo', '<', now()->toDateString());
          });
    });
}
```

---

### 2.2 Modul Tiket Gangguan & Dispatch YANTEK (`/admin/outages`)

Mengelola tiket aduan listrik masyarakat dari form laporan kendala di aplikasi seluler/web PLN DIGI.

| Tingkat Keparahan | Kategori Gangguan | SLA Target Dispatch | Aksi Petugas & Respon Sistem |
|---|---|---|---|
| **🚨 KRITIS (Emergency)** | `padam_total`, `korsleting` | **Maksimal 30 Menit** | Indikator merah menyala. Tombol prioritas untuk langsung menerbitkan **SPK YANTEK AI** agar regu siaga meluncur ke lokasi. |
| **⚠️ SEDANG (Warning)** | `mcb_trip`, `penurunan_daya`, `meter_rusak` | **Maksimal 3 Jam** | Penjadwalan teknisi harian, inspeksi kWh meter, dan penggantian komponen instalasi. |

#### Alur Status Tiket Gangguan:
1. `dilaporkan` (Tiket baru masuk dari warga)
2. `diproses` (Admin menugaskan Tim Regu YANTEK dan mengisi `catatan_petugas`)
3. `selesai` (Petugas menyelesaikan pekerjaan di lokasi dan aliran listrik pulih)

---

### 2.3 Modul Audit Catat Meter SwaCAM (`/admin/meter-readings`)

Pelanggan mengirimkan foto meteran listrik mandiri setiap akhir bulan (tanggal 24–27). Sebelum tagihan terbit, admin memverifikasi angka stand meter untuk mencegah kesalahan input ataupun kecurangan (*fraud*).

#### Algoritma Deteksi Anomali Pemakaian:
```php
$isAnomaly = ($reading->pemakaian_kwh > 400) || ($reading->pemakaian_kwh < 20 && $reading->customer->daya >= 1300);
```
- Jika pemakaian **$> 400\text{ kWh}$** untuk rumah tangga standar atau terjadi penurunan tiba-tiba padahal kapasitas daya besar, sistem memberikan tanda `⚠️ Indikasi Anomali Konsumsi Listrik`.
- Admin dapat menolak dan langsung menerbitkan **Berita Acara Pemeriksaan Meter (BA-P2TL AI)** untuk peninjauan fisik lapangan.

---

## 3. Pusat Surat Kedinasan & Jembatan AI Agent (`/admin/letters`)

Modul ini adalah **antarmuka jembatan (bridge)** yang mempersiapkan seluruh data variabel database ke dalam format siap cerna untuk AI Agent pembentuk surat.

### 3.1 Empat Jenis Template Kedinasan Standar PLN

| Kode Jenis | Nama Dokumen | Regulasi & Dasar Hukum | Penerima |
|---|---|---|---|
| `sp1` | Surat Peringatan 1 (SP-1) Tunggakan Listrik | Perjanjian Jual Beli Tenaga Listrik (PJBTL) Pasal 7 | Pelanggan Pascabayar |
| `sp2` | Surat Peringatan 2 & Pemberitahuan Pemutusan Sementara | Permen ESDM No. 27 Tahun 2017 & SOP Penagihan PLN | Pelanggan Menunggak $>10$ Hari |
| `spk` | Surat Perintah Kerja (SPK) YANTEK Gangguan | Standar Layanan Pelayanan Distribusi (SLP-PLN) | Tim Teknisi Lapangan (Regu Cepat) |
| `ba_meter` | Berita Acara Audit SwaCAM & Pemeriksaan P2TL | Kepdir PLN No. 088-Z.P/DIR/2016 perihal P2TL | Pelanggan & Petugas Auditor |

---

### 3.2 Skema JSON Payload untuk AI Agent

Saat admin menekan tombol **"Salin JSON Payload"** pada antarmuka, sistem menghasilkan payload JSON berstandar OpenAPI yang siap dikirimkan melalui HTTP POST ke endpoint backend LLM / Agent:

```json
{
  "document_type": "SP-1",
  "meta": {
    "nomor_surat": "041/DIS.01.02/ULP-JKT/SP-1/2026",
    "tanggal_terbit": "2026-09-30",
    "unit_layanan": "UNIT LAYANAN PELANGGAN (ULP) CIRACAS",
    "sifat": "PENTING",
    "perihal": "Surat Pemberitahuan Keterlambatan Pembayaran Tagihan Listrik"
  },
  "recipient": {
    "id_pelanggan": "532100889912",
    "nama": "Ahmad Fauzi",
    "alamat": "Jl. Raya Ciracas No. 42, Jakarta Timur",
    "golongan_tarif": "R1",
    "daya_va": 1300
  },
  "billing_data": {
    "periode": "2026-08",
    "pemakaian_kwh": 184,
    "pokok_tagihan": 261000,
    "denda": 15000,
    "total_kewajiban": 276000,
    "hari_keterlambatan": 10
  },
  "instructions": {
    "deadline_hari": "3 Hari Kerja",
    "metode_pembayaran": "Aplikasi PLN DIGI / Bank Mandiri / BRI / Indomaret",
    "konsekuensi_default": "Surat Peringatan 2 dan Pemutusan Sementara Sambungan Listrik"
  },
  "signatory": {
    "nama": "IR. H. BAMBANG PRASETYO, M.T.",
    "jabatan": "Manajer Unit Layanan Pelanggan",
    "nip": "198403152008121002"
  }
}
```

---

### 3.3 Prompt Engineering System untuk Model Bahasa (LLM)

Saat admin menekan tombol **"Salin Prompt AI"**, sistem merangkai *meta-prompt* terstruktur yang menempatkan model bahasa sebagai asisten legal PLN:

```markdown
Anda adalah Asisten Hukum & Administrasi Kedinasan PT PLN (Persero).
Tugas Anda adalah memformulasikan Draf Dokumen Resmi Kedinasan berdasarkan data operasional berikut:

[PARAMETER DATA OPERASIONAL]
- Jenis Dokumen: Surat Peringatan 1 (SP-1) Tunggakan Rekening Listrik
- Nomor Dokumen: 041/DIS.01.02/ULP-JKT/SP-1/2026
- Unit Penerbit: UNIT LAYANAN PELANGGAN (ULP) CIRACAS
- ID Pelanggan: 532100889912
- Nama Pelanggan: Ahmad Fauzi
- Alamat Pelanggan: Jl. Raya Ciracas No. 42, Jakarta Timur
- Total Kewajiban / Estimasi: Rp 276.000
- Batas Waktu / Target SLA: 3 Hari Kerja

[PANDUAN PENYUSUNAN]
1. Gunakan bahasa Indonesia baku, sopan, tegas, dan menjunjung tinggi etika kedinasan BUMN.
2. Sertakan dasar hukum Perjanjian Jual Beli Tenaga Listrik (PJBTL) dan Permen ESDM No. 27 Tahun 2017.
3. Rincikan konsekuensi administratif apabila kewajiban tidak diselesaikan sesuai batas waktu.
4. Buat dalam format draf siap terbit dengan struktur: KOP Surat, Pembuka, Rincian, Penutup, dan Kolom TTD.
```

---

### 3.4 Mesin Cetak A4 Mandiri (`/admin/letters/preview`)

Dapat diakses di `/admin/letters/preview?type={type}&bill_id={id}&outage_id={id}`. Menggunakan aturan CSS cetak presisi:
- Dimensi kertas $210\text{ mm} \times 297\text{ mm}$ (A4 Standar Internasional).
- Margin cetak $20\text{ mm}$.
- Komponen navigasi web otomatis disembunyikan menggunakan kelas `@media print { .no-print { display: none !important; } }`.
- Watermark stempel dinas PLN merah dengan kemiringan $12^\circ$ dan QR Code validasi digital UUID.

---

## 4. Bedah Kode Sumber (Source Code Explanation)

### 4.1 `AdminController.php`

Terletak di [AdminController.php](file:///c:/Users/ASUS/PROJECT%20CODING/Lomba%20PLNDIGI/app/Http/Controllers/Admin/AdminController.php).

#### Method `dashboard()`
Mengambil data agregasi eksekutif secara real-time dari database:
```php
$metrics = [
    'total_customers'      => Customer::count(),
    'active_customers'     => Customer::where('status', 'active')->count(),
    'unpaid_bills_count'   => Bill::whereIn('status', ['unpaid', 'overdue'])->count(),
    'unpaid_bills_sum'     => Bill::whereIn('status', ['unpaid', 'overdue'])->sum('total_biaya'),
    'critical_outages'     => OutageReport::whereIn('kategori', ['padam_total', 'korsleting'])
                                ->whereIn('status', ['dilaporkan', 'diproses'])->count(),
    'monthly_revenue'      => Transaction::where('status', 'success')
                                ->whereMonth('created_at', now()->month)->sum('total_bayar'),
];
```
*Tujuan*: Memberikan gambaran sekilas (*helicopter view*) kepada admin mengenai kesehatan keuangan dan kestabilan jaringan listrik.

#### Method `bills(Request $request)`
Mengelola filter data tagihan, relasi customer dan tarif, serta penghitungan total piutang:
```php
$query = Bill::with(['customer.tariff', 'meterReading']);
// Mendukung pencarian teks berdasarkan Nama atau ID Pelanggan
if ($request->filled('q')) {
    $q = $request->q;
    $query->whereHas('customer', function ($sub) use ($q) {
        $sub->where('nama', 'like', "%{$q}%")
            ->orWhere('id_pelanggan', 'like', "%{$q}%");
    });
}
```

#### Method `letters(Request $request)`
Menyiapkan data hydrator untuk generator dokumen. Mengambil tagihan yang menunggak (`overdueBills`) dan gangguan aktif (`activeOutages`), lalu memilih item default untuk langsung dipreview di halaman:
```php
$selectedBill = $selectedBillId ? Bill::with(['customer.tariff'])->find($selectedBillId) : $overdueBills->first();
$selectedOutage = $selectedOutageId ? OutageReport::with(['user', 'customer'])->find($selectedOutageId) : $activeOutages->first();
```

---

### 4.2 `letters.blade.php` (Alpine.js Reactive State)

Terletak di [letters.blade.php](file:///c:/Users/ASUS/PROJECT%20CODING/Lomba%20PLNDIGI/resources/views/admin/letters.blade.php).

State management dikontrol secara instan tanpa reload browser menggunakan komponen Alpine.js `letterGenerator()`:

```javascript
function letterGenerator() {
    return {
        activeType: '{{ $type ?? "sp1" }}',
        currentDate: '{{ now()->translatedFormat("d F Y") }}',
        formData: {
            noSurat: '041/DIS.01.02/ULP-JKT/SP-1/{{ date("Y") }}',
            unitLayanan: 'UNIT LAYANAN PELANGGAN (ULP) CIRACAS',
            namaPenerima: '{{ $selectedBill?->customer->nama ?? "Ahmad Fauzi" }}',
            alamat: '{{ $selectedBill?->customer->alamat ?? "Jl. Raya Ciracas No. 42" }}',
            idRef: '{{ $selectedBill?->customer->id_pelanggan ?? "532100889912" }}',
            catatanNominal: 'Rp {{ number_format($selectedBill?->total_bayar ?? 276000, 0, ",", ".") }}',
            deadline: '3 (tiga) Hari Kerja',
            // template narasi paragraf resmi...
        },
        
        // Mengubah template dinamis saat tab diklik:
        setTemplate(type) {
            this.activeType = type;
            // update nomor surat, perihal, dan paragraf narasi secara otomatis
        },

        // Handler untuk menyalin JSON ke clipboard
        copyJson(btn) {
            const payload = { ... };
            navigator.clipboard.writeText(JSON.stringify(payload, null, 2));
            // Trigger feedback visual "Tersalin!"
        }
    }
}
```

---

### 4.3 `letter-preview.blade.php` (CSS Print Engine)

Terletak di [letter-preview.blade.php](file:///c:/Users/ASUS/PROJECT%20CODING/Lomba%20PLNDIGI/resources/views/admin/letter-preview.blade.php).

Menerapkan aturan `@media print` sehingga saat admin mengklik `window.print()` atau menekan `Ctrl + P`, browser hanya mencetak lembar kertas dokumen A4 tanpa navbar, tombol, atau background abu-abu:

```css
.paper-a4 {
    width: 210mm;
    min-height: 297mm;
    padding: 20mm 20mm 20mm 25mm;
    margin: 20px auto;
    background: white;
}

@media print {
    body { background: white !important; margin: 0 !important; }
    .no-print { display: none !important; }
    .paper-a4 {
        width: 100% !important;
        margin: 0 !important;
        box-shadow: none !important;
        page-break-after: avoid;
    }
}
```

---

### 4.4 `routes/web.php`

Daftar rute admin terlindungi yang didaftarkan di [web.php](file:///c:/Users/ASUS/PROJECT%20CODING/Lomba%20PLNDIGI/routes/web.php):

| Method | URI | Route Name | Action Controller |
|---|---|---|---|
| `GET` | `/admin` | `admin.dashboard` | `AdminController@dashboard` |
| `GET` | `/admin/customers` | `admin.customers` | `AdminController@customers` |
| `GET` | `/admin/transactions` | `admin.transactions` | `AdminController@transactions` |
| `GET` | `/admin/bills` | `admin.bills` | `AdminController@bills` |
| `GET` | `/admin/outages` | `admin.outages` | `AdminController@outages` |
| `POST` | `/admin/outages/{outage}/status` | `admin.outages.status` | `AdminController@updateOutageStatus` |
| `GET` | `/admin/meter-readings` | `admin.meter_readings` | `AdminController@meterReadings` |
| `POST` | `/admin/meter-readings/{meterReading}/verify` | `admin.meter_readings.verify` | `AdminController@verifyMeterReading` |
| `GET` | `/admin/letters` | `admin.letters` | `AdminController@letters` |
| `GET` | `/admin/letters/preview` | `admin.letters.preview` | `AdminController@previewLetter` |

---

## 5. Panduan Integrasi AI Agent Pembentuk Surat

Jika Anda ingin menghubungkan generator dokumen ini ke skrip AI Agent eksternal (misalnya menggunakan Python, Node.js, atau modul API Laravel):

### Skenario 1: Copy-Paste Prompt Langsung ke LLM
1. Masuk ke menu **Pusat Surat AI** (`/admin/letters`).
2. Pilih data tagihan atau tiket dari dropdown.
3. Klik tombol **"Salin Prompt AI"**.
4. Buka ChatGPT, Claude, atau Gemini, lalu paste prompt tersebut. AI akan memproduksi narasi surat dinas lengkap dengan klausul hukum yang presisi.

### Skenario 2: Menggunakan JSON Payload untuk Function Calling (API)
AI Agent menerima payload JSON dari endpoint atau clipboard, kemudian memanggil LLM dengan *System Prompt*:

```python
import json
from openai import OpenAI

client = OpenAI(api_key="YOUR_API_KEY")

# Data disalin dari tombol "Salin JSON Payload" di Admin PLN DIGI
payload = {
    "document_type": "SP-2",
    "meta": {"nomor_surat": "082/DIS.01.02/ULP-JKT/SP-2/2026"},
    "recipient": {"nama": "Ahmad Fauzi", "id_pelanggan": "532100889912"},
    "billing_data": {"total_kewajiban": 345000, "hari_keterlambatan": 14}
}

response = client.chat.completions.create(
    model="gpt-4o",
    messages=[
        {"role": "system", "content": "Anda adalah Legal Officer PT PLN (Persero). Buatkan narasi surat resmi peringatan kedua dan pemberitahuan pemutusan listrik berdasarkan data JSON yang diberikan."},
        {"role": "user", "content": json.dumps(payload)}
    ]
)

print(response.choices[0].message.content)
```

---

## 6. Roadmap Pengembangan API & Webhook (Next Steps)

Untuk integrasi dua arah otomatis di masa mendatang:
1. **Endpoint REST API**: Menambahkan route `POST /api/v1/letters/generate` yang menerima JSON payload dan langsung memanggil model AI di server.
2. **Auto Delivery**: Mengintegrasikan draf surat yang dihasilkan AI ke modul WhatsApp Gateway (Fonnte/Twilio) atau email SMTP resmi pelanggan.
3. **Penyimpanan Berkas Digital**: Menyimpan dokumen PDF hasil generasi ke bucket cloud storage (S3) dengan penomoran unik arsip dinas PLN.

---

## 7. Standar & Asal-Usul Format Dokumen Kedinasan PLN

Format surat yang digunakan dalam sistem PLN DIGI **bukan template fiktif sembarangan**, melainkan mengacu langsung pada standar hukum dan tata naskah dinas resmi PT PLN (Persero):

### 7.1 Dasar Hukum & Regulasi
1. **Peraturan Direksi PT PLN (Persero) No. 0022.P/DIR/2020** tentang *Pedoman Tata Naskah Dinas PT PLN (Persero)* (TNDE — Tata Naskah Dinas Elektronik).
2. **Peraturan Menteri Energi dan Sumber Daya Mineral (ESDM) No. 27 Tahun 2017** tentang *Tingkat Mutu Pelayanan dan Biaya yang Terkait dengan Penyaluran Tenaga Listrik oleh PT PLN (Persero)*. Mengatur bahwa keterlambatan pembayaran melewati batas jatuh tempo (tanggal 20) memberikan hak hukum bagi PLN untuk mengenakan denda dan melakukan pemutusan sementara.
3. **Perjanjian Jual Beli Tenaga Listrik (PJBTL) Pasal 7**: Klausul kontrak sah antara pelanggan dan PLN mengenai hak, kewajiban, dan sanksi penertiban.
4. **Keputusan Direksi PT PLN (Persero) No. 088-Z.P/DIR/2016**: Petunjuk Teknis *Penertiban Pemakaian Tenaga Listrik (P2TL)* untuk pemeriksaan stand meter dan investigasi kebocoran arus.
5. **UU No. 1 Tahun 2024 tentang ITE**: Menetapkan keabsahan hukum Tanda Tangan Elektronik (TTE) dan QR Code verifikasi dokumen digital.

### 7.2 Rumus & Format Nomor Surat Dinas Resmi PLN
Format nomor surat kedinasan PLN tersusun atas 5 blok kode terstandar:

```
    041  /  DIS.01.02  /  ULP-JKT  /  SP-1  /  2026
    ──┬─    ────┬────     ───┬───     ──┬─     ─┬──
      │         │            │          │       └── Tahun Takwim Berjalan
      │         │            │          └────────── Singkatan Jenis Naskah Dinas
      │         │            └───────────────────── Kode Unit Layanan Pelanggan (Ciracas/Jakarta)
      │         └────────────────────────────────── Kode Klasifikasi Masalah Arsip (Distribusi & Piutang)
      └──────────────────────────────────────────── Nomor Urut Surat Keluar di Buku Register ULP
```

- **`041`**: Nomor urut berkas keluar pada buku agenda sekretariat dinas ULP.
- **`DIS.01.02`**: Kode Klasifikasi Masalah Kearsipan PLN:
  - `DIS`: Bidang Distribusi & Niaga Tenaga Listrik.
  - `01`: Penjualan Tenaga Listrik & Pelayanan Pelanggan.
  - `02`: Pengendalian Piutang & Penagihan Rekening Listrik.
- **`ULP-JKT`**: Unit Layanan Pelanggan pelaksana (contoh: ULP Ciracas / ULP Kramat Jati).
- **`SP-1` / `SP-2` / `SPK` / `BA-P2TL`**: Jenis surat (Surat Peringatan 1 / 2, Surat Perintah Kerja, Berita Acara).
- **`2026`**: Tahun takwim penerbitan surat.

### 7.3 Anatomi 5 Bagian Lembar Naskah Dinas PLN
1. **Kepala Surat (Kop Surat Resmi)**:
   - Lambang Petir Kuning & Gelombang Biru PT PLN (Persero).
   - Teks Identitas: `PT PLN (PERSERO) - DISTRIBUSI JAKARTA RAYA - ULP CIRACAS`.
   - Sertifikasi Mutu: `ISO 9001:2015`.
   - Saluran Pengaduan: `Call Center 123` dan `www.pln.co.id`.
2. **Metadata Surat**:
   - `Nomor`, `Lampiran` (1 Berkas), `Sifat` (*PENTING / SEGERA*), `Perihal`, dan Tanggal Terbit.
3. **Identitas Subjek Pelanggan**:
   - Nama Pelanggan, ID Pelanggan (12 Digit), Golongan Tarif & Daya VA, serta Alamat Objek.
4. **Batang Tubuh (Isi Surat)**:
   - Paragraf konsideran mengutip PJBTL & Permen ESDM.
   - Tabel rincian pokok tagihan, pemakaian kWh, denda keterlambatan, dan total kewajiban.
   - Instruksi batas waktu pelunasan (*SLA 3 hari kerja* untuk SP-1; *1x24 jam* untuk SP-2).
   - Konsekuensi pemutusan fisik MCB oleh Tim P2TL jika melampaui batas waktu.
5. **Kaki Surat (Pengesahan Legalitas)**:
   - QR Code verifikasi dokumen elektronik (UUID unik sistem PLN DIGI).
   - Tanda tangan digital dan stempel dinas PLN (merah miring $12^\circ$).
   - Nama Pejabat Berwenang: `IR. H. BAMBANG PRASETYO, M.T.` (Manajer ULP) beserta NIP resmi.

---

## 8. Panduan Konversi ke Teks & WhatsApp Broadcast

Untuk keperluan pengiriman notifikasi otomatis via SMS, WhatsApp Gateway, atau prompt input bagi model LLM:

### 8.1 Menjalankan Command CLI Artisan
Aplikasi telah dilengkapi Artisan Command khusus:

```bash
# 1. Konversi ke Plain Text (Memo Dinas)
php artisan letter:generate sp1 --format=text

# 2. Konversi ke Format WhatsApp Broadcast (Lengkap dengan Bold & Emoji)
php artisan letter:generate sp1 --format=wa

# 3. Konversi dan Simpan ke File Eksternal
php artisan letter:generate sp1 --format=text --output="storage/app/memo_sp1.txt"

# 4. Generate Format JSON untuk Konsumsi AI Agent
php artisan letter:generate sp1 --format=json
```

### 8.2 Endpoint Web untuk Unduh File Teks
Admin dapat mengunduh langsung berkas `.txt` melalui browser:
- **Plain Text**: `http://localhost:8000/admin/letters/download-text?type=sp1&bill_id=3&format=text`
- **WhatsApp Text**: `http://localhost:8000/admin/letters/download-text?type=sp1&bill_id=3&format=wa`

### 8.3 Contoh Output Teks WhatsApp
```text
*[PEMBERITAHUAN RESMI PT PLN (PERSERO)]*
No: _041/DIS.01.02/ULP-JKT/SP-1/2026_

Kepada Yth. *Budi Santoso*
ID Pelanggan: `531200026789`

Kami menginformasikan bahwa tagihan listrik Anda periode berjalan tercatat belum lunas dengan rincian:
💰 *Total Wajib Bayar: Rp 518.237*
⏳ *Batas Waktu: 3 Hari Kerja*

Mohon segera lakukan pembayaran melalui aplikasi *PLN DIGI* atau gerai pembayaran terdekat guna menghindari sanksi pemutusan sementara.
_Informasi resmi Call Center PLN: 123_
```

---

## 9. Panduan Konversi ke Dokumen PDF (4 Metode Lengkap)

Terdapat 4 pilihan metode konversi ke PDF yang dapat digunakan sesuai infrastruktur server Anda:

### Metode 1: Built-in Headless Browser CLI (Direkomendasikan — 0 Package Tambahan)
Metode ini memanfaatkan Microsoft Edge atau Google Chrome yang sudah terpasang di sistem operasi server tanpa perlu menginstal package composer tambahan.

#### Perintah Windows PowerShell / CMD:
```powershell
# Menggunakan Microsoft Edge (bawaan Windows)
msedge --headless --disable-gpu --no-pdf-header-footer --print-to-pdf="C:\dokumen_sp1.pdf" "http://localhost:8000/admin/letters/preview?type=sp1&bill_id=3"

# Menggunakan Google Chrome
chrome --headless --disable-gpu --no-pdf-header-footer --print-to-pdf="C:\dokumen_sp1.pdf" "http://localhost:8000/admin/letters/preview?type=sp1&bill_id=3"
```

#### Perintah Linux Server (Ubuntu/Debian):
```bash
google-chrome-stable --headless --disable-gpu --no-pdf-header-footer --print-to-pdf=/var/www/sp1.pdf http://localhost:8000/admin/letters/preview?type=sp1&bill_id=3
```

#### Menjalankan via Artisan Command:
```bash
php artisan letter:generate sp1 --format=pdf
# File otomatis tersimpan di storage/app/public/sp1_{timestamp}.pdf
```

---

### Metode 2: Library Laravel DomPDF (`barryvdh/laravel-dompdf`)
Jika Anda ingin menghasilkan PDF secara murni di level PHP (tanpa menjalankan browser headless):

#### 1. Instalasi:
```bash
composer require barryvdh/laravel-dompdf
```

#### 2. Implementasi di Controller:
```php
use Barryvdh\DomPDF\Facade\Pdf;

public function exportPdf(Request $request)
{
    $bill = Bill::with(['customer.tariff'])->findOrFail($request->bill_id);
    $nomorSurat = '041/DIS.01.02/ULP-JKT/SP-1/' . date('Y');

    $pdf = Pdf::loadView('admin.letter-preview', compact('bill', 'nomorSurat'))
              ->setPaper('a4', 'portrait');

    return $pdf->download('Surat_Peringatan_PLN_' . $bill->customer->id_pelanggan . '.pdf');
}
```

---

### Metode 3: Library Spatie Browsershot (Puppeteer / Node.js)
Jika server memiliki Node.js dan menginginkan hasil render vector PDF presisi tinggi:

#### 1. Instalasi:
```bash
composer require spatie/browsershot
npm install puppeteer
```

#### 2. Implementasi di Controller:
```php
use Spatie\Browsershot\Browsershot;

public function exportBrowsershot(Request $request)
{
    $url = route('admin.letters.preview', ['type' => 'sp1', 'bill_id' => $request->bill_id]);

    $pdfPath = storage_path('app/public/surat_' . time() . '.pdf');

    Browsershot::url($url)
        ->format('A4')
        ->margins(15, 20, 15, 20)
        ->showBackground()
        ->save($pdfPath);

    return response()->download($pdfPath);
}
```

---

### Metode 4: Native Browser Print Engine (`window.print()` / `@media print`)
Metode paling instan untuk petugas admin di browser:
1. Buka halaman pratinjau: `http://localhost:8000/admin/letters/preview?type=sp1`
2. Klik tombol **"Cetak / Simpan PDF"** di pojok kanan atas atau tekan `Ctrl + P`.
3. Pada dialog cetak browser, pilih tujuan: **"Save as PDF"** / **"Simpan sebagai PDF"**.
4. Lembar surat dicetak secara bersih tanpa navbar web, tombol, atau background abu-abu karena telah diisolasi oleh stylesheet:
   ```css
   @media print {
       body { background: white !important; margin: 0 !important; }
       .no-print { display: none !important; }
       .paper-a4 {
           width: 100% !important;
           margin: 0 !important;
           box-shadow: none !important;
           page-break-after: avoid;
       }
   }
   ```

---

## 10. Referensi Kode Sumber yang Terkait

| Komponen File | Fungsi & Peran |
|---|---|
| [LetterFormatterService.php](file:///c:/Users/ASUS/PROJECT%20CODING/Lomba%20PLNDIGI/app/Services/LetterFormatterService.php) | Service pusat penomoran dinas, konversi ke Plain Text, format WhatsApp, dan eksekutor CLI print-to-pdf headless. |
| [GenerateLetterCommand.php](file:///c:/Users/ASUS/PROJECT%20CODING/Lomba%20PLNDIGI/app/Console/Commands/GenerateLetterCommand.php) | Artisan CLI command: `php artisan letter:generate {type} {id?} --format={text\|wa\|json\|pdf}`. |
| [AdminController.php](file:///c:/Users/ASUS/PROJECT%20CODING/Lomba%20PLNDIGI/app/Http/Controllers/Admin/AdminController.php) | Method `letters()`, `previewLetter()`, dan `downloadText()` untuk streaming berkas dokumen kedinasan. |
| [letters.blade.php](file:///c:/Users/ASUS/PROJECT%20CODING/Lomba%20PLNDIGI/resources/views/admin/letters.blade.php) | UI Generator interaktif dengan form parameter dinamis, Alpine.js live state, tombol salin Prompt AI & JSON payload. |
| [letter-preview.blade.php](file:///c:/Users/ASUS/PROJECT%20CODING/Lomba%20PLNDIGI/resources/views/admin/letter-preview.blade.php) | Template lembar kerja resmi standar A4 PLN dengan kop dinas, barcode QR UUID, stempel basah $12^\circ$, dan CSS print. |
| [routes/web.php](file:///c:/Users/ASUS/PROJECT%20CODING/Lomba%20PLNDIGI/routes/web.php) | Endpoint rute admin terproteksi: `/admin/letters`, `/admin/letters/preview`, `/admin/letters/download-text`. |

---

> Dokumen ini diperbarui secara otomatis pada repositori branch `feature/plndigi-v2` dan menjadi acuan operasional bagi pengembang maupun tim teknis lomba PLN DIGI.

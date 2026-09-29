<?php

namespace App\Services;

use App\Models\Bill;
use App\Models\OutageReport;
use Carbon\Carbon;
use Illuminate\Support\Facades\Process;

class LetterFormatterService
{
    /**
     * Dapatkan nomor surat dinas resmi berdasarkan standar TNDE PLN
     */
    public static function generateNomorSurat(string $type): string
    {
        $year = now()->format('Y');
        return match ($type) {
            'sp1'      => '041/DIS.01.02/ULP-JKT/SP-1/' . $year,
            'sp2'      => '082/DIS.01.02/ULP-JKT/SP-2/' . $year,
            'spk'      => '115/YANTEK/GANGGUAN/' . $year,
            'ba_meter' => '204/BA-P2TL/METER/' . $year,
            default    => '041/DIS.01.02/ULP-JKT/' . $year,
        };
    }

    /**
     * Konversi data surat kedinasan ke format Teks Polos (Plain Text / Memo Dinas)
     */
    public static function toPlainText(string $type, ?Bill $bill = null, ?OutageReport $outage = null, array $custom = []): string
    {
        $nomorSurat = $custom['no_surat'] ?? self::generateNomorSurat($type);
        $tgl = now()->translatedFormat('d F Y');
        $ulp = $custom['ulp'] ?? 'UNIT LAYANAN PELANGGAN (ULP) CIRACAS';

        if ($type === 'sp1') {
            $nama = $bill?->customer->nama ?? 'Ahmad Fauzi';
            $idPel = $bill?->customer->id_pelanggan ?? '532100889912';
            $alamat = $bill?->customer->alamat ?? 'Jl. Raya Ciracas No. 42';
            $total = number_format($bill?->total_biaya ?? 276000, 0, ',', '.');
            $denda = number_format($bill?->denda ?? 15000, 0, ',', '.');

            return <<<TEXT
================================================================================
                    PT PLN (PERSERO) - DISTRIBUSI JAKARTA RAYA
                         {$ulp}
================================================================================
Nomor    : {$nomorSurat}
Lampiran : 1 (satu) Berkas Lembar Rincian Tagihan
Sifat    : PENTING (SP-1)
Perihal  : Surat Pemberitahuan Keterlambatan Pembayaran Rekening Listrik
Tanggal  : Jakarta, {$tgl}

Kepada Yth.
Bapak/Ibu: {$nama}
ID Pelanggan: {$idPel}
Alamat   : {$alamat}
Di Tempat

Dengan hormat,

Berdasarkan data sistem tagihan digital PLN DIGI hingga tanggal surat ini diterbitkan,
kami memberitahukan bahwa rekening listrik atas nama Bapak/Ibu tercatat belum diselesaikan:

- ID Pelanggan          : {$idPel}
- Denda Keterlambatan   : Rp {$denda}
- Total Wajib Bayar     : Rp {$total}
- Batas Waktu Pelunasan : 3 (tiga) Hari Kerja sejak surat ini diterbitkan

Sesuai ketentuan Perjanjian Jual Beli Tenaga Listrik (PJBTL), kami menghimbau agar
Bapak/Ibu segera melunasi kewajiban tersebut melalui aplikasi PLN DIGI, ATM/VA Bank,
Kantor Pos, atau loket pembayaran resmi PLN.

Apabila sampai batas waktu tersebut pembayaran belum dilakukan, kami terpaksa
melanjutkan ke tahapan Surat Peringatan 2 (SP-2) dan pemutusan sementara sambungan.

Manajer Unit Layanan Pelanggan,
PT PLN (PERSERO)

IR. H. BAMBANG PRASETYO, M.T.
NIP. 198403152008121002
================================================================================
TEXT;
        }

        if ($type === 'sp2') {
            $nama = $bill?->customer->nama ?? 'Ahmad Fauzi';
            $idPel = $bill?->customer->id_pelanggan ?? '532100889912';
            $total = number_format($bill?->total_biaya ?? 345000, 0, ',', '.');

            return <<<TEXT
================================================================================
                    PT PLN (PERSERO) - DISTRIBUSI JAKARTA RAYA
                         {$ulp}
================================================================================
Nomor    : {$nomorSurat}
Sifat    : SANGAT PENTING / SEGERA (SP-2)
Perihal  : Peringatan Terakhir & Pemberitahuan Pemutusan Sementara Sambungan Listrik
Tanggal  : Jakarta, {$tgl}

Kepada Yth.
Bapak/Ibu: {$nama} (ID Pelanggan: {$idPel})

Merujuk Surat Peringatan Pertama (SP-1) dan Permen ESDM No. 27 Tahun 2017,
dengan ini kami memberikan PERINGATAN TERAKHIR waktu penyelesaian 1 x 24 Jam
atas tunggakan listrik sebesar Rp {$total}.

Apabila dalam waktu 1x24 jam belum diselesaikan, Tim P2TL/YANTEK akan melakukan
PEMUTUSAN SEMENTARA pada kWh Meter instalasi tanpa pemberitahuan terpisah berikutnya.

Manajer Unit Layanan Pelanggan,
PT PLN (PERSERO)
================================================================================
TEXT;
        }

        if ($type === 'spk') {
            $tiketId = $outage?->id ?? '701';
            $kategori = $outage?->label_kategori ?? 'Padam Total Wilayah';
            $lokasi = $outage?->lokasi ?? 'Jl. Raya Ciracas No. 42';
            $pelapor = $outage?->user->name ?? 'Warga Setempat';

            return <<<TEXT
================================================================================
               SURAT PERINTAH KERJA (SPK) YANTEK - PT PLN (PERSERO)
================================================================================
Nomor SPK : {$nomorSurat}
Prioritas : DISPATCH SEGERA (SLA 30 MENIT)
Tanggal   : Jakarta, {$tgl}

DITUGASKAN KEPADA: Tim Pelayanan Teknik (YANTEK) Regu Alpha
OBJEK GANGGUAN:
- Nomor Tiket     : #{$tiketId}
- Jenis Gangguan  : {$kategori}
- Nama Pelapor    : {$pelapor}
- Lokasi Kejadian : {$lokasi}

INSTRUKSI PENANGANAN:
1. Terapkan K3 Tegangan Rendah secara ketat.
2. Isolasi titik hubung singkat / ganti MCB rusak.
3. Ambil dokumentasi foto sebelum dan sesudah perbaikan.
4. Laporkan pemulihan tegangan ke Dispatcher Admin.
================================================================================
TEXT;
        }

        return "Dokumen Kedinasan PLN: {$nomorSurat}";
    }

    /**
     * Konversi data surat ke format WhatsApp Broadcast (Markdown WhatsApp)
     */
    public static function toWhatsApp(string $type, ?Bill $bill = null, ?OutageReport $outage = null): string
    {
        $nomorSurat = self::generateNomorSurat($type);
        $tgl = now()->translatedFormat('d M Y');

        if ($type === 'sp1') {
            $nama = $bill?->customer->nama ?? 'Bapak/Ibu';
            $idPel = $bill?->customer->id_pelanggan ?? '-';
            $total = number_format($bill?->total_biaya ?? 0, 0, ',', '.');

            return "*[PEMBERITAHUAN RESMI PT PLN (PERSERO)]*\n"
                . "No: _{$nomorSurat}_\n\n"
                . "Kepada Yth. *{$nama}*\n"
                . "ID Pelanggan: `{$idPel}`\n\n"
                . "Kami menginformasikan bahwa tagihan listrik Anda periode berjalan tercatat belum lunas dengan rincian:\n"
                . "💰 *Total Wajib Bayar: Rp {$total}*\n"
                . "⏳ *Batas Waktu: 3 Hari Kerja*\n\n"
                . "Mohon segera lakukan pembayaran melalui aplikasi *PLN DIGI* atau gerai pembayaran terdekat guna menghindari sanksi pemutusan sementara.\n\n"
                . "_Informasi resmi Call Center PLN: 123_";
        }

        if ($type === 'sp2') {
            $nama = $bill?->customer->nama ?? 'Bapak/Ibu';
            $idPel = $bill?->customer->id_pelanggan ?? '-';
            $total = number_format($bill?->total_biaya ?? 0, 0, ',', '.');

            return "🚨 *[PERINGATAN TERAKHIR - PEMUTUSAN SEMENTARA]*\n"
                . "PT PLN (Persero) - No: _{$nomorSurat}_\n\n"
                . "Yth. *{$nama}* (`{$idPel}`)\n\n"
                . "Berdasarkan Permen ESDM No. 27/2017, kami memberikan batas waktu *1x24 Jam* untuk menyelesaikan tunggakan sebesar *Rp {$total}*.\n\n"
                . "Jika tidak diselesaikan, petugas lapangan akan melakukan *PEMUTUSAN SEMENTARA* pada kWh meter hari ini.\n\n"
                . "Bayar instan di aplikasi PLN DIGI: http://localhost:8000/dashboard/tagihan";
        }

        return "Pemberitahuan Resmi PLN DIGI: {$nomorSurat}";
    }

    /**
     * Konversi dokumen ke PDF menggunakan Built-in Headless Browser CLI (Edge / Chrome)
     * Tidak membutuhkan package composer tambahan!
     */
    public static function convertUrlToPdfViaCli(string $url, string $outputPdfPath): array
    {
        // Deteksi executable headless browser yang tersedia di sistem
        $browsers = [
            'msedge',                                    // Microsoft Edge (Default di Windows)
            'chrome',                                    // Google Chrome
            'C:\Program Files (x86)\Microsoft\Edge\Application\msedge.exe',
            'C:\Program Files\Google\Chrome\Application\chrome.exe',
            '/usr/bin/google-chrome',                   // Linux
            '/usr/bin/chromium-browser',                // Linux Chromium
        ];

        $executable = null;
        foreach ($browsers as $b) {
            $check = Process::run("where {$b} 2>nul || which {$b} 2>/dev/null");
            if ($check->successful() || file_exists($b)) {
                $executable = $b;
                break;
            }
        }

        if (! $executable) {
            return [
                'success' => false,
                'message' => 'Headless browser (msedge/chrome) tidak ditemukan di PATH sistem.',
            ];
        }

        // Jalankan perintah print-to-pdf headless
        $cmd = "\"{$executable}\" --headless --disable-gpu --no-pdf-header-footer --print-to-pdf=\"{$outputPdfPath}\" \"{$url}\"";
        $result = Process::run($cmd);

        return [
            'success' => $result->successful() && file_exists($outputPdfPath),
            'command' => $cmd,
            'output_path' => $outputPdfPath,
            'error'   => $result->errorOutput(),
        ];
    }
}

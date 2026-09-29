<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cetak Dokumen Kedinasan - PT PLN (Persero) {{ $nomorSurat }}</title>
    
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=JetBrains+Mono:wght@400;600&display=swap" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background: #f1f5f9;
            color: #0f172a;
        }

        .paper-a4 {
            width: 210mm;
            min-height: 297mm;
            padding: 20mm 20mm 20mm 25mm;
            margin: 20px auto;
            background: white;
            box-shadow: 0 4px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
            position: relative;
            box-sizing: border-box;
        }

        @media print {
            body {
                background: white !important;
                margin: 0 !important;
                padding: 0 !important;
            }
            .no-print {
                display: none !important;
            }
            .paper-a4 {
                width: 100% !important;
                min-height: auto !important;
                margin: 0 !important;
                padding: 15mm 20mm !important;
                box-shadow: none !important;
                page-break-after: avoid;
            }
        }
    </style>
</head>
<body class="antialiased">

    <!-- Top Floating Toolbar (No Print) -->
    <header class="no-print sticky top-0 z-50 bg-[#001a4d] border-b border-white/10 text-white px-4 py-3 shadow-md">
        <div class="max-w-5xl mx-auto flex items-center justify-between">
            <div class="flex items-center gap-3">
                <a href="{{ route('admin.letters', ['type' => $type, 'bill_id' => $bill?->id, 'outage_id' => $outage?->id]) }}" 
                   class="px-3 py-1.5 rounded-lg bg-white/10 hover:bg-white/20 text-xs font-semibold flex items-center gap-1.5 transition">
                    <i class="fas fa-arrow-left"></i> Kembali ke Generator
                </a>
                <span class="text-white/40">|</span>
                <span class="text-xs font-mono text-[#FDB813]">
                    <i class="fas fa-file-signature mr-1"></i> {{ $nomorSurat }}
                </span>
            </div>

            <div class="flex items-center gap-2">
                <button type="button" onclick="window.print()" class="px-4 py-1.5 rounded-lg bg-[#FDB813] text-[#001a4d] hover:bg-yellow-400 font-bold text-xs flex items-center gap-1.5 transition shadow">
                    <i class="fas fa-print"></i> Cetak / Simpan PDF
                </button>
            </div>
        </div>
    </header>

    <!-- Main A4 Paper Content -->
    <main class="paper-a4">
        
        <!-- KOP SURAT RESMI PT PLN (PERSERO) -->
        <div class="flex items-center justify-between border-b-2 border-slate-900 pb-3 mb-6">
            <div class="flex items-center gap-3">
                <div class="w-12 h-12 bg-[#00529C] text-[#FDB813] rounded-xl flex items-center justify-center font-bold text-2xl shadow-xs">
                    <i class="fas fa-bolt"></i>
                </div>
                <div>
                    <h1 class="text-base font-black tracking-wider text-[#00529C] uppercase leading-tight">PT PLN (PERSERO)</h1>
                    <p class="text-[11px] font-bold text-slate-800 uppercase tracking-wide">DISTRIBUSI JAKARTA RAYA & TANGERANG</p>
                    <p class="text-[10px] text-slate-500">UNIT LAYANAN PELANGGAN (ULP) CIRACAS</p>
                </div>
            </div>
            <div class="text-right text-[10px] text-slate-500 font-mono">
                <p>Call Center: 123 | pln123@pln.co.id</p>
                <p>www.pln.co.id</p>
                <p class="font-bold text-slate-700">ISO 9001:2015 Terverifikasi</p>
            </div>
        </div>

        @if($type === 'sp1')
            <!-- SURAT PERINGATAN 1 (SP-1) -->
            <div class="flex justify-between items-start text-xs mb-6 font-sans">
                <div class="space-y-1">
                    <p><strong>Nomor</strong> : <span class="font-mono text-slate-800">{{ $nomorSurat }}</span></p>
                    <p><strong>Lampiran</strong> : 1 (satu) Berkas Lembar Rincian Tagihan</p>
                    <p><strong>Sifat</strong> : <span class="font-bold uppercase text-amber-600">PENTING (SP-1)</span></p>
                    <p><strong>Perihal</strong> : <span class="font-bold underline">Surat Pemberitahuan Tunggakan Rekening Listrik</span></p>
                </div>
                <div class="text-right text-xs">
                    <p>Jakarta, {{ now()->translatedFormat('d F Y') }}</p>
                </div>
            </div>

            <div class="text-xs mb-6 space-y-0.5">
                <p>Kepada Yth.</p>
                <p class="font-bold text-sm text-slate-900">{{ $bill?->customer->nama ?? 'Bapak / Ibu Pelanggan PLN' }}</p>
                <p class="text-slate-600">{{ $bill?->customer->alamat ?? 'Alamat Terdaftar di Sistem PLN DIGI' }}</p>
                <p class="font-mono text-[#00529C] font-semibold">ID Pelanggan: {{ $bill?->customer->id_pelanggan ?? '532100889912' }} (Tarif: {{ $bill?->customer->tariff->kode_tarif ?? 'R1' }} / {{ number_format($bill?->customer->daya ?? 1300, 0, ',', '.') }} VA)</p>
                <p>Di Tempat</p>
            </div>

            <div class="text-xs leading-relaxed text-justify space-y-4 mb-6 text-slate-800">
                <p>
                    Dengan hormat, kami sampaikan terima kasih atas kepercayaan Bapak/Ibu menggunakan tenaga listrik dari PT PLN (Persero). 
                    Berdasarkan catatan sistem tagihan digital PLN DIGI hingga tanggal surat ini diterbitkan, kami memberitahukan bahwa rekening listrik atas nama Bapak/Ibu tercatat telah melampaui tanggal jatuh tempo pembayaran.
                </p>

                <!-- Box Rincian Tagihan -->
                <div class="p-3.5 bg-slate-50 border border-slate-200 rounded-xl space-y-1 font-mono text-xs">
                    <div class="flex justify-between">
                        <span class="text-slate-500">ID Pelanggan:</span>
                        <span class="font-bold text-slate-900">{{ $bill?->customer->id_pelanggan ?? '532100889912' }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-slate-500">Periode Tagihan:</span>
                        <span class="font-bold text-slate-900">{{ $bill?->periode ? \Carbon\Carbon::parse($bill->periode . '-01')->translatedFormat('F Y') : now()->translatedFormat('F Y') }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-slate-500">Pemakaian Listrik:</span>
                        <span class="font-bold text-slate-900">{{ number_format($bill?->meterReading?->pemakaian_kwh ?? 184, 0, ',', '.') }} kWh</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-slate-500">Denda Keterlambatan:</span>
                        <span class="font-bold text-amber-600">Rp {{ number_format($bill?->denda ?? 15000, 0, ',', '.') }}</span>
                    </div>
                    <div class="flex justify-between border-t border-slate-200 pt-1">
                        <span class="font-bold text-slate-700">Total Tagihan Wajib Dibayar:</span>
                        <span class="font-extrabold text-red-600">Rp {{ number_format($bill?->total_bayar ?? 276000, 0, ',', '.') }}</span>
                    </div>
                </div>

                <p>
                    Sehubungan dengan hal tersebut, kami menghimbau agar Bapak/Ibu dapat segera melakukan pelunasan tagihan selambat-lambatnya dalam waktu <strong>3 (tiga) hari kerja</strong> sejak diterbitkannya surat peringatan ini melalui aplikasi PLN DIGI, Virtual Account Bank, Kantor Pos, maupun gerai mitra pembayaran resmi terdekat.
                </p>

                <p>
                    Apabila sampai dengan batas waktu yang ditentukan pelunasan belum diselesaikan, maka sesuai Peraturan Direksi PT PLN (Persero) serta ketentuan Perjanjian Jual Beli Tenaga Listrik (PJBTL), kami terpaksa akan melakukan tindakan <em>Surat Peringatan 2 (SP-2)</em> yang dilanjutkan dengan pemutusan sementara sambungan tenaga listrik.
                </p>
                <p>
                    Apabila Bapak/Ibu telah melakukan pembayaran sebelum surat ini diterima, mohon surat ini dapat diabaikan atau kirimkan bukti bayar melalui menu layanan PLN DIGI. Atas perhatian dan kerjasamanya, kami ucapkan terima kasih.
                </p>
            </div>

        @elseif($type === 'sp2')
            <!-- SURAT PERINGATAN 2 (SP-2) & PEMUTUSAN -->
            <div class="flex justify-between items-start text-xs mb-6 font-sans">
                <div class="space-y-1">
                    <p><strong>Nomor</strong> : <span class="font-mono text-slate-800">{{ $nomorSurat }}</span></p>
                    <p><strong>Lampiran</strong> : 1 (satu) Berkas Lembar Rekapitulasi Tagihan & Denda</p>
                    <p><strong>Sifat</strong> : <span class="font-bold uppercase text-red-600">SANGAT PENTING / SEGERA (SP-2)</span></p>
                    <p><strong>Perihal</strong> : <span class="font-bold underline text-red-700">Peringatan Terakhir dan Pemberitahuan Pemutusan Sementara Sambungan Listrik</span></p>
                </div>
                <div class="text-right text-xs">
                    <p>Jakarta, {{ now()->translatedFormat('d F Y') }}</p>
                </div>
            </div>

            <div class="text-xs mb-6 space-y-0.5">
                <p>Kepada Yth.</p>
                <p class="font-bold text-sm text-slate-900">{{ $bill?->customer->nama ?? 'Bapak / Ibu Pelanggan PLN' }}</p>
                <p class="text-slate-600">{{ $bill?->customer->alamat ?? 'Alamat Terdaftar di Sistem PLN DIGI' }}</p>
                <p class="font-mono text-red-600 font-semibold">ID Pelanggan: {{ $bill?->customer->id_pelanggan ?? '532100889912' }} (Tarif: {{ $bill?->customer->tariff->kode_tarif ?? 'R1' }} / {{ number_format($bill?->customer->daya ?? 1300, 0, ',', '.') }} VA)</p>
                <p>Di Tempat</p>
            </div>

            <div class="text-xs leading-relaxed text-justify space-y-4 mb-6 text-slate-800">
                <p>
                    Merujuk pada Surat Peringatan Pertama (SP-1) yang telah kami kirimkan sebelumnya perihal tunggakan rekening listrik, dengan ini kami sampaikan bahwa hingga saat ini sistem PLN DIGI belum mencatat adanya pelunasan atas kewajiban tagihan listrik Bapak/Ibu.
                </p>

                <!-- Box Rincian Tunggakan Kritis -->
                <div class="p-3.5 bg-red-50/70 border border-red-200 rounded-xl space-y-1 font-mono text-xs">
                    <div class="flex justify-between">
                        <span class="text-slate-600">ID Pelanggan / Rekening:</span>
                        <span class="font-bold text-slate-900">{{ $bill?->customer->id_pelanggan ?? '532100889912' }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-slate-600">Total Keterlambatan:</span>
                        <span class="font-bold text-red-700">{{ $bill?->tanggal_jatuh_tempo ? now()->diffInDays(\Carbon\Carbon::parse($bill->tanggal_jatuh_tempo)) : 14 }} Hari Melampaui Batas</span>
                    </div>
                    <div class="flex justify-between border-t border-red-200 pt-1">
                        <span class="font-bold text-red-900">Total Tunggakan Pokok + Denda:</span>
                        <span class="font-extrabold text-red-700 text-sm">Rp {{ number_format($bill?->total_bayar ?? 345000, 0, ',', '.') }}</span>
                    </div>
                </div>

                <p>
                    Berdasarkan Peraturan Menteri ESDM Nomor 27 Tahun 2017 dan Ketentuan PJBTL PT PLN (Persero), dengan ini kami memberikan <strong>peringatan terakhir</strong> dan waktu pelunasan selama <strong>1 x 24 Jam</strong> sejak diterbitkannya surat ini.
                </p>
                <p>
                    Apabila sampai dengan batas waktu tersebut di atas pembayaran belum lunas, maka Tim Pelaksana Penertiban Pemakaian Tenaga Listrik (P2TL) / Petugas YanTek akan melakukan <strong>PEMUTUSAN SEMENTARA</strong> pada kWh Meter instalasi listrik pelanggan tanpa pemberitahuan terpisah berikutnya.
                </p>
                <p>
                    Penyambungan kembali hanya dapat diproses setelah seluruh tunggakan pokok, denda keterlambatan, serta biaya penyambungan kembali diselesaikan melalui kanal resmi PLN DIGI.
                </p>
            </div>

        @elseif($type === 'spk')
            <!-- SURAT PERINTAH KERJA (SPK) YANTEK -->
            <div class="flex justify-between items-start text-xs mb-6 font-sans">
                <div class="space-y-1">
                    <p><strong>Nomor SPK</strong> : <span class="font-mono text-slate-800">{{ $nomorSurat }}</span></p>
                    <p><strong>Lampiran</strong> : Lembar Berita Acara & SOP Penanganan</p>
                    <p><strong>Prioritas</strong> : <span class="font-bold uppercase text-red-600">DISPATCH SEGERA (SLA 3 JAM)</span></p>
                    <p><strong>Perihal</strong> : <span class="font-bold underline text-[#00529C]">Surat Perintah Kerja (SPK) Penanganan Gangguan / Pemulihan Daya</span></p>
                </div>
                <div class="text-right text-xs">
                    <p>Jakarta, {{ now()->translatedFormat('d F Y') }}</p>
                    <p class="font-mono text-[10px] text-slate-500">Pukul: {{ now()->format('H:i') }} WIB</p>
                </div>
            </div>

            <div class="text-xs mb-6 space-y-0.5">
                <p>Kepada Petugas Lapangan:</p>
                <p class="font-bold text-sm text-slate-900">TIM PELAYANAN TEKNIK (YANTEK) REGU ALPHA - CIRACAS</p>
                <p class="text-slate-600">Koordinator: Regu Cepat Tanggap Gangguan Distribusi</p>
                <p>Di Lapangan</p>
            </div>

            <div class="text-xs leading-relaxed text-justify space-y-4 mb-6 text-slate-800">
                <p>
                    Dengan ini diperintahkan kepada Tim Pelayanan Teknik (YANTEK) ULP Ciracas untuk segera melakukan tindakan perbaikan, inspeksi, dan penanganan gangguan sistem tenaga listrik di lokasi berikut sesuai tiket pengaduan masyarakat yang masuk pada sistem PLN DIGI:
                </p>

                <!-- Box Rincian Tiket & Lokasi -->
                <div class="p-3.5 bg-yellow-50/70 border border-yellow-200 rounded-xl space-y-1.5 font-mono text-xs">
                    <div class="flex justify-between">
                        <span class="text-slate-600">Nomor Tiket:</span>
                        <span class="font-bold text-[#00529C]">#{{ $outage?->id ?? '701' }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-slate-600">Jenis Gangguan:</span>
                        <span class="font-bold text-red-600">{{ $outage?->label_kategori ?? 'Padam Total Wilayah / Korsleting' }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-slate-600">Pelapor:</span>
                        <span class="font-bold text-slate-900">{{ $outage?->user->name ?? 'Warga Setempat' }} ({{ $outage?->customer?->id_pelanggan ?? '532100889912' }})</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-slate-600">Lokasi / Alamat:</span>
                        <span class="font-bold text-slate-900">{{ $outage?->lokasi ?? 'Jl. Raya Ciracas No. 42, RT 04/RW 02, Jakarta Timur' }}</span>
                    </div>
                    <div class="border-t border-yellow-200 pt-1 text-[11px] text-slate-700">
                        <span class="font-semibold text-slate-500">Deskripsi Masalah:</span>
                        <p class="font-sans italic mt-0.5">{{ $outage?->deskripsi ?? 'Trafo meledak dan listrik mati total di 3 blok perumahan sejak pukul 01:15 WIB.' }}</p>
                    </div>
                </div>

                <p>
                    <strong>Instruksi Khusus Petugas:</strong>
                </p>
                <ol class="list-decimal list-inside space-y-1 pl-2">
                    <li>Wajib menerapkan Standar Keselamatan dan Kesehatan Kerja (K3) Listrik Tegangan Rendah / Menengah.</li>
                    <li>Lakukan isolasi titik hubung singkat / ganti MCB / perbaiki sambungan kabel JTR yang mengalami anomali.</li>
                    <li>Ambil dokumentasi foto sebelum (before) dan sesudah (after) perbaikan melalui aplikasi PLN DIGI Petugas.</li>
                    <li>Selesaikan penanganan sebelum batas SLA berakhir dan laporkan status terkini ke Dispatcher Admin.</li>
                </ol>
            </div>

        @else
            <!-- BERITA ACARA PEMERIKSAAN METER (BA-P2TL) -->
            <div class="flex justify-between items-start text-xs mb-6 font-sans">
                <div class="space-y-1">
                    <p><strong>Nomor Dokumen</strong> : <span class="font-mono text-slate-800">{{ $nomorSurat }}</span></p>
                    <p><strong>Lampiran</strong> : Foto Stand Meter & Log Perekaman SwaCAM</p>
                    <p><strong>Sifat</strong> : <span class="font-bold uppercase text-blue-800">RESMI / KEDINASAN</span></p>
                    <p><strong>Perihal</strong> : <span class="font-bold underline text-[#00529C]">Berita Acara Hasil Audit dan Verifikasi Stand Meter (SwaCAM)</span></p>
                </div>
                <div class="text-right text-xs">
                    <p>Jakarta, {{ now()->translatedFormat('d F Y') }}</p>
                </div>
            </div>

            <div class="text-xs leading-relaxed text-justify space-y-4 mb-6 text-slate-800">
                <p>
                    Pada hari ini <strong>{{ now()->translatedFormat('l') }}</strong>, tanggal <strong>{{ now()->translatedFormat('d F Y') }}</strong>, bertempat di Kantor Unit Layanan Pelanggan (ULP) Ciracas, telah dilaksanakan audit verifikasi catatan meter mandiri (SwaCAM) pelanggan PLN DIGI untuk penerbitan rekening listrik.
                </p>

                <!-- Box Rincian Meter -->
                <div class="p-3.5 bg-slate-50 border border-slate-200 rounded-xl space-y-1 font-mono text-xs">
                    <div class="flex justify-between">
                        <span class="text-slate-500">ID Pelanggan:</span>
                        <span class="font-bold text-slate-900">{{ $bill?->customer->id_pelanggan ?? '532100889912' }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-slate-500">Nama Pelanggan:</span>
                        <span class="font-bold text-slate-900">{{ $bill?->customer->nama ?? 'Ahmad Fauzi' }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-slate-500">Stand Meter Tercatat:</span>
                        <span class="font-bold text-[#00529C]">014.892 kWh (Validitas: Terverifikasi OCR / SwaCAM)</span>
                    </div>
                    <div class="flex justify-between border-t border-slate-200 pt-1">
                        <span class="font-bold text-slate-700">Hasil Audit:</span>
                        <span class="font-bold text-emerald-600">SESUAI DENGAN HISTORI KONSUMSI NORMAL</span>
                    </div>
                </div>

                <p>
                    Berdasarkan hasil uji validasi data visual dan anomali algoritma PLN DIGI, dinyatakan bahwa data angka stand meter tersebut dinyatakan <strong>SAH dan VALID</strong> untuk dijadikan dasar penetapan tagihan rekening listrik periode berjalan.
                </p>
                <p>
                    Demikian Berita Acara ini dibuat dengan sebenarnya dan penuh rasa tanggung jawab untuk dapat dipergunakan sebagaimana mestinya.
                </p>
            </div>
        @endif

        <!-- Tanda Tangan & QR Code Autentikasi Kedinasan -->
        <div class="flex justify-between items-end mt-16 pt-6 font-sans text-xs border-t border-slate-300">
            <div class="flex items-center gap-3">
                <div class="w-16 h-16 border border-slate-400 rounded-lg p-1 bg-white flex flex-col items-center justify-center text-center">
                    <i class="fas fa-qrcode text-3xl text-slate-800"></i>
                    <span class="text-[7px] font-mono text-slate-500 mt-0.5">VERIFIED</span>
                </div>
                <div class="text-[10px] text-slate-600 leading-tight">
                    <p class="font-bold text-slate-800">Dokumen Sah Digital PLN</p>
                    <p>Ditandatangani secara elektronik</p>
                    <p class="font-mono text-slate-500">UUID: 8F2A-94B1-PLNDIGI</p>
                </div>
            </div>

            <div class="text-center w-56">
                <p class="font-bold text-slate-800">PT PLN (PERSERO)</p>
                <p class="text-[11px] text-slate-600">Manajer Unit Layanan Pelanggan</p>
                <div class="h-16 flex items-center justify-center my-1 relative">
                    <span class="text-xs font-serif italic text-blue-900 opacity-60 tracking-widest">[Cap & TTD Elektronik]</span>
                    <div class="absolute w-20 h-20 rounded-full border-2 border-red-500/30 flex items-center justify-center text-[9px] font-bold text-red-500/40 rotate-12 uppercase pointer-events-none">
                        PLN RESMI
                    </div>
                </div>
                <p class="font-bold underline text-slate-900">IR. H. BAMBANG PRASETYO, M.T.</p>
                <p class="text-[10px] font-mono text-slate-500">NIP: 198403152008121002</p>
            </div>
        </div>

    </main>

</body>
</html>

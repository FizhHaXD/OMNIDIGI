@extends('layouts.main')
@section('title', 'Pusat Dokumen & Surat Kedinasan AI - Admin PLN DIGI')

@section('content')
{{-- Header --}}
<section class="relative -mt-16 md:-mt-18 bg-gradient-to-br from-[#001230] via-[#00265a] to-[#001a4d] text-white overflow-hidden">
    <div class="absolute inset-0 opacity-10 pointer-events-none">
        <div class="absolute top-10 right-10 w-96 h-96 bg-[#FDB813] rounded-full blur-[140px]"></div>
    </div>
    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-32 pb-8 md:pt-36 md:pb-10">
        <div class="flex flex-col md:flex-row md:items-end justify-between gap-6 mb-6">
            <div>
                <span class="inline-flex items-center gap-2 px-3.5 py-1 bg-white/10 rounded-full text-[#FDB813] text-xs font-semibold uppercase tracking-wider mb-3 border border-white/10">
                    <i class="fas fa-magic"></i> AI Agent Ready Document Center
                </span>
                <h1 class="text-3xl md:text-4xl font-extrabold tracking-tight">Pusat Generator Surat Kedinasan PLN</h1>
                <p class="text-white/60 text-sm mt-1">Otomasi penyusunan Surat Peringatan, Surat Perintah Kerja (SPK), dan Berita Acara berbasis data operasional.</p>
            </div>
            
            <div class="flex items-center gap-2">
                <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl bg-emerald-500/20 text-emerald-400 border border-emerald-500/30 text-xs font-semibold">
                    <i class="fas fa-circle text-[8px] animate-pulse"></i> Siap Integrasi AI Agent
                </span>
            </div>
        </div>

        {{-- Sub-Navigation Tabs --}}
        @include('admin.partials.nav')
    </div>
</section>

<section class="py-8 md:py-12 bg-slate-50/60 min-h-screen" x-data="letterGenerator()">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        {{-- Tab Jenis Surat --}}
        <div class="flex flex-wrap gap-2 mb-6">
            <button type="button" @click="setTemplate('sp1')" 
                    :class="activeType === 'sp1' ? 'bg-[#00529C] text-white shadow-md' : 'bg-white text-slate-700 hover:bg-slate-50 border border-slate-200'"
                    class="px-4 py-2.5 rounded-xl text-xs font-bold transition-all flex items-center gap-2">
                <i class="fas fa-envelope-open-text text-amber-400"></i>
                <span>Surat Peringatan 1 (SP-1) Tunggakan</span>
            </button>

            <button type="button" @click="setTemplate('sp2')" 
                    :class="activeType === 'sp2' ? 'bg-[#00529C] text-white shadow-md' : 'bg-white text-slate-700 hover:bg-slate-50 border border-slate-200'"
                    class="px-4 py-2.5 rounded-xl text-xs font-bold transition-all flex items-center gap-2">
                <i class="fas fa-ban text-red-400"></i>
                <span>Surat Peringatan 2 & Pemutusan (SP-2)</span>
            </button>

            <button type="button" @click="setTemplate('spk')" 
                    :class="activeType === 'spk' ? 'bg-[#00529C] text-white shadow-md' : 'bg-white text-slate-700 hover:bg-slate-50 border border-slate-200'"
                    class="px-4 py-2.5 rounded-xl text-xs font-bold transition-all flex items-center gap-2">
                <i class="fas fa-tools text-yellow-400"></i>
                <span>Surat Perintah Kerja (SPK) YANTEK</span>
            </button>

            <button type="button" @click="setTemplate('ba_meter')" 
                    :class="activeType === 'ba_meter' ? 'bg-[#00529C] text-white shadow-md' : 'bg-white text-slate-700 hover:bg-slate-50 border border-slate-200'"
                    class="px-4 py-2.5 rounded-xl text-xs font-bold transition-all flex items-center gap-2">
                <i class="fas fa-file-contract text-emerald-400"></i>
                <span>Berita Acara Pemeriksaan Meter (BA-P2TL)</span>
            </button>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
            
            {{-- Panel Kiri: Konfigurasi Parameter Surat & AI Prompt (Col 5) --}}
            <div class="lg:col-span-5 space-y-6">

                {{-- Card Pilih Data Sumber dari Database --}}
                <div class="card p-5 border-l-4 border-l-[#00529C]">
                    <h3 class="text-sm font-bold text-slate-900 mb-3 flex items-center gap-2">
                        <i class="fas fa-database text-[#00529C]"></i>
                        <span>Pilih Sumber Data dari Database</span>
                    </h3>

                    {{-- Jika Surat Peringatan (Tarik data Bill) --}}
                    <div x-show="activeType === 'sp1' || activeType === 'sp2'" class="space-y-3">
                        <label class="block text-xs font-semibold text-slate-600">Pilih Rekening Menunggak:</label>
                        <select class="form-input text-xs w-full rounded-xl" @change="onSelectBill($event.target.value)">
                            @foreach($overdueBills as $b)
                                <option value="{{ $b->id }}" {{ (isset($selectedBill) && $selectedBill->id === $b->id) ? 'selected' : '' }}>
                                    {{ $b->customer->id_pelanggan }} — {{ $b->customer->nama }} (Rp {{ number_format($b->total_bayar, 0, ',', '.') }})
                                </option>
                            @endforeach
                        </select>
                        <p class="text-[11px] text-slate-400">Data otomatis menarik ID Pelanggan, alamat, rincian tunggakan, dan denda.</p>
                    </div>

                    {{-- Jika SPK Gangguan (Tarik data Outage) --}}
                    <div x-show="activeType === 'spk'" class="space-y-3" style="display: none;">
                        <label class="block text-xs font-semibold text-slate-600">Pilih Tiket Gangguan Warga:</label>
                        <select class="form-input text-xs w-full rounded-xl" @change="onSelectOutage($event.target.value)">
                            @foreach($activeOutages as $o)
                                <option value="{{ $o->id }}" {{ (isset($selectedOutage) && $selectedOutage->id === $o->id) ? 'selected' : '' }}>
                                    TIKET #{{ $o->id }} — {{ $o->label_kategori }} ({{ Str::limit($o->lokasi, 35) }})
                                </option>
                            @endforeach
                        </select>
                        <p class="text-[11px] text-slate-400">Data otomatis menarik lokasi gangguan, kategori bahaya, dan nama pelapor.</p>
                    </div>
                </div>

                {{-- Parameter Input Form --}}
                <div class="card p-5">
                    <h3 class="text-sm font-bold text-slate-900 mb-3 flex items-center justify-between">
                        <span class="flex items-center gap-2">
                            <i class="fas fa-sliders-h text-slate-500"></i> Parameter Variabel Surat
                        </span>
                        <span class="text-[10px] text-slate-400 uppercase">Live Update</span>
                    </h3>

                    <div class="space-y-3 text-xs">
                        <div>
                            <label class="block font-semibold text-slate-600 mb-1">Nomor Surat Resmi:</label>
                            <input type="text" x-model="formData.noSurat" class="form-input text-xs w-full font-mono rounded-lg">
                        </div>

                        <div>
                            <label class="block font-semibold text-slate-600 mb-1">Unit Layanan Pelanggan (ULP):</label>
                            <input type="text" x-model="formData.unitLayanan" class="form-input text-xs w-full rounded-lg">
                        </div>

                        <div>
                            <label class="block font-semibold text-slate-600 mb-1">Nama Penerima / Pelanggan:</label>
                            <input type="text" x-model="formData.namaPenerima" class="form-input text-xs w-full rounded-lg">
                        </div>

                        <div>
                            <label class="block font-semibold text-slate-600 mb-1">Alamat / Lokasi Objek:</label>
                            <textarea rows="2" x-model="formData.alamat" class="form-input text-xs w-full rounded-lg"></textarea>
                        </div>

                        <div class="grid grid-cols-2 gap-3">
                            <div>
                                <label class="block font-semibold text-slate-600 mb-1">ID Pelanggan / No. Tiket:</label>
                                <input type="text" x-model="formData.idRef" class="form-input text-xs w-full font-mono rounded-lg">
                            </div>
                            <div>
                                <label class="block font-semibold text-slate-600 mb-1">Batas Waktu / Target SLA:</label>
                                <input type="text" x-model="formData.deadline" class="form-input text-xs w-full rounded-lg">
                            </div>
                        </div>

                        <div>
                            <label class="block font-semibold text-slate-600 mb-1">Rincian Nominal / Catatan Khusus:</label>
                            <input type="text" x-model="formData.catatanNominal" class="form-input text-xs w-full font-bold text-red-600 rounded-lg">
                        </div>
                    </div>
                </div>

                {{-- AI Agent Prompt & JSON Export Box --}}
                <div class="card p-5 bg-gradient-to-br from-slate-900 to-indigo-950 text-white shadow-lg">
                    <div class="flex items-center justify-between mb-3">
                        <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-[#FDB813] text-[#001a4d] uppercase">
                            <i class="fas fa-robot"></i> AI Agent Pipeline
                        </span>
                        <span class="text-[10px] text-white/50 font-mono">Payload Generator</span>
                    </div>
                    
                    <h4 class="text-sm font-bold mb-1">Ekspor Data untuk AI Agent Pembentuk Surat</h4>
                    <p class="text-[11px] text-white/60 mb-4 leading-relaxed">
                        Data parameter di atas dapat langsung disalin sebagai prompt siap pakai atau payload JSON terstruktur untuk dikonsumsi oleh agent LLM pembentuk dokumen dinas.
                    </p>

                    <div class="flex items-center gap-2">
                        <button type="button" @click="copyPrompt($el)" 
                                class="flex-1 py-2 px-3 bg-white/10 hover:bg-white/20 border border-white/20 rounded-xl text-xs font-semibold transition-all flex items-center justify-center gap-1.5">
                            <i class="far fa-copy text-[#FDB813]"></i> Salin Prompt AI
                        </button>
                        <button type="button" @click="copyJson($el)" 
                                class="flex-1 py-2 px-3 bg-[#00529C] hover:bg-[#003d75] rounded-xl text-xs font-semibold transition-all flex items-center justify-center gap-1.5">
                            <i class="fas fa-code text-[#FDB813]"></i> Salin JSON Payload
                        </button>
                    </div>
                </div>

            </div>

            {{-- Panel Kanan: Live Preview Dokumen Dinas Resmi PLN (Col 7) --}}
            <div class="lg:col-span-7">
                
                {{-- Action Bar Preview --}}
                <div class="flex items-center justify-between mb-4">
                    <span class="text-xs font-bold text-slate-700 flex items-center gap-2">
                        <i class="fas fa-eye text-[#00529C]"></i> Pratinjau Dokumen Dinas (Format A4 Resmi)
                    </span>
                    <div class="flex items-center gap-2">
                        <button type="button" @click="window.print()" class="btn-primary text-xs py-1.5 px-3 flex items-center gap-1.5">
                            <i class="fas fa-print"></i> Cetak / Simpan PDF
                        </button>
                    </div>
                </div>

                {{-- Lembar Surat Resmi (Official PLN Stationery Mockup) --}}
                <div class="card p-8 md:p-10 bg-white border border-slate-300 shadow-md font-serif text-slate-900 printable-sheet" style="min-height: 750px;">
                    
                    {{-- KOP SURAT RESMI PT PLN (PERSERO) --}}
                    <div class="flex items-center justify-between border-b-2 border-slate-900 pb-3 mb-6 font-sans">
                        <div class="flex items-center gap-3">
                            <div class="w-12 h-12 bg-[#00529C] text-[#FDB813] rounded-xl flex items-center justify-center font-bold text-2xl shadow-xs">
                                <i class="fas fa-bolt"></i>
                            </div>
                            <div>
                                <h2 class="text-base font-black tracking-wider text-[#00529C] uppercase leading-tight">PT PLN (PERSERO)</h2>
                                <p class="text-[11px] font-bold text-slate-800 uppercase tracking-wide">DISTRIBUSI JAKARTA RAYA</p>
                                <p class="text-[10px] text-slate-500" x-text="formData.unitLayanan">UNIT LAYANAN PELANGGAN (ULP) CIRACAS</p>
                            </div>
                        </div>
                        <div class="text-right text-[10px] text-slate-500 font-mono">
                            <p>Call Center: 123</p>
                            <p>www.pln.co.id</p>
                            <p class="font-bold text-slate-700">ISO 9001:2015</p>
                        </div>
                    </div>

                    {{-- Informasi Surat & Nomor --}}
                    <div class="flex justify-between items-start text-xs mb-6 font-sans">
                        <div class="space-y-1">
                            <p><strong>Nomor</strong> : <span class="font-mono text-slate-800" x-text="formData.noSurat"></span></p>
                            <p><strong>Lampiran</strong> : 1 (satu) Berkas Lembar Rincian</p>
                            <p><strong>Sifat</strong> : <span class="font-bold uppercase text-red-600" x-text="formData.sifat">PENTING / SEGERA</span></p>
                            <p><strong>Perihal</strong> : <span class="font-bold underline" x-text="formData.perihal"></span></p>
                        </div>
                        <div class="text-right font-sans text-xs">
                            <p>Jakarta, <span x-text="currentDate"></span></p>
                        </div>
                    </div>

                    {{-- Alamat Penerima --}}
                    <div class="text-xs mb-6 font-sans space-y-0.5">
                        <p>Kepada Yth.</p>
                        <p class="font-bold text-sm text-slate-900" x-text="formData.namaPenerima"></p>
                        <p class="text-slate-600" x-text="formData.alamat"></p>
                        <p class="font-mono text-[#00529C] font-semibold">ID Pelanggan / Ref: <span x-text="formData.idRef"></span></p>
                        <p>Di Tempat</p>
                    </div>

                    {{-- Paragraf Isi Surat --}}
                    <div class="text-xs leading-relaxed text-justify space-y-4 mb-6 font-sans text-slate-800">
                        <p x-html="formData.paragraf1"></p>

                        {{-- Kotak Rincian Tabel --}}
                        <div class="p-3.5 bg-slate-50 border border-slate-200 rounded-xl space-y-1 font-mono text-xs">
                            <div class="flex justify-between">
                                <span class="text-slate-500">ID Pelanggan / No. Tiket:</span>
                                <span class="font-bold text-slate-900" x-text="formData.idRef"></span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-slate-500">Rincian Pokok:</span>
                                <span class="font-bold text-slate-900" x-text="formData.rincianPokok"></span>
                            </div>
                            <div class="flex justify-between border-t border-slate-200 pt-1">
                                <span class="font-bold text-slate-700">Total Kewajiban / Estimasi:</span>
                                <span class="font-extrabold text-red-600" x-text="formData.catatanNominal"></span>
                            </div>
                        </div>

                        <p x-html="formData.paragraf2"></p>
                        <p x-html="formData.paragraf3"></p>
                    </div>

                    {{-- Tanda Tangan & QR Code Autentikasi --}}
                    <div class="flex justify-between items-end mt-12 pt-6 font-sans text-xs border-t border-dashed border-slate-200">
                        <div class="flex items-center gap-3">
                            <div class="w-16 h-16 border border-slate-300 rounded-lg p-1 bg-white flex flex-col items-center justify-center text-center">
                                <i class="fas fa-qrcode text-3xl text-slate-800"></i>
                                <span class="text-[8px] font-mono text-slate-400 mt-0.5">VERIFIED</span>
                            </div>
                            <div class="text-[10px] text-slate-500 leading-tight">
                                <p class="font-bold text-slate-700">Dokumen Resmi PLN DIGI</p>
                                <p>Ditandatangani secara elektronik</p>
                                <p class="font-mono text-slate-400">UUID: 8F2A-94B1-PLN</p>
                            </div>
                        </div>

                        <div class="text-center w-56">
                            <p class="font-bold text-slate-800">PT PLN (PERSERO)</p>
                            <p class="text-[11px] text-slate-600" x-text="formData.jabatanTtd">Manajer Unit Layanan Pelanggan</p>
                            <div class="h-16 flex items-center justify-center my-1 relative">
                                <span class="text-xs font-serif italic text-blue-900 opacity-60 tracking-widest">[Tanda Tangan & Cap Dinas]</span>
                                <div class="absolute w-20 h-20 rounded-full border-2 border-red-500/30 flex items-center justify-center text-[9px] font-bold text-red-500/40 rotate-12 uppercase pointer-events-none">
                                    PLN RESMI
                                </div>
                            </div>
                            <p class="font-bold underline text-slate-900" x-text="formData.namaTtd">IR. H. BAMBANG PRASETYO, M.T.</p>
                            <p class="text-[10px] font-mono text-slate-500">NIP: 198403152008121002</p>
                        </div>
                    </div>

                </div>

            </div>
        </div>

    </div>
</section>

{{-- Alpine.js State Management --}}
<script>
function letterGenerator() {
    return {
        activeType: 'sp1',
        currentDate: '{{ now()->translatedFormat("d F Y") }}',
        formData: {
            noSurat: '041/DIS.01.02/ULP-JKT/SP-1/{{ now()->format("Y") }}',
            unitLayanan: 'UNIT LAYANAN PELANGGAN (ULP) CIRACAS',
            sifat: 'PENTING / PERINGATAN',
            perihal: 'Pemberitahuan Pelunasan Tunggakan Rekening Listrik (SP-1)',
            namaPenerima: '{{ $selectedBill->customer->nama ?? "Pelanggan PLN" }}',
            alamat: '{{ $selectedBill->customer->alamat ?? "Jl. Raya Jakarta Timur" }}',
            idRef: '{{ $selectedBill->customer->id_pelanggan ?? "531200012345" }}',
            deadline: '3 (tiga) hari kerja sejak surat ini diterima',
            catatanNominal: 'Rp {{ number_format($selectedBill->total_bayar ?? 250000, 0, ",", ".") }}',
            rincianPokok: 'Periode {{ $selectedBill->nama_bulan ?? "September" }} {{ $selectedBill->tahun ?? 2026 }} ({{ number_format($selectedBill->total_kwh ?? 120) }} kWh)',
            paragraf1: 'Dengan hormat, berdasarkan hasil monitoring sistem pembukuan PLN DIGI, kami memberitahukan bahwa rekening listrik atas nama Saudara sampai saat surat ini diterbitkan tercatat masih memiliki kewajiban tertunggak yang telah melampaui tanggal jatuh tempo.',
            paragraf2: 'Sehubungan dengan hal tersebut, kami menghimbau Saudara untuk segera melakukan pelunasan sebelum batas waktu penertiban. Pembayaran dapat dilakukan dengan mudah melalui aplikasi PLN DIGI (QRIS, E-Wallet, atau Virtual Account Bank).',
            paragraf3: 'Apabila sampai dengan batas waktu yang ditentukan Saudara belum melakukan penyelesaian pembayaran, maka sesuai ketentuan Peraturan Menteri ESDM yang berlaku, dengan sangat menyesal petugas kami akan melakukan <strong>Pemutusan Sementara</strong> aliran listrik pada instalasi persil Saudara.',
            jabatanTtd: 'Manajer Unit Layanan Pelanggan',
            namaTtd: 'IR. H. BAMBANG PRASETYO, M.T.'
        },

        setTemplate(type) {
            this.activeType = type;
            if (type === 'sp1') {
                this.formData.noSurat = '041/DIS.01.02/ULP-JKT/SP-1/{{ now()->format("Y") }}';
                this.formData.sifat = 'PENTING / PERINGATAN';
                this.formData.perihal = 'Pemberitahuan Pelunasan Tunggakan Rekening Listrik (SP-1)';
                this.formData.paragraf1 = 'Dengan hormat, berdasarkan hasil monitoring sistem pembukuan PLN DIGI, kami memberitahukan bahwa rekening listrik atas nama Saudara sampai saat surat ini diterbitkan tercatat memiliki tunggakan yang telah melampaui batas tanggal jatuh tempo.';
                this.formData.paragraf2 = 'Kami mohon Saudara dapat segera melakukan pelunasan tagihan tersebut dalam waktu selambat-lambatnya 3 (tiga) hari kerja melalui loket pembayaran resmi atau aplikasi PLN DIGI.';
                this.formData.paragraf3 = 'Surat peringatan ini kami sampaikan sebagai bentuk pelayanan dan koordinasi awal demi kelancaran penyaluran tenaga listrik di tempat Saudara.';
            } else if (type === 'sp2') {
                this.formData.noSurat = '082/DIS.01.02/ULP-JKT/SP-2/{{ now()->format("Y") }}';
                this.formData.sifat = 'SANGAT SEGERA / PENERTIBAN';
                this.formData.perihal = 'Surat Peringatan Terakhir & Pemberitahuan Pemutusan Aliran Listrik (SP-2)';
                this.formData.paragraf1 = 'Menindaklanjuti Surat Peringatan Pertama (SP-1) kami terdahulu, diberitahukan dengan hormat bahwa catatan rekening listrik Saudara hingga saat ini masih belum diselesaikan.';
                this.formData.paragraf2 = 'Oleh karena itu, kami memberikan batas toleransi terakhir selambat-lambatnya 1 x 24 jam sejak surat ini diterima untuk melunasi seluruh total tagihan beserta denda keterlambatan.';
                this.formData.paragraf3 = 'Apabila Saudara mengabaikan pemberitahuan ini, petugas Pelayanan Teknik (YANTEK) didampingi tim P2TL akan melakukan <strong>Penyegelan dan Pemutusan Sementara Sambungan Tenaga Listrik</strong> pada instalasi Saudara tanpa pemberitahuan lanjutan.';
            } else if (type === 'spk') {
                this.formData.noSurat = '115/YANTEK/GANGGUAN/{{ now()->format("Y") }}';
                this.formData.sifat = 'SEGERA / DISPATCH LAPANGAN';
                this.formData.perihal = 'Surat Perintah Kerja (SPK) Penanganan Gangguan Jaringan Listrik';
                this.formData.paragraf1 = 'Sehubungan dengan laporan gangguan kelistrikan dari masyarakat melalui sistem PLN DIGI, kepada regu teknisi piket ditugaskan untuk segera melakukan investigasi dan perbaikan teknis di lapangan.';
                this.formData.paragraf2 = 'Petugas wajib mematuhi standar operasional K3 (Kesehatan dan Keselamatan Kerja) kelistrikan, menggunakan APD lengkap, serta berkoordinasi dengan warga setempat.';
                this.formData.paragraf3 = 'Laporan hasil inspeksi, penggantian komponen, dan pemulihan tegangan wajib dilaporkan kembali ke sistem dalam batas SLA maksimal 45 menit setelah unit tiba di lokasi.';
                this.formData.jabatanTtd = 'Supervisor Operasi & Pelayanan Teknik';
                this.formData.namaTtd = 'DODI KURNIAWAN, S.T.';
            } else if (type === 'ba_meter') {
                this.formData.noSurat = '204/BA-P2TL/METER/{{ now()->format("Y") }}';
                this.formData.sifat = 'RESMI / AUDIT TEKNIS';
                this.formData.perihal = 'Berita Acara Pemeriksaan Stand Meter Listrik & Kalibrasi Pengukuran';
                this.formData.paragraf1 = 'Pada hari ini telah dilakukan audit dan verifikasi pembacaan angka stand kwh-meter mandiri (SwaCAM) pelanggan untuk memastikan kesesuaian indeks pemakaian energi listrik.';
                this.formData.paragraf2 = 'Hasil verifikasi fisik menunjukkan integritas segel meter dalam kondisi baik dan pembacaan angka register meter dinyatakan akurat untuk dijadikan dasar penerbitan rekening listrik.';
                this.formData.paragraf3 = 'Demikian Berita Acara Pemeriksaan ini dibuat dengan sebenarnya dalam 2 (dua) rangkap untuk dipergunakan sebagaimana mestinya.';
            }
        },

        onSelectBill(id) {
            @foreach($overdueBills as $b)
                if (id == '{{ $b->id }}') {
                    this.formData.namaPenerima = '{{ $b->customer->nama ?? "" }}';
                    this.formData.alamat = '{{ $b->customer->alamat ?? "" }}';
                    this.formData.idRef = '{{ $b->customer->id_pelanggan ?? "" }}';
                    this.formData.catatanNominal = 'Rp {{ number_format($b->total_bayar, 0, ",", ".") }}';
                    this.formData.rincianPokok = 'Periode {{ $b->nama_bulan ?? $b->bulan }} {{ $b->tahun }} ({{ number_format($b->total_kwh) }} kWh)';
                }
            @endforeach
        },

        onSelectOutage(id) {
            @foreach($activeOutages as $o)
                if (id == '{{ $o->id }}') {
                    this.formData.namaPenerima = 'Petugas YANTEK Regu A / Pelapor: {{ $o->user->name ?? "Warga" }}';
                    this.formData.alamat = '{{ $o->lokasi }}';
                    this.formData.idRef = 'TIKET #{{ $o->id }} ({{ $o->label_kategori }})';
                    this.formData.catatanNominal = 'Prioritas Kritis / SLA 45 Menit';
                    this.formData.rincianPokok = 'Indikasi: {{ $o->deskripsi }}';
                }
            @endforeach
        },

        copyPrompt(btn) {
            const promptText = `Bertindaklah sebagai AI Agent Resmi Bagian Hukum & Administrasi PT PLN (Persero). Buatkan naskah ${this.formData.perihal} dengan ketentuan:
Nomor Surat: ${this.formData.noSurat}
Kepada: ${this.formData.namaPenerima}
Alamat: ${this.formData.alamat}
ID Pelanggan / Referensi: ${this.formData.idRef}
Rincian: ${this.formData.rincianPokok}
Kewajiban / Target: ${this.formData.catatanNominal}
Batas Waktu: ${this.formData.deadline}
Format: Tata naskah dinas resmi BUMN kelistrikan Indonesia yang formal, santun namun tegas sesuai regulasi Permen ESDM.`;

            navigator.clipboard.writeText(promptText).then(() => {
                const originalHtml = btn.innerHTML;
                btn.innerHTML = '<i class="fas fa-check text-emerald-400"></i> Prompt Tersalin!';
                setTimeout(() => { btn.innerHTML = originalHtml; }, 2000);
            });
        },

        copyJson(btn) {
            const jsonPayload = JSON.stringify({
                document_type: this.activeType,
                reference_no: this.formData.noSurat,
                subject: this.formData.perihal,
                recipient_name: this.formData.namaPenerima,
                recipient_address: this.formData.alamat,
                customer_id: this.formData.idRef,
                details: this.formData.rincianPokok,
                total_amount: this.formData.catatanNominal,
                sla_deadline: this.formData.deadline,
                issuer_branch: this.formData.unitLayanan,
                generated_at: new Date().toISOString()
            }, null, 2);

            navigator.clipboard.writeText(jsonPayload).then(() => {
                const originalHtml = btn.innerHTML;
                btn.innerHTML = '<i class="fas fa-check text-emerald-400"></i> JSON Tersalin!';
                setTimeout(() => { btn.innerHTML = originalHtml; }, 2000);
            });
        }
    }
}
</script>

<style>
@media print {
    body * {
        visibility: hidden;
    }
    .printable-sheet, .printable-sheet * {
        visibility: visible;
    }
    .printable-sheet {
        position: absolute;
        left: 0;
        top: 0;
        width: 100%;
        border: none !important;
        box-shadow: none !important;
        padding: 0 !important;
    }
}
</style>
@endsection

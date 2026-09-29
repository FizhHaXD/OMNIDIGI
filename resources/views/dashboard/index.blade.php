@extends('layouts.main')
@section('title', 'Dashboard Pelanggan - PLN DIGI')

@section('content')
{{-- Header Hero --}}
<section class="relative -mt-16 md:-mt-18 bg-gradient-to-br from-[#001230] via-[#00265a] to-[#001a4d] text-white overflow-hidden pb-14 pt-32 md:pt-36">
    <div class="absolute inset-0 opacity-20 pointer-events-none">
        <div class="absolute -top-32 right-12 w-[600px] h-[600px] bg-[#FDB813] rounded-full blur-[170px]"></div>
        <div class="absolute -bottom-32 left-12 w-[500px] h-[500px] bg-[#00529C] rounded-full blur-[150px]"></div>
    </div>

    <div class="relative w-full max-w-[1760px] mx-auto px-4 sm:px-6 lg:px-10">
        <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-6">
            
            {{-- User Greeting & Status --}}
            <div class="flex items-center gap-4 sm:gap-6">
                <div class="w-16 h-16 sm:w-20 sm:h-20 rounded-2xl bg-gradient-to-br from-white/20 to-white/5 backdrop-blur-md flex items-center justify-center border border-white/20 shadow-xl flex-shrink-0">
                    <i class="fas fa-user-circle text-[#FDB813] text-3xl sm:text-4xl"></i>
                </div>
                <div>
                    <div class="flex flex-wrap items-center gap-2.5 mb-1.5">
                        <span class="px-3.5 py-1 rounded-full bg-emerald-500/20 text-emerald-300 border border-emerald-500/30 text-xs font-bold uppercase tracking-wider flex items-center gap-1.5 shadow-xs">
                            <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span> Sambungan Listrik Aktif
                        </span>
                        <span class="px-3 py-1 rounded-full bg-white/10 text-white/90 border border-white/10 text-xs font-semibold">
                            <i class="fas fa-calendar-day mr-1.5 text-[#FDB813]"></i> {{ now()->translatedFormat('l, d F Y') }}
                        </span>
                    </div>
                    <h1 class="text-2xl sm:text-3xl lg:text-4xl font-black tracking-tight text-white leading-tight">
                        Selamat Datang, {{ $user->name }}
                    </h1>
                    <p class="text-white/75 text-sm sm:text-base mt-1 font-medium">
                        Pusat kendali layanan listrik digital, pemantauan konsumsi daya, dan transaksi terpadu PLN.
                    </p>
                </div>
            </div>

            {{-- Quick Stats Ribbon --}}
            <div class="flex flex-wrap items-center gap-3 sm:gap-4">
                {{-- PLN Point Card --}}
                <a href="{{ route('dashboard.reward') }}" class="group bg-white/10 hover:bg-white/15 backdrop-blur-md px-5 py-3.5 rounded-2xl border border-white/15 transition-all shadow-md flex items-center gap-3.5">
                    <div class="w-11 h-11 rounded-xl bg-[#FDB813] text-[#001a4d] flex items-center justify-center font-black text-xl shadow-xs group-hover:scale-105 transition-transform">
                        <i class="fas fa-gift"></i>
                    </div>
                    <div>
                        <p class="text-[11px] font-bold text-white/70 uppercase tracking-wider">PLN Point Reward</p>
                        <p class="text-xl font-black text-[#FDB813] group-hover:text-yellow-300 transition-colors">
                            {{ number_format($sisaPoin ?? 0, 0, ',', '.') }} <span class="text-xs font-medium text-white/80">Poin</span>
                        </p>
                    </div>
                </a>

                {{-- Status Daya Jaringan --}}
                <div class="bg-white/10 backdrop-blur-md px-5 py-3.5 rounded-2xl border border-white/15 shadow-md flex items-center gap-3.5">
                    <div class="w-11 h-11 rounded-xl bg-cyan-500/20 text-cyan-300 flex items-center justify-center shadow-xs">
                        <svg class="w-6 h-6 text-cyan-300" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M13 2L3 14h9l-1 8 10-12h-9l1-8z"/>
                        </svg>
                    </div>
                    <div>
                        <p class="text-[11px] font-bold text-white/70 uppercase tracking-wider">Tegangan Jaringan</p>
                        <p class="text-xl font-black text-white">
                            220V <span class="text-xs font-bold text-emerald-400">Normal (50Hz)</span>
                        </p>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>

{{-- Main Content Section (Full-Width Responsive Container) --}}
<section class="py-8 md:py-12 bg-slate-50/70 min-h-screen">
    <div class="w-full max-w-[1760px] mx-auto px-4 sm:px-6 lg:px-10 space-y-8 md:space-y-12">

        {{-- ROW 1: Master Customer Card & Billing Summary (12 Columns) --}}
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 lg:gap-8 items-stretch">
            
            {{-- Left Col (7 / 12): Data Pelanggan & Token Terakhir --}}
            <div class="lg:col-span-7 flex flex-col justify-between space-y-6">
                
                @if($customer)
                {{-- Master Customer ID Card --}}
                <div class="bg-gradient-to-br from-[#003d75] via-[#00529C] to-[#00265a] rounded-3xl p-6 sm:p-8 text-white shadow-xl relative overflow-hidden flex flex-col justify-between h-full border border-white/15">
                    <div class="absolute -top-16 -right-16 w-72 h-72 bg-white/5 rounded-full pointer-events-none"></div>
                    <div class="absolute bottom-0 right-10 w-56 h-56 bg-[#FDB813]/10 rounded-full blur-3xl pointer-events-none"></div>

                    {{-- Top Card Details --}}
                    <div>
                        <div class="flex flex-wrap items-center justify-between gap-4 mb-4">
                            <div class="flex items-center gap-2.5">
                                <span class="w-8 h-8 rounded-xl bg-white/15 flex items-center justify-center text-[#FDB813] font-bold shadow-xs">
                                    <i class="fas fa-id-card"></i>
                                </span>
                                <span class="text-xs uppercase font-extrabold tracking-widest text-white/80">ID Pelanggan Terdaftar</span>
                            </div>
                            <span class="px-3.5 py-1 rounded-full bg-emerald-400/20 text-emerald-300 border border-emerald-400/30 text-xs font-bold shadow-xs flex items-center gap-1.5">
                                <i class="fas fa-check-circle text-xs"></i> Terhubung & Terverifikasi
                            </span>
                        </div>

                        {{-- ID Pelanggan Digits --}}
                        <div class="flex flex-wrap items-center gap-3 sm:gap-4 mb-6">
                            <span class="text-3xl sm:text-4xl lg:text-5xl font-black font-mono tracking-wider text-[#FDB813] drop-shadow-sm select-all">
                                {{ $customer->id_pelanggan }}
                            </span>
                            <button type="button" onclick="copyText('{{ $customer->id_pelanggan }}', this)" 
                                    class="py-2 px-3.5 rounded-xl bg-white/10 hover:bg-white/20 text-white text-xs font-bold flex items-center gap-1.5 transition border border-white/15 shadow-sm active:scale-95"
                                    title="Salin ID Pelanggan">
                                <i class="far fa-copy text-sm"></i>
                                <span>Salin ID</span>
                            </button>
                        </div>
                    </div>

                    {{-- Bottom Specs Pill Grid --}}
                    <div class="pt-6 border-t border-white/15 grid grid-cols-1 sm:grid-cols-3 gap-3.5 sm:gap-4 text-sm">
                        <div class="bg-white/10 backdrop-blur-sm rounded-2xl p-4 border border-white/10">
                            <p class="text-white/60 text-xs font-semibold uppercase tracking-wider mb-1">Daya & Golongan</p>
                            <p class="text-base font-extrabold text-white flex items-center gap-1.5">
                                <i class="fas fa-plug text-[#FDB813]"></i>
                                {{ number_format($customer->tariff->daya_va ?? $customer->daya ?? 1300, 0, ',', '.') }} VA 
                                <span class="text-xs font-normal text-white/70">({{ $customer->tariff->kode ?? $customer->tariff->kode_tarif ?? 'R1' }})</span>
                            </p>
                        </div>

                        <div class="bg-white/10 backdrop-blur-sm rounded-2xl p-4 border border-white/10">
                            <p class="text-white/60 text-xs font-semibold uppercase tracking-wider mb-1">Nama Pemilik</p>
                            <p class="text-base font-extrabold text-white truncate" title="{{ $customer->nama }}">
                                <i class="fas fa-user-check text-cyan-300 mr-1.5"></i>{{ $customer->nama }}
                            </p>
                        </div>

                        <div class="bg-white/10 backdrop-blur-sm rounded-2xl p-4 border border-white/10">
                            <p class="text-white/60 text-xs font-semibold uppercase tracking-wider mb-1">Lokasi Alamat</p>
                            <p class="text-xs font-semibold text-white/90 truncate" title="{{ $customer->alamat }}">
                                <i class="fas fa-map-marker-alt text-amber-300 mr-1"></i>{{ $customer->alamat }}
                            </p>
                        </div>
                    </div>

                </div>
                @else
                <div class="card p-8 md:p-10 text-center h-full flex flex-col items-center justify-center border border-slate-200 shadow-md rounded-3xl">
                    <div class="w-16 h-16 rounded-2xl bg-amber-50 text-amber-500 flex items-center justify-center text-3xl mb-4 shadow-sm">
                        <i class="fas fa-exclamation-triangle"></i>
                    </div>
                    <h3 class="text-lg font-bold text-slate-900 mb-1">Belum Terhubung dengan Data Pelanggan</h3>
                    <p class="text-sm text-slate-500 max-w-md mb-4">Tambahkan ID Pelanggan listrik PLN Anda untuk mengaktifkan pemantauan real-time dan pembayaran instan.</p>
                    <a href="{{ route('profile.edit') }}" class="btn-primary text-xs py-2.5 px-5">
                        <i class="fas fa-plus mr-1.5"></i> Hubungkan ID Pelanggan
                    </a>
                </div>
                @endif

                {{-- Card Token Terakhir (Jika Prabayar) --}}
                @if($lastToken && $lastToken->token_listrik)
                <div class="card p-5 sm:p-6 border-l-4 border-l-[#FDB813] bg-gradient-to-r from-amber-50/70 via-white to-amber-50/30 shadow-md rounded-3xl border border-slate-200/80">
                    <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-5">
                        <div class="flex items-center gap-4">
                            <div class="w-14 h-14 rounded-2xl bg-amber-500/15 flex items-center justify-center text-amber-700 flex-shrink-0 border border-amber-200/60 shadow-xs">
                                <svg class="w-7 h-7 text-[#FDB813]" viewBox="0 0 24 24" fill="currentColor">
                                    <path d="M13 2L3 14h9l-1 8 10-12h-9l1-8z"/>
                                </svg>
                            </div>
                            <div>
                                <div class="flex flex-wrap items-center gap-2 mb-1">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-md text-xs font-bold bg-[#FDB813]/30 text-[#9E6E00] uppercase tracking-wider">
                                        <i class="fas fa-receipt mr-1"></i> 20 Digit Stroom Terakhir
                                    </span>
                                    <span class="text-xs text-slate-400 font-medium">{{ $lastToken->created_at->translatedFormat('d M Y, H:i') }} WIB</span>
                                </div>
                                <p class="text-xs sm:text-sm text-slate-600 font-medium">
                                    No. Meter: <strong class="font-mono text-slate-800">{{ $lastToken->no_meter }}</strong> · 
                                    Nominal: <strong class="text-emerald-700 font-bold">Rp {{ number_format($lastToken->amount, 0, ',', '.') }}</strong>
                                </p>
                            </div>
                        </div>

                        {{-- 20 Digit Token Code & Copy Button --}}
                        <div class="flex items-center justify-between sm:justify-end gap-3 bg-white p-3.5 rounded-2xl border border-slate-200 shadow-xs">
                            <div>
                                <p class="text-[10px] text-slate-400 uppercase font-bold tracking-wider">Nomor Kode Stroom</p>
                                <p class="text-lg sm:text-xl md:text-2xl font-black font-mono tracking-widest text-[#00529C] select-all">{{ $lastToken->token_listrik }}</p>
                            </div>
                            <button type="button" onclick="copyText('{{ $lastToken->token_listrik }}', this)"
                                    class="px-4 py-2.5 bg-[#00529C] hover:bg-[#003d75] text-white rounded-xl text-xs font-bold flex items-center gap-1.5 shadow transition-all whitespace-nowrap active:scale-95" 
                                    title="Salin Kode Token">
                                <i class="far fa-copy text-sm"></i>
                                <span>Salin</span>
                            </button>
                        </div>
                    </div>
                </div>
                @endif

            </div>

            {{-- Right Col (5 / 12): Ringkasan Tagihan & Finansial --}}
            <div class="lg:col-span-5 flex flex-col justify-between space-y-6">
                
                {{-- Billing Summary Card --}}
                <div class="card p-6 sm:p-8 bg-white border border-slate-200/90 shadow-lg rounded-3xl flex flex-col justify-between h-full">
                    <div>
                        <div class="flex items-center justify-between pb-4 mb-5 border-b border-slate-100">
                            <div>
                                <h3 class="text-lg font-black text-slate-900 flex items-center gap-2">
                                    <i class="fas fa-file-invoice-dollar text-[#00529C]"></i>
                                    Status Tagihan Listrik
                                </h3>
                                <p class="text-xs text-slate-500 mt-0.5">Informasi kewajiban pembayaran bulan berjalan</p>
                            </div>
                            @if($tagihanBelumBayar > 0)
                                <span class="px-3.5 py-1 rounded-full bg-red-100 text-red-700 text-xs font-bold flex items-center gap-1.5 shadow-xs">
                                    <i class="fas fa-exclamation-circle text-xs"></i> {{ $tagihanBelumBayar }} Belum Lunas
                                </span>
                            @else
                                <span class="px-3.5 py-1 rounded-full bg-emerald-100 text-emerald-700 text-xs font-bold flex items-center gap-1.5 shadow-xs">
                                    <i class="fas fa-check-circle text-xs"></i> Lunas
                                </span>
                            @endif
                        </div>

                        {{-- Total Amount Display --}}
                        <div class="p-6 rounded-2xl bg-gradient-to-br from-slate-50 to-blue-50/50 border border-slate-200/80 mb-6">
                            <p class="text-xs font-bold text-slate-500 uppercase tracking-wider mb-1.5">Total Kewajiban Pembayaran</p>
                            <div class="flex items-baseline gap-2">
                                <span class="text-3xl sm:text-4xl lg:text-5xl font-black text-slate-900 tracking-tight">
                                    Rp {{ number_format($totalTagihan, 0, ',', '.') }}
                                </span>
                            </div>
                            @if($activeBill)
                                <div class="mt-4 pt-3 border-t border-slate-200/60 flex justify-between items-center text-xs sm:text-sm">
                                    <span class="text-slate-500 font-medium">Jatuh Tempo:</span>
                                    <span class="font-bold {{ \Carbon\Carbon::parse($activeBill->tanggal_jatuh_tempo)->isPast() ? 'text-red-600' : 'text-slate-700' }}">
                                        {{ \Carbon\Carbon::parse($activeBill->tanggal_jatuh_tempo)->translatedFormat('d F Y') }}
                                        @if(\Carbon\Carbon::parse($activeBill->tanggal_jatuh_tempo)->isPast())
                                            (Lewat Tempo)
                                        @endif
                                    </span>
                                </div>
                            @else
                                <p class="text-xs sm:text-sm text-emerald-600 font-bold mt-2.5 flex items-center gap-1.5">
                                    <i class="fas fa-check-double text-base"></i> Seluruh tagihan Anda telah lunas. Terima kasih atas kepatuhan Anda!
                                </p>
                            @endif
                        </div>
                    </div>

                    {{-- Billing Action Buttons --}}
                    <div class="space-y-3 pt-2">
                        @if($totalTagihan > 0)
                            <a href="{{ route('dashboard.tagihan') }}" class="w-full py-4 px-6 rounded-2xl bg-[#00529C] hover:bg-[#003d75] text-white font-extrabold text-sm sm:text-base flex items-center justify-center gap-2.5 shadow-lg shadow-blue-900/25 transition-all hover:scale-[1.01] active:scale-[0.99]">
                                <i class="fas fa-credit-card text-[#FDB813]"></i>
                                <span>Bayar Tagihan Sekarang</span>
                            </a>
                        @else
                            <a href="{{ route('dashboard.tagihan') }}" class="w-full py-3.5 px-6 rounded-2xl bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold text-sm flex items-center justify-center gap-2 transition">
                                <i class="fas fa-receipt text-[#00529C]"></i>
                                <span>Lihat Lembar Tagihan</span>
                            </a>
                        @endif

                        <div class="grid grid-cols-2 gap-3">
                            <a href="{{ route('dashboard.token') }}" class="py-3 px-3 rounded-2xl bg-amber-50 hover:bg-amber-100 border border-amber-200 text-amber-800 text-xs sm:text-sm font-bold flex items-center justify-center gap-2 transition text-center shadow-xs">
                                <i class="fas fa-bolt text-[#FDB813]"></i> Beli Token
                            </a>
                            <a href="{{ route('dashboard.metering') }}" class="py-3 px-3 rounded-2xl bg-emerald-50 hover:bg-emerald-100 border border-emerald-200 text-emerald-800 text-xs sm:text-sm font-bold flex items-center justify-center gap-2 transition text-center shadow-xs">
                                <i class="fas fa-camera text-emerald-600"></i> Catat Meter
                            </a>
                        </div>
                    </div>

                </div>

            </div>

        </div>

        {{-- ROW 2: Layanan Utama PLN DIGI (Menu Grid dengan Gambar & Tipografi Premium) --}}
        <div>
            <div class="flex flex-col sm:flex-row sm:items-end justify-between gap-3 mb-6 sm:mb-8">
                <div>
                    <span class="text-xs font-black uppercase tracking-wider text-[#00529C] flex items-center gap-2 mb-1.5">
                        <i class="fas fa-th-large text-sm"></i> Ekosistem Layanan Terpadu
                    </span>
                    <h2 class="text-2xl sm:text-3xl lg:text-4xl font-black text-slate-900 tracking-tight">
                        Layanan Mandiri PLN DIGI
                    </h2>
                    <p class="text-slate-500 text-sm sm:text-base mt-1 font-medium">
                        Akses instan seluruh kebutuhan kelistrikan, pembayaran, pemantauan energi, dan pelaporan kendala.
                    </p>
                </div>
            </div>

            {{-- 8 Service Cards Grid (4 Columns on Desktop, 2 on Tablet, 1 on Mobile) --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5 sm:gap-6">
                
                {{-- 1. Bayar Tagihan --}}
                <a href="{{ route('dashboard.tagihan') }}" class="card p-6 sm:p-7 group hover:shadow-2xl transition-all duration-300 hover:-translate-y-1.5 border border-slate-200/90 bg-white rounded-3xl flex flex-col justify-between relative overflow-hidden">
                    <div>
                        <div class="flex items-center justify-between mb-5">
                            <div class="w-18 h-18 sm:w-20 sm:h-20 rounded-2xl p-2 bg-blue-50/80 border border-blue-100 group-hover:scale-105 transition-transform shadow-xs">
                                <img src="{{ asset('images/services/tagihan.svg') }}" alt="Bayar Tagihan" class="w-full h-full object-contain">
                            </div>
                            <span class="relative z-10 px-3 py-1 rounded-full text-xs font-bold bg-blue-50 text-[#00529C] border border-blue-200 uppercase tracking-wide">
                                Tagihan
                            </span>
                        </div>

                        <h3 class="text-lg sm:text-xl font-extrabold text-slate-900 group-hover:text-[#00529C] transition-colors mb-2 leading-tight">
                            Bayar Tagihan
                        </h3>
                        <p class="text-xs sm:text-sm text-slate-600 leading-relaxed font-normal">
                            Cek lembar rekening bulanan, rincian biaya pemakaian, dan bayar instan via VA atau QRIS.
                        </p>
                    </div>

                    <div class="pt-5 mt-5 border-t border-slate-100 flex items-center justify-between text-xs sm:text-sm font-bold text-[#00529C]">
                        <span>Buka Tagihan</span>
                        <i class="fas fa-arrow-right group-hover:translate-x-1.5 transition-transform"></i>
                    </div>
                </a>

                {{-- 2. Beli Token Listrik --}}
                <a href="{{ route('dashboard.token') }}" class="card p-6 sm:p-7 group hover:shadow-2xl transition-all duration-300 hover:-translate-y-1.5 border border-slate-200/90 bg-white rounded-3xl flex flex-col justify-between relative overflow-hidden">
                    <div>
                        <div class="flex items-center justify-between mb-5">
                            <div class="w-18 h-18 sm:w-20 sm:h-20 rounded-2xl p-2 bg-amber-50/80 border border-amber-100 group-hover:scale-105 transition-transform shadow-xs">
                                <img src="{{ asset('images/services/token.svg') }}" alt="Beli Token Listrik" class="w-full h-full object-contain">
                            </div>
                            <span class="relative z-10 px-3 py-1 rounded-full text-xs font-bold bg-amber-50 text-amber-800 border border-amber-200 uppercase tracking-wide">
                                24/7 Stroom
                            </span>
                        </div>

                        <h3 class="text-lg sm:text-xl font-extrabold text-slate-900 group-hover:text-[#00529C] transition-colors mb-2 leading-tight">
                            Beli Token Listrik
                        </h3>
                        <p class="text-xs sm:text-sm text-slate-600 leading-relaxed font-normal">
                            Beli nomor stroom prabayar mulai Rp 20.000 dengan kode token 20 digit terbit seketika.
                        </p>
                    </div>

                    <div class="pt-5 mt-5 border-t border-slate-100 flex items-center justify-between text-xs sm:text-sm font-bold text-[#00529C]">
                        <span>Beli Token</span>
                        <i class="fas fa-arrow-right group-hover:translate-x-1.5 transition-transform"></i>
                    </div>
                </a>

                {{-- 3. Catat Meter Mandiri (SwaCAM) --}}
                <a href="{{ route('dashboard.metering') }}" class="card p-6 sm:p-7 group hover:shadow-2xl transition-all duration-300 hover:-translate-y-1.5 border border-slate-200/90 bg-white rounded-3xl flex flex-col justify-between relative overflow-hidden">
                    <div>
                        <div class="flex items-center justify-between mb-5">
                            <div class="w-18 h-18 sm:w-20 sm:h-20 rounded-2xl p-2 bg-emerald-50/80 border border-emerald-100 group-hover:scale-105 transition-transform shadow-xs">
                                <img src="{{ asset('images/services/swacam.svg') }}" alt="Catat Meter SwaCAM" class="w-full h-full object-contain">
                            </div>
                            <span class="relative z-10 px-3 py-1 rounded-full text-xs font-bold bg-emerald-50 text-emerald-800 border border-emerald-200 uppercase tracking-wide">
                                Tgl 24-27
                            </span>
                        </div>

                        <h3 class="text-lg sm:text-xl font-extrabold text-slate-900 group-hover:text-[#00529C] transition-colors mb-2 leading-tight">
                            Catat Meter Mandiri
                        </h3>
                        <p class="text-xs sm:text-sm text-slate-600 leading-relaxed font-normal">
                            Foto angka stand meter Anda setiap akhir bulan untuk penetapan tagihan yang akurat & transparan.
                        </p>
                    </div>

                    <div class="pt-5 mt-5 border-t border-slate-100 flex items-center justify-between text-xs sm:text-sm font-bold text-[#00529C]">
                        <span>Baca Meter</span>
                        <i class="fas fa-arrow-right group-hover:translate-x-1.5 transition-transform"></i>
                    </div>
                </a>

                {{-- 4. Monitoring Pemakaian --}}
                <a href="{{ route('dashboard.monitoring') }}" class="card p-6 sm:p-7 group hover:shadow-2xl transition-all duration-300 hover:-translate-y-1.5 border border-slate-200/90 bg-white rounded-3xl flex flex-col justify-between relative overflow-hidden">
                    <div>
                        <div class="flex items-center justify-between mb-5">
                            <div class="w-18 h-18 sm:w-20 sm:h-20 rounded-2xl p-2 bg-indigo-50/80 border border-indigo-100 group-hover:scale-105 transition-transform shadow-xs">
                                <img src="{{ asset('images/services/monitoring.svg') }}" alt="Monitoring Pemakaian" class="w-full h-full object-contain">
                            </div>
                            <span class="relative z-10 px-3 py-1 rounded-full text-xs font-bold bg-indigo-50 text-indigo-800 border border-indigo-200 uppercase tracking-wide">
                                Analitik
                            </span>
                        </div>

                        <h3 class="text-lg sm:text-xl font-extrabold text-slate-900 group-hover:text-[#00529C] transition-colors mb-2 leading-tight">
                            Monitoring Energi
                        </h3>
                        <p class="text-xs sm:text-sm text-slate-600 leading-relaxed font-normal">
                            Pantau grafik tren konsumsi listrik bulanan dan histori pengeluaran biaya daya Anda.
                        </p>
                    </div>

                    <div class="pt-5 mt-5 border-t border-slate-100 flex items-center justify-between text-xs sm:text-sm font-bold text-[#00529C]">
                        <span>Lihat Grafik</span>
                        <i class="fas fa-arrow-right group-hover:translate-x-1.5 transition-transform"></i>
                    </div>
                </a>

                {{-- 5. Simulasi Biaya & Pasang Baru --}}
                <a href="{{ route('dashboard.simulasi') }}" class="card p-6 sm:p-7 group hover:shadow-2xl transition-all duration-300 hover:-translate-y-1.5 border border-slate-200/90 bg-white rounded-3xl flex flex-col justify-between relative overflow-hidden">
                    <div>
                        <div class="flex items-center justify-between mb-5">
                            <div class="w-18 h-18 sm:w-20 sm:h-20 rounded-2xl p-2 bg-cyan-50/80 border border-cyan-100 group-hover:scale-105 transition-transform shadow-xs">
                                <img src="{{ asset('images/services/simulasi.svg') }}" alt="Simulasi Biaya" class="w-full h-full object-contain">
                            </div>
                            <span class="relative z-10 px-3 py-1 rounded-full text-xs font-bold bg-cyan-50 text-cyan-800 border border-cyan-200 uppercase tracking-wide">
                                Kalkulator
                            </span>
                        </div>

                        <h3 class="text-lg sm:text-xl font-extrabold text-slate-900 group-hover:text-[#00529C] transition-colors mb-2 leading-tight">
                            Simulasi Biaya Listrik
                        </h3>
                        <p class="text-xs sm:text-sm text-slate-600 leading-relaxed font-normal">
                            Hitung estimasi rekening listrik bulanan berdasarkan perabot rumah tangga atau simulasi pasang baru.
                        </p>
                    </div>

                    <div class="pt-5 mt-5 border-t border-slate-100 flex items-center justify-between text-xs sm:text-sm font-bold text-[#00529C]">
                        <span>Hitung Simulasi</span>
                        <i class="fas fa-arrow-right group-hover:translate-x-1.5 transition-transform"></i>
                    </div>
                </a>

                {{-- 6. Lapor Gangguan Listrik --}}
                <a href="{{ route('dashboard.outage') }}" class="card p-6 sm:p-7 group hover:shadow-2xl transition-all duration-300 hover:-translate-y-1.5 border border-slate-200/90 bg-white rounded-3xl flex flex-col justify-between relative overflow-hidden">
                    <div>
                        <div class="flex items-center justify-between mb-5">
                            <div class="w-18 h-18 sm:w-20 sm:h-20 rounded-2xl p-2 bg-red-50/80 border border-red-100 group-hover:scale-105 transition-transform shadow-xs">
                                <img src="{{ asset('images/services/outage.svg') }}" alt="Lapor Gangguan Listrik" class="w-full h-full object-contain">
                            </div>
                            <span class="relative z-10 px-3 py-1 rounded-full text-xs font-bold bg-red-50 text-red-700 border border-red-200 uppercase tracking-wide">
                                Siaga 24 Jam
                            </span>
                        </div>

                        <h3 class="text-lg sm:text-xl font-extrabold text-slate-900 group-hover:text-red-600 transition-colors mb-2 leading-tight">
                            Lapor Gangguan Listrik
                        </h3>
                        <p class="text-xs sm:text-sm text-slate-600 leading-relaxed font-normal">
                            Laporkan listrik padam, korsleting, atau kerusakan kWh meter untuk respon dispatching tim YANTEK.
                        </p>
                    </div>

                    <div class="pt-5 mt-5 border-t border-slate-100 flex items-center justify-between text-xs sm:text-sm font-bold text-red-600">
                        <span>Lapor Sekarang</span>
                        <i class="fas fa-arrow-right group-hover:translate-x-1.5 transition-transform"></i>
                    </div>
                </a>

                {{-- 7. PLN Reward & Point --}}
                <a href="{{ route('dashboard.reward') }}" class="card p-6 sm:p-7 group hover:shadow-2xl transition-all duration-300 hover:-translate-y-1.5 border border-slate-200/90 bg-white rounded-3xl flex flex-col justify-between relative overflow-hidden">
                    <div>
                        <div class="flex items-center justify-between mb-5">
                            <div class="w-18 h-18 sm:w-20 sm:h-20 rounded-2xl p-2 bg-amber-50/80 border border-amber-100 group-hover:scale-105 transition-transform shadow-xs">
                                <img src="{{ asset('images/services/reward.svg') }}" alt="PLN Reward" class="w-full h-full object-contain">
                            </div>
                            <span class="relative z-10 px-3 py-1 rounded-full text-xs font-bold bg-amber-50 text-amber-800 border border-amber-200 uppercase tracking-wide">
                                Voucher & Hadiah
                            </span>
                        </div>

                        <h3 class="text-lg sm:text-xl font-extrabold text-slate-900 group-hover:text-[#00529C] transition-colors mb-2 leading-tight">
                            PLN Point Reward
                        </h3>
                        <p class="text-xs sm:text-sm text-slate-600 leading-relaxed font-normal">
                            Kumpulkan poin dari setiap transaksi pembayaran listrik dan tukarkan dengan voucher diskon menarik.
                        </p>
                    </div>

                    <div class="pt-5 mt-5 border-t border-slate-100 flex items-center justify-between text-xs sm:text-sm font-bold text-[#00529C]">
                        <span>Tukar Poin</span>
                        <i class="fas fa-arrow-right group-hover:translate-x-1.5 transition-transform"></i>
                    </div>
                </a>

                {{-- 8. Pengaturan Profil --}}
                <a href="{{ route('profile.edit') }}" class="card p-6 sm:p-7 group hover:shadow-2xl transition-all duration-300 hover:-translate-y-1.5 border border-slate-200/90 bg-white rounded-3xl flex flex-col justify-between relative overflow-hidden">
                    <div>
                        <div class="flex items-center justify-between mb-5">
                            <div class="w-18 h-18 sm:w-20 sm:h-20 rounded-2xl p-2 bg-slate-100 border border-slate-200 group-hover:scale-105 transition-transform shadow-xs">
                                <img src="{{ asset('images/services/profile.svg') }}" alt="Profil Pengguna" class="w-full h-full object-contain">
                            </div>
                            <span class="relative z-10 px-3 py-1 rounded-full text-xs font-bold bg-slate-100 text-slate-700 border border-slate-200 uppercase tracking-wide">
                                Akun & ID
                            </span>
                        </div>

                        <h3 class="text-lg sm:text-xl font-extrabold text-slate-900 group-hover:text-[#00529C] transition-colors mb-2 leading-tight">
                            Profil & Keamanan
                        </h3>
                        <p class="text-xs sm:text-sm text-slate-600 leading-relaxed font-normal">
                            Kelola alamat pengiriman rekening, kata sandi akun, dan pengaturan notifikasi WhatsApp / Email.
                        </p>
                    </div>

                    <div class="pt-5 mt-5 border-t border-slate-100 flex items-center justify-between text-xs sm:text-sm font-bold text-[#00529C]">
                        <span>Pengaturan Akun</span>
                        <i class="fas fa-arrow-right group-hover:translate-x-1.5 transition-transform"></i>
                    </div>
                </a>

            </div>
        </div>

        {{-- ROW 3: Transaksi Terakhir & Promo Terpadu (12 Columns) --}}
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 lg:gap-8 items-start">
            
            {{-- Col 8: Riwayat Transaksi Terakhir --}}
            <div class="lg:col-span-8 space-y-4">
                <div class="flex items-center justify-between">
                    <div>
                        <h3 class="text-xl sm:text-2xl font-black text-slate-900 flex items-center gap-2">
                            <i class="fas fa-clock-rotate-left text-[#00529C]"></i>
                            Riwayat Transaksi Terkini
                        </h3>
                        <p class="text-xs sm:text-sm text-slate-500 mt-0.5">Catatan aktivitas transaksi pembayaran tagihan dan pembelian token Anda</p>
                    </div>
                    <a href="{{ route('dashboard.tagihan') }}" class="text-xs sm:text-sm font-bold text-[#00529C] hover:underline flex items-center gap-1.5">
                        Lihat Semua <i class="fas fa-arrow-right text-xs"></i>
                    </a>
                </div>

                @if($recentTransactions->isEmpty())
                    <div class="card p-12 text-center border border-slate-200 shadow-sm rounded-3xl bg-white">
                        <div class="w-16 h-16 bg-slate-100 text-slate-400 rounded-2xl flex items-center justify-center mx-auto mb-4 text-2xl">
                            <i class="fas fa-receipt"></i>
                        </div>
                        <h4 class="text-base font-bold text-slate-700">Belum Ada Transaksi</h4>
                        <p class="text-xs text-slate-400 mt-1 max-w-sm mx-auto">Semua transaksi pembayaran tagihan dan pembelian token listrik Anda akan tercatat secara otomatis di sini.</p>
                    </div>
                @else
                    <div class="card overflow-hidden border border-slate-200 shadow-md bg-white rounded-3xl">
                        <div class="overflow-x-auto">
                            <table class="w-full text-left">
                                <thead>
                                    <tr class="border-b border-slate-100 bg-slate-50/80 text-xs font-extrabold text-slate-600 uppercase tracking-wider">
                                        <th class="px-6 py-4">Waktu Transaksi</th>
                                        <th class="px-6 py-4">Jenis Layanan</th>
                                        <th class="px-6 py-4">Keterangan / Ref</th>
                                        <th class="px-6 py-4">Jumlah Pembayaran</th>
                                        <th class="px-6 py-4 text-center">Status</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-slate-100 text-sm">
                                    @foreach($recentTransactions as $trx)
                                    <tr class="hover:bg-slate-50/70 transition-colors">
                                        <td class="px-6 py-4 text-xs font-semibold text-slate-600">
                                            {{ $trx->created_at->translatedFormat('d M Y') }}
                                            <span class="block text-[11px] font-normal text-slate-400">{{ $trx->created_at->format('H:i') }} WIB</span>
                                        </td>
                                        <td class="px-6 py-4 font-bold text-slate-900 capitalize">
                                            @if($trx->type === 'token')
                                                <span class="inline-flex items-center gap-1.5 text-amber-700 font-bold">
                                                    <i class="fas fa-bolt text-[#FDB813]"></i> Token Stroom
                                                </span>
                                            @else
                                                <span class="inline-flex items-center gap-1.5 text-[#00529C] font-bold">
                                                    <i class="fas fa-file-invoice text-[#00529C]"></i> Tagihan Listrik
                                                </span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 text-xs text-slate-600 font-mono font-medium">
                                            {{ $trx->reference_no ?? $trx->customer?->id_pelanggan ?? $customer?->id_pelanggan ?? '-' }}
                                        </td>
                                        <td class="px-6 py-4 font-black text-slate-900 text-sm sm:text-base">
                                            Rp {{ number_format($trx->amount, 0, ',', '.') }}
                                        </td>
                                        <td class="px-6 py-4 text-center">
                                            @if($trx->status === 'success')
                                                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-emerald-100 text-emerald-800 shadow-xs">
                                                    <i class="fas fa-check-circle text-[11px]"></i> Berhasil
                                                </span>
                                            @elseif($trx->status === 'pending')
                                                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-amber-100 text-amber-800 shadow-xs">
                                                    <i class="fas fa-clock text-[11px]"></i> Menunggu
                                                </span>
                                            @else
                                                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-red-100 text-red-800 shadow-xs">
                                                    <i class="fas fa-times-circle text-[11px]"></i> Gagal
                                                </span>
                                            @endif
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                @endif
            </div>

            {{-- Col 4: Info Edukasi & Promo Smart Grid --}}
            <div class="lg:col-span-4 space-y-6">
                <div>
                    <h3 class="text-xl sm:text-2xl font-black text-slate-900 flex items-center gap-2 mb-1">
                        <i class="fas fa-bullhorn text-[#FDB813]"></i>
                        Info & Promo Terkini
                    </h3>
                    <p class="text-xs sm:text-sm text-slate-500 font-medium">Inovasi kelistrikan ramah lingkungan dan edukasi PLN</p>
                </div>

                {{-- Promo Banner Card with Clean Vector SVG Asset --}}
                <div class="card overflow-hidden border border-slate-200 shadow-lg rounded-3xl group bg-white">
                    <div class="relative h-52 overflow-hidden bg-[#001a4d]">
                        <img src="{{ asset('images/smart_meter_banner.svg') }}" alt="PLN Smart Grid AMI" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                    </div>
                    <div class="p-6 bg-white">
                        <h4 class="text-base sm:text-lg font-black text-slate-900 mb-1.5 group-hover:text-[#00529C] transition-colors leading-tight">
                            KWh Meter Pintar (Advanced Metering)
                        </h4>
                        <p class="text-xs sm:text-sm text-slate-600 leading-relaxed mb-5">
                            Tingkatkan efisiensi energi dengan pembacaan meter otomatis tanpa perlu didatangi petugas pencatat meter.
                        </p>
                        <div class="flex items-center justify-between pt-4 border-t border-slate-100 text-xs sm:text-sm">
                            <span class="text-slate-400 font-semibold">Bantuan Resmi: Call 123</span>
                            <a href="tel:123" class="font-extrabold text-[#00529C] hover:underline flex items-center gap-1.5">
                                Hubungi Kami <i class="fas fa-phone-alt text-xs"></i>
                            </a>
                        </div>
                    </div>
                </div>

                {{-- Bantuan Call Center Mini Box --}}
                <div class="p-6 rounded-3xl bg-gradient-to-br from-[#00265a] to-[#001230] text-white flex items-center justify-between gap-4 shadow-xl border border-white/10">
                    <div class="flex items-center gap-4">
                        <div class="w-14 h-14 rounded-2xl bg-[#FDB813] text-[#001230] flex items-center justify-center font-black text-2xl shadow-xs">
                            <i class="fas fa-headset"></i>
                        </div>
                        <div>
                            <p class="text-xs text-white/70 font-bold uppercase tracking-wider">Layanan Pengaduan 24 Jam</p>
                            <p class="text-xl font-black text-white">Contact Center 123</p>
                        </div>
                    </div>
                    <a href="https://wa.me/628122123123" target="_blank" class="p-3.5 rounded-2xl bg-white/10 hover:bg-white/20 text-[#FDB813] transition border border-white/15 shadow-sm active:scale-95" title="Chat WhatsApp PLN">
                        <i class="fab fa-whatsapp text-2xl"></i>
                    </a>
                </div>

            </div>

        </div>

    </div>
</section>

<script>
function copyText(text, btn) {
    navigator.clipboard.writeText(text).then(() => {
        const originalHtml = btn.innerHTML;
        btn.innerHTML = '<i class="fas fa-check text-emerald-400"></i> <span>Tersalin!</span>';
        btn.classList.add('bg-emerald-600', 'text-white');
        setTimeout(() => {
            btn.innerHTML = originalHtml;
            btn.classList.remove('bg-emerald-600', 'text-white');
        }, 2000);
    });
}
</script>
@endsection

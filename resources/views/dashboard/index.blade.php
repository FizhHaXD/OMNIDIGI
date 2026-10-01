@extends('layouts.main')
@section('title', 'Dashboard Pelanggan - PLN DIGI')

@section('content')
{{-- Header Hero --}}
<section class="relative -mt-16 md:-mt-18 bg-gradient-to-br from-[#001230] via-[#00265a] to-[#001a4d] text-white overflow-hidden pb-12 pt-32 md:pt-36">
    <div class="absolute inset-0 opacity-15 pointer-events-none">
        <div class="absolute -top-24 right-10 w-[500px] h-[500px] bg-[#FDB813] rounded-full blur-[150px]"></div>
        <div class="absolute -bottom-24 left-10 w-[400px] h-[400px] bg-[#00529C] rounded-full blur-[130px]"></div>
    </div>

    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-6 lg:gap-8">
            
            {{-- User Greeting & Status --}}
            <div class="flex items-center gap-4 sm:gap-5">
                <div class="w-16 h-16 sm:w-20 sm:h-20 rounded-2xl bg-gradient-to-br from-white/20 to-white/5 backdrop-blur-md flex items-center justify-center border border-white/20 shadow-xl flex-shrink-0 overflow-hidden">
                    @if($user->avatar_url)
                        <img src="{{ $user->avatar_url }}" alt="{{ $user->name }}" class="w-full h-full object-cover">
                    @else
                        <i class="fas fa-user-circle text-[#FDB813] text-3xl sm:text-4xl"></i>
                    @endif
                </div>
                <div>
                    <div class="flex flex-wrap items-center gap-2 mb-2">
                        <span class="px-3 py-1 rounded-full bg-emerald-500/20 text-emerald-300 border border-emerald-500/30 text-xs font-bold uppercase tracking-wider flex items-center gap-1.5 shadow-xs">
                            <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span> Sambungan Aktif
                        </span>
                        <span class="px-3 py-1 rounded-full bg-white/10 text-white/90 border border-white/10 text-xs font-semibold">
                            <i class="fas fa-calendar-day mr-1.5 text-[#FDB813]"></i> {{ now()->translatedFormat('l, d F Y') }}
                        </span>
                    </div>
                    <h1 class="text-2xl sm:text-3xl lg:text-4xl font-black tracking-tight text-white leading-tight">
                        Selamat Datang, {{ $user->name }}
                    </h1>
                    <p class="text-white/70 text-sm sm:text-base mt-1.5 font-normal leading-relaxed max-w-xl">
                        Pusat kendali layanan listrik digital, pemantauan konsumsi daya, dan transaksi terpadu PLN.
                    </p>
                </div>
            </div>

            {{-- Quick Stats Ribbon --}}
            <div class="flex flex-wrap sm:flex-nowrap items-center gap-3.5 flex-shrink-0">
                {{-- PLN Point Card --}}
                <a href="{{ route('dashboard.reward') }}" class="group bg-white/10 hover:bg-white/15 backdrop-blur-md px-5 py-3.5 rounded-2xl border border-white/15 transition-all shadow-md flex items-center gap-3.5 relative overflow-hidden flex-shrink-0">
                    <div class="absolute -top-4 -right-4 w-16 h-16 rounded-full bg-[#FDB813]/15 pointer-events-none"></div>
                    <div class="w-11 h-11 rounded-xl bg-[#FDB813] text-[#001a4d] flex items-center justify-center font-black text-lg shadow-xs group-hover:scale-105 transition-transform flex-shrink-0">
                        <i class="fas fa-gift"></i>
                    </div>
                    <div class="min-w-[95px]">
                        <p class="text-[11px] font-bold text-white/70 uppercase tracking-wider mb-0.5">PLN Point</p>
                        <p class="text-xl font-black text-[#FDB813] group-hover:text-yellow-300 transition-colors flex items-baseline gap-1">
                            <span>{{ number_format($sisaPoin ?? 0, 0, ',', '.') }}</span>
                            <span class="text-xs font-semibold text-white/80">Poin</span>
                        </p>
                    </div>
                </a>

                {{-- Status Daya Jaringan --}}
                <div class="bg-white/10 backdrop-blur-md px-5 py-3.5 rounded-2xl border border-white/15 shadow-md flex items-center gap-3.5 relative overflow-hidden flex-shrink-0">
                    <div class="absolute -top-4 -right-4 w-16 h-16 rounded-full bg-cyan-400/15 pointer-events-none"></div>
                    <div class="w-11 h-11 rounded-xl bg-cyan-500/20 text-cyan-300 flex items-center justify-center shadow-xs flex-shrink-0">
                        <svg class="w-6 h-6 text-cyan-300" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M13 2L3 14h9l-1 8 10-12h-9l1-8z"/>
                        </svg>
                    </div>
                    <div class="min-w-[145px]">
                        <p class="text-[11px] font-bold text-white/70 uppercase tracking-wider mb-0.5">Tegangan Listrik</p>
                        <div class="flex items-center gap-2">
                            <span class="text-xl font-black text-white tracking-tight">220V</span>
                            <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-emerald-400/20 text-emerald-300 border border-emerald-400/30 whitespace-nowrap shadow-xs">
                                <span class="w-1.5 h-1.5 rounded-full bg-emerald-400 animate-pulse"></span> Normal (50Hz)
                            </span>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>

{{-- Main Content Section (Standard Max-w-7xl with Balanced Margins) --}}
<section class="py-8 md:py-12 bg-slate-50/70 min-h-screen">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8 md:space-y-10">

        {{-- ROW 1: Master Customer Card & Billing Summary (12 Columns) --}}
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-stretch">
            
            {{-- Left Col (7 / 12): Data Pelanggan & Token Terakhir --}}
            <div class="lg:col-span-7 flex flex-col gap-5">
                
                @if($customer)
                {{-- Master Customer ID Card with Aesthetic Circular Accents --}}
                <div class="bg-gradient-to-br from-[#003d75] via-[#00529C] to-[#00265a] rounded-3xl p-6 sm:p-7 text-white shadow-xl relative overflow-hidden border border-white/15">
                    {{-- Aesthetic Circles --}}
                    <div class="absolute -top-12 -right-12 w-56 h-56 bg-white/10 rounded-full pointer-events-none"></div>
                    <div class="absolute -bottom-10 right-20 w-44 h-44 bg-[#FDB813]/20 rounded-full blur-2xl pointer-events-none"></div>
                    <div class="absolute top-1/2 left-1/3 w-32 h-32 bg-cyan-400/10 rounded-full blur-xl pointer-events-none"></div>

                    {{-- Top Card Details --}}
                    <div class="relative z-10">
                        <div class="flex flex-wrap items-center justify-between gap-3 mb-3">
                            <div class="flex items-center gap-2">
                                <span class="w-7 h-7 rounded-lg bg-white/15 flex items-center justify-center text-[#FDB813] font-bold shadow-xs">
                                    <i class="fas fa-id-card text-xs"></i>
                                </span>
                                <span class="text-xs uppercase font-extrabold tracking-widest text-white/80">ID Pelanggan Terdaftar</span>
                            </div>
                            <span class="px-3 py-1 rounded-full bg-emerald-400/20 text-emerald-300 border border-emerald-400/30 text-xs font-bold shadow-xs flex items-center gap-1.5">
                                <i class="fas fa-check-circle text-xs"></i> Terhubung & Terverifikasi
                            </span>
                        </div>

                        {{-- ID Pelanggan Digits --}}
                        <div class="flex flex-wrap items-center gap-3 mb-5">
                            <span class="text-3xl sm:text-4xl font-black font-mono tracking-wider text-[#FDB813] drop-shadow-sm select-all">
                                {{ $customer->id_pelanggan }}
                            </span>
                            <button type="button" onclick="copyText('{{ $customer->id_pelanggan }}', this)" 
                                    class="py-1.5 px-3 rounded-xl bg-white/10 hover:bg-white/20 text-white text-xs font-bold flex items-center gap-1.5 transition border border-white/15 shadow-sm active:scale-95"
                                    title="Salin ID Pelanggan">
                                <i class="far fa-copy text-xs"></i>
                                <span>Salin</span>
                            </button>
                        </div>
                    </div>

                    {{-- Bottom Specs Pill Grid --}}
                    <div class="pt-5 border-t border-white/15 grid grid-cols-1 sm:grid-cols-3 gap-3 text-sm relative z-10">
                        <div class="bg-white/10 backdrop-blur-sm rounded-2xl p-3 border border-white/10">
                            <p class="text-white/60 text-[11px] font-semibold uppercase tracking-wider mb-0.5">Daya & Golongan</p>
                            <p class="text-sm font-extrabold text-white flex items-center gap-1.5">
                                <i class="fas fa-plug text-[#FDB813]"></i>
                                {{ number_format($customer->tariff->daya_va ?? $customer->daya ?? 1300, 0, ',', '.') }} VA 
                                <span class="text-xs font-normal text-white/70">({{ $customer->tariff->kode ?? $customer->tariff->kode_tarif ?? 'R1' }})</span>
                            </p>
                        </div>

                        <div class="bg-white/10 backdrop-blur-sm rounded-2xl p-3 border border-white/10">
                            <p class="text-white/60 text-[11px] font-semibold uppercase tracking-wider mb-0.5">Nama Pemilik</p>
                            <p class="text-sm font-extrabold text-white break-words" title="{{ $customer->nama }}">
                                <i class="fas fa-user-check text-cyan-300 mr-1"></i>{{ $customer->nama }}
                            </p>
                        </div>

                        <div class="bg-white/10 backdrop-blur-sm rounded-2xl p-3 border border-white/10">
                            <p class="text-white/60 text-[11px] font-semibold uppercase tracking-wider mb-0.5">Lokasi Alamat</p>
                            <p class="text-xs font-semibold text-white/90 break-words leading-relaxed" title="{{ $customer->alamat }}">
                                <i class="fas fa-map-marker-alt text-amber-300 mr-1"></i>{{ $customer->alamat }}
                            </p>
                        </div>
                    </div>

                </div>
                @else
                <div class="card p-8 text-center h-full flex flex-col items-center justify-center border border-slate-200 shadow-md rounded-3xl">
                    <div class="w-14 h-14 rounded-2xl bg-amber-50 text-amber-500 flex items-center justify-center text-2xl mb-3 shadow-sm">
                        <i class="fas fa-exclamation-triangle"></i>
                    </div>
                    <h3 class="text-base font-bold text-slate-900 mb-1">Belum Terhubung dengan Data Pelanggan</h3>
                    <p class="text-xs text-slate-500 max-w-md mb-4">Tambahkan ID Pelanggan listrik PLN Anda untuk mengaktifkan pemantauan real-time dan pembayaran instan.</p>
                    <a href="{{ route('profile.edit') }}" class="btn-primary text-xs py-2 px-4">
                        <i class="fas fa-plus mr-1.5"></i> Hubungkan ID Pelanggan
                    </a>
                </div>
                @endif

                {{-- Card Token Terakhir (Jika Prabayar) with Aesthetic Circle --}}
                @if($lastToken && $lastToken->token_listrik)
                <div class="card p-5 sm:p-6 border-l-4 border-l-[#FDB813] bg-gradient-to-r from-amber-50/80 via-white to-amber-50/40 shadow-md rounded-3xl border border-slate-200/90 relative overflow-hidden">
                    {{-- Aesthetic Circle Accent --}}
                    <div class="absolute -top-8 -right-8 w-32 h-32 rounded-full bg-amber-100/60 pointer-events-none"></div>

                    <div class="relative z-10 space-y-3.5">
                        {{-- Top Metadata Row --}}
                        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-2.5">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-full bg-amber-500/15 flex items-center justify-center text-amber-700 flex-shrink-0 border border-amber-200 shadow-xs">
                                    <svg class="w-5 h-5 text-[#FDB813]" viewBox="0 0 24 24" fill="currentColor">
                                        <path d="M13 2L3 14h9l-1 8 10-12h-9l1-8z"/>
                                    </svg>
                                </div>
                                <div class="flex flex-wrap items-center gap-2">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold bg-[#FDB813]/25 text-[#9E6E00] uppercase tracking-wider">
                                        <i class="fas fa-receipt mr-1.5 text-xs"></i> 20 Digit Stroom Terakhir
                                    </span>
                                    <span class="text-xs text-slate-400 font-medium">
                                        {{ $lastToken->created_at->translatedFormat('d M Y, H:i') }} WIB
                                    </span>
                                </div>
                            </div>

                            {{-- No. Meter & Nominal Badges --}}
                            <div class="flex flex-wrap items-center gap-2 text-xs">
                                <span class="px-2.5 py-1 rounded-xl bg-slate-100 text-slate-700 font-medium border border-slate-200/60">
                                    No. Meter: <strong class="font-mono text-slate-900 font-bold">{{ $lastToken->no_meter }}</strong>
                                </span>
                                <span class="px-2.5 py-1 rounded-xl bg-emerald-50 text-emerald-800 font-extrabold border border-emerald-200">
                                    Rp {{ number_format($lastToken->amount, 0, ',', '.') }}
                                </span>
                            </div>
                        </div>

                        {{-- Prominent 20-Digit Code Box & Copy Button --}}
                        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 bg-white p-3.5 sm:p-4 rounded-2xl border border-amber-200/80 shadow-xs">
                            <div class="min-w-0">
                                <p class="text-[10px] text-slate-400 uppercase font-bold tracking-wider mb-0.5">Nomor Kode Stroom</p>
                                <p class="text-lg sm:text-2xl font-black font-mono tracking-widest text-[#00529C] select-all whitespace-nowrap overflow-x-auto py-0.5">
                                    {{ $lastToken->token_listrik }}
                                </p>
                            </div>
                            <button type="button" onclick="copyText('{{ $lastToken->token_listrik }}', this)"
                                    class="px-4 py-2.5 bg-[#00529C] hover:bg-[#003d75] text-white rounded-xl text-xs font-bold flex items-center justify-center gap-2 shadow transition-all whitespace-nowrap active:scale-95 flex-shrink-0" 
                                    title="Salin Kode Token">
                                <i class="far fa-copy text-xs"></i>
                                <span>Salin Kode</span>
                            </button>
                        </div>
                    </div>
                </div>
                @endif

            </div>

            {{-- Right Col (5 / 12): Ringkasan Tagihan & Finansial with Aesthetic Circle --}}
            <div class="lg:col-span-5 flex flex-col">
                
                {{-- Billing Summary Card --}}
                <div class="card p-6 sm:p-7 bg-white border border-slate-200/90 shadow-lg rounded-3xl flex flex-col justify-between h-full relative overflow-hidden">
                    {{-- Aesthetic Circle Accent --}}
                    <div class="absolute -top-10 -right-10 w-36 h-36 rounded-full bg-blue-50/80 pointer-events-none"></div>

                    <div class="relative z-10">
                        <div class="flex items-center justify-between pb-3.5 mb-4 border-b border-slate-100">
                            <div>
                                <h3 class="text-base font-black text-slate-900 flex items-center gap-2">
                                    <i class="fas fa-file-invoice-dollar text-[#00529C]"></i>
                                    Status Tagihan Listrik
                                </h3>
                                <p class="text-xs text-slate-500 mt-0.5">Informasi kewajiban pembayaran bulan berjalan</p>
                            </div>
                            @if($tagihanBelumBayar > 0)
                                <span class="px-3 py-1 rounded-full bg-red-100 text-red-700 text-xs font-bold flex items-center gap-1.5 shadow-xs">
                                    <i class="fas fa-exclamation-circle text-xs"></i> {{ $tagihanBelumBayar }} Belum Lunas
                                </span>
                            @else
                                <span class="px-3 py-1 rounded-full bg-emerald-100 text-emerald-700 text-xs font-bold flex items-center gap-1.5 shadow-xs">
                                    <i class="fas fa-check-circle text-xs"></i> Lunas
                                </span>
                            @endif
                        </div>

                        {{-- Total Amount Display --}}
                        <div class="p-5 rounded-2xl bg-gradient-to-br from-slate-50 to-blue-50/50 border border-slate-200/80 mb-5">
                            <p class="text-xs font-bold text-slate-500 uppercase tracking-wider mb-1">Total Kewajiban Pembayaran</p>
                            <div class="flex items-baseline gap-2">
                                <span class="text-3xl sm:text-4xl font-black text-slate-900 tracking-tight">
                                    Rp {{ number_format($totalTagihan, 0, ',', '.') }}
                                </span>
                            </div>
                            @if($activeBill)
                                <div class="mt-3 pt-2.5 border-t border-slate-200/60 flex justify-between items-center text-xs">
                                    <span class="text-slate-500 font-medium">Jatuh Tempo:</span>
                                    <span class="font-bold {{ \Carbon\Carbon::parse($activeBill->tanggal_jatuh_tempo)->isPast() ? 'text-red-600' : 'text-slate-700' }}">
                                        {{ \Carbon\Carbon::parse($activeBill->tanggal_jatuh_tempo)->translatedFormat('d F Y') }}
                                        @if(\Carbon\Carbon::parse($activeBill->tanggal_jatuh_tempo)->isPast())
                                             (Lewat Tempo)
                                        @endif
                                    </span>
                                </div>
                            @else
                                <p class="text-xs text-emerald-600 font-bold mt-2 flex items-center gap-1.5">
                                    <i class="fas fa-check-double text-sm"></i> Seluruh tagihan Anda telah lunas. Terima kasih!
                                </p>
                            @endif
                        </div>
                    </div>

                    {{-- Billing Action Buttons & Trust Micro Note --}}
                    <div class="space-y-3 pt-1 relative z-10">
                        @if($totalTagihan > 0)
                            <a href="{{ route('dashboard.tagihan') }}" class="w-full py-3.5 px-5 rounded-2xl bg-[#00529C] hover:bg-[#003d75] text-white font-extrabold text-sm flex items-center justify-center gap-2 shadow-lg shadow-blue-900/25 transition-all hover:scale-[1.01] active:scale-[0.99]">
                                <i class="fas fa-credit-card text-[#FDB813]"></i>
                                <span>Bayar Tagihan Sekarang</span>
                            </a>
                        @else
                            <a href="{{ route('dashboard.tagihan') }}" class="w-full py-3 px-5 rounded-2xl bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold text-sm flex items-center justify-center gap-2 transition">
                                <i class="fas fa-receipt text-[#00529C]"></i>
                                <span>Lihat Lembar Tagihan</span>
                            </a>
                        @endif

                        <div class="grid grid-cols-2 gap-2.5">
                            <a href="{{ route('dashboard.token') }}" class="py-2.5 px-3 rounded-2xl bg-amber-50 hover:bg-amber-100 border border-amber-200 text-amber-800 text-xs font-bold flex items-center justify-center gap-1.5 transition text-center shadow-xs">
                                <i class="fas fa-bolt text-[#FDB813]"></i> Beli Token
                            </a>
                            <a href="{{ route('dashboard.metering') }}" class="py-2.5 px-3 rounded-2xl bg-emerald-50 hover:bg-emerald-100 border border-emerald-200 text-emerald-800 text-xs font-bold flex items-center justify-center gap-1.5 transition text-center shadow-xs">
                                <i class="fas fa-camera text-emerald-600"></i> Catat Meter
                            </a>
                        </div>

                        {{-- Trust Micro Note --}}
                        <div class="pt-3 border-t border-slate-100 flex items-center justify-between text-[11px] text-slate-400 font-medium">
                            <span class="flex items-center gap-1">
                                <i class="fas fa-shield-alt text-[#00529C]"></i> Transaksi Resmi PLN
                            </span>
                            <span class="flex items-center gap-1">
                                <i class="fas fa-bolt text-[#FDB813]"></i> Verifikasi Instan
                            </span>
                        </div>
                    </div>

                </div>

            </div>

        </div>

        {{-- ROW 2: Layanan Utama PLN DIGI (Menu Grid dengan Lingkaran Estetika & Gambar 3D) --}}
        <div>
            <div class="flex flex-col sm:flex-row sm:items-end justify-between gap-3 mb-6">
                <div>
                    <span class="text-xs font-black uppercase tracking-wider text-[#00529C] flex items-center gap-2 mb-1">
                        <i class="fas fa-th-large text-xs"></i> Ekosistem Layanan Terpadu
                    </span>
                    <h2 class="text-2xl sm:text-3xl font-black text-slate-900 tracking-tight">
                        Layanan Mandiri PLN DIGI
                    </h2>
                    <p class="text-slate-500 text-xs sm:text-sm mt-0.5 font-medium">
                        Akses instan seluruh kebutuhan kelistrikan, pembayaran, pemantauan energi, dan pelaporan kendala.
                    </p>
                </div>
            </div>

            {{-- 8 Service Cards Grid (4 Columns on Desktop, 2 on Tablet, 1 on Mobile) --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-5">
                
                {{-- 1. Bayar Tagihan (Blue Aesthetics Circle) --}}
                <a href="{{ route('dashboard.tagihan') }}" class="card p-5 sm:p-6 group hover:shadow-2xl transition-all duration-300 hover:-translate-y-1.5 border border-slate-200/90 bg-white rounded-3xl flex flex-col justify-between relative overflow-hidden">
                    {{-- Aesthetic Circles --}}
                    <div class="absolute -top-7 -right-7 w-32 h-32 rounded-full bg-blue-100/70 pointer-events-none group-hover:scale-125 transition-transform duration-500"></div>
                    <div class="absolute -bottom-8 -left-8 w-24 h-24 rounded-full bg-blue-50/80 pointer-events-none"></div>

                    <div class="relative z-10">
                        <div class="flex items-center justify-between mb-4">
                            <div class="w-16 h-16 sm:w-18 sm:h-18 rounded-full p-2.5 bg-gradient-to-br from-blue-100 via-blue-50 to-white border border-blue-200/80 group-hover:scale-110 transition-transform shadow-xs flex items-center justify-center">
                                <img src="{{ asset('images/services/tagihan.svg') }}" alt="Bayar Tagihan" class="w-full h-full object-contain">
                            </div>
                            <span class="relative z-10 px-2.5 py-0.5 rounded-full text-[11px] font-bold bg-blue-50 text-[#00529C] border border-blue-200 uppercase tracking-wide">
                                Tagihan
                            </span>
                        </div>

                        <h3 class="text-base sm:text-lg font-extrabold text-slate-900 group-hover:text-[#00529C] transition-colors mb-1.5 leading-tight">
                            Bayar Tagihan
                        </h3>
                        <p class="text-xs text-slate-600 leading-relaxed font-normal">
                            Cek lembar rekening bulanan, rincian biaya pemakaian, dan bayar instan via VA atau QRIS.
                        </p>
                    </div>

                    <div class="pt-4 mt-4 border-t border-slate-100 flex items-center justify-between text-xs font-bold text-[#00529C] relative z-10">
                        <span>Buka Tagihan</span>
                        <i class="fas fa-arrow-right group-hover:translate-x-1.5 transition-transform"></i>
                    </div>
                </a>

                {{-- 2. Beli Token Listrik (Amber Aesthetics Circle) --}}
                <a href="{{ route('dashboard.token') }}" class="card p-5 sm:p-6 group hover:shadow-2xl transition-all duration-300 hover:-translate-y-1.5 border border-slate-200/90 bg-white rounded-3xl flex flex-col justify-between relative overflow-hidden">
                    {{-- Aesthetic Circles --}}
                    <div class="absolute -top-7 -right-7 w-32 h-32 rounded-full bg-amber-100/70 pointer-events-none group-hover:scale-125 transition-transform duration-500"></div>
                    <div class="absolute -bottom-8 -left-8 w-24 h-24 rounded-full bg-amber-50/80 pointer-events-none"></div>

                    <div class="relative z-10">
                        <div class="flex items-center justify-between mb-4">
                            <div class="w-16 h-16 sm:w-18 sm:h-18 rounded-full p-2.5 bg-gradient-to-br from-amber-100 via-amber-50 to-white border border-amber-200/80 group-hover:scale-110 transition-transform shadow-xs flex items-center justify-center">
                                <img src="{{ asset('images/services/token.svg') }}" alt="Beli Token Listrik" class="w-full h-full object-contain">
                            </div>
                            <span class="relative z-10 px-2.5 py-0.5 rounded-full text-[11px] font-bold bg-amber-50 text-amber-800 border border-amber-200 uppercase tracking-wide">
                                24/7 Stroom
                            </span>
                        </div>

                        <h3 class="text-base sm:text-lg font-extrabold text-slate-900 group-hover:text-[#00529C] transition-colors mb-1.5 leading-tight">
                            Beli Token Listrik
                        </h3>
                        <p class="text-xs text-slate-600 leading-relaxed font-normal">
                            Beli nomor stroom prabayar mulai Rp 20.000 dengan kode token 20 digit terbit seketika.
                        </p>
                    </div>

                    <div class="pt-4 mt-4 border-t border-slate-100 flex items-center justify-between text-xs font-bold text-[#00529C] relative z-10">
                        <span>Beli Token</span>
                        <i class="fas fa-arrow-right group-hover:translate-x-1.5 transition-transform"></i>
                    </div>
                </a>

                {{-- 3. Catat Meter Mandiri (Emerald Aesthetics Circle) --}}
                <a href="{{ route('dashboard.metering') }}" class="card p-5 sm:p-6 group hover:shadow-2xl transition-all duration-300 hover:-translate-y-1.5 border border-slate-200/90 bg-white rounded-3xl flex flex-col justify-between relative overflow-hidden">
                    {{-- Aesthetic Circles --}}
                    <div class="absolute -top-7 -right-7 w-32 h-32 rounded-full bg-emerald-100/70 pointer-events-none group-hover:scale-125 transition-transform duration-500"></div>
                    <div class="absolute -bottom-8 -left-8 w-24 h-24 rounded-full bg-emerald-50/80 pointer-events-none"></div>

                    <div class="relative z-10">
                        <div class="flex items-center justify-between mb-4">
                            <div class="w-16 h-16 sm:w-18 sm:h-18 rounded-full p-2.5 bg-gradient-to-br from-emerald-100 via-emerald-50 to-white border border-emerald-200/80 group-hover:scale-110 transition-transform shadow-xs flex items-center justify-center">
                                <img src="{{ asset('images/services/swacam.svg') }}" alt="Catat Meter SwaCAM" class="w-full h-full object-contain">
                            </div>
                            <span class="relative z-10 px-2.5 py-0.5 rounded-full text-[11px] font-bold bg-emerald-50 text-emerald-800 border border-emerald-200 uppercase tracking-wide">
                                Tgl 24-27
                            </span>
                        </div>

                        <h3 class="text-base sm:text-lg font-extrabold text-slate-900 group-hover:text-[#00529C] transition-colors mb-1.5 leading-tight">
                            Catat Meter Mandiri
                        </h3>
                        <p class="text-xs text-slate-600 leading-relaxed font-normal">
                            Foto angka stand meter Anda setiap akhir bulan untuk penetapan tagihan yang akurat & transparan.
                        </p>
                    </div>

                    <div class="pt-4 mt-4 border-t border-slate-100 flex items-center justify-between text-xs font-bold text-[#00529C] relative z-10">
                        <span>Baca Meter</span>
                        <i class="fas fa-arrow-right group-hover:translate-x-1.5 transition-transform"></i>
                    </div>
                </a>

                {{-- 4. Monitoring Pemakaian (Indigo Aesthetics Circle) --}}
                <a href="{{ route('dashboard.monitoring') }}" class="card p-5 sm:p-6 group hover:shadow-2xl transition-all duration-300 hover:-translate-y-1.5 border border-slate-200/90 bg-white rounded-3xl flex flex-col justify-between relative overflow-hidden">
                    {{-- Aesthetic Circles --}}
                    <div class="absolute -top-7 -right-7 w-32 h-32 rounded-full bg-indigo-100/70 pointer-events-none group-hover:scale-125 transition-transform duration-500"></div>
                    <div class="absolute -bottom-8 -left-8 w-24 h-24 rounded-full bg-indigo-50/80 pointer-events-none"></div>

                    <div class="relative z-10">
                        <div class="flex items-center justify-between mb-4">
                            <div class="w-16 h-16 sm:w-18 sm:h-18 rounded-full p-2.5 bg-gradient-to-br from-indigo-100 via-indigo-50 to-white border border-indigo-200/80 group-hover:scale-110 transition-transform shadow-xs flex items-center justify-center">
                                <img src="{{ asset('images/services/monitoring.svg') }}" alt="Monitoring Pemakaian" class="w-full h-full object-contain">
                            </div>
                            <span class="relative z-10 px-2.5 py-0.5 rounded-full text-[11px] font-bold bg-indigo-50 text-indigo-800 border border-indigo-200 uppercase tracking-wide">
                                Analitik
                            </span>
                        </div>

                        <h3 class="text-base sm:text-lg font-extrabold text-slate-900 group-hover:text-[#00529C] transition-colors mb-1.5 leading-tight">
                            Monitoring Energi
                        </h3>
                        <p class="text-xs text-slate-600 leading-relaxed font-normal">
                            Pantau grafik tren konsumsi listrik bulanan dan histori pengeluaran biaya daya Anda.
                        </p>
                    </div>

                    <div class="pt-4 mt-4 border-t border-slate-100 flex items-center justify-between text-xs font-bold text-[#00529C] relative z-10">
                        <span>Lihat Grafik</span>
                        <i class="fas fa-arrow-right group-hover:translate-x-1.5 transition-transform"></i>
                    </div>
                </a>

                {{-- 5. Simulasi Biaya & Pasang Baru (Cyan Aesthetics Circle) --}}
                <a href="{{ route('dashboard.simulasi') }}" class="card p-5 sm:p-6 group hover:shadow-2xl transition-all duration-300 hover:-translate-y-1.5 border border-slate-200/90 bg-white rounded-3xl flex flex-col justify-between relative overflow-hidden">
                    {{-- Aesthetic Circles --}}
                    <div class="absolute -top-7 -right-7 w-32 h-32 rounded-full bg-cyan-100/70 pointer-events-none group-hover:scale-125 transition-transform duration-500"></div>
                    <div class="absolute -bottom-8 -left-8 w-24 h-24 rounded-full bg-cyan-50/80 pointer-events-none"></div>

                    <div class="relative z-10">
                        <div class="flex items-center justify-between mb-4">
                            <div class="w-16 h-16 sm:w-18 sm:h-18 rounded-full p-2.5 bg-gradient-to-br from-cyan-100 via-cyan-50 to-white border border-cyan-200/80 group-hover:scale-110 transition-transform shadow-xs flex items-center justify-center">
                                <img src="{{ asset('images/services/simulasi.svg') }}" alt="Simulasi Biaya" class="w-full h-full object-contain">
                            </div>
                            <span class="relative z-10 px-2.5 py-0.5 rounded-full text-[11px] font-bold bg-cyan-50 text-cyan-800 border border-cyan-200 uppercase tracking-wide">
                                Kalkulator
                            </span>
                        </div>

                        <h3 class="text-base sm:text-lg font-extrabold text-slate-900 group-hover:text-[#00529C] transition-colors mb-1.5 leading-tight">
                            Simulasi Biaya Listrik
                        </h3>
                        <p class="text-xs text-slate-600 leading-relaxed font-normal">
                            Hitung estimasi rekening listrik bulanan berdasarkan perabot rumah tangga atau simulasi pasang baru.
                        </p>
                    </div>

                    <div class="pt-4 mt-4 border-t border-slate-100 flex items-center justify-between text-xs font-bold text-[#00529C] relative z-10">
                        <span>Hitung Simulasi</span>
                        <i class="fas fa-arrow-right group-hover:translate-x-1.5 transition-transform"></i>
                    </div>
                </a>

                {{-- 6. Lapor Gangguan Listrik (Red/Rose Aesthetics Circle) --}}
                <a href="{{ route('dashboard.outage') }}" class="card p-5 sm:p-6 group hover:shadow-2xl transition-all duration-300 hover:-translate-y-1.5 border border-slate-200/90 bg-white rounded-3xl flex flex-col justify-between relative overflow-hidden">
                    {{-- Aesthetic Circles --}}
                    <div class="absolute -top-7 -right-7 w-32 h-32 rounded-full bg-rose-100/70 pointer-events-none group-hover:scale-125 transition-transform duration-500"></div>
                    <div class="absolute -bottom-8 -left-8 w-24 h-24 rounded-full bg-rose-50/80 pointer-events-none"></div>

                    <div class="relative z-10">
                        <div class="flex items-center justify-between mb-4">
                            <div class="w-16 h-16 sm:w-18 sm:h-18 rounded-full p-2.5 bg-gradient-to-br from-rose-100 via-rose-50 to-white border border-rose-200/80 group-hover:scale-110 transition-transform shadow-xs flex items-center justify-center">
                                <img src="{{ asset('images/services/outage.svg') }}" alt="Lapor Gangguan Listrik" class="w-full h-full object-contain">
                            </div>
                            <span class="relative z-10 px-2.5 py-0.5 rounded-full text-[11px] font-bold bg-red-50 text-red-700 border border-red-200 uppercase tracking-wide">
                                Siaga 24 Jam
                            </span>
                        </div>

                        <h3 class="text-base sm:text-lg font-extrabold text-slate-900 group-hover:text-red-600 transition-colors mb-1.5 leading-tight">
                            Lapor Gangguan Listrik
                        </h3>
                        <p class="text-xs text-slate-600 leading-relaxed font-normal">
                            Laporkan listrik padam, korsleting, atau kerusakan kWh meter untuk respon dispatching tim YANTEK.
                        </p>
                    </div>

                    <div class="pt-4 mt-4 border-t border-slate-100 flex items-center justify-between text-xs font-bold text-red-600 relative z-10">
                        <span>Lapor Sekarang</span>
                        <i class="fas fa-arrow-right group-hover:translate-x-1.5 transition-transform"></i>
                    </div>
                </a>

                {{-- 7. PLN Reward & Point (Gold/Amber Aesthetics Circle) --}}
                <a href="{{ route('dashboard.reward') }}" class="card p-5 sm:p-6 group hover:shadow-2xl transition-all duration-300 hover:-translate-y-1.5 border border-slate-200/90 bg-white rounded-3xl flex flex-col justify-between relative overflow-hidden">
                    {{-- Aesthetic Circles --}}
                    <div class="absolute -top-7 -right-7 w-32 h-32 rounded-full bg-amber-100/70 pointer-events-none group-hover:scale-125 transition-transform duration-500"></div>
                    <div class="absolute -bottom-8 -left-8 w-24 h-24 rounded-full bg-amber-50/80 pointer-events-none"></div>

                    <div class="relative z-10">
                        <div class="flex items-center justify-between mb-4">
                            <div class="w-16 h-16 sm:w-18 sm:h-18 rounded-full p-2.5 bg-gradient-to-br from-amber-100 via-amber-50 to-white border border-amber-200/80 group-hover:scale-110 transition-transform shadow-xs flex items-center justify-center">
                                <img src="{{ asset('images/services/reward.svg') }}" alt="PLN Reward" class="w-full h-full object-contain">
                            </div>
                            <span class="relative z-10 px-2.5 py-0.5 rounded-full text-[11px] font-bold bg-amber-50 text-amber-800 border border-amber-200 uppercase tracking-wide">
                                Voucher & Hadiah
                            </span>
                        </div>

                        <h3 class="text-base sm:text-lg font-extrabold text-slate-900 group-hover:text-[#00529C] transition-colors mb-1.5 leading-tight">
                            PLN Point Reward
                        </h3>
                        <p class="text-xs text-slate-600 leading-relaxed font-normal">
                            Kumpulkan poin dari setiap transaksi pembayaran listrik dan tukarkan dengan voucher diskon menarik.
                        </p>
                    </div>

                    <div class="pt-4 mt-4 border-t border-slate-100 flex items-center justify-between text-xs font-bold text-[#00529C] relative z-10">
                        <span>Tukar Poin</span>
                        <i class="fas fa-arrow-right group-hover:translate-x-1.5 transition-transform"></i>
                    </div>
                </a>

                {{-- 8. Pengaturan Profil (Slate/Violet Aesthetics Circle) --}}
                <a href="{{ route('profile.edit') }}" class="card p-5 sm:p-6 group hover:shadow-2xl transition-all duration-300 hover:-translate-y-1.5 border border-slate-200/90 bg-white rounded-3xl flex flex-col justify-between relative overflow-hidden">
                    {{-- Aesthetic Circles --}}
                    <div class="absolute -top-7 -right-7 w-32 h-32 rounded-full bg-slate-200/60 pointer-events-none group-hover:scale-125 transition-transform duration-500"></div>
                    <div class="absolute -bottom-8 -left-8 w-24 h-24 rounded-full bg-slate-100/80 pointer-events-none"></div>

                    <div class="relative z-10">
                        <div class="flex items-center justify-between mb-4">
                            <div class="w-16 h-16 sm:w-18 sm:h-18 rounded-full p-2.5 bg-gradient-to-br from-slate-200 via-slate-100 to-white border border-slate-300/80 group-hover:scale-110 transition-transform shadow-xs flex items-center justify-center">
                                <img src="{{ asset('images/services/profile.svg') }}" alt="Profil Pengguna" class="w-full h-full object-contain">
                            </div>
                            <span class="relative z-10 px-2.5 py-0.5 rounded-full text-[11px] font-bold bg-slate-100 text-slate-700 border border-slate-200 uppercase tracking-wide">
                                Akun & ID
                            </span>
                        </div>

                        <h3 class="text-base sm:text-lg font-extrabold text-slate-900 group-hover:text-[#00529C] transition-colors mb-1.5 leading-tight">
                            Profil & Keamanan
                        </h3>
                        <p class="text-xs text-slate-600 leading-relaxed font-normal">
                            Kelola alamat pengiriman rekening, kata sandi akun, dan pengaturan notifikasi WhatsApp / Email.
                        </p>
                    </div>

                    <div class="pt-4 mt-4 border-t border-slate-100 flex items-center justify-between text-xs font-bold text-[#00529C] relative z-10">
                        <span>Pengaturan Akun</span>
                        <i class="fas fa-arrow-right group-hover:translate-x-1.5 transition-transform"></i>
                    </div>
                </a>

            </div>
        </div>

        {{-- ROW 3: Transaksi Terakhir & Promo Terpadu (12 Columns) --}}
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-start">
            
            {{-- Col 8: Riwayat Transaksi Terakhir --}}
            <div class="lg:col-span-8 space-y-4">
                <div class="flex items-center justify-between">
                    <div>
                        <h3 class="text-xl font-black text-slate-900 flex items-center gap-2">
                            <i class="fas fa-clock-rotate-left text-[#00529C]"></i>
                            Riwayat Transaksi Terkini
                        </h3>
                        <p class="text-xs text-slate-500 mt-0.5">Catatan aktivitas transaksi pembayaran tagihan dan pembelian token Anda</p>
                    </div>
                    <a href="{{ route('dashboard.tagihan') }}" class="text-xs font-bold text-[#00529C] hover:underline flex items-center gap-1.5">
                        Lihat Semua <i class="fas fa-arrow-right text-[10px]"></i>
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
                    <div class="card overflow-hidden border border-slate-200 shadow-md bg-white rounded-3xl relative">
                        {{-- Aesthetic Circle Accent --}}
                        <div class="absolute -top-12 -right-12 w-48 h-48 rounded-full bg-blue-50/70 pointer-events-none"></div>

                        <div class="overflow-x-auto relative z-10">
                            <table class="w-full text-left">
                                <thead>
                                    <tr class="border-b border-slate-100 bg-slate-50/80 text-xs font-extrabold text-slate-600 uppercase tracking-wider">
                                        <th class="px-5 py-3.5">Waktu Transaksi</th>
                                        <th class="px-5 py-3.5">Jenis Layanan</th>
                                        <th class="px-5 py-3.5">Keterangan / Ref</th>
                                        <th class="px-5 py-3.5">Jumlah Pembayaran</th>
                                        <th class="px-5 py-3.5 text-center">Status</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-slate-100 text-sm">
                                    @foreach($recentTransactions as $trx)
                                    <tr class="hover:bg-slate-50/70 transition-colors">
                                        <td class="px-5 py-3.5 text-xs font-semibold text-slate-600">
                                            {{ $trx->created_at->translatedFormat('d M Y') }}
                                            <span class="block text-[11px] font-normal text-slate-400">{{ $trx->created_at->format('H:i') }} WIB</span>
                                        </td>
                                        <td class="px-5 py-3.5 font-bold text-slate-900 capitalize">
                                            @if($trx->type === 'token')
                                                <span class="inline-flex items-center gap-1.5 text-amber-700 font-bold text-xs sm:text-sm">
                                                    <i class="fas fa-bolt text-[#FDB813]"></i> Token Stroom
                                                </span>
                                            @else
                                                <span class="inline-flex items-center gap-1.5 text-[#00529C] font-bold text-xs sm:text-sm">
                                                    <i class="fas fa-file-invoice text-[#00529C]"></i> Tagihan Listrik
                                                </span>
                                            @endif
                                        </td>
                                        <td class="px-5 py-3.5 text-xs text-slate-600 font-mono font-medium">
                                            {{ $trx->reference_no ?? $trx->customer?->id_pelanggan ?? $customer?->id_pelanggan ?? '-' }}
                                        </td>
                                        <td class="px-5 py-3.5 font-black text-slate-900 text-sm">
                                            Rp {{ number_format($trx->amount, 0, ',', '.') }}
                                        </td>
                                        <td class="px-5 py-3.5 text-center">
                                            @if($trx->status === 'success')
                                                <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-xs font-bold bg-emerald-100 text-emerald-800 shadow-xs">
                                                    <i class="fas fa-check-circle text-[10px]"></i> Berhasil
                                                </span>
                                            @elseif($trx->status === 'pending')
                                                <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-xs font-bold bg-amber-100 text-amber-800 shadow-xs">
                                                    <i class="fas fa-clock text-[10px]"></i> Menunggu
                                                </span>
                                            @else
                                                <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-xs font-bold bg-red-100 text-red-800 shadow-xs">
                                                    <i class="fas fa-times-circle text-[10px]"></i> Gagal
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
            <div class="lg:col-span-4 space-y-5">
                <div>
                    <h3 class="text-xl font-black text-slate-900 flex items-center gap-2 mb-0.5">
                        <i class="fas fa-bullhorn text-[#FDB813]"></i>
                        Info & Promo Terkini
                    </h3>
                    <p class="text-xs text-slate-500 font-medium">Inovasi kelistrikan ramah lingkungan dan edukasi PLN</p>
                </div>

                {{-- Promo Banner Carousel Card with Auto-Slide & Touch Support --}}
                <div x-data="{
                    active: 0,
                    total: 4,
                    progress: 0,
                    progressTimer: null,
                    touchStartX: 0,
                    duration: 5000,
                    startAutoSlide() {
                        this.stopAutoSlide();
                        const interval = 50;
                        const step = (interval / this.duration) * 100;
                        this.progressTimer = setInterval(() => {
                            this.progress += step;
                            if (this.progress >= 100) {
                                this.next();
                            }
                        }, interval);
                    },
                    stopAutoSlide() {
                        if (this.progressTimer) {
                            clearInterval(this.progressTimer);
                            this.progressTimer = null;
                        }
                    },
                    next() {
                        this.active = (this.active + 1) % this.total;
                        this.progress = 0;
                    },
                    prev() {
                        this.active = (this.active - 1 + this.total) % this.total;
                        this.progress = 0;
                    },
                    goTo(index) {
                        this.active = index;
                        this.progress = 0;
                    }
                }"
                x-init="startAutoSlide()"
                @mouseenter="stopAutoSlide()"
                @mouseleave="startAutoSlide()"
                @touchstart.passive="touchStartX = $event.changedTouches[0].screenX"
                @touchend.passive="if ($event.changedTouches[0].screenX < touchStartX - 40) next(); if ($event.changedTouches[0].screenX > touchStartX + 40) prev();"
                class="card overflow-hidden border border-slate-200 shadow-lg rounded-3xl group bg-white relative">
                    
                    {{-- Aesthetic Circle Accent --}}
                    <div class="absolute -top-10 -right-10 w-36 h-36 rounded-full bg-blue-100/40 pointer-events-none z-0"></div>

                    {{-- Top Progress Bar --}}
                    <div class="h-1 w-full bg-slate-100 overflow-hidden relative z-20">
                        <div class="h-full bg-gradient-to-r from-[#00529C] to-[#FDB813] transition-all duration-75"
                             :style="`width: ${progress}%;`"></div>
                    </div>

                    {{-- Floating Badge Slide Counter --}}
                    <div class="absolute top-4 right-4 z-20 px-2.5 py-1 rounded-full bg-slate-900/60 backdrop-blur-md text-[10px] font-bold text-white tracking-wider flex items-center gap-1.5 border border-white/20 shadow-sm">
                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-400 animate-pulse"></span>
                        <span x-text="active + 1"></span>/<span x-text="total"></span>
                    </div>

                    {{-- Navigation Arrows (Visible on hover & touch) --}}
                    <button @click="prev()" 
                            class="absolute left-2 top-[88px] -translate-y-1/2 w-8 h-8 rounded-full bg-black/40 hover:bg-black/70 text-white backdrop-blur-md flex items-center justify-center text-xs opacity-0 group-hover:opacity-100 transition-all duration-200 z-20 shadow-md active:scale-90"
                            aria-label="Previous Slide">
                        <i class="fas fa-chevron-left"></i>
                    </button>
                    <button @click="next()" 
                            class="absolute right-2 top-[88px] -translate-y-1/2 w-8 h-8 rounded-full bg-black/40 hover:bg-black/70 text-white backdrop-blur-md flex items-center justify-center text-xs opacity-0 group-hover:opacity-100 transition-all duration-200 z-20 shadow-md active:scale-90"
                            aria-label="Next Slide">
                        <i class="fas fa-chevron-right"></i>
                    </button>

                    {{-- Slider Track --}}
                    <div class="relative overflow-hidden z-10">
                        <div class="flex transition-transform duration-500 ease-out"
                             :style="`transform: translateX(-${active * 100}%);`">

                            {{-- Slide 1: Smart Meter AMI --}}
                            <div class="w-full flex-shrink-0">
                                <div class="relative h-48 overflow-hidden bg-[#001a4d]">
                                    <img src="{{ asset('images/smart_meter_banner.svg') }}" alt="PLN Smart Grid AMI" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                                </div>
                                <div class="p-5 bg-white">
                                    <h4 class="text-base font-black text-slate-900 mb-1 leading-tight line-clamp-1 group-hover:text-[#00529C] transition-colors">
                                        KWh Meter Pintar (Advanced Metering)
                                    </h4>
                                    <p class="text-xs text-slate-600 leading-relaxed mb-4 line-clamp-2 min-h-[34px]">
                                        Tingkatkan efisiensi energi dengan pembacaan meter otomatis tanpa perlu didatangi petugas pencatat meter.
                                    </p>
                                    <div class="flex items-center justify-between pt-3 border-t border-slate-100 text-xs">
                                        <span class="text-slate-400 font-semibold flex items-center gap-1.5">
                                            <i class="fas fa-microchip text-blue-500"></i> Smart Grid AMI
                                        </span>
                                        <a href="{{ route('dashboard.monitoring') }}" class="font-extrabold text-[#00529C] hover:text-[#003B70] flex items-center gap-1.5 group-hover:translate-x-0.5 transition">
                                            Monitoring <i class="fas fa-arrow-right text-[10px]"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>

                            {{-- Slide 2: Promo Tambah Daya --}}
                            <div class="w-full flex-shrink-0">
                                <div class="relative h-48 overflow-hidden bg-[#001845]">
                                    <img src="{{ asset('images/promo_tambah_daya.svg') }}" alt="Promo Tambah Daya PLN" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                                </div>
                                <div class="p-5 bg-white">
                                    <h4 class="text-base font-black text-slate-900 mb-1 leading-tight line-clamp-1 group-hover:text-[#00529C] transition-colors">
                                        Promo Diskon Tambah Daya 2026
                                    </h4>
                                    <p class="text-xs text-slate-600 leading-relaxed mb-4 line-clamp-2 min-h-[34px]">
                                        Daya listrik rumah sering turun? Ajukan tambah daya hingga 5.500 VA hemat s/d 50% via PLN DIGI.
                                    </p>
                                    <div class="flex items-center justify-between pt-3 border-t border-slate-100 text-xs">
                                        <span class="text-slate-400 font-semibold flex items-center gap-1.5">
                                            <i class="fas fa-bolt text-amber-500"></i> Diskon s/d 50%
                                        </span>
                                        <a href="{{ route('simulasi') }}" class="font-extrabold text-[#00529C] hover:text-[#003B70] flex items-center gap-1.5 group-hover:translate-x-0.5 transition">
                                            Simulasi <i class="fas fa-arrow-right text-[10px]"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>

                            {{-- Slide 3: DigiPoints & Rewards --}}
                            <div class="w-full flex-shrink-0">
                                <div class="relative h-48 overflow-hidden bg-[#0f172a]">
                                    <img src="{{ asset('images/promo_rewards.svg') }}" alt="DigiPoints & Reward PLN" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                                </div>
                                <div class="p-5 bg-white">
                                    <h4 class="text-base font-black text-slate-900 mb-1 leading-tight line-clamp-1 group-hover:text-[#00529C] transition-colors">
                                        DigiPoints &amp; Reward Pelanggan
                                    </h4>
                                    <p class="text-xs text-slate-600 leading-relaxed mb-4 line-clamp-2 min-h-[34px]">
                                        Bayar tagihan listrik tepat waktu sebelum tgl 20 setiap bulan, kumpulkan poin reward &amp; tukar voucher token.
                                    </p>
                                    <div class="flex items-center justify-between pt-3 border-t border-slate-100 text-xs">
                                        <span class="text-slate-400 font-semibold flex items-center gap-1.5">
                                            <i class="fas fa-gift text-purple-500"></i> Poin Reward
                                        </span>
                                        <a href="{{ route('dashboard.reward') }}" class="font-extrabold text-[#00529C] hover:text-[#003B70] flex items-center gap-1.5 group-hover:translate-x-0.5 transition">
                                            Tukar Poin <i class="fas fa-arrow-right text-[10px]"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>

                            {{-- Slide 4: SwaCAM (Catat Meter Mandiri) --}}
                            <div class="w-full flex-shrink-0">
                                <div class="relative h-48 overflow-hidden bg-[#022c22]">
                                    <img src="{{ asset('images/promo_swacam.svg') }}" alt="Catat Meter Mandiri SwaCAM" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                                </div>
                                <div class="p-5 bg-white">
                                    <h4 class="text-base font-black text-slate-900 mb-1 leading-tight line-clamp-1 group-hover:text-[#00529C] transition-colors">
                                        Catat Meter Mandiri (SwaCAM)
                                    </h4>
                                    <p class="text-xs text-slate-600 leading-relaxed mb-4 line-clamp-2 min-h-[34px]">
                                        Foto dan kirim angka stand kWh meter Anda secara praktis tiap tanggal 24-27 untuk tagihan lebih akurat.
                                    </p>
                                    <div class="flex items-center justify-between pt-3 border-t border-slate-100 text-xs">
                                        <span class="text-slate-400 font-semibold flex items-center gap-1.5">
                                            <i class="fas fa-camera text-emerald-500"></i> SwaCAM Bulanan
                                        </span>
                                        <a href="{{ route('dashboard.metering') }}" class="font-extrabold text-[#00529C] hover:text-[#003B70] flex items-center gap-1.5 group-hover:translate-x-0.5 transition">
                                            Catat Meter <i class="fas fa-arrow-right text-[10px]"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>

                    {{-- Carousel Indicator Dots (Bottom) --}}
                    <div class="flex items-center justify-center gap-1.5 pb-4 bg-white relative z-20">
                        <template x-for="i in total" :key="i">
                            <button @click="goTo(i - 1)" 
                                    :class="active === (i - 1) ? 'w-6 bg-[#00529C]' : 'w-2 bg-slate-200 hover:bg-slate-300'"
                                    class="h-2 rounded-full transition-all duration-300 focus:outline-none"
                                    :aria-label="'Pergi ke slide ' + i">
                            </button>
                        </template>
                    </div>

                </div>

                {{-- Bantuan Call Center Mini Box with Aesthetic Circle --}}
                <div class="p-5 rounded-3xl bg-gradient-to-br from-[#00265a] to-[#001230] text-white flex items-center justify-between gap-4 shadow-xl border border-white/10 relative overflow-hidden">
                    <div class="absolute -top-6 -right-6 w-24 h-24 rounded-full bg-white/5 pointer-events-none"></div>

                    <div class="flex items-center gap-3.5 relative z-10">
                        <div class="w-12 h-12 rounded-2xl bg-[#FDB813] text-[#001230] flex items-center justify-center font-black text-xl shadow-xs">
                            <i class="fas fa-headset"></i>
                        </div>
                        <div>
                            <p class="text-[11px] text-white/70 font-bold uppercase tracking-wider">Layanan Pengaduan 24 Jam</p>
                            <p class="text-lg font-black text-white">Contact Center 123</p>
                        </div>
                    </div>
                    <a href="https://wa.me/628122123123" target="_blank" class="p-3 rounded-2xl bg-white/10 hover:bg-white/20 text-[#FDB813] transition border border-white/15 shadow-sm active:scale-95 relative z-10" title="Chat WhatsApp PLN">
                        <i class="fab fa-whatsapp text-xl"></i>
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

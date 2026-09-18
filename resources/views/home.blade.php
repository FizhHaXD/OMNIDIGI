@extends('layouts.main')
@section('title', 'PLN DIGI - Layanan Listrik Digital Indonesia')

@section('content')
{{-- ══ HERO ══ --}}
<section class="relative -mt-16 bg-[#1B6EBB] text-white overflow-hidden pt-32 lg:pt-40">
    {{-- 1. Base Blue Gradient --}}
    <div class="absolute inset-0 bg-gradient-to-br from-[#2782C9] via-[#1B6EBB] to-[#0F477E]"></div>
    
    {{-- 2. Background Overlay Image --}}
    <div class="absolute inset-0 bg-[url('/images/hero-pln-1.jpg')] bg-cover bg-center opacity-40 mix-blend-overlay"></div>
    <div class="absolute inset-0 bg-[url('/images/hero-pln-1.jpg')] bg-cover bg-center opacity-10"></div>
    
    {{-- 3. Left-side reading gradient --}}
    <div class="absolute inset-0 bg-gradient-to-r from-[#1961A5]/95 via-[#1961A5]/50 to-transparent"></div>

    {{-- Hero Top Wrapper --}}
    <div class="relative w-full">
        {{-- Right: Hero Image curved panel --}}
        <div class="absolute right-0 top-0 bottom-0 w-[52%] z-10 hidden lg:block">
            <div class="absolute inset-0 overflow-hidden" style="border-top-left-radius: 200px 50%; border-bottom-left-radius: 200px 50%; border-left: 2px solid rgba(253,184,19,0.35); box-shadow: -10px 0 40px rgba(253,184,19,0.12);">
                <img src="{{ asset('images/thumbnail-pln.png') }}" class="w-full h-full object-cover object-[center_30%]" alt="PLN Worker">
                <div class="absolute inset-0 bg-gradient-to-l from-transparent via-transparent to-[#1961A5]/65"></div>
                <div class="absolute inset-x-0 top-0 h-28 bg-gradient-to-b from-[#2782C9]/65 to-transparent"></div>
                <div class="absolute inset-x-0 bottom-0 h-28 bg-gradient-to-t from-[#0F477E]/85 to-transparent"></div>
            </div>
            
            {{-- Floating Icon Pills on curved edge --}}
            <div class="absolute left-[-22px] inset-y-0 flex flex-col justify-center gap-7 z-30">
                <div class="w-[52px] h-[52px] bg-gradient-to-br from-[#FDB813] to-[#D4980A] rounded-2xl flex items-center justify-center shadow-[0_0_20px_rgba(253,184,19,0.45)] transform translate-x-4 border border-white/20">
                    <i class="fas fa-file-invoice-dollar text-[#7a5500] text-lg"></i>
                </div>
                <div class="w-[52px] h-[52px] bg-gradient-to-br from-[#FDB813] to-[#D4980A] rounded-2xl flex items-center justify-center shadow-[0_0_20px_rgba(253,184,19,0.45)] transform -translate-x-1 border border-white/20">
                    <i class="fas fa-bolt text-[#7a5500] text-lg"></i>
                </div>
                <div class="w-[52px] h-[52px] bg-gradient-to-br from-[#FDB813] to-[#D4980A] rounded-2xl flex items-center justify-center shadow-[0_0_20px_rgba(253,184,19,0.45)] transform translate-x-4 border border-white/20">
                    <i class="fas fa-plug text-[#7a5500] text-lg"></i>
                </div>
            </div>
        </div>

        {{-- Left: Hero Text Content — diberi ruang napas dari kiri --}}
        <div class="relative z-20 w-full">
            <div class="pl-20 sm:pl-28 lg:pl-36 xl:pl-48 2xl:pl-56 pr-4 max-w-[720px] pt-4 pb-16">
                {{-- Eyebrow badge --}}
                <div class="inline-flex items-center gap-2.5 px-4 py-2 border border-white/20 rounded-full mb-9 backdrop-blur-sm bg-white/10">
                    <span class="w-2 h-2 rounded-full bg-[#FDB813] animate-pulse flex-shrink-0"></span>
                    <span class="text-[11px] font-bold uppercase tracking-[0.22em] text-white/75">Satu Portal, Ribuan Kemudahan</span>
                </div>

                {{-- Main Heading --}}
                <h1 class="text-[2.9rem] md:text-[3.8rem] font-extrabold leading-[1.1] mb-7 tracking-tight">
                    Satu portal,<br>
                    ribuan peluang<br>
                    <span class="text-[#FDB813]">pencari dan</span><br>
                    <span class="text-[#FDB813]">pemberi layanan</span>
                </h1>

                {{-- Sub-description --}}
                <p class="text-white/70 text-[15px] leading-[1.75] max-w-[420px]">
                    PLN DIGI menghubungkan pelanggan dengan layanan listrik digital terverifikasi dalam satu ekosistem terpercaya.
                </p>
            </div>
        </div>
    </div>

    {{-- ══ BOTTOM CARDS — Separated with clear top spacing from image ══ --}}
    <div class="relative z-30 w-full pl-20 sm:pl-28 lg:pl-36 xl:pl-48 2xl:pl-56 pr-8 sm:pr-12 lg:pr-16 pb-14">

        {{-- Section divider line --}}
        <div class="border-t border-white/10 mb-8"></div>

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-5">
            
            {{-- Left: Quick Action Cards --}}
            <div class="lg:col-span-4 flex flex-col gap-3">
                <p class="text-[9px] font-bold uppercase tracking-[0.2em] text-white/35 mb-2 pl-0.5">Aksi Cepat</p>

                {{-- Bayar Tagihan --}}
                <a href="/produk/tagihan" class="group flex items-center gap-4 p-5 rounded-2xl bg-white/10 border border-white/15 hover:bg-white/18 hover:border-white/28 backdrop-blur-md transition-all duration-200 shadow-md">
                    <div class="w-11 h-11 rounded-xl bg-gradient-to-br from-[#FDB813] to-[#D4980A] flex items-center justify-center flex-shrink-0 shadow group-hover:scale-105 transition-transform duration-200">
                        <i class="fas fa-file-invoice-dollar text-[#7a5500] text-[15px]"></i>
                    </div>
                    <div class="flex-1 min-w-0">
                        <div class="flex items-center justify-between">
                            <span class="font-bold text-[14.5px] text-white group-hover:text-[#FDB813] transition-colors">Bayar Tagihan</span>
                            <i class="fas fa-chevron-right text-white/30 text-[10px] group-hover:text-[#FDB813] group-hover:translate-x-0.5 transition-all"></i>
                        </div>
                        <p class="text-white/55 text-[12px] mt-0.5 leading-snug">Bayar tagihan listrik pascabayar Anda.</p>
                    </div>
                </a>

                {{-- Beli Token --}}
                <a href="/produk/token" class="group flex items-center gap-4 p-5 rounded-2xl bg-white/10 border border-white/15 hover:bg-white/18 hover:border-white/28 backdrop-blur-md transition-all duration-200 shadow-md">
                    <div class="w-11 h-11 rounded-xl bg-gradient-to-br from-[#FDB813] to-[#D4980A] flex items-center justify-center flex-shrink-0 shadow group-hover:scale-105 transition-transform duration-200">
                        <i class="fas fa-bolt text-[#7a5500] text-[15px]"></i>
                    </div>
                    <div class="flex-1 min-w-0">
                        <div class="flex items-center justify-between">
                            <span class="font-bold text-[14.5px] text-white group-hover:text-[#FDB813] transition-colors">Beli Token</span>
                            <i class="fas fa-chevron-right text-white/30 text-[10px] group-hover:text-[#FDB813] group-hover:translate-x-0.5 transition-all"></i>
                        </div>
                        <p class="text-white/55 text-[12px] mt-0.5 leading-snug">Isi ulang token listrik prabayar Anda.</p>
                    </div>
                </a>
            </div>

            {{-- Right: Info Feature Cards --}}
            <div class="lg:col-span-8">
                <p class="text-[9px] font-bold uppercase tracking-[0.2em] text-white/35 mb-5 pl-0.5">Layanan Lainnya</p>
                <div class="bg-white/10 backdrop-blur-md border border-white/15 rounded-2xl px-8 py-7 relative overflow-hidden shadow-md">
                    <div class="absolute -top-10 -right-10 w-48 h-48 bg-[#FDB813]/5 rounded-full blur-3xl pointer-events-none"></div>
                    
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-0 relative z-10 divide-y md:divide-y-0 md:divide-x divide-white/10">
                        
                        {{-- Feature 1: Pendanaan --}}
                        <div class="flex flex-col pb-5 md:pb-0 md:pr-8 group/feat cursor-pointer" onclick="window.location.href='/simulasi'">
                            <div class="flex items-start justify-between mb-4">
                                <div class="w-9 h-9 border border-white/20 rounded-xl flex items-center justify-center bg-white/5 group-hover/feat:border-[#FDB813]/50 group-hover/feat:bg-[#FDB813]/10 transition-all">
                                    <i class="fas fa-calculator text-[#FDB813] text-sm"></i>
                                </div>
                                <i class="fas fa-arrow-right text-white/25 text-[10px] mt-1 group-hover/feat:text-white/60 transition-colors"></i>
                            </div>
                            <span class="text-[13.5px] font-bold text-[#FDB813] mb-1 group-hover/feat:text-[#ffd060] transition-colors">Belum tersedia</span>
                            <p class="text-white/50 text-[11.5px] leading-relaxed">Pendanaan Pemasangan Baru</p>
                        </div>
                        
                        {{-- Feature 2: Riwayat --}}
                        <div class="flex flex-col py-5 md:py-0 md:px-8 group/feat cursor-pointer" onclick="window.location.href='/dashboard'">
                            <div class="flex items-start justify-between mb-4">
                                <div class="w-9 h-9 border border-white/20 rounded-xl flex items-center justify-center bg-white/5 group-hover/feat:border-[#FDB813]/50 group-hover/feat:bg-[#FDB813]/10 transition-all">
                                    <i class="fas fa-history text-[#FDB813] text-sm"></i>
                                </div>
                                <i class="fas fa-arrow-right text-white/25 text-[10px] mt-1 group-hover/feat:text-white/60 transition-colors"></i>
                            </div>
                            <span class="text-[13.5px] font-bold text-[#FDB813] mb-1 group-hover/feat:text-[#ffd060] transition-colors">Belum tersedia</span>
                            <p class="text-white/50 text-[11.5px] leading-relaxed">Riwayat Transaksi Listrik</p>
                        </div>

                        {{-- Feature 3: Support --}}
                        <div class="flex flex-col pt-5 md:pt-0 md:pl-8 group/feat cursor-pointer">
                            <div class="flex items-start justify-between mb-4">
                                <div class="w-9 h-9 border border-white/20 rounded-xl flex items-center justify-center bg-white/5 group-hover/feat:border-[#FDB813]/50 group-hover/feat:bg-[#FDB813]/10 transition-all">
                                    <i class="fas fa-headset text-[#FDB813] text-sm"></i>
                                </div>
                                <i class="fas fa-arrow-right text-white/25 text-[10px] mt-1 group-hover/feat:text-white/60 transition-colors"></i>
                            </div>
                            <span class="text-[13.5px] font-bold text-[#FDB813] mb-1 group-hover/feat:text-[#ffd060] transition-colors">Belum tersedia</span>
                            <p class="text-white/50 text-[11.5px] leading-relaxed">Penerima Manfaat Support</p>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ══ APA ITU PLN DIGI ══ --}}
<section class="relative overflow-hidden py-0" style="background-color: #ccdff2;">

    {{-- Background: full-width images sepenuhnya visible --}}
    <div class="absolute inset-0">
        <div class="absolute inset-y-0 left-0 w-1/2 overflow-hidden">
            <img src="{{ asset('images/thumbnail-pln.png') }}"
                 alt="PLN background left"
                 class="w-full h-full object-cover object-center"
                 style="filter: blur(2px) brightness(0.82) saturate(0.65);">
        </div>
        <div class="absolute inset-y-0 right-0 w-1/2 overflow-hidden">
            <img src="{{ asset('images/hero-pln-1.jpg') }}"
                 alt="PLN background right"
                 class="w-full h-full object-cover object-center"
                 style="filter: blur(2px) brightness(0.82) saturate(0.65);">
        </div>
    </div>

    {{-- Overlay ringan agar warna tetap harmonis --}}
    <div class="absolute inset-0 bg-[#b8d4ee]/40"></div>

    {{-- Top & bottom fade to white --}}
    <div class="absolute inset-x-0 top-0 h-20 bg-gradient-to-b from-white to-transparent"></div>
    <div class="absolute inset-x-0 bottom-0 h-20 bg-gradient-to-t from-white to-transparent"></div>

    {{-- Content: seluruh area dibungkus glass card --}}
    <div class="relative z-10 max-w-3xl mx-auto px-8 py-20">

        {{-- ═══ GLASS CARD ═══ --}}
        <div class="bg-white/80 backdrop-blur-md rounded-3xl border border-white/90 shadow-[0_8px_48px_rgba(0,60,120,0.12)] overflow-hidden">

            {{-- Garis atas (full-width accent) --}}
            <div class="h-[2px] bg-gradient-to-r from-transparent via-slate-300/70 to-transparent"></div>

            {{-- Inner padding --}}
            <div class="px-14 py-12 text-center">

                {{-- Title --}}
                <h2 class="text-[2rem] md:text-[2.4rem] font-extrabold text-slate-900 tracking-[-0.025em] mb-8 leading-tight">
                    Apa itu PLN DIGI?
                </h2>

                {{-- Paragraf 1: besar, terbaca jelas --}}
                <p class="text-slate-700 text-[17px] leading-[1.9] mb-4 font-normal">
                    PLN DIGI menghubungkan pelanggan dengan berbagai layanan listrik digital.
                    Kami hadir untuk membuat pengelolaan listrik lebih mudah, lebih cepat,
                    dan lebih dekat bagi siapa pun.
                </p>

                {{-- Paragraf 2 --}}
                <p class="text-slate-500 text-[15.5px] leading-[1.9] mb-10">
                    Kami mewujudkan akses energi listrik yang merata, transparan,
                    dan dapat dijangkau oleh seluruh masyarakat Indonesia.
                </p>

                {{-- Garis pemisah sebelum quote --}}
                <div class="h-px bg-gradient-to-r from-transparent via-slate-200 to-transparent mb-8"></div>

                {{-- Quote --}}
                <p class="text-[#B8780A] text-[15.5px] font-medium italic tracking-wide">
                    &ldquo; Listrik untuk kehidupan yang lebih baik. &rdquo;
                </p>

            </div>

            {{-- Garis bawah (full-width accent) --}}
            <div class="h-[2px] bg-gradient-to-r from-transparent via-slate-300/70 to-transparent"></div>

        </div>
        {{-- ═══ END GLASS CARD ═══ --}}

    </div>
</section>

{{-- ══ FEATURES ══ --}}
<section class="py-16">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-10">
            <span class="section-label">Keunggulan</span>
            <h2 class="section-title">Kenapa PLN DIGI?</h2>
        </div>
        <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-5">
            @php
                $features = [
                    ['icon' => 'fa-shield-alt', 'title' => 'Aman & Terpercaya', 'desc' => 'Transaksi dijamin aman dengan enkripsi dan verifikasi berlapis.'],
                    ['icon' => 'fa-clock', 'title' => '24/7 Tersedia', 'desc' => 'Layanan tersedia kapan saja, di mana saja, tanpa antri.'],
                    ['icon' => 'fa-wallet', 'title' => 'Banyak Metode Bayar', 'desc' => 'Dukung pembayaran via QRIS, e-wallet, dan transfer bank.'],
                    ['icon' => 'fa-history', 'title' => 'Riwayat Lengkap', 'desc' => 'Pantau semua riwayat transaksi dan pembayaran Anda.'],
                ];
            @endphp
            @foreach($features as $f)
                <div class="card p-6 text-center">
                    <div class="w-12 h-12 bg-[#2D6DA8]/8 rounded-xl flex items-center justify-center mx-auto mb-4">
                        <i class="fas {{ $f['icon'] }} text-[#2D6DA8] text-lg"></i>
                    </div>
                    <h3 class="font-bold text-slate-900 text-sm mb-1.5">{{ $f['title'] }}</h3>
                    <p class="text-xs text-slate-500 leading-relaxed">{{ $f['desc'] }}</p>
                </div>
            @endforeach
        </div>
    </div>
</section>

{{-- ══ STATS ══ --}}
<section class="py-12 bg-[#2D6DA8]">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
            @php
                $stats = [
                    ['value' => '1M+', 'label' => 'Pelanggan'],
                    ['value' => '99.9%', 'label' => 'Uptime'],
                    ['value' => '3 Detik', 'label' => 'Proses Transaksi'],
                    ['value' => '24/7', 'label' => 'Dukungan'],
                ];
            @endphp
            @foreach($stats as $s)
                <div class="text-center">
                    <p class="text-2xl md:text-3xl font-bold text-white">{{ $s['value'] }}</p>
                    <p class="text-sm text-white/50 mt-0.5">{{ $s['label'] }}</p>
                </div>
            @endforeach
        </div>
    </div>
</section>

{{-- ══ TAGLINE BAR (like SatuBeasiswa) ══ --}}
<section class="py-8 bg-white border-y border-slate-100">
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col md:flex-row items-center gap-4 md:gap-8">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 bg-[#2D6DA8]/10 rounded-full flex items-center justify-center flex-shrink-0">
                    <i class="fas fa-check-circle text-[#2D6DA8]"></i>
                </div>
                <p class="font-bold text-slate-900 text-sm">Satu platform. Satu layanan. <span class="text-[#D4980A]">Satu solusi.</span></p>
            </div>
            <div class="hidden md:block w-px h-8 bg-slate-200"></div>
            <p class="text-slate-500 text-sm">Mewujudkan akses listrik yang merata melalui digitalisasi layanan PLN di Indonesia.</p>
        </div>
    </div>
</section>

{{-- ══ FAQ (like SatuBeasiswa) ══ --}}
<section class="py-16 bg-[#EFF3F8]">
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
        <span class="section-label">FAQ</span>
        <h2 class="section-title mb-8">Pertanyaan yang sering ditanyakan</h2>

        <div class="space-y-3" x-data="{ open: null }">
            @php
                $faqs = [
                    ['q' => 'Bagaimana cara membayar tagihan listrik?', 'a' => 'Klik menu Produk > Bayar Tagihan, masukkan ID Pelanggan, lalu pilih metode pembayaran (QRIS, e-wallet, atau transfer bank).'],
                    ['q' => 'Apakah bisa beli token di PLN DIGI?', 'a' => 'Ya, Anda bisa membeli token listrik prabayar mulai dari nominal Rp 20.000 hingga Rp 1.000.000 melalui menu Produk > Beli Token.'],
                    ['q' => 'Apa itu simulasi pasang listrik baru?', 'a' => 'Fitur simulasi membantu Anda menghitung estimasi biaya pemasangan listrik baru berdasarkan jenis tarif dan daya yang dipilih.'],
                    ['q' => 'Apakah data saya aman?', 'a' => 'Ya, semua data pelanggan dienkripsi dan disimpan dengan standar keamanan tinggi. Kami tidak membagikan data kepada pihak ketiga.'],
                    ['q' => 'Bagaimana cara mendaftar?', 'a' => 'Klik tombol "Buat Akun" di pojok kanan atas, isi formulir pendaftaran, dan verifikasi email Anda.'],
                ];
            @endphp
            @foreach($faqs as $i => $faq)
                <div class="bg-white rounded-xl border border-slate-200">
                    <button @click="open === {{ $i }} ? open = null : open = {{ $i }}" class="w-full flex items-center justify-between px-5 py-4 text-left">
                        <span class="text-sm font-medium text-slate-800">{{ $faq['q'] }}</span>
                        <i class="fas fa-plus text-slate-400 text-xs transition-transform" :class="open === {{ $i }} ? 'rotate-45' : ''"></i>
                    </button>
                    <div x-show="open === {{ $i }}" x-collapse>
                        <div class="px-5 pb-4">
                            <p class="text-sm text-slate-500 leading-relaxed">{{ $faq['a'] }}</p>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>

{{-- ══ CTA BANNER (like SatuBeasiswa — blue bar before footer) ══ --}}
<section class="bg-[#2D6DA8] py-12">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col md:flex-row items-center justify-between gap-6">
            <div>
                <h2 class="text-xl md:text-2xl font-bold text-white">
                    Siap beralih ke <span class="text-[#D4980A]">layanan digital?</span>
                </h2>
                <p class="text-white/60 text-sm mt-1.5 max-w-lg">
                    Bergabunglah dengan jutaan pelanggan yang telah mempercayai PLN DIGI.
                </p>
            </div>
            <div class="flex gap-3">
                @guest
                    <a href="{{ route('register') }}" class="btn-secondary">Mulai cari layanan →</a>
                    <a href="{{ route('login') }}" class="btn-outline">Masuk</a>
                @else
                    <a href="{{ route('produk') }}" class="btn-secondary">Mulai Transaksi →</a>
                @endguest
            </div>
        </div>
    </div>
</section>
@endsection

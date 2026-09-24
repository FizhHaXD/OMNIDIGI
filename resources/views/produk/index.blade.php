@extends('layouts.main')
@section('title', 'Katalog Produk & Layanan - PLN DIGI')

@section('content')
{{-- Header --}}
<section class="relative -mt-16 md:-mt-18 bg-gradient-to-br from-[#001230] via-[#00265a] to-[#001a4d] text-white overflow-hidden">
    <div class="absolute inset-0 bg-[url('/images/hero-pln-1.jpg')] bg-cover bg-center opacity-10 mix-blend-luminosity"></div>
    <div class="absolute inset-0 bg-gradient-to-t from-[#001230]/80 via-transparent to-transparent"></div>
    
    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-32 pb-14 md:pt-36 md:pb-16">
        <div class="max-w-3xl">
            <span class="inline-flex items-center gap-2 px-3.5 py-1.5 bg-white/10 rounded-full text-[#FDB813] text-xs font-semibold uppercase tracking-wider mb-4 border border-white/15 backdrop-blur-sm">
                <i class="fas fa-bolt text-[11px]"></i> Ekosistem Layanan Digital PLN
            </span>
            <h1 class="text-3xl md:text-5xl font-extrabold tracking-tight mb-4 leading-tight">
                Semua Produk & Layanan <span class="text-[#FDB813]">Kelistrikan</span>
            </h1>
            <p class="text-white/70 text-base md:text-lg leading-relaxed">
                Pelajari seluruh fitur unggulan yang tersedia di PLN DIGI. Mulai dari pembayaran tagihan, pembelian token, catat meter mandiri, hingga pelaporan gangguan 24 jam dalam satu portal terpadu.
            </p>
        </div>
    </div>
</section>

{{-- Main Content Section --}}
<section class="py-10 md:py-16 bg-slate-50 min-h-[600px]" x-data="{ activeTab: 'semua' }">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        {{-- Guest Notice Banner (Saat belum login) --}}
        @guest
        <div class="mb-10 p-5 md:p-6 rounded-2xl bg-gradient-to-r from-amber-50 to-orange-50/70 border border-amber-200/90 shadow-sm flex flex-col md:flex-row md:items-center justify-between gap-5">
            <div class="flex items-start md:items-center gap-4">
                <div class="w-12 h-12 rounded-2xl bg-[#FDB813]/20 text-[#B8780A] flex items-center justify-center flex-shrink-0 text-xl shadow-inner">
                    <i class="fas fa-lock"></i>
                </div>
                <div>
                    <h3 class="text-base font-bold text-slate-800">Akses Penuh Layanan Pengguna</h3>
                    <p class="text-xs md:text-sm text-slate-600 mt-0.5 max-w-2xl leading-relaxed">
                        Anda dapat melihat dan mempelajari semua informasi produk di bawah ini. Untuk mengakses dan menggunakan layanan, silakan masuk ke akun PLN DIGI Anda.
                    </p>
                </div>
            </div>
            <div class="flex items-center gap-3 flex-shrink-0">
                <a href="{{ route('login') }}" class="btn-primary text-xs sm:text-sm px-5 py-2.5 shadow-sm hover:shadow transition-all">
                    <i class="fas fa-sign-in-alt text-xs"></i> Masuk Sekarang
                </a>
                <a href="{{ route('register') }}" class="px-5 py-2.5 rounded-full text-xs sm:text-sm font-semibold bg-white border border-slate-300 text-slate-700 hover:bg-slate-100 transition-colors shadow-sm">
                    Daftar Akun
                </a>
            </div>
        </div>
        @else
        {{-- Auth Customer Summary Helper --}}
        <div class="mb-8 p-4 rounded-xl bg-blue-50/80 border border-blue-100 flex items-center justify-between text-xs text-slate-600">
            <div class="flex items-center gap-2">
                <i class="fas fa-check-circle text-[#00529C]"></i>
                <span>Anda sedang login sebagai <strong>{{ auth()->user()->name }}</strong>. Klik layanan apa saja di bawah ini untuk langsung menuju halaman dashboard terkait.</span>
            </div>
            <a href="{{ route('dashboard') }}" class="font-semibold text-[#00529C] hover:underline flex items-center gap-1">
                Buka Dashboard <i class="fas fa-arrow-right text-[10px]"></i>
            </a>
        </div>
        @endguest

        {{-- Filter Tabs --}}
        <div class="flex flex-wrap items-center justify-between gap-4 mb-8 pb-4 border-b border-slate-200">
            <div class="flex flex-wrap gap-2">
                <button @click="activeTab = 'semua'"
                        :class="activeTab === 'semua' ? 'bg-[#00529C] text-white shadow-md' : 'bg-white text-slate-600 hover:bg-slate-100 border border-slate-200'"
                        class="px-4 py-2 rounded-full text-xs sm:text-sm font-semibold transition-all">
                    Semua Layanan ({{ count($products) }})
                </button>
                <button @click="activeTab = 'pembayaran'"
                        :class="activeTab === 'pembayaran' ? 'bg-[#00529C] text-white shadow-md' : 'bg-white text-slate-600 hover:bg-slate-100 border border-slate-200'"
                        class="px-4 py-2 rounded-full text-xs sm:text-sm font-semibold transition-all">
                    <i class="fas fa-wallet mr-1.5 text-xs opacity-70"></i> Pembayaran
                </button>
                <button @click="activeTab = 'pengawasan'"
                        :class="activeTab === 'pengawasan' ? 'bg-[#00529C] text-white shadow-md' : 'bg-white text-slate-600 hover:bg-slate-100 border border-slate-200'"
                        class="px-4 py-2 rounded-full text-xs sm:text-sm font-semibold transition-all">
                    <i class="fas fa-chart-pie mr-1.5 text-xs opacity-70"></i> Pengawasan & Meteran
                </button>
                <button @click="activeTab = 'bantuan'"
                        :class="activeTab === 'bantuan' ? 'bg-[#00529C] text-white shadow-md' : 'bg-white text-slate-600 hover:bg-slate-100 border border-slate-200'"
                        class="px-4 py-2 rounded-full text-xs sm:text-sm font-semibold transition-all">
                    <i class="fas fa-headset mr-1.5 text-xs opacity-70"></i> Bantuan & Reward
                </button>
            </div>

            <p class="text-xs text-slate-400">
                <span class="font-medium text-slate-600">{{ count($products) }}</span> produk & layanan tersedia
            </p>
        </div>

        {{-- Products Grid --}}
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-16">
            @foreach($products as $p)
            <div x-show="activeTab === 'semua' || activeTab === '{{ $p['kategori'] }}'"
                 x-transition:enter="transition ease-out duration-200"
                 x-transition:enter-start="opacity-0 translate-y-2"
                 x-transition:enter-end="opacity-100 translate-y-0"
                 class="card p-6 flex flex-col justify-between group hover:shadow-xl transition-all duration-300 hover:-translate-y-1 bg-white border border-slate-200/90 rounded-2xl relative overflow-hidden">
                
                {{-- Decorative top accent line --}}
                <div class="absolute top-0 left-0 right-0 h-1 bg-gradient-to-r from-[#00529C] via-[#2D6DA8] to-[#FDB813] opacity-0 group-hover:opacity-100 transition-opacity"></div>

                <div>
                    {{-- Header Top: Icon + Badge --}}
                    <div class="flex items-start justify-between gap-3 mb-5">
                        <div class="w-14 h-14 rounded-2xl {{ $p['icon_bg'] }} flex items-center justify-center flex-shrink-0 text-xl shadow-sm group-hover:scale-105 transition-transform duration-300">
                            <i class="fas {{ $p['icon'] }}"></i>
                        </div>
                        <span class="inline-block px-3 py-1 rounded-full text-[11px] font-bold tracking-wide uppercase {{ $p['badge_bg'] }}">
                            {{ $p['badge'] }}
                        </span>
                    </div>

                    {{-- Title & Summary --}}
                    <h2 class="text-lg font-bold text-slate-900 mb-2 group-hover:text-[#00529C] transition-colors leading-snug">
                        {{ $p['nama'] }}
                    </h2>
                    <p class="text-xs text-slate-500 font-medium mb-4 leading-relaxed">
                        {{ $p['ringkasan'] }}
                    </p>

                    {{-- Description --}}
                    <p class="text-xs text-slate-600 leading-relaxed mb-5 bg-slate-50 p-3.5 rounded-xl border border-slate-100">
                        {{ $p['deskripsi'] }}
                    </p>

                    {{-- Feature List --}}
                    <div class="space-y-2 mb-6">
                        <p class="text-[11px] font-bold uppercase tracking-wider text-slate-400 mb-2.5">Fitur Unggulan</p>
                        @foreach($p['fitur'] as $fitur)
                        <div class="flex items-start gap-2 text-xs text-slate-700">
                            <i class="fas fa-check text-emerald-500 text-[10px] mt-1 flex-shrink-0"></i>
                            <span class="leading-tight">{{ $fitur }}</span>
                        </div>
                        @endforeach
                    </div>
                </div>

                {{-- Action Button --}}
                <div class="pt-4 border-t border-slate-100">
                    @auth
                        <a href="{{ $p['route'] }}"
                           class="btn-primary w-full text-center flex items-center justify-center gap-2 py-2.5 text-xs font-semibold shadow-sm hover:shadow">
                            <span>{{ $p['btn_text'] }}</span>
                            <i class="fas fa-arrow-right text-[11px] group-hover:translate-x-1 transition-transform"></i>
                        </a>
                    @else
                        <a href="{{ route('login') }}"
                           class="w-full py-2.5 px-4 rounded-full text-xs font-semibold flex items-center justify-center gap-2 bg-slate-100 hover:bg-[#00529C] text-slate-700 hover:text-white border border-slate-200 hover:border-[#00529C] transition-all duration-200 group/btn shadow-sm"
                           title="Silakan masuk untuk menggunakan layanan {{ $p['nama'] }}">
                            <i class="fas fa-lock text-[11px] text-slate-400 group-hover/btn:text-white transition-colors"></i>
                            <span>Masuk untuk Menggunakan</span>
                        </a>
                    @endauth
                </div>

            </div>
            @endforeach
        </div>

        {{-- Bottom Banner (Trust & Help) --}}
        <div class="bg-gradient-to-r from-[#00529C] to-[#003d75] rounded-3xl p-8 md:p-12 text-white shadow-xl relative overflow-hidden">
            <div class="absolute -right-10 -bottom-10 w-64 h-64 bg-[#FDB813]/10 rounded-full blur-3xl pointer-events-none"></div>
            
            <div class="relative z-10 flex flex-col lg:flex-row items-start lg:items-center justify-between gap-8">
                <div class="max-w-2xl">
                    <span class="inline-block px-3.5 py-1 bg-white/10 rounded-full text-[#FDB813] text-xs font-bold uppercase tracking-wider mb-3.5 border border-white/10">
                        Pusat Bantuan & Layanan 24 Jam
                    </span>
                    <h3 class="text-2xl md:text-3xl font-extrabold tracking-tight mb-2.5">
                        Mengalami Kendala atau Pertanyaan Layanan?
                    </h3>
                    <p class="text-white/70 text-sm leading-relaxed">
                        Layanan PLN DIGI siap mendampingi kebutuhan kelistrikan Anda 24 jam sehari, 7 hari seminggu. Hubungi Contact Center resmi kami untuk bantuan instan atau lakukan simulasi pemasangan listrik.
                    </p>
                </div>
                <div class="flex flex-col sm:flex-row items-stretch sm:items-center gap-3 w-full lg:w-auto flex-shrink-0">
                    <a href="tel:123" class="btn-secondary text-center justify-center text-sm py-3 px-6 shadow-lg whitespace-nowrap">
                        <i class="fas fa-phone-alt mr-2"></i> Hubungi PLN 123
                    </a>
                    <a href="{{ route('simulasi') }}" class="btn-outline text-center justify-center text-sm py-3 px-6 !border-white/30 hover:!bg-white/10 whitespace-nowrap">
                        <i class="fas fa-calculator mr-2"></i> Simulasi Pasang Baru
                    </a>
                </div>
            </div>
        </div>

    </div>
</section>
@endsection

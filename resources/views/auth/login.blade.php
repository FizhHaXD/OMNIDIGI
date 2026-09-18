<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'PLN DIGI') }} — Masuk</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-white" style="font-family: 'Plus Jakarta Sans', sans-serif;">

<div class="min-h-screen flex">

    {{-- ══ LEFT PANEL: Branding (hidden on mobile) ══ --}}
    <div class="hidden lg:flex lg:w-[52%] relative flex-col overflow-hidden bg-[#0F477E]">

        {{-- Background Gradient --}}
        <div class="absolute inset-0 bg-gradient-to-br from-[#2782C9] via-[#1561A8] to-[#0a2f5c]"></div>

        {{-- Background image overlay --}}
        <div class="absolute inset-0 bg-[url('/images/hero-pln-1.jpg')] bg-cover bg-center opacity-20 mix-blend-overlay"></div>
        <div class="absolute inset-0 bg-gradient-to-t from-[#0a2f5c]/80 via-transparent to-transparent"></div>

        {{-- Decorative Circles --}}
        <div class="absolute -top-24 -left-24 w-72 h-72 bg-[#FDB813]/10 rounded-full blur-3xl"></div>
        <div class="absolute bottom-0 right-0 w-96 h-96 bg-[#2782C9]/30 rounded-full blur-3xl translate-x-1/3 translate-y-1/3"></div>

        {{-- PLN Worker Image --}}
        <div class="absolute inset-0 flex items-end justify-center">
            <img src="{{ asset('images/thumbnail-pln.png') }}"
                 alt="PLN Worker"
                 class="w-full h-full object-cover object-center opacity-35">
        </div>

        {{-- Content --}}
        <div class="relative z-10 flex flex-col h-full px-12 py-10">

            {{-- Logo --}}
            <a href="/" class="flex items-center gap-3 group w-fit">
                <div class="w-10 h-10 bg-[#FDB813] rounded-xl flex items-center justify-center shadow-md group-hover:scale-105 transition-transform">
                    <i class="fas fa-bolt text-[#001a4d] text-base"></i>
                </div>
                <div>
                    <span class="text-[18px] font-extrabold text-white tracking-tight leading-none">
                        PLN<span class="text-[#FDB813]">DIGI</span>
                    </span>
                    <p class="text-white/50 text-[10px] font-medium tracking-wider">Layanan Listrik Digital</p>
                </div>
            </a>

            {{-- Main Copy — vertically centered --}}
            <div class="flex-1 flex flex-col justify-center">
                <div class="inline-flex items-center gap-2 px-3 py-1.5 bg-white/10 border border-white/20 rounded-full mb-8 w-fit backdrop-blur-sm">
                    <span class="w-1.5 h-1.5 bg-[#FDB813] rounded-full animate-pulse"></span>
                    <span class="text-[10px] font-bold uppercase tracking-widest text-white/70">Selamat Datang Kembali</span>
                </div>

                <h1 class="text-[2.4rem] font-extrabold text-white leading-[1.15] mb-5 tracking-tight">
                    Kelola listrik<br>
                    Anda dengan<br>
                    <span class="text-[#FDB813]">mudah & cepat</span>
                </h1>

                <p class="text-white/60 text-[14px] leading-relaxed max-w-xs mb-10">
                    Satu akun untuk bayar tagihan, beli token, dan pantau semua transaksi listrik Anda.
                </p>

                {{-- Feature Pills --}}
                <div class="flex flex-col gap-3">
                    @php
                        $features = [
                            ['icon' => 'fa-file-invoice-dollar', 'text' => 'Bayar tagihan pascabayar'],
                            ['icon' => 'fa-bolt',                'text' => 'Beli token prabayar instan'],
                            ['icon' => 'fa-shield-alt',          'text' => 'Transaksi aman & terenkripsi'],
                        ];
                    @endphp
                    @foreach($features as $f)
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 rounded-lg bg-[#FDB813]/15 border border-[#FDB813]/25 flex items-center justify-center flex-shrink-0">
                                <i class="fas {{ $f['icon'] }} text-[#FDB813] text-xs"></i>
                            </div>
                            <span class="text-white/70 text-[13px]">{{ $f['text'] }}</span>
                        </div>
                    @endforeach
                </div>
            </div>

            {{-- Bottom attribution --}}
            <p class="text-white/25 text-[11px]">© {{ date('Y') }} PLN DIGI — Lomba PLN Digital Innovation</p>
        </div>
    </div>

    {{-- ══ RIGHT PANEL: Login Form ══ --}}
    <div class="flex-1 flex flex-col justify-center px-8 sm:px-14 lg:px-16 py-12 bg-white">

        {{-- Mobile Logo --}}
        <div class="flex items-center gap-3 mb-10 lg:hidden">
            <div class="w-9 h-9 bg-[#FDB813] rounded-xl flex items-center justify-center">
                <i class="fas fa-bolt text-[#001a4d] text-sm"></i>
            </div>
            <span class="text-[17px] font-extrabold text-[#00529C]">PLN<span class="text-[#FDB813]">DIGI</span></span>
        </div>

        <div class="w-full max-w-[400px]">

            {{-- Header --}}
            <div class="mb-8">
                <h2 class="text-[1.75rem] font-extrabold text-slate-900 tracking-tight mb-1.5">Masuk ke akun</h2>
                <p class="text-slate-500 text-[14px]">
                    Belum punya akun?
                    <a href="{{ route('register') }}" class="text-[#00529C] font-semibold hover:underline ml-0.5">Daftar sekarang</a>
                </p>
            </div>

            {{-- Session Status --}}
            <x-auth-session-status class="mb-5" :status="session('status')" />

            <form method="POST" action="{{ route('login') }}" class="space-y-5">
                @csrf

                {{-- Email --}}
                <div>
                    <label for="email" class="block text-[13px] font-semibold text-slate-700 mb-1.5">
                        Alamat Email
                    </label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                            <i class="fas fa-envelope text-slate-400 text-[13px]"></i>
                        </div>
                        <input
                            id="email"
                            type="email"
                            name="email"
                            value="{{ old('email') }}"
                            required
                            autofocus
                            autocomplete="username"
                            placeholder="contoh@email.com"
                            class="w-full pl-10 pr-4 py-3 text-[14px] text-slate-800 bg-slate-50 border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-[#00529C]/30 focus:border-[#00529C] transition placeholder-slate-400 @error('email') border-red-400 bg-red-50 @enderror"
                        >
                    </div>
                    @error('email')
                        <p class="mt-1.5 text-[12px] text-red-500 flex items-center gap-1"><i class="fas fa-exclamation-circle"></i> {{ $message }}</p>
                    @enderror
                </div>

                {{-- Password --}}
                <div>
                    <div class="flex items-center justify-between mb-1.5">
                        <label for="password" class="block text-[13px] font-semibold text-slate-700">
                            Password
                        </label>
                        @if (Route::has('password.request'))
                            <a href="{{ route('password.request') }}" class="text-[12px] text-[#00529C] hover:underline font-medium">
                                Lupa password?
                            </a>
                        @endif
                    </div>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                            <i class="fas fa-lock text-slate-400 text-[13px]"></i>
                        </div>
                        <input
                            id="password"
                            type="password"
                            name="password"
                            required
                            autocomplete="current-password"
                            placeholder="••••••••"
                            class="w-full pl-10 pr-12 py-3 text-[14px] text-slate-800 bg-slate-50 border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-[#00529C]/30 focus:border-[#00529C] transition placeholder-slate-400 @error('password') border-red-400 bg-red-50 @enderror"
                        >
                        {{-- Toggle password --}}
                        <button type="button" onclick="togglePassword()" class="absolute inset-y-0 right-0 pr-3.5 flex items-center text-slate-400 hover:text-slate-600 transition">
                            <i id="eye-icon" class="fas fa-eye text-[13px]"></i>
                        </button>
                    </div>
                    @error('password')
                        <p class="mt-1.5 text-[12px] text-red-500 flex items-center gap-1"><i class="fas fa-exclamation-circle"></i> {{ $message }}</p>
                    @enderror
                </div>

                {{-- Remember Me --}}
                <div class="flex items-center gap-2.5">
                    <input
                        id="remember_me"
                        type="checkbox"
                        name="remember"
                        class="w-4 h-4 rounded border-slate-300 text-[#00529C] focus:ring-[#00529C]/30 cursor-pointer"
                    >
                    <label for="remember_me" class="text-[13px] text-slate-600 cursor-pointer select-none">
                        Ingat saya di perangkat ini
                    </label>
                </div>

                {{-- Submit --}}
                <button
                    type="submit"
                    class="w-full py-3.5 px-6 bg-[#00529C] hover:bg-[#003d75] text-white text-[14px] font-bold rounded-xl transition-all duration-200 flex items-center justify-center gap-2 shadow-md hover:shadow-lg active:scale-[0.98]"
                >
                    <i class="fas fa-sign-in-alt text-sm"></i>
                    Masuk Sekarang
                </button>
            </form>

            {{-- Divider --}}
            <div class="flex items-center gap-3 my-7">
                <div class="flex-1 h-px bg-slate-200"></div>
                <span class="text-slate-400 text-[12px] font-medium">atau</span>
                <div class="flex-1 h-px bg-slate-200"></div>
            </div>

            {{-- Back to home --}}
            <a href="/" class="w-full flex items-center justify-center gap-2 py-3 px-6 border border-slate-200 rounded-xl text-slate-600 text-[13px] font-medium hover:bg-slate-50 hover:border-slate-300 transition-all duration-200">
                <i class="fas fa-arrow-left text-xs text-slate-400"></i>
                Kembali ke Beranda
            </a>

        </div>
    </div>
</div>

<script>
    function togglePassword() {
        const input = document.getElementById('password');
        const icon = document.getElementById('eye-icon');
        if (input.type === 'password') {
            input.type = 'text';
            icon.className = 'fas fa-eye-slash text-[13px]';
        } else {
            input.type = 'password';
            icon.className = 'fas fa-eye text-[13px]';
        }
    }
</script>
</body>
</html>

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'PLN DIGI') }} — Daftar Akun</title>

    <!-- Google Fonts (Inter & Plus Jakarta Sans) -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&family=Plus+Jakarta+Sans:ital,wght@0,200..800;1,200..800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-white">

<div class="min-h-screen flex">

    {{-- ══ LEFT PANEL: Branding (hidden on mobile) ══ --}}
    <div class="hidden lg:flex lg:w-[50%] relative flex-col overflow-hidden bg-[#0F477E]">

        {{-- Background Gradient --}}
        <div class="absolute inset-0 bg-gradient-to-br from-[#2782C9] via-[#1561A8] to-[#0a2f5c]"></div>

        {{-- Background image overlay --}}
        <div class="absolute inset-0 bg-[url('/images/hero-pln-1.jpg')] bg-cover bg-center opacity-20 mix-blend-overlay"></div>
        <div class="absolute inset-0 bg-gradient-to-t from-[#0a2f5c]/85 via-transparent to-transparent"></div>

        {{-- Decorative Circles --}}
        <div class="absolute -top-24 -left-24 w-72 h-72 bg-[#FDB813]/10 rounded-full blur-3xl"></div>
        <div class="absolute bottom-0 right-0 w-96 h-96 bg-[#2782C9]/30 rounded-full blur-3xl translate-x-1/3 translate-y-1/3"></div>

        {{-- PLN Worker Image --}}
        <div class="absolute inset-0 flex items-end justify-center">
            <img src="{{ asset('images/thumbnail-pln.png') }}"
                 alt="PLN Worker"
                 class="w-full h-full object-cover object-center opacity-30">
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
                <div class="inline-flex items-center gap-2 px-3 py-1.5 bg-white/10 border border-white/20 rounded-full mb-6 w-fit backdrop-blur-sm">
                    <span class="w-1.5 h-1.5 bg-[#FDB813] rounded-full animate-pulse"></span>
                    <span class="text-[10px] font-bold uppercase tracking-widest text-white/80">Bergabung Bersama Kami</span>
                </div>

                <h1 class="text-[2.3rem] font-extrabold text-white leading-[1.18] mb-4 tracking-tight">
                    Mulai nikmati kemudahan<br>
                    layanan listrik digital<br>
                    <span class="text-[#FDB813]">dalam satu sentuhan</span>
                </h1>

                <p class="text-white/60 text-[14px] leading-relaxed max-w-sm mb-8">
                    Daftar akun sekarang untuk memantau konsumsi listrik, bayar tagihan tepat waktu, dan nikmati program reward eksklusif.
                </p>

                {{-- Feature Pills --}}
                <div class="flex flex-col gap-3.5">
                    @php
                        $benefits = [
                            ['icon' => 'fa-bolt',          'title' => 'Kemudahan Akses', 'desc' => 'Beli token & bayar tagihan 24/7 instan'],
                            ['icon' => 'fa-chart-line',    'title' => 'Monitoring Hemat', 'desc' => 'Pantau riwayat pemakaian & catat meter mandiri'],
                            ['icon' => 'fa-gift',          'title' => 'PLN Point Reward', 'desc' => 'Kumpulkan poin dan tukarkan diskon menarik'],
                        ];
                    @endphp
                    @foreach($benefits as $b)
                        <div class="flex items-center gap-3.5 bg-white/5 border border-white/10 p-3 rounded-xl backdrop-blur-sm max-w-sm">
                            <div class="w-9 h-9 rounded-lg bg-[#FDB813]/20 border border-[#FDB813]/30 flex items-center justify-center flex-shrink-0">
                                <i class="fas {{ $b['icon'] }} text-[#FDB813] text-sm"></i>
                            </div>
                            <div>
                                <h4 class="text-white text-[13px] font-bold leading-tight">{{ $b['title'] }}</h4>
                                <p class="text-white/60 text-[11px] leading-tight mt-0.5">{{ $b['desc'] }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            {{-- Bottom attribution --}}
            <p class="text-white/30 text-[11px]">© {{ date('Y') }} PLN DIGI — Solusi Energi Masa Depan</p>
        </div>
    </div>

    {{-- ══ RIGHT PANEL: Register Form ══ --}}
    <div class="flex-1 flex flex-col justify-center px-8 sm:px-14 lg:px-16 py-10 bg-white overflow-y-auto">

        {{-- Mobile Logo --}}
        <div class="flex items-center gap-3 mb-8 lg:hidden">
            <div class="w-9 h-9 bg-[#FDB813] rounded-xl flex items-center justify-center">
                <i class="fas fa-bolt text-[#001a4d] text-sm"></i>
            </div>
            <span class="text-[17px] font-extrabold text-[#00529C]">PLN<span class="text-[#FDB813]">DIGI</span></span>
        </div>

        <div class="w-full max-w-[420px] mx-auto lg:mx-0">

            {{-- Header --}}
            <div class="mb-6">
                <h2 class="text-[1.75rem] font-extrabold text-slate-900 tracking-tight mb-1.5">Buat Akun Baru</h2>
                <p class="text-slate-500 text-[14px]">
                    Sudah memiliki akun?
                    <a href="{{ route('login') }}" class="text-[#00529C] font-semibold hover:underline ml-0.5">Masuk di sini</a>
                </p>
            </div>

            <form method="POST" action="{{ route('register') }}" class="space-y-4">
                @csrf

                {{-- Name --}}
                <div>
                    <label for="name" class="block text-[13px] font-semibold text-slate-700 mb-1.5">
                        Nama Lengkap
                    </label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                            <i class="fas fa-user text-slate-400 text-[13px]"></i>
                        </div>
                        <input
                            id="name"
                            type="text"
                            name="name"
                            value="{{ old('name') }}"
                            required
                            autofocus
                            autocomplete="name"
                            placeholder="Contoh: Budi Santoso"
                            class="w-full pl-10 pr-4 py-3 text-[14px] text-slate-800 bg-slate-50 border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-[#00529C]/30 focus:border-[#00529C] transition placeholder-slate-400 @error('name') border-red-400 bg-red-50 @enderror"
                        >
                    </div>
                    @error('name')
                        <p class="mt-1.5 text-[12px] text-red-500 flex items-center gap-1"><i class="fas fa-exclamation-circle"></i> {{ $message }}</p>
                    @enderror
                </div>

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
                            autocomplete="username"
                            placeholder="nama@email.com"
                            class="w-full pl-10 pr-4 py-3 text-[14px] text-slate-800 bg-slate-50 border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-[#00529C]/30 focus:border-[#00529C] transition placeholder-slate-400 @error('email') border-red-400 bg-red-50 @enderror"
                        >
                    </div>
                    @error('email')
                        <p class="mt-1.5 text-[12px] text-red-500 flex items-center gap-1"><i class="fas fa-exclamation-circle"></i> {{ $message }}</p>
                    @enderror
                </div>

                {{-- Password --}}
                <div>
                    <label for="password" class="block text-[13px] font-semibold text-slate-700 mb-1.5">
                        Kata Sandi
                    </label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                            <i class="fas fa-lock text-slate-400 text-[13px]"></i>
                        </div>
                        <input
                            id="password"
                            type="password"
                            name="password"
                            required
                            autocomplete="new-password"
                            placeholder="Minimal 8 karakter"
                            class="w-full pl-10 pr-12 py-3 text-[14px] text-slate-800 bg-slate-50 border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-[#00529C]/30 focus:border-[#00529C] transition placeholder-slate-400 @error('password') border-red-400 bg-red-50 @enderror"
                        >
                        {{-- Toggle password --}}
                        <button type="button" onclick="togglePasswordVisibility('password', 'eye-password')" class="absolute inset-y-0 right-0 pr-3.5 flex items-center text-slate-400 hover:text-slate-600 transition">
                            <i id="eye-password" class="fas fa-eye text-[13px]"></i>
                        </button>
                    </div>
                    @error('password')
                        <p class="mt-1.5 text-[12px] text-red-500 flex items-center gap-1"><i class="fas fa-exclamation-circle"></i> {{ $message }}</p>
                    @enderror
                </div>

                {{-- Confirm Password --}}
                <div>
                    <label for="password_confirmation" class="block text-[13px] font-semibold text-slate-700 mb-1.5">
                        Konfirmasi Kata Sandi
                    </label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                            <i class="fas fa-shield-alt text-slate-400 text-[13px]"></i>
                        </div>
                        <input
                            id="password_confirmation"
                            type="password"
                            name="password_confirmation"
                            required
                            autocomplete="new-password"
                            placeholder="Ulangi kata sandi Anda"
                            class="w-full pl-10 pr-12 py-3 text-[14px] text-slate-800 bg-slate-50 border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-[#00529C]/30 focus:border-[#00529C] transition placeholder-slate-400 @error('password_confirmation') border-red-400 bg-red-50 @enderror"
                        >
                        {{-- Toggle password confirm --}}
                        <button type="button" onclick="togglePasswordVisibility('password_confirmation', 'eye-confirm')" class="absolute inset-y-0 right-0 pr-3.5 flex items-center text-slate-400 hover:text-slate-600 transition">
                            <i id="eye-confirm" class="fas fa-eye text-[13px]"></i>
                        </button>
                    </div>
                    @error('password_confirmation')
                        <p class="mt-1.5 text-[12px] text-red-500 flex items-center gap-1"><i class="fas fa-exclamation-circle"></i> {{ $message }}</p>
                    @enderror
                </div>

                {{-- Terms Checkbox --}}
                <div class="pt-1">
                    <label class="flex items-start gap-2.5 cursor-pointer select-none">
                        <input
                            type="checkbox"
                            required
                            name="terms"
                            class="w-4 h-4 mt-0.5 rounded border-slate-300 text-[#00529C] focus:ring-[#00529C]/30 cursor-pointer"
                        >
                        <span class="text-[12px] text-slate-600 leading-normal">
                            Saya menyetujui <span class="text-[#00529C] font-semibold">Syarat & Ketentuan</span> serta Kebijakan Privasi PLN DIGI.
                        </span>
                    </label>
                </div>

                {{-- Submit --}}
                <div class="pt-2">
                    <button
                        type="submit"
                        class="w-full py-3.5 px-6 bg-[#00529C] hover:bg-[#003d75] text-white text-[14px] font-bold rounded-xl transition-all duration-200 flex items-center justify-center gap-2 shadow-md hover:shadow-lg active:scale-[0.98]"
                    >
                        <i class="fas fa-user-plus text-sm"></i>
                        Daftar Akun Sekarang
                    </button>
                </div>
            </form>

            {{-- Divider --}}
            <div class="flex items-center gap-3 my-6">
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
    function togglePasswordVisibility(inputId, iconId) {
        const input = document.getElementById(inputId);
        const icon = document.getElementById(iconId);
        if (!input || !icon) return;

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

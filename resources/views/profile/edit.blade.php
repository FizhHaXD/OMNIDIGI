@extends('layouts.main')
@section('title', 'Pengaturan Profil - PLN DIGI')

@section('content')
{{-- Header --}}
<section class="relative -mt-16 md:-mt-18 bg-gradient-to-br from-[#001230] via-[#00265a] to-[#001a4d] text-white overflow-hidden">
    <div class="absolute inset-0 opacity-10">
        <div class="absolute top-10 right-10 w-72 h-72 bg-[#FDB813] rounded-full blur-[120px]"></div>
    </div>
    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-32 pb-10 md:pt-36 md:pb-14">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <div class="flex items-center gap-4">
                <div class="w-14 h-14 rounded-2xl bg-white/10 backdrop-blur-sm flex items-center justify-center border border-white/10 text-[#FDB813] text-2xl overflow-hidden shadow-sm">
                    @if($user->avatar_url)
                        <img src="{{ $user->avatar_url }}" alt="{{ $user->name }}" class="w-full h-full object-cover">
                    @else
                        <i class="fas fa-user-circle"></i>
                    @endif
                </div>
                <div>
                    <h1 class="text-2xl md:text-3xl font-bold">Pengaturan Akun & Profil</h1>
                    <p class="text-white/60 text-sm mt-0.5">Kelola informasi data pribadi dan keamanan akun PLN DIGI Anda</p>
                </div>
            </div>
            <div class="flex items-center gap-2">
                @if($user->isAdmin())
                    <a href="{{ route('admin.dashboard') }}" class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl bg-[#00529C] hover:bg-[#003d75] text-white text-sm font-semibold transition border border-white/20 shadow-sm">
                        <i class="fas fa-shield-alt text-[#FDB813]"></i>
                        <span>Panel Admin</span>
                    </a>
                @endif
                <a href="{{ route('dashboard') }}" class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl bg-white/10 hover:bg-white/20 text-white text-sm font-medium transition backdrop-blur-sm border border-white/10">
                    <i class="fas fa-arrow-left text-xs"></i>
                    <span>Kembali ke Dashboard</span>
                </a>
            </div>
        </div>
    </div>
</section>

{{-- Content --}}
<section class="py-8 md:py-12 bg-slate-50 min-h-[60vh]">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8">
        
        {{-- Card: Akses Administrator --}}
        @if($user->isAdmin())
            <div class="bg-white rounded-2xl shadow-sm border border-slate-200/80 p-6 sm:p-8 flex flex-col sm:flex-row sm:items-center justify-between gap-5 border-l-4 border-l-[#00529C]">
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 rounded-xl bg-blue-50 border border-blue-100 flex items-center justify-center text-[#00529C] text-xl flex-shrink-0">
                        <i class="fas fa-shield-alt"></i>
                    </div>
                    <div>
                        <div class="flex items-center gap-2">
                            <h2 class="text-base sm:text-lg font-bold text-slate-900">Panel Administrator</h2>
                            <span class="px-2 py-0.5 rounded text-[10px] font-bold bg-amber-100 text-amber-800 uppercase">Akses Khusus</span>
                        </div>
                        <p class="text-slate-500 text-xs sm:text-sm mt-0.5">Kelola data pelanggan, tiket gangguan, audit meter, transaksi, dan surat kedinasan AI.</p>
                    </div>
                </div>
                <div>
                    <a href="{{ route('admin.dashboard') }}" class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl bg-[#00529C] hover:bg-[#003d75] text-white text-sm font-bold transition shadow-sm whitespace-nowrap">
                        <span>Buka Panel Admin</span>
                        <i class="fas fa-arrow-right text-xs"></i>
                    </a>
                </div>
            </div>
        @endif

        {{-- Card: Informasi Profil --}}
        <div class="bg-white rounded-2xl shadow-sm border border-slate-200/80 p-6 sm:p-8">
            <div class="max-w-xl">
                @include('profile.partials.update-profile-information-form')
            </div>
        </div>

        {{-- Card: Ubah Password --}}
        <div class="bg-white rounded-2xl shadow-sm border border-slate-200/80 p-6 sm:p-8">
            <div class="max-w-xl">
                @include('profile.partials.update-password-form')
            </div>
        </div>

        {{-- Card: Hapus Akun --}}
        <div class="bg-white rounded-2xl shadow-sm border border-red-100 p-6 sm:p-8">
            <div class="max-w-xl">
                @include('profile.partials.delete-user-form')
            </div>
        </div>

    </div>
</section>
@endsection

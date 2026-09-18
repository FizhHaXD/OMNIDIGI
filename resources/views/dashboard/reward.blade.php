@extends('layouts.main')
@section('title', 'PLN Reward - PLN DIGI')

@section('content')
<section class="relative -mt-16 md:-mt-18 bg-gradient-to-br from-[#001230] via-[#00265a] to-[#001a4d] text-white overflow-hidden">
    <div class="absolute inset-0 opacity-10">
        <div class="absolute top-10 right-20 w-60 h-60 bg-[#FDB813] rounded-full blur-[100px]"></div>
    </div>
    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-32 pb-8 md:pt-36 md:pb-10">
        <a href="{{ route('dashboard') }}" class="inline-flex items-center text-white/50 hover:text-white text-sm mb-3 transition-colors">
            <i class="fas fa-arrow-left mr-2"></i> Kembali ke Dashboard
        </a>
        <h1 class="text-2xl md:text-3xl font-bold">PLN Reward</h1>
        <p class="text-white/50 mt-1 text-sm">Kumpulkan poin dari setiap transaksi dan tukar dengan hadiah menarik.</p>
    </div>
</section>

<section class="py-8 md:py-10">
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">

        {{-- Poin & Tier Card --}}
        <div class="bg-gradient-to-r from-[#00529C] to-[#003d75] rounded-2xl p-8 text-white mb-8 shadow-xl relative overflow-hidden">
            <div class="absolute top-0 right-0 w-40 h-40 bg-white/5 rounded-full -translate-y-1/2 translate-x-1/2"></div>
            <div class="relative flex flex-col md:flex-row md:items-center md:justify-between gap-6">
                <div>
                    <p class="text-white/50 text-xs uppercase tracking-widest mb-2">Total Poin Anda</p>
                    <p class="text-5xl font-extrabold tracking-tight" style="color: {{ $tierColor }}">{{ number_format($totalPoin, 0, ',', '.') }}</p>
                    <div class="flex items-center gap-2 mt-2">
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold" style="background: {{ $tierColor }}20; color: {{ $tierColor }}">
                            <i class="fas fa-crown mr-1.5"></i> {{ $tier }}
                        </span>
                        <span class="text-white/50 text-xs">• {{ $totalTransaksi }} transaksi berhasil</span>
                    </div>
                </div>
                <div class="bg-white/10 backdrop-blur-sm rounded-xl px-6 py-4 border border-white/10">
                    <p class="text-white/50 text-[11px] uppercase tracking-wider mb-1">Total Belanja</p>
                    <p class="text-xl font-bold">Rp {{ number_format($totalNominal, 0, ',', '.') }}</p>
                </div>
            </div>
        </div>

        {{-- Cara Dapat Poin --}}
        <div class="card p-6 mb-8">
            <h2 class="text-lg font-bold text-slate-900 mb-4">Cara Mendapat Poin</h2>
            <div class="grid md:grid-cols-2 gap-4">
                <div class="flex items-start gap-3 p-4 bg-slate-50 rounded-xl">
                    <div class="w-9 h-9 bg-[#00529C]/10 rounded-lg flex items-center justify-center flex-shrink-0">
                        <i class="fas fa-check text-[#00529C] text-sm"></i>
                    </div>
                    <div>
                        <p class="text-sm font-semibold text-slate-700">Transaksi Berhasil</p>
                        <p class="text-xs text-slate-500">+10 poin setiap transaksi yang berhasil</p>
                    </div>
                </div>
                <div class="flex items-start gap-3 p-4 bg-slate-50 rounded-xl">
                    <div class="w-9 h-9 bg-[#FDB813]/15 rounded-lg flex items-center justify-center flex-shrink-0">
                        <i class="fas fa-coins text-[#FDB813] text-sm"></i>
                    </div>
                    <div>
                        <p class="text-sm font-semibold text-slate-700">Bonus Nominal</p>
                        <p class="text-xs text-slate-500">+5 poin setiap kelipatan Rp 100.000</p>
                    </div>
                </div>
            </div>
        </div>

        {{-- Benefit List --}}
        <h2 class="text-lg font-bold text-slate-900 mb-4">Tukar Poin</h2>
        <div class="grid md:grid-cols-2 gap-4">
            @foreach($benefits as $benefit)
            <div class="card p-5 flex items-center gap-4 {{ $benefit['available'] ? '' : 'opacity-50' }}">
                <div class="w-12 h-12 rounded-2xl flex items-center justify-center flex-shrink-0 {{ $benefit['available'] ? 'bg-[#FDB813]/15' : 'bg-slate-100' }}">
                    <i class="fas {{ $benefit['icon'] }} {{ $benefit['available'] ? 'text-[#FDB813]' : 'text-slate-300' }} text-lg"></i>
                </div>
                <div class="flex-1">
                    <p class="text-sm font-semibold text-slate-700">{{ $benefit['nama'] }}</p>
                    <p class="text-xs text-slate-500">{{ number_format($benefit['poin'], 0, ',', '.') }} poin</p>
                </div>
                @if($benefit['available'])
                    <button class="px-4 py-2 bg-[#00529C] text-white text-xs font-semibold rounded-lg hover:bg-[#003d75] transition-colors">
                        Tukar
                    </button>
                @else
                    <span class="px-3 py-1.5 bg-slate-100 text-slate-400 text-xs font-medium rounded-lg">Poin Kurang</span>
                @endif
            </div>
            @endforeach
        </div>

        <div class="mt-6 p-4 bg-amber-50 border border-amber-200 rounded-xl">
            <p class="text-xs text-amber-700"><i class="fas fa-info-circle mr-1.5"></i> Fitur tukar poin masih dalam tahap pengembangan. Poin Anda akan tetap tersimpan.</p>
        </div>
    </div>
</section>
@endsection

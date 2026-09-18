@extends('layouts.main')
@section('title', 'Beli Token Listrik - PLN DIGI')

@section('content')
{{-- Header --}}
<section class="relative -mt-16 md:-mt-18 bg-gradient-to-br from-[#001230] via-[#00265a] to-[#001a4d] text-white overflow-hidden">
    <div class="absolute inset-0 bg-[url('https://images.unsplash.com/photo-1473341304170-971dccb5ac1e?w=1920&q=80')] bg-cover bg-center opacity-10 mix-blend-luminosity"></div>
    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-32 pb-16 md:pt-36 md:pb-20">
        <span class="inline-flex items-center gap-2 px-4 py-1.5 bg-white/10 rounded-full text-[#FDB813] text-xs font-semibold uppercase tracking-wider mb-4 border border-white/10">
            Token Listrik
        </span>
        <h1 class="text-3xl md:text-4xl font-bold">Beli Token Listrik</h1>
        <p class="text-white/50 mt-2">Isi ulang token listrik prabayar Anda kapan saja.</p>
    </div>
</section>

<section class="py-12 md:py-16">
    <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="card p-7">
            <form action="{{ route('produk.bayar') }}" method="POST">
                @csrf
                <input type="hidden" name="type" value="token">

                {{-- No Meter --}}
                <div class="mb-6">
                    <label class="form-label">Nomor Meter / ID Pelanggan</label>
                    <input type="text" name="no_meter" class="form-input" placeholder="Contoh: 5312 0001 2345" required>
                    @error('no_meter')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Nominal --}}
                <div class="mb-6">
                    <label class="form-label">Pilih Nominal</label>
                    @php
                        $nominals = [20000, 50000, 100000, 200000, 500000, 1000000];
                    @endphp
                    <div class="grid grid-cols-3 gap-3">
                        @foreach($nominals as $nom)
                            <label class="relative flex items-center justify-center p-3.5 rounded-xl border border-slate-200 cursor-pointer hover:border-[#FDB813]/60 hover:bg-[#FDB813]/5 transition-all has-[:checked]:border-[#FDB813] has-[:checked]:bg-[#FDB813]/10">
                                <input type="radio" name="amount" value="{{ $nom }}" class="sr-only" {{ $loop->index === 1 ? 'checked' : '' }}>
                                <span class="font-semibold text-slate-800 text-sm">Rp {{ number_format($nom, 0, ',', '.') }}</span>
                            </label>
                        @endforeach
                    </div>
                    @error('amount')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Payment Method --}}
                <div class="mb-6">
                    <label class="form-label">Metode Pembayaran</label>
                    <div class="grid grid-cols-3 gap-3">
                        <label class="flex flex-col items-center gap-2 p-3.5 rounded-xl border border-slate-200 cursor-pointer hover:border-[#00529C]/40 hover:bg-[#00529C]/5 transition-all has-[:checked]:border-[#00529C] has-[:checked]:bg-[#00529C]/5">
                            <input type="radio" name="payment_method" value="qris" class="sr-only" checked>
                            <i class="fas fa-qrcode text-xl text-[#00529C]"></i>
                            <span class="text-xs font-medium text-slate-700">QRIS</span>
                        </label>
                        <label class="flex flex-col items-center gap-2 p-3.5 rounded-xl border border-slate-200 cursor-pointer hover:border-[#00529C]/40 hover:bg-[#00529C]/5 transition-all has-[:checked]:border-[#00529C] has-[:checked]:bg-[#00529C]/5">
                            <input type="radio" name="payment_method" value="ewallet" class="sr-only">
                            <i class="fas fa-wallet text-xl text-[#00529C]"></i>
                            <span class="text-xs font-medium text-slate-700">E-Wallet</span>
                        </label>
                        <label class="flex flex-col items-center gap-2 p-3.5 rounded-xl border border-slate-200 cursor-pointer hover:border-[#00529C]/40 hover:bg-[#00529C]/5 transition-all has-[:checked]:border-[#00529C] has-[:checked]:bg-[#00529C]/5">
                            <input type="radio" name="payment_method" value="transfer" class="sr-only">
                            <i class="fas fa-university text-xl text-[#00529C]"></i>
                            <span class="text-xs font-medium text-slate-700">Transfer</span>
                        </label>
                    </div>
                </div>

                @auth
                    <button type="submit" class="btn-secondary w-full">
                        <i class="fas fa-bolt text-xs"></i> Beli Token
                    </button>
                @else
                    <a href="{{ route('login') }}" class="btn-blue w-full text-center">
                        Masuk untuk Beli Token
                    </a>
                @endauth
            </form>
        </div>
    </div>
</section>
@endsection

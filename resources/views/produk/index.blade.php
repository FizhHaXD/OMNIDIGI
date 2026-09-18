@extends('layouts.main')
@section('title', 'Produk & Layanan - PLN DIGI')

@section('content')
{{-- Header --}}
<section class="relative -mt-16 md:-mt-18 bg-gradient-to-br from-[#001230] via-[#00265a] to-[#001a4d] text-white overflow-hidden">
    <div class="absolute inset-0 bg-[url('https://images.unsplash.com/photo-1473341304170-971dccb5ac1e?w=1920&q=80')] bg-cover bg-center opacity-10 mix-blend-luminosity"></div>
    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-32 pb-16 md:pt-36 md:pb-20">
        <span class="inline-flex items-center gap-2 px-4 py-1.5 bg-white/10 rounded-full text-[#FDB813] text-xs font-semibold uppercase tracking-wider mb-4 border border-white/10">
            Produk & Layanan
        </span>
        <h1 class="text-3xl md:text-4xl font-bold">Pilih Layanan Anda</h1>
        <p class="text-white/50 mt-2">Bayar tagihan atau beli token listrik dengan mudah.</p>
    </div>
</section>

<section class="py-14 md:py-20">
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid md:grid-cols-2 gap-6">
            {{-- Bayar Tagihan --}}
            <a href="{{ route('produk.tagihan') }}" class="card p-8 text-center group">
                <div class="w-16 h-16 bg-[#00529C]/8 rounded-2xl flex items-center justify-center mx-auto mb-5 group-hover:bg-[#00529C]/15 transition-colors">
                    <i class="fas fa-file-invoice-dollar text-[#00529C] text-2xl"></i>
                </div>
                <h2 class="text-xl font-bold text-slate-900 mb-2">Bayar Tagihan</h2>
                <p class="text-slate-500 text-sm leading-relaxed mb-5">Bayar tagihan listrik pascabayar bulanan Anda dengan berbagai metode pembayaran.</p>
                <span class="btn-blue text-sm">
                    Bayar Sekarang <i class="fas fa-arrow-right text-xs ml-1"></i>
                </span>
            </a>

            {{-- Beli Token --}}
            <a href="{{ route('produk.token') }}" class="card p-8 text-center group">
                <div class="w-16 h-16 bg-[#FDB813]/15 rounded-2xl flex items-center justify-center mx-auto mb-5 group-hover:bg-[#FDB813]/25 transition-colors">
                    <i class="fas fa-bolt text-[#FDB813] text-2xl"></i>
                </div>
                <h2 class="text-xl font-bold text-slate-900 mb-2">Beli Token</h2>
                <p class="text-slate-500 text-sm leading-relaxed mb-5">Isi ulang token listrik prabayar Anda kapan saja dengan pilihan nominal mulai Rp 20.000.</p>
                <span class="btn-secondary text-sm">
                    Beli Token <i class="fas fa-arrow-right text-xs ml-1"></i>
                </span>
            </a>
        </div>
    </div>
</section>
@endsection

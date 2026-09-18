@extends('layouts.main')
@section('title', 'Token Saya - PLN DIGI')

@section('content')
<section class="relative -mt-16 md:-mt-18 bg-gradient-to-br from-[#001230] via-[#00265a] to-[#001a4d] text-white overflow-hidden">
    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-32 pb-8 md:pt-36 md:pb-10">
        <a href="{{ route('dashboard') }}" class="inline-flex items-center text-white/50 hover:text-white text-sm mb-3 transition-colors">
            <i class="fas fa-arrow-left mr-2"></i> Kembali ke Dashboard
        </a>
        <h1 class="text-2xl md:text-3xl font-bold">Token Saya</h1>
        <p class="text-white/50 mt-1 text-sm">Riwayat pembelian token listrik prabayar Anda.</p>
    </div>
</section>

<section class="py-8 md:py-10">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-end mb-5">
            <a href="{{ route('produk.token') }}" class="btn-primary text-sm">
                <i class="fas fa-bolt mr-1.5"></i> Beli Token Baru
            </a>
        </div>

        @if($tokens->isEmpty())
            <div class="card p-10 text-center">
                <div class="w-14 h-14 bg-[#FDB813]/15 rounded-2xl flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-bolt text-[#FDB813] text-xl"></i>
                </div>
                <p class="text-slate-400 text-sm mb-3">Belum ada riwayat pembelian token.</p>
                <a href="{{ route('produk.token') }}" class="btn-primary inline-flex text-sm">Beli Token Sekarang</a>
            </div>
        @else
            <div class="card overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead>
                            <tr class="border-b border-slate-100 bg-slate-50/50">
                                <th class="px-5 py-3 text-left text-[11px] font-semibold text-slate-400 uppercase tracking-wider">Tanggal</th>
                                <th class="px-5 py-3 text-left text-[11px] font-semibold text-slate-400 uppercase tracking-wider">Nominal</th>
                                <th class="px-5 py-3 text-left text-[11px] font-semibold text-slate-400 uppercase tracking-wider">Token Listrik</th>
                                <th class="px-5 py-3 text-left text-[11px] font-semibold text-slate-400 uppercase tracking-wider">Metode Bayar</th>
                                <th class="px-5 py-3 text-left text-[11px] font-semibold text-slate-400 uppercase tracking-wider">Status</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-50">
                            @foreach($tokens as $t)
                            <tr class="hover:bg-slate-50/50 transition-colors">
                                <td class="px-5 py-3.5 text-sm text-slate-500">{{ $t->created_at->format('d M Y H:i') }}</td>
                                <td class="px-5 py-3.5 text-sm font-semibold text-slate-900">Rp {{ number_format($t->amount, 0, ',', '.') }}</td>
                                <td class="px-5 py-3.5 text-sm font-mono text-[#00529C]">{{ $t->token_listrik ?? '-' }}</td>
                                <td class="px-5 py-3.5 text-sm text-slate-500">{{ $t->paymentMethod->nama ?? '-' }}</td>
                                <td class="px-5 py-3.5">
                                    @if($t->status === 'success') <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-emerald-50 text-emerald-700">Berhasil</span>
                                    @elseif($t->status === 'pending') <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-amber-50 text-amber-700">Pending</span>
                                    @else <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-50 text-red-700">Gagal</span>
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
</section>
@endsection

@extends('layouts.main')
@section('title', 'Tagihan Saya - PLN DIGI')

@section('content')
<section class="relative -mt-16 md:-mt-18 bg-gradient-to-br from-[#001230] via-[#00265a] to-[#001a4d] text-white overflow-hidden">
    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-32 pb-8 md:pt-36 md:pb-10">
        <a href="{{ route('dashboard') }}" class="inline-flex items-center text-white/50 hover:text-white text-sm mb-3 transition-colors">
            <i class="fas fa-arrow-left mr-2"></i> Kembali ke Dashboard
        </a>
        <h1 class="text-2xl md:text-3xl font-bold">Tagihan Saya</h1>
        <p class="text-white/50 mt-1 text-sm">Daftar tagihan listrik Anda beserta status pembayarannya.</p>
    </div>
</section>

<section class="py-8 md:py-10">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">

        @if(!$customer)
            <div class="card p-10 text-center">
                <i class="fas fa-exclamation-circle text-amber-400 text-3xl mb-3"></i>
                <p class="text-slate-600">Anda belum memiliki data pelanggan PLN.</p>
            </div>
        @elseif($bills->isEmpty())
            <div class="card p-10 text-center">
                <div class="w-14 h-14 bg-slate-100 rounded-2xl flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-file-invoice text-slate-300 text-xl"></i>
                </div>
                <p class="text-slate-400 text-sm">Belum ada tagihan.</p>
            </div>
        @else
            {{-- Summary --}}
            @php
                $unpaid = $bills->whereIn('status', ['unpaid', 'overdue']);
                $totalUnpaid = $unpaid->sum('total_biaya') + $unpaid->sum('denda');
            @endphp
            @if($unpaid->isNotEmpty())
            <div class="bg-gradient-to-r from-red-500 to-rose-600 rounded-2xl p-6 text-white mb-6 shadow-lg">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-white/70 text-sm">Total Tagihan Belum Dibayar</p>
                        <p class="text-3xl font-bold mt-1">Rp {{ number_format($totalUnpaid, 0, ',', '.') }}</p>
                        <p class="text-white/60 text-xs mt-1">{{ $unpaid->count() }} tagihan tertunggak</p>
                    </div>
                    <a href="{{ route('produk.tagihan') }}" class="bg-white/20 hover:bg-white/30 backdrop-blur-sm px-5 py-2.5 rounded-xl text-sm font-semibold transition-colors">
                        Bayar Sekarang <i class="fas fa-arrow-right ml-1.5"></i>
                    </a>
                </div>
            </div>
            @endif

            {{-- Tabel Tagihan --}}
            <div class="card overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead>
                            <tr class="border-b border-slate-100 bg-slate-50/50">
                                <th class="px-5 py-3 text-left text-[11px] font-semibold text-slate-400 uppercase tracking-wider">Periode</th>
                                <th class="px-5 py-3 text-left text-[11px] font-semibold text-slate-400 uppercase tracking-wider">Pemakaian</th>
                                <th class="px-5 py-3 text-left text-[11px] font-semibold text-slate-400 uppercase tracking-wider">Total Biaya</th>
                                <th class="px-5 py-3 text-left text-[11px] font-semibold text-slate-400 uppercase tracking-wider">Denda</th>
                                <th class="px-5 py-3 text-left text-[11px] font-semibold text-slate-400 uppercase tracking-wider">Jatuh Tempo</th>
                                <th class="px-5 py-3 text-left text-[11px] font-semibold text-slate-400 uppercase tracking-wider">Status</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-50">
                            @foreach($bills as $bill)
                            <tr class="hover:bg-slate-50/50 transition-colors">
                                <td class="px-5 py-3.5 text-sm font-medium text-slate-700">{{ $bill->nama_bulan }} {{ $bill->tahun }}</td>
                                <td class="px-5 py-3.5 text-sm text-slate-500">{{ number_format($bill->total_kwh, 0, ',', '.') }} kWh</td>
                                <td class="px-5 py-3.5 text-sm font-semibold text-slate-900">Rp {{ number_format($bill->total_biaya, 0, ',', '.') }}</td>
                                <td class="px-5 py-3.5 text-sm {{ $bill->denda > 0 ? 'text-red-600 font-semibold' : 'text-slate-400' }}">
                                    {{ $bill->denda > 0 ? 'Rp ' . number_format($bill->denda, 0, ',', '.') : '-' }}
                                </td>
                                <td class="px-5 py-3.5 text-sm text-slate-500">{{ $bill->tanggal_jatuh_tempo?->format('d M Y') ?? '-' }}</td>
                                <td class="px-5 py-3.5">
                                    @if($bill->status === 'paid')
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-emerald-50 text-emerald-700"><i class="fas fa-check-circle mr-1"></i>Lunas</span>
                                    @elseif($bill->status === 'overdue')
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-50 text-red-700"><i class="fas fa-exclamation-circle mr-1"></i>Jatuh Tempo</span>
                                    @else
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-amber-50 text-amber-700"><i class="fas fa-clock mr-1"></i>Belum Bayar</span>
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

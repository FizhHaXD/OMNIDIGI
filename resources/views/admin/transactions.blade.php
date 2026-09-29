@extends('layouts.main')
@section('title', 'Audit Transaksi - Admin PLN DIGI')

@section('content')
{{-- Header --}}
<section class="relative -mt-16 md:-mt-18 bg-gradient-to-br from-[#001230] via-[#00265a] to-[#001a4d] text-white overflow-hidden">
    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-32 pb-8 md:pt-36 md:pb-10">
        <div class="flex flex-col md:flex-row md:items-end justify-between gap-6 mb-6">
            <div>
                <span class="inline-flex items-center gap-2 px-3.5 py-1 bg-white/10 rounded-full text-[#FDB813] text-xs font-semibold uppercase tracking-wider mb-3 border border-white/10">
                    <i class="fas fa-receipt"></i> Keuangan & Audit
                </span>
                <h1 class="text-3xl md:text-4xl font-extrabold tracking-tight">Audit Transaksi Pembayaran</h1>
                <p class="text-white/60 text-sm mt-1">Rekapitulasi transaksi pembayaran tagihan pascabayar dan token listrik.</p>
            </div>
        </div>

        {{-- Sub-Navigation Tabs --}}
        @include('admin.partials.nav')
    </div>
</section>

<section class="py-8 md:py-12 bg-slate-50/60 min-h-screen">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        {{-- Filter Box --}}
        <div class="card p-4 mb-6">
            <form method="GET" action="{{ route('admin.transactions') }}" class="flex flex-col md:flex-row gap-3">
                <div class="flex-1 relative">
                    <i class="fas fa-search absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400 text-xs"></i>
                    <input type="text" name="q" value="{{ request('q') }}" placeholder="Cari No. Referensi atau No. Meter..."
                           class="form-input text-xs pl-9 w-full rounded-xl">
                </div>
                <div class="w-full md:w-44">
                    <select name="type" class="form-input text-xs w-full rounded-xl" onchange="this.form.submit()">
                        <option value="">Semua Jenis</option>
                        <option value="tagihan" {{ request('type') === 'tagihan' ? 'selected' : '' }}>Tagihan Listrik</option>
                        <option value="token" {{ request('type') === 'token' ? 'selected' : '' }}>Token Prabayar</option>
                    </select>
                </div>
                <div class="w-full md:w-44">
                    <select name="status" class="form-input text-xs w-full rounded-xl" onchange="this.form.submit()">
                        <option value="">Semua Status</option>
                        <option value="success" {{ request('status') === 'success' ? 'selected' : '' }}>Berhasil</option>
                        <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="failed" {{ request('status') === 'failed' ? 'selected' : '' }}>Gagal</option>
                    </select>
                </div>
                <button type="submit" class="btn-primary text-xs py-2 px-4 whitespace-nowrap">
                    Filter
                </button>
                @if(request()->hasAny(['q', 'type', 'status']))
                    <a href="{{ route('admin.transactions') }}" class="btn-outline text-xs py-2 px-4 whitespace-nowrap text-slate-600">
                        Reset
                    </a>
                @endif
            </form>
        </div>

        {{-- Table Container --}}
        <div class="card overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr class="border-b border-slate-100 bg-slate-50/60">
                            <th class="px-5 py-3.5 text-left text-[11px] font-semibold text-slate-400 uppercase tracking-wider">Ref / Tanggal</th>
                            <th class="px-5 py-3.5 text-left text-[11px] font-semibold text-slate-400 uppercase tracking-wider">User / Pelanggan</th>
                            <th class="px-5 py-3.5 text-left text-[11px] font-semibold text-slate-400 uppercase tracking-wider">Jenis Transaksi</th>
                            <th class="px-5 py-3.5 text-left text-[11px] font-semibold text-slate-400 uppercase tracking-wider">No. Meter</th>
                            <th class="px-5 py-3.5 text-left text-[11px] font-semibold text-slate-400 uppercase tracking-wider">Jumlah</th>
                            <th class="px-5 py-3.5 text-left text-[11px] font-semibold text-slate-400 uppercase tracking-wider">Metode Bayar</th>
                            <th class="px-5 py-3.5 text-left text-[11px] font-semibold text-slate-400 uppercase tracking-wider">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-50">
                        @forelse($transactions as $trx)
                            <tr class="hover:bg-slate-50/50 transition-colors">
                                <td class="px-5 py-3.5">
                                    <p class="text-xs font-mono font-bold text-slate-900">{{ $trx->ref_number }}</p>
                                    <p class="text-[11px] text-slate-400">{{ $trx->created_at->format('d M Y, H:i') }} WIB</p>
                                </td>
                                <td class="px-5 py-3.5">
                                    <p class="text-xs font-bold text-slate-800">{{ $trx->customer->nama ?? ($trx->user->name ?? 'Pelanggan') }}</p>
                                    <p class="text-[11px] text-slate-400">{{ $trx->user->email ?? '-' }}</p>
                                </td>
                                <td class="px-5 py-3.5 text-xs font-semibold capitalize text-slate-700">
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-lg text-xs
                                        {{ $trx->type === 'tagihan' ? 'bg-blue-50 text-[#00529C]' : 'bg-amber-50 text-amber-800' }}">
                                        <i class="fas {{ $trx->type === 'tagihan' ? 'fa-file-invoice-dollar' : 'fa-bolt' }} text-[10px]"></i>
                                        {{ $trx->type }}
                                    </span>
                                </td>
                                <td class="px-5 py-3.5 text-xs font-mono text-slate-600">{{ $trx->no_meter }}</td>
                                <td class="px-5 py-3.5 text-xs font-black text-slate-900">
                                    Rp {{ number_format($trx->amount, 0, ',', '.') }}
                                </td>
                                <td class="px-5 py-3.5 text-xs font-medium text-slate-600">
                                    {{ $trx->paymentMethod->nama ?? strtoupper($trx->payment_method) }}
                                </td>
                                <td class="px-5 py-3.5">
                                    @if($trx->status === 'success')
                                        <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-xs font-semibold bg-emerald-50 text-emerald-700">
                                            <i class="fas fa-check-circle text-[10px]"></i> Berhasil
                                        </span>
                                    @elseif($trx->status === 'pending')
                                        <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-xs font-semibold bg-amber-50 text-amber-700">
                                            <i class="fas fa-clock text-[10px]"></i> Pending
                                        </span>
                                    @else
                                        <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-xs font-semibold bg-red-50 text-red-700">
                                            <i class="fas fa-times-circle text-[10px]"></i> Gagal
                                        </span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="px-5 py-12 text-center text-slate-400 text-sm">
                                    Tidak ada data transaksi yang ditemukan.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($transactions->hasPages())
                <div class="px-5 py-4 border-t border-slate-100 bg-slate-50/50">
                    {{ $transactions->links() }}
                </div>
            @endif
        </div>
    </div>
</section>
@endsection

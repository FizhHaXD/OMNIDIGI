@extends('layouts.main')
@section('title', 'Admin Dashboard - PLN DIGI')

@section('content')
{{-- Header --}}
<section class="relative -mt-16 md:-mt-18 bg-gradient-to-br from-[#001230] via-[#00265a] to-[#001a4d] text-white overflow-hidden">
    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-32 pb-16 md:pt-36 md:pb-20">
        <div class="flex items-end justify-between">
            <div>
                <span class="inline-flex items-center gap-2 px-4 py-1.5 bg-white/10 rounded-full text-[#FDB813] text-xs font-semibold uppercase tracking-wider mb-4 border border-white/10">
                    Admin Panel
                </span>
                <h1 class="text-3xl md:text-4xl font-bold">Dashboard Admin</h1>
                <p class="text-white/50 mt-2">Monitor data pelanggan dan transaksi.</p>
            </div>
            <div class="hidden md:flex gap-3">
                <a href="{{ route('admin.customers') }}" class="btn-outline text-sm py-2">Pelanggan</a>
                <a href="{{ route('admin.transactions') }}" class="btn-outline text-sm py-2">Transaksi</a>
            </div>
        </div>
    </div>
</section>

<section class="py-10 md:py-14">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        {{-- Stats --}}
        <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-10">
            <div class="stat-card">
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 bg-[#00529C]/8 rounded-xl flex items-center justify-center flex-shrink-0">
                        <i class="fas fa-users text-[#00529C] text-lg"></i>
                    </div>
                    <div>
                        <p class="text-xs text-slate-400">Pelanggan</p>
                        <p class="text-2xl font-extrabold text-slate-900">{{ number_format($stats['total_pelanggan']) }}</p>
                    </div>
                </div>
            </div>
            <div class="stat-card">
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 bg-[#FDB813]/15 rounded-xl flex items-center justify-center flex-shrink-0">
                        <i class="fas fa-exchange-alt text-[#FDB813] text-lg"></i>
                    </div>
                    <div>
                        <p class="text-xs text-slate-400">Transaksi</p>
                        <p class="text-2xl font-extrabold text-slate-900">{{ number_format($stats['total_transaksi']) }}</p>
                    </div>
                </div>
            </div>
            <div class="stat-card">
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 bg-emerald-50 rounded-xl flex items-center justify-center flex-shrink-0">
                        <i class="fas fa-money-bill-wave text-emerald-600 text-lg"></i>
                    </div>
                    <div>
                        <p class="text-xs text-slate-400">Pendapatan</p>
                        <p class="text-xl font-extrabold text-slate-900">Rp {{ number_format($stats['pendapatan'], 0, ',', '.') }}</p>
                    </div>
                </div>
            </div>
            <div class="stat-card">
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 bg-slate-100 rounded-xl flex items-center justify-center flex-shrink-0">
                        <i class="fas fa-user-check text-slate-500 text-lg"></i>
                    </div>
                    <div>
                        <p class="text-xs text-slate-400">User</p>
                        <p class="text-2xl font-extrabold text-slate-900">{{ number_format($stats['total_user']) }}</p>
                    </div>
                </div>
            </div>
        </div>

        {{-- Recent Transactions --}}
        <h2 class="text-lg font-bold text-slate-900 mb-4">Transaksi Terbaru</h2>
        <div class="table-container">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr class="border-b border-slate-100">
                            <th class="px-5 py-3.5 text-left text-[11px] font-semibold text-slate-400 uppercase tracking-wider">Ref</th>
                            <th class="px-5 py-3.5 text-left text-[11px] font-semibold text-slate-400 uppercase tracking-wider">User</th>
                            <th class="px-5 py-3.5 text-left text-[11px] font-semibold text-slate-400 uppercase tracking-wider">Jenis</th>
                            <th class="px-5 py-3.5 text-left text-[11px] font-semibold text-slate-400 uppercase tracking-wider">Jumlah</th>
                            <th class="px-5 py-3.5 text-left text-[11px] font-semibold text-slate-400 uppercase tracking-wider">Metode</th>
                            <th class="px-5 py-3.5 text-left text-[11px] font-semibold text-slate-400 uppercase tracking-wider">Status</th>
                            <th class="px-5 py-3.5 text-left text-[11px] font-semibold text-slate-400 uppercase tracking-wider">Tanggal</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-50">
                        @forelse($recentTransactions as $trx)
                            <tr class="hover:bg-slate-50/50 transition-colors">
                                <td class="px-5 py-3.5 text-sm font-mono text-slate-500">{{ $trx->ref_number }}</td>
                                <td class="px-5 py-3.5 text-sm font-medium text-slate-700">{{ $trx->user->name ?? '-' }}</td>
                                <td class="px-5 py-3.5 text-sm capitalize text-slate-600">{{ $trx->type }}</td>
                                <td class="px-5 py-3.5 text-sm font-semibold text-slate-900">Rp {{ number_format($trx->amount, 0, ',', '.') }}</td>
                                <td class="px-5 py-3.5 text-sm uppercase text-slate-500">{{ $trx->payment_method }}</td>
                                <td class="px-5 py-3.5">
                                    @if($trx->status === 'success') <span class="badge-success">Berhasil</span>
                                    @elseif($trx->status === 'pending') <span class="badge-pending">Pending</span>
                                    @else <span class="badge-failed">Gagal</span> @endif
                                </td>
                                <td class="px-5 py-3.5 text-sm text-slate-500">{{ $trx->created_at->format('d M Y H:i') }}</td>
                            </tr>
                        @empty
                            <tr><td colspan="7" class="px-5 py-10 text-center text-slate-400 text-sm">Belum ada transaksi</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</section>
@endsection

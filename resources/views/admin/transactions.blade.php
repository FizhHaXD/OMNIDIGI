@extends('layouts.main')
@section('title', 'Transaksi - Admin PLN DIGI')

@section('content')
<section class="py-12 md:py-20">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="mb-8 animate-fade-up">
            <h1 class="text-2xl font-bold text-slate-900">Data Transaksi</h1>
            <p class="text-slate-500 text-sm mt-1">Monitor semua transaksi pembayaran</p>
        </div>

        <div class="table-container animate-fade-up delay-100">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-slate-50 border-b border-slate-100">
                        <tr>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-slate-500 uppercase">Ref</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-slate-500 uppercase">User</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-slate-500 uppercase">Jenis</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-slate-500 uppercase">No. Meter</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-slate-500 uppercase">Jumlah</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-slate-500 uppercase">Metode</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-slate-500 uppercase">Status</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-slate-500 uppercase">Tanggal</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-50">
                        @forelse($transactions as $trx)
                            <tr class="hover:bg-slate-50/50 transition-colors">
                                <td class="px-6 py-4 text-sm font-mono text-slate-600">{{ $trx->ref_number }}</td>
                                <td class="px-6 py-4 text-sm font-medium text-slate-900">{{ $trx->user->name ?? '-' }}</td>
                                <td class="px-6 py-4 text-sm capitalize">
                                    <i class="fas {{ $trx->type === 'tagihan' ? 'fa-file-invoice text-blue-600' : 'fa-bolt text-yellow-500' }} mr-1"></i>
                                    {{ $trx->type }}
                                </td>
                                <td class="px-6 py-4 text-sm font-mono text-slate-600">{{ $trx->no_meter }}</td>
                                <td class="px-6 py-4 text-sm font-bold text-slate-900">Rp {{ number_format($trx->amount, 0, ',', '.') }}</td>
                                <td class="px-6 py-4 text-sm uppercase text-slate-600">{{ $trx->payment_method }}</td>
                                <td class="px-6 py-4">
                                    @if($trx->status === 'success')
                                        <span class="badge-success">Berhasil</span>
                                    @elseif($trx->status === 'pending')
                                        <span class="badge-pending">Pending</span>
                                    @else
                                        <span class="badge-failed">Gagal</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-sm text-slate-600">{{ $trx->created_at->format('d M Y H:i') }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="px-6 py-12 text-center text-slate-400">Belum ada transaksi</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($transactions->hasPages())
                <div class="px-6 py-4 border-t border-slate-100">
                    {{ $transactions->links() }}
                </div>
            @endif
        </div>

        <div class="mt-6">
            <a href="{{ route('admin.dashboard') }}" class="text-sm text-slate-500 hover:text-blue-700">
                <i class="fas fa-arrow-left"></i> Kembali ke Dashboard
            </a>
        </div>
    </div>
</section>
@endsection

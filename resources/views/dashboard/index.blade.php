@extends('layouts.main')
@section('title', 'Dashboard - PLN DIGI')

@section('content')
{{-- Header --}}
<section class="relative -mt-16 md:-mt-18 bg-gradient-to-br from-[#001230] via-[#00265a] to-[#001a4d] text-white overflow-hidden">
    <div class="absolute inset-0 opacity-10">
        <div class="absolute top-10 right-10 w-72 h-72 bg-[#FDB813] rounded-full blur-[120px]"></div>
    </div>
    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-32 pb-10 md:pt-36 md:pb-14">
        <div class="flex items-center gap-4 mb-3">
            <div class="w-14 h-14 rounded-2xl bg-white/10 backdrop-blur-sm flex items-center justify-center border border-white/10">
                <i class="fas fa-user text-[#FDB813] text-xl"></i>
            </div>
            <div>
                <h1 class="text-2xl md:text-3xl font-bold">Selamat Datang, {{ $user->name }}</h1>
                <p class="text-white/50 text-sm mt-0.5">Kelola listrik Anda dalam satu platform.</p>
            </div>
        </div>
    </div>
</section>

<section class="py-8 md:py-10">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        {{-- Info Card Pelanggan --}}
        @if($customer)
        <div class="bg-gradient-to-r from-[#00529C] to-[#003d75] rounded-2xl p-6 md:p-8 text-white mb-8 shadow-xl relative overflow-hidden">
            <div class="absolute top-0 right-0 w-48 h-48 bg-white/5 rounded-full -translate-y-1/2 translate-x-1/2"></div>
            <div class="relative flex flex-col md:flex-row md:items-center md:justify-between gap-6">
                <div class="flex-1">
                    <p class="text-white/50 text-xs uppercase tracking-widest mb-2">ID Pelanggan</p>
                    <p class="text-2xl font-bold font-mono tracking-wider mb-3">{{ $customer->id_pelanggan }}</p>
                    <div class="flex flex-wrap gap-x-6 gap-y-2 text-sm">
                        <span class="text-white/70"><i class="fas fa-bolt text-[#FDB813] mr-1.5"></i>{{ $customer->tariff->daya_va ?? '-' }} VA</span>
                        <span class="text-white/70"><i class="fas fa-tag text-[#FDB813] mr-1.5"></i>{{ $customer->tariff->kode ?? '-' }}</span>
                        <span class="text-white/70"><i class="fas fa-map-marker-alt text-[#FDB813] mr-1.5"></i>{{ Str::limit($customer->alamat, 35) }}</span>
                    </div>
                </div>
                <div class="flex gap-4">
                    <div class="bg-white/10 backdrop-blur-sm rounded-xl px-5 py-3 text-center border border-white/10 min-w-[130px]">
                        <p class="text-white/50 text-[11px] uppercase tracking-wider mb-1">Tagihan</p>
                        <p class="text-xl font-bold text-[#FDB813]">{{ $tagihanBelumBayar }}</p>
                        <p class="text-[10px] text-white/40">Belum Bayar</p>
                    </div>
                    <div class="bg-white/10 backdrop-blur-sm rounded-xl px-5 py-3 text-center border border-white/10 min-w-[130px]">
                        <p class="text-white/50 text-[11px] uppercase tracking-wider mb-1">Total</p>
                        <p class="text-lg font-bold">Rp {{ number_format($totalTagihan, 0, ',', '.') }}</p>
                        <p class="text-[10px] text-white/40">Harus Dibayar</p>
                    </div>
                </div>
            </div>
        </div>
        @else
        <div class="card p-8 text-center mb-8">
            <i class="fas fa-exclamation-circle text-amber-400 text-3xl mb-3"></i>
            <p class="text-slate-600">Anda belum memiliki data pelanggan PLN. Hubungi admin untuk pendaftaran.</p>
        </div>
        @endif

        {{-- Grid Menu Fitur (4x2) --}}
        <h2 class="text-lg font-bold text-slate-900 mb-5">Layanan</h2>
        <div class="grid grid-cols-2 sm:grid-cols-4 md:grid-cols-4 gap-4 mb-10">
            {{-- Bayar Tagihan --}}
            <a href="{{ route('dashboard.tagihan') }}" class="card p-5 text-center group hover:shadow-lg transition-all duration-200 hover:-translate-y-0.5">
                <div class="w-12 h-12 bg-[#00529C]/10 rounded-2xl flex items-center justify-center mx-auto mb-3 group-hover:bg-[#00529C]/20 transition-colors">
                    <i class="fas fa-file-invoice-dollar text-[#00529C] text-lg"></i>
                </div>
                <p class="text-sm font-semibold text-slate-700">Tagihan</p>
                <p class="text-[11px] text-slate-400 mt-0.5">Bayar & Cek</p>
            </a>

            {{-- Beli Token --}}
            <a href="{{ route('dashboard.token') }}" class="card p-5 text-center group hover:shadow-lg transition-all duration-200 hover:-translate-y-0.5">
                <div class="w-12 h-12 bg-[#FDB813]/15 rounded-2xl flex items-center justify-center mx-auto mb-3 group-hover:bg-[#FDB813]/25 transition-colors">
                    <i class="fas fa-bolt text-[#FDB813] text-lg"></i>
                </div>
                <p class="text-sm font-semibold text-slate-700">Token</p>
                <p class="text-[11px] text-slate-400 mt-0.5">Beli & Riwayat</p>
            </a>

            {{-- Self Metering --}}
            <a href="{{ route('dashboard.metering') }}" class="card p-5 text-center group hover:shadow-lg transition-all duration-200 hover:-translate-y-0.5">
                <div class="w-12 h-12 bg-emerald-50 rounded-2xl flex items-center justify-center mx-auto mb-3 group-hover:bg-emerald-100 transition-colors">
                    <i class="fas fa-tachometer-alt text-emerald-600 text-lg"></i>
                </div>
                <p class="text-sm font-semibold text-slate-700">Self Metering</p>
                <p class="text-[11px] text-slate-400 mt-0.5">Baca Meteran</p>
            </a>

            {{-- Monitoring --}}
            <a href="{{ route('dashboard.monitoring') }}" class="card p-5 text-center group hover:shadow-lg transition-all duration-200 hover:-translate-y-0.5">
                <div class="w-12 h-12 bg-indigo-50 rounded-2xl flex items-center justify-center mx-auto mb-3 group-hover:bg-indigo-100 transition-colors">
                    <i class="fas fa-chart-line text-indigo-600 text-lg"></i>
                </div>
                <p class="text-sm font-semibold text-slate-700">Monitoring</p>
                <p class="text-[11px] text-slate-400 mt-0.5">Grafik Pemakaian</p>
            </a>

            {{-- Simulasi Keuangan --}}
            <a href="{{ route('dashboard.simulasi') }}" class="card p-5 text-center group hover:shadow-lg transition-all duration-200 hover:-translate-y-0.5">
                <div class="w-12 h-12 bg-cyan-50 rounded-2xl flex items-center justify-center mx-auto mb-3 group-hover:bg-cyan-100 transition-colors">
                    <i class="fas fa-calculator text-cyan-600 text-lg"></i>
                </div>
                <p class="text-sm font-semibold text-slate-700">Simulasi</p>
                <p class="text-[11px] text-slate-400 mt-0.5">Estimasi Biaya</p>
            </a>

            {{-- Report Outage --}}
            <a href="{{ route('dashboard.outage') }}" class="card p-5 text-center group hover:shadow-lg transition-all duration-200 hover:-translate-y-0.5">
                <div class="w-12 h-12 bg-red-50 rounded-2xl flex items-center justify-center mx-auto mb-3 group-hover:bg-red-100 transition-colors">
                    <i class="fas fa-exclamation-triangle text-red-500 text-lg"></i>
                </div>
                <p class="text-sm font-semibold text-slate-700">Lapor Gangguan</p>
                <p class="text-[11px] text-slate-400 mt-0.5">Report Outage</p>
            </a>

            {{-- PLN Reward --}}
            <a href="{{ route('dashboard.reward') }}" class="card p-5 text-center group hover:shadow-lg transition-all duration-200 hover:-translate-y-0.5">
                <div class="w-12 h-12 bg-amber-50 rounded-2xl flex items-center justify-center mx-auto mb-3 group-hover:bg-amber-100 transition-colors">
                    <i class="fas fa-gift text-amber-500 text-lg"></i>
                </div>
                <p class="text-sm font-semibold text-slate-700">PLN Reward</p>
                <p class="text-[11px] text-slate-400 mt-0.5">Poin & Hadiah</p>
            </a>

            {{-- Profil --}}
            <a href="{{ route('profile.edit') }}" class="card p-5 text-center group hover:shadow-lg transition-all duration-200 hover:-translate-y-0.5">
                <div class="w-12 h-12 bg-slate-100 rounded-2xl flex items-center justify-center mx-auto mb-3 group-hover:bg-slate-200 transition-colors">
                    <i class="fas fa-user-cog text-slate-500 text-lg"></i>
                </div>
                <p class="text-sm font-semibold text-slate-700">Profil</p>
                <p class="text-[11px] text-slate-400 mt-0.5">Pengaturan Akun</p>
            </a>
        </div>

        {{-- Transaksi Terakhir --}}
        <h2 class="text-lg font-bold text-slate-900 mb-4">Transaksi Terakhir</h2>
        @if($recentTransactions->isEmpty())
            <div class="card p-10 text-center mb-8">
                <div class="w-14 h-14 bg-slate-100 rounded-2xl flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-receipt text-slate-300 text-xl"></i>
                </div>
                <p class="text-slate-400 text-sm">Belum ada transaksi.</p>
            </div>
        @else
            <div class="card overflow-hidden mb-8">
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead>
                            <tr class="border-b border-slate-100 bg-slate-50/50">
                                <th class="px-5 py-3 text-left text-[11px] font-semibold text-slate-400 uppercase tracking-wider">Tanggal</th>
                                <th class="px-5 py-3 text-left text-[11px] font-semibold text-slate-400 uppercase tracking-wider">Jenis</th>
                                <th class="px-5 py-3 text-left text-[11px] font-semibold text-slate-400 uppercase tracking-wider">Jumlah</th>
                                <th class="px-5 py-3 text-left text-[11px] font-semibold text-slate-400 uppercase tracking-wider">Status</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-50">
                            @foreach($recentTransactions as $trx)
                            <tr class="hover:bg-slate-50/50 transition-colors">
                                <td class="px-5 py-3.5 text-sm text-slate-500">{{ $trx->created_at->format('d M Y') }}</td>
                                <td class="px-5 py-3.5 text-sm font-medium capitalize text-slate-700">{{ $trx->type }}</td>
                                <td class="px-5 py-3.5 text-sm font-semibold text-slate-900">Rp {{ number_format($trx->amount, 0, ',', '.') }}</td>
                                <td class="px-5 py-3.5">
                                    @if($trx->status === 'success') <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-emerald-50 text-emerald-700">Berhasil</span>
                                    @elseif($trx->status === 'pending') <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-amber-50 text-amber-700">Pending</span>
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

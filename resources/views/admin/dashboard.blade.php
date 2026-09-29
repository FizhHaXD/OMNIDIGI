@extends('layouts.main')
@section('title', 'Admin Dashboard - PLN DIGI')

@section('content')
{{-- Header --}}
<section class="relative -mt-16 md:-mt-18 bg-gradient-to-br from-[#001230] via-[#00265a] to-[#001a4d] text-white overflow-hidden">
    <div class="absolute inset-0 opacity-10 pointer-events-none">
        <div class="absolute top-10 right-10 w-96 h-96 bg-[#FDB813] rounded-full blur-[140px]"></div>
    </div>
    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-32 pb-8 md:pt-36 md:pb-10">
        <div class="flex flex-col md:flex-row md:items-end justify-between gap-6 mb-6">
            <div>
                <span class="inline-flex items-center gap-2 px-3.5 py-1 bg-white/10 rounded-full text-[#FDB813] text-xs font-semibold uppercase tracking-wider mb-3 border border-white/10">
                    <i class="fas fa-shield-alt"></i> Panel Kontrol Backoffice
                </span>
                <h1 class="text-3xl md:text-4xl font-extrabold tracking-tight">Dashboard Admin</h1>
                <p class="text-white/60 text-sm mt-1">Pemantauan pelanggan, tagihan, audit gangguan, dan otomasi dokumen kedinasan.</p>
            </div>
            
            <div class="flex items-center gap-3">
                <a href="{{ route('admin.letters') }}" class="btn-primary text-xs flex items-center gap-2">
                    <i class="fas fa-magic text-[#FDB813]"></i>
                    <span>Buka Pusat Surat AI</span>
                </a>
            </div>
        </div>

        {{-- Sub-Navigation Tabs --}}
        @include('admin.partials.nav')
    </div>
</section>

<section class="py-8 md:py-12 bg-slate-50/60 min-h-screen">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        {{-- Flash Messages --}}
        @if(session('success'))
            <div class="bg-emerald-50 border border-emerald-200 text-emerald-700 px-5 py-3.5 rounded-xl mb-6 flex items-center gap-3 shadow-sm">
                <i class="fas fa-check-circle text-emerald-500 text-base"></i>
                <p class="text-sm font-medium">{{ session('success') }}</p>
            </div>
        @endif

        {{-- 6 Executive Metric Cards --}}
        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-3.5 mb-8">
            {{-- Pelanggan --}}
            <div class="card p-4 hover:shadow-md transition-shadow">
                <div class="flex items-center justify-between mb-2">
                    <span class="text-[11px] font-semibold text-slate-400 uppercase tracking-wider">Pelanggan</span>
                    <div class="w-8 h-8 rounded-lg bg-[#00529C]/10 flex items-center justify-center text-[#00529C]">
                        <i class="fas fa-users text-xs"></i>
                    </div>
                </div>
                <p class="text-2xl font-black text-slate-900">{{ number_format($stats['total_pelanggan']) }}</p>
                <p class="text-[10px] text-slate-400 mt-1">Total data CRM</p>
            </div>

            {{-- Transaksi --}}
            <div class="card p-4 hover:shadow-md transition-shadow">
                <div class="flex items-center justify-between mb-2">
                    <span class="text-[11px] font-semibold text-slate-400 uppercase tracking-wider">Transaksi</span>
                    <div class="w-8 h-8 rounded-lg bg-[#FDB813]/15 flex items-center justify-center text-[#b88000]">
                        <i class="fas fa-exchange-alt text-xs"></i>
                    </div>
                </div>
                <p class="text-2xl font-black text-slate-900">{{ number_format($stats['total_transaksi']) }}</p>
                <p class="text-[10px] text-slate-400 mt-1">Tagihan & Token</p>
            </div>

            {{-- Pendapatan --}}
            <div class="card p-4 hover:shadow-md transition-shadow">
                <div class="flex items-center justify-between mb-2">
                    <span class="text-[11px] font-semibold text-slate-400 uppercase tracking-wider">Pendapatan</span>
                    <div class="w-8 h-8 rounded-lg bg-emerald-50 flex items-center justify-center text-emerald-600">
                        <i class="fas fa-wallet text-xs"></i>
                    </div>
                </div>
                <p class="text-lg font-black text-slate-900 truncate" title="Rp {{ number_format($stats['pendapatan'], 0, ',', '.') }}">
                    Rp {{ number_format($stats['pendapatan'] / 1000000, 1) }}M
                </p>
                <p class="text-[10px] text-emerald-600 font-semibold mt-1">Rp {{ number_format($stats['pendapatan'], 0, ',', '.') }}</p>
            </div>

            {{-- Piutang & Tunggakan --}}
            <a href="{{ route('admin.bills', ['status' => 'overdue']) }}" class="card p-4 hover:shadow-md hover:border-red-200 transition-all group">
                <div class="flex items-center justify-between mb-2">
                    <span class="text-[11px] font-semibold text-slate-400 uppercase tracking-wider group-hover:text-red-600 transition-colors">Tunggakan</span>
                    <div class="w-8 h-8 rounded-lg bg-red-50 flex items-center justify-center text-red-600">
                        <i class="fas fa-file-invoice text-xs"></i>
                    </div>
                </div>
                <p class="text-2xl font-black text-red-600">{{ $stats['tagihan_belum_lunas'] }}</p>
                <p class="text-[10px] text-red-500 font-medium mt-1 truncate">Rp {{ number_format($stats['total_piutang'], 0, ',', '.') }}</p>
            </a>

            {{-- Gangguan Aktif --}}
            <a href="{{ route('admin.outages', ['status' => 'dilaporkan']) }}" class="card p-4 hover:shadow-md hover:border-amber-200 transition-all group">
                <div class="flex items-center justify-between mb-2">
                    <span class="text-[11px] font-semibold text-slate-400 uppercase tracking-wider group-hover:text-amber-600 transition-colors">Gangguan</span>
                    <div class="w-8 h-8 rounded-lg bg-amber-50 flex items-center justify-center text-amber-600">
                        <i class="fas fa-bolt text-xs"></i>
                    </div>
                </div>
                <p class="text-2xl font-black text-amber-600">{{ $stats['gangguan_aktif'] }}</p>
                <p class="text-[10px] text-amber-600 font-medium mt-1">Perlu Dispatch SPK</p>
            </a>

            {{-- SwaCAM Pending --}}
            <a href="{{ route('admin.meter_readings', ['status' => 'pending']) }}" class="card p-4 hover:shadow-md hover:border-blue-200 transition-all group">
                <div class="flex items-center justify-between mb-2">
                    <span class="text-[11px] font-semibold text-slate-400 uppercase tracking-wider group-hover:text-[#00529C] transition-colors">SwaCAM</span>
                    <div class="w-8 h-8 rounded-lg bg-blue-50 flex items-center justify-center text-[#00529C]">
                        <i class="fas fa-camera text-xs"></i>
                    </div>
                </div>
                <p class="text-2xl font-black text-[#00529C]">{{ $stats['meter_pending'] }}</p>
                <p class="text-[10px] text-[#00529C] font-medium mt-1">Menunggu Verifikasi</p>
            </a>
        </div>

        {{-- Banner Integrasi AI Agent Pembentuk Surat --}}
        <div class="bg-gradient-to-r from-[#00265a] to-[#00529C] rounded-2xl p-6 text-white mb-8 shadow-md relative overflow-hidden flex flex-col md:flex-row md:items-center justify-between gap-6">
            <div class="relative z-10 max-w-2xl">
                <div class="flex items-center gap-2 mb-2">
                    <span class="px-2.5 py-0.5 rounded text-[10px] font-bold bg-[#FDB813] text-[#001a4d] uppercase tracking-wider">
                        <i class="fas fa-sparkles mr-1"></i> AI Document Pipeline
                    </span>
                    <span class="text-xs text-white/70">Terintegrasi dengan Data Tunggakan & Tiket Lapangan</span>
                </div>
                <h3 class="text-xl font-bold">Pusat Generator Dokumen & Surat Kedinasan PLN</h3>
                <p class="text-xs text-white/70 mt-1 leading-relaxed">
                    Sistem dapat mengekstrak data pelanggan menunggak untuk membuat <strong>Surat Peringatan 1 & 2</strong>, atau tiket gangguan untuk menerbitkan <strong>Surat Perintah Kerja (SPK) YANTEK</strong> secara otomatis dengan format resmi PT PLN (Persero).
                </p>
            </div>
            <div class="relative z-10 flex flex-wrap items-center gap-2 flex-shrink-0">
                <a href="{{ route('admin.letters', ['type' => 'sp_tunggakan']) }}" class="px-4 py-2.5 bg-white text-[#00529C] font-bold text-xs rounded-xl hover:bg-slate-100 shadow-sm transition-all flex items-center gap-2">
                    <i class="fas fa-file-invoice text-red-500"></i> Buat Surat Peringatan
                </a>
                <a href="{{ route('admin.letters', ['type' => 'spk_gangguan']) }}" class="px-4 py-2.5 bg-[#FDB813] text-[#001a4d] font-bold text-xs rounded-xl hover:bg-[#e6a307] shadow-sm transition-all flex items-center gap-2">
                    <i class="fas fa-tools text-[#001a4d]"></i> Terbitkan SPK
                </a>
            </div>
        </div>

        {{-- Grid: Two Columns (Tabel Transaksi vs Tunggakan & Gangguan) --}}
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
            
            {{-- Left: Transaksi Terbaru (Col 7) --}}
            <div class="lg:col-span-7">
                <div class="flex items-center justify-between mb-4">
                    <h2 class="text-base font-bold text-slate-900 flex items-center gap-2">
                        <i class="fas fa-receipt text-[#00529C]"></i> Transaksi Terbaru
                    </h2>
                    <a href="{{ route('admin.transactions') }}" class="text-xs font-semibold text-[#00529C] hover:underline">
                        Lihat Semua Transaksi →
                    </a>
                </div>

                <div class="card overflow-hidden">
                    <div class="overflow-x-auto">
                        <table class="w-full">
                            <thead>
                                <tr class="border-b border-slate-100 bg-slate-50/60">
                                    <th class="px-4 py-3 text-left text-[11px] font-semibold text-slate-400 uppercase">Ref / Pelanggan</th>
                                    <th class="px-4 py-3 text-left text-[11px] font-semibold text-slate-400 uppercase">Jenis</th>
                                    <th class="px-4 py-3 text-left text-[11px] font-semibold text-slate-400 uppercase">Jumlah</th>
                                    <th class="px-4 py-3 text-left text-[11px] font-semibold text-slate-400 uppercase">Status</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-50">
                                @forelse($recentTransactions as $trx)
                                    <tr class="hover:bg-slate-50/50 transition-colors">
                                        <td class="px-4 py-3">
                                            <p class="text-xs font-mono font-bold text-slate-800">{{ $trx->ref_number }}</p>
                                            <p class="text-[11px] text-slate-400">{{ $trx->customer->nama ?? ($trx->user->name ?? 'Pelanggan') }}</p>
                                        </td>
                                        <td class="px-4 py-3 text-xs capitalize text-slate-600">
                                            <span class="inline-flex items-center gap-1 font-medium">
                                                <i class="fas {{ $trx->type === 'tagihan' ? 'fa-file-invoice-dollar text-[#00529C]' : 'fa-bolt text-[#FDB813]' }} text-[10px]"></i>
                                                {{ $trx->type }}
                                            </span>
                                        </td>
                                        <td class="px-4 py-3 text-xs font-bold text-slate-900">
                                            Rp {{ number_format($trx->amount, 0, ',', '.') }}
                                        </td>
                                        <td class="px-4 py-3">
                                            @if($trx->status === 'success')
                                                <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-[10px] font-semibold bg-emerald-50 text-emerald-700">
                                                    <i class="fas fa-check-circle text-[9px]"></i> Sukses
                                                </span>
                                            @elseif($trx->status === 'pending')
                                                <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-[10px] font-semibold bg-amber-50 text-amber-700">
                                                    <i class="fas fa-clock text-[9px]"></i> Pending
                                                </span>
                                            @else
                                                <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-[10px] font-semibold bg-red-50 text-red-700">
                                                    <i class="fas fa-times text-[9px]"></i> Gagal
                                                </span>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="px-4 py-8 text-center text-slate-400 text-xs">Belum ada transaksi tercatat.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            {{-- Right: Urgent Action Center (Col 5) --}}
            <div class="lg:col-span-5 space-y-6">
                
                {{-- Tiket Gangguan Urgent --}}
                <div>
                    <div class="flex items-center justify-between mb-4">
                        <h2 class="text-base font-bold text-slate-900 flex items-center gap-2">
                            <i class="fas fa-exclamation-triangle text-amber-500"></i> Gangguan Perlu Tindak Lanjut
                        </h2>
                        <a href="{{ route('admin.outages') }}" class="text-xs font-semibold text-[#00529C] hover:underline">
                            Semua Tiket →
                        </a>
                    </div>

                    <div class="card divide-y divide-slate-100">
                        @forelse($urgentOutages as $outage)
                            <div class="p-3.5 hover:bg-slate-50/60 transition-colors flex items-start justify-between gap-3">
                                <div class="flex-1 min-w-0">
                                    <div class="flex items-center gap-2 mb-1">
                                        <span class="px-2 py-0.5 rounded text-[10px] font-bold uppercase
                                            {{ in_array($outage->kategori, ['padam_total', 'korsleting']) ? 'bg-red-100 text-red-700' : 'bg-amber-100 text-amber-800' }}">
                                            {{ $outage->label_kategori }}
                                        </span>
                                        <span class="text-[10px] text-slate-400">{{ $outage->created_at->diffForHumans() }}</span>
                                    </div>
                                    <p class="text-xs font-bold text-slate-800 truncate">{{ $outage->lokasi }}</p>
                                    <p class="text-[11px] text-slate-500 truncate mt-0.5">{{ $outage->deskripsi }}</p>
                                </div>
                                <a href="{{ route('admin.letters', ['type' => 'spk_gangguan', 'outage_id' => $outage->id]) }}" 
                                   class="px-2.5 py-1.5 bg-amber-50 hover:bg-amber-100 text-amber-800 rounded-lg text-[11px] font-bold flex items-center gap-1 whitespace-nowrap shadow-xs" title="Terbitkan Surat Perintah Kerja">
                                    <i class="fas fa-file-signature text-[10px]"></i> SPK
                                </a>
                            </div>
                        @empty
                            <div class="p-6 text-center text-slate-400 text-xs">
                                <i class="fas fa-check-circle text-emerald-500 text-lg mb-1 block"></i>
                                Tidak ada tiket gangguan aktif saat ini.
                            </div>
                        @endforelse
                    </div>
                </div>

                {{-- Tagihan Jatuh Tempo / Menunggak --}}
                <div>
                    <div class="flex items-center justify-between mb-4">
                        <h2 class="text-base font-bold text-slate-900 flex items-center gap-2">
                            <i class="fas fa-clock text-red-500"></i> Prioritas Penagihan
                        </h2>
                        <a href="{{ route('admin.bills', ['status' => 'overdue']) }}" class="text-xs font-semibold text-[#00529C] hover:underline">
                            Semua Tunggakan →
                        </a>
                    </div>

                    <div class="card divide-y divide-slate-100">
                        @forelse($overdueBills as $bill)
                            <div class="p-3.5 hover:bg-slate-50/60 transition-colors flex items-start justify-between gap-3">
                                <div class="flex-1 min-w-0">
                                    <div class="flex items-center gap-2 mb-1">
                                        <span class="text-xs font-bold font-mono text-slate-900">{{ $bill->customer->id_pelanggan ?? '-' }}</span>
                                        <span class="text-[11px] text-slate-500 truncate">· {{ $bill->customer->nama ?? '-' }}</span>
                                    </div>
                                    <p class="text-xs font-black text-red-600">
                                        Rp {{ number_format($bill->total_bayar, 0, ',', '.') }}
                                        <span class="text-[10px] text-slate-400 font-normal">({{ $bill->nama_bulan ?? $bill->bulan }}/{{ $bill->tahun }})</span>
                                    </p>
                                    <p class="text-[10px] text-slate-400 mt-0.5">Jatuh Tempo: {{ $bill->tanggal_jatuh_tempo ? $bill->tanggal_jatuh_tempo->format('d M Y') : '-' }}</p>
                                </div>
                                <a href="{{ route('admin.letters', ['type' => 'sp_tunggakan', 'bill_id' => $bill->id]) }}" 
                                   class="px-2.5 py-1.5 bg-red-50 hover:bg-red-100 text-red-700 rounded-lg text-[11px] font-bold flex items-center gap-1 whitespace-nowrap shadow-xs" title="Draft Surat Peringatan Tunggakan">
                                    <i class="fas fa-envelope-open-text text-[10px]"></i> SP
                                </a>
                            </div>
                        @empty
                            <div class="p-6 text-center text-slate-400 text-xs">
                                <i class="fas fa-check-circle text-emerald-500 text-lg mb-1 block"></i>
                                Semua tagihan tertagih dengan baik.
                            </div>
                        @endforelse
                    </div>
                </div>

            </div>
        </div>

    </div>
</section>
@endsection

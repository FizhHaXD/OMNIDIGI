@extends('layouts.main')
@section('title', 'Audit Meter Mandiri (SwaCAM) - Admin PLN DIGI')

@section('content')
{{-- Header --}}
<section class="relative -mt-16 md:-mt-18 bg-gradient-to-br from-[#001230] via-[#00265a] to-[#001a4d] text-white overflow-hidden">
    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-32 pb-8 md:pt-36 md:pb-10">
        <div class="flex flex-col md:flex-row md:items-end justify-between gap-6 mb-6">
            <div>
                <span class="inline-flex items-center gap-2 px-3.5 py-1 bg-white/10 rounded-full text-[#FDB813] text-xs font-semibold uppercase tracking-wider mb-3 border border-white/10">
                    <i class="fas fa-tachometer-alt"></i> SwaCAM & Pengukuran
                </span>
                <h1 class="text-3xl md:text-4xl font-extrabold tracking-tight">Audit Catat Meter Mandiri</h1>
                <p class="text-white/60 text-sm mt-1">Verifikasi pembacaan angka stand meteran yang dilaporkan mandiri oleh pelanggan.</p>
            </div>
            
            <a href="{{ route('admin.letters', ['type' => 'ba_meter']) }}" class="btn-primary text-xs py-2.5 flex items-center gap-2">
                <i class="fas fa-file-contract text-xs"></i> Buat Berita Acara Meter (AI)
            </a>
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
                <i class="fas fa-check-circle text-emerald-500"></i>
                <p class="text-sm font-medium">{{ session('success') }}</p>
            </div>
        @endif

        {{-- Summary Cards --}}
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-6">
            <div class="card p-4">
                <p class="text-[11px] font-semibold text-slate-400 uppercase tracking-wider">Total Laporan SwaCAM</p>
                <p class="text-2xl font-black text-slate-900 mt-1">{{ number_format($summary['total']) }}</p>
                <p class="text-[10px] text-slate-400 mt-0.5">Seluruh periode pelaporan</p>
            </div>
            <div class="card p-4 border-l-4 border-l-amber-500">
                <p class="text-[11px] font-semibold text-amber-600 uppercase tracking-wider">Menunggu Verifikasi</p>
                <p class="text-2xl font-black text-amber-600 mt-1">{{ number_format($summary['pending']) }}</p>
                <p class="text-[10px] text-amber-600 font-semibold mt-0.5">Perlu konfirmasi admin</p>
            </div>
            <div class="card p-4 border-l-4 border-l-emerald-500">
                <p class="text-[11px] font-semibold text-emerald-600 uppercase tracking-wider">Terverifikasi</p>
                <p class="text-2xl font-black text-emerald-600 mt-1">{{ number_format($summary['verified']) }}</p>
                <p class="text-[10px] text-slate-400 mt-0.5">Siap diterbitkan tagihan</p>
            </div>
            <div class="card p-4 border-l-4 border-l-blue-500">
                <p class="text-[11px] font-semibold text-blue-600 uppercase tracking-wider">Sudah Terbit Tagihan</p>
                <p class="text-2xl font-black text-blue-600 mt-1">{{ number_format($summary['billed']) }}</p>
                <p class="text-[10px] text-slate-400 mt-0.5">Masuk ke billing sistem</p>
            </div>
        </div>

        {{-- Filter Box --}}
        <div class="card p-4 mb-6">
            <form method="GET" action="{{ route('admin.meter_readings') }}" class="flex flex-col md:flex-row gap-3">
                <div class="flex-1 relative">
                    <i class="fas fa-search absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400 text-xs"></i>
                    <input type="text" name="q" value="{{ request('q') }}" placeholder="Cari ID Pelanggan atau Nama Pelanggan..."
                           class="form-input text-xs pl-9 w-full rounded-xl">
                </div>
                <div class="w-full md:w-56">
                    <select name="status" class="form-input text-xs w-full rounded-xl" onchange="this.form.submit()">
                        <option value="">Semua Status Audit</option>
                        <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>⏳ Menunggu Verifikasi</option>
                        <option value="verified" {{ request('status') === 'verified' ? 'selected' : '' }}>✅ Terverifikasi</option>
                        <option value="billed" {{ request('status') === 'billed' ? 'selected' : '' }}>📄 Sudah Terbit Tagihan</option>
                    </select>
                </div>
                <button type="submit" class="btn-primary text-xs py-2 px-4 whitespace-nowrap">
                    Filter
                </button>
                @if(request()->hasAny(['q', 'status']))
                    <a href="{{ route('admin.meter_readings') }}" class="btn-outline text-xs py-2 px-4 whitespace-nowrap text-slate-600">
                        Reset
                    </a>
                @endif
            </form>
        </div>

        {{-- Table Audit SwaCAM --}}
        <div class="card overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr class="border-b border-slate-100 bg-slate-50/60">
                            <th class="px-5 py-3.5 text-left text-[11px] font-semibold text-slate-400 uppercase tracking-wider">ID Pelanggan / Nama</th>
                            <th class="px-5 py-3.5 text-left text-[11px] font-semibold text-slate-400 uppercase tracking-wider">Periode</th>
                            <th class="px-5 py-3.5 text-left text-[11px] font-semibold text-slate-400 uppercase tracking-wider">Stand Awal</th>
                            <th class="px-5 py-3.5 text-left text-[11px] font-semibold text-slate-400 uppercase tracking-wider">Stand Akhir</th>
                            <th class="px-5 py-3.5 text-left text-[11px] font-semibold text-slate-400 uppercase tracking-wider">Pemakaian (kWh)</th>
                            <th class="px-5 py-3.5 text-left text-[11px] font-semibold text-slate-400 uppercase tracking-wider">Status & Anomali</th>
                            <th class="px-5 py-3.5 text-right text-[11px] font-semibold text-slate-400 uppercase tracking-wider">Aksi Verifikasi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-50">
                        @forelse($readings as $r)
                            @php
                                $kwh = $r->meteran_akhir - $r->meteran_awal;
                                $isAnomaly = $kwh > 400 || $kwh < 10;
                            @endphp
                            <tr class="hover:bg-slate-50/50 transition-colors {{ $isAnomaly ? 'bg-amber-50/20' : '' }}">
                                <td class="px-5 py-3.5">
                                    <p class="text-xs font-mono font-bold text-[#00529C]">{{ $r->customer->id_pelanggan ?? '-' }}</p>
                                    <p class="text-xs font-semibold text-slate-900">{{ $r->customer->nama ?? '-' }}</p>
                                    <p class="text-[10px] text-slate-400">{{ $r->customer->tariff->kode ?? '-' }} ({{ number_format($r->customer->tariff->daya_va ?? 0) }} VA)</p>
                                </td>
                                <td class="px-5 py-3.5 text-xs font-semibold text-slate-700">
                                    {{ $r->nama_bulan }} {{ $r->tahun }}
                                </td>
                                <td class="px-5 py-3.5 text-xs font-mono text-slate-600">
                                    {{ number_format($r->meteran_awal, 0, ',', '.') }}
                                </td>
                                <td class="px-5 py-3.5 text-xs font-mono font-bold text-slate-900">
                                    {{ number_format($r->meteran_akhir, 0, ',', '.') }}
                                </td>
                                <td class="px-5 py-3.5 text-xs font-black text-[#00529C]">
                                    {{ number_format($kwh, 0, ',', '.') }} kWh
                                </td>
                                <td class="px-5 py-3.5">
                                    <div class="flex flex-col gap-1 items-start">
                                        @if($r->status === 'billed')
                                            <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-[10px] font-semibold bg-blue-50 text-blue-700">
                                                <i class="fas fa-file-invoice text-[9px]"></i> Tagihan Terbit
                                            </span>
                                        @elseif($r->status === 'verified')
                                            <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-[10px] font-semibold bg-emerald-50 text-emerald-700">
                                                <i class="fas fa-check-circle text-[9px]"></i> Terverifikasi
                                            </span>
                                        @else
                                            <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-[10px] font-semibold bg-amber-50 text-amber-700 border border-amber-200">
                                                <i class="fas fa-clock text-[9px]"></i> Menunggu Verifikasi
                                            </span>
                                        @endif

                                        @if($isAnomaly)
                                            <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded text-[9px] font-bold bg-red-100 text-red-700">
                                                <i class="fas fa-exclamation-triangle"></i> Indikasi Lonjakan kWh
                                            </span>
                                        @endif
                                    </div>
                                </td>
                                <td class="px-5 py-3.5 text-right">
                                    <div class="flex items-center justify-end gap-1.5">
                                        @if($r->status === 'pending')
                                            <form method="POST" action="{{ route('admin.meter_readings.verify', $r) }}">
                                                @csrf
                                                <button type="submit" class="px-3 py-1.5 bg-emerald-600 hover:bg-emerald-700 text-white rounded-lg text-xs font-semibold shadow-xs transition-all flex items-center gap-1">
                                                    <i class="fas fa-check"></i> Verifikasi
                                                </button>
                                            </form>
                                        @endif

                                        @if($isAnomaly)
                                            <a href="{{ route('admin.letters', ['type' => 'ba_meter']) }}"
                                               class="px-2.5 py-1.5 bg-red-50 hover:bg-red-100 text-red-700 rounded-lg text-xs font-semibold transition-all" title="Buat Berita Acara Pemeriksaan Stand Meter">
                                                <i class="fas fa-file-alt"></i> BA P2TL
                                            </a>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="px-5 py-12 text-center text-slate-400 text-sm">
                                    Tidak ada data pembacaan meteran yang ditemukan.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($readings->hasPages())
                <div class="px-5 py-4 border-t border-slate-100 bg-slate-50/50">
                    {{ $readings->links() }}
                </div>
            @endif
        </div>
    </div>
</section>
@endsection

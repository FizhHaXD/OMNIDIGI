@extends('layouts.main')
@section('title', 'Tagihan & Tunggakan - Admin PLN DIGI')

@section('content')
{{-- Header --}}
<section class="relative -mt-16 md:-mt-18 bg-gradient-to-br from-[#001230] via-[#00265a] to-[#001a4d] text-white overflow-hidden">
    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-32 pb-8 md:pt-36 md:pb-10">
        <div class="flex flex-col md:flex-row md:items-end justify-between gap-6 mb-6">
            <div>
                <span class="inline-flex items-center gap-2 px-3.5 py-1 bg-white/10 rounded-full text-[#FDB813] text-xs font-semibold uppercase tracking-wider mb-3 border border-white/10">
                    <i class="fas fa-file-invoice-dollar"></i> Manajemen Piutang & Billing
                </span>
                <h1 class="text-3xl md:text-4xl font-extrabold tracking-tight">Tagihan & Tunggakan Pelanggan</h1>
                <p class="text-white/60 text-sm mt-1">Klasifikasi tagihan, identifikasi tunggakan jatuh tempo, dan penerbitan surat peringatan.</p>
            </div>
            
            <a href="{{ route('admin.letters', ['type' => 'sp_tunggakan']) }}" class="btn-primary text-xs py-2.5 flex items-center gap-2">
                <i class="fas fa-envelope-open-text text-xs"></i> Buat Surat Peringatan (AI)
            </a>
        </div>

        {{-- Sub-Navigation Tabs --}}
        @include('admin.partials.nav')
    </div>
</section>

<section class="py-8 md:py-12 bg-slate-50/60 min-h-screen">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        {{-- 4 Klasifikasi Metrik Ringkasan --}}
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-6">
            <div class="card p-4">
                <p class="text-[11px] font-semibold text-slate-400 uppercase tracking-wider">Total Piutang Listrik</p>
                <p class="text-xl font-black text-red-600 mt-1">Rp {{ number_format($summary['total_piutang'], 0, ',', '.') }}</p>
                <p class="text-[10px] text-slate-400 mt-0.5">Tagihan belum terbayar</p>
            </div>
            <div class="card p-4">
                <p class="text-[11px] font-semibold text-slate-400 uppercase tracking-wider">Total Denda Keterlambatan</p>
                <p class="text-xl font-black text-amber-600 mt-1">Rp {{ number_format($summary['total_denda'], 0, ',', '.') }}</p>
                <p class="text-[10px] text-slate-400 mt-0.5">Akumulasi denda aktif</p>
            </div>
            <div class="card p-4">
                <p class="text-[11px] font-semibold text-slate-400 uppercase tracking-wider">Rekening Menunggak</p>
                <p class="text-xl font-black text-red-600 mt-1">{{ number_format($summary['overdue_count']) }} Pelanggan</p>
                <p class="text-[10px] text-red-500 font-semibold mt-0.5">Perlu Surat Peringatan (SP)</p>
            </div>
            <div class="card p-4">
                <p class="text-[11px] font-semibold text-slate-400 uppercase tracking-wider">Belum Jatuh Tempo</p>
                <p class="text-xl font-black text-slate-800 mt-1">{{ number_format($summary['unpaid_count']) }} Rekening</p>
                <p class="text-[10px] text-slate-400 mt-0.5">Masa bayar normal</p>
            </div>
        </div>

        {{-- Filter & Search Box --}}
        <div class="card p-4 mb-6">
            <form method="GET" action="{{ route('admin.bills') }}" class="flex flex-col md:flex-row gap-3">
                <div class="flex-1 relative">
                    <i class="fas fa-search absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400 text-xs"></i>
                    <input type="text" name="q" value="{{ request('q') }}" placeholder="Cari ID Pelanggan atau Nama Pelanggan..."
                           class="form-input text-xs pl-9 w-full rounded-xl">
                </div>
                <div class="w-full md:w-56">
                    <select name="status" class="form-input text-xs w-full rounded-xl" onchange="this.form.submit()">
                        <option value="">Semua Status Tagihan</option>
                        <option value="overdue" {{ request('status') === 'overdue' ? 'selected' : '' }}>⚠️ Menunggak (Overdue)</option>
                        <option value="unpaid" {{ request('status') === 'unpaid' ? 'selected' : '' }}>Belum Bayar (Unpaid)</option>
                        <option value="paid" {{ request('status') === 'paid' ? 'selected' : '' }}>Lunas (Paid)</option>
                    </select>
                </div>
                <button type="submit" class="btn-primary text-xs py-2 px-4 whitespace-nowrap">
                    Filter
                </button>
                @if(request()->hasAny(['q', 'status']))
                    <a href="{{ route('admin.bills') }}" class="btn-outline text-xs py-2 px-4 whitespace-nowrap text-slate-600">
                        Reset
                    </a>
                @endif
            </form>
        </div>

        {{-- Table Tagihan & Klasifikasi Penagihan --}}
        <div class="card overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr class="border-b border-slate-100 bg-slate-50/60">
                            <th class="px-5 py-3.5 text-left text-[11px] font-semibold text-slate-400 uppercase tracking-wider">ID Pelanggan / Nama</th>
                            <th class="px-5 py-3.5 text-left text-[11px] font-semibold text-slate-400 uppercase tracking-wider">Periode</th>
                            <th class="px-5 py-3.5 text-left text-[11px] font-semibold text-slate-400 uppercase tracking-wider">Pemakaian (kWh)</th>
                            <th class="px-5 py-3.5 text-left text-[11px] font-semibold text-slate-400 uppercase tracking-wider">Tagihan Pokok</th>
                            <th class="px-5 py-3.5 text-left text-[11px] font-semibold text-slate-400 uppercase tracking-wider">Denda</th>
                            <th class="px-5 py-3.5 text-left text-[11px] font-semibold text-slate-400 uppercase tracking-wider">Total Harus Bayar</th>
                            <th class="px-5 py-3.5 text-left text-[11px] font-semibold text-slate-400 uppercase tracking-wider">Klasifikasi Tindakan</th>
                            <th class="px-5 py-3.5 text-right text-[11px] font-semibold text-slate-400 uppercase tracking-wider">Aksi Surat</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-50">
                        @forelse($bills as $b)
                            @php
                                $isOverdue = $b->status === 'overdue' || ($b->status === 'unpaid' && $b->tanggal_jatuh_tempo && $b->tanggal_jatuh_tempo->isPast());
                                $daysLate = ($isOverdue && $b->tanggal_jatuh_tempo) ? abs((int) now()->diffInDays($b->tanggal_jatuh_tempo, false)) : 0;
                            @endphp
                            <tr class="hover:bg-slate-50/50 transition-colors {{ $isOverdue ? 'bg-red-50/20' : '' }}">
                                <td class="px-5 py-3.5">
                                    <p class="text-xs font-mono font-bold text-[#00529C]">{{ $b->customer->id_pelanggan ?? '-' }}</p>
                                    <p class="text-xs font-semibold text-slate-900">{{ $b->customer->nama ?? '-' }}</p>
                                    <p class="text-[10px] text-slate-400">{{ $b->customer->tariff->kode ?? '-' }} / {{ number_format($b->customer->tariff->daya_va ?? 0) }} VA</p>
                                </td>
                                <td class="px-5 py-3.5 text-xs font-medium text-slate-700">
                                    {{ $b->nama_bulan ?? $b->bulan }} {{ $b->tahun }}
                                    <span class="block text-[10px] text-slate-400">Jatuh Tempo: {{ $b->tanggal_jatuh_tempo ? $b->tanggal_jatuh_tempo->format('d M Y') : '-' }}</span>
                                </td>
                                <td class="px-5 py-3.5 text-xs font-semibold text-slate-800">
                                    {{ number_format($b->total_kwh, 0, ',', '.') }} kWh
                                </td>
                                <td class="px-5 py-3.5 text-xs font-medium text-slate-700">
                                    Rp {{ number_format($b->total_biaya, 0, ',', '.') }}
                                </td>
                                <td class="px-5 py-3.5 text-xs font-medium {{ $b->denda > 0 ? 'text-amber-600 font-bold' : 'text-slate-400' }}">
                                    Rp {{ number_format($b->denda, 0, ',', '.') }}
                                </td>
                                <td class="px-5 py-3.5 text-xs font-black {{ $b->status === 'paid' ? 'text-emerald-600' : 'text-red-600' }}">
                                    Rp {{ number_format($b->total_bayar, 0, ',', '.') }}
                                </td>
                                <td class="px-5 py-3.5">
                                    @if($b->status === 'paid')
                                        <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-[11px] font-semibold bg-emerald-50 text-emerald-700">
                                            <i class="fas fa-check-circle text-[10px]"></i> Lunas
                                        </span>
                                    @elseif($isOverdue)
                                        @if($daysLate > 20)
                                            <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-red-100 text-red-800">
                                                <i class="fas fa-ban text-[10px]"></i> SPK Pemutusan (>20h)
                                            </span>
                                        @elseif($daysLate >= 7)
                                            <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-amber-100 text-amber-800">
                                                <i class="fas fa-exclamation-circle text-[10px]"></i> SP-2 (Lewat {{ $daysLate }}h)
                                            </span>
                                        @else
                                            <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-[10px] font-semibold bg-orange-100 text-orange-800">
                                                <i class="fas fa-clock text-[10px]"></i> SP-1 (Lewat {{ $daysLate }}h)
                                            </span>
                                        @endif
                                    @else
                                        <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-[11px] font-medium bg-slate-100 text-slate-700">
                                            <i class="fas fa-hourglass-start text-[10px]"></i> Belum Jatuh Tempo
                                        </span>
                                    @endif
                                </td>
                                <td class="px-5 py-3.5 text-right">
                                    @if($b->status !== 'paid')
                                        <a href="{{ route('admin.letters', ['type' => 'sp_tunggakan', 'bill_id' => $b->id]) }}"
                                           class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-[#00529C] hover:bg-[#003d75] text-white rounded-lg text-xs font-semibold shadow-xs transition-all whitespace-nowrap">
                                            <i class="fas fa-magic text-[10px] text-[#FDB813]"></i> Draft SP (AI)
                                        </a>
                                    @else
                                        <span class="text-xs text-slate-400 italic">Tidak ada aksi</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="px-5 py-12 text-center text-slate-400 text-sm">
                                    Tidak ada data tagihan yang sesuai dengan filter.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($bills->hasPages())
                <div class="px-5 py-4 border-t border-slate-100 bg-slate-50/50">
                    {{ $bills->links() }}
                </div>
            @endif
        </div>
    </div>
</section>
@endsection

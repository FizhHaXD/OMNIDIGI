@extends('layouts.main')
@section('title', 'Tiket Gangguan Listrik - Admin PLN DIGI')

@section('content')
{{-- Header --}}
<section class="relative -mt-16 md:-mt-18 bg-gradient-to-br from-[#001230] via-[#00265a] to-[#001a4d] text-white overflow-hidden">
    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-32 pb-8 md:pt-36 md:pb-10">
        <div class="flex flex-col md:flex-row md:items-end justify-between gap-6 mb-6">
            <div>
                <span class="inline-flex items-center gap-2 px-3.5 py-1 bg-white/10 rounded-full text-[#FDB813] text-xs font-semibold uppercase tracking-wider mb-3 border border-white/10">
                    <i class="fas fa-tools"></i> Pelayanan Teknik & Dispatch
                </span>
                <h1 class="text-3xl md:text-4xl font-extrabold tracking-tight">Tiket Laporan Gangguan Listrik</h1>
                <p class="text-white/60 text-sm mt-1">Klasifikasi tingkat keparahan gangguan dan dispatch Surat Perintah Kerja (SPK) YANTEK.</p>
            </div>
            
            <a href="{{ route('admin.letters', ['type' => 'spk_gangguan']) }}" class="btn-primary text-xs py-2.5 flex items-center gap-2">
                <i class="fas fa-file-signature text-xs"></i> Buat SPK Lapangan (AI)
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

        {{-- 4 Stat Cards --}}
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-6">
            <div class="card p-4">
                <p class="text-[11px] font-semibold text-slate-400 uppercase tracking-wider">Total Laporan Warga</p>
                <p class="text-2xl font-black text-slate-900 mt-1">{{ number_format($summary['total']) }}</p>
                <p class="text-[10px] text-slate-400 mt-0.5">Semua tiket tercatat</p>
            </div>
            <div class="card p-4 border-l-4 border-l-red-500">
                <p class="text-[11px] font-semibold text-red-600 uppercase tracking-wider">Gangguan Kritis (SLA 30m)</p>
                <p class="text-2xl font-black text-red-600 mt-1">{{ number_format($summary['kritis']) }}</p>
                <p class="text-[10px] text-red-500 font-semibold mt-0.5">Padam Total & Korsleting</p>
            </div>
            <div class="card p-4 border-l-4 border-l-amber-500">
                <p class="text-[11px] font-semibold text-amber-600 uppercase tracking-wider">Sedang Ditangani</p>
                <p class="text-2xl font-black text-amber-600 mt-1">{{ number_format($summary['diproses']) }}</p>
                <p class="text-[10px] text-slate-400 mt-0.5">Teknisi di lapangan</p>
            </div>
            <div class="card p-4 border-l-4 border-l-emerald-500">
                <p class="text-[11px] font-semibold text-emerald-600 uppercase tracking-wider">Penanganan Selesai</p>
                <p class="text-2xl font-black text-emerald-600 mt-1">{{ number_format($summary['selesai']) }}</p>
                <p class="text-[10px] text-emerald-600 font-semibold mt-0.5">Listrik normal kembali</p>
            </div>
        </div>

        {{-- Filters --}}
        <div class="card p-4 mb-6">
            <form method="GET" action="{{ route('admin.outages') }}" class="flex flex-col md:flex-row gap-3">
                <div class="flex-1 relative">
                    <i class="fas fa-search absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400 text-xs"></i>
                    <input type="text" name="q" value="{{ request('q') }}" placeholder="Cari berdasarkan lokasi atau deskripsi laporan..."
                           class="form-input text-xs pl-9 w-full rounded-xl">
                </div>
                <div class="w-full md:w-48">
                    <select name="kategori" class="form-input text-xs w-full rounded-xl" onchange="this.form.submit()">
                        <option value="">Semua Kategori</option>
                        <option value="padam_total" {{ request('kategori') === 'padam_total' ? 'selected' : '' }}>Padam Total (Kritis)</option>
                        <option value="korsleting" {{ request('kategori') === 'korsleting' ? 'selected' : '' }}>Korsleting (Kritis)</option>
                        <option value="tegangan_rendah" {{ request('kategori') === 'tegangan_rendah' ? 'selected' : '' }}>Tegangan Rendah</option>
                        <option value="meteran_rusak" {{ request('kategori') === 'meteran_rusak' ? 'selected' : '' }}>Meteran Rusak</option>
                        <option value="lainnya" {{ request('kategori') === 'lainnya' ? 'selected' : '' }}>Lainnya</option>
                    </select>
                </div>
                <div class="w-full md:w-44">
                    <select name="status" class="form-input text-xs w-full rounded-xl" onchange="this.form.submit()">
                        <option value="">Semua Status</option>
                        <option value="dilaporkan" {{ request('status') === 'dilaporkan' ? 'selected' : '' }}>Dilaporkan</option>
                        <option value="diproses" {{ request('status') === 'diproses' ? 'selected' : '' }}>Diproses</option>
                        <option value="selesai" {{ request('status') === 'selesai' ? 'selected' : '' }}>Selesai</option>
                    </select>
                </div>
                <button type="submit" class="btn-primary text-xs py-2 px-4 whitespace-nowrap">
                    Filter
                </button>
                @if(request()->hasAny(['q', 'kategori', 'status']))
                    <a href="{{ route('admin.outages') }}" class="btn-outline text-xs py-2 px-4 whitespace-nowrap text-slate-600">
                        Reset
                    </a>
                @endif
            </form>
        </div>

        {{-- Grid Tiket Gangguan --}}
        <div class="space-y-4">
            @forelse($outages as $o)
                @php
                    $isCritical = in_array($o->kategori, ['padam_total', 'korsleting']);
                @endphp
                <div class="card p-5 border-l-4 {{ $isCritical ? 'border-l-red-500' : 'border-l-[#00529C]' }} hover:shadow-md transition-shadow">
                    <div class="flex flex-col lg:flex-row lg:items-start justify-between gap-5">
                        
                        {{-- Info Detail --}}
                        <div class="flex-1">
                            <div class="flex flex-wrap items-center gap-2 mb-2">
                                <span class="font-mono font-bold text-xs text-[#00529C]">TIKET #{{ $o->id }}</span>
                                
                                {{-- Kategori Badge --}}
                                <span class="px-2.5 py-0.5 rounded text-[10px] font-bold uppercase tracking-wider
                                    {{ $isCritical ? 'bg-red-100 text-red-700' : 'bg-blue-50 text-blue-800' }}">
                                    <i class="fas {{ $isCritical ? 'fa-bolt text-red-500' : 'fa-info-circle text-blue-500' }} mr-1"></i>
                                    {{ $o->label_kategori }} {{ $isCritical ? '— Kritis' : '' }}
                                </span>

                                {{-- Status Badge --}}
                                <span class="px-2.5 py-0.5 rounded-full text-[10px] font-semibold
                                    {{ $o->status === 'selesai' ? 'bg-emerald-50 text-emerald-700 border border-emerald-200' : ($o->status === 'diproses' ? 'bg-amber-50 text-amber-700 border border-amber-200' : 'bg-red-50 text-red-700 border border-red-200') }}">
                                    @if($o->status === 'selesai')
                                        <i class="fas fa-check-circle text-[9px] mr-1"></i> Selesai Ditangani
                                    @elseif($o->status === 'diproses')
                                        <i class="fas fa-spinner fa-spin text-[9px] mr-1"></i> Sedang Ditangani YANTEK
                                    @else
                                        <i class="fas fa-clock text-[9px] mr-1"></i> Menunggu Dispatch
                                    @endif
                                </span>

                                <span class="text-xs text-slate-400">
                                    <i class="far fa-calendar-alt mr-1"></i> {{ $o->created_at->format('d M Y, H:i') }} WIB ({{ $o->created_at->diffForHumans() }})
                                </span>
                            </div>

                            <p class="text-sm font-bold text-slate-900 mb-1">
                                <i class="fas fa-map-marker-alt text-red-500 mr-1.5"></i> {{ $o->lokasi }}
                            </p>

                            <p class="text-xs text-slate-600 leading-relaxed mb-3 bg-slate-50 p-3 rounded-xl border border-slate-100">
                                {{ $o->deskripsi }}
                            </p>

                            <div class="flex flex-wrap items-center gap-4 text-xs text-slate-500">
                                <span><i class="fas fa-user mr-1 text-slate-400"></i> Pelapor: <strong>{{ $o->user->name ?? 'Masyarakat' }}</strong></span>
                                @if($o->customer)
                                    <span><i class="fas fa-bolt mr-1 text-[#FDB813]"></i> ID Pelanggan: <strong>{{ $o->customer->id_pelanggan }}</strong></span>
                                @endif
                                @if($o->foto)
                                    <a href="{{ asset('storage/' . $o->foto) }}" target="_blank" class="text-[#00529C] hover:underline font-semibold flex items-center gap-1">
                                        <i class="fas fa-image"></i> Lihat Foto Bukti
                                    </a>
                                @endif
                            </div>

                            {{-- Catatan Petugas (Jika Ada) --}}
                            @if($o->catatan_petugas)
                                <div class="mt-3 p-3 bg-blue-50/70 border border-blue-100 rounded-xl text-xs text-blue-900">
                                    <p class="font-bold flex items-center gap-1.5">
                                        <i class="fas fa-user-shield text-[#00529C]"></i> Catatan Petugas Lapangan:
                                    </p>
                                    <p class="mt-0.5 text-blue-800">{{ $o->catatan_petugas }}</p>
                                </div>
                            @endif
                        </div>

                        {{-- Action Panel Update Status & SPK Generator --}}
                        <div class="bg-slate-50 p-4 rounded-2xl border border-slate-200/80 w-full lg:w-72 flex-shrink-0">
                            <p class="text-[11px] font-bold text-slate-700 uppercase tracking-wider mb-2">Tindakan Admin</p>
                            
                            {{-- Form Update Status --}}
                            <form method="POST" action="{{ route('admin.outages.status', $o) }}" class="space-y-2 mb-3">
                                @csrf
                                <select name="status" class="form-input text-xs w-full rounded-lg py-1.5 font-semibold">
                                    <option value="dilaporkan" {{ $o->status === 'dilaporkan' ? 'selected' : '' }}>Status: Dilaporkan</option>
                                    <option value="diproses" {{ $o->status === 'diproses' ? 'selected' : '' }}>Status: Diproses (Dispatch)</option>
                                    <option value="selesai" {{ $o->status === 'selesai' ? 'selected' : '' }}>Status: Selesai</option>
                                </select>
                                <textarea name="catatan_petugas" rows="2" placeholder="Catatan teknisi lapangan..." class="form-input text-xs w-full rounded-lg">{{ $o->catatan_petugas }}</textarea>
                                <button type="submit" class="btn-primary text-xs w-full py-1.5">
                                    Update Status Tiket
                                </button>
                            </form>

                            {{-- Generator SPK AI Ready --}}
                            <a href="{{ route('admin.letters', ['type' => 'spk_gangguan', 'outage_id' => $o->id]) }}"
                               class="w-full px-3 py-2 bg-amber-500 hover:bg-amber-600 text-white rounded-xl text-xs font-bold flex items-center justify-center gap-2 shadow-xs transition-all">
                                <i class="fas fa-magic text-[#001a4d]"></i>
                                <span>Terbitkan SPK (AI)</span>
                            </a>
                        </div>

                    </div>
                </div>
            @empty
                <div class="card p-12 text-center text-slate-400 text-sm">
                    <i class="fas fa-check-circle text-emerald-500 text-3xl mb-3 block"></i>
                    Tidak ada laporan gangguan yang sesuai filter. Jaringan kelistrikan beroperasi normal.
                </div>
            @endforelse
        </div>

        @if($outages->hasPages())
            <div class="mt-6">
                {{ $outages->links() }}
            </div>
        @endif

    </div>
</section>
@endsection

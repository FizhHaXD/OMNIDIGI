@extends('layouts.main')
@section('title', 'Laporan Gangguan - PLN DIGI')

@section('content')
<section class="relative -mt-16 md:-mt-18 bg-gradient-to-br from-[#001230] via-[#00265a] to-[#001a4d] text-white overflow-hidden">
    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-32 pb-8 md:pt-36 md:pb-10">
        <a href="{{ route('dashboard') }}" class="inline-flex items-center text-white/50 hover:text-white text-sm mb-3 transition-colors">
            <i class="fas fa-arrow-left mr-2"></i> Kembali ke Dashboard
        </a>
        <h1 class="text-2xl md:text-3xl font-bold">Laporan Gangguan</h1>
        <p class="text-white/50 mt-1 text-sm">Riwayat laporan gangguan listrik Anda.</p>
    </div>
</section>

<section class="py-8 md:py-10">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">

        {{-- Flash --}}
        @if(session('success'))
            <div class="bg-emerald-50 border border-emerald-200 text-emerald-700 px-5 py-4 rounded-xl mb-6 flex items-center gap-3">
                <i class="fas fa-check-circle text-emerald-500"></i>
                <p class="text-sm">{{ session('success') }}</p>
            </div>
        @endif

        <div class="flex justify-end mb-5">
            <a href="{{ route('dashboard.outage.create') }}" class="btn-primary text-sm">
                <i class="fas fa-plus mr-1.5"></i> Buat Laporan Baru
            </a>
        </div>

        @if($reports->isEmpty())
            <div class="card p-10 text-center">
                <div class="w-14 h-14 bg-red-50 rounded-2xl flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-exclamation-triangle text-red-300 text-xl"></i>
                </div>
                <p class="text-slate-400 text-sm mb-3">Belum ada laporan gangguan.</p>
                <a href="{{ route('dashboard.outage.create') }}" class="btn-primary inline-flex text-sm">Buat Laporan Pertama</a>
            </div>
        @else
            <div class="space-y-4">
                @foreach($reports as $report)
                <div class="card p-5">
                    <div class="flex items-start justify-between gap-4">
                        <div class="flex-1">
                            <div class="flex items-center gap-2 mb-2">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                    {{ $report->status === 'selesai' ? 'bg-emerald-50 text-emerald-700' : ($report->status === 'diproses' ? 'bg-blue-50 text-blue-700' : 'bg-amber-50 text-amber-700') }}">
                                    @if($report->status === 'selesai') <i class="fas fa-check-circle mr-1"></i>Selesai
                                    @elseif($report->status === 'diproses') <i class="fas fa-spinner mr-1"></i>Diproses
                                    @else <i class="fas fa-clock mr-1"></i>Dilaporkan
                                    @endif
                                </span>
                                <span class="text-xs text-slate-400">{{ $report->created_at->format('d M Y H:i') }}</span>
                            </div>
                            <h3 class="text-sm font-bold text-slate-800">{{ $report->label_kategori }}</h3>
                            <p class="text-sm text-slate-500 mt-1">{{ Str::limit($report->deskripsi, 120) }}</p>
                            <p class="text-xs text-slate-400 mt-2"><i class="fas fa-map-marker-alt mr-1"></i>{{ $report->lokasi }}</p>
                            @if($report->catatan_petugas)
                                <div class="mt-3 p-3 bg-blue-50 rounded-lg">
                                    <p class="text-xs text-blue-700"><i class="fas fa-comment mr-1"></i> <strong>Petugas:</strong> {{ $report->catatan_petugas }}</p>
                                </div>
                            @endif
                        </div>
                        @if($report->foto)
                        <img src="{{ asset('storage/' . $report->foto) }}" alt="Foto gangguan" class="w-20 h-20 object-cover rounded-xl flex-shrink-0">
                        @endif
                    </div>
                </div>
                @endforeach
            </div>
        @endif
    </div>
</section>
@endsection

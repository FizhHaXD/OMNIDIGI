@extends('layouts.main')
@section('title', 'Self Metering - PLN DIGI')

@section('content')
<section class="relative -mt-16 md:-mt-18 bg-gradient-to-br from-[#001230] via-[#00265a] to-[#001a4d] text-white overflow-hidden">
    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-32 pb-8 md:pt-36 md:pb-10">
        <a href="{{ route('dashboard') }}" class="inline-flex items-center text-white/50 hover:text-white text-sm mb-3 transition-colors">
            <i class="fas fa-arrow-left mr-2"></i> Kembali ke Dashboard
        </a>
        <h1 class="text-2xl md:text-3xl font-bold">Self Metering</h1>
        <p class="text-white/50 mt-1 text-sm">Laporkan pembacaan meteran listrik Anda secara mandiri.</p>
    </div>
</section>

<section class="py-8 md:py-12">
    <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8">

        {{-- Flash Messages --}}
        @if(session('success'))
            <div class="bg-emerald-50 border border-emerald-200 text-emerald-700 px-5 py-4 rounded-xl mb-6 flex items-center gap-3">
                <i class="fas fa-check-circle text-emerald-500"></i>
                <p class="text-sm">{{ session('success') }}</p>
            </div>
        @endif
        @if(session('error'))
            <div class="bg-red-50 border border-red-200 text-red-700 px-5 py-4 rounded-xl mb-6 flex items-center gap-3">
                <i class="fas fa-exclamation-circle text-red-500"></i>
                <p class="text-sm">{{ session('error') }}</p>
            </div>
        @endif

        @if(!$customer)
            <div class="card p-10 text-center">
                <i class="fas fa-exclamation-circle text-amber-400 text-3xl mb-3"></i>
                <p class="text-slate-600">Anda belum memiliki data pelanggan PLN.</p>
            </div>
        @else
            {{-- Last Reading Info --}}
            @if($lastReading)
            <div class="card p-5 mb-6 bg-slate-50 border-slate-200">
                <h3 class="text-sm font-bold text-slate-700 mb-3">Pembacaan Terakhir</h3>
                <div class="grid grid-cols-3 gap-4">
                    <div>
                        <p class="text-[11px] text-slate-400 uppercase tracking-wider">Periode</p>
                        <p class="text-sm font-semibold text-slate-700">{{ $lastReading->nama_bulan }} {{ $lastReading->tahun }}</p>
                    </div>
                    <div>
                        <p class="text-[11px] text-slate-400 uppercase tracking-wider">Meteran Akhir</p>
                        <p class="text-sm font-semibold text-slate-700 font-mono">{{ number_format($lastReading->meteran_akhir, 0, ',', '.') }}</p>
                    </div>
                    <div>
                        <p class="text-[11px] text-slate-400 uppercase tracking-wider">Pemakaian</p>
                        <p class="text-sm font-semibold text-emerald-600">{{ number_format($lastReading->meteran_akhir - $lastReading->meteran_awal, 0, ',', '.') }} kWh</p>
                    </div>
                </div>
            </div>
            @endif

            {{-- Status Jika Sudah Lapor Bulan Ini --}}
            @if($currentMonthReading)
            <div class="card p-6 mb-6 border-emerald-200 bg-emerald-50/50">
                <div class="flex items-start gap-4">
                    <div class="w-12 h-12 rounded-2xl bg-emerald-100 flex items-center justify-center flex-shrink-0">
                        <i class="fas fa-check-circle text-emerald-600 text-xl"></i>
                    </div>
                    <div class="flex-1">
                        <div class="flex items-center justify-between mb-1">
                            <h3 class="font-bold text-slate-800 text-base">Laporan Bulan Ini Telah Diterima</h3>
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold
                                {{ $currentMonthReading->status === 'billed' ? 'bg-blue-100 text-blue-800' : ($currentMonthReading->status === 'verified' ? 'bg-emerald-100 text-emerald-800' : 'bg-amber-100 text-amber-800') }}">
                                @if($currentMonthReading->status === 'billed')
                                    <i class="fas fa-file-invoice mr-1"></i> Tagihan Terbit
                                @elseif($currentMonthReading->status === 'verified')
                                    <i class="fas fa-badge-check mr-1"></i> Terverifikasi
                                @else
                                    <i class="fas fa-clock mr-1"></i> Menunggu Verifikasi
                                @endif
                            </span>
                        </div>
                        <p class="text-sm text-slate-600 mb-3">
                            Anda sudah melaporkan stand meter untuk periode <strong>{{ $currentMonthReading->nama_bulan }} {{ $currentMonthReading->tahun }}</strong>.
                        </p>
                        <div class="grid grid-cols-3 gap-3 bg-white p-3 rounded-xl border border-emerald-100 text-center">
                            <div>
                                <p class="text-[10px] text-slate-400 uppercase">Stand Awal</p>
                                <p class="text-xs font-mono font-semibold text-slate-700">{{ number_format($currentMonthReading->meteran_awal, 0, ',', '.') }}</p>
                            </div>
                            <div>
                                <p class="text-[10px] text-slate-400 uppercase">Stand Akhir</p>
                                <p class="text-xs font-mono font-semibold text-slate-900">{{ number_format($currentMonthReading->meteran_akhir, 0, ',', '.') }}</p>
                            </div>
                            <div>
                                <p class="text-[10px] text-slate-400 uppercase">Pemakaian</p>
                                <p class="text-xs font-semibold text-emerald-600">{{ number_format($currentMonthReading->meteran_akhir - $currentMonthReading->meteran_awal, 0, ',', '.') }} kWh</p>
                            </div>
                        </div>
                        <p class="text-xs text-slate-400 mt-3">
                            <i class="fas fa-calendar-alt mr-1 text-[#00529C]"></i> Pelaporan periode berikutnya dibuka pada tanggal <strong>24–27 {{ now()->addMonth()->translatedFormat('F Y') }}</strong>.
                        </p>
                    </div>
                </div>
            </div>
            @else
                {{-- Form Self Metering --}}
                <div class="card p-6">
                    <h2 class="text-lg font-bold text-slate-900 mb-1">Input Baca Meteran</h2>
                    <p class="text-sm text-slate-500 mb-5">Masukkan angka yang tertera di meteran listrik Anda saat ini.</p>

                    <form method="POST" action="{{ route('dashboard.metering.store') }}">
                        @csrf
                        <div class="mb-5">
                            <label for="meteran_akhir" class="block text-sm font-medium text-slate-700 mb-1.5">Angka Meteran Saat Ini</label>
                            <input type="number" name="meteran_akhir" id="meteran_akhir"
                                   class="form-input w-full text-lg font-mono"
                                   placeholder="{{ $lastReading ? 'Harus lebih dari ' . number_format($lastReading->meteran_akhir, 0, ',', '.') : 'Masukkan angka meteran' }}"
                                   min="{{ $lastReading ? $lastReading->meteran_akhir + 1 : 0 }}" required>
                            @error('meteran_akhir')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="bg-amber-50 border border-amber-200 rounded-xl p-4 mb-5">
                            <div class="flex gap-2">
                                <i class="fas fa-info-circle text-amber-500 mt-0.5"></i>
                                <div>
                                    <p class="text-sm text-amber-800 font-medium">Tips Self Metering</p>
                                    <ul class="text-xs text-amber-700 mt-1 space-y-0.5">
                                        <li>• Pastikan membaca angka meteran dari kiri ke kanan</li>
                                        <li>• Abaikan angka berwarna merah (desimal)</li>
                                        <li>• Laporkan sebelum tanggal 25 setiap bulan</li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                        <button type="submit" class="btn-primary w-full">
                            <i class="fas fa-paper-plane mr-2"></i> Kirim Pembacaan
                        </button>
                    </form>
                </div>
            @endif
        @endif
    </div>
</section>
@endsection

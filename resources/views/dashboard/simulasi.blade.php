@extends('layouts.main')
@section('title', 'Simulasi Keuangan - PLN DIGI')

@section('content')
<section class="relative -mt-16 md:-mt-18 bg-gradient-to-br from-[#001230] via-[#00265a] to-[#001a4d] text-white overflow-hidden">
    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-32 pb-8 md:pt-36 md:pb-10">
        <a href="{{ route('dashboard') }}" class="inline-flex items-center text-white/50 hover:text-white text-sm mb-3 transition-colors">
            <i class="fas fa-arrow-left mr-2"></i> Kembali ke Dashboard
        </a>
        <h1 class="text-2xl md:text-3xl font-bold">Simulasi Keuangan Listrik</h1>
        <p class="text-white/50 mt-1 text-sm">Hitung estimasi biaya listrik bulanan berdasarkan pemakaian Anda.</p>
    </div>
</section>

<section class="py-8 md:py-10">
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">

        @if(!$customer)
            <div class="card p-10 text-center">
                <i class="fas fa-exclamation-circle text-amber-400 text-3xl mb-3"></i>
                <p class="text-slate-600">Anda belum memiliki data pelanggan. Simulasi memerlukan data tarif Anda.</p>
            </div>
        @else
            {{-- Info Tarif --}}
            <div class="card p-5 mb-6 bg-[#00529C]/5 border-[#00529C]/10">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-[#00529C]/10 rounded-xl flex items-center justify-center">
                        <i class="fas fa-info-circle text-[#00529C]"></i>
                    </div>
                    <div>
                        <p class="text-sm font-semibold text-slate-700">Tarif Anda: {{ $customer->tariff->kode ?? '-' }} ({{ $customer->tariff->daya_va ?? '-' }} VA)</p>
                        <p class="text-xs text-slate-500">Harga per kWh: Rp {{ number_format($customer->tariff->harga_per_kwh ?? 0, 2, ',', '.') }} | Biaya Beban: Rp {{ number_format($customer->tariff->biaya_beban ?? 0, 0, ',', '.') }}</p>
                    </div>
                </div>
            </div>

            {{-- Form Simulasi --}}
            <div class="card p-6 mb-6">
                <h2 class="text-lg font-bold text-slate-900 mb-4">Masukkan Estimasi Pemakaian</h2>
                <form method="GET" action="{{ route('dashboard.simulasi') }}">
                    <div class="mb-4">
                        <label for="kwh" class="block text-sm font-medium text-slate-700 mb-1.5">Pemakaian kWh per Bulan</label>
                        <div class="relative">
                            <input type="number" name="kwh" id="kwh" value="{{ request('kwh', '') }}"
                                   class="form-input w-full pr-14" placeholder="Contoh: 200" min="0" step="1" required>
                            <span class="absolute right-4 top-1/2 -translate-y-1/2 text-slate-400 text-sm font-medium">kWh</span>
                        </div>
                    </div>
                    <button type="submit" class="btn-primary w-full">
                        <i class="fas fa-calculator mr-2"></i> Hitung Estimasi
                    </button>
                </form>
            </div>

            {{-- Hasil Simulasi --}}
            @if($estimasi)
            <div class="card overflow-hidden">
                <div class="bg-gradient-to-r from-[#00529C] to-[#003d75] p-5 text-white">
                    <h3 class="font-bold text-lg">Hasil Estimasi</h3>
                    <p class="text-white/60 text-sm">Berdasarkan tarif {{ $estimasi['tariff']->kode }} ({{ $estimasi['tariff']->daya_va }} VA)</p>
                </div>
                <div class="p-6">
                    <div class="space-y-3">
                        <div class="flex justify-between items-center py-2 border-b border-slate-100">
                            <span class="text-sm text-slate-600">Pemakaian</span>
                            <span class="text-sm font-semibold text-slate-800">{{ number_format($estimasi['kwh'], 0, ',', '.') }} kWh</span>
                        </div>
                        <div class="flex justify-between items-center py-2 border-b border-slate-100">
                            <span class="text-sm text-slate-600">Biaya Listrik ({{ number_format($estimasi['kwh'], 0) }} × Rp {{ number_format($estimasi['tariff']->harga_per_kwh, 2, ',', '.') }})</span>
                            <span class="text-sm font-semibold text-slate-800">Rp {{ number_format($estimasi['biaya_listrik'], 0, ',', '.') }}</span>
                        </div>
                        <div class="flex justify-between items-center py-2 border-b border-slate-100">
                            <span class="text-sm text-slate-600">Biaya Beban</span>
                            <span class="text-sm font-semibold text-slate-800">Rp {{ number_format($estimasi['biaya_beban'], 0, ',', '.') }}</span>
                        </div>
                        <div class="flex justify-between items-center py-2 border-b border-slate-100">
                            <span class="text-sm text-slate-600">PPJ (5%)</span>
                            <span class="text-sm font-semibold text-slate-800">Rp {{ number_format($estimasi['ppj'], 0, ',', '.') }}</span>
                        </div>
                        <div class="flex justify-between items-center py-3 bg-[#00529C]/5 rounded-xl px-4 mt-2">
                            <span class="text-base font-bold text-slate-900">Total Estimasi</span>
                            <span class="text-xl font-bold text-[#00529C]">Rp {{ number_format($estimasi['total'], 0, ',', '.') }}</span>
                        </div>
                    </div>
                </div>
            </div>
            @endif
        @endif
    </div>
</section>
@endsection

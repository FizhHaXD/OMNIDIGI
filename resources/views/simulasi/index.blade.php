@extends('layouts.main')
@section('title', 'Simulasi Pasang Listrik Baru - PLN DIGI')

@section('content')
{{-- Header --}}
<section class="relative -mt-16 md:-mt-18 bg-gradient-to-br from-[#001230] via-[#00265a] to-[#001a4d] text-white overflow-hidden">
    <div class="absolute inset-0 bg-[url('/images/hero-pln-1.jpg')] bg-cover bg-center opacity-15"></div>
    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-32 pb-16 md:pt-36 md:pb-20">
        <span class="inline-flex items-center gap-2 px-4 py-1.5 bg-white/10 rounded-full text-[#FDB813] text-xs font-semibold uppercase tracking-wider mb-4 border border-white/10">
            Simulasi Biaya
        </span>
        <h1 class="text-3xl md:text-4xl font-bold">Simulasi Pasang Listrik Baru</h1>
        <p class="text-white/50 mt-2 max-w-lg">Hitung estimasi biaya pemasangan listrik baru sesuai kebutuhan daya Anda.</p>
    </div>
</section>

<section class="py-12 md:py-16">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid md:grid-cols-2 gap-8">
            {{-- Form --}}
            <div class="card p-7">
                <h3 class="text-base font-bold text-slate-900 mb-5">Pilih Jenis Tarif</h3>
                <form action="{{ route('simulasi.hitung') }}" method="POST">
                    @csrf
                    <div class="space-y-3">
                        @foreach($tariffs as $tariff)
                            <label class="flex items-center gap-3 p-3.5 rounded-xl border cursor-pointer transition-all duration-200
                                {{ isset($result) && $result['tariff']->id === $tariff->id
                                    ? 'border-[#00529C] bg-[#00529C]/5'
                                    : 'border-slate-200 hover:border-slate-300 hover:bg-slate-50' }}">
                                <input type="radio" name="tariff_id" value="{{ $tariff->id }}"
                                       class="w-4 h-4 text-[#00529C] border-slate-300"
                                       {{ isset($result) && $result['tariff']->id === $tariff->id ? 'checked' : '' }}
                                       required>
                                <div class="flex-1 min-w-0">
                                    <p class="font-semibold text-sm text-slate-900">{{ $tariff->nama }}</p>
                                    <p class="text-xs text-slate-400 mt-0.5">{{ $tariff->kode }}</p>
                                </div>
                                <span class="text-xs font-bold text-[#00529C] bg-[#00529C]/8 px-2.5 py-1 rounded-full">{{ number_format($tariff->daya) }} VA</span>
                            </label>
                        @endforeach
                    </div>

                    @error('tariff_id')
                        <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
                    @enderror

                    <button type="submit" class="btn-blue w-full mt-6">
                        <i class="fas fa-calculator text-xs"></i> Hitung Estimasi
                    </button>
                </form>
            </div>

            {{-- Result --}}
            <div>
                @if(isset($result))
                    <div class="card p-7 border-[#00529C]/20">
                        <h3 class="text-base font-bold text-slate-900 mb-5">Estimasi Biaya</h3>

                        <div class="bg-slate-50 rounded-xl p-4 mb-5">
                            <p class="text-xs text-slate-400 mb-1">Jenis Tarif</p>
                            <p class="text-lg font-bold text-slate-900">{{ $result['tariff']->nama }}</p>
                            <p class="text-xs text-[#00529C] font-medium mt-0.5">{{ $result['tariff']->kode }} · {{ number_format($result['tariff']->daya) }} VA</p>
                        </div>

                        <div class="space-y-3">
                            <div class="flex justify-between items-center py-2.5 border-b border-slate-100">
                                <span class="text-sm text-slate-500">Biaya Pasang</span>
                                <span class="text-sm font-semibold text-slate-900">Rp {{ number_format($result['biaya_pasang'], 0, ',', '.') }}</span>
                            </div>
                            <div class="flex justify-between items-center py-2.5 border-b border-slate-100">
                                <span class="text-sm text-slate-500">Biaya Admin</span>
                                <span class="text-sm font-semibold text-slate-900">Rp {{ number_format($result['biaya_admin'], 0, ',', '.') }}</span>
                            </div>
                            <div class="flex justify-between items-center py-2.5 border-b border-slate-100">
                                <span class="text-sm text-slate-500">PPN (11%)</span>
                                <span class="text-sm font-semibold text-slate-900">Rp {{ number_format($result['ppn'], 0, ',', '.') }}</span>
                            </div>
                            <div class="flex justify-between items-center py-3.5 bg-[#00529C] text-white rounded-xl px-5 mt-2">
                                <span class="font-medium text-sm">Total Estimasi</span>
                                <span class="text-lg font-extrabold">Rp {{ number_format($result['total'], 0, ',', '.') }}</span>
                            </div>
                        </div>

                        @if($result['tariff']->deskripsi)
                            <div class="mt-5 p-3.5 bg-[#FDB813]/10 rounded-xl border border-[#FDB813]/20">
                                <p class="text-xs text-slate-600"><i class="fas fa-info-circle text-[#FDB813] mr-1.5"></i>{{ $result['tariff']->deskripsi }}</p>
                            </div>
                        @endif
                    </div>
                @else
                    <div class="card p-7 flex flex-col items-center justify-center text-center min-h-[400px]">
                        <div class="w-16 h-16 bg-slate-100 rounded-2xl flex items-center justify-center mb-4">
                            <i class="fas fa-calculator text-slate-300 text-2xl"></i>
                        </div>
                        <h3 class="font-bold text-slate-400 mb-1">Belum Ada Simulasi</h3>
                        <p class="text-slate-400 text-sm max-w-xs">Pilih jenis tarif di sebelah kiri untuk melihat estimasi biaya.</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</section>
@endsection

@extends('layouts.main')
@section('title', 'Beli Token Listrik - PLN DIGI')

@section('content')
{{-- Header --}}
<section class="relative -mt-16 md:-mt-18 bg-gradient-to-br from-[#001230] via-[#00265a] to-[#001a4d] text-white overflow-hidden">
    <div class="absolute inset-0 bg-[url('https://images.unsplash.com/photo-1473341304170-971dccb5ac1e?w=1920&q=80')] bg-cover bg-center opacity-10 mix-blend-luminosity"></div>
    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-32 pb-16 md:pt-36 md:pb-20">
        <span class="inline-flex items-center gap-2 px-4 py-1.5 bg-white/10 rounded-full text-[#FDB813] text-xs font-semibold uppercase tracking-wider mb-4 border border-white/10">
            Token Listrik
        </span>
        <h1 class="text-3xl md:text-4xl font-bold">Beli Token Listrik</h1>
        <p class="text-white/50 mt-2">Masukkan ID Pelanggan atau Nomor Meter untuk beli token listrik prabayar.</p>
    </div>
</section>

<section class="py-12 md:py-16">
    <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8">

        {{-- Alert error --}}
        @if(session('error'))
            <div class="bg-red-50 border border-red-200 text-red-700 rounded-xl px-5 py-4 mb-5 flex items-center gap-3">
                <i class="fas fa-exclamation-circle text-red-500"></i>
                <p class="text-sm font-medium">{{ session('error') }}</p>
            </div>
        @endif

        {{-- Form Cek --}}
        <div class="card p-7">
            <h3 class="text-base font-bold text-slate-900 mb-4">Cek Nomor Meter / ID Pelanggan</h3>
            <form action="{{ route('produk.cekToken') }}" method="POST">
                @csrf
                <label class="form-label">Nomor Meter / ID Pelanggan</label>
                <div class="flex gap-3">
                    <input type="text" name="no_meter" class="form-input flex-1"
                           placeholder="Contoh: 531200012345"
                           value="{{ old('no_meter', isset($customer) ? ($customer->id_pelanggan ?? $customer->no_meter) : '') }}" required>
                    <button type="submit" class="btn-blue whitespace-nowrap">
                        <i class="fas fa-search text-xs"></i> Cek
                    </button>
                </div>
                @error('no_meter')
                    <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
                @enderror
            </form>
        </div>

        {{-- Result --}}
        @if(isset($customer))
            <div class="card p-7 mt-6 border-[#00529C]/20">
                <h3 class="text-base font-bold text-slate-900 mb-5">Data Pelanggan</h3>

                <div class="grid grid-cols-2 gap-3 mb-5">
                    <div class="bg-slate-50 rounded-xl p-3.5">
                        <p class="text-[10px] text-slate-400 uppercase tracking-wider mb-0.5">ID Pelanggan / Meter</p>
                        <p class="font-semibold text-sm text-slate-900 font-mono">{{ $customer->id_pelanggan }}</p>
                    </div>
                    <div class="bg-slate-50 rounded-xl p-3.5">
                        <p class="text-[10px] text-slate-400 uppercase tracking-wider mb-0.5">Nama Pelanggan</p>
                        <p class="font-semibold text-sm text-slate-900">{{ $customer->nama }}</p>
                    </div>
                    <div class="bg-slate-50 rounded-xl p-3.5">
                        <p class="text-[10px] text-slate-400 uppercase tracking-wider mb-0.5">Tarif / Daya</p>
                        <p class="font-semibold text-sm text-slate-900">
                            {{ $customer->tariff->kode ?? '-' }} / {{ number_format($customer->tariff->daya_va ?? 0) }} VA
                        </p>
                    </div>
                    <div class="bg-slate-50 rounded-xl p-3.5">
                        <p class="text-[10px] text-slate-400 uppercase tracking-wider mb-0.5">Alamat</p>
                        <p class="font-semibold text-sm text-slate-900 leading-snug">{{ $customer->alamat }}</p>
                    </div>
                </div>

                {{-- Banner Total Pembelian Token (Biru PLN & Kuning PLN) --}}
                <div class="bg-[#00529C] text-white rounded-xl p-5 mb-5">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-white/60 text-xs">Total Pembelian Token</p>
                            <p class="text-2xl font-extrabold mt-0.5" id="banner-amount">Rp 50.000</p>
                            <p class="text-white/50 text-xs mt-1" id="banner-kwh">Estimasi daya didapat: ~32 kWh</p>
                        </div>
                        <span class="bg-[#FDB813] text-[#001a4d] px-3.5 py-1 rounded-full text-xs font-bold">Prabayar</span>
                    </div>
                </div>

                @auth
                    <form action="{{ route('produk.bayar') }}" method="POST">
                        @csrf
                        <input type="hidden" name="type" value="token">
                        <input type="hidden" name="no_meter" value="{{ $customer->id_pelanggan }}">

                        {{-- Pilihan Nominal Grid --}}
                        <label class="form-label">Pilih Nominal Token</label>
                        <div class="grid grid-cols-3 gap-3 mb-5">
                            @php
                                $nominals = [
                                    20000   => ['kwh' => '~12 kWh',  'label' => 'Rp 20.000'],
                                    50000   => ['kwh' => '~32 kWh',  'label' => 'Rp 50.000'],
                                    100000  => ['kwh' => '~65 kWh',  'label' => 'Rp 100.000'],
                                    200000  => ['kwh' => '~132 kWh', 'label' => 'Rp 200.000'],
                                    500000  => ['kwh' => '~336 kWh', 'label' => 'Rp 500.000'],
                                    1000000 => ['kwh' => '~676 kWh', 'label' => 'Rp 1.000.000'],
                                ];
                                $defaultNom = 50000;
                            @endphp
                            @foreach($nominals as $nom => $info)
                                <label class="flex flex-col items-center justify-center p-3 rounded-xl border border-slate-200 cursor-pointer hover:border-[#00529C]/40 hover:bg-[#00529C]/5 transition-all has-[:checked]:border-[#00529C] has-[:checked]:bg-[#00529C]/5">
                                    <input type="radio" name="amount" value="{{ $nom }}" class="sr-only" 
                                           {{ $nom === $defaultNom ? 'checked' : '' }}
                                           data-label="{{ $info['label'] }}" 
                                           data-kwh="{{ $info['kwh'] }}"
                                           onchange="updateTokenAmount(this)">
                                    <span class="font-bold text-slate-800 text-sm">{{ $info['label'] }}</span>
                                    <span class="text-[10px] text-slate-400 mt-0.5">{{ $info['kwh'] }}</span>
                                </label>
                            @endforeach
                        </div>

                        {{-- Metode Pembayaran (Sama persis dengan Tagihan) --}}
                        <label class="form-label">Metode Pembayaran</label>
                        <div class="grid grid-cols-3 gap-3 mb-5">
                            @foreach($paymentMethods as $index => $method)
                                <label class="flex flex-col items-center gap-2 p-3.5 rounded-xl border border-slate-200 cursor-pointer hover:border-[#00529C]/40 hover:bg-[#00529C]/5 transition-all has-[:checked]:border-[#00529C] has-[:checked]:bg-[#00529C]/5">
                                    <input type="radio" name="payment_method_id" value="{{ $method->id }}" class="sr-only" {{ $index === 0 ? 'checked' : '' }}>
                                    @if($method->kode === 'qris')
                                        <i class="fas fa-qrcode text-xl text-[#00529C]"></i>
                                    @elseif(in_array($method->kode, ['gopay', 'ovo', 'dana']))
                                        <i class="fas fa-wallet text-xl text-[#00529C]"></i>
                                    @elseif(in_array($method->kode, ['bca', 'mandiri', 'bni']))
                                        <i class="fas fa-university text-xl text-[#00529C]"></i>
                                    @else
                                        <i class="fas fa-money-bill text-xl text-[#00529C]"></i>
                                    @endif
                                    <span class="text-xs font-medium text-slate-700">{{ $method->nama }}</span>
                                </label>
                            @endforeach
                        </div>

                        <button type="submit" class="btn-blue w-full" id="btn-submit">
                            <i class="fas fa-credit-card text-xs"></i>
                            <span id="btn-text">Beli Token Rp 50.000</span>
                        </button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="btn-blue w-full text-center block">
                        Masuk untuk Beli Token
                    </a>
                @endauth
            </div>
        @endif

        {{-- Panduan Singkat --}}
        <div class="card p-5 mt-6 border border-slate-100">
            <h4 class="text-xs font-bold text-slate-700 uppercase tracking-wider mb-3 flex items-center gap-2">
                <i class="fas fa-info-circle text-[#00529C]"></i> Informasi Token Listrik
            </h4>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-3 text-xs text-slate-500">
                <div class="bg-slate-50 rounded-lg p-3">
                    <span class="font-semibold text-slate-800 block mb-1">1. Pilih & Bayar</span>
                    Pilih nominal token dan metode bayar sesuai keinginan Anda.
                </div>
                <div class="bg-slate-50 rounded-lg p-3">
                    <span class="font-semibold text-slate-800 block mb-1">2. Dapatkan 20 Digit</span>
                    Setelah pembayaran berhasil, Anda akan menerima 20 digit kode token.
                </div>
                <div class="bg-slate-50 rounded-lg p-3">
                    <span class="font-semibold text-slate-800 block mb-1">3. Masukkan ke Meteran</span>
                    Tekan 20 angka token pada keypad kWh meter, lalu tekan tombol Enter.
                </div>
            </div>
        </div>

    </div>
</section>

<script>
function updateTokenAmount(radio) {
    const label = radio.getAttribute('data-label');
    const kwh   = radio.getAttribute('data-kwh');
    
    document.getElementById('banner-amount').textContent = label;
    document.getElementById('banner-kwh').textContent = 'Estimasi daya didapat: ' + kwh;
    
    const btnText = document.getElementById('btn-text');
    if (btnText) {
        btnText.textContent = 'Beli Token ' + label;
    }
}
</script>
@endsection

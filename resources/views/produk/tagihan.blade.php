@extends('layouts.main')
@section('title', 'Bayar Tagihan Listrik - PLN DIGI')

@section('content')
{{-- Header --}}
<section class="relative -mt-16 md:-mt-18 bg-gradient-to-br from-[#001230] via-[#00265a] to-[#001a4d] text-white overflow-hidden">
    <div class="absolute inset-0 bg-[url('https://images.unsplash.com/photo-1473341304170-971dccb5ac1e?w=1920&q=80')] bg-cover bg-center opacity-10 mix-blend-luminosity"></div>
    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-32 pb-16 md:pt-36 md:pb-20">
        <span class="inline-flex items-center gap-2 px-4 py-1.5 bg-white/10 rounded-full text-[#FDB813] text-xs font-semibold uppercase tracking-wider mb-4 border border-white/10">
            Pembayaran Tagihan
        </span>
        <h1 class="text-3xl md:text-4xl font-bold">Bayar Tagihan Listrik</h1>
        <p class="text-white/50 mt-2">Masukkan ID Pelanggan untuk cek dan bayar tagihan.</p>
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
            <h3 class="text-base font-bold text-slate-900 mb-4">Cek Tagihan</h3>
            <form action="{{ route('produk.cekTagihan') }}" method="POST">
                @csrf
                <label class="form-label">ID Pelanggan</label>
                <div class="flex gap-3">
                    <input type="text" name="id_pelanggan" class="form-input flex-1"
                           placeholder="Contoh: 531200012345"
                           value="{{ old('id_pelanggan', isset($customer) ? $customer->id_pelanggan : '') }}" required>
                    <button type="submit" class="btn-blue whitespace-nowrap">
                        <i class="fas fa-search text-xs"></i> Cek
                    </button>
                </div>
                @error('id_pelanggan')
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
                        <p class="text-[10px] text-slate-400 uppercase tracking-wider mb-0.5">ID Pelanggan</p>
                        <p class="font-semibold text-sm text-slate-900">{{ $customer->id_pelanggan }}</p>
                    </div>
                    <div class="bg-slate-50 rounded-xl p-3.5">
                        <p class="text-[10px] text-slate-400 uppercase tracking-wider mb-0.5">Nama</p>
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

                {{-- Tagihan belum bayar --}}
                @php
                    $totalTagihan = $customer->total_tagihan;
                    $latestBill   = isset($unpaidBills) ? $unpaidBills->first() : null;
                @endphp

                <div class="bg-[#00529C] text-white rounded-xl p-5 mb-5">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-white/60 text-xs">Total Tagihan Tertunggak</p>
                            <p class="text-2xl font-extrabold mt-0.5">Rp {{ number_format($totalTagihan, 0, ',', '.') }}</p>
                            @if(isset($unpaidBills) && $unpaidBills->count() > 1)
                                <p class="text-white/50 text-xs mt-1">{{ $unpaidBills->count() }} tagihan belum dibayar</p>
                            @endif
                        </div>
                        @if($totalTagihan > 0)
                            <span class="bg-[#FDB813] text-[#001a4d] px-3.5 py-1 rounded-full text-xs font-bold">Belum Lunas</span>
                        @else
                            <span class="bg-emerald-400 text-emerald-900 px-3.5 py-1 rounded-full text-xs font-bold">Lunas</span>
                        @endif
                    </div>
                </div>

                {{-- Daftar tagihan per bulan --}}
                @if(isset($unpaidBills) && $unpaidBills->isNotEmpty())
                    <div class="mb-5 space-y-2">
                        <p class="text-xs font-semibold text-slate-500 uppercase tracking-wider mb-2">Rincian Tagihan</p>
                        @foreach($unpaidBills as $bill)
                            <div class="flex items-center justify-between bg-slate-50 rounded-lg px-4 py-2.5">
                                <div>
                                    <p class="text-sm font-medium text-slate-800">{{ $bill->nama_bulan }} {{ $bill->tahun }}</p>
                                    <p class="text-xs text-slate-400">{{ number_format($bill->total_kwh, 0, ',', '.') }} kWh
                                        @if($bill->denda > 0)
                                            · Denda Rp {{ number_format($bill->denda, 0, ',', '.') }}
                                        @endif
                                    </p>
                                </div>
                                <div class="text-right">
                                    <p class="text-sm font-semibold text-slate-900">Rp {{ number_format($bill->total_bayar, 0, ',', '.') }}</p>
                                    @if($bill->status === 'overdue')
                                        <span class="text-[10px] text-red-600 font-semibold">Jatuh Tempo</span>
                                    @else
                                        <span class="text-[10px] text-amber-600 font-semibold">Belum Bayar</span>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif

                @if($totalTagihan > 0)
                    @auth
                        <form action="{{ route('produk.bayar') }}" method="POST">
                            @csrf
                            <input type="hidden" name="type" value="tagihan">
                            <input type="hidden" name="amount" value="{{ $totalTagihan }}">
                            <input type="hidden" name="no_meter" value="{{ $customer->id_pelanggan }}">
                            {{-- Kirim bill_id tagihan terbaru yang belum dibayar --}}
                            @if($latestBill)
                                <input type="hidden" name="bill_id" value="{{ $latestBill->id }}">
                            @endif

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

                            <button type="submit" class="btn-blue w-full">
                                <i class="fas fa-credit-card text-xs"></i>
                                Bayar Rp {{ number_format($totalTagihan, 0, ',', '.') }}
                            </button>
                        </form>
                    @else
                        <a href="{{ route('login') }}" class="btn-blue w-full text-center block">
                            Masuk untuk Bayar
                        </a>
                    @endauth
                @else
                    <div class="bg-emerald-50 border border-emerald-200 rounded-xl p-4 text-center">
                        <i class="fas fa-check-circle text-emerald-500 text-2xl mb-2"></i>
                        <p class="text-emerald-700 font-semibold text-sm">Semua tagihan sudah lunas!</p>
                    </div>
                @endif
            </div>
        @endif
    </div>
</section>
@endsection

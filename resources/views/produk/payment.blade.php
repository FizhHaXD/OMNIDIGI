@extends('layouts.main')
@section('title', 'Pembayaran - PLN DIGI')

@section('content')
<section class="py-12 md:py-20 bg-slate-50 min-h-[60vh]">
    <div class="max-w-md mx-auto px-4 sm:px-6 lg:px-8">
        <div class="card p-7 text-center">
            {{-- Icon --}}
            <div class="w-14 h-14 bg-[#00529C]/10 rounded-2xl flex items-center justify-center mx-auto mb-5">
                @if($transaction->payment_method === 'qris')
                    <i class="fas fa-qrcode text-[#00529C] text-2xl"></i>
                @elseif($transaction->payment_method === 'ewallet')
                    <i class="fas fa-wallet text-[#00529C] text-2xl"></i>
                @else
                    <i class="fas fa-university text-[#00529C] text-2xl"></i>
                @endif
            </div>

            <h2 class="text-lg font-bold text-slate-900 mb-1">Konfirmasi Pembayaran</h2>
            <p class="text-slate-400 text-sm mb-6">Selesaikan pembayaran Anda</p>

            {{-- Detail --}}
            <div class="bg-slate-50 rounded-xl p-5 text-left mb-5 space-y-2.5">
                <div class="flex justify-between">
                    <span class="text-slate-400 text-sm">Jenis</span>
                    <span class="font-medium text-sm capitalize">{{ $transaction->type === 'tagihan' ? 'Bayar Tagihan' : 'Beli Token' }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-slate-400 text-sm">No. Meter</span>
                    <span class="font-medium text-sm">{{ $transaction->no_meter }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-slate-400 text-sm">Metode</span>
                    <span class="font-medium text-sm uppercase">{{ $transaction->payment_method }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-slate-400 text-sm">Referensi</span>
                    <span class="font-medium text-sm font-mono text-xs">{{ $transaction->ref_number }}</span>
                </div>
                <hr class="border-slate-200">
                <div class="flex justify-between items-center pt-1">
                    <span class="font-semibold text-slate-700">Total</span>
                    <span class="text-xl font-extrabold text-[#00529C]">Rp {{ number_format($transaction->amount, 0, ',', '.') }}</span>
                </div>
            </div>

            {{-- Payment Simulation --}}
            @if($transaction->payment_method === 'qris')
                <div class="border border-dashed border-slate-200 rounded-xl p-5 mb-5">
                    <div class="w-36 h-36 bg-slate-900 rounded-lg mx-auto mb-3 flex items-center justify-center">
                        <div class="grid grid-cols-5 gap-0.5 p-3">
                            @for($i = 0; $i < 25; $i++)
                                <div class="w-2.5 h-2.5 {{ rand(0,1) ? 'bg-white' : 'bg-slate-900' }} rounded-[1px]"></div>
                            @endfor
                        </div>
                    </div>
                    <p class="text-xs text-slate-400">Scan QR Code untuk membayar</p>
                </div>
            @elseif($transaction->payment_method === 'ewallet')
                <div class="bg-[#00529C]/5 rounded-xl p-5 mb-5 border border-[#00529C]/10">
                    <p class="text-sm text-[#00529C] mb-3">Bayar melalui e-wallet:</p>
                    <div class="flex justify-center gap-3">
                        <div class="bg-white rounded-lg p-2.5 shadow-sm border border-slate-100"><i class="fas fa-wallet text-lg text-green-600"></i></div>
                        <div class="bg-white rounded-lg p-2.5 shadow-sm border border-slate-100"><i class="fas fa-mobile-alt text-lg text-blue-600"></i></div>
                        <div class="bg-white rounded-lg p-2.5 shadow-sm border border-slate-100"><i class="fas fa-credit-card text-lg text-purple-600"></i></div>
                    </div>
                </div>
            @else
                <div class="bg-[#FDB813]/10 rounded-xl p-5 mb-5 border border-[#FDB813]/20">
                    <p class="text-sm text-slate-600 mb-1.5">Transfer ke rekening:</p>
                    <p class="text-lg font-bold font-mono text-slate-900">PLN - 1234 5678 9012</p>
                    <p class="text-xs text-slate-400">Bank Mandiri</p>
                </div>
            @endif

            {{-- Confirm --}}
            <form action="{{ route('produk.konfirmasi', $transaction) }}" method="POST">
                @csrf
                <button type="submit" class="btn-blue w-full py-3.5">
                    <i class="fas fa-check-circle text-xs"></i> Saya Sudah Bayar
                </button>
            </form>

            <a href="{{ route('produk') }}" class="inline-block mt-3 text-xs text-slate-400 hover:text-slate-600 transition-colors">
                Batalkan
            </a>
        </div>
    </div>
</section>
@endsection

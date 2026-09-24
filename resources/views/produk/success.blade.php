@extends('layouts.main')
@section('title', 'Pembayaran Berhasil - PLN DIGI')

@section('content')
<section class="py-16 md:py-24 bg-slate-50 min-h-[70vh]">
    <div class="max-w-lg mx-auto px-4 sm:px-6 lg:px-8">

        {{-- Success Card --}}
        <div class="card p-8 text-center">

            {{-- Animated Checkmark --}}
            <div class="w-20 h-20 bg-emerald-100 rounded-full flex items-center justify-center mx-auto mb-6 relative">
                <div class="w-16 h-16 bg-emerald-500 rounded-full flex items-center justify-center animate-pulse-once">
                    <i class="fas fa-check text-white text-2xl"></i>
                </div>
                <div class="absolute inset-0 rounded-full border-4 border-emerald-300 animate-ping opacity-30"></div>
            </div>

            <h2 class="text-2xl font-bold text-slate-900 mb-1">Pembayaran Berhasil!</h2>
            <p class="text-slate-400 text-sm mb-7">
                Transaksi Anda telah diproses dan tercatat di sistem PLN DIGI.
            </p>

            {{-- Detail Transaksi --}}
            <div class="bg-slate-50 rounded-2xl p-5 text-left mb-6 space-y-3 border border-slate-100">
                <div class="flex justify-between items-center">
                    <span class="text-slate-400 text-sm">No. Referensi</span>
                    <span class="font-mono text-xs font-semibold text-slate-700 bg-slate-100 px-2 py-1 rounded-lg">{{ $transaction->ref_number }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-slate-400 text-sm">Jenis Transaksi</span>
                    <span class="font-medium text-sm capitalize">
                        {{ $transaction->type === 'tagihan' ? 'Bayar Tagihan' : 'Beli Token Listrik' }}
                    </span>
                </div>
                <div class="flex justify-between">
                    <span class="text-slate-400 text-sm">No. Meter</span>
                    <span class="font-medium text-sm font-mono">{{ $transaction->no_meter }}</span>
                </div>
                @if($transaction->customer)
                    <div class="flex justify-between">
                        <span class="text-slate-400 text-sm">Nama Pelanggan</span>
                        <span class="font-medium text-sm">{{ $transaction->customer->nama }}</span>
                    </div>
                @endif
                <div class="flex justify-between">
                    <span class="text-slate-400 text-sm">Metode Bayar</span>
                    <span class="font-medium text-sm">{{ $transaction->paymentMethod->nama ?? '-' }}</span>
                </div>
                @if($transaction->type === 'tagihan' && $transaction->bill)
                    <div class="flex justify-between">
                        <span class="text-slate-400 text-sm">Periode Tagihan</span>
                        <span class="font-medium text-sm">{{ $transaction->bill->nama_bulan }} {{ $transaction->bill->tahun }}</span>
                    </div>
                @endif
                <hr class="border-slate-200">
                <div class="flex justify-between items-center">
                    <span class="font-bold text-slate-700">Total Dibayar</span>
                    <span class="text-xl font-extrabold text-emerald-600">Rp {{ number_format($transaction->amount, 0, ',', '.') }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-slate-400 text-sm">Tanggal</span>
                    <span class="font-medium text-sm">{{ $transaction->updated_at->format('d M Y, H:i') }} WIB</span>
                </div>
            </div>

            {{-- Token Listrik (jika beli token) --}}
            @if($transaction->type === 'token' && $transaction->token_listrik)
                <div class="bg-gradient-to-br from-[#00529C] to-[#003d78] rounded-2xl p-6 mb-6 text-white">
                    <p class="text-white/60 text-xs uppercase tracking-wider mb-2">Token Listrik Anda</p>
                    <div class="flex items-center justify-center gap-3 mb-3">
                        <i class="fas fa-bolt text-[#FDB813] text-xl"></i>
                        <p class="text-2xl font-extrabold font-mono tracking-widest text-[#FDB813]">{{ $transaction->token_listrik }}</p>
                        <button onclick="copyToken()" class="text-white/50 hover:text-white transition-colors" title="Salin token">
                            <i class="far fa-copy text-sm"></i>
                        </button>
                    </div>
                    <p class="text-white/50 text-xs">Masukkan kode token di meteran listrik Anda</p>
                    <p class="text-white/40 text-[10px] mt-1">Nominal: Rp {{ number_format($transaction->amount, 0, ',', '.') }}</p>
                </div>
                <script>
                    function copyToken() {
                        navigator.clipboard.writeText('{{ $transaction->token_listrik }}').then(() => {
                            const btn = document.querySelector('[onclick="copyToken()"]');
                            btn.innerHTML = '<i class="fas fa-check text-emerald-400 text-sm"></i>';
                            setTimeout(() => btn.innerHTML = '<i class="far fa-copy text-sm"></i>', 2000);
                        });
                    }
                </script>
            @endif

            {{-- Status Badge --}}
            <div class="inline-flex items-center gap-2 px-4 py-2 bg-emerald-50 border border-emerald-200 rounded-full text-emerald-700 text-sm font-semibold mb-7">
                <div class="w-2 h-2 bg-emerald-500 rounded-full"></div>
                Transaksi Sukses
            </div>

            {{-- Action Buttons --}}
            <div class="flex flex-col gap-3">
                <a href="{{ route('dashboard') }}" class="btn-blue w-full text-center">
                    <i class="fas fa-home text-xs"></i> Kembali ke Dashboard
                </a>
                @if($transaction->type === 'tagihan')
                    <a href="{{ route('dashboard.tagihan') }}" class="text-[#00529C] text-sm font-medium hover:underline">
                        Lihat Riwayat Tagihan
                    </a>
                @else
                    <a href="{{ route('dashboard.token') }}" class="text-[#00529C] text-sm font-medium hover:underline">
                        Lihat Riwayat Token
                    </a>
                @endif
            </div>
        </div>

    </div>
</section>

<style>
@keyframes pulse-once {
    0%, 100% { transform: scale(1); }
    50% { transform: scale(1.05); }
}
.animate-pulse-once {
    animation: pulse-once 0.6s ease-in-out;
}
</style>
@endsection

@extends('layouts.main')
@section('title', 'Konfirmasi Pembayaran - PLN DIGI')

@section('content')
<section class="py-12 md:py-20 bg-slate-50 min-h-[60vh]">
    <div class="max-w-md mx-auto px-4 sm:px-6 lg:px-8">
        <div class="card p-7 text-center">
            {{-- Icon berdasarkan metode pembayaran --}}
            <div class="w-14 h-14 bg-[#00529C]/10 rounded-2xl flex items-center justify-center mx-auto mb-5">
                @php $kode = $transaction->paymentMethod->kode ?? '' @endphp
                @if($kode === 'qris')
                    <i class="fas fa-qrcode text-[#00529C] text-2xl"></i>
                @elseif(in_array($kode, ['gopay', 'ovo', 'dana']))
                    <i class="fas fa-wallet text-[#00529C] text-2xl"></i>
                @elseif(in_array($kode, ['bca', 'mandiri', 'bni']))
                    <i class="fas fa-university text-[#00529C] text-2xl"></i>
                @else
                    <i class="fas fa-credit-card text-[#00529C] text-2xl"></i>
                @endif
            </div>

            <h2 class="text-lg font-bold text-slate-900 mb-1">Konfirmasi Pembayaran</h2>
            <p class="text-slate-400 text-sm mb-6">Selesaikan pembayaran Anda sebelum menekan tombol di bawah.</p>

            {{-- Detail Transaksi --}}
            <div class="bg-slate-50 rounded-xl p-5 text-left mb-5 space-y-2.5">
                <div class="flex justify-between">
                    <span class="text-slate-400 text-sm">Jenis</span>
                    <span class="font-medium text-sm capitalize">{{ $transaction->type === 'tagihan' ? 'Bayar Tagihan' : 'Beli Token' }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-slate-400 text-sm">No. Meter</span>
                    <span class="font-medium text-sm font-mono">{{ $transaction->no_meter }}</span>
                </div>
                @if($customer)
                    <div class="flex justify-between">
                        <span class="text-slate-400 text-sm">Nama Pelanggan</span>
                        <span class="font-medium text-sm">{{ $customer->nama }}</span>
                    </div>
                @endif
                <div class="flex justify-between">
                    <span class="text-slate-400 text-sm">Metode Bayar</span>
                    <span class="font-medium text-sm uppercase">{{ $transaction->paymentMethod->nama ?? '-' }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-slate-400 text-sm">No. Referensi</span>
                    <span class="font-medium font-mono text-xs text-slate-700">{{ $transaction->ref_number }}</span>
                </div>
                <hr class="border-slate-200">
                <div class="flex justify-between items-center pt-1">
                    <span class="font-semibold text-slate-700">Total Bayar</span>
                    <span class="text-xl font-extrabold text-[#00529C]">Rp {{ number_format($transaction->amount, 0, ',', '.') }}</span>
                </div>
            </div>

            {{-- Payment Simulation berdasarkan kode metode --}}
            @if($kode === 'qris')
                @php
                    $qrisPayload = route('qris.simulasi', $transaction->ref_number);
                @endphp
                <div class="border border-dashed border-slate-200 rounded-2xl p-6 mb-5 bg-white">
                    <div class="flex flex-col items-center">

                        {{-- QR Code Container --}}
                        <div class="bg-white p-3 rounded-xl shadow-sm border border-slate-100 inline-block mb-3 relative">
                            <div id="qrcode" class="flex justify-center items-center">
                                <img src="https://api.qrserver.com/v1/create-qr-code/?size=180x180&data={{ urlencode($qrisPayload) }}" alt="QR Code QRIS" class="w-[180px] h-[180px] rounded-lg">
                            </div>
                            <div class="absolute inset-0 flex items-center justify-center pointer-events-none">
                                <div class="w-9 h-9 bg-white rounded-lg shadow border border-slate-100 flex items-center justify-center">
                                    <i class="fas fa-bolt text-[#00529C] text-sm"></i>
                                </div>
                            </div>
                        </div>

                        {{-- Label & info QRIS --}}
                        <div class="flex items-center gap-3 w-full mb-2">
                            <div class="h-px flex-1 bg-slate-100"></div>
                            <span class="text-[11px] font-bold text-slate-400 uppercase tracking-widest">QRIS STANDAR</span>
                            <div class="h-px flex-1 bg-slate-100"></div>
                        </div>
                        <p class="text-xs text-slate-400">Scan dengan GoPay, OVO, Dana, ShopeePay, atau m-Banking</p>
                        
                        <div class="mt-3 bg-[#00529C]/5 rounded-xl px-5 py-2 inline-block">
                            <p class="text-base font-extrabold text-[#00529C]">Rp {{ number_format($transaction->amount, 0, ',', '.') }}</p>
                        </div>

                        {{-- Tombol Buka Simulasi Langsung --}}
                        <div class="mt-4 w-full">
                            <a href="{{ $qrisPayload }}" target="_blank" class="text-xs font-semibold text-[#00529C] bg-[#00529C]/10 hover:bg-[#00529C]/20 px-4 py-2 rounded-xl inline-flex items-center gap-1.5 transition-colors">
                                <i class="fas fa-mobile-screen-button"></i>
                                Simulasi Scan QR (Buka di Tab Baru)
                            </a>
                        </div>

                        <div id="status-wait-box" class="mt-3 flex items-center gap-1.5 text-[11px] text-amber-600">
                            <i class="fas fa-spinner fa-spin"></i>
                            <span>Menunggu pembayaran via scan...</span>
                        </div>
                    </div>
                </div>

            @elseif(in_array($kode, ['gopay', 'ovo', 'dana']))
                <div class="bg-[#00529C]/5 rounded-xl p-5 mb-5 border border-[#00529C]/10">
                    <p class="text-sm text-[#00529C] font-semibold mb-1">
                        {{ $transaction->paymentMethod->nama ?? 'E-Wallet' }}
                    </p>
                    <p class="text-xs text-slate-500 mb-3">Bayar ke nomor tujuan:</p>
                    <p class="text-lg font-bold font-mono text-slate-900">08 1234 5678 90</p>
                    <p class="text-xs text-slate-400 mt-1">Nominal tepat: Rp {{ number_format($transaction->amount, 0, ',', '.') }}</p>
                </div>
            @elseif(in_array($kode, ['bca', 'mandiri', 'bni']))
                <div class="bg-[#FDB813]/10 rounded-xl p-5 mb-5 border border-[#FDB813]/20">
                    <p class="text-sm text-slate-600 font-semibold mb-1">Transfer {{ $transaction->paymentMethod->nama ?? 'Bank' }}</p>
                    <p class="text-xs text-slate-500 mb-3">Rekening tujuan PLN:</p>
                    <p class="text-lg font-bold font-mono text-slate-900">PLN — 1234 5678 9012</p>
                    <p class="text-xs text-slate-400 mt-1">Nominal: Rp {{ number_format($transaction->amount, 0, ',', '.') }}</p>
                </div>
            @else
                <div class="bg-slate-100 rounded-xl p-5 mb-5 border border-slate-200">
                    <i class="fas fa-info-circle text-slate-400 text-2xl mb-2"></i>
                    <p class="text-sm text-slate-600">Selesaikan pembayaran sesuai metode yang dipilih.</p>
                </div>
            @endif

            {{-- Tombol Konfirmasi --}}
            <form action="{{ route('produk.konfirmasi', $transaction) }}" method="POST">
                @csrf
                <button type="submit" class="btn-blue w-full py-3.5">
                    <i class="fas fa-check-circle text-xs"></i> Saya Sudah Bayar
                </button>
            </form>

            <a href="{{ route('produk') }}" class="inline-block mt-3 text-xs text-slate-400 hover:text-slate-600 transition-colors">
                Batalkan Transaksi
            </a>
        </div>
    </div>
</section>

@if(($transaction->paymentMethod->kode ?? '') === 'qris')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const kodeTrx = @json($transaction->ref_number);
    const checkUrl = "{{ route('qris.check', ':kode') }}".replace(':kode', encodeURIComponent(kodeTrx));
    const waitBox  = document.getElementById('status-wait-box');

    const checkInterval = setInterval(() => {
        fetch(checkUrl, { headers: { 'Accept': 'application/json' } })
            .then(res => res.json())
            .then(data => {
                if (data.is_paid || data.status === 'success') {
                    clearInterval(checkInterval);
                    if (waitBox) {
                        waitBox.className = "mt-3 flex items-center justify-center gap-1.5 text-xs font-semibold text-emerald-700 bg-emerald-50 border border-emerald-200 rounded-xl py-2 px-3";
                        waitBox.innerHTML = '<i class="fas fa-check-circle text-emerald-600 text-sm"></i> <span>Pembayaran Berhasil Terverifikasi! Mengalihkan...</span>';
                    }
                    setTimeout(() => {
                        window.location.href = data.redirect_url;
                    }, 1200);
                }
            })
            .catch(() => {});
    }, 2500);
});
</script>
@endif
@endsection


@extends('layouts.main')
@section('title', 'Pembayaran QRIS - PLN DIGI')

@section('content')
<section class="py-12 md:py-20 bg-slate-50 min-h-[70vh]">
    <div class="max-w-md mx-auto px-4 sm:px-6 lg:px-8">
        <div class="card p-7 text-center shadow-lg border border-slate-100 relative overflow-hidden">
            
            {{-- Header QRIS PLN --}}
            <div class="flex items-center justify-between border-b border-slate-100 pb-4 mb-5">
                <div class="flex items-center gap-2">
                    <span class="w-8 h-8 rounded-lg bg-[#00529C] text-white flex items-center justify-center font-bold text-xs">
                        PLN
                    </span>
                    <span class="font-bold text-slate-800 text-sm">PLN DIGI Pay</span>
                </div>
                <div class="bg-slate-100 px-3 py-1 rounded-full text-[11px] font-semibold text-slate-600 flex items-center gap-1.5">
                    <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                    QRIS Standar
                </div>
            </div>

            <h2 class="text-lg font-bold text-slate-900 mb-1">Scan QRIS untuk Membayar</h2>
            <p class="text-slate-400 text-xs mb-5">Buka aplikasi m-Banking atau E-Wallet pilihan Anda, lalu scan kode QR di bawah ini.</p>

            {{-- Kotak QR Code --}}
            <div class="bg-white border-2 border-dashed border-slate-200 rounded-2xl p-5 mb-5 inline-block shadow-sm">
                <div id="qrcode-container" class="relative flex items-center justify-center min-w-[200px] min-h-[200px]">
                    {{-- Container JS QRCode --}}
                    <div id="qrcode" class="flex justify-center items-center"></div>

                    {{-- Logo QRIS di tengah --}}
                    <div class="absolute w-10 h-10 bg-white rounded-lg p-1 shadow-md border border-slate-100 flex items-center justify-center pointer-events-none">
                        <i class="fas fa-bolt text-[#00529C] text-base"></i>
                    </div>
                </div>

                {{-- Countdown timer --}}
                <div class="mt-3 pt-3 border-t border-slate-100 flex items-center justify-between text-xs text-slate-400">
                    <span>Berlaku hingga:</span>
                    <span id="countdown" class="font-bold font-mono text-[#00529C]">14:59</span>
                </div>
            </div>

            {{-- Detail Tagihan / Transaksi --}}
            <div class="bg-slate-50 rounded-xl p-4 text-left mb-5 space-y-2 border border-slate-100">
                <div class="flex justify-between items-center text-xs">
                    <span class="text-slate-400">Kode Transaksi</span>
                    <span class="font-mono font-semibold text-slate-700 select-all">{{ $kode }}</span>
                </div>
                @if(isset($transaction) && $transaction->no_meter)
                <div class="flex justify-between items-center text-xs">
                    <span class="text-slate-400">ID Pelanggan / Meter</span>
                    <span class="font-mono text-slate-600">{{ $transaction->no_meter }}</span>
                </div>
                @endif
                <div class="flex justify-between items-center text-xs">
                    <span class="text-slate-400">Metode</span>
                    <span class="font-semibold text-slate-700">QRIS (Semua Bank / E-Wallet)</span>
                </div>
                <hr class="border-slate-200">
                <div class="flex justify-between items-center pt-1">
                    <span class="text-sm font-semibold text-slate-700">Total Pembayaran</span>
                    <span class="text-xl font-extrabold text-[#00529C]">Rp {{ number_format($nominal, 0, ',', '.') }}</span>
                </div>
            </div>

            {{-- Status Menunggu / Berhasil --}}
            <div id="status-indicator" class="flex items-center justify-center gap-2 text-xs font-medium text-amber-600 bg-amber-50 border border-amber-200 rounded-xl py-2.5 px-4 mb-4">
                <i class="fas fa-spinner fa-spin"></i>
                <span>Menunggu scan & pembayaran...</span>
            </div>

            {{-- Tombol Simulasi Langsung (Test Mode) --}}
            <div class="space-y-2">
                <a href="{{ $payload }}" target="_blank" id="btn-simulasi" class="btn-blue w-full py-3 text-sm flex items-center justify-center gap-2">
                    <i class="fas fa-mobile-screen-button"></i>
                    Simulasi Scan QR (Buka Link)
                </a>
                <p class="text-[11px] text-slate-400">
                    💡 <span class="font-medium">Tips:</span> Anda bisa scan QR dengan kamera HP Anda, atau klik tombol di atas untuk mencoba simulasi pembayaran di tab baru.
                </p>
            </div>

            <div class="mt-4 pt-4 border-t border-slate-100 flex items-center justify-between text-xs text-slate-400">
                <a href="{{ route('dashboard') }}" class="hover:text-slate-600 transition-colors">
                    <i class="fas fa-arrow-left mr-1"></i> Dashboard
                </a>
                <a href="{{ route('produk') }}" class="hover:text-slate-600 transition-colors">
                    Batalkan
                </a>
            </div>
        </div>
    </div>
</section>

{{-- Library QRCode.js --}}
<script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const payloadUrl = @json($payload);
    const kodeTrx    = @json($kode);
    const qrcodeEl   = document.getElementById('qrcode');

    // 1. Generate QR Code
    try {
        if (typeof QRCode !== 'undefined') {
            new QRCode(qrcodeEl, {
                text: payloadUrl,
                width: 190,
                height: 190,
                colorDark : "#0f172a",
                colorLight : "#ffffff",
                correctLevel : QRCode.CorrectLevel.M
            });
        } else {
            throw new Error('QRCode lib not loaded');
        }
    } catch(e) {
        // Fallback jika CDN tidak aktif
        qrcodeEl.innerHTML = `<img src="https://api.qrserver.com/v1/create-qr-code/?size=190x190&data=${encodeURIComponent(payloadUrl)}" alt="QR Code" class="w-[190px] h-[190px] rounded-lg">`;
    }

    // 2. Countdown Timer 15 Menit
    let duration = 15 * 60;
    const countdownEl = document.getElementById('countdown');
    const timer = setInterval(() => {
        if (duration <= 0) {
            clearInterval(timer);
            countdownEl.textContent = 'Kedaluwarsa';
            countdownEl.classList.add('text-red-500');
            return;
        }
        duration--;
        const m = String(Math.floor(duration / 60)).padStart(2, '0');
        const s = String(duration % 60).padStart(2, '0');
        countdownEl.textContent = `${m}:${s}`;
    }, 1000);

    // 3. Auto Polling Status Transaksi (Tiap 2.5 Detik)
    const statusUrl = "{{ route('qris.check', ':kode') }}".replace(':kode', encodeURIComponent(kodeTrx));
    const statusEl  = document.getElementById('status-indicator');

    const checkInterval = setInterval(() => {
        fetch(statusUrl, { headers: { 'Accept': 'application/json' } })
            .then(res => res.json())
            .then(data => {
                if (data.is_paid || data.status === 'success') {
                    clearInterval(checkInterval);
                    clearInterval(timer);
                    
                    statusEl.className = "flex items-center justify-center gap-2 text-xs font-semibold text-emerald-700 bg-emerald-50 border border-emerald-200 rounded-xl py-2.5 px-4 mb-4";
                    statusEl.innerHTML = '<i class="fas fa-check-circle text-emerald-600 text-sm"></i> <span>Pembayaran Berhasil! Mengalihkan...</span>';

                    setTimeout(() => {
                        window.location.href = data.redirect_url;
                    }, 1200);
                }
            })
            .catch(() => {});
    }, 2500);
});
</script>
@endsection

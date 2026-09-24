<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Simulasi Pembayaran QRIS - PLN DIGI</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-slate-100 flex items-center justify-center min-h-screen p-4 font-sans">
    <div class="bg-white max-w-sm w-full rounded-2xl shadow-xl overflow-hidden text-center p-6 border border-slate-200">
        
        {{-- Icon Sukses --}}
        <div class="w-16 h-16 bg-emerald-100 text-emerald-600 rounded-full flex items-center justify-center mx-auto mb-4">
            <i class="fas fa-check text-2xl"></i>
        </div>

        <h1 class="text-xl font-bold text-slate-800 mb-1">
            Pembayaran simulasi berhasil ✔
        </h1>
        <p class="text-slate-500 text-xs mb-5">
            QR Code telah berhasil di-scan & pembayaran terverifikasi otomatis oleh sistem PLN DIGI.
        </p>

        {{-- Detail Transaksi --}}
        <div class="bg-slate-50 rounded-xl p-4 text-left text-xs space-y-2.5 mb-6 border border-slate-100">
            <div class="flex justify-between">
                <span class="text-slate-400">Kode Transaksi:</span>
                <span class="font-mono font-semibold text-slate-700 select-all">{{ $kode }}</span>
            </div>
            @if($transaction)
            <div class="flex justify-between">
                <span class="text-slate-400">Jenis:</span>
                <span class="font-medium text-slate-700 capitalize">{{ $transaction->type === 'tagihan' ? 'Tagihan Listrik' : 'Token Listrik' }}</span>
            </div>
            <div class="flex justify-between">
                <span class="text-slate-400">Nominal:</span>
                <span class="font-bold text-[#00529C]">Rp {{ number_format($transaction->amount, 0, ',', '.') }}</span>
            </div>
            <div class="flex justify-between">
                <span class="text-slate-400">Status:</span>
                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-semibold bg-emerald-100 text-emerald-800">
                    Lunas (Paid)
                </span>
            </div>
            <div class="flex justify-between">
                <span class="text-slate-400">Waktu Bayar:</span>
                <span class="text-slate-600">{{ now()->format('d M Y, H:i') }} WIB</span>
            </div>
            @endif
        </div>

        {{-- Tombol Aksi --}}
        <div class="space-y-2">
            @if($transaction)
            <a href="{{ route('produk.sukses', $transaction) }}" class="block w-full bg-[#00529C] hover:bg-[#004080] text-white font-medium py-3 rounded-xl text-sm transition">
                Lihat Detail Transaksi
            </a>
            @endif
            <a href="{{ route('dashboard') }}" class="block w-full bg-slate-100 hover:bg-slate-200 text-slate-700 font-medium py-2.5 rounded-xl text-xs transition">
                Kembali ke Dashboard PLN DIGI
            </a>
        </div>

        <p class="text-[10px] text-slate-400 mt-4">
            Layar perangkat pembayaran Anda akan otomatis diperbarui.
        </p>
    </div>
</body>
</html>

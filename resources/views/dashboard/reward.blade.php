@extends('layouts.main')
@section('title', 'PLN Reward - PLN DIGI')

@section('content')
<section class="relative -mt-16 md:-mt-18 bg-gradient-to-br from-[#001230] via-[#00265a] to-[#001a4d] text-white overflow-hidden">
    <div class="absolute inset-0 opacity-10">
        <div class="absolute top-10 right-20 w-60 h-60 bg-[#FDB813] rounded-full blur-[100px]"></div>
    </div>
    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-32 pb-8 md:pt-36 md:pb-10">
        <a href="{{ route('dashboard') }}" class="inline-flex items-center text-white/50 hover:text-white text-sm mb-3 transition-colors">
            <i class="fas fa-arrow-left mr-2"></i> Kembali ke Dashboard
        </a>
        <h1 class="text-2xl md:text-3xl font-bold">PLN Reward</h1>
        <p class="text-white/50 mt-1 text-sm">Kumpulkan poin dari setiap transaksi dan tukar dengan hadiah menarik.</p>
    </div>
</section>

<section class="py-8 md:py-12">
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">

        {{-- Flash Messages --}}
        @if(session('success'))
            <div class="bg-emerald-50 border border-emerald-200 text-emerald-700 px-5 py-4 rounded-xl mb-6 flex items-center justify-between shadow-sm">
                <div class="flex items-center gap-3">
                    <i class="fas fa-check-circle text-emerald-500 text-lg"></i>
                    <p class="text-sm font-medium">{{ session('success') }}</p>
                </div>
                <button onclick="this.parentElement.remove()" class="text-emerald-500 hover:text-emerald-700"><i class="fas fa-times"></i></button>
            </div>
        @endif
        @if(session('error'))
            <div class="bg-red-50 border border-red-200 text-red-700 px-5 py-4 rounded-xl mb-6 flex items-center justify-between shadow-sm">
                <div class="flex items-center gap-3">
                    <i class="fas fa-exclamation-circle text-red-500 text-lg"></i>
                    <p class="text-sm font-medium">{{ session('error') }}</p>
                </div>
                <button onclick="this.parentElement.remove()" class="text-red-500 hover:text-red-700"><i class="fas fa-times"></i></button>
            </div>
        @endif

        {{-- Poin & Tier Card --}}
        <div class="bg-gradient-to-r from-[#00529C] to-[#003d75] rounded-2xl p-8 text-white mb-8 shadow-xl relative overflow-hidden">
            <div class="absolute top-0 right-0 w-40 h-40 bg-white/5 rounded-full -translate-y-1/2 translate-x-1/2"></div>
            <div class="relative flex flex-col md:flex-row md:items-center md:justify-between gap-6">
                <div>
                    <p class="text-white/50 text-xs uppercase tracking-widest mb-2">Sisa Poin Tersedia</p>
                    <p class="text-5xl font-extrabold tracking-tight" style="color: {{ $tierColor }}">{{ number_format($totalPoin, 0, ',', '.') }}</p>
                    <div class="flex items-center gap-2 mt-2">
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold" style="background: {{ $tierColor }}20; color: {{ $tierColor }}">
                            <i class="fas fa-crown mr-1.5"></i> {{ $tier }}
                        </span>
                        <span class="text-white/60 text-xs">• Total perolehan: {{ number_format($totalEarned, 0, ',', '.') }} poin ({{ $totalTransaksi }} transaksi)</span>
                    </div>
                </div>
                <div class="bg-white/10 backdrop-blur-sm rounded-xl px-6 py-4 border border-white/10 text-right md:text-left">
                    <p class="text-white/50 text-[11px] uppercase tracking-wider mb-1">Total Belanja</p>
                    <p class="text-xl font-bold">Rp {{ number_format($totalNominal, 0, ',', '.') }}</p>
                </div>
            </div>
        </div>

        {{-- Voucher Saya (Jika ada) --}}
        @if(isset($myClaims) && $myClaims->isNotEmpty())
        <div class="mb-8">
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-lg font-bold text-slate-900 flex items-center gap-2">
                    <i class="fas fa-ticket-alt text-[#FDB813]"></i> Voucher Saya
                </h2>
                <span class="text-xs text-slate-400">{{ $myClaims->count() }} voucher aktif</span>
            </div>
            <div class="grid md:grid-cols-2 gap-4">
                @foreach($myClaims as $claim)
                <div class="card p-5 border-l-4 border-l-[#00529C] bg-white flex flex-col justify-between">
                    <div class="flex items-start justify-between gap-3 mb-3">
                        <div>
                            <span class="inline-block px-2 py-0.5 rounded text-[10px] font-semibold uppercase tracking-wider
                                {{ $claim->status === 'active' ? 'bg-emerald-50 text-emerald-700 border border-emerald-200' : 'bg-slate-100 text-slate-500' }}">
                                {{ $claim->status === 'active' ? 'Aktif' : 'Digunakan' }}
                            </span>
                            <h3 class="font-bold text-slate-800 text-base mt-1">{{ $claim->nama }}</h3>
                            <p class="text-xs text-slate-400">Ditukar: {{ $claim->created_at->format('d M Y') }} · Berlaku s/d {{ $claim->expired_at?->format('d M Y') }}</p>
                        </div>
                        <div class="w-10 h-10 rounded-xl bg-[#00529C]/10 flex items-center justify-center text-[#00529C] flex-shrink-0">
                            <i class="fas fa-gift"></i>
                        </div>
                    </div>
                    <div class="bg-slate-50 rounded-xl p-3 border border-dashed border-slate-200 flex items-center justify-between">
                        <div>
                            <p class="text-[10px] text-slate-400 uppercase font-semibold">Kode Voucher</p>
                            <p class="font-mono font-bold text-[#00529C] text-sm tracking-wider">{{ $claim->voucher_code }}</p>
                        </div>
                        <button onclick="copyVoucher('{{ $claim->voucher_code }}', this)" class="px-3 py-1.5 bg-white border border-slate-200 rounded-lg text-xs font-semibold text-slate-700 hover:bg-slate-50 transition-colors flex items-center gap-1.5 shadow-sm">
                            <i class="far fa-copy text-slate-400"></i> Salin
                        </button>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        @endif

        {{-- Cara Dapat Poin --}}
        <div class="card p-6 mb-8">
            <h2 class="text-lg font-bold text-slate-900 mb-4">Cara Mendapat Poin</h2>
            <div class="grid md:grid-cols-2 gap-4">
                <div class="flex items-start gap-3 p-4 bg-slate-50 rounded-xl">
                    <div class="w-9 h-9 bg-[#00529C]/10 rounded-lg flex items-center justify-center flex-shrink-0">
                        <i class="fas fa-check text-[#00529C] text-sm"></i>
                    </div>
                    <div>
                        <p class="text-sm font-semibold text-slate-700">Transaksi Berhasil</p>
                        <p class="text-xs text-slate-500">+10 poin setiap transaksi yang berhasil</p>
                    </div>
                </div>
                <div class="flex items-start gap-3 p-4 bg-slate-50 rounded-xl">
                    <div class="w-9 h-9 bg-[#FDB813]/15 rounded-lg flex items-center justify-center flex-shrink-0">
                        <i class="fas fa-coins text-[#FDB813] text-sm"></i>
                    </div>
                    <div>
                        <p class="text-sm font-semibold text-slate-700">Bonus Nominal</p>
                        <p class="text-xs text-slate-500">+5 poin setiap kelipatan Rp 100.000</p>
                    </div>
                </div>
            </div>
        </div>

        {{-- Benefit List --}}
        <h2 class="text-lg font-bold text-slate-900 mb-4">Katalog Hadiah & Voucher</h2>
        <div class="grid md:grid-cols-2 gap-4 mb-6">
            @foreach($benefits as $benefit)
            <div class="card p-5 flex items-center gap-4 {{ $benefit['available'] ? 'hover:border-[#00529C]/30 transition-all' : 'opacity-60 bg-slate-50/50' }}">
                <div class="w-12 h-12 rounded-2xl flex items-center justify-center flex-shrink-0 {{ $benefit['available'] ? 'bg-[#FDB813]/20' : 'bg-slate-100' }}">
                    <i class="fas {{ $benefit['icon'] }} {{ $benefit['available'] ? 'text-[#00529C]' : 'text-slate-300' }} text-lg"></i>
                </div>
                <div class="flex-1">
                    <p class="text-sm font-bold text-slate-800">{{ $benefit['nama'] }}</p>
                    <p class="text-xs text-slate-500 mt-0.5">{{ $benefit['deskripsi'] }}</p>
                    <p class="text-xs font-semibold text-[#00529C] mt-1">{{ number_format($benefit['poin'], 0, ',', '.') }} poin</p>
                </div>
                <div>
                    @if($benefit['available'])
                        <form method="POST" action="{{ route('dashboard.reward.redeem') }}" onsubmit="return confirm('Tukarkan {{ number_format($benefit['poin'], 0, ',', '.') }} poin untuk {{ $benefit['nama'] }}?')">
                            @csrf
                            <input type="hidden" name="reward_id" value="{{ $benefit['id'] }}">
                            <button type="submit" class="px-4 py-2 bg-[#00529C] text-white text-xs font-semibold rounded-xl hover:bg-[#003d75] shadow hover:shadow-md transition-all whitespace-nowrap">
                                Tukar Poin
                            </button>
                        </form>
                    @else
                        <span class="px-3 py-1.5 bg-slate-100 text-slate-400 text-xs font-medium rounded-lg whitespace-nowrap">
                            Poin Kurang
                        </span>
                    @endif
                </div>
            </div>
            @endforeach
        </div>

        <div class="p-4 bg-blue-50 border border-blue-200 rounded-xl flex items-center gap-3">
            <i class="fas fa-info-circle text-[#00529C] text-lg"></i>
            <p class="text-xs text-blue-900 leading-relaxed">
                Voucher yang telah ditukarkan akan berlaku selama 3 bulan dan dapat disalin kodenya di bagian <strong>Voucher Saya</strong> di atas untuk digunakan saat checkout pembayaran tagihan atau pembelian token.
            </p>
        </div>
    </div>
</section>

<script>
function copyVoucher(code, btn) {
    navigator.clipboard.writeText(code).then(() => {
        const originalHtml = btn.innerHTML;
        btn.innerHTML = '<i class="fas fa-check text-emerald-600"></i> Tersalin!';
        btn.classList.add('bg-emerald-50', 'text-emerald-700', 'border-emerald-300');
        setTimeout(() => {
            btn.innerHTML = originalHtml;
            btn.classList.remove('bg-emerald-50', 'text-emerald-700', 'border-emerald-300');
        }, 2000);
    });
}
</script>
@endsection

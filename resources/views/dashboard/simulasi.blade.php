@extends('layouts.main')
@section('title', 'Simulasi Keuangan - PLN DIGI')

@section('content')
<section class="relative -mt-16 md:-mt-18 bg-gradient-to-br from-[#001230] via-[#00265a] to-[#001a4d] text-white overflow-hidden">
    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-32 pb-8 md:pt-36 md:pb-10">
        <a href="{{ route('dashboard') }}" class="inline-flex items-center text-white/50 hover:text-white text-sm mb-3 transition-colors">
            <i class="fas fa-arrow-left mr-2"></i> Kembali ke Dashboard
        </a>
        <h1 class="text-2xl md:text-3xl font-bold">Simulasi Keuangan Listrik</h1>
        <p class="text-white/50 mt-1 text-sm">Hitung estimasi konsumsi alat elektronik dan proyeksi biaya listrik bulanan Anda.</p>
    </div>
</section>

<section class="py-8 md:py-10">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">

        {{-- Info Tarif Aktif & Selector --}}
        <div class="card p-5 mb-6 bg-slate-50 border-slate-200">
            <form method="GET" action="{{ route('dashboard.simulasi') }}" id="tariffForm">
                <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
                    <div class="flex items-center gap-3">
                        <div class="w-12 h-12 bg-[#00529C]/10 rounded-2xl flex items-center justify-center text-[#00529C] flex-shrink-0">
                            <i class="fas fa-bolt text-lg"></i>
                        </div>
                        <div>
                            @if($customer && (!$selectedTariff || $selectedTariff->id === $customer->tariff_id))
                                <span class="inline-block px-2 py-0.5 rounded text-[10px] font-bold bg-[#00529C]/10 text-[#00529C] uppercase tracking-wider mb-0.5">
                                    Tarif Pelanggan Anda
                                </span>
                            @else
                                <span class="inline-block px-2 py-0.5 rounded text-[10px] font-bold bg-amber-100 text-amber-800 uppercase tracking-wider mb-0.5">
                                    Simulasi Golongan Tarif
                                </span>
                            @endif
                            <h3 class="font-bold text-slate-800 text-base">
                                {{ $selectedTariff->kode ?? 'R1-1300' }} — {{ $selectedTariff->nama ?? 'Rumah Tangga' }} ({{ number_format($selectedTariff->daya_va ?? 1300) }} VA)
                            </h3>
                            <p class="text-xs text-slate-500 mt-0.5">
                                Tarif per kWh: <strong>Rp {{ number_format($selectedTariff->harga_per_kwh ?? 1444.7, 2, ',', '.') }}</strong> · Biaya Beban: <strong>Rp {{ number_format($selectedTariff->biaya_beban ?? 0, 0, ',', '.') }}</strong>
                            </p>
                        </div>
                    </div>
                    <div class="min-w-[200px]">
                        <label for="tariff_id" class="block text-[11px] font-semibold text-slate-400 uppercase tracking-wider mb-1">Ganti Golongan Tarif</label>
                        <select name="tariff_id" id="tariff_id" class="form-input text-xs w-full" onchange="this.form.submit()">
                            @foreach($tariffs as $t)
                                <option value="{{ $t->id }}" {{ (isset($selectedTariff) && $selectedTariff->id == $t->id) ? 'selected' : '' }}>
                                    {{ $t->kode }} ({{ number_format($t->daya_va) }} VA) — Rp {{ number_format($t->harga_per_kwh, 0) }}/kWh
                                </option>
                            @endforeach
                        </select>
                        <input type="hidden" name="kwh" id="tariff_kwh_input" value="{{ request('kwh', '') }}">
                    </div>
                </div>
            </form>
        </div>

        {{-- Tool Kalkulator Cerdas Elektronik --}}
        <div class="card p-6 mb-6" x-data="applianceCalculator()">
            <div class="flex items-center justify-between mb-4 pb-3 border-b border-slate-100">
                <div>
                    <h2 class="text-lg font-bold text-slate-900 flex items-center gap-2">
                        <i class="fas fa-calculator text-[#00529C]"></i> Kalkulator Peralatan Elektronik
                    </h2>
                    <p class="text-xs text-slate-500 mt-0.5">Pilih jumlah dan durasi pemakaian alat rumah tangga untuk menghitung estimasi kWh otomatis.</p>
                </div>
                <button type="button" @click="reset()" class="text-xs text-slate-400 hover:text-red-500 transition-colors">
                    <i class="fas fa-rotate-left mr-1"></i> Reset
                </button>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-5">
                <template x-for="(appliance, index) in appliances" :key="index">
                    <div class="p-3.5 rounded-xl border border-slate-100 bg-slate-50/50 hover:bg-slate-50 transition-colors flex items-center justify-between gap-3">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-xl bg-white border border-slate-200 flex items-center justify-center text-[#00529C] shadow-sm flex-shrink-0">
                                <i :class="appliance.icon"></i>
                            </div>
                            <div>
                                <p class="text-sm font-bold text-slate-800" x-text="appliance.name"></p>
                                <p class="text-[11px] text-slate-400" x-text="appliance.watt + ' Watt · ' + appliance.defaultDesc"></p>
                            </div>
                        </div>
                        <div class="flex items-center gap-2">
                            <div class="text-right">
                                <span class="text-[10px] text-slate-400 block">Unit</span>
                                <input type="number" min="0" max="20" class="w-12 text-center text-xs p-1 border border-slate-200 rounded-lg font-semibold"
                                       x-model.number="appliance.qty" @input="calculate()">
                            </div>
                            <div class="text-right">
                                <span class="text-[10px] text-slate-400 block">Jam/Hari</span>
                                <input type="number" min="0" max="24" class="w-12 text-center text-xs p-1 border border-slate-200 rounded-lg font-semibold"
                                       x-model.number="appliance.hours" @input="calculate()">
                            </div>
                        </div>
                    </div>
                </template>
            </div>

            <div class="bg-[#00529C]/5 rounded-2xl p-4 flex flex-col sm:flex-row items-center justify-between gap-4 border border-[#00529C]/10">
                <div>
                    <p class="text-xs text-slate-500">Estimasi Total Konsumsi dari Peralatan:</p>
                    <p class="text-2xl font-extrabold text-[#00529C]">
                        <span x-text="totalKwh"></span> <span class="text-sm font-semibold text-slate-600">kWh / bulan</span>
                    </p>
                </div>
                <button type="button" @click="applyKwh()" class="px-5 py-2.5 bg-[#00529C] hover:bg-[#003d75] text-white text-xs font-bold rounded-xl shadow transition-all flex items-center gap-2">
                    <i class="fas fa-arrow-down"></i> Terapkan ke Form Simulasi
                </button>
            </div>
        </div>

        {{-- Form Simulasi --}}
        <div class="card p-6 mb-6">
            <h2 class="text-lg font-bold text-slate-900 mb-1">Form Hitung Estimasi Biaya</h2>
            <p class="text-xs text-slate-500 mb-4">Anda juga dapat memasukkan angka kWh secara manual di bawah ini.</p>

            <form method="GET" action="{{ route('dashboard.simulasi') }}" id="calcForm">
                @if(request('tariff_id') || (isset($selectedTariff) && (!$customer || $selectedTariff->id !== $customer->tariff_id)))
                    <input type="hidden" name="tariff_id" value="{{ $selectedTariff->id ?? '' }}">
                @endif
                <div class="mb-4">
                    <label for="kwh" class="block text-sm font-medium text-slate-700 mb-1.5">Estimasi Pemakaian Bulanan (kWh)</label>
                    <div class="relative">
                        <input type="number" name="kwh" id="kwh" value="{{ request('kwh', '') }}"
                               class="form-input w-full pr-16 text-lg font-mono" placeholder="Contoh: 200" min="0" step="1" required>
                        <span class="absolute right-4 top-1/2 -translate-y-1/2 text-slate-400 text-sm font-semibold">kWh</span>
                    </div>
                </div>
                <button type="submit" class="btn-primary w-full py-3">
                    <i class="fas fa-calculator mr-2"></i> Hitung Estimasi Biaya
                </button>
            </form>
        </div>

        {{-- Hasil Simulasi --}}
        @if($estimasi)
        <div class="card overflow-hidden shadow-lg border-[#00529C]/20 mb-8 animate-slide-in">
            <div class="bg-gradient-to-r from-[#00529C] to-[#003d75] p-6 text-white flex items-center justify-between">
                <div>
                    <span class="inline-block px-2.5 py-0.5 rounded-full text-xs font-bold bg-[#FDB813] text-[#001a4d] uppercase mb-1">
                        Hasil Perhitungan
                    </span>
                    <h3 class="font-extrabold text-xl">Proyeksi Tagihan Listrik Bulanan</h3>
                    <p class="text-white/60 text-xs mt-0.5">Golongan Tarif: {{ $estimasi['tariff']->kode }} ({{ number_format($estimasi['tariff']->daya_va) }} VA) · Rp {{ number_format($estimasi['tariff']->harga_per_kwh, 2, ',', '.') }}/kWh</p>
                </div>
                <div class="w-12 h-12 bg-white/10 rounded-2xl flex items-center justify-center text-white text-xl">
                    <i class="fas fa-file-invoice-dollar"></i>
                </div>
            </div>
            <div class="p-6">
                <div class="space-y-3">
                    <div class="flex justify-between items-center py-2.5 border-b border-slate-100">
                        <span class="text-sm text-slate-600">Volume Pemakaian Listrik</span>
                        <span class="text-sm font-bold font-mono text-slate-800">{{ number_format($estimasi['kwh'], 0, ',', '.') }} kWh</span>
                    </div>
                    <div class="flex justify-between items-center py-2.5 border-b border-slate-100">
                        <span class="text-sm text-slate-600">Biaya Pemakaian ({{ number_format($estimasi['kwh'], 0) }} × Rp {{ number_format($estimasi['tariff']->harga_per_kwh, 2, ',', '.') }})</span>
                        <span class="text-sm font-semibold text-slate-800">Rp {{ number_format($estimasi['biaya_listrik'], 0, ',', '.') }}</span>
                    </div>
                    <div class="flex justify-between items-center py-2.5 border-b border-slate-100">
                        <span class="text-sm text-slate-600">Biaya Beban (Abunemen)</span>
                        <span class="text-sm font-semibold text-slate-800">Rp {{ number_format($estimasi['biaya_beban'], 0, ',', '.') }}</span>
                    </div>
                    <div class="flex justify-between items-center py-2.5 border-b border-slate-100">
                        <span class="text-sm text-slate-600">Pajak Penerangan Jalan / PPJ (5%)</span>
                        <span class="text-sm font-semibold text-slate-800">Rp {{ number_format($estimasi['ppj'], 0, ',', '.') }}</span>
                    </div>
                    <div class="flex justify-between items-center py-4 bg-gradient-to-r from-[#00529C]/10 to-[#00529C]/5 rounded-2xl px-5 mt-3 border border-[#00529C]/20">
                        <div>
                            <span class="text-xs uppercase tracking-wider font-bold text-slate-500 block">Total Estimasi Tagihan</span>
                            <span class="text-2xl font-extrabold text-[#00529C]">Rp {{ number_format($estimasi['total'], 0, ',', '.') }}</span>
                        </div>
                        <div class="text-right">
                            <span class="text-xs text-slate-500">Estimasi / hari:</span>
                            <p class="text-sm font-bold text-slate-800">~Rp {{ number_format($estimasi['total'] / 30, 0, ',', '.') }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endif

    </div>
</section>

<script>
function applianceCalculator() {
    return {
        appliances: [
            { name: 'AC 1/2 PK (Hemat Energi)', watt: 350, defaultDesc: 'Kamar Tidur', qty: 1, hours: 8, icon: 'fas fa-snowflake' },
            { name: 'Kulkas 1 Pintu / 2 Pintu', watt: 100, defaultDesc: 'Menyala Terus', qty: 1, hours: 24, icon: 'fas fa-box' },
            { name: 'TV LED 32–43 Inch', watt: 60, defaultDesc: 'Ruang Keluarga', qty: 1, hours: 5, icon: 'fas fa-tv' },
            { name: 'Mesin Cuci Otomatis', watt: 300, defaultDesc: 'Pemakaian Harian', qty: 1, hours: 2, icon: 'fas fa-soap' },
            { name: 'Rice Cooker / Magic Com', watt: 350, defaultDesc: 'Memasak & Menghangatkan', qty: 1, hours: 4, icon: 'fas fa-bowl-rice' },
            { name: 'Setrika Listrik', watt: 300, defaultDesc: 'Menyetrika Pakaian', qty: 1, hours: 1, icon: 'fas fa-shirt' },
            { name: 'Kipas Angin Berdiri', watt: 50, defaultDesc: 'Sirkulasi Ruangan', qty: 2, hours: 6, icon: 'fas fa-fan' },
            { name: 'Lampu LED Hemat Energi', watt: 10, defaultDesc: 'Penerangan Rumah', qty: 6, hours: 10, icon: 'fas fa-lightbulb' },
        ],
        totalKwh: 0,
        init() {
            this.calculate();
        },
        calculate() {
            let sumWattHour = 0;
            this.appliances.forEach(app => {
                const q = Math.max(0, app.qty || 0);
                const h = Math.min(24, Math.max(0, app.hours || 0));
                sumWattHour += (app.watt * q * h);
            });
            // 30 hari dalam 1 bulan / 1000 untuk kWh
            this.totalKwh = Math.round((sumWattHour * 30) / 1000);
        },
        reset() {
            this.appliances.forEach(app => {
                app.qty = 0;
                app.hours = 0;
            });
            this.totalKwh = 0;
        },
        applyKwh() {
            const input = document.getElementById('kwh');
            if (input) {
                input.value = this.totalKwh;
                document.getElementById('tariff_kwh_input').value = this.totalKwh;
                input.focus();
                input.scrollIntoView({ behavior: 'smooth', block: 'center' });
            }
        }
    }
}
</script>
@endsection

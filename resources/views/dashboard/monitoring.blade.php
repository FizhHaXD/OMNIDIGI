@extends('layouts.main')
@section('title', 'Monitoring Pemakaian - PLN DIGI')

@section('content')
<section class="relative -mt-16 md:-mt-18 bg-gradient-to-br from-[#001230] via-[#00265a] to-[#001a4d] text-white overflow-hidden">
    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-32 pb-8 md:pt-36 md:pb-10">
        <a href="{{ route('dashboard') }}" class="inline-flex items-center text-white/50 hover:text-white text-sm mb-3 transition-colors">
            <i class="fas fa-arrow-left mr-2"></i> Kembali ke Dashboard
        </a>
        <h1 class="text-2xl md:text-3xl font-bold">Monitoring Pemakaian</h1>
        <p class="text-white/50 mt-1 text-sm">Pantau konsumsi listrik dan biaya bulanan Anda.</p>
    </div>
</section>

<section class="py-8 md:py-12">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">

        @if(empty($chartData['labels']))
            <div class="card p-10 text-center">
                <div class="w-14 h-14 bg-indigo-50 rounded-2xl flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-chart-line text-indigo-300 text-xl"></i>
                </div>
                <p class="text-slate-700 font-semibold text-base">Belum ada data pemakaian atau transaksi</p>
                <p class="text-slate-400 text-xs mt-1">Data grafik akan terisi otomatis setelah Anda melakukan pembayaran tagihan listrik, pembelian token, atau pelaporan baca meter.</p>
            </div>
        @else
            {{-- Info Ringkasan Pelanggan --}}
            @if($customer)
            <div class="card p-4 mb-6 bg-slate-50 border-slate-200 flex flex-wrap items-center justify-between gap-4">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl bg-[#00529C]/10 flex items-center justify-center text-[#00529C]">
                        <i class="fas fa-bolt"></i>
                    </div>
                    <div>
                        <p class="text-xs text-slate-400">ID Pelanggan</p>
                        <p class="text-sm font-bold font-mono text-slate-800">{{ $customer->id_pelanggan }} <span class="text-xs font-normal text-slate-500">({{ $customer->tariff->kode ?? '-' }} / {{ number_format($customer->tariff->daya_va ?? 0) }} VA)</span></p>
                    </div>
                </div>
                <div class="flex items-center gap-2">
                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-emerald-50 text-emerald-700 border border-emerald-200">
                        <i class="fas fa-check-circle mr-1"></i> Data Terintegrasi
                    </span>
                </div>
            </div>
            @endif

            {{-- Grafik Konsumsi kWh --}}
            <div class="card p-6 mb-6">
                <div class="flex items-center justify-between mb-4">
                    <h2 class="text-lg font-bold text-slate-900">Konsumsi Listrik (kWh)</h2>
                    <span class="text-xs text-slate-400 font-medium">Satuan Kilowatt-hour</span>
                </div>
                <div style="height: 320px;">
                    <canvas id="chartKwh"></canvas>
                </div>
            </div>

            {{-- Grafik Biaya --}}
            @if(!empty($chartData['biaya']))
            <div class="card p-6 mb-6">
                <div class="flex items-center justify-between mb-4">
                    <h2 class="text-lg font-bold text-slate-900">Biaya Listrik (Rupiah)</h2>
                    <span class="text-xs text-slate-400 font-medium">Tagihan & Token</span>
                </div>
                <div style="height: 320px;">
                    <canvas id="chartBiaya"></canvas>
                </div>
            </div>
            @endif

            {{-- Summary Stats --}}
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                @php
                    $totalKwh = array_sum($chartData['kwh']);
                    $avgKwh = count($chartData['kwh']) > 0 ? $totalKwh / count($chartData['kwh']) : 0;
                    $maxKwh = !empty($chartData['kwh']) ? max($chartData['kwh']) : 0;
                    $minKwh = !empty($chartData['kwh']) ? min($chartData['kwh']) : 0;
                @endphp
                <div class="card p-5 text-center">
                    <p class="text-[11px] text-slate-400 uppercase tracking-wider mb-1">Total kWh</p>
                    <p class="text-2xl font-bold text-slate-900">{{ number_format($totalKwh, 0, ',', '.') }}</p>
                </div>
                <div class="card p-5 text-center">
                    <p class="text-[11px] text-slate-400 uppercase tracking-wider mb-1">Rata-rata / Bulan</p>
                    <p class="text-2xl font-bold text-[#00529C]">{{ number_format($avgKwh, 0, ',', '.') }}</p>
                </div>
                <div class="card p-5 text-center">
                    <p class="text-[11px] text-slate-400 uppercase tracking-wider mb-1">Tertinggi</p>
                    <p class="text-2xl font-bold text-red-500">{{ number_format($maxKwh, 0, ',', '.') }}</p>
                </div>
                <div class="card p-5 text-center">
                    <p class="text-[11px] text-slate-400 uppercase tracking-wider mb-1">Terendah</p>
                    <p class="text-2xl font-bold text-emerald-500">{{ number_format($minKwh, 0, ',', '.') }}</p>
                </div>
            </div>
        @endif
    </div>
</section>

{{-- Chart.js via CDN --}}
@if(!empty($chartData['labels']))
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.4/dist/chart.umd.min.js"></script>
<script>
    const labels = @json($chartData['labels']);

    // kWh Chart
    new Chart(document.getElementById('chartKwh'), {
        type: 'bar',
        data: {
            labels: labels,
            datasets: [{
                label: 'Konsumsi (kWh)',
                data: @json($chartData['kwh']),
                backgroundColor: 'rgba(0, 82, 156, 0.75)',
                borderColor: '#00529C',
                borderWidth: 1,
                borderRadius: 8,
                barPercentage: 0.6,
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: { 
                legend: { display: false },
                tooltip: {
                    callbacks: {
                        label: ctx => 'Konsumsi: ' + ctx.parsed.y.toLocaleString('id-ID') + ' kWh'
                    }
                }
            },
            scales: {
                y: { beginAtZero: true, grid: { color: '#f1f5f9' }, ticks: { callback: v => v + ' kWh' } },
                x: { grid: { display: false } }
            }
        }
    });

    // Biaya Chart
    @if(!empty($chartData['biaya']))
    new Chart(document.getElementById('chartBiaya'), {
        type: 'line',
        data: {
            labels: labels,
            datasets: [{
                label: 'Biaya (Rp)',
                data: @json($chartData['biaya']),
                borderColor: '#FDB813',
                backgroundColor: 'rgba(253, 184, 19, 0.1)',
                borderWidth: 3,
                tension: 0.3,
                fill: true,
                pointBackgroundColor: '#FDB813',
                pointRadius: 5,
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: { 
                legend: { display: false },
                tooltip: {
                    callbacks: {
                        label: ctx => 'Biaya: Rp ' + ctx.parsed.y.toLocaleString('id-ID')
                    }
                }
            },
            scales: {
                y: { beginAtZero: true, grid: { color: '#f1f5f9' },
                     ticks: { callback: v => 'Rp ' + v.toLocaleString('id-ID') } },
                x: { grid: { display: false } }
            }
        }
    });
    @endif
</script>
@endif
@endsection

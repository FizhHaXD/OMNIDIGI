<?php

namespace App\Http\Controllers;

use App\Models\Bill;
use App\Models\Customer;
use App\Models\MeterReading;
use App\Models\News;
use App\Models\Tariff;
use App\Models\Transaction;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Dashboard home — summary cards + quick actions
     */
    public function index()
    {
        $user = auth()->user();
        $customers = $user->customers()->with('tariff.category')->get();
        $customer = $customers->first();

        // Summary data
        $totalTagihan = 0;
        $tagihanBelumBayar = 0;
        $lastToken = null;

        if ($customer) {
            $totalTagihan = Bill::where('customer_id', $customer->id)
                ->whereIn('status', ['unpaid', 'overdue'])
                ->sum('total_biaya');

            $tagihanBelumBayar = Bill::where('customer_id', $customer->id)
                ->whereIn('status', ['unpaid', 'overdue'])
                ->count();
        }

        // Token listrik terakhir milik user yang sukses
        $lastToken = Transaction::where('user_id', $user->id)
            ->where('type', 'token')
            ->where('status', 'success')
            ->whereNotNull('token_listrik')
            ->latest()
            ->first();

        // Transaksi terakhir
        $recentTransactions = Transaction::where('user_id', $user->id)
            ->latest()
            ->take(5)
            ->get();

        return view('dashboard.index', compact(
            'user', 'customer', 'customers', 'totalTagihan',
            'tagihanBelumBayar', 'lastToken', 'recentTransactions'
        ));
    }

    /**
     * Tagihan Saya — daftar tagihan per bulan
     */
    public function tagihan()
    {
        $user = auth()->user();
        $customer = $user->customers()->first();

        $bills = collect();
        if ($customer) {
            $bills = Bill::where('customer_id', $customer->id)
                ->with('meterReading')
                ->orderByDesc('tahun')
                ->orderByDesc('bulan')
                ->get();
        }

        return view('dashboard.tagihan', compact('user', 'customer', 'bills'));
    }

    /**
     * Token Saya — riwayat pembelian token
     */
    public function token()
    {
        $user = auth()->user();
        $tokens = Transaction::where('user_id', $user->id)
            ->where('type', 'token')
            ->with('paymentMethod')
            ->latest()
            ->get();

        return view('dashboard.token', compact('user', 'tokens'));
    }

    /**
     * Simulasi Keuangan — estimasi biaya listrik bulanan
     */
    public function simulasiKeuangan(Request $request)
    {
        $user = auth()->user();
        $customer = $user->customers()->with('tariff')->first();
        $tariffs = Tariff::orderBy('daya_va')->get();

        // Tentukan tarif yang digunakan (dari request, dari customer, atau fallback ke R1-1300)
        $selectedTariff = null;
        if ($request->filled('tariff_id')) {
            $selectedTariff = Tariff::find($request->input('tariff_id'));
        }
        if (!$selectedTariff && $customer) {
            $selectedTariff = $customer->tariff;
        }
        if (!$selectedTariff && $tariffs->isNotEmpty()) {
            $selectedTariff = $tariffs->firstWhere('kode', 'R1-1300') ?? $tariffs->first();
        }

        $estimasi = null;
        if ($request->has('kwh') && $selectedTariff) {
            $kwh = max(0, (float) $request->input('kwh'));
            $biayaListrik = $kwh * $selectedTariff->harga_per_kwh;
            $biayaBeban = $selectedTariff->biaya_beban;
            $ppj = $biayaListrik * 0.05; // PPJ 5%
            $estimasi = [
                'kwh'           => $kwh,
                'biaya_listrik' => $biayaListrik,
                'biaya_beban'   => $biayaBeban,
                'ppj'           => $ppj,
                'total'         => $biayaListrik + $biayaBeban + $ppj,
                'tariff'        => $selectedTariff,
            ];
        }

        return view('dashboard.simulasi', compact('user', 'customer', 'tariffs', 'selectedTariff', 'estimasi'));
    }

    /**
     * Self Metering — form input baca meteran
     */
    public function selfMetering()
    {
        $user = auth()->user();
        $customer = $user->customers()->first();

        $lastReading = null;
        $currentMonthReading = null;

        if ($customer) {
            $lastReading = MeterReading::where('customer_id', $customer->id)
                ->orderByDesc('tahun')
                ->orderByDesc('bulan')
                ->first();

            $currentMonthReading = MeterReading::where('customer_id', $customer->id)
                ->where('bulan', now()->month)
                ->where('tahun', now()->year)
                ->first();
        }

        return view('dashboard.metering', compact('user', 'customer', 'lastReading', 'currentMonthReading'));
    }

    /**
     * Simpan baca meteran dari self metering
     */
    public function storeMeterReading(Request $request)
    {
        $request->validate([
            'meteran_akhir' => 'required|integer|min:0',
        ]);

        $user = auth()->user();
        $customer = $user->customers()->first();

        if (! $customer) {
            return back()->with('error', 'Anda belum memiliki data pelanggan.');
        }

        // Cek apakah sudah pernah lapor untuk bulan dan tahun berjalan
        $alreadySubmitted = MeterReading::where('customer_id', $customer->id)
            ->where('bulan', now()->month)
            ->where('tahun', now()->year)
            ->first();

        if ($alreadySubmitted) {
            return back()->with('error', 'Anda sudah melakukan pelaporan meteran untuk periode ' . $alreadySubmitted->nama_bulan . ' ' . $alreadySubmitted->tahun . ' (Stand: ' . number_format($alreadySubmitted->meteran_akhir, 0, ',', '.') . ' kWh). Pelaporan periode berikutnya dibuka bulan depan.');
        }

        $lastReading = MeterReading::where('customer_id', $customer->id)
            ->orderByDesc('tahun')
            ->orderByDesc('bulan')
            ->first();

        $meteranAwal = $lastReading ? $lastReading->meteran_akhir : 0;
        $meteranAkhir = (int) $request->input('meteran_akhir');

        if ($meteranAkhir <= $meteranAwal) {
            return back()->with('error', 'Angka meteran harus lebih besar dari pembacaan terakhir (' . number_format($meteranAwal, 0, ',', '.') . ').');
        }

        MeterReading::create([
            'customer_id'   => $customer->id,
            'bulan'         => now()->month,
            'tahun'         => now()->year,
            'meteran_awal'  => $meteranAwal,
            'meteran_akhir' => $meteranAkhir,
            'status'        => 'pending',
        ]);

        return back()->with('success', 'Pembacaan meteran berhasil dikirim! Selisih pemakaian: ' . number_format($meteranAkhir - $meteranAwal, 0, ',', '.') . ' kWh. Laporan Anda sedang menunggu verifikasi petugas.');
    }

    /**
     * Monitoring — grafik konsumsi & biaya
     */
    public function monitoring()
    {
        $user = auth()->user();
        $customer = $user->customers()->with('tariff')->first();
        $tarifKwh = $customer?->tariff?->harga_per_kwh ?? 1444.7;

        $bulanNames = [1=>'Jan',2=>'Feb',3=>'Mar',4=>'Apr',5=>'Mei',6=>'Jun',7=>'Jul',8=>'Agu',9=>'Sep',10=>'Okt',11=>'Nov',12=>'Des'];

        // Period map: [ 'YYYY-MM' => ['label' => 'Bulan YYYY', 'kwh' => 0, 'biaya' => 0, 'order' => YYYYMM] ]
        $periodData = [];

        // 1. Data Pascabayar dari MeterReading
        if ($customer) {
            $readings = MeterReading::where('customer_id', $customer->id)
                ->orderBy('tahun')
                ->orderBy('bulan')
                ->get();

            foreach ($readings as $r) {
                $key = sprintf('%04d-%02d', $r->tahun, $r->bulan);
                $kwh = max(0, $r->meteran_akhir - $r->meteran_awal);
                if (!isset($periodData[$key])) {
                    $periodData[$key] = [
                        'label' => ($bulanNames[$r->bulan] ?? $r->bulan) . ' ' . $r->tahun,
                        'kwh'   => 0,
                        'biaya' => 0,
                        'order' => ($r->tahun * 100) + $r->bulan,
                    ];
                }
                $periodData[$key]['kwh'] += $kwh;
            }

            // 2. Data Tagihan Listrik (Bill)
            $bills = Bill::where('customer_id', $customer->id)
                ->orderBy('tahun')
                ->orderBy('bulan')
                ->get();

            foreach ($bills as $b) {
                $key = sprintf('%04d-%02d', $b->tahun, $b->bulan);
                if (!isset($periodData[$key])) {
                    $periodData[$key] = [
                        'label' => ($bulanNames[$b->bulan] ?? $b->bulan) . ' ' . $b->tahun,
                        'kwh'   => (float) $b->total_kwh,
                        'biaya' => 0,
                        'order' => ($b->tahun * 100) + $b->bulan,
                    ];
                } elseif ($periodData[$key]['kwh'] == 0 && $b->total_kwh > 0) {
                    $periodData[$key]['kwh'] = (float) $b->total_kwh;
                }
                $periodData[$key]['biaya'] += (float) $b->total_biaya;
            }
        }

        // 3. Data Token Listrik (Prabayar)
        $tokenTransactions = Transaction::where('user_id', $user->id)
            ->where('type', 'token')
            ->where('status', 'success')
            ->get();

        foreach ($tokenTransactions as $t) {
            $m = (int) $t->created_at->format('n');
            $y = (int) $t->created_at->format('Y');
            $key = sprintf('%04d-%02d', $y, $m);

            $nominal = (float) $t->amount;
            $kwhToken = $tarifKwh > 0 ? round($nominal / $tarifKwh) : round($nominal / 1444.7);

            if (!isset($periodData[$key])) {
                $periodData[$key] = [
                    'label' => ($bulanNames[$m] ?? $m) . ' ' . $y,
                    'kwh'   => 0,
                    'biaya' => 0,
                    'order' => ($y * 100) + $m,
                ];
            }
            $periodData[$key]['kwh'] += $kwhToken;
            $periodData[$key]['biaya'] += $nominal;
        }

        // Urutkan berdasarkan urutan kronologis periode
        uasort($periodData, fn($a, $b) => $a['order'] <=> $b['order']);

        // Batasi maksimal 12 bulan terakhir
        if (count($periodData) > 12) {
            $periodData = array_slice($periodData, -12, 12, true);
        }

        $chartData = [
            'labels' => array_values(array_column($periodData, 'label')),
            'kwh'    => array_values(array_column($periodData, 'kwh')),
            'biaya'  => array_values(array_column($periodData, 'biaya')),
        ];

        return view('dashboard.monitoring', compact('user', 'customer', 'chartData'));
    }
}

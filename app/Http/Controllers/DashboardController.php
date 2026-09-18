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

            $lastToken = Transaction::where('user_id', $user->id)
                ->where('type', 'token')
                ->where('status', 'success')
                ->latest()
                ->first();
        }

        // Transaksi terakhir
        $recentTransactions = Transaction::where('user_id', $user->id)
            ->latest()
            ->take(5)
            ->get();

        // Berita terbaru
        $latestNews = News::published()->latest('published_at')->take(3)->get();

        return view('dashboard.index', compact(
            'user', 'customer', 'customers', 'totalTagihan',
            'tagihanBelumBayar', 'lastToken', 'recentTransactions', 'latestNews'
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

        $estimasi = null;
        if ($request->has('kwh') && $customer) {
            $kwh = (float) $request->input('kwh');
            $tariff = $customer->tariff;
            $biayaListrik = $kwh * $tariff->harga_per_kwh;
            $biayaBeban = $tariff->biaya_beban;
            $ppj = $biayaListrik * 0.05; // PPJ 5%
            $estimasi = [
                'kwh'           => $kwh,
                'biaya_listrik' => $biayaListrik,
                'biaya_beban'   => $biayaBeban,
                'ppj'           => $ppj,
                'total'         => $biayaListrik + $biayaBeban + $ppj,
                'tariff'        => $tariff,
            ];
        }

        return view('dashboard.simulasi', compact('user', 'customer', 'estimasi'));
    }

    /**
     * Self Metering — form input baca meteran
     */
    public function selfMetering()
    {
        $user = auth()->user();
        $customer = $user->customers()->first();

        $lastReading = null;
        if ($customer) {
            $lastReading = MeterReading::where('customer_id', $customer->id)
                ->orderByDesc('tahun')
                ->orderByDesc('bulan')
                ->first();
        }

        return view('dashboard.metering', compact('user', 'customer', 'lastReading'));
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
            'status'        => 'submitted',
        ]);

        return back()->with('success', 'Pembacaan meteran berhasil dikirim! Selisih: ' . number_format($meteranAkhir - $meteranAwal, 0, ',', '.') . ' kWh');
    }

    /**
     * Monitoring — grafik konsumsi & biaya
     */
    public function monitoring()
    {
        $user = auth()->user();
        $customer = $user->customers()->first();

        $chartData = ['labels' => [], 'kwh' => [], 'biaya' => []];

        if ($customer) {
            $readings = MeterReading::where('customer_id', $customer->id)
                ->orderBy('tahun')
                ->orderBy('bulan')
                ->get();

            $bills = Bill::where('customer_id', $customer->id)
                ->orderBy('tahun')
                ->orderBy('bulan')
                ->get();

            $bulanNames = [1=>'Jan',2=>'Feb',3=>'Mar',4=>'Apr',5=>'Mei',6=>'Jun',7=>'Jul',8=>'Agu',9=>'Sep',10=>'Okt',11=>'Nov',12=>'Des'];

            foreach ($readings as $r) {
                $label = ($bulanNames[$r->bulan] ?? $r->bulan) . ' ' . $r->tahun;
                $chartData['labels'][] = $label;
                $chartData['kwh'][] = $r->meteran_akhir - $r->meteran_awal;
            }

            foreach ($bills as $b) {
                $chartData['biaya'][] = (float) $b->total_biaya;
            }
        }

        return view('dashboard.monitoring', compact('user', 'customer', 'chartData'));
    }
}

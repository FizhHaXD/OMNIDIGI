<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\News;
use App\Models\PaymentMethod;
use App\Models\Tariff;
use App\Models\Transaction;

class HomeController extends Controller
{
    public function index()
    {
        $tariffs = Tariff::with('category')->take(4)->get();
        $latestNews = News::published()->latest('published_at')->take(3)->get();

        // Data Statistik Real-Time dari Database
        $totalPelanggan = Customer::count();
        $totalTransaksi = Transaction::count();
        $transaksiSukses = Transaction::where('status', 'success')->count();
        $totalMetodeBayar = PaymentMethod::where('is_active', true)->count();

        $successRate = $totalTransaksi > 0 ? round(($transaksiSukses / $totalTransaksi) * 100, 1) : 99.9;

        $formatK = function ($num, $fallback = '0') {
            if ($num >= 1000000) {
                return round($num / 1000000, 1) . 'M+';
            }
            if ($num >= 1000) {
                return round($num / 1000, 1) . 'K+';
            }
            if ($num > 0) {
                return number_format($num, 0, ',', '.') . ($num >= 50 ? '+' : '');
            }
            return $fallback;
        };

        $stats = [
            [
                'value' => $formatK($totalPelanggan, '50+'),
                'label' => 'Pelanggan Terdaftar',
            ],
            [
                'value' => $successRate . '%',
                'label' => 'Transaksi Sukses',
            ],
            [
                'value' => $formatK($totalTransaksi, '90+'),
                'label' => 'Transaksi Terproses',
            ],
            [
                'value' => $totalMetodeBayar > 0 ? $totalMetodeBayar . ' Saluran' : '24/7',
                'label' => 'Metode Pembayaran',
            ],
        ];

        return view('home', compact('tariffs', 'latestNews', 'stats'));
    }
}

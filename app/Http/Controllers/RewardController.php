<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;

class RewardController extends Controller
{
    /**
     * PLN Reward — poin & benefit
     */
    public function index()
    {
        $user = auth()->user();

        // Hitung poin: setiap transaksi sukses = 10 poin + bonus per 100rb
        $successTransactions = Transaction::where('user_id', $user->id)
            ->where('status', 'success')
            ->get();

        $totalPoin = 0;
        foreach ($successTransactions as $trx) {
            $totalPoin += 10; // base poin per transaksi
            $totalPoin += floor((float) $trx->amount / 100000) * 5; // bonus 5 poin per 100rb
        }

        $totalTransaksi = $successTransactions->count();
        $totalNominal = $successTransactions->sum('amount');

        // Tier reward
        $tier = 'Bronze';
        $tierColor = '#CD7F32';
        if ($totalPoin >= 500) {
            $tier = 'Gold';
            $tierColor = '#FFD700';
        } elseif ($totalPoin >= 200) {
            $tier = 'Silver';
            $tierColor = '#C0C0C0';
        }

        // Benefit list (simulasi)
        $benefits = [
            ['nama' => 'Diskon Tagihan 5%', 'poin' => 100, 'icon' => 'fa-tag', 'available' => $totalPoin >= 100],
            ['nama' => 'Cashback Token Rp 5.000', 'poin' => 150, 'icon' => 'fa-bolt', 'available' => $totalPoin >= 150],
            ['nama' => 'Gratis Admin 1x', 'poin' => 200, 'icon' => 'fa-gift', 'available' => $totalPoin >= 200],
            ['nama' => 'Voucher Belanja Rp 50.000', 'poin' => 500, 'icon' => 'fa-shopping-bag', 'available' => $totalPoin >= 500],
        ];

        return view('dashboard.reward', compact(
            'user', 'totalPoin', 'totalTransaksi', 'totalNominal',
            'tier', 'tierColor', 'benefits'
        ));
    }
}

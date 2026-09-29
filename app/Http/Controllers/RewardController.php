<?php

namespace App\Http\Controllers;

use App\Models\RewardClaim;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class RewardController extends Controller
{
    /**
     * Daftar benefit reward yang tersedia
     */
    protected function getRewardCatalog(): array
    {
        return [
            'diskon_5' => [
                'id'        => 'diskon_5',
                'nama'      => 'Diskon Tagihan 5%',
                'poin'      => 100,
                'icon'      => 'fa-tag',
                'prefix'    => 'PLN-DISC5-',
                'deskripsi' => 'Diskon 5% untuk pembayaran tagihan listrik periode berikutnya.',
            ],
            'cashback_5k' => [
                'id'        => 'cashback_5k',
                'nama'      => 'Cashback Token Rp 5.000',
                'poin'      => 150,
                'icon'      => 'fa-bolt',
                'prefix'    => 'PLN-CB5K-',
                'deskripsi' => 'Cashback langsung Rp 5.000 untuk pembelian token listrik.',
            ],
            'free_admin' => [
                'id'        => 'free_admin',
                'nama'      => 'Gratis Biaya Admin 1x',
                'poin'      => 200,
                'icon'      => 'fa-gift',
                'prefix'    => 'PLN-NOADM-',
                'deskripsi' => 'Bebas biaya admin transfer bank/e-wallet untuk 1 kali pembayaran.',
            ],
            'voucher_50k' => [
                'id'        => 'voucher_50k',
                'nama'      => 'Voucher Belanja Rp 50.000',
                'poin'      => 500,
                'icon'      => 'fa-shopping-bag',
                'prefix'    => 'PLN-SHOP50-',
                'deskripsi' => 'Voucher belanja senilai Rp 50.000 di merchant rekanan resmi PLN.',
            ],
        ];
    }

    /**
     * PLN Reward — poin & benefit
     */
    public function index()
    {
        $user = auth()->user();

        // Hitung total poin didapat: setiap transaksi sukses = 10 poin + bonus 5 poin per 100rb
        $successTransactions = Transaction::where('user_id', $user->id)
            ->where('status', 'success')
            ->get();

        $totalEarned = 0;
        foreach ($successTransactions as $trx) {
            $totalEarned += 10;
            $totalEarned += floor((float) $trx->amount / 100000) * 5;
        }

        // Poin yang sudah digunakan untuk penukaran
        $poinUsed = RewardClaim::where('user_id', $user->id)->sum('poin');
        $totalPoin = max(0, $totalEarned - $poinUsed);

        $totalTransaksi = $successTransactions->count();
        $totalNominal = $successTransactions->sum('amount');

        // Tier reward berdasarkan total poin yang pernah diperoleh
        $tier = 'Bronze';
        $tierColor = '#CD7F32';
        if ($totalEarned >= 500) {
            $tier = 'Gold';
            $tierColor = '#FFD700';
        } elseif ($totalEarned >= 200) {
            $tier = 'Silver';
            $tierColor = '#C0C0C0';
        }

        // Benefit list dengan status availability
        $catalog = $this->getRewardCatalog();
        $benefits = [];
        foreach ($catalog as $item) {
            $item['available'] = ($totalPoin >= $item['poin']);
            $benefits[] = $item;
        }

        // Daftar voucher yang telah diklaim oleh user
        $myClaims = RewardClaim::where('user_id', $user->id)
            ->latest()
            ->get();

        return view('dashboard.reward', compact(
            'user', 'totalPoin', 'totalEarned', 'totalTransaksi', 'totalNominal',
            'tier', 'tierColor', 'benefits', 'myClaims'
        ));
    }

    /**
     * Proses penukaran poin reward
     */
    public function redeem(Request $request)
    {
        $catalog = $this->getRewardCatalog();

        $request->validate([
            'reward_id' => 'required|in:' . implode(',', array_keys($catalog)),
        ]);

        $user = auth()->user();
        $rewardId = $request->input('reward_id');
        $reward = $catalog[$rewardId];

        // Hitung sisa poin
        $successTransactions = Transaction::where('user_id', $user->id)
            ->where('status', 'success')
            ->get();

        $totalEarned = 0;
        foreach ($successTransactions as $trx) {
            $totalEarned += 10;
            $totalEarned += floor((float) $trx->amount / 100000) * 5;
        }

        $poinUsed = RewardClaim::where('user_id', $user->id)->sum('poin');
        $availablePoin = max(0, $totalEarned - $poinUsed);

        if ($availablePoin < $reward['poin']) {
            return back()->with('error', 'Poin Anda tidak mencukupi untuk menukar reward ini. Poin saat ini: ' . number_format($availablePoin, 0, ',', '.') . ', dibutuhkan: ' . number_format($reward['poin'], 0, ',', '.') . '.');
        }

        // Generate kode voucher unik
        $voucherCode = $reward['prefix'] . strtoupper(Str::random(6));

        RewardClaim::create([
            'user_id'      => $user->id,
            'reward_id'    => $reward['id'],
            'nama'         => $reward['nama'],
            'poin'         => $reward['poin'],
            'voucher_code' => $voucherCode,
            'status'       => 'active',
            'expired_at'   => now()->addMonths(3),
        ]);

        return back()->with('success', 'Selamat! Penukaran reward "' . $reward['nama'] . '" berhasil. Kode Voucher Anda: ' . $voucherCode);
    }
}

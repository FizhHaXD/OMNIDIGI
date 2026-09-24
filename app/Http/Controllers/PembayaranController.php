<?php

namespace App\Http\Controllers;

use App\Models\Bill;
use App\Models\PaymentMethod;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PembayaranController extends Controller
{
    /**
     * Tampilan QRIS Pembayaran
     */
    public function qris(Request $request)
    {
        $qrisMethod = PaymentMethod::where('kode', 'qris')->first();

        // Cek apakah ada transaksi pending spesifik yang diminta (misal dari form checkout)
        $ref = $request->query('ref');
        $transaction = null;

        if ($ref) {
            $transaction = Transaction::with(['customer', 'bill', 'paymentMethod'])
                ->where('ref_number', $ref)
                ->first();
        }

        if ($transaction) {
            $kode = $transaction->ref_number;
            $nominal = (int) $transaction->amount;
        } else {
            // Sesuai template: unik tiap transaksi & simpan ke database
            $kode = 'QRIS-' . Str::upper(Str::random(10));
            $nominal = (int) ($request->query('nominal', 150000));

            $user = auth()->user() ?? User::where('email', 'hafizh@mail.com')->first() ?? User::first();
            $customer = $user?->customer ?? \App\Models\Customer::first();

            // Simpan ke tabel transactions dengan status 'pending' (menunggu)
            $transaction = Transaction::create([
                'user_id'           => $user?->id,
                'customer_id'       => $customer?->id,
                'payment_method_id' => $qrisMethod?->id ?? 1,
                'type'              => 'tagihan',
                'amount'            => $nominal,
                'status'            => 'pending',
                'no_meter'          => $customer?->id_pelanggan ?? '531200012345',
                'ref_number'        => $kode,
                'keterangan'        => 'Pembayaran via QRIS (Batas waktu 15 menit)',
            ]);
        }

        return view('pembayaran.qris', [
            'kode'        => $kode,
            'nominal'     => $nominal,
            'payload'     => route('qris.simulasi', $kode), // MODE SIMULASI (terbuka saat di-scan)
            'transaction' => $transaction,
        ]);
    }

    /**
     * Simulasi Scan QRIS: terbuka saat QR di-scan oleh kamera HP atau diklik
     */
    public function simulasi(string $kode)
    {
        // Cari transaksi berdasarkan kode/ref_number
        $transaction = Transaction::where('ref_number', $kode)->first();

        if ($transaction) {
            // Ubah status pembayaran menjadi success (lunas)
            $transaction->update(['status' => 'success']);

            // Jika transaksi terkait tagihan listrik, update status bill menjadi 'paid'
            if ($transaction->bill_id) {
                Bill::where('id', $transaction->bill_id)->update([
                    'status'        => 'paid',
                    'tanggal_bayar' => now()->toDateString(),
                ]);
            }

            // Jika pembelian token, generate token listrik jika belum ada
            if ($transaction->type === 'token' && empty($transaction->token_listrik)) {
                $rawToken = str_pad((string) random_int(0, 99999999999999999), 20, '0', STR_PAD_LEFT);
                $tokenListrik = implode(' ', str_split($rawToken, 4));
                $transaction->update(['token_listrik' => $tokenListrik]);
            }
        }

        // Tampilkan halaman simulasi berhasil yang informatif
        return view('pembayaran.simulasi_sukses', [
            'kode'        => $kode,
            'transaction' => $transaction,
            'pesan'       => 'Pembayaran simulasi berhasil ✔',
        ]);
    }

    /**
     * Endpoint polling status untuk auto-redirect di layar setelah QR di-scan di HP
     */
    public function checkStatus(string $kode)
    {
        $transaction = Transaction::where('ref_number', $kode)->first();

        if (!$transaction) {
            return response()->json(['status' => 'not_found'], 404);
        }

        $redirectUrl = route('produk.sukses', $transaction);

        return response()->json([
            'status'       => $transaction->status, // 'pending' atau 'success'
            'is_paid'      => $transaction->status === 'success',
            'redirect_url' => $redirectUrl,
            'ref_number'   => $transaction->ref_number,
        ]);
    }
}

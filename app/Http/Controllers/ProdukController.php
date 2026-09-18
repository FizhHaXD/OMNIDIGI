<?php

namespace App\Http\Controllers;

use App\Models\Bill;
use App\Models\Customer;
use App\Models\PaymentMethod;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ProdukController extends Controller
{
    // Halaman pilih produk
    public function index()
    {
        return view('produk.index');
    }

    // Form bayar tagihan
    public function tagihan()
    {
        $paymentMethods = PaymentMethod::active()->get();
        return view('produk.tagihan', compact('paymentMethods'));
    }

    // Cek tagihan pelanggan
    public function cekTagihan(Request $request)
    {
        $request->validate([
            'id_pelanggan' => 'required|string',
        ]);

        $customer = Customer::with(['tariff.category', 'bills' => function ($q) {
            $q->where('status', 'unpaid')->latest();
        }])->where('id_pelanggan', $request->id_pelanggan)->first();

        if (!$customer) {
            return back()->with('error', 'ID Pelanggan tidak ditemukan.');
        }

        $paymentMethods = PaymentMethod::active()->get();
        return view('produk.tagihan', compact('customer', 'paymentMethods'));
    }

    // Form beli token
    public function token()
    {
        $paymentMethods = PaymentMethod::active()->get();
        return view('produk.token', compact('paymentMethods'));
    }

    // Proses pembayaran (tagihan atau token)
    public function bayar(Request $request)
    {
        $request->validate([
            'type'              => 'required|in:tagihan,token',
            'amount'            => 'required|numeric|min:1000',
            'no_meter'          => 'required|string',
            'payment_method_id' => 'required|exists:payment_methods,id',
            'bill_id'           => 'nullable|exists:bills,id',
        ]);

        $customer = Customer::where('id_pelanggan', $request->no_meter)->first();

        // Generate token jika pembelian token
        $tokenListrik = null;
        if ($request->type === 'token') {
            $rawToken = str_pad((string) random_int(0, 99999999999999999), 20, '0', STR_PAD_LEFT);
            $tokenListrik = implode(' ', str_split($rawToken, 4));
        }

        $transaction = Transaction::create([
            'user_id'           => auth()->id(),
            'customer_id'       => $customer?->id,
            'bill_id'           => $request->type === 'tagihan' ? $request->bill_id : null,
            'payment_method_id' => $request->payment_method_id,
            'type'              => $request->type,
            'amount'            => $request->amount,
            'nominal'           => $request->type === 'token' ? $request->amount : null,
            'status'            => 'pending',
            'no_meter'          => $request->no_meter,
            'ref_number'        => 'TRX-' . date('Ymd') . '-' . strtoupper(Str::random(5)),
            'token_listrik'     => $tokenListrik,
        ]);

        return view('produk.payment', [
            'transaction' => $transaction->load('paymentMethod'),
            'customer'    => $customer,
        ]);
    }

    // Konfirmasi pembayaran (simulasi)
    public function konfirmasi(Transaction $transaction)
    {
        $transaction->update(['status' => 'success']);

        // Jika bayar tagihan, update status bill menjadi paid
        if ($transaction->type === 'tagihan' && $transaction->bill_id) {
            Bill::where('id', $transaction->bill_id)->update([
                'status'       => 'paid',
                'tanggal_bayar' => now()->toDateString(),
            ]);
        }

        return redirect()->route('dashboard')->with('success', 'Pembayaran berhasil! Ref: ' . $transaction->ref_number);
    }
}

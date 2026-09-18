<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Bill;
use App\Models\Customer;
use App\Models\Tariff;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function dashboard()
    {
        $stats = [
            'total_pelanggan'  => Customer::count(),
            'total_transaksi'  => Transaction::count(),
            'total_user'       => User::where('role', 'user')->count(),
            'pendapatan'       => Transaction::where('status', 'success')->sum('amount'),
            'tagihan_belum_lunas' => Bill::where('status', 'unpaid')->count(),
        ];

        $recentTransactions = Transaction::with(['user', 'customer', 'paymentMethod'])
            ->latest()
            ->take(10)
            ->get();

        return view('admin.dashboard', compact('stats', 'recentTransactions'));
    }

    public function customers()
    {
        $customers = Customer::with(['user', 'tariff.category'])->latest()->paginate(15);
        return view('admin.customers', compact('customers'));
    }

    public function createCustomer()
    {
        $tariffs = Tariff::with('category')->orderBy('daya_va')->get();
        return view('admin.customer-form', compact('tariffs'));
    }

    public function storeCustomer(Request $request)
    {
        $request->validate([
            'id_pelanggan'   => 'required|string|unique:customers,id_pelanggan',
            'nama'           => 'required|string|max:100',
            'alamat'         => 'required|string',
            'tariff_id'      => 'required|exists:tariffs,id',
            'nomor_telepon'  => 'nullable|string|max:15',
            'email'          => 'nullable|email|max:100',
        ]);

        Customer::create($request->only([
            'id_pelanggan', 'nama', 'alamat', 'tariff_id',
            'nomor_telepon', 'email',
        ]));

        return redirect()->route('admin.customers')->with('success', 'Pelanggan berhasil ditambahkan.');
    }

    public function editCustomer(Customer $customer)
    {
        $tariffs = Tariff::with('category')->orderBy('daya_va')->get();
        return view('admin.customer-form', compact('customer', 'tariffs'));
    }

    public function updateCustomer(Request $request, Customer $customer)
    {
        $request->validate([
            'id_pelanggan'   => 'required|string|unique:customers,id_pelanggan,' . $customer->id,
            'nama'           => 'required|string|max:100',
            'alamat'         => 'required|string',
            'tariff_id'      => 'required|exists:tariffs,id',
            'nomor_telepon'  => 'nullable|string|max:15',
            'email'          => 'nullable|email|max:100',
            'status_aktif'   => 'boolean',
        ]);

        $customer->update($request->only([
            'id_pelanggan', 'nama', 'alamat', 'tariff_id',
            'nomor_telepon', 'email', 'status_aktif',
        ]));

        return redirect()->route('admin.customers')->with('success', 'Data pelanggan berhasil diupdate.');
    }

    public function deleteCustomer(Customer $customer)
    {
        $customer->delete();
        return redirect()->route('admin.customers')->with('success', 'Pelanggan berhasil dihapus.');
    }

    public function transactions()
    {
        $transactions = Transaction::with(['user', 'customer', 'paymentMethod', 'bill'])
            ->latest()
            ->paginate(15);
        return view('admin.transactions', compact('transactions'));
    }
}

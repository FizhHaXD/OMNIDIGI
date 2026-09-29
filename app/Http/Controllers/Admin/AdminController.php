<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Bill;
use App\Models\Customer;
use App\Models\MeterReading;
use App\Models\OutageReport;
use App\Models\Tariff;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function dashboard()
    {
        $stats = [
            'total_pelanggan'     => Customer::count(),
            'total_transaksi'     => Transaction::count(),
            'total_user'          => User::where('role', 'user')->count(),
            'pendapatan'          => Transaction::where('status', 'success')->sum('amount'),
            'tagihan_belum_lunas' => Bill::whereIn('status', ['unpaid', 'overdue'])->count(),
            'total_piutang'       => Bill::whereIn('status', ['unpaid', 'overdue'])->sum('total_biaya')
                                     + Bill::whereIn('status', ['unpaid', 'overdue'])->sum('denda'),
            'gangguan_aktif'      => OutageReport::whereIn('status', ['dilaporkan', 'diproses'])->count(),
            'meter_pending'       => MeterReading::where('status', 'pending')->count(),
        ];

        $recentTransactions = Transaction::with(['user', 'customer', 'paymentMethod'])
            ->latest()
            ->take(8)
            ->get();

        $urgentOutages = OutageReport::with(['user', 'customer'])
            ->whereIn('status', ['dilaporkan', 'diproses'])
            ->latest()
            ->take(5)
            ->get();

        $overdueBills = Bill::with(['customer.tariff'])
            ->whereIn('status', ['unpaid', 'overdue'])
            ->orderBy('tanggal_jatuh_tempo', 'asc')
            ->take(5)
            ->get();

        return view('admin.dashboard', compact('stats', 'recentTransactions', 'urgentOutages', 'overdueBills'));
    }

    public function customers(Request $request)
    {
        $query = Customer::with(['user', 'tariff.category']);

        if ($request->filled('q')) {
            $q = $request->q;
            $query->where(function ($sub) use ($q) {
                $sub->where('nama', 'like', "%{$q}%")
                    ->orWhere('id_pelanggan', 'like', "%{$q}%")
                    ->orWhere('alamat', 'like', "%{$q}%");
            });
        }

        if ($request->filled('status')) {
            $query->where('status_aktif', $request->status === 'active');
        }

        $customers = $query->latest()->paginate(15)->withQueryString();
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

    public function transactions(Request $request)
    {
        $query = Transaction::with(['user', 'customer', 'paymentMethod', 'bill']);

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        if ($request->filled('q')) {
            $q = $request->q;
            $query->where(function ($sub) use ($q) {
                $sub->where('ref_number', 'like', "%{$q}%")
                    ->orWhere('no_meter', 'like', "%{$q}%");
            });
        }

        $transactions = $query->latest()->paginate(15)->withQueryString();
        return view('admin.transactions', compact('transactions'));
    }

    /**
     * Manajemen & Klasifikasi Tagihan & Tunggakan
     */
    public function bills(Request $request)
    {
        $query = Bill::with(['customer.tariff', 'meterReading']);

        if ($request->filled('status')) {
            if ($request->status === 'overdue') {
                $query->where(function ($q) {
                    $q->where('status', 'overdue')
                      ->orWhere(function ($sub) {
                          $sub->where('status', 'unpaid')
                              ->where('tanggal_jatuh_tempo', '<', now()->toDateString());
                      });
                });
            } elseif ($request->status === 'unpaid') {
                $query->where('status', 'unpaid');
            } elseif ($request->status === 'paid') {
                $query->where('status', 'paid');
            }
        }

        if ($request->filled('q')) {
            $q = $request->q;
            $query->whereHas('customer', function ($sub) use ($q) {
                $sub->where('nama', 'like', "%{$q}%")
                    ->orWhere('id_pelanggan', 'like', "%{$q}%");
            });
        }

        $summary = [
            'total_piutang' => Bill::whereIn('status', ['unpaid', 'overdue'])->sum('total_biaya'),
            'total_denda'   => Bill::whereIn('status', ['unpaid', 'overdue'])->sum('denda'),
            'unpaid_count'  => Bill::where('status', 'unpaid')->count(),
            'overdue_count' => Bill::where('status', 'overdue')
                                ->orWhere(function ($q) {
                                    $q->where('status', 'unpaid')
                                      ->where('tanggal_jatuh_tempo', '<', now()->toDateString());
                                })->count(),
        ];

        $bills = $query->orderBy('tanggal_jatuh_tempo', 'desc')->paginate(15)->withQueryString();

        return view('admin.bills', compact('bills', 'summary'));
    }

    /**
     * Manajemen Tiket Gangguan & Dispatch
     */
    public function outages(Request $request)
    {
        $query = OutageReport::with(['user', 'customer']);

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('kategori')) {
            $query->where('kategori', $request->kategori);
        }

        if ($request->filled('q')) {
            $q = $request->q;
            $query->where(function ($sub) use ($q) {
                $sub->where('lokasi', 'like', "%{$q}%")
                    ->orWhere('deskripsi', 'like', "%{$q}%");
            });
        }

        $summary = [
            'total'      => OutageReport::count(),
            'dilaporkan' => OutageReport::where('status', 'dilaporkan')->count(),
            'diproses'   => OutageReport::where('status', 'diproses')->count(),
            'selesai'    => OutageReport::where('status', 'selesai')->count(),
            'kritis'     => OutageReport::whereIn('kategori', ['padam_total', 'korsleting'])->whereIn('status', ['dilaporkan', 'diproses'])->count(),
        ];

        $outages = $query->latest()->paginate(12)->withQueryString();

        return view('admin.outages', compact('outages', 'summary'));
    }

    public function updateOutageStatus(Request $request, OutageReport $outage)
    {
        $request->validate([
            'status'          => 'required|in:dilaporkan,diproses,selesai',
            'catatan_petugas' => 'nullable|string|max:500',
        ]);

        $outage->update($request->only(['status', 'catatan_petugas']));

        return back()->with('success', 'Status laporan gangguan #' . $outage->id . ' berhasil diperbarui.');
    }

    /**
     * Audit & Verifikasi Catat Meter Mandiri (SwaCAM)
     */
    public function meterReadings(Request $request)
    {
        $query = MeterReading::with(['customer.tariff', 'bill']);

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('q')) {
            $q = $request->q;
            $query->whereHas('customer', function ($sub) use ($q) {
                $sub->where('nama', 'like', "%{$q}%")
                    ->orWhere('id_pelanggan', 'like', "%{$q}%");
            });
        }

        $summary = [
            'total'    => MeterReading::count(),
            'pending'  => MeterReading::where('status', 'pending')->count(),
            'verified' => MeterReading::where('status', 'verified')->count(),
            'billed'   => MeterReading::where('status', 'billed')->count(),
        ];

        $readings = $query->latest()->paginate(15)->withQueryString();

        return view('admin.meter-readings', compact('readings', 'summary'));
    }

    public function verifyMeterReading(MeterReading $meterReading)
    {
        $meterReading->update(['status' => 'verified']);
        return back()->with('success', 'Stand meter pelanggan ' . ($meterReading->customer->nama ?? '') . ' berhasil diverifikasi.');
    }

    /**
     * Pusat Dokumen & Surat Kedinasan PLN (AI Ready)
     */
    public function letters(Request $request)
    {
        $type = $request->get('type', 'sp_tunggakan');
        $selectedBillId = $request->get('bill_id');
        $selectedOutageId = $request->get('outage_id');

        // Data Pelanggan yang Menunggak untuk Pilihan Surat Peringatan
        $overdueBills = Bill::with(['customer.tariff'])
            ->whereIn('status', ['unpaid', 'overdue'])
            ->orderBy('tanggal_jatuh_tempo', 'asc')
            ->get();

        // Data Tiket Gangguan untuk Pilihan SPK YANTEK
        $activeOutages = OutageReport::with(['user', 'customer'])
            ->whereIn('status', ['dilaporkan', 'diproses'])
            ->latest()
            ->get();

        // Pilih item aktif untuk digenerate
        $selectedBill = $selectedBillId ? Bill::with(['customer.tariff'])->find($selectedBillId) : $overdueBills->first();
        $selectedOutage = $selectedOutageId ? OutageReport::with(['user', 'customer'])->find($selectedOutageId) : $activeOutages->first();

        return view('admin.letters', compact(
            'type',
            'overdueBills',
            'activeOutages',
            'selectedBill',
            'selectedOutage'
        ));
    }

    /**
     * Preview Surat Resmi Siap Cetak (A4 Official Format)
     */
    public function previewLetter(Request $request)
    {
        $type = $request->get('type', 'sp_tunggakan');
        $bill = null;
        $outage = null;

        if ($request->filled('bill_id')) {
            $bill = Bill::with(['customer.tariff'])->find($request->bill_id);
        }
        if ($request->filled('outage_id')) {
            $outage = OutageReport::with(['user', 'customer'])->find($request->outage_id);
        }

        $nomorSurat = match ($type) {
            'sp1'         => '041/DIS.01.02/ULP-JKT/SP-1/' . now()->format('Y'),
            'sp2'         => '082/DIS.01.02/ULP-JKT/SP-2/' . now()->format('Y'),
            'spk'         => '115/YANTEK/GANGGUAN/' . now()->format('Y'),
            'ba_meter'    => '204/BA-P2TL/METER/' . now()->format('Y'),
            default       => '041/DIS.01.02/ULP-JKT/' . now()->format('Y'),
        };

        return view('admin.letter-preview', compact('type', 'bill', 'outage', 'nomorSurat'));
    }
}

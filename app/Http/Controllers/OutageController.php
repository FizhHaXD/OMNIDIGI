<?php

namespace App\Http\Controllers;

use App\Models\OutageReport;
use Illuminate\Http\Request;

class OutageController extends Controller
{
    /**
     * Daftar laporan gangguan milik user
     */
    public function index()
    {
        $user = auth()->user();
        $reports = OutageReport::where('user_id', $user->id)
            ->with('customer')
            ->latest()
            ->get();

        return view('dashboard.outage.index', compact('user', 'reports'));
    }

    /**
     * Form lapor gangguan baru
     */
    public function create()
    {
        $user = auth()->user();
        $customers = $user->customers;

        return view('dashboard.outage.create', compact('user', 'customers'));
    }

    /**
     * Simpan laporan gangguan
     */
    public function store(Request $request)
    {
        $request->validate([
            'kategori'    => 'required|in:padam_total,tegangan_rendah,korsleting,meteran_rusak,lainnya',
            'deskripsi'   => 'required|string|min:10',
            'lokasi'      => 'required|string|max:255',
            'customer_id' => 'nullable|exists:customers,id',
            'foto'        => 'nullable|image|max:2048',
        ]);

        $data = [
            'user_id'     => auth()->id(),
            'customer_id' => $request->input('customer_id'),
            'kategori'    => $request->input('kategori'),
            'deskripsi'   => $request->input('deskripsi'),
            'lokasi'      => $request->input('lokasi'),
            'status'      => 'dilaporkan',
        ];

        if ($request->hasFile('foto')) {
            $data['foto'] = $request->file('foto')->store('outages', 'public');
        }

        OutageReport::create($data);

        return redirect()->route('dashboard.outage')->with('success', 'Laporan gangguan berhasil dikirim! Tim PLN akan segera menindaklanjuti.');
    }
}

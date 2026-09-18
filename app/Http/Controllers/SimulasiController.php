<?php

namespace App\Http\Controllers;

use App\Models\Tariff;
use Illuminate\Http\Request;

class SimulasiController extends Controller
{
    public function index()
    {
        $tariffs = Tariff::with('category')->orderBy('daya_va')->get();
        return view('simulasi.index', compact('tariffs'));
    }

    public function hitung(Request $request)
    {
        $request->validate([
            'tariff_id' => 'required|exists:tariffs,id',
        ]);

        $tariff = Tariff::findOrFail($request->tariff_id);

        $result = [
            'tariff' => $tariff,
            'biaya_pasang' => $tariff->biaya_pasang,
            'biaya_admin' => $tariff->biaya_admin,
            'ppn' => round(($tariff->biaya_pasang + $tariff->biaya_admin) * 0.11, 2),
            'total' => round(($tariff->biaya_pasang + $tariff->biaya_admin) * 1.11, 2),
        ];

        $tariffs = Tariff::with('category')->orderBy('daya_va')->get();
        return view('simulasi.index', compact('tariffs', 'result'));
    }
}

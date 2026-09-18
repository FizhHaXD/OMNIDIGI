<?php

namespace App\Http\Controllers;

use App\Models\Tariff;

class HomeController extends Controller
{
    public function index()
    {
        $tariffs = Tariff::with('category')->take(4)->get();
        return view('home', compact('tariffs'));
    }
}

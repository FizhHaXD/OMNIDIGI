<?php

namespace App\Http\Controllers;

use App\Models\News;
use App\Models\Tariff;

class HomeController extends Controller
{
    public function index()
    {
        $tariffs = Tariff::with('category')->take(4)->get();
        $latestNews = News::published()->latest('published_at')->take(3)->get();
        return view('home', compact('tariffs', 'latestNews'));
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\News;
use Illuminate\Http\Request;

class NewsController extends Controller
{
    /**
     * Daftar berita publik
     */
    public function index(Request $request)
    {
        $query = News::published()->latest('published_at');

        if ($request->has('kategori') && $request->kategori !== 'semua') {
            $query->byKategori($request->kategori);
        }

        $news = $query->paginate(9);
        $activeKategori = $request->input('kategori', 'semua');

        return view('news.index', compact('news', 'activeKategori'));
    }

    /**
     * Detail berita
     */
    public function show(string $slug)
    {
        $article = News::published()->where('slug', $slug)->firstOrFail();
        $related = News::published()
            ->where('id', '!=', $article->id)
            ->where('kategori', $article->kategori)
            ->latest('published_at')
            ->take(3)
            ->get();

        return view('news.show', compact('article', 'related'));
    }
}

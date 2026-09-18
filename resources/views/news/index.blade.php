@extends('layouts.main')
@section('title', 'Berita PLN - PLN DIGI')

@section('content')
<section class="relative -mt-16 md:-mt-18 bg-gradient-to-br from-[#001230] via-[#00265a] to-[#001a4d] text-white overflow-hidden">
    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-32 pb-8 md:pt-36 md:pb-10">
        <h1 class="text-2xl md:text-3xl font-bold">Berita & Informasi PLN</h1>
        <p class="text-white/50 mt-1 text-sm">Berita terkini, promo, dan tips seputar kelistrikan.</p>
    </div>
</section>

<section class="py-8 md:py-10">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">

        {{-- Filter Kategori --}}
        <div class="flex flex-wrap gap-2 mb-8">
            @php
                $kategoris = ['semua' => 'Semua', 'info' => 'Informasi', 'promo' => 'Promo', 'gangguan' => 'Gangguan', 'tips' => 'Tips & Trik'];
            @endphp
            @foreach($kategoris as $key => $label)
                <a href="{{ route('news.index', ['kategori' => $key]) }}"
                   class="px-4 py-2 rounded-full text-sm font-medium transition-colors
                          {{ $activeKategori === $key ? 'bg-[#00529C] text-white shadow-md' : 'bg-slate-100 text-slate-600 hover:bg-slate-200' }}">
                    {{ $label }}
                </a>
            @endforeach
        </div>

        {{-- Grid Berita --}}
        @if($news->isEmpty())
            <div class="card p-10 text-center">
                <div class="w-14 h-14 bg-sky-50 rounded-2xl flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-newspaper text-sky-300 text-xl"></i>
                </div>
                <p class="text-slate-400 text-sm">Belum ada berita untuk kategori ini.</p>
            </div>
        @else
            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($news as $item)
                <a href="{{ route('news.show', $item->slug) }}" class="card overflow-hidden group hover:shadow-lg transition-all duration-200 hover:-translate-y-0.5">
                    @if($item->gambar)
                    <div class="h-48 bg-slate-100 overflow-hidden">
                        <img src="{{ asset('storage/' . $item->gambar) }}" alt="{{ $item->judul }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                    </div>
                    @else
                    <div class="h-48 bg-gradient-to-br from-[#00529C] to-[#003d75] flex items-center justify-center">
                        <i class="fas fa-newspaper text-white/20 text-5xl"></i>
                    </div>
                    @endif
                    <div class="p-5">
                        <div class="flex items-center gap-2 mb-2">
                            <span class="inline-block px-2.5 py-0.5 rounded text-[10px] font-semibold uppercase tracking-wider bg-[#00529C]/10 text-[#00529C]">{{ $item->label_kategori }}</span>
                            <span class="text-[11px] text-slate-400">{{ $item->published_at->format('d M Y') }}</span>
                        </div>
                        <h3 class="text-base font-bold text-slate-800 mb-2 line-clamp-2 group-hover:text-[#00529C] transition-colors">{{ $item->judul }}</h3>
                        <p class="text-sm text-slate-500 line-clamp-3">{{ $item->excerpt }}</p>
                    </div>
                </a>
                @endforeach
            </div>

            {{-- Pagination --}}
            <div class="mt-8">
                {{ $news->appends(['kategori' => $activeKategori])->links() }}
            </div>
        @endif
    </div>
</section>
@endsection

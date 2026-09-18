@extends('layouts.main')
@section('title', $article->judul . ' - PLN DIGI')

@section('content')
<section class="relative -mt-16 md:-mt-18 bg-gradient-to-br from-[#001230] via-[#00265a] to-[#001a4d] text-white overflow-hidden">
    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-32 pb-8 md:pt-36 md:pb-10">
        <a href="{{ route('news.index') }}" class="inline-flex items-center text-white/50 hover:text-white text-sm mb-3 transition-colors">
            <i class="fas fa-arrow-left mr-2"></i> Semua Berita
        </a>
        <div class="flex items-center gap-2 mb-3">
            <span class="inline-block px-2.5 py-0.5 rounded text-[10px] font-semibold uppercase tracking-wider bg-white/10 text-white/70">{{ $article->label_kategori }}</span>
            <span class="text-sm text-white/50">{{ $article->published_at->format('d M Y') }}</span>
        </div>
        <h1 class="text-2xl md:text-3xl font-bold leading-tight max-w-3xl">{{ $article->judul }}</h1>
    </div>
</section>

<section class="py-8 md:py-10">
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">

        {{-- Header Image --}}
        @if($article->gambar)
        <div class="rounded-2xl overflow-hidden mb-8 shadow-lg">
            <img src="{{ asset('storage/' . $article->gambar) }}" alt="{{ $article->judul }}" class="w-full h-auto object-cover">
        </div>
        @endif

        {{-- Article Content --}}
        <div class="prose prose-slate max-w-none mb-12">
            {!! nl2br(e($article->konten)) !!}
        </div>

        {{-- Related Articles --}}
        @if($related->isNotEmpty())
        <hr class="border-slate-200 mb-8">
        <h2 class="text-lg font-bold text-slate-900 mb-5">Berita Terkait</h2>
        <div class="grid md:grid-cols-3 gap-5">
            @foreach($related as $r)
            <a href="{{ route('news.show', $r->slug) }}" class="card overflow-hidden group hover:shadow-lg transition-all duration-200">
                @if($r->gambar)
                <div class="h-32 bg-slate-100 overflow-hidden">
                    <img src="{{ asset('storage/' . $r->gambar) }}" alt="{{ $r->judul }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                </div>
                @else
                <div class="h-32 bg-gradient-to-br from-[#00529C] to-[#003d75] flex items-center justify-center">
                    <i class="fas fa-newspaper text-white/20 text-3xl"></i>
                </div>
                @endif
                <div class="p-4">
                    <h3 class="text-sm font-bold text-slate-800 line-clamp-2 group-hover:text-[#00529C] transition-colors">{{ $r->judul }}</h3>
                    <p class="text-xs text-slate-400 mt-1">{{ $r->published_at->format('d M Y') }}</p>
                </div>
            </a>
            @endforeach
        </div>
        @endif
    </div>
</section>
@endsection

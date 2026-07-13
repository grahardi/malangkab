@extends('layouts.app')

@section('title', $article->title.' — Malangkab.com')
@section('description', $article->excerpt)

@section('content')
    <article class="max-w-3xl mx-auto px-5 py-14">
        <span class="font-mono text-xs uppercase tracking-widest text-liat">{{ $article->category->name }}</span>
        <h1 class="font-display text-3xl md:text-4xl font-bold mt-2 leading-tight">{{ $article->title }}</h1>
        <p class="text-gray-500 text-sm mt-3">{{ $article->published_at?->translatedFormat('d F Y') }} · {{ $article->views }} kali dibaca</p>

        <img src="{{ $article->cover_image }}" alt="{{ $article->title }}" class="w-full h-72 md:h-96 object-cover rounded-2xl mt-6 shadow-lg">

        <div class="prose prose-lg max-w-none mt-8 leading-relaxed">
            {!! $article->body !!}
        </div>

        @if(!empty($article->gallery))
        <div class="mt-10">
            <h3 class="font-display font-semibold text-lg mb-4">Galeri</h3>
            <div class="grid grid-cols-2 md:grid-cols-3 gap-3">
                @foreach($article->gallery as $img)
                    <img src="{{ $img }}" alt="Galeri {{ $article->title }}" class="w-full h-32 object-cover rounded-lg">
                @endforeach
            </div>
        </div>
        @endif
    </article>

    @if($related->isNotEmpty())
    <section class="bg-ijotebu2 py-14">
        <div class="max-w-6xl mx-auto px-5">
            <h2 class="font-display text-xl font-bold text-white mb-6">Artikel Terkait</h2>
            <div class="grid sm:grid-cols-2 md:grid-cols-4 gap-5">
                @foreach($related as $item)
                    <a href="{{ route('article.show', [$item->category->slug, $item]) }}" class="group block bg-white/5 hover:bg-white/10 border border-white/10 rounded-xl overflow-hidden transition">
                        <img src="{{ $item->cover_image }}" alt="{{ $item->title }}" class="w-full h-28 object-cover">
                        <div class="p-4">
                            <h3 class="text-white text-sm font-semibold group-hover:text-emas transition">{{ $item->title }}</h3>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>
    </section>
    @endif
@endsection

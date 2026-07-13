@extends('layouts.app')

@section('title', $category->name.' — Malangkab.com')

@section('content')
    <section class="bg-ijotebu2 py-16">
        <div class="max-w-6xl mx-auto px-5">
            <span class="font-mono text-xs uppercase tracking-widest text-emas">Kategori & Sub-kategori</span>
            <h1 class="font-display text-3xl md:text-4xl font-bold text-white mt-2">{{ $category->name }}</h1>
            @if($category->description)
                <p class="text-gray-300 mt-3 max-w-2xl">{{ $category->description }}</p>
            @endif
        </div>
    </section>

    <section class="max-w-6xl mx-auto px-5 py-14 space-y-16">
        @foreach($childrenWithArticles as $child)
            <div>
                <div class="flex items-end justify-between mb-5">
                    <div>
                        <span class="text-2xl">{{ $child->icon }}</span>
                        <span class="font-display text-xl font-bold ml-1">{{ $child->name }}</span>
                        @if($child->children()->exists())
                            <span class="text-sm text-gray-500 ml-2">{{ $child->children()->count() }} sekolah/entitas</span>
                        @else
                            <span class="text-sm text-gray-500 ml-2">{{ $child->publishedArticles()->count() }} artikel</span>
                        @endif
                    </div>
                    <a href="{{ route('category.show', $child->slug) }}" class="text-liat text-sm font-semibold hover:underline whitespace-nowrap">Lihat semua →</a>
                </div>

                @if($child->sampleArticles->isEmpty())
                    @if($child->children()->exists())
                        <p class="text-sm text-gray-500">Berisi {{ $child->children()->count() }} sub-kategori — klik "Lihat semua" untuk menjelajah.</p>
                    @else
                        <p class="text-sm text-gray-400 italic">Belum ada artikel di sub-kategori ini.</p>
                    @endif
                @else
                    <div class="grid sm:grid-cols-2 md:grid-cols-4 gap-5">
                        @foreach($child->sampleArticles as $article)
                            <a href="{{ route('article.show', [$child->slug, $article]) }}" class="group block bg-white rounded-xl overflow-hidden shadow hover:shadow-lg transition">
                                <img src="{{ $article->cover_image }}" alt="{{ $article->title }}" class="w-full h-32 object-cover">
                                <div class="p-4">
                                    <h3 class="font-display font-semibold text-sm group-hover:text-liat transition">{{ $article->title }}</h3>
                                </div>
                            </a>
                        @endforeach
                    </div>
                @endif
            </div>
        @endforeach
    </section>
@endsection

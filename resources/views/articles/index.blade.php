@extends('layouts.app')

@section('title', $category->name.' — Malangkab.com')

@section('content')
    <section class="bg-ijotebu contour-bg py-16">
        <div class="max-w-6xl mx-auto px-5">
            <span class="font-mono text-xs uppercase tracking-widest text-emas">
                @if($category->slug === 'kecamatan') 33 Wilayah Administratif
                @elseif($category->slug === 'tokoh') Profil Tokoh
                @else Profil Daerah
                @endif
            </span>
            <h1 class="font-display text-3xl md:text-4xl font-bold text-white mt-2">{{ $category->name }}</h1>
            @if($category->description)
                <p class="text-gray-200 mt-3 max-w-2xl">{{ $category->description }}</p>
            @endif
        </div>
    </section>

    <section class="max-w-6xl mx-auto px-5 py-14">
        <div class="grid sm:grid-cols-2 md:grid-cols-3 gap-6">
            @foreach($articles as $article)
                <a href="{{ route('article.show', [$article->category->slug, $article]) }}" class="group block bg-white rounded-xl overflow-hidden shadow hover:shadow-lg transition">
                    <img src="{{ $article->cover_image }}" alt="{{ $article->title }}" class="w-full h-40 object-cover">
                    <div class="p-5">
                        @if($article->category->slug !== $category->slug)
                            <span class="font-mono text-[11px] uppercase tracking-widest text-liat">{{ $article->category->name }}</span>
                        @endif
                        <h3 class="font-display font-semibold group-hover:text-liat transition">{{ $article->title }}</h3>
                        <p class="text-sm text-gray-500 mt-2 line-clamp-2">{{ $article->excerpt }}</p>
                    </div>
                </a>
            @endforeach
        </div>

        <div class="mt-10">
            {{ $articles->links() }}
        </div>
    </section>
@endsection

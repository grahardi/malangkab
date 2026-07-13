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

    <section class="max-w-6xl mx-auto px-5 py-14">
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
            @foreach($children as $child)
                @php
                    $hasSubChildren = $child->children()->exists();
                    $count = $hasSubChildren ? $child->children()->count() : $child->publishedArticles()->count();
                    $countLabel = $hasSubChildren ? 'sekolah/entitas' : 'artikel';
                @endphp
                <a href="{{ route('category.show', $child->slug) }}" class="group block bg-white rounded-xl border border-gray-100 shadow hover:shadow-lg hover:-translate-y-0.5 transition p-6 text-center">
                    <span class="text-4xl">{{ $child->icon }}</span>
                    <h3 class="font-display font-semibold text-lg mt-3 group-hover:text-liat transition">{{ $child->name }}</h3>
                    <span class="inline-block mt-2 text-xs font-mono uppercase tracking-widest text-gray-400">{{ $count }} {{ $countLabel }}</span>
                </a>
            @endforeach
        </div>

        <div class="mt-10">
            {{ $children->links() }}
        </div>
    </section>
@endsection

<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Category;
use Illuminate\View\View;

class ArticleController extends Controller
{
    public function home(): View
    {
        $categories = Category::orderBy('order')->get();

        $latest = Article::published()
            ->with('category')
            ->orderByDesc('published_at')
            ->limit(6)
            ->get();

        $profileHighlight = Article::published()
            ->whereHas('category', fn ($q) => $q->where('slug', 'profile'))
            ->orderByDesc('published_at')
            ->first();

        $kecamatanList = Article::published()
            ->whereHas('category', fn ($q) => $q->where('slug', 'kecamatan'))
            ->orderBy('title')
            ->get();

        return view('home', compact('categories', 'latest', 'profileHighlight', 'kecamatanList'));
    }

    public function category(string $slug): View
    {
        $category = Category::where('slug', $slug)->firstOrFail();

        $articles = $category->publishedArticles()->paginate(12);

        return view('articles.index', compact('category', 'articles'));
    }

    public function show(string $categorySlug, Article $article): View
    {
        abort_unless($article->category->slug === $categorySlug, 404);

        $article->increment('views');

        $related = Article::published()
            ->where('category_id', $article->category_id)
            ->where('id', '!=', $article->id)
            ->inRandomOrder()
            ->limit(4)
            ->get();

        return view('articles.show', compact('article', 'related'));
    }
}

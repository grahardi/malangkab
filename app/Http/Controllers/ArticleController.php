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

        // 6 kecamatan tampil acak di beranda (kartu thumbnail, 3 baris x 2 kolom).
        // inRandomOrder() membuat urutan berbeda setiap kali halaman dimuat ulang.
        $kecamatanRandom = Article::published()
            ->whereHas('category', fn ($q) => $q->where('slug', 'kecamatan'))
            ->inRandomOrder()
            ->limit(6)
            ->get();

        // 6 destinasi Pariwisata tampil acak (dari SEMUA sub-kategori: Pantai, Air Terjun, dst),
        // ditampilkan di ATAS modul kecamatan di beranda.
        $pariwisataRootId = Category::where('slug', 'pariwisata')->value('id');
        $pariwisataRandom = Article::published()
            ->with('category')
            ->whereHas('category', fn ($q) => $q->where('parent_id', $pariwisataRootId))
            ->inRandomOrder()
            ->limit(6)
            ->get();

        return view('home', compact('categories', 'latest', 'profileHighlight', 'kecamatanList', 'kecamatanRandom', 'pariwisataRandom'));
    }

    public function category(string $slug): View
    {
        $category = Category::where('slug', $slug)->firstOrFail();

        // Kategori dengan sub-kategori (mis. Pariwisata → Pantai, Air Terjun, dst)
        // ditampilkan sebagai halaman ringkasan per sub-kategori, bukan grid artikel biasa.
        if ($category->children()->exists()) {
            $childrenWithArticles = $category->children()
                ->orderBy('order')
                ->get()
                ->map(function (Category $child) {
                    $child->setRelation(
                        'sampleArticles',
                        $child->publishedArticles()->limit(4)->get()
                    );

                    return $child;
                });

            return view('articles.category-tree', compact('category', 'childrenWithArticles'));
        }

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

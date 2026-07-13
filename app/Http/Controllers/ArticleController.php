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

        // Khusus "Tokoh": jangan tampilkan grid sub-kategori (Politik/Budayawan/dst),
        // langsung tampilkan gabungan seluruh profil tokoh sebagai kartu + thumbnail,
        // dipaginasi 12 per halaman.
        if ($category->slug === 'tokoh') {
            $childIds = $category->children()->pluck('id');

            $articles = Article::published()
                ->with('category')
                ->whereIn('category_id', $childIds)
                ->orderByDesc('published_at')
                ->paginate(12);

            return view('articles.index', compact('category', 'articles'));
        }

        // Kategori dengan sub-kategori lain (mis. Pariwisata → Pantai, Air Terjun, dst,
        // atau Pendidikan → SMP → 33 sekolah) ditampilkan sebagai grid kartu/box
        // sederhana, 3 kolom x 3 baris (9 per halaman) — supaya kategori dengan
        // banyak anak (mis. 33 sekolah) tetap ringkas dan bisa dipaginasi.
        if ($category->children()->exists()) {
            $children = $category->children()->orderBy('order')->paginate(9);

            return view('articles.category-grid', compact('category', 'children'));
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

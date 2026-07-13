<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Category;
use Illuminate\Http\Response;

class SitemapController extends Controller
{
    /**
     * Sitemap XML dinamis: selalu mengikuti data terbaru di database (kategori +
     * artikel published), tidak perlu di-generate ulang manual tiap ada artikel baru.
     * Daftarkan URL-nya (…/sitemap.xml) di Google Search Console.
     */
    public function index(): Response
    {
        $urls = collect();

        // Halaman beranda
        $urls->push([
            'loc' => route('home'),
            'lastmod' => now()->toAtomString(),
            'changefreq' => 'daily',
            'priority' => '1.0',
        ]);

        // Semua kategori (root & sub-kategori)
        Category::orderBy('id')->get()->each(function (Category $category) use ($urls) {
            $urls->push([
                'loc' => route('category.show', $category->slug),
                'lastmod' => $category->updated_at?->toAtomString() ?? now()->toAtomString(),
                'changefreq' => 'weekly',
                'priority' => $category->isRoot() ? '0.8' : '0.6',
            ]);
        });

        // Semua artikel published
        Article::published()
            ->with('category')
            ->orderByDesc('updated_at')
            ->chunk(500, function ($chunk) use ($urls) {
                foreach ($chunk as $article) {
                    $urls->push([
                        'loc' => route('article.show', [$article->category->slug, $article]),
                        'lastmod' => $article->updated_at->toAtomString(),
                        'changefreq' => 'monthly',
                        'priority' => '0.5',
                    ]);
                }
            });

        $xml = view('sitemap', ['urls' => $urls])->render();

        return response($xml, 200)->header('Content-Type', 'text/xml');
    }
}

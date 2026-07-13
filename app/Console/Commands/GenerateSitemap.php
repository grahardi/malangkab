<?php

namespace App\Console\Commands;

use App\Models\Article;
use App\Models\Category;
use Illuminate\Console\Command;

class GenerateSitemap extends Command
{
    protected $signature = 'sitemap:generate';

    protected $description = 'Generate sitemap.xml versi statis ke public/sitemap.xml (opsional, alternatif dari sitemap dinamis di /sitemap.xml)';

    public function handle(): int
    {
        $urls = collect();

        $urls->push([
            'loc' => route('home'),
            'lastmod' => now()->toAtomString(),
            'changefreq' => 'daily',
            'priority' => '1.0',
        ]);

        Category::orderBy('id')->get()->each(function (Category $category) use ($urls) {
            $urls->push([
                'loc' => route('category.show', $category->slug),
                'lastmod' => $category->updated_at?->toAtomString() ?? now()->toAtomString(),
                'changefreq' => 'weekly',
                'priority' => $category->isRoot() ? '0.8' : '0.6',
            ]);
        });

        Article::published()->with('category')->orderByDesc('updated_at')->chunk(500, function ($chunk) use ($urls) {
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

        file_put_contents(public_path('sitemap.xml'), $xml);

        $this->info('Sitemap statis berhasil ditulis ke public/sitemap.xml ('.$urls->count().' URL).');
        $this->comment('Catatan: karena file ini fisik di public/, Nginx akan otomatis menyajikannya '
            .'langsung tanpa lewat Laravel (lebih cepat), menggantikan versi dinamis di route /sitemap.xml. '
            .'Jalankan ulang perintah ini (mis. lewat cron harian) setiap kali ada artikel baru supaya tetap up-to-date.');

        return self::SUCCESS;
    }
}

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\Category;
use App\Services\AiArticleGenerator;
use App\Services\ArticleScraperService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;

class ArticleController extends Controller
{
    public function index(Request $request): View
    {
        $articles = Article::with('category')
            ->when($request->filled('category'), fn ($q) => $q->where('category_id', $request->integer('category')))
            ->when($request->filled('status'), fn ($q) => $q->where('status', $request->string('status')))
            ->when($request->filled('q'), fn ($q) => $q->where('title', 'like', '%'.$request->string('q').'%'))
            ->latest()
            ->paginate(20)
            ->withQueryString();

        $categories = Category::orderBy('parent_id')->orderBy('order')->get();

        return view('admin.articles.index', compact('articles', 'categories'));
    }

    public function create(): View
    {
        $categories = Category::orderBy('parent_id')->orderBy('order')->get();

        return view('admin.articles.create', compact('categories'));
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'category_id' => ['required', 'exists:categories,id'],
            'title' => ['required', 'string', 'max:200'],
            'excerpt' => ['nullable', 'string', 'max:500'],
            'body' => ['required', 'string'],
            'cover_image' => ['nullable', 'string', 'max:2048'],
            'gallery_text' => ['nullable', 'string'],
            'status' => ['required', 'in:draft,published'],
        ]);

        $gallery = collect(explode("\n", $data['gallery_text'] ?? ''))
            ->map(fn ($line) => trim($line))
            ->filter()
            ->values()
            ->all();

        Article::create([
            'category_id' => $data['category_id'],
            'title' => $data['title'],
            'slug' => Str::slug($data['title']).'-'.Str::random(4),
            'excerpt' => $data['excerpt'] ?? Str::limit(strip_tags($data['body']), 160),
            'body' => $data['body'],
            'cover_image' => $data['cover_image'] ?? null,
            'gallery' => $gallery,
            'status' => $data['status'],
            'published_at' => $data['status'] === 'published' ? now() : null,
        ]);

        return redirect()->route('admin.articles.index')->with('status', 'Artikel "'.$data['title'].'" berhasil disimpan.');
    }

    public function edit(Article $article): View
    {
        $categories = Category::orderBy('parent_id')->orderBy('order')->get();

        return view('admin.articles.edit', compact('article', 'categories'));
    }

    public function update(Request $request, Article $article): RedirectResponse
    {
        $data = $request->validate([
            'category_id' => ['required', 'exists:categories,id'],
            'title' => ['required', 'string', 'max:200'],
            'excerpt' => ['nullable', 'string', 'max:500'],
            'body' => ['required', 'string'],
            'cover_image' => ['nullable', 'string', 'max:2048'],
            'gallery_text' => ['nullable', 'string'],
            'status' => ['required', 'in:draft,published'],
        ]);

        $gallery = collect(explode("\n", $data['gallery_text'] ?? ''))
            ->map(fn ($line) => trim($line))
            ->filter()
            ->values()
            ->all();

        $article->update([
            'category_id' => $data['category_id'],
            'title' => $data['title'],
            'excerpt' => $data['excerpt'] ?? Str::limit(strip_tags($data['body']), 160),
            'body' => $data['body'],
            'cover_image' => $data['cover_image'] ?? null,
            'gallery' => $gallery,
            'status' => $data['status'],
            'published_at' => $data['status'] === 'published' ? ($article->published_at ?? now()) : $article->published_at,
        ]);

        return redirect()->route('admin.articles.index')->with('status', 'Artikel "'.$article->title.'" berhasil diperbarui.');
    }

    public function destroy(Article $article): RedirectResponse
    {
        $article->delete();

        return redirect()->route('admin.articles.index')->with('status', 'Artikel berhasil dihapus.');
    }

    /**
     * Publish massal semua artikel berstatus draft, mengikuti filter kategori/pencarian
     * yang sedang aktif di halaman (supaya bisa dibatasi per kategori, mis. hanya
     * "Wisata Alam", bukan semua draft sekaligus kalau tidak diinginkan).
     */
    public function publishDrafts(Request $request): RedirectResponse
    {
        $count = Article::where('status', 'draft')
            ->when($request->filled('category'), fn ($q) => $q->where('category_id', $request->integer('category')))
            ->when($request->filled('q'), fn ($q) => $q->where('title', 'like', '%'.$request->string('q').'%'))
            ->update(['status' => 'published', 'published_at' => now()]);

        return redirect()->route('admin.articles.index', $request->only('category', 'q'))
            ->with('status', "{$count} artikel draft berhasil di-publish.");
    }

    /**
     * Mode 2: Scrape URL. Mengembalikan JSON draf (judul, excerpt, gambar, teks mentah)
     * untuk mengisi form create — BUKAN langsung menyimpan artikel.
     */
    public function scrape(Request $request, ArticleScraperService $scraper): JsonResponse
    {
        $request->validate(['url' => ['required', 'url']]);

        try {
            $result = $scraper->scrape($request->string('url'));

            return response()->json(['ok' => true, 'data' => $result]);
        } catch (\Throwable $e) {
            return response()->json(['ok' => false, 'message' => $e->getMessage()], 422);
        }
    }

    /**
     * Mode 3: Generate AI. Mengembalikan JSON draf (judul, excerpt, body HTML)
     * untuk mengisi form create — hasilnya selalu perlu ditinjau sebelum dipublikasikan.
     */
    public function generateAi(Request $request, AiArticleGenerator $generator): JsonResponse
    {
        $request->validate([
            'topic' => ['required', 'string', 'max:200'],
            'category_id' => ['required', 'exists:categories,id'],
            'context' => ['nullable', 'string', 'max:500'],
        ]);

        $category = Category::findOrFail($request->integer('category_id'));

        try {
            $result = $generator->generate(
                $request->string('topic'),
                $category->pathLabel(),
                $request->string('context')
            );

            return response()->json(['ok' => true, 'data' => $result]);
        } catch (\Throwable $e) {
            return response()->json(['ok' => false, 'message' => $e->getMessage()], 422);
        }
    }
}

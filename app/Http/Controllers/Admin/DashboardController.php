<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\Category;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $stats = [
            'articles' => Article::count(),
            'published' => Article::where('status', 'published')->count(),
            'drafts' => Article::where('status', 'draft')->count(),
            'categories' => Category::count(),
        ];

        $latest = Article::with('category')->latest()->limit(8)->get();

        return view('admin.dashboard', compact('stats', 'latest'));
    }
}

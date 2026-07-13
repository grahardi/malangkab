<?php

/**
 * Tambahkan baris-baris berikut ke routes/web.php proyek Anda.
 */

use App\Http\Controllers\Admin\ArticleController as AdminArticleController;
use App\Http\Controllers\Admin\AuthController as AdminAuthController;
use App\Http\Controllers\Admin\CategoryController as AdminCategoryController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use Illuminate\Support\Facades\Route;

Route::prefix('admin')->name('admin.')->group(function () {
    // Login tidak butuh middleware auth/admin
    Route::get('login', [AdminAuthController::class, 'showLogin'])->name('login');
    Route::post('login', [AdminAuthController::class, 'login']);
    Route::post('logout', [AdminAuthController::class, 'logout'])->name('logout');

    Route::middleware(['auth', 'admin'])->group(function () {
        Route::get('/', [AdminDashboardController::class, 'index'])->name('dashboard');

        // Manajemen kategori (tree, seperti WordPress/Joomla)
        Route::get('categories', [AdminCategoryController::class, 'index'])->name('categories.index');
        Route::get('categories/create', [AdminCategoryController::class, 'create'])->name('categories.create');
        Route::post('categories', [AdminCategoryController::class, 'store'])->name('categories.store');
        Route::get('categories/{category}/edit', [AdminCategoryController::class, 'edit'])->name('categories.edit');
        Route::put('categories/{category}', [AdminCategoryController::class, 'update'])->name('categories.update');
        Route::delete('categories/{category}', [AdminCategoryController::class, 'destroy'])->name('categories.destroy');

        // Manajemen artikel: manual, scrape URL, generate AI
        Route::get('articles', [AdminArticleController::class, 'index'])->name('articles.index');
        Route::get('articles/create', [AdminArticleController::class, 'create'])->name('articles.create');
        Route::post('articles', [AdminArticleController::class, 'store'])->name('articles.store');
        Route::get('articles/{article}/edit', [AdminArticleController::class, 'edit'])->name('articles.edit');
        Route::put('articles/{article}', [AdminArticleController::class, 'update'])->name('articles.update');
        Route::delete('articles/{article}', [AdminArticleController::class, 'destroy'])->name('articles.destroy');
        Route::post('articles/scrape', [AdminArticleController::class, 'scrape'])->name('articles.scrape');
        Route::post('articles/generate-ai', [AdminArticleController::class, 'generateAi'])->name('articles.generate-ai');
    });
});

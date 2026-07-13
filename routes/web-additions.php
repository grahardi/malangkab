<?php

/**
 * Tambahkan baris-baris berikut ke dalam routes/web.php proyek Anda.
 */

use App\Http\Controllers\ArticleController;
use Illuminate\Support\Facades\Route;

Route::get('/', [ArticleController::class, 'home'])->name('home');
Route::get('/{category}', [ArticleController::class, 'category'])->name('category.show');
Route::get('/{category}/{article}', [ArticleController::class, 'show'])->name('article.show');

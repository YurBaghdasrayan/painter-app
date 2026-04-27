<?php

use App\Http\Controllers\ArticleController;
use App\Http\Controllers\AboutController;
use App\Http\Controllers\CollectionController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\ExhibitionController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\GalleryController;
use App\Http\Controllers\PicturesAndVideosController;
use App\Http\Controllers\SitemapController;
use Illuminate\Support\Facades\Route;

Route::get('/lang/{locale}', function (string $locale) {
    $allowed = ['en', 'ru', 'hy', 'am'];
    if (!in_array($locale, $allowed, true)) {
        $locale = config('app.fallback_locale', 'en');
    }

    // Normalize Armenian to Laravel "hy"
    if ($locale === 'am') {
        $locale = 'hy';
    }

    session(['app_locale' => $locale]);

    return redirect()->back();
})->name('lang.switch');

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/sitemap.xml', [SitemapController::class, 'index'])->name('sitemap');

Route::get('/about', [AboutController::class, 'show'])->name('about');
Route::get('/contact', [ContactController::class, 'show'])->name('contact');

Route::get('/gallery', [GalleryController::class, 'index'])->name('gallery.index');
Route::get('/gallery/sections/{gallery_section}', [GalleryController::class, 'showSection'])->name('gallery.section');
Route::get('/gallery/{slug}', [GalleryController::class, 'show'])->name('gallery.show');

Route::get('/pictures-and-videos', [PicturesAndVideosController::class, 'show'])->name('pictures-and-videos.index');
Route::get('/pictures-and-videos/{itemId}', [PicturesAndVideosController::class, 'showItem'])->name('pictures-and-videos.show');

Route::get('/collection', [CollectionController::class, 'index'])->name('collection.index');
Route::get('/collection/sections/{collection_section}', [CollectionController::class, 'showSection'])->name('collection.section');
Route::get('/collection/{slug}', [CollectionController::class, 'show'])->name('collection.show');

Route::get('/exhibitions', [ExhibitionController::class, 'index'])->name('exhibitions.index');
Route::get('/exhibitions/{exhibition}', [ExhibitionController::class, 'show'])->name('exhibitions.show');

//articles

Route::get('/articles', [ArticleController::class, 'index'])->name('articles.index');
Route::get('/articles/{slug}', [ArticleController::class, 'show'])->name('articles.show');

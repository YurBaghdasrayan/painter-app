<?php

use App\Http\Controllers\ArticleController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\GalleryController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/gallery', [GalleryController::class, 'index'])->name('gallery.index');
Route::get('/gallery/sections/{gallery_section}', [GalleryController::class, 'showSection'])->name('gallery.section');
Route::get('/gallery/{slug}', [GalleryController::class, 'show'])->name('gallery.show');

//articles

Route::get('/articles', [ArticleController::class, 'index'])->name('articles.index');
Route::get('/articles/{slug}', [ArticleController::class, 'show'])->name('articles.show');

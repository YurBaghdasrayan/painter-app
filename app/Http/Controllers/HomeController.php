<?php

namespace App\Http\Controllers;

use App\Models\GallerySection;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function index(): View
    {
        $gallerySection = GallerySection::query()
            ->where('is_active', true)
            ->with([
                'items' => fn ($q) => $q
                    ->where('is_active', true)
                    ->orderBy('sort_order'),
            ])
            ->orderBy('id')
            ->first();

        return view('home', [
            'gallerySection' => $gallerySection,
        ]);
    }
}


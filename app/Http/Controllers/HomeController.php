<?php

namespace App\Http\Controllers;

use App\Models\CollectionSection;
use App\Models\Exhibition;
use App\Models\GallerySection;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function index(): View
    {
        $gallerySections = GallerySection::query()
            ->where('is_active', true)
            ->whereHas('items', function ($q) {
                $q->where('is_active', true);
            })
            ->with(['items' => function ($q) {
                $q->where('is_active', true)->orderBy('sort_order');
            }])
            ->orderBy('id')
            ->get();

        $collectionSections = CollectionSection::query()
            ->where('is_active', true)
            ->whereHas('items', function ($q) {
                $q->where('is_active', true);
            })
            ->with(['items' => function ($q) {
                $q->where('is_active', true)->orderBy('sort_order');
            }])
            ->orderBy('id')
            ->get();

        $exhibitions = Exhibition::query()
            ->select([
                'id',
                'image',
                'title',
                'title_am',
                'title_ru',
                'title_en',
                'description',
                'description_am',
                'description_ru',
                'description_en',
                'sort_order',
                'is_active',
            ])
            ->where('is_active', true)
            ->orderBy('sort_order')
            ->orderBy('id')
            ->limit(2)
            ->get();

        return view('home', [
            'gallerySections' => $gallerySections,
            'collectionSections' => $collectionSections,
            'exhibitions' => $exhibitions,
        ]);
    }
}


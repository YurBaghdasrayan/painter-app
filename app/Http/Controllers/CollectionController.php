<?php

namespace App\Http\Controllers;

use App\Models\CollectionItem;
use App\Models\CollectionSection;
use App\Models\GalleryItem;
use App\Models\StaticPage;
use Illuminate\View\View;

class CollectionController extends Controller
{
    public function index(): View
    {
        $galleryItems = GalleryItem::query()
            ->where('is_active', true)
            ->where('is_featured_on_home', true)
            ->orderBy('sort_order')
            ->orderBy('id')
            ->get();

        $sections = CollectionSection::query()
            ->where('is_active', true)
            ->whereHas('items', function ($q) {
                $q->where('is_active', true);
            })
            ->with([
                'items' => function ($q) {
                    $q->where('is_active', true)->orderBy('sort_order');
                },
            ])
            ->orderBy('id')
            ->get();

        $heroSection = $sections->first();
        $heroItem = $heroSection?->items?->first();

        $staticPage = StaticPage::query()
            ->where('slug', 'collection')
            ->where('is_active', true)
            ->first();

        return view('collection.index', [
            'galleryItems' => $galleryItems,
            'sections' => $sections,
            'heroSection' => $heroSection,
            'heroItem' => $heroItem,
            'staticPage' => $staticPage,
        ]);
    }

    public function showSection(CollectionSection $collectionSection): View
    {
        $section = CollectionSection::query()
            ->whereKey($collectionSection->getKey())
            ->where('is_active', true)
            ->with([
                'items' => function ($q) {
                    $q->where('is_active', true)->orderBy('sort_order');
                },
            ])
            ->firstOrFail();

        $sectionsForCards = CollectionSection::query()
            ->where('is_active', true)
            ->whereHas('items', function ($q) {
                $q->where('is_active', true);
            })
            ->with([
                'items' => function ($q) {
                    $q->where('is_active', true)
                        ->orderBy('sort_order')
                        ->limit(1);
                },
            ])
            ->orderBy('id')
            ->get();

        $staticPage = StaticPage::query()
            ->where('slug', 'collection')
            ->where('is_active', true)
            ->first();

        return view('collection.section', [
            'section' => $section,
            'sectionsForCards' => $sectionsForCards,
            'staticPage' => $staticPage,
        ]);
    }

    public function show(string $slug): View
    {
        $item = CollectionItem::query()
            ->where('is_active', true)
            ->where('slug', $slug)
            ->firstOrFail();

        $relatedItems = CollectionItem::query()
            ->where('is_active', true)
            ->where('id', '!=', $item->id)
            ->orderBy('sort_order')
            ->limit(4)
            ->get();

        $staticPage = StaticPage::query()
            ->where('slug', 'collection')
            ->where('is_active', true)
            ->first();

        return view('collection.show', [
            'item' => $item,
            'relatedItems' => $relatedItems,
            'staticPage' => $staticPage,
        ]);
    }
}


<?php

namespace App\Http\Controllers;

use App\Models\GalleryItem;
use App\Models\GallerySection;
use App\Models\StaticPage;
use Illuminate\Http\Request;
use Illuminate\View\View;

class GalleryController extends Controller
{
    public function index(Request $request): View
    {
        $sections = GallerySection::query()
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
            ->where('slug', 'gallery')
            ->where('is_active', true)
            ->first();

        return view('gallery.index', [
            'sections' => $sections,
            'heroSection' => $heroSection,
            'heroItem' => $heroItem,
            'staticPage' => $staticPage,
        ]);
    }

    public function showSection(GallerySection $gallerySection): View
    {
        $section = GallerySection::query()
            ->whereKey($gallerySection->getKey())
            ->where('is_active', true)
            ->with([
                'items' => function ($q) {
                    $q->where('is_active', true)->orderBy('sort_order');
                },
            ])
            ->firstOrFail();

        $staticPage = StaticPage::query()
            ->where('slug', 'gallery')
            ->where('is_active', true)
            ->first();

        return view('gallery.section', [
            'section' => $section,
            'staticPage' => $staticPage,
        ]);
    }

    public function show(string $slug): View
    {
        $item = GalleryItem::query()
            ->where('is_active', true)
            ->where('slug', $slug)
            ->firstOrFail();

        $relatedItems = GalleryItem::query()
            ->where('is_active', true)
            ->where('id', '!=', $item->id)
            ->orderBy('sort_order')
            ->limit(4)
            ->get();

        $staticPage = StaticPage::query()
            ->where('slug', 'gallery')
            ->where('is_active', true)
            ->first();

        return view('gallery.show', [
            'item' => $item,
            'relatedItems' => $relatedItems,
            'staticPage' => $staticPage,
        ]);
    }
}

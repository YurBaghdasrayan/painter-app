<?php

namespace App\Http\Controllers;

use App\Models\GalleryItem;
use App\Models\StaticPage;
use Illuminate\Http\Request;
use Illuminate\View\View;

class GalleryController extends Controller
{
    public function index(Request $request): View
    {
        $items = GalleryItem::query()
            ->where('is_active', true)
            ->orderBy('sort_order')
            ->orderBy('id')
            ->get();

        $heroItem = $items->first();

        $staticPage = StaticPage::query()
            ->where('slug', 'gallery')
            ->where('is_active', true)
            ->first();

        return view('gallery.index', [
            'items' => $items,
            'heroItem' => $heroItem,
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

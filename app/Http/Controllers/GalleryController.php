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
            ->whereNotNull('image')
            ->where('image', '!=', '')
            ->whereNotNull('slug')
            ->where('slug', '!=', '')
            ->orderBy('sort_order')
            ->orderByDesc('id')
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

        $locale = app()->getLocale();
        if ($locale === 'hy') {
            $locale = 'am';
        }
        if (! in_array($locale, ['am', 'ru', 'en'], true)) {
            $locale = 'en';
        }

        $col = "same_line_title_{$locale}";
        $groupLocalized = trim((string) ($item->getAttribute($col) ?? ''));
        $groupLegacy = trim((string) ($item->getAttribute('same_line_title') ?? ''));
        $groupValue = $groupLocalized !== '' ? $groupLocalized : $groupLegacy;

        $relatedItems = collect();

        if ($groupValue !== '') {
            $relatedQuery = GalleryItem::query()
                ->where('is_active', true)
                ->where('id', '!=', $item->id)
                ->whereNotNull('image')
                ->whereNotNull('slug')
                ->where('slug', '!=', '');

            if ($groupLocalized !== '') {
                $relatedQuery->where($col, $groupValue);
            } else {
                $relatedQuery->where('same_line_title', $groupValue);
            }

            $relatedItems = $relatedQuery
                ->orderBy('sort_order')
                ->orderByDesc('id')
                ->get();
        }

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

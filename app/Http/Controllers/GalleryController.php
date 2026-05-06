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
        if ($locale === 'hy') $locale = 'am';
        if (!in_array($locale, ['am', 'ru', 'en'], true)) $locale = 'en';

        $groupValue = trim((string) ($item->getAttribute("same_line_title_{$locale}") ?? ''));
        if ($groupValue === '') {
            $groupValue = trim((string) ($item->getAttribute('same_line_title') ?? ''));
        }

        $relatedQuery = GalleryItem::query()
            ->where('is_active', true)
            ->where('id', '!=', $item->id)
            ->whereNotNull('image');

        if ($groupValue !== '') {
            $col = "same_line_title_{$locale}";
            // Put same-line items first; if fewer than 4, remaining are filled by others.
            $relatedQuery
                ->orderByRaw("CASE WHEN {$col} = ? THEN 0 ELSE 1 END ASC", [$groupValue])
                ->orderBy('sort_order')
                ->orderByDesc('id');
        } else {
            // No grouping value: just show random other items.
            $relatedQuery->inRandomOrder();
        }

        $relatedItems = $relatedQuery
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

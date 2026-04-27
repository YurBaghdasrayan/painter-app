<?php

namespace App\Http\Controllers;

use App\Models\PicturesAndVideo;
use App\Models\StaticPage;
use Illuminate\Support\Collection;
use Illuminate\View\View;

class PicturesAndVideosController extends Controller
{
    protected function normalizeItemArray($raw, string $fallbackPrefix): Collection
    {
        $raw = is_array($raw) ? $raw : [];

        return collect($raw)
            ->values()
            ->map(function ($it, int $idx) use ($fallbackPrefix) {
                $it = is_array($it) ? $it : [];

                $id = $it['id'] ?? null;
                if (!is_string($id) || trim($id) === '') {
                    $id = "{$fallbackPrefix}-{$idx}";
                }

                $image = $it['image'] ?? null;
                if (is_array($image)) {
                    $image = $image[0] ?? null;
                }

                return [
                    ...$it,
                    'id' => $id,
                    'image' => is_string($image) && trim($image) !== '' ? $image : null,
                ];
            })
            ->filter(fn (array $it) => !empty($it['image']))
            ->values();
    }

    protected function normalizeFirstBlock(?PicturesAndVideo $page): Collection
    {
        return $this->normalizeItemArray(is_array($page?->items) ? $page->items : [], 'photo');
    }

    protected function normalizeSecondBlock(?PicturesAndVideo $page): Collection
    {
        $raw = is_array($page?->content) ? ($page->content['second_block']['items'] ?? []) : [];
        return $this->normalizeItemArray($raw, 'block2');
    }

    protected function normalizeFourthBlock(?PicturesAndVideo $page): Collection
    {
        $raw = is_array($page?->content) ? ($page->content['fourth_block']['items'] ?? []) : [];
        return $this->normalizeItemArray($raw, 'slider');
    }

    protected function normalizeAllItems(?PicturesAndVideo $page): Collection
    {
        return $this->normalizeFirstBlock($page)
            ->concat($this->normalizeSecondBlock($page))
            ->concat($this->normalizeFourthBlock($page))
            ->unique('id')
            ->values();
    }

    public function show(): View
    {
        $staticPage = StaticPage::query()
            ->where('slug', 'pictures-and-videos')
            ->where('is_active', true)
            ->first();

        $page = PicturesAndVideo::query()
            ->where('is_active', true)
            ->orderBy('sort_order')
            ->orderBy('id')
            ->first();

        $items = $this->normalizeFirstBlock($page)->take(5);

        return view('pictures-and-videos.index', [
            'staticPage' => $staticPage,
            'page' => $page,
            'items' => $items,
        ]);
    }

    public function showItem(string $itemId): View
    {
        $staticPage = StaticPage::query()
            ->where('slug', 'pictures-and-videos')
            ->where('is_active', true)
            ->first();

        $page = PicturesAndVideo::query()
            ->where('is_active', true)
            ->orderBy('sort_order')
            ->orderBy('id')
            ->first();

        $items = $this->normalizeAllItems($page);
        $item = $items->firstWhere('id', $itemId);

        abort_if(!$item, 404);

        return view('pictures-and-videos.show', [
            'staticPage' => $staticPage,
            'page' => $page,
            'item' => $item,
        ]);
    }
}


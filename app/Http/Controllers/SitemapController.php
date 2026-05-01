<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\CollectionItem;
use App\Models\CollectionSection;
use App\Models\Exhibition;
use App\Models\GalleryItem;
use Illuminate\Http\Response;

class SitemapController extends Controller
{
    public function index(): Response
    {
        $urls = collect();

        $urls->push([
            'loc' => url('/'),
            'changefreq' => 'weekly',
            'priority' => '1.0',
        ]);

        foreach (['/about', '/contact', '/gallery', '/collection', '/exhibitions', '/articles', '/pictures-and-videos'] as $path) {
            $urls->push([
                'loc' => url($path),
                'changefreq' => 'weekly',
                'priority' => '0.8',
            ]);
        }

        GalleryItem::query()
            ->where('is_active', true)
            ->whereNotNull('slug')
            ->select(['slug', 'updated_at'])
            ->orderBy('id')
            ->chunk(200, function ($rows) use (&$urls) {
                foreach ($rows as $row) {
                    $urls->push([
                        'loc' => route('gallery.show', ['slug' => $row->slug]),
                        'lastmod' => optional($row->updated_at)->toAtomString(),
                        'changefreq' => 'monthly',
                        'priority' => '0.6',
                    ]);
                }
            });

        CollectionSection::query()
            ->where('is_active', true)
            ->select(['id'])
            ->orderBy('id')
            ->chunk(200, function ($rows) use (&$urls) {
                foreach ($rows as $row) {
                    $urls->push([
                        'loc' => route('collection.section', $row),
                        'changefreq' => 'weekly',
                        'priority' => '0.7',
                    ]);
                }
            });

        CollectionItem::query()
            ->where('is_active', true)
            ->whereNotNull('slug')
            ->select(['slug', 'updated_at'])
            ->orderBy('id')
            ->chunk(200, function ($rows) use (&$urls) {
                foreach ($rows as $row) {
                    $urls->push([
                        'loc' => route('collection.show', ['slug' => $row->slug]),
                        'lastmod' => optional($row->updated_at)->toAtomString(),
                        'changefreq' => 'monthly',
                        'priority' => '0.6',
                    ]);
                }
            });

        Exhibition::query()
            ->where('is_active', true)
            ->select(['id', 'updated_at'])
            ->orderBy('id')
            ->chunk(200, function ($rows) use (&$urls) {
                foreach ($rows as $row) {
                    $urls->push([
                        'loc' => route('exhibitions.show', $row),
                        'lastmod' => optional($row->updated_at)->toAtomString(),
                        'changefreq' => 'monthly',
                        'priority' => '0.6',
                    ]);
                }
            });

        Article::query()
            ->where('is_active', true)
            ->whereNotNull('slug')
            ->select(['slug', 'updated_at'])
            ->orderBy('id')
            ->chunk(200, function ($rows) use (&$urls) {
                foreach ($rows as $row) {
                    $urls->push([
                        'loc' => route('articles.show', ['slug' => $row->slug]),
                        'lastmod' => optional($row->updated_at)->toAtomString(),
                        'changefreq' => 'monthly',
                        'priority' => '0.6',
                    ]);
                }
            });

        $xml = view('sitemap.xml', ['urls' => $urls])->render();

        return response($xml, 200, [
            'Content-Type' => 'application/xml; charset=UTF-8',
        ]);
    }
}


<?php

namespace App\Http\Controllers;

use App\Models\Exhibition;
use App\Models\StaticPage;
use Illuminate\View\View;

class ExhibitionController extends Controller
{
    public function index(): View
    {
        $exhibitions = Exhibition::query()
            ->where('is_active', true)
            ->orderBy('sort_order')
            ->orderBy('id')
            ->get();

        $staticPage = StaticPage::query()
            ->where('slug', 'exhibitions')
            ->where('is_active', true)
            ->first();

        return view('exhibitions.index', [
            'exhibitions' => $exhibitions,
            'staticPage' => $staticPage,
        ]);
    }

    public function show(Exhibition $exhibition): View
    {
        abort_unless($exhibition->is_active, 404);

        $exhibition->load([
            'items' => function ($q) {
                $q->where('is_active', true)->orderBy('sort_order');
            },
        ]);

        $staticPage = StaticPage::query()
            ->where('slug', 'exhibitions')
            ->where('is_active', true)
            ->first();

        $relatedExhibitions = Exhibition::query()
            ->select([
                'id',
                'image',
                'title',
                'title_am',
                'title_ru',
                'title_en',
                'sort_order',
                'is_active',
            ])
            ->where('is_active', true)
            ->whereNotNull('image')
            ->where('id', '!=', $exhibition->id)
            ->orderBy('sort_order')
            ->orderBy('id')
            ->limit(12)
            ->get();

        return view('exhibitions.show', [
            'exhibition' => $exhibition,
            'staticPage' => $staticPage,
            'relatedExhibitions' => $relatedExhibitions,
        ]);
    }
}


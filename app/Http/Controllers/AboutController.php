<?php

namespace App\Http\Controllers;

use App\Models\StaticPage;
use Illuminate\View\View;

class AboutController extends Controller
{
    public function show(): View
    {
        $staticPage = StaticPage::query()
            ->where('slug', 'about')
            ->where('is_active', true)
            ->firstOrFail();

        return view('about', [
            'staticPage' => $staticPage,
        ]);
    }
}


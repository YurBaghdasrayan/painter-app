<?php

namespace App\Http\Controllers;

use App\Models\StaticPage;
use Illuminate\View\View;

class ContactController extends Controller
{
    public function show(): View
    {
        $staticPage = StaticPage::query()
            ->where('slug', 'contact')
            ->where('is_active', true)
            ->first();

        return view('contact', [
            'staticPage' => $staticPage,
        ]);
    }
}


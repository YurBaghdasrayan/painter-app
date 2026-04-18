<?php

namespace App\Providers;

use App\Models\StaticPage;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        View::composer('*', function ($view) {
            $footerPage = StaticPage::query()
                ->where('slug', 'footer')
                ->where('is_active', true)
                ->first();

            $footerContent = $footerPage?->localizedContent() ?? [];

            $view->with('footerPage', $footerPage);
            $view->with('footerContent', $footerContent);
        });
    }
}

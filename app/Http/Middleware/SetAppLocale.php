<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SetAppLocale
{
    /**
     * @param  \Closure(\Illuminate\Http\Request): \Symfony\Component\HttpFoundation\Response  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Laravel standard locale for Armenian is "hy".
        // We keep "am" for backward compatibility with existing DB fields/content keys.
        $allowed = ['en', 'ru', 'hy', 'am'];

        $locale = (string) $request->session()->get('app_locale', config('app.locale', 'en'));
        if (!in_array($locale, $allowed, true)) {
            $locale = config('app.fallback_locale', 'en');
        }

        // Normalize "am" to "hy" for the app locale.
        if ($locale === 'am') {
            $locale = 'hy';
        }

        app()->setLocale($locale);

        return $next($request);
    }
}


<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    @php
        $seoTitle = trim((string) view()->yieldContent('title', config('app.name', 'Painter App')));
        $seoDescription = trim((string) view()->yieldContent('meta_description', ''));
        if ($seoDescription === '') {
            $seoDescription = trim((string) view()->yieldContent('description', ''));
        }

        $seoCanonical = trim((string) view()->yieldContent('canonical', url()->current()));
        $seoRobots = trim((string) view()->yieldContent('robots', 'index,follow'));
        $seoOgImage = trim((string) view()->yieldContent('og_image', ''));

        if (mb_strlen($seoDescription) > 180) {
            $seoDescription = mb_substr($seoDescription, 0, 177) . '...';
        }
    @endphp

    <title>{{ $seoTitle }}</title>
    <meta name="description" content="{{ $seoDescription }}">
    <meta name="robots" content="{{ $seoRobots }}">
    <link rel="canonical" href="{{ $seoCanonical }}">

    <meta property="og:type" content="website">
    <meta property="og:title" content="{{ $seoTitle }}">
    <meta property="og:description" content="{{ $seoDescription }}">
    <meta property="og:url" content="{{ $seoCanonical }}">
    @if($seoOgImage !== '')
        <meta property="og:image" content="{{ $seoOgImage }}">
    @endif

    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="{{ $seoTitle }}">
    <meta name="twitter:description" content="{{ $seoDescription }}">
    @if($seoOgImage !== '')
        <meta name="twitter:image" content="{{ $seoOgImage }}">
    @endif

    <link rel="preconnect" href="https://fonts.bunny.net" />
    <link href="https://fonts.bunny.net/css?family=cormorant-garamond:300,400,500,600|inter:200,300,400,500" rel="stylesheet" />

    <link rel="stylesheet" href="{{ asset('assets/css/home.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/gallery.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/articles.css') }}" />
    @stack('styles')
</head>
<body>
    @include('includes.header')

    <main>
        @yield('content')
    </main>
    @include('includes.footer')

    @stack('scripts')
</body>
</html>


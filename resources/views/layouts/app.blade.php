<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>@yield('title', 'Home')</title>

    <link rel="preconnect" href="https://fonts.bunny.net" />
    <link href="https://fonts.bunny.net/css?family=cormorant-garamond:300,400,500,600|inter:200,300,400,500" rel="stylesheet" />

    <link rel="stylesheet" href="{{ asset('assets/css/home.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/gallery.css') }}" />
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


<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>@yield('title', 'Home')</title>

    <link rel="preconnect" href="https://fonts.bunny.net" />
    <link href="https://fonts.bunny.net/css?family=cormorant-garamond:300,400,500,600|inter:200,300,400,500" rel="stylesheet" />

    <link rel="stylesheet" href="{{ asset('assets/css/home.css') }}" />
</head>
<body>
    @include('includes.header')

    <main>
        @yield('content')
    </main>

    @stack('scripts')
</body>
</html>


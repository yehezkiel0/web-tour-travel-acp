<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <title>@yield('title', 'ACP Tours & Travel')</title>

    <link rel="preload" as="image" href="{{ asset('images/home/Hero_Image.webp') }}" fetchpriority="high"
        type="image/webp">
    <link rel="preload" as="image" href="{{ asset('images/home/Hero_Image.png') }}" fetchpriority="high"
        type="image/png">


    <link rel="preload" href="https://cdnjs.cloudflare.com/ajax/libs/izitoast/1.4.0/css/iziToast.min.css"
        as="style" onload="this.onload=null;this.rel='stylesheet'">
    <noscript>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/izitoast/1.4.0/css/iziToast.min.css">
    </noscript>

    <link rel="preload" href="https://kit.fontawesome.com/7fa26d577c.js" as="script" crossorigin="anonymous">

    <link rel="icon" type="image/png" href="{{ asset('favicon-96x96.png') }}" sizes="96x96" />
    <link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}" />
    <link rel="shortcut icon" href="{{ asset('favicon.ico') }}" />
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('apple-touch-icon.png') }}" />
    <meta name="apple-mobile-web-app-title" content="ACP Tours & Travel" />
    <link rel="manifest" href="{{ asset('site.webmanifest') }}" />

    @php
        $isProduction = app()->environment('production');
        $manifestPath = $isProduction ? '../public_html/build/manifest.json' : public_path('build/manifest.json');
    @endphp

    @if ($isProduction && file_exists($manifestPath))
        @php
            $manifest = json_decode(file_get_contents($manifestPath), true);
        @endphp
        <link rel="stylesheet" href="{{ config('app.url') }}/build/{{ $manifest['resources/css/app.css']['file'] }}">
        <script type="module" src="{{ config('app.url') }}/build/{{ $manifest['resources/js/app.js']['file'] }}"></script>
    @else
        @viteReactRefresh
        @vite(['resources/js/app.js', 'resources/css/app.css'])
    @endif
</head>

<body class="font-poppins" data-page="{{ request()->route()->getName() }}">
    <div class="main-wrapper bg-white">
        @yield('content')
    </div>
    <script script src="https://cdnjs.cloudflare.com/ajax/libs/izitoast/1.4.0/js/iziToast.min.js"></script>
    <script src="https://kit.fontawesome.com/7fa26d577c.js" crossorigin="anonymous"></script>
    <x-tooltip />
    <x-alert-notification />
</body>

</html>

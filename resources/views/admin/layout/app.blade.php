<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <link rel="icon" type="image/png" href="{{ asset('uploads/favicon.png') }}">

    <title>Admin Panel</title>

    @php
        $isProduction = app()->environment('production');
        $manifestPath = $isProduction ? '../public_html/build/manifest.json' : public_path('build/manifest.json');
    @endphp

    @if ($isProduction && file_exists($manifestPath))
        @php
            $manifest = json_decode(file_get_contents($manifestPath), true);
            $buildUrl = rtrim(config('app.url'), '/') . '/build';
            $appJs = $manifest['resources/js/app.js']['file'] ?? 'assets/app.js';
            $appCss = $manifest['style.css']['file'] ?? 'assets/style.css';
        @endphp
        <link rel="stylesheet" href="{{ $buildUrl }}/{{ $appCss }}">
        <script type="module" src="{{ $buildUrl }}/{{ $appJs }}"></script>
    @else
        @vite(['resources/js/app.js'])
    @endif
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/izitoast/1.4.0/css/iziToast.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" />
</head>

<body class="bg-gray-100 font-poppins h-full">

    <div class="relative">
        @yield('content')
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/izitoast/1.4.0/js/iziToast.min.js"></script>
    <x-alert-notification />
    <x-text-area-config />
</body>

</html>

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
        $manifestPath = $_SERVER['DOCUMENT_ROOT'] . '/build/manifest.json';
    @endphp


    @if ($isProduction && file_exists($manifestPath))
        @php
            $manifest = json_decode(file_get_contents($manifestPath), true);
        @endphp
        <link rel="stylesheet" href="{{ config('app.url') }}/build/{{ $manifest['resources/css/app.css']['file'] }}">
        <script type="module" src="{{ config('app.url') }}/build/{{ $manifest['resources/js/app.js']['file'] }}"></script>
    @else
        @vite(['resources/js/app.js', 'resources/css/app.css'])
    @endif
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/izitoast/1.4.0/css/iziToast.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" />

    <!-- TinyMCE CDN with API Key -->
    <script src="https://cdn.tiny.cloud/1/rvzuxw8ad6nq8y34fv4yof385m5nyzf1sqs4z6baybpxffmk/tinymce/7/tinymce.min.js"
        referrerpolicy="origin"></script>
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

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <title>ACP</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/izitoast/1.4.0/css/iziToast.min.css" />
    <link rel="stylesheet" href="{{ asset('dist/css/custom-hamburgers.css') }}">
</head>

<body class="font-poppins">
    <div class="main-wrapper bg-white">
        @yield('content')
    </div>
    <script script src="https://cdnjs.cloudflare.com/ajax/libs/izitoast/1.4.0/js/iziToast.min.js"></script>
    <script src="https://kit.fontawesome.com/7fa26d577c.js" crossorigin="anonymous"></script>
    <x-tooltip />
    <x-alert-notification />
</body>

</html>

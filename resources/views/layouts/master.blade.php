<!doctype html>
<html lang="en" data-bs-theme="dark">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta property="og:site_name" content="gw-ent" />
    <!-- App favicon_url -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/fontawesome-v6.css') }}">
</head>

<body>
    <div class="container-fluid text-center">
        @yield('content')
    </div>
    <script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>

    @stack('pesa')
</body>

</html>

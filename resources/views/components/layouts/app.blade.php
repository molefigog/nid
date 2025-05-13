<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/fontawesome-v6.css') }}">
    <title>{{ $title ?? 'Page Title' }}</title>
</head>

<body>
    {{ $slot }}

    <script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>
</body>

</html>

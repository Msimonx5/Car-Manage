<!DOCTYPE html>
<html lang="fr">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>@yield('title','SOULAMI CAR')</title>

    {{-- @vite([
        'resources/css/app.css',
        'resources/js/app.js'
    ]) --}}
<link href="{{ asset('vendor/bootstrap/bootstrap.min.css') }}" rel="stylesheet">
</head>

<body class="bg-light">

@include('layouts.navbar')

<div class="container-fluid py-4">

    @yield('content')

</div>

@stack('scripts')
<script src="{{ asset('vendor/bootstrap/bootstrap.min.js') }}"></script>

</body>

</html>
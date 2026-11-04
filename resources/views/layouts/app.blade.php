<!DOCTYPE html>
<html lang="fr">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>@yield('title','Car manager')</title>

    {{-- @vite([
        'resources/css/app.css',
        'resources/js/app.js'
    ]) --}}
<link href="{{ asset('vendor/bootstrap/bootstrap.min.css') }}" rel="stylesheet">
<style>
    :root{--bs-primary:#1877f2;--bs-primary-rgb:24,119,242}
    .btn-primary{
        --bs-btn-color:#fff;--bs-btn-bg:#1877f2;--bs-btn-border-color:#1877f2;
        --bs-btn-hover-color:#fff;--bs-btn-hover-bg:#1664d9;--bs-btn-hover-border-color:#155dc9;
        --bs-btn-active-color:#fff;--bs-btn-active-bg:#155dc9;--bs-btn-active-border-color:#155dc9;
        --bs-btn-disabled-color:#fff;--bs-btn-disabled-bg:#1877f2;--bs-btn-disabled-border-color:#1877f2
    }
</style>
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
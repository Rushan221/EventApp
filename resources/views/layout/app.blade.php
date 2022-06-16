<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <title>{{ config('app.name', 'Laravel') }}</title>
    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body>
<nav class="navbar navbar-dark bg-dark mb-3">
    <div class="container-fluid">
        <a class="navbar-brand" href="#">Event App</a>
    </div>
</nav>
<div class="container">
    @include('sweetalert::alert')
    @yield('content')
</div>

<!-- Scripts -->
<script src="{{ asset('js/app.js') }}"></script>
@yield('js')
</body>
</html>

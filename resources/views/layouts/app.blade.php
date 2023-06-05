<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Laravel') }}</title>
    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>
    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body>
    <header>
        <div>
            <a href="/" class="logo">Genealogy</a>
            @if(request()->is('imaged*'))
                <a class="link__template" href="/">Обычный</a>
            @else
                <a class="link__template" href="/imaged">С картинкой</a>
            @endif
        </div>
        <div class="links">
            @if(Auth::check())
                <a href="/logout">Выйти</a>
            @else
                <a href="/login">Войти</a>
            @endif
        </div>
    </header>
    @yield('content')
    <footer>
        Разработано в &nbsp;<a href="https://telegram.me/musabekovmg" target="_blank" style="color: #2196F3 !important; font-weight: 600">nello</a>
    </footer>
</body>
</html>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', config('app.name'))</title>
    <link rel="stylesheet" href="{{ asset('powerpuffsite/css/cabinet.css') }}">
    <link rel="shortcut icon" href="{{ asset('powerpuffsite/images/favicon.ico') }}">
    @stack('styles')
</head>
<body class="nk-body bg-white npc-default has-aside dark-mode">
    <div class="nk-app-root">
        <div class="nk-main">
            @yield('content')
        </div>
    </div>

    <script src="{{ asset('powerpuffsite/js/jquery-2.1.1.min.js') }}"></script>
    <script src="{{ asset('powerpuffsite/js/bundle.js') }}"></script>
    <script src="{{ asset('powerpuffsite/js/scripts.js') }}"></script>
    <script src="{{ asset('powerpuffsite/js/ion.rangeSlider.min.js') }}"></script>
    <script src="{{ asset('powerpuffsite/js/jquery-3.4.1.min.js') }}"></script>
    <script src="{{ asset('powerpuffsite/js/main.js') }}"></script>
    @stack('scripts')
</body>
</html>

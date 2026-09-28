<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'IssAltyapı')</title>
    @vite('resources/css/app.css')

    @stack('styles')
</head>

<body class="@yield('body_class', 'bg-white text-gray-900')">

@include('partials.header')

@yield('content')

@stack('scripts')
</body>
</html>


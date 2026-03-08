<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('head-scripts')

    <!-- Theme Initialization -->
    <script>
        (function () {
            // Get user preference from Blade or localStorage
            let theme = '{!! auth()->check() ? auth()->user()->theme : "system" !!}';

            if (theme === 'system') {
                if (window.matchMedia('(prefers-color-scheme: dark)').matches) {
                    document.documentElement.classList.add('dark');
                } else {
                    document.documentElement.classList.remove('dark');
                }
            } else if (theme === 'dark') {
                document.documentElement.classList.add('dark');
            } else {
                document.documentElement.classList.remove('dark');
            }
        })();
    </script>
</head>

@php
    $classes = [
        'body' => $ui['body'],
        'wrapper' => 'min-h-screen flex flex-col',
        'header' => [
            'container' => $ui['page-header'],
            'inner' => "{$ui['container']}"
        ],
        'main' => [
            'container' => $ui['main-wrapper'] . ' flex-1 flex flex-col relative',
            'inner' => "{$ui['container']} flex-1 flex flex-col w-full"
        ]
    ];
@endphp

<body class="{{ $classes['body'] }}">
    <div class="{{ $classes['wrapper'] }}">
        @include('layouts.navigation')

        <!-- Page Heading -->
        @isset($header)
            <header class="{{ $classes['header']['container'] }}">
                <div class="{{ $classes['header']['inner'] }}">
                    {{ $header }}
                </div>
            </header>
        @endisset

        <!-- Page Content -->
        <main class="{{ $classes['main']['container'] }}">
            <div class="{{ $classes['main']['inner'] }}">
                {{ $slot }}
            </div>
        </main>
    </div>
    @stack('scripts')
</body>

</html>
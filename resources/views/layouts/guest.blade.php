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
        'body' => 'font-sans text-secondary antialiased bg-primary-sat',
        'wrapper' => 'min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0',
        'logo_wrapper' => '',
        'logo' => 'w-20 h-20 fill-current text-secondary-desat hover:text-secondary transition-colors',
        'content' => 'w-full sm:max-w-md mt-6 px-6 py-4 bg-primary shadow-sm overflow-hidden sm:rounded-xl border border-tertiary'
    ];
@endphp

<body class="{{ $classes['body'] }}">
    <div class="{{ $classes['wrapper'] }}">
        <div class="{{ $classes['logo_wrapper'] }}">
            <a href="/">
                <x-application-logo class="{{ $classes['logo'] }}" />
            </a>
        </div>

        <div class="{{ $classes['content'] }}">
            {{ $slot }}
        </div>
    </div>
</body>

</html>
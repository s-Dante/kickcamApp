<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />

    <!-- Styles / Scripts -->
    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @else
        <style>
        </style>
    @endif
</head>

<body>
    <main>

        <div class="layer-balls">

        </div>

        <h1>Todo el Mundial en un mismo lugar</h1>
        <span>La experiencia definitiva de realidad aumentada para fanáticos del fútbol.</span>
        <a href="{{ route('auth.login') }}">
            Comenzar Ahora
        </a>
    </main>
</body>

</html>

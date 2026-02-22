<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="{{ $description ?? 'La experiencia definitiva de realidad aumentada para fanáticos del fútbol.' }}">
    <title>{{ $title ?? 'Inicio' }} | {{ config('app.name', 'KickCamApp') }}</title>

    <link rel="preconnect" href="https://fonts.bunny.net">

    @stack('css') {{-- Para CSS específico de cada página --}}

    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @endif
</head>

<body>

    @if (isset($header))
    <header>
        {{ $header }}
    </header>
    @endif

    <main>
        {{ $slot }}
    </main>

    @if (isset($footer))
    <footer>
        {{ $footer }}
    </footer>
    @endif

    @stack('js')
</body>

</html>
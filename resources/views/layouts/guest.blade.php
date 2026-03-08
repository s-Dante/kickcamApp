<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'KickCamApp') }}</title>

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
    <style>
        @keyframes float {

            0%,
            100% {
                transform: translateY(0px) rotate(0deg);
            }

            50% {
                transform: translateY(-20px) rotate(5deg);
            }
        }

        @keyframes blob {
            0% {
                transform: translate(0px, 0px) scale(1);
            }

            33% {
                transform: translate(30px, -50px) scale(1.1);
            }

            66% {
                transform: translate(-20px, 20px) scale(0.9);
            }

            100% {
                transform: translate(0px, 0px) scale(1);
            }
        }

        .animate-float-slow {
            animation: float 8s ease-in-out infinite;
        }

        .animate-blob {
            animation: blob 7s infinite;
        }

        .animation-delay-2000 {
            animation-delay: 2s;
        }

        .animation-delay-4000 {
            animation-delay: 4s;
        }
    </style>
</head>

@php
    $classes = [
        'body' => 'font-sans text-secondary antialiased bg-radial-1 min-h-[100dvh] relative overflow-hidden',
        'backgroundLayer' => 'absolute inset-0 w-full h-full z-0 overflow-hidden pointer-events-none select-none flex items-center justify-center',
        // Blobs
        'blob1' => 'absolute top-[5%] left-[10%] md:top-[10%] md:left-[20%] w-60 h-60 md:w-80 md:h-80 bg-accent/30 dark:bg-accent-sat/20 rounded-full mix-blend-normal blur-[80px] md:blur-[120px] animate-blob',
        'blob2' => 'absolute top-[20%] right-[10%] md:top-[30%] md:right-[20%] w-60 h-60 md:w-80 md:h-80 bg-blue-500/20 dark:bg-blue-600/15 rounded-full mix-blend-normal blur-[80px] md:blur-[120px] animate-blob animation-delay-2000',
        'blob3' => 'absolute bottom-[10%] left-[20%] md:bottom-[10%] md:left-[40%] w-60 h-60 md:w-80 md:h-80 bg-purple-500/20 dark:bg-purple-600/15 rounded-full mix-blend-normal blur-[80px] md:blur-[120px] animate-blob animation-delay-4000',
        // Ball
        'ball' => 'absolute opacity-10 md:opacity-[0.12] pointer-events-none w-[16rem] md:w-[22rem] bottom-[5%] right-[-10%] md:bottom-[5%] md:right-[5%] blur-[1px] animate-float-slow',

        'wrapper' => 'min-h-[100dvh] flex flex-col sm:justify-center items-center py-8 sm:pt-0 relative z-10 px-4',
        'logo_wrapper' => 'mb-4 sm:mb-6',
        'logo' => 'w-16 h-16 sm:w-20 sm:h-20 fill-current text-accent hover:scale-105 transition-transform duration-300 drop-shadow-xl',
        'content' => 'w-full sm:max-w-md px-6 py-6 sm:px-8 sm:py-8 bg-primary/80 dark:bg-primary-sat/80 backdrop-blur-xl shadow-2xl overflow-hidden rounded-[1.5rem] border border-white/40 dark:border-white/10'
    ];
@endphp

<body class="{{ $classes['body'] }}">
    <div class="{{ $classes['backgroundLayer'] }}">
        <div class="{{ $classes['blob1'] }}"></div>
        <div class="{{ $classes['blob2'] }}"></div>
        <div class="{{ $classes['blob3'] }}"></div>
        <img src="{{ asset('assets/wc-balls/2022.png') }}" class="{{ $classes['ball'] }}" alt="Balón Decorativo" />
    </div>

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
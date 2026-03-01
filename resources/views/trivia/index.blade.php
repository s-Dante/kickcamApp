@php
    $classes = [
        'page' => [
            'container' => 'py-6',
            'wrapper' => 'max-w-7xl mx-auto sm:px-6 lg:px-8',
            'header' => 'mb-6 px-4 sm:px-0',
            'title' => $ui['h1'],
            'subtitle' => "mt-1 {$ui['text-muted']}"
        ],
        'challenge' => [
            'card' => "{$ui['card-accent']} mb-8 mx-4 sm:mx-0 transform transition-transform hover:scale-[1.01] cursor-pointer",
            'link' => 'block p-6 sm:p-10 relative',
            'pattern' => 'absolute inset-0 opacity-10 bg-[url(\'data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMjAiIGhlaWdodD0iMjAiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyI+PGNpcmNsZSBjeD0iMiIgY3k9IjIiIHI9IjIiIGZpbGw9IiNmZmYiLz48L3N2Zz4=\')]',
            'content' => 'relative z-10 flex flex-col sm:flex-row items-center justify-between gap-6',
            'text_wrapper' => 'text-center sm:text-left',
            'badge' => 'inline-flex items-center gap-1.5 py-1.5 px-3 rounded-full text-xs font-semibold bg-accent-desat text-accent-sat dark:bg-accent-sat dark:text-accent-desat mb-3 shadow-sm border border-accent/30',
            'badge_icon' => 'w-4 h-4 text-accent',
            'title' => 'text-3xl sm:text-4xl font-extrabold text-secondary-sat dark:text-secondary-desat mb-2 drop-shadow-md',
            'desc' => 'text-secondary dark:text-tertiary-desat text-sm sm:text-base max-w-xl mx-auto sm:mx-0',
            'icon_wrapper' => 'flex-shrink-0 relative',
            'icon_bg' => 'w-24 h-24 sm:w-32 sm:h-32 bg-primary/40 rounded-full flex items-center justify-center backdrop-blur-sm border border-tertiary shadow-2xl',
            'icon' => 'text-5xl sm:text-6xl drop-shadow-lg filter'
        ],
        'grid' => [
            'container' => 'px-4 sm:px-0',
            'header' => 'flex items-center justify-between mb-4',
            'title' => $ui['h2'],
            'badge' => "text-xs font-medium {$ui['text-muted']} bg-tertiary-desat px-2 py-1 rounded-full border border-tertiary",
            'empty_card' => "bg-primary border-2 border-dashed border-tertiary rounded-xl p-8 text-center {$ui['text-muted']}",
            'empty_icon' => 'mx-auto h-12 w-12 text-tertiary-sat mb-3',
            'empty_title' => 'font-medium text-secondary-sat',
            'empty_desc' => 'text-sm',
            'items' => 'grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 sm:gap-6',
            'item_icon' => 'w-3.5 h-3.5 mr-1'
        ]
    ];
@endphp

<x-app-layout>
    <div class="{{ $classes['page']['container'] }}">
        <div class="{{ $classes['page']['wrapper'] }}">

            <!-- Page Header -->
            <div class="{{ $classes['page']['header'] }}">
                <h1 class="{{ $classes['page']['title'] }}">Centro de Trivia</h1>
                <p class="{{ $classes['page']['subtitle'] }}">Demuestra cuánto sabes sobre el mundo y sus selecciones.
                </p>
            </div>

            <!-- Global Challenge (Main Card) -->
            <div class="{{ $classes['challenge']['card'] }}">
                <a href="{{ route('trivia.play', 'world') }}" class="{{ $classes['challenge']['link'] }}">
                    <!-- Background Pattern / Decoration -->
                    <div class="{{ $classes['challenge']['pattern'] }}">
                    </div>

                    <div class="{{ $classes['challenge']['content'] }}">
                        <div class="{{ $classes['challenge']['text_wrapper'] }}">
                            <span class="{{ $classes['challenge']['badge'] }}">
                                <svg class="{{ $classes['challenge']['badge_icon'] }}" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                                </svg>
                                Jugabilidad Infinita
                            </span>
                            <h2 class="{{ $classes['challenge']['title'] }}">
                                Desafío
                                Mundial</h2>
                            <p class="{{ $classes['challenge']['desc'] }}">
                                Enfréntate a preguntas aleatorias sobre capitales, continentes, idiomas y monedas de
                                cualquier rincón del planeta. ¿Podrás ganar la insignia dorada?
                            </p>
                        </div>

                        <div class="{{ $classes['challenge']['icon_wrapper'] }}">
                            <div class="{{ $classes['challenge']['icon_bg'] }}">
                                <span class="{{ $classes['challenge']['icon'] }}">🌍</span>
                            </div>
                        </div>
                    </div>
                </a>
            </div>

            <!-- Country Grid Section -->
            <div class="{{ $classes['grid']['container'] }}">
                <div class="{{ $classes['grid']['header'] }}">
                    <h3 class="{{ $classes['grid']['title'] }}">Trivias por País</h3>
                    <span class="{{ $classes['grid']['badge'] }}">En
                        Base de Datos</span>
                </div>

                @if($countries->isEmpty())
                    <div class="{{ $classes['grid']['empty_card'] }}">
                        <svg class="{{ $classes['grid']['empty_icon'] }}" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 002-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10">
                            </path>
                        </svg>
                        <p class="{{ $classes['grid']['empty_title'] }}">No hay países disponibles</p>
                        <p class="{{ $classes['grid']['empty_desc'] }}">Aún no se han configurado preguntas para selecciones
                            específicas.</p>
                    </div>
                @else
                    <div class="{{ $classes['grid']['items'] }}">
                        @foreach($countries as $country)
                            <x-country-card :href="route('trivia.play', $country->id)" :country="$country">
                                <svg class="{{ $classes['grid']['item_icon'] }}" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z">
                                    </path>
                                </svg>
                                {{ count($country->question) ?? 0 }} Preguntas
                            </x-country-card>
                        @endforeach
                    </div>
                @endif
            </div>

        </div>
    </div>
</x-app-layout>
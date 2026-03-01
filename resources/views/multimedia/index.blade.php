@php
    $classes = [
        'page' => [
            'container' => 'py-6',
            'wrapper' => 'max-w-7xl mx-auto sm:px-6 lg:px-8',
            'header' => 'mb-8 px-4 sm:px-0',
            'title' => $ui['h1'],
            'subtitle' => "mt-1 {$ui['text-muted']}"
        ],
        'content' => [
            'grid_section' => 'px-4 sm:px-0',
            'empty' => [
                'container' => "bg-primary border-2 border-dashed border-tertiary rounded-xl p-8 text-center {$ui['text-muted']}",
                'icon' => 'mx-auto h-12 w-12 text-tertiary-sat mb-3',
                'title' => 'font-medium text-secondary-sat',
                'subtitle' => 'text-sm'
            ],
            'grid' => 'grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 sm:gap-6',
            'card_icon' => 'w-3.5 h-3.5 mr-1'
        ]
    ];
@endphp

<x-app-layout>
    <div class="{{ $classes['page']['container'] }}">
        <div class="{{ $classes['page']['wrapper'] }}">

            <!-- Page Header -->
            <div class="{{ $classes['page']['header'] }}">
                <h1 class="{{ $classes['page']['title'] }}">Multimedia</h1>
                <p class="{{ $classes['page']['subtitle'] }}">Explora videos, momentos y contenido exclusivo por país.
                </p>
            </div>

            <!-- Country Grid Section -->
            <div class="{{ $classes['content']['grid_section'] }}">
                @if($countries->isEmpty())
                    <div class="{{ $classes['content']['empty']['container'] }}">
                        <svg class="{{ $classes['content']['empty']['icon'] }}" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z">
                            </path>
                        </svg>
                        <p class="{{ $classes['content']['empty']['title'] }}">No hay países disponibles</p>
                        <p class="{{ $classes['content']['empty']['subtitle'] }}">Aún no se han configurado selecciones.</p>
                    </div>
                @else
                    <div class="{{ $classes['content']['grid'] }}">
                        @foreach($countries as $country)
                            <x-country-card :href="route('multimedia.show', $country->slug)" :country="$country">
                                <svg class="{{ $classes['content']['card_icon'] }}" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z">
                                    </path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                {{ $country->multimedia_count ?? 0 }} Videos
                            </x-country-card>
                        @endforeach
                    </div>
                @endif
            </div>

        </div>
    </div>
</x-app-layout>
@php
    $classes = [
        'page' => [
            'container' => 'py-6',
            'wrapper' => 'max-w-7xl mx-auto sm:px-6 lg:px-8',
            'back_wrapper' => 'mb-6 px-4 sm:px-0',
            'back_link' => 'inline-flex items-center text-sm font-medium text-accent hover:text-accent-sat transition-colors',
            'back_icon' => 'mr-2 w-4 h-4'
        ],
        'header' => [
            'container' => 'bg-primary overflow-hidden shadow-sm sm:rounded-2xl mb-8 relative border border-tertiary',
            'banner_img' => 'h-32 sm:h-48 w-full bg-cover bg-center',
            'banner_gradient' => 'h-32 sm:h-48 w-full bg-gradient-to-r from-accent to-accent-sat',
            'content' => 'px-4 sm:px-8 pb-8 pt-4 sm:pt-6 relative',
            'badge_wrapper' => 'absolute -top-16 sm:-top-20 left-4 sm:left-8 w-24 h-24 sm:w-32 sm:h-32 bg-primary rounded-full p-2 shadow-lg border-4 border-primary flex items-center justify-center',
            'badge_img' => 'w-full h-full object-contain',
            'badge_icon' => 'text-3xl',
            'info_container' => 'mt-12 sm:mt-14 sm:flex sm:items-end sm:justify-between',
            'title' => "{$ui['h1']} tracking-tight",
            'subtitle' => "text-secondary-desat mt-1 flex items-center",
            'subtitle_text' => 'font-medium text-secondary mr-2',
            'tag' => 'inline-flex items-center rounded-md bg-tertiary-desat px-2 py-1 text-xs font-medium text-secondary-desat ring-1 ring-inset ring-tertiary-sat',
            'stats_wrapper' => 'mt-4 sm:mt-0 flex flex-wrap gap-4 text-sm text-secondary-desat',
            'stat_item' => 'flex items-center',
            'stat_icon' => 'w-4 h-4 mr-1 text-accent'
        ],
        'content' => [
            'grid' => 'grid grid-cols-1 lg:grid-cols-3 gap-8 px-4 sm:px-0',
            'main_col' => 'lg:col-span-2',
            'main_card' => "{$ui['card']} p-6 sm:p-8",
            'main_title' => "{$ui['h2']} mb-4 flex items-center",
            'main_icon' => 'w-5 h-5 text-accent mr-2',
            'prose' => 'prose prose-sm sm:prose-base text-secondary-desat max-w-none',
            'text' => 'whitespace-pre-line',
            'empty' => 'italic',
            'side_col' => 'lg:col-span-1',
            'side_title' => "{$ui['h2']} mb-4 flex items-center",
            'side_icon' => 'w-5 h-5 text-tertiary-sat mr-2',
            'side_empty' => 'bg-tertiary-desat rounded-xl p-6 text-center text-secondary-desat border border-tertiary',
            'event_list' => 'space-y-4',
            'event_card' => "{$ui['card']} p-4 hover:shadow-md transition-shadow",
            'event_header' => "text-xs {$ui['text-muted']} mb-2 flex justify-between",
            'event_league' => 'font-medium',
            'event_row' => 'flex items-center justify-between mb-2',
            'team_col_home' => 'text-sm font-semibold truncate flex-1 text-right',
            'team_col_away' => 'text-sm font-semibold truncate flex-1 text-left',
            'team_match' => 'text-accent',
            'team_nomatch' => 'text-secondary-sat',
            'score_col' => 'px-3 font-mono text-base font-bold text-secondary bg-primary-desat rounded mx-2',
            'score_div' => 'text-tertiary-sat font-normal',
            'video_container' => 'mt-2 text-center',
            'video_link' => 'inline-flex items-center text-xs font-medium text-red-600 hover:text-red-800',
            'video_icon' => 'w-3 h-3 mr-1'
        ]
    ];
@endphp

<x-app-layout>
    <div class="{{ $classes['page']['container'] }}">
        <div class="{{ $classes['page']['wrapper'] }}">

            <!-- Breadcrumbs / Back button -->
            <div class="{{ $classes['page']['back_wrapper'] }}">
                <a href="{{ route('scoreboard.index') }}" class="{{ $classes['page']['back_link'] }}">
                    <svg class="{{ $classes['page']['back_icon'] }}" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    Volver a Marcadores
                </a>
            </div>

            <!-- Team Header Profile -->
            <div class="{{ $classes['header']['container'] }}">
                <!-- Cover Banner (if available) -->
                @if(!empty($team['strEquipment']))
                    <div class="{{ $classes['header']['banner_img'] }}"
                        style="background-image: url('{{ $team['strEquipment'] }}');"></div>
                @else
                    <div class="{{ $classes['header']['banner_gradient'] }}"></div>
                @endif

                <div class="{{ $classes['header']['content'] }}">
                    <!-- Badge overlapping the banner -->
                    <div class="{{ $classes['header']['badge_wrapper'] }}">
                        @if(!empty($team['strBadge']))
                            <img src="{{ $team['strBadge'] }}" alt="{{ $team['strTeam'] }} badge"
                                class="{{ $classes['header']['badge_img'] }}">
                        @else
                            <span class="{{ $classes['header']['badge_icon'] }}">🛡️</span>
                        @endif
                    </div>

                    <div class="{{ $classes['header']['info_container'] }}">
                        <div>
                            <h1 class="{{ $classes['header']['title'] }}">{{ $team['strTeam'] }}</h1>
                            <p class="{{ $classes['header']['subtitle'] }}">
                                <span
                                    class="{{ $classes['header']['subtitle_text'] }}">{{ $team['strAlternate'] ?? '' }}</span>
                                @if(!empty($team['intFormedYear']))
                                    <span class="{{ $classes['header']['tag'] }}">Fundado
                                        en {{ $team['intFormedYear'] }}</span>
                                @endif
                            </p>
                        </div>

                        <!-- Extra Stats/Location -->
                        <div class="{{ $classes['header']['stats_wrapper'] }}">
                            @if(!empty($team['strStadium']))
                                <div class="{{ $classes['header']['stat_item'] }}">
                                    <svg class="{{ $classes['header']['stat_icon'] }}" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4">
                                        </path>
                                    </svg>
                                    Estadio: {{ $team['strStadium'] }}
                                </div>
                            @endif
                            @if(!empty($team['strCountry']))
                                <div class="{{ $classes['header']['stat_item'] }}">
                                    <svg class="{{ $classes['header']['stat_icon'] }}" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z">
                                        </path>
                                    </svg>
                                    {{ $team['strCountry'] }}
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- Content Grid -->
            <div class="{{ $classes['content']['grid'] }}">

                <!-- Main Content / Biography -->
                <div class="{{ $classes['content']['main_col'] }}">
                    <div class="{{ $classes['content']['main_card'] }}">
                        <h2 class="{{ $classes['content']['main_title'] }}">
                            <svg class="{{ $classes['content']['main_icon'] }}" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            Sobre {{ $team['strTeam'] }}
                        </h2>
                        <div class="{{ $classes['content']['prose'] }}">
                            @if(!empty($team['strDescriptionES']))
                                <p class="{{ $classes['content']['text'] }}">{{ $team['strDescriptionES'] }}</p>
                            @elseif(!empty($team['strDescriptionEN']))
                                <p class="{{ $classes['content']['text'] }}">{{ $team['strDescriptionEN'] }}</p>
                            @else
                                <p class="{{ $classes['content']['empty'] }}">No hay biografía disponible para este equipo.
                                </p>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Sidebar / Last Events -->
                <div class="{{ $classes['content']['side_col'] }}">
                    <h2 class="{{ $classes['content']['side_title'] }}">
                        <svg class="{{ $classes['content']['side_icon'] }}" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        Últimos Enfrentamientos
                    </h2>

                    @if(empty($lastEvents))
                        <div class="{{ $classes['content']['side_empty'] }}">
                            No hay registro de partidos recientes para este equipo.
                        </div>
                    @else
                        <div class="{{ $classes['content']['event_list'] }}">
                            @foreach($lastEvents as $event)
                                <div class="{{ $classes['content']['event_card'] }}">
                                    <div class="{{ $classes['content']['event_header'] }}">
                                        <span>{{ \Carbon\Carbon::parse($event['dateEvent'])->format('d M Y') }}</span>
                                        <span
                                            class="{{ $classes['content']['event_league'] }}">{{ $event['strLeague'] ?? '' }}</span>
                                    </div>

                                    <div class="{{ $classes['content']['event_row'] }}">
                                        <!-- Home Team -->
                                        <div
                                            class="{{ $classes['content']['team_col_home'] }} {{ $event['idHomeTeam'] === $team['idTeam'] ? $classes['content']['team_match'] : $classes['content']['team_nomatch'] }}">
                                            {{ $event['strHomeTeam'] }}
                                        </div>

                                        <!-- Score -->
                                        <div class="{{ $classes['content']['score_col'] }}">
                                            {{ $event['intHomeScore'] ?? '-' }} <span
                                                class="{{ $classes['content']['score_div'] }}">:</span>
                                            {{ $event['intAwayScore'] ?? '-' }}
                                        </div>

                                        <!-- Away Team -->
                                        <div
                                            class="{{ $classes['content']['team_col_away'] }} {{ $event['idAwayTeam'] === $team['idTeam'] ? $classes['content']['team_match'] : $classes['content']['team_nomatch'] }}">
                                            {{ $event['strAwayTeam'] }}
                                        </div>
                                    </div>

                                    @if($event['strVideo'])
                                        <div class="{{ $classes['content']['video_container'] }}">
                                            <a href="{{ $event['strVideo'] }}" target="_blank"
                                                class="{{ $classes['content']['video_link'] }}">
                                                <svg class="{{ $classes['content']['video_icon'] }}" fill="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path d="M8 5v14l11-7z" />
                                                </svg>
                                                Highlights
                                            </a>
                                        </div>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>

            </div>
        </div>
    </div>
</x-app-layout>
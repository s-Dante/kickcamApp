@php
    $classes = [
        'page' => [
            'container' => 'py-6',
            'wrapper' => 'max-w-7xl mx-auto sm:px-6 lg:px-8',
            'header' => 'mb-6 px-4 sm:px-0',
            'title' => $ui['h1'],
            'subtitle' => "mt-1 {$ui['text-muted']}"
        ],
        'filters' => [
            'container' => 'mb-8 px-4 sm:px-0 scrollbar-hide overflow-x-auto',
            'nav' => 'flex space-x-4',
            'link' => 'px-4 py-2 font-medium text-sm rounded-md whitespace-nowrap transition-colors',
            'link_active' => 'bg-accent-desat/30 text-accent-sat dark:text-accent-desat',
            'link_inactive' => 'text-tertiary-sat hover:text-secondary hover:bg-tertiary-desat/50',
            'icon' => 'mr-2'
        ],
        'content' => [
            'grid' => 'px-4 sm:px-0 grid grid-cols-1 lg:grid-cols-2 gap-8'
        ],
        'events' => [
            'title' => "{$ui['h2']} mb-4 flex items-center",
            'title_icon' => 'w-5 h-5 text-tertiary-sat mr-2',
            'empty' => [
                'container' => 'bg-accent-desat/10 rounded-xl p-8 text-center text-accent-sat dark:text-accent-desat border border-accent/20 flex flex-col items-center justify-center',
                'icon' => 'text-4xl mb-3',
                'title' => 'font-bold text-lg mb-1',
                'desc' => 'text-sm opacity-80 max-w-sm',
                'highlight' => 'font-bold'
            ],
            'list' => 'space-y-4',
            'past_card' => "{$ui['card']} p-4 hover:shadow-md transition-shadow",
            'date' => "text-xs {$ui['text-muted']} mb-2 font-medium",
            'row' => 'flex items-center justify-between',
            'team_col_home' => 'flex flex-col flex-1 text-right gap-2',
            'team_col_away' => 'flex flex-col flex-1 text-left gap-2',
            'team_link' => 'font-semibold text-secondary-sat hover:text-accent transition-colors',
            'team_link_winner' => 'text-accent',
            'score_col' => 'px-6 flex items-center gap-3 font-mono text-xl font-bold text-secondary',
            'score_div' => 'text-tertiary-sat',
            'video_container' => 'mt-3 text-center border-t border-tertiary pt-2',
            'video_link' => 'text-xs text-red-600 hover:text-red-800 flex items-center justify-center font-medium',
            'video_icon' => 'w-4 h-4 mr-1',
            'next_card' => 'bg-primary rounded-xl shadow-sm border border-tertiary p-4 border-l-4 border-l-accent hover:border-l-accent-sat transition-colors',
            'next_row' => 'flex flex-col items-center sm:flex-row sm:justify-between text-center sm:text-left mb-3 sm:mb-0',
            'next_team_col' => 'flex-1',
            'next_team_col_right' => 'flex-1 sm:text-right',
            'next_team_link' => 'font-bold text-secondary-sat hover:text-accent transition-colors block',
            'next_label' => "text-xs {$ui['text-muted']}",
            'next_vs' => 'px-6 font-bold text-tertiary-sat my-2 sm:my-0',
            'next_time' => "mt-3 bg-tertiary-desat rounded p-2 text-center text-xs {$ui['text-muted']} flex justify-center items-center gap-2",
            'next_time_icon' => 'w-4 h-4'
        ]
    ];
@endphp

<x-app-layout>
    <div class="{{ $classes['page']['container'] }}">
        <div class="{{ $classes['page']['wrapper'] }}">

            <!-- Page Header -->
            <div class="{{ $classes['page']['header'] }}">
                <h1 class="{{ $classes['page']['title'] }}">Marcadores</h1>
                <p class="{{ $classes['page']['subtitle'] }}">Resultados en vivo y próximos eventos cortesía de
                    TheSportsDB.
                </p>
            </div>

            <!-- League Filters (Tabs) -->
            <div class="{{ $classes['filters']['container'] }}">
                <nav class="{{ $classes['filters']['nav'] }}" aria-label="Tabs">
                    @foreach($leagues as $league)
                        <a href="{{ route('scoreboard.index', ['league' => $league['id']]) }}"
                            class="{{ $classes['filters']['link'] }} {{ $activeLeague['id'] === $league['id'] ? $classes['filters']['link_active'] : $classes['filters']['link_inactive'] }}">
                            <span class="{{ $classes['filters']['icon'] }}">{{ $league['icon'] }}</span>
                            {{ $league['name'] }}
                        </a>
                    @endforeach
                </nav>
            </div>

            <!-- Dashboard Content -->
            <div class="{{ $classes['content']['grid'] }}">

                <!-- Live Events Column (Full Width if exists) -->
                @if(!empty($liveEvents))
                    <div class="col-span-1 lg:col-span-2 mb-6">
                        <h2 class="{{ $classes['events']['title'] }} text-red-500 animate-pulse">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                            </svg>
                            EN VIVO
                        </h2>

                        <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-4">
                            @foreach($liveEvents as $event)
                                <div
                                    class="bg-primary border-2 border-red-500/50 rounded-xl p-4 shadow-[0_0_15px_rgba(239,68,68,0.2)]">
                                    <div class="flex justify-between items-center mb-3">
                                        <span
                                            class="text-xs font-bold text-red-500 bg-red-500/10 px-2 py-1 rounded-full animate-pulse">
                                            LIVE
                                        </span>
                                        <span class="text-xs text-secondary-desat font-mono">
                                            {{ $event['strTime'] ?? 'En juego' }}
                                        </span>
                                    </div>
                                    <div class="flex items-center justify-between">
                                        <div class="flex-1 text-center">
                                            <a href="{{ route('scoreboard.team', $event['idHomeTeam']) }}"
                                                class="{{ $classes['events']['team_link'] }} text-lg">
                                                {{ $event['strHomeTeam'] }}
                                            </a>
                                        </div>
                                        <div class="px-4 font-mono text-2xl font-bold text-secondary flex items-center gap-2">
                                            <span
                                                class="{{ isset($event['intHomeScore']) && $event['intHomeScore'] > $event['intAwayScore'] ? 'text-accent' : '' }}">{{ $event['intHomeScore'] ?? '-' }}</span>
                                            <span class="text-tertiary-sat text-sm">-</span>
                                            <span
                                                class="{{ isset($event['intAwayScore']) && $event['intAwayScore'] > $event['intHomeScore'] ? 'text-accent' : '' }}">{{ $event['intAwayScore'] ?? '-' }}</span>
                                        </div>
                                        <div class="flex-1 text-center">
                                            <a href="{{ route('scoreboard.team', $event['idAwayTeam']) }}"
                                                class="{{ $classes['events']['team_link'] }} text-lg">
                                                {{ $event['strAwayTeam'] }}
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif

                <!-- Past Events Column -->
                <div>
                    <h2 class="{{ $classes['events']['title'] }}">
                        <svg class="{{ $classes['events']['title_icon'] }}" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        Últimos Resultados
                    </h2>

                    @if(empty($pastEvents))
                        <div class="{{ $classes['events']['empty']['container'] }}">
                            <span class="{{ $classes['events']['empty']['icon'] }}">📡</span>
                            <h3 class="{{ $classes['events']['empty']['title'] }}">Resultados No Soportados</h3>
                            <p class="{{ $classes['events']['empty']['desc'] }}">
                                Los últimos resultados de esta liga no están disponibles para terceros en este momento bajo
                                el plan de datos gratuito. Intenta explorando el contenido de <span
                                    class="{{ $classes['events']['empty']['highlight'] }}">Mundial 2026</span> o <span
                                    class="{{ $classes['events']['empty']['highlight'] }}">Premier League</span>.
                            </p>
                        </div>
                    @else
                        <div class="{{ $classes['events']['list'] }}">
                            @foreach($pastEvents as $event)
                                <div class="{{ $classes['events']['past_card'] }}">
                                    <div class="{{ $classes['events']['date'] }}">
                                        {{ \Carbon\Carbon::parse($event['dateEvent'])->format('d M Y') }}
                                    </div>
                                    <div class="{{ $classes['events']['row'] }}">
                                        <div class="{{ $classes['events']['team_col_home'] }}">
                                            <a href="{{ route('scoreboard.team', $event['idHomeTeam']) }}"
                                                class="{{ $classes['events']['team_link'] }} {{ $event['intHomeScore'] > $event['intAwayScore'] ? $classes['events']['team_link_winner'] : '' }}">
                                                {{ $event['strHomeTeam'] }}
                                            </a>
                                        </div>
                                        <div class="{{ $classes['events']['score_col'] }}">
                                            <span>{{ $event['intHomeScore'] ?? '-' }}</span>
                                            <span class="{{ $classes['events']['score_div'] }}">-</span>
                                            <span>{{ $event['intAwayScore'] ?? '-' }}</span>
                                        </div>
                                        <div class="{{ $classes['events']['team_col_away'] }}">
                                            <a href="{{ route('scoreboard.team', $event['idAwayTeam']) }}"
                                                class="{{ $classes['events']['team_link'] }} {{ $event['intAwayScore'] > $event['intHomeScore'] ? $classes['events']['team_link_winner'] : '' }}">
                                                {{ $event['strAwayTeam'] }}
                                            </a>
                                        </div>
                                    </div>
                                    @if($event['strVideo'])
                                        <div class="{{ $classes['events']['video_container'] }}">
                                            <a href="{{ $event['strVideo'] }}" target="_blank"
                                                class="{{ $classes['events']['video_link'] }}">
                                                <svg class="{{ $classes['events']['video_icon'] }}" fill="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path d="M8 5v14l11-7z" />
                                                </svg>
                                                Ver Highlights
                                            </a>
                                        </div>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>

                <!-- Next Events Column -->
                <div>
                    <h2 class="{{ $classes['events']['title'] }}">
                        <svg class="{{ $classes['events']['title_icon'] }}" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
                            </path>
                        </svg>
                        Próximos Partidos
                    </h2>

                    @if(empty($nextEvents))
                        <div class="{{ $classes['events']['empty']['container'] }}">
                            <span class="{{ $classes['events']['empty']['icon'] }}">🗓️</span>
                            <h3 class="{{ $classes['events']['empty']['title'] }}">Calendario No Disponible</h3>
                            <p class="{{ $classes['events']['empty']['desc'] }}">
                                Este bloque de calendario está reservado u oculto por los proveedores de la API para esta
                                liga.
                            </p>
                        </div>
                    @else
                        <div class="{{ $classes['events']['list'] }}">
                            @foreach($nextEvents as $event)
                                <div class="{{ $classes['events']['next_card'] }}">
                                    <div class="{{ $classes['events']['next_row'] }}">
                                        <div class="{{ $classes['events']['next_team_col'] }}">
                                            <a href="{{ route('scoreboard.team', $event['idHomeTeam']) }}"
                                                class="{{ $classes['events']['next_team_link'] }}">{{ $event['strHomeTeam'] }}</a>
                                            <div class="{{ $classes['events']['next_label'] }}">Local</div>
                                        </div>
                                        <div class="{{ $classes['events']['next_vs'] }}">VS</div>
                                        <div class="{{ $classes['events']['next_team_col_right'] }}">
                                            <a href="{{ route('scoreboard.team', $event['idAwayTeam']) }}"
                                                class="{{ $classes['events']['next_team_link'] }}">{{ $event['strAwayTeam'] }}</a>
                                            <div class="{{ $classes['events']['next_label'] }}">Visitante</div>
                                        </div>
                                    </div>
                                    <div class="{{ $classes['events']['next_time'] }}">
                                        <svg class="{{ $classes['events']['next_time_icon'] }}" fill="none"
                                            stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                        {{ \Carbon\Carbon::parse($event['dateEvent'])->format('l, d M Y') }} •
                                        {{ $event['strTime'] ?? 'Por Definir' }}
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>

            </div>
        </div>
    </div>
</x-app-layout>
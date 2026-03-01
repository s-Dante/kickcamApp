<x-app-layout>
    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <!-- Page Header -->
            <div class="mb-6 px-4 sm:px-0">
                <h1 class="{{ $ui['h1'] }}">Marcadores</h1>
                <p class="mt-1 {{ $ui['text-muted'] }}">Resultados en vivo y próximos eventos cortesía de TheSportsDB.
                </p>
            </div>

            <!-- League Filters (Tabs) -->
            <div class="mb-8 px-4 sm:px-0 scrollbar-hide overflow-x-auto">
                <nav class="flex space-x-4" aria-label="Tabs">
                    @foreach($leagues as $league)
                        <a href="{{ route('scoreboard.index', ['league' => $league['id']]) }}" class="{{ $activeLeague['id'] === $league['id'] ? 'bg-accent-desat/30 text-accent-sat dark:text-accent-desat' : 'text-tertiary-sat hover:text-secondary hover:bg-tertiary-desat/50' }} 
                                       px-4 py-2 font-medium text-sm rounded-md whitespace-nowrap transition-colors">
                            <span class="mr-2">{{ $league['icon'] }}</span>
                            {{ $league['name'] }}
                        </a>
                    @endforeach
                </nav>
            </div>

            <!-- Dashboard Content -->
            <div class="px-4 sm:px-0 grid grid-cols-1 lg:grid-cols-2 gap-8">

                <!-- Past Events Column -->
                <div>
                    <h2 class="{{ $ui['h2'] }} mb-4 flex items-center">
                        <svg class="w-5 h-5 text-tertiary-sat mr-2" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        Últimos Resultados
                    </h2>

                    @if(empty($pastEvents))
                        <div
                            class="bg-accent-desat/10 rounded-xl p-8 text-center text-accent-sat dark:text-accent-desat border border-accent/20 flex flex-col items-center justify-center">
                            <span class="text-4xl mb-3">📡</span>
                            <h3 class="font-bold text-lg mb-1">Resultados No Soportados</h3>
                            <p class="text-sm opacity-80 max-w-sm">
                                Los últimos resultados de esta liga no están disponibles para terceros en este momento bajo
                                el plan de datos gratuito. Intenta explorando el contenido de <span
                                    class="font-bold">Mundial 2026</span> o <span class="font-bold">Premier League</span>.
                            </p>
                        </div>
                    @else
                        <div class="space-y-4">
                            @foreach($pastEvents as $event)
                                <div class="{{ $ui['card'] }} p-4 hover:shadow-md transition-shadow">
                                    <div class="text-xs {{ $ui['text-muted'] }} mb-2 font-medium">
                                        {{ \Carbon\Carbon::parse($event['dateEvent'])->format('d M Y') }}
                                    </div>
                                    <div class="flex items-center justify-between">
                                        <div class="flex flex-col flex-1 text-right gap-2">
                                            <a href="{{ route('scoreboard.team', $event['idHomeTeam']) }}"
                                                class="font-semibold text-secondary-sat hover:text-accent transition-colors {{ $event['intHomeScore'] > $event['intAwayScore'] ? 'text-accent' : '' }}">
                                                {{ $event['strHomeTeam'] }}
                                            </a>
                                        </div>
                                        <div class="px-6 flex items-center gap-3 font-mono text-xl font-bold text-secondary">
                                            <span>{{ $event['intHomeScore'] ?? '-' }}</span>
                                            <span class="text-tertiary-sat">-</span>
                                            <span>{{ $event['intAwayScore'] ?? '-' }}</span>
                                        </div>
                                        <div class="flex flex-col flex-1 text-left gap-2">
                                            <a href="{{ route('scoreboard.team', $event['idAwayTeam']) }}"
                                                class="font-semibold text-secondary-sat hover:text-accent transition-colors {{ $event['intAwayScore'] > $event['intHomeScore'] ? 'text-accent' : '' }}">
                                                {{ $event['strAwayTeam'] }}
                                            </a>
                                        </div>
                                    </div>
                                    @if($event['strVideo'])
                                        <div class="mt-3 text-center border-t border-tertiary pt-2">
                                            <a href="{{ $event['strVideo'] }}" target="_blank"
                                                class="text-xs text-red-600 hover:text-red-800 flex items-center justify-center font-medium">
                                                <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 24 24">
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
                    <h2 class="{{ $ui['h2'] }} mb-4 flex items-center">
                        <svg class="w-5 h-5 text-tertiary-sat mr-2" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
                            </path>
                        </svg>
                        Próximos Partidos
                    </h2>

                    @if(empty($nextEvents))
                        <div
                            class="bg-accent-desat/10 rounded-xl p-8 text-center text-accent-sat dark:text-accent-desat border border-accent/20 flex flex-col items-center justify-center">
                            <span class="text-4xl mb-3">🗓️</span>
                            <h3 class="font-bold text-lg mb-1">Calendario No Disponible</h3>
                            <p class="text-sm opacity-80 max-w-sm">
                                Este bloque de calendario está reservado u oculto por los proveedores de la API para esta
                                liga.
                            </p>
                        </div>
                    @else
                        <div class="space-y-4">
                            @foreach($nextEvents as $event)
                                <div
                                    class="bg-primary rounded-xl shadow-sm border border-tertiary p-4 border-l-4 border-l-accent hover:border-l-accent-sat transition-colors">
                                    <div
                                        class="flex flex-col items-center sm:flex-row sm:justify-between text-center sm:text-left mb-3 sm:mb-0">
                                        <div class="flex-1">
                                            <a href="{{ route('scoreboard.team', $event['idHomeTeam']) }}"
                                                class="font-bold text-secondary-sat hover:text-accent transition-colors block">{{ $event['strHomeTeam'] }}</a>
                                            <div class="text-xs {{ $ui['text-muted'] }}">Local</div>
                                        </div>
                                        <div class="px-6 font-bold text-tertiary-sat my-2 sm:my-0">VS</div>
                                        <div class="flex-1 sm:text-right">
                                            <a href="{{ route('scoreboard.team', $event['idAwayTeam']) }}"
                                                class="font-bold text-secondary-sat hover:text-accent transition-colors block">{{ $event['strAwayTeam'] }}</a>
                                            <div class="text-xs {{ $ui['text-muted'] }}">Visitante</div>
                                        </div>
                                    </div>
                                    <div
                                        class="mt-3 bg-tertiary-desat rounded p-2 text-center text-xs {{ $ui['text-muted'] }} flex justify-center items-center gap-2">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
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
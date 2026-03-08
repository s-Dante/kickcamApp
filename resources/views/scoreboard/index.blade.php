@php
    function formatTime($time)
    {
        if (!$time)
            return 'Por Definir';
        try {
            return \Carbon\Carbon::parse($time)->format('H:i');
        } catch (\Exception $e) {
            return $time;
        }
    }
@endphp

<x-app-layout>
    <div class="py-10 bg-tertiary-desat/5 min-h-screen font-sans">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-10">

            <!-- Page Header -->
            <div
                class="px-4 sm:px-0 flex flex-col sm:flex-row sm:justify-between sm:items-end border-b border-tertiary/60 pb-6 gap-4">
                <div>
                    <h1 class="text-4xl font-light text-secondary tracking-tight">Marcadores</h1>
                    <p class="mt-2 text-tertiary-sat text-sm uppercase tracking-widest font-bold">
                        Resultados y Posiciones
                    </p>
                </div>

                <!-- League Filters (Elegant Underline Tabs) -->
                <nav class="flex overflow-x-auto scrollbar-hide space-x-6 sm:space-x-8" aria-label="Tabs">
                    @foreach($leagues as $league)
                        <a href="{{ route('scoreboard.index', ['league' => $league['id']]) }}"
                            class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm transition-colors duration-200 {{ $activeLeague['id'] === $league['id'] ? 'border-accent text-secondary' : 'border-transparent text-tertiary-sat hover:text-secondary hover:border-tertiary' }}">
                            <span class="mr-1.5 opacity-80">{{ $league['icon'] }}</span>
                            {{ $league['name'] }}
                        </a>
                    @endforeach
                </nav>
            </div>

            <!-- Content Area (Triple Column Layout) -->
            <div class="px-4 sm:px-0 grid grid-cols-1 lg:grid-cols-3 gap-8">

                <!-- COLUMN 1: Standings (Left) -->
                <div class="space-y-8">
                    <section class="sticky top-20">
                        <div class="flex items-center justify-between mb-4">
                            <h2 class="text-xl font-medium text-secondary">Tabla General</h2>
                            <span
                                class="text-xs text-tertiary-sat font-bold uppercase tracking-widest bg-tertiary-desat px-2 py-1 rounded">Temp
                                25/26</span>
                        </div>

                        @if(empty($standings))
                            <div class="bg-primary border border-tertiary/40 rounded-2xl p-8 text-center shadow-sm">
                                <p class="text-sm text-tertiary-sat">Clasificaciones no emitidas actualmente.</p>
                            </div>
                        @else
                            <div class="bg-primary border border-tertiary/40 rounded-2xl shadow-sm overflow-hidden">
                                <table class="w-full text-left text-sm">
                                    <thead
                                        class="bg-tertiary-desat/30 text-xs uppercase font-bold text-tertiary-sat border-b border-tertiary/50">
                                        <tr>
                                            <th scope="col" class="px-3 py-3 w-8 text-center">#</th>
                                            <th scope="col" class="px-2 py-3">Club</th>
                                            <th scope="col" class="px-2 py-3 text-center" title="Partidos Jugados">PJ</th>
                                            <th scope="col" class="px-2 py-3 text-center hidden xl:table-cell"
                                                title="Diferencia de Goles">DIF</th>
                                            <th scope="col" class="px-3 py-3 text-center text-secondary">PTS</th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-tertiary/20">
                                        @foreach(array_slice($standings, 0, 18) as $row)
                                            <tr class="hover:bg-tertiary-desat/5 transition-colors group">
                                                <td class="px-3 py-3 text-center text-tertiary-sat font-mono text-xs">
                                                    {{ $row['intRank'] }}
                                                </td>
                                                <td class="px-2 py-3 font-medium text-secondary flex items-center gap-2">
                                                    @if(!empty($row['strBadge']))
                                                        <img src="{{ $row['strBadge'] }}" alt="Escudo de {{ $row['strTeam'] }}"
                                                            class="w-5 h-5 object-contain opacity-90 group-hover:opacity-100 transition-opacity">
                                                    @else
                                                        <span class="w-5 h-5 rounded-full bg-tertiary-desat"></span>
                                                    @endif
                                                    <a href="{{ route('scoreboard.team', $row['idTeam'] ?? '0') }}"
                                                        class="truncate max-w-[90px] xl:max-w-[120px] hover:text-accent transition-colors">
                                                        {{ $row['strTeam'] }}
                                                    </a>
                                                </td>
                                                <td class="px-2 py-3 text-center text-tertiary-sat">
                                                    {{ $row['intPlayed'] }}
                                                </td>
                                                <td class="px-2 py-3 text-center text-tertiary-sat hidden xl:table-cell">
                                                    {{ $row['intGoalDifference'] > 0 ? '+' . $row['intGoalDifference'] : $row['intGoalDifference'] }}
                                                </td>
                                                <td class="px-3 py-3 text-center font-bold text-secondary">
                                                    {{ $row['intPoints'] }}
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @endif
                    </section>
                </div>

                <!-- COLUMN 2: Past Events (Middle) -->
                <div class="space-y-8">
                    <section>
                        <h2 class="text-xl font-medium text-secondary mb-4 flex items-center gap-2">
                            <span class="w-2 h-2 rounded-full bg-accent/60"></span>
                            Resultados Recientes
                        </h2>

                        @if(empty($pastEvents))
                            <div
                                class="border border-dashed border-tertiary/50 rounded-xl p-8 text-center text-tertiary-sat">
                                <p>Información no disponible en este nivel de acceso (API Tier).</p>
                            </div>
                        @else
                            <div class="bg-primary border border-tertiary/40 rounded-2xl overflow-hidden shadow-sm">
                                <ul class="divide-y divide-tertiary/30">
                                    @foreach($pastEvents as $event)
                                        <li class="p-4 hover:bg-tertiary-desat/10 transition-colors flex flex-col gap-3 group">
                                            <!-- Date and Highlights -->
                                            <div
                                                class="flex justify-between items-center text-[11px] font-bold text-tertiary-sat uppercase tracking-wider">
                                                <span>{{ \Carbon\Carbon::parse($event['dateEvent'])->translatedFormat('d M Y') }}</span>
                                                @if(!empty($event['strVideo']))
                                                    <a href="{{ $event['strVideo'] }}" target="_blank"
                                                        class="text-red-500 hover:text-red-600 transition-colors opacity-0 group-hover:opacity-100 flex items-center gap-1"
                                                        title="Ver Highlights">
                                                        <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 24 24">
                                                            <path d="M8 5v14l11-7z" />
                                                        </svg>
                                                        Highlights
                                                    </a>
                                                @endif
                                            </div>

                                            <!-- Teams & Score Row -->
                                            <div class="flex items-center justify-between gap-2">
                                                <div class="flex-1 text-right truncate">
                                                    <a href="{{ route('scoreboard.team', $event['idHomeTeam'] ?? '0') }}"
                                                        class="font-medium text-sm text-secondary hover:text-accent transition-colors {{ isset($event['intHomeScore']) && $event['intHomeScore'] > ($event['intAwayScore'] ?? -1) ? 'font-bold' : '' }}">
                                                        {{ $event['strHomeTeam'] ?? 'Local' }}
                                                    </a>
                                                </div>
                                                <div
                                                    class="px-2 py-1 bg-tertiary-desat/30 rounded flex gap-2 font-mono font-bold items-center justify-center min-w-[64px] text-sm md:text-base">
                                                    <span
                                                        class="{{ isset($event['intHomeScore']) && $event['intHomeScore'] > ($event['intAwayScore'] ?? -1) ? 'text-accent' : 'text-secondary' }}">{{ $event['intHomeScore'] ?? '-' }}</span>
                                                    <span class="text-tertiary-sat font-normal opacity-50">-</span>
                                                    <span
                                                        class="{{ isset($event['intAwayScore']) && $event['intAwayScore'] > ($event['intHomeScore'] ?? -1) ? 'text-accent' : 'text-secondary' }}">{{ $event['intAwayScore'] ?? '-' }}</span>
                                                </div>
                                                <div class="flex-1 text-left truncate">
                                                    <a href="{{ route('scoreboard.team', $event['idAwayTeam'] ?? '0') }}"
                                                        class="font-medium text-sm text-secondary hover:text-accent transition-colors {{ isset($event['intAwayScore']) && $event['intAwayScore'] > ($event['intHomeScore'] ?? -1) ? 'font-bold' : '' }}">
                                                        {{ $event['strAwayTeam'] ?? 'Visitante' }}
                                                    </a>
                                                </div>
                                            </div>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                    </section>
                </div>

                <!-- COLUMN 3: Next Events (Right) -->
                <div class="space-y-8">
                    <section>
                        <h2 class="text-xl font-medium text-secondary mb-4 flex items-center gap-2">
                            <span class="w-2 h-2 rounded-full border border-tertiary-sat"></span>
                            Próximos Encuentros
                        </h2>

                        @if(empty($nextEvents))
                            <div
                                class="border border-dashed border-tertiary/50 rounded-xl p-8 text-center text-tertiary-sat">
                                <p>No existen calendarios futuros programados.</p>
                            </div>
                        @else
                            <div
                                class="bg-primary/60 border border-tertiary/40 rounded-2xl overflow-hidden backdrop-blur-sm">
                                <ul class="divide-y divide-tertiary/30 border-t-2 border-transparent">
                                    @foreach($nextEvents as $event)
                                        <li class="p-4 hover:bg-tertiary-desat/10 transition-colors flex flex-col gap-3">
                                            <!-- Date & Time -->
                                            <div
                                                class="flex justify-between items-center text-[11px] font-bold text-tertiary-sat uppercase tracking-wider">
                                                <span>{{ \Carbon\Carbon::parse($event['dateEvent'])->translatedFormat('d M Y') }}</span>
                                                <span
                                                    class="font-mono text-secondary opacity-70 bg-tertiary-desat/50 px-1.5 py-0.5 rounded">
                                                    {{ formatTime($event['strTime']) }}
                                                </span>
                                            </div>

                                            <!-- Matchup Row -->
                                            <div class="flex items-center justify-between gap-2">
                                                <div class="flex-1 text-right truncate">
                                                    <a href="{{ route('scoreboard.team', $event['idHomeTeam'] ?? '0') }}"
                                                        class="font-medium text-sm text-secondary hover:text-accent transition-colors">
                                                        {{ $event['strHomeTeam'] ?? 'Local' }}
                                                    </a>
                                                </div>
                                                <div
                                                    class="text-[10px] font-black tracking-widest text-tertiary-sat opacity-40 px-1 uppercase">
                                                    VS</div>
                                                <div class="flex-1 text-left truncate">
                                                    <a href="{{ route('scoreboard.team', $event['idAwayTeam'] ?? '0') }}"
                                                        class="font-medium text-sm text-secondary hover:text-accent transition-colors">
                                                        {{ $event['strAwayTeam'] ?? 'Visitante' }}
                                                    </a>
                                                </div>
                                            </div>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                    </section>

                </div>

            </div>
        </div>
    </div>
</x-app-layout>
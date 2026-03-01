<x-app-layout>
    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <!-- Breadcrumbs / Back button -->
            <div class="mb-6 px-4 sm:px-0">
                <a href="{{ route('scoreboard.index') }}"
                    class="inline-flex items-center text-sm font-medium text-indigo-600 hover:text-indigo-800 transition-colors">
                    <svg class="mr-2 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                        xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    Volver a Marcadores
                </a>
            </div>

            <!-- Team Header Profile -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-2xl mb-8 relative border border-gray-100">
                <!-- Cover Banner (if available) -->
                @if(!empty($team['strEquipment']))
                    <div class="h-32 sm:h-48 w-full bg-cover bg-center"
                        style="background-image: url('{{ $team['strEquipment'] }}');"></div>
                @else
                    <div class="h-32 sm:h-48 w-full bg-gradient-to-r from-indigo-500 to-purple-600"></div>
                @endif

                <div class="px-4 sm:px-8 pb-8 pt-4 sm:pt-6 relative">
                    <!-- Badge overlapping the banner -->
                    <div
                        class="absolute -top-16 sm:-top-20 left-4 sm:left-8 w-24 h-24 sm:w-32 sm:h-32 bg-white rounded-full p-2 shadow-lg border-4 border-white flex items-center justify-center">
                        @if(!empty($team['strBadge']))
                            <img src="{{ $team['strBadge'] }}" alt="{{ $team['strTeam'] }} badge"
                                class="w-full h-full object-contain">
                        @else
                            <span class="text-3xl">🛡️</span>
                        @endif
                    </div>

                    <div class="mt-12 sm:mt-14 sm:flex sm:items-end sm:justify-between">
                        <div>
                            <h1 class="text-3xl font-extrabold text-gray-900 tracking-tight">{{ $team['strTeam'] }}</h1>
                            <p class="text-gray-500 mt-1 flex items-center">
                                <span class="font-medium text-gray-700 mr-2">{{ $team['strAlternate'] ?? '' }}</span>
                                @if(!empty($team['intFormedYear']))
                                    <span
                                        class="inline-flex items-center rounded-md bg-gray-50 px-2 py-1 text-xs font-medium text-gray-600 ring-1 ring-inset ring-gray-500/10">Fundado
                                        en {{ $team['intFormedYear'] }}</span>
                                @endif
                            </p>
                        </div>

                        <!-- Extra Stats/Location -->
                        <div class="mt-4 sm:mt-0 flex flex-wrap gap-4 text-sm text-gray-600">
                            @if(!empty($team['strStadium']))
                                <div class="flex items-center">
                                    <svg class="w-4 h-4 mr-1 text-indigo-500" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4">
                                        </path>
                                    </svg>
                                    Estadio: {{ $team['strStadium'] }}
                                </div>
                            @endif
                            @if(!empty($team['strCountry']))
                                <div class="flex items-center">
                                    <svg class="w-4 h-4 mr-1 text-indigo-500" fill="none" stroke="currentColor"
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
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 px-4 sm:px-0">

                <!-- Main Content / Biography -->
                <div class="lg:col-span-2">
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 sm:p-8">
                        <h2 class="text-xl font-bold text-gray-900 mb-4 flex items-center">
                            <svg class="w-5 h-5 text-indigo-500 mr-2" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            Sobre {{ $team['strTeam'] }}
                        </h2>
                        <div class="prose prose-sm sm:prose-base text-gray-600 max-w-none">
                            @if(!empty($team['strDescriptionES']))
                                <p class="whitespace-pre-line">{{ $team['strDescriptionES'] }}</p>
                            @elseif(!empty($team['strDescriptionEN']))
                                <p class="whitespace-pre-line">{{ $team['strDescriptionEN'] }}</p>
                            @else
                                <p class="italic">No hay biografía disponible para este equipo.</p>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Sidebar / Last Events -->
                <div class="lg:col-span-1">
                    <h2 class="text-xl font-bold text-gray-900 mb-4 flex items-center">
                        <svg class="w-5 h-5 text-gray-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        Últimos Enfrentamientos
                    </h2>

                    @if(empty($lastEvents))
                        <div class="bg-gray-50 rounded-xl p-6 text-center text-gray-500 border border-gray-100">
                            No hay registro de partidos recientes para este equipo.
                        </div>
                    @else
                        <div class="space-y-4">
                            @foreach($lastEvents as $event)
                                <div
                                    class="bg-white rounded-xl shadow-sm border border-gray-100 p-4 hover:shadow-md transition-shadow">
                                    <div class="text-xs text-gray-400 mb-2 flex justify-between">
                                        <span>{{ \Carbon\Carbon::parse($event['dateEvent'])->format('d M Y') }}</span>
                                        <span class="font-medium">{{ $event['strLeague'] ?? '' }}</span>
                                    </div>

                                    <div class="flex items-center justify-between mb-2">
                                        <!-- Home Team -->
                                        <div
                                            class="text-sm font-semibold truncate flex-1 text-right {{ $event['idHomeTeam'] === $team['idTeam'] ? 'text-indigo-600' : 'text-gray-700' }}">
                                            {{ $event['strHomeTeam'] }}
                                        </div>

                                        <!-- Score -->
                                        <div class="px-3 font-mono text-base font-bold text-gray-900 bg-gray-50 rounded mx-2">
                                            {{ $event['intHomeScore'] ?? '-' }} <span class="text-gray-300 font-normal">:</span>
                                            {{ $event['intAwayScore'] ?? '-' }}
                                        </div>

                                        <!-- Away Team -->
                                        <div
                                            class="text-sm font-semibold truncate flex-1 text-left {{ $event['idAwayTeam'] === $team['idTeam'] ? 'text-indigo-600' : 'text-gray-700' }}">
                                            {{ $event['strAwayTeam'] }}
                                        </div>
                                    </div>

                                    @if($event['strVideo'])
                                        <div class="mt-2 text-center">
                                            <a href="{{ $event['strVideo'] }}" target="_blank"
                                                class="inline-flex items-center text-xs font-medium text-red-600 hover:text-red-800">
                                                <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 24 24">
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
<x-app-layout>
    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <!-- Page Header -->
            <div class="mb-6 px-4 sm:px-0">
                <h1 class="text-3xl font-extrabold text-gray-900 tracking-tight">Centro de Trivia</h1>
                <p class="mt-1 text-sm text-gray-500">Demuestra cuánto sabes sobre el mundo y sus selecciones.</p>
            </div>

            <!-- Global Challenge (Main Card) -->
            <div
                class="bg-gradient-to-r from-blue-600 to-indigo-700 rounded-2xl shadow-xl overflow-hidden mb-8 mx-4 sm:mx-0 transform transition-transform hover:scale-[1.01] cursor-pointer">
                <a href="{{ route('trivia.play', 'world') }}" class="block p-6 sm:p-10 relative">
                    <!-- Background Pattern / Decoration -->
                    <div
                        class="absolute inset-0 opacity-10 bg-[url('data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMjAiIGhlaWdodD0iMjAiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyI+PGNpcmNsZSBjeD0iMiIgY3k9IjIiIHI9IjIiIGZpbGw9IiNmZmYiLz48L3N2Zz4=')]">
                    </div>

                    <div class="relative z-10 flex flex-col sm:flex-row items-center justify-between gap-6">
                        <div class="text-center sm:text-left">
                            <span
                                class="inline-flex items-center gap-1.5 py-1.5 px-3 rounded-full text-xs font-semibold bg-blue-100 text-blue-800 mb-3 shadow-sm">
                                <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                                </svg>
                                Jugabilidad Infinita
                            </span>
                            <h2 class="text-3xl sm:text-4xl font-extrabold text-white mb-2 drop-shadow-md">Desafío
                                Mundial</h2>
                            <p class="text-blue-100 text-sm sm:text-base max-w-xl mx-auto sm:mx-0">
                                Enfréntate a preguntas aleatorias sobre capitales, continentes, idiomas y monedas de
                                cualquier rincón del planeta. ¿Podrás ganar la insignia dorada?
                            </p>
                        </div>

                        <div class="flex-shrink-0 relative">
                            <div
                                class="w-24 h-24 sm:w-32 sm:h-32 bg-white/20 rounded-full flex items-center justify-center backdrop-blur-sm border-2 border-white/30 shadow-2xl">
                                <span class="text-5xl sm:text-6xl drop-shadow-lg filter">🌍</span>
                            </div>
                        </div>
                    </div>
                </a>
            </div>

            <!-- Country Grid Section -->
            <div class="px-4 sm:px-0">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-bold text-gray-800">Trivias por País</h3>
                    <span
                        class="text-xs font-medium text-gray-500 bg-gray-100 px-2 py-1 rounded-full border border-gray-200">En
                        Base de Datos</span>
                </div>

                @if($countries->isEmpty())
                    <div class="bg-white border-2 border-dashed border-gray-300 rounded-xl p-8 text-center text-gray-500">
                        <svg class="mx-auto h-12 w-12 text-gray-400 mb-3" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 002-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10">
                            </path>
                        </svg>
                        <p class="font-medium text-gray-900">No hay países disponibles</p>
                        <p class="text-sm">Aún no se han configurado preguntas para selecciones específicas.</p>
                    </div>
                @else
                    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 sm:gap-6">
                        @foreach($countries as $country)
                            <x-country-card :href="route('trivia.play', $country->id)" :country="$country">
                                <svg class="w-3.5 h-3.5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
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
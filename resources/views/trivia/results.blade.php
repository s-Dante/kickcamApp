<x-app-layout>
    <div class="py-10 bg-gray-50 min-h-screen flex flex-col">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 w-full space-y-6">

            <!-- Title & Global Result Status -->
            <div class="bg-gradient-to-r from-indigo-600 to-purple-600 rounded-2xl shadow-xl overflow-hidden text-center text-white relative">
                
                <div class="absolute inset-0 opacity-20 bg-[url('data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMjAiIGhlaWdodD0iMjAiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyI+PGNpcmNsZSBjeD0iMiIgY3k9IjIiIHI9IjIiIGZpbGw9IiNmZmYiLz48L3N2Zz4=')]"></div>
                
                <div class="relative z-10 p-8 sm:p-12">
                    <h2 class="text-sm uppercase font-bold tracking-widest text-indigo-200 mb-2">Desempeño</h2>
                    
                    <div class="flex items-center justify-center mb-6">
                        <div class="w-24 h-24 sm:w-32 sm:h-32 bg-white/20 rounded-full flex flex-col items-center justify-center backdrop-blur-sm border-4 border-white">
                            <span class="text-4xl sm:text-5xl font-extrabold">{{ session('score') }}</span>
                            <span class="text-xs font-bold text-indigo-100 uppercase tracking-wider">de {{ session('totalQuestions') }}</span>
                        </div>
                    </div>
                    
                    <h1 class="text-2xl sm:text-3xl font-extrabold mb-4">{{ session('status') }}</h1>
                    
                    <div class="flex items-center justify-center gap-4 text-sm font-semibold mt-4">
                        <div class="bg-indigo-800/50 px-4 py-2 rounded-lg flex items-center">
                            <span class="mr-2 text-xl">⭐️</span>
                            <span>+{{ session('totalEarnedPoints') }} pt</span>
                        </div>
                    </div>

                    @if(session('awardedItems') && count(session('awardedItems')) > 0)
                        <div class="mt-6">
                            <p class="text-xs text-indigo-200 uppercase tracking-widest font-bold mb-2">Nuevos Desbloqueos en Dashboard</p>
                            <div class="flex flex-wrap justify-center gap-2">
                                @foreach(session('awardedItems') as $item)
                                    <span class="bg-orange-500 text-white text-xs font-bold px-3 py-1.5 rounded-full shadow-lg border border-orange-400">
                                        {{ $item }}
                                    </span>
                                @endforeach
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Detailed Results Feed -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 overflow-hidden">
                <h3 class="text-xl font-bold text-gray-800 mb-6 border-b pb-4">Detalle de Respuestas</h3>
                
                <div class="space-y-6">
                    @if(session('detailedResults'))
                        @foreach(session('detailedResults') as $index => $res)
                            <div class="bg-gray-50 rounded-xl p-5 border border-gray-200 {{ $res['is_correct'] ? 'border-l-4 border-l-green-500' : 'border-l-4 border-l-red-500' }}">
                                <h4 class="font-bold text-gray-800 text-lg mb-3">
                                    <span class="text-gray-400 text-sm font-normal mr-2">Q{{ $index + 1 }}.</span>
                                    {{ $res['question'] }}
                                </h4>
                                
                                <div class="space-y-2">
                                    <div class="flex items-center text-sm font-medium">
                                        <span class="w-24 text-gray-500">Tu respuesta:</span>
                                        <span class="flex items-center px-3 py-1 rounded-md {{ $res['is_correct'] ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                            @if($res['is_correct'])
                                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                            @else
                                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                            @endif
                                            {{ $res['user_answer'] }}
                                        </span>
                                    </div>
                                    
                                    @if(!$res['is_correct'])
                                        <div class="flex items-center text-sm font-medium">
                                            <span class="w-24 text-gray-500">Correcta:</span>
                                            <span class="flex items-center px-3 py-1 bg-green-50/50 text-green-700 rounded-md border border-green-200">
                                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                                {{ $res['correct_answer'] }}
                                            </span>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    @endif
                </div>

                <!-- Action Button -->
                <div class="mt-8 pt-6 border-t border-gray-100 flex justify-center">
                    <a href="{{ route('trivia.index') }}" class="w-full sm:w-auto text-center bg-gray-900 text-white font-bold py-3 px-10 rounded-xl hover:bg-gray-800 transition-colors shadow-lg shadow-gray-200">
                        Volver al Catálogo ➔
                    </a>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>

<x-app-layout>
    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <!-- Perfil Encabezado -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6 text-gray-900 flex flex-col sm:flex-row items-center gap-6">
                    <!-- Avatar Genérico -->
                    <div class="relative w-24 h-24 rounded-full bg-gray-200 border-4 border-indigo-100 flex items-center justify-center overflow-hidden shrink-0 shadow-inner">
                        <svg class="w-16 h-16 text-gray-400" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M24 20.993V24H0v-2.996A14.977 14.977 0 0112.004 15c4.904 0 9.26 2.354 11.996 5.993zM16.002 8.999a4 4 0 11-8 0 4 4 0 018 0z" />
                        </svg>
                    </div>

                    <!-- Info Usuario -->
                    <div class="text-center sm:text-left flex-1">
                        <h2 class="text-2xl font-bold text-gray-800">{{ auth()->user()->name }}</h2>
                        <p class="text-gray-500 font-medium pb-2">@ {{ auth()->user()->username ?? 'usuario_invitado' }}</p>
                        
                        <!-- Mini Stats Bar -->
                        <div class="flex flex-wrap items-center justify-center sm:justify-start gap-4 mt-2">
                            <div class="bg-indigo-50 text-indigo-700 px-3 py-1 rounded-full text-sm font-bold flex items-center shadow-sm">
                                <svg class="w-4 h-4 mr-1 pb-[1px]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                                {{ number_format(auth()->user()->points ?? 0) }} Puntos
                            </div>
                            <!-- Agregaremos aquí Nivel si se requiere luego -->
                        </div>
                    </div>

                    <!-- Edición Desktop -->
                    <div class="hidden sm:block">
                        <a href="{{ route('profile.edit') }}" class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 disabled:opacity-25 transition ease-in-out duration-150">
                            Editar Perfil
                        </a>
                    </div>
                </div>
            </div>

            <!-- Insignias Coleccionables (Badges) -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <div class="flex items-center justify-between border-b pb-4 mb-4">
                        <h3 class="text-lg font-bold text-gray-800 flex items-center">
                            <svg class="w-5 h-5 mr-2 text-yellow-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M11.3 1.046A1 1 0 0112 2v5h4a1 1 0 01.82 1.573l-7 10A1 1 0 018 18v-5H4a1 1 0 01-.82-1.573l7-10a1 1 0 011.12-.38z" clip-rule="evenodd"></path></svg>
                            Colección de Insignias
                        </h3>
                        <span class="text-xs font-semibold text-gray-500 bg-gray-100 px-2 py-1 rounded-full">Proximamente</span>
                    </div>
                    
                    <div class="grid grid-cols-2 xs:grid-cols-3 sm:grid-cols-4 md:grid-cols-5 gap-4">
                        <!-- Insignia Ejemplo: Desbloqueada -->
                        <div class="flex flex-col items-center p-3 rounded-xl bg-gray-50 border border-gray-100 shadow-sm transition-transform hover:scale-105 cursor-pointer">
                            <div class="w-16 h-16 rounded-full bg-indigo-100 flex items-center justify-center mb-2 shadow-inner border border-indigo-200">
                                🏆
                            </div>
                            <span class="text-xs font-bold text-gray-800 text-center leading-tight">Primer Paso</span>
                            <span class="text-[10px] text-gray-500 mt-1">100 pts</span>
                        </div>

                        <!-- Insignia Ejemplo: Bloqueada (Silueta) -->
                        <div class="flex flex-col items-center p-3 rounded-xl bg-gray-50/50 border border-transparent">
                            <div class="w-16 h-16 rounded-full bg-gray-200 flex items-center justify-center mb-2 grayscale opacity-50 relative overflow-hidden">
                                <span class="text-2xl filter drop-shadow opacity-50">🌍</span>
                                <!-- Diagonal Slash -->
                                <div class="absolute inset-0 flex items-center justify-center">
                                    <svg class="w-8 h-8 text-gray-400 opacity-60" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                                </div>
                            </div>
                            <span class="text-xs font-semibold text-gray-400 text-center leading-tight">Mundo Oculto</span>
                        </div>

                        <!-- Insignia Ejemplo: Bloqueada (Silueta) -->
                        <div class="flex flex-col items-center p-3 rounded-xl bg-gray-50/50 border border-transparent">
                            <div class="w-16 h-16 rounded-full bg-gray-200 flex items-center justify-center mb-2 grayscale opacity-40">
                                <span class="text-2xl filter drop-shadow opacity-60">⚽️</span>
                            </div>
                            <span class="text-xs font-semibold text-gray-400 text-center leading-tight">? ? ?</span>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>

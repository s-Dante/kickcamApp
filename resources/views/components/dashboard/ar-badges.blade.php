<div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
    <div class="p-6">
        <div class="flex items-center justify-between border-b pb-4 mb-4">
            <h3 class="text-lg font-bold text-gray-800 flex items-center">
                <span class="text-2xl mr-2">🌍</span>
                Colección Mundial (AR)
            </h3>
            <span
                class="text-xs font-semibold text-gray-500 bg-gray-100 px-2 py-1 rounded-full border border-gray-200">Deportes
                Oficiales</span>
        </div>

        <div class="grid grid-cols-2 xs:grid-cols-3 sm:grid-cols-4 md:grid-cols-5 gap-4">
            <!-- Colección: Banderas (Flags) -->
            <div onclick="openBadgeModal('flag')"
                class="flex flex-col items-center p-3 rounded-xl bg-indigo-50 border border-indigo-100 shadow-sm transition-transform hover:scale-105 cursor-pointer">
                <div
                    class="w-16 h-16 rounded-full bg-indigo-200 flex items-center justify-center mb-2 shadow-inner border border-indigo-300">
                    <span class="text-3xl drop-shadow-sm">🏳️</span>
                </div>
                <span
                    class="text-xs font-bold text-indigo-900 text-center leading-tight uppercase tracking-wider">Flags</span>
                <span class="text-[10px] text-indigo-500 font-semibold mt-1">Ver Álbum</span>
            </div>

            <!-- Colección: Escudos (Shields) -->
            <div onclick="openBadgeModal('shield')"
                class="flex flex-col items-center p-3 rounded-xl bg-indigo-50 border border-indigo-100 shadow-sm transition-transform hover:scale-105 cursor-pointer">
                <div
                    class="w-16 h-16 rounded-full bg-indigo-200 flex items-center justify-center mb-2 shadow-inner border border-indigo-300">
                    <span class="text-3xl drop-shadow-sm">🛡️</span>
                </div>
                <span
                    class="text-xs font-bold text-indigo-900 text-center leading-tight uppercase tracking-wider">Shields</span>
                <span class="text-[10px] text-indigo-500 font-semibold mt-1">Ver Álbum</span>
            </div>

            <!-- Colección: Balones (Balls) -->
            <div onclick="openBadgeModal('ball')"
                class="flex flex-col items-center p-3 rounded-xl bg-indigo-50 border border-indigo-100 shadow-sm transition-transform hover:scale-105 cursor-pointer">
                <div
                    class="w-16 h-16 rounded-full bg-indigo-200 flex items-center justify-center mb-2 shadow-inner border border-indigo-300">
                    <span class="text-3xl drop-shadow-sm">⚽️</span>
                </div>
                <span
                    class="text-xs font-bold text-indigo-900 text-center leading-tight uppercase tracking-wider">Balls</span>
                <span class="text-[10px] text-indigo-500 font-semibold mt-1">Ver Álbum</span>
            </div>

            <!-- Colección: Logo FIFA -->
            <div onclick="openBadgeModal('fifa_logo')"
                class="flex flex-col items-center p-3 rounded-xl bg-indigo-50 border border-indigo-100 shadow-sm transition-transform hover:scale-105 cursor-pointer">
                <div
                    class="w-16 h-16 rounded-full bg-indigo-200 flex items-center justify-center mb-2 shadow-inner border border-indigo-300">
                    <span class="text-3xl drop-shadow-sm">🏆</span>
                </div>
                <span class="text-xs font-bold text-indigo-900 text-center leading-tight uppercase tracking-wider">FIFA
                    Logo</span>
                <span class="text-[10px] text-indigo-500 font-semibold mt-1">Ver Álbum</span>
            </div>

            <!-- Colección: Posters -->
            <div onclick="openBadgeModal('poster')"
                class="flex flex-col items-center p-3 rounded-xl bg-indigo-50 border border-indigo-100 shadow-sm transition-transform hover:scale-105 cursor-pointer">
                <div
                    class="w-16 h-16 rounded-full bg-indigo-200 flex items-center justify-center mb-2 shadow-inner border border-indigo-300">
                    <span class="text-3xl drop-shadow-sm">🖼️</span>
                </div>
                <span
                    class="text-xs font-bold text-indigo-900 text-center leading-tight uppercase tracking-wider">Posters</span>
                <span class="text-[10px] text-indigo-500 font-semibold mt-1">Ver Álbum</span>
            </div>
        </div>
    </div>
</div>
<x-app-layout>
    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <!-- Perfil Encabezado -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6 text-gray-900 flex flex-col sm:flex-row items-center gap-6">
                    <!-- Avatar Genérico / 3D Placeholder -->
                    <div
                        class="relative w-24 h-24 sm:w-32 sm:h-32 rounded-2xl bg-gray-900 border-4 border-indigo-500 overflow-hidden shrink-0 shadow-lg group">
                        <div
                            class="absolute inset-0 bg-gradient-to-br from-indigo-500/20 to-purple-500/20 pointer-events-none">
                        </div>
                        <!-- Placeholder Grid 3D -->
                        <div
                            class="absolute inset-0 bg-[url('data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMjAiIGhlaWdodD0iMjAiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyI+PHBhdGggZD0iTTEgMWgyMHYyMEgxVjF6IiBmaWxsPSJub25lIiBzdHJva2U9IiMzMzMiIHN0cm9rZS13aWR0aD0iMSIgb3BhY2l0eT0iLjIiLz48L3N2Zz4=')]">
                        </div>

                        <div
                            class="w-full h-full flex flex-col items-center justify-center opacity-80 group-hover:opacity-100 transition-opacity">
                            <svg class="w-8 h-8 text-indigo-300 mb-1" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M14 10l-2 1m0 0l-2-1m2 1v2.5M20 7l-2 1m2-1l-2-1m2 1v2.5M14 4l-2-1-2 1M4 7l2-1M4 7l2 1M4 7v2.5M12 21l-2-1m2 1l2-1m-2 1v-2.5M6 18l-2-1v-2.5M18 18l2-1v-2.5">
                                </path>
                            </svg>
                            <span
                                class="text-[9px] font-bold text-indigo-200 tracking-wider text-center leading-tight">CANVAS<br>3D</span>
                        </div>
                    </div>

                    <!-- Info Usuario -->
                    <div class="text-center sm:text-left flex-1">
                        <h2 class="text-2xl font-bold text-gray-800">{{ auth()->user()->name }}</h2>
                        <p class="text-gray-500 font-medium pb-2">@ {{ auth()->user()->username ?? 'usuario_invitado' }}
                        </p>

                        <!-- Mini Stats Bar -->
                        <div class="flex flex-wrap items-center justify-center sm:justify-start gap-4 mt-2">
                            <div
                                class="bg-indigo-50 text-indigo-700 px-3 py-1 rounded-full text-sm font-bold flex items-center shadow-sm">
                                <svg class="w-4 h-4 mr-1 pb-[1px]" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                                </svg>
                                {{ number_format(auth()->user()->points ?? 0) }} Puntos
                            </div>
                            <!-- Agregaremos aquí Nivel si se requiere luego -->
                        </div>
                    </div>

                    <!-- Edición Desktop -->
                    <div class="hidden sm:block">
                        <a href="{{ route('profile.edit') }}"
                            class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 disabled:opacity-25 transition ease-in-out duration-150">
                            Editar Perfil
                        </a>
                    </div>
                </div>
            </div>

            <!-- Logros Generales (Misiones de la App) -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <div class="flex items-center justify-between border-b pb-4 mb-4">
                        <h3 class="text-lg font-bold text-gray-800 flex items-center">
                            <span class="text-2xl mr-2">🎯</span>
                            Logros Generales
                        </h3>
                    </div>

                    <div class="grid grid-cols-2 xs:grid-cols-3 sm:grid-cols-4 md:grid-cols-5 gap-4">
                        @foreach($generalBadges as $badge)
                            @php
                                $isUnlocked = in_array($badge->id, $userUnlockedIds);
                            @endphp

                            @if($isUnlocked)
                                <!-- Logro Desbloqueado -->
                                <div class="flex flex-col items-center p-3 rounded-xl bg-orange-50 border border-orange-100 shadow-sm transition-transform hover:scale-105 cursor-pointer"
                                    title="{{ $badge->description }}">
                                    <div
                                        class="w-14 h-14 rounded-full bg-orange-200 flex items-center justify-center mb-2 shadow-inner border border-orange-300 overflow-hidden">
                                        <img src="{{ $badge->image_url }}" alt="{{ $badge->title }}"
                                            class="w-10 h-10 object-contain drop-shadow-md">
                                    </div>
                                    <span
                                        class="text-xs font-bold text-orange-900 text-center leading-tight">{{ $badge->title }}</span>
                                </div>
                            @else
                                <!-- Logro Bloqueado -->
                                <div class="flex flex-col items-center p-3 rounded-xl bg-gray-50/50 border border-transparent"
                                    title="{{ $badge->description }}">
                                    <div
                                        class="w-14 h-14 rounded-full bg-gray-200 flex items-center justify-center mb-2 grayscale opacity-50 relative overflow-hidden">
                                        <img src="{{ $badge->image_url }}" alt="?"
                                            class="w-8 h-8 object-contain filter drop-shadow opacity-50">
                                        <!-- Diagonal Slash -->
                                        <div class="absolute inset-0 flex items-center justify-center">
                                            <svg class="w-8 h-8 text-gray-500 opacity-60" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z">
                                                </path>
                                            </svg>
                                        </div>
                                    </div>
                                    <span class="text-xs font-semibold text-gray-400 text-center leading-tight">Misterio</span>
                                </div>
                            @endif
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Insignias de Colección Mundial (AR) -->
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
                            <span
                                class="text-xs font-bold text-indigo-900 text-center leading-tight uppercase tracking-wider">FIFA
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

        </div>
    </div>

    <!-- Vanilla JS Modals Logic and Architecture -->
    <div id="badgeModalOverlay"
        class="fixed inset-0 z-50 flex items-center justify-center bg-gray-900 bg-opacity-75 backdrop-blur-sm opacity-0 pointer-events-none transition-opacity duration-300">
        <div class="bg-white rounded-2xl shadow-xl w-11/12 max-w-4xl max-h-[85vh] flex flex-col transform scale-95 transition-transform duration-300"
            id="badgeModalContent">

            <!-- Modal Header -->
            <div class="flex items-center justify-between p-5 border-b border-gray-100">
                <h3 class="text-xl font-bold text-gray-800 flex items-center capitalize" id="modalTitle">
                    <span class="mr-2" id="modalIcon">🌍</span> <span id="modalCategoryText">Colección</span>
                </h3>
                <button onclick="closeBadgeModal()"
                    class="text-gray-400 hover:text-gray-600 transition-colors bg-gray-100 hover:bg-gray-200 rounded-full p-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12">
                        </path>
                    </svg>
                </button>
            </div>

            <!-- Modal Body (Grid Scrollable) -->
            <div class="p-6 overflow-y-auto">
                <div id="modalGrid"
                    class="grid grid-cols-2 xs:grid-cols-3 sm:grid-cols-4 md:grid-cols-5 lg:grid-cols-6 gap-4">
                    <!-- Badges injected dynamically by JS -->
                </div>
            </div>

            <!-- Modal Footer -->
            <div class="p-4 border-t border-gray-100 bg-gray-50 flex justify-between items-center rounded-b-2xl">
                <span class="text-sm font-semibold text-gray-500" id="modalProgressText">0 / 0 Desbloqueadas</span>
                <button onclick="closeBadgeModal()"
                    class="px-5 py-2 bg-indigo-600 text-white rounded-lg font-bold shadow-sm hover:bg-indigo-700 transition-colors">Cerrar
                    Álbum</button>
            </div>
        </div>
    </div>

    <!-- Inject PHP Payload to JS -->
    <script>
        const soccerCategoriesPayload = @json($soccerCategories);
        const userUnlockedPayload = @json($userUnlockedIds);

        const modalOverlay = document.getElementById('badgeModalOverlay');
        const modalContent = document.getElementById('badgeModalContent');
        const modalGrid = document.getElementById('modalGrid');
        const modalTitleIcon = document.getElementById('modalIcon');
        const modalCategoryText = document.getElementById('modalCategoryText');
        const modalProgressText = document.getElementById('modalProgressText');

        const iconsMap = {
            'flag': '🏳️',
            'shield': '🛡️',
            'ball': '⚽️',
            'fifa_logo': '🏆',
            'poster': '🖼️'
        };

        function openBadgeModal(categoryType) {
            // Setup Headers
            modalTitleIcon.innerText = iconsMap[categoryType] || '🌍';
            modalCategoryText.innerText = `Álbum de ${categoryType}`;

            // Clean previous grid elements
            modalGrid.innerHTML = '';

            // Pull data
            const badgesRaw = soccerCategoriesPayload[categoryType] || [];

            // Re-map as Array if Laravel passed an Object because of plucked Keys
            const badges = Array.isArray(badgesRaw) ? badgesRaw : Object.values(badgesRaw);

            let unlockedCount = 0;

            // Render Nodes
            badges.forEach(badge => {
                const isUnlocked = userUnlockedPayload.includes(badge.id);

                if (isUnlocked) unlockedCount++;

                const template = isUnlocked ? `
                    <div class="flex flex-col items-center p-3 rounded-xl bg-orange-50 border border-orange-200 shadow-sm transition-transform hover:scale-105" title="${badge.description}">
                        <div class="w-16 h-16 rounded-full bg-white flex items-center justify-center p-1 mb-2 shadow-inner border-2 border-orange-400 overflow-hidden relative">
                            <div class="absolute inset-0 bg-gradient-to-tr from-yellow-200 to-transparent opacity-20"></div>
                            <img src="${badge.image_url}" alt="${badge.title}" class="w-full h-full object-contain relative z-10 drop-shadow-sm">
                        </div>
                        <span class="text-[10px] font-bold text-orange-900 text-center leading-tight line-clamp-2">${badge.title}</span>
                    </div>
                ` : `
                    <div class="flex flex-col items-center p-3 rounded-xl bg-gray-50/70 border border-transparent" title="Sigue jugando Trivia para desbloquearla">
                        <div class="w-16 h-16 rounded-full bg-gray-200 flex items-center justify-center p-2 mb-2 grayscale opacity-40 shadow-inner overflow-hidden">
                            <svg class="w-8 h-8 text-gray-500 opacity-30" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                        </div>
                        <span class="text-[10px] font-semibold text-gray-400 text-center leading-tight">Misterio</span>
                    </div>
                `;

                modalGrid.insertAdjacentHTML('beforeend', template);
            });

            // Update footer
            modalProgressText.innerText = `${unlockedCount} / ${badges.length} Desbloqueadas`;

            // Display Animations
            modalOverlay.classList.remove('opacity-0', 'pointer-events-none');
            modalContent.classList.remove('scale-95');
        }

        function closeBadgeModal() {
            modalOverlay.classList.add('opacity-0', 'pointer-events-none');
            modalContent.classList.add('scale-95');
        }

        // Close on escape key
        document.addEventListener('keydown', function (event) {
            if (event.key === "Escape") {
                closeBadgeModal();
            }
        });

        // Close on clicking outside overlay
        modalOverlay.addEventListener('click', function (event) {
            if (event.target === modalOverlay) {
                closeBadgeModal();
            }
        });
    </script>
</x-app-layout>
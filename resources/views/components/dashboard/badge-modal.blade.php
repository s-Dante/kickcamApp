@props(['soccerCategories', 'userUnlockedIds'])

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
        modalTitleIcon.innerText = iconsMap[categoryType] || '🌍';
        modalCategoryText.innerText = `Álbum de ${categoryType}`;
        modalGrid.innerHTML = '';

        const badgesRaw = soccerCategoriesPayload[categoryType] || [];
        const badges = Array.isArray(badgesRaw) ? badgesRaw : Object.values(badgesRaw);

        let unlockedCount = 0;

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

        modalProgressText.innerText = `${unlockedCount} / ${badges.length} Desbloqueadas`;
        modalOverlay.classList.remove('opacity-0', 'pointer-events-none');
        modalContent.classList.remove('scale-95');
    }

    function closeBadgeModal() {
        modalOverlay.classList.add('opacity-0', 'pointer-events-none');
        modalContent.classList.add('scale-95');
    }

    document.addEventListener('keydown', function (event) {
        if (event.key === "Escape") closeBadgeModal();
    });

    modalOverlay.addEventListener('click', function (event) {
        if (event.target === modalOverlay) closeBadgeModal();
    });
</script>
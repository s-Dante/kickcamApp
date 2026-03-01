@props(['soccerCategories', 'userUnlockedIds'])

<div id="badgeModalOverlay"
    class="{{ $ui['modal-backdrop'] }} opacity-0 pointer-events-none transition-opacity duration-300">
    <div class="{{ $ui['modal-content'] }} max-w-4xl max-h-[85vh] flex flex-col transform scale-95 transition-transform duration-300"
        id="badgeModalContent">

        <!-- Modal Header -->
        <div class="flex items-center justify-between p-5 border-b border-tertiary">
            <h3 class="{{ $ui['h2'] }} flex items-center capitalize" id="modalTitle">
                <span class="mr-2" id="modalIcon">🌍</span> <span id="modalCategoryText">Colección</span>
            </h3>
            <button onclick="closeBadgeModal()"
                class="{{ $ui['text-muted'] }} transition-colors hover:text-secondary bg-tertiary-desat hover:bg-tertiary rounded-full p-2">
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
        <div class="p-4 border-t border-tertiary bg-tertiary-desat/50 flex justify-between items-center rounded-b-2xl">
            <span class="text-sm font-semibold {{ $ui['text-muted'] }}" id="modalProgressText">0 / 0
                Desbloqueadas</span>
            <button onclick="closeBadgeModal()" class="{{ $ui['btn-primary'] }}">Cerrar
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
                <div class="flex flex-col items-center p-3 rounded-xl bg-accent-desat/30 border border-accent shadow-sm transition-transform hover:scale-105" title="${badge.description}">
                    <div class="w-16 h-16 rounded-full bg-primary flex items-center justify-center p-1 mb-2 shadow-inner border-2 border-accent-sat overflow-hidden relative">
                        <div class="absolute inset-0 bg-radial-1 opacity-20"></div>
                        <img src="${badge.image_url}" alt="${badge.title}" class="w-full h-full object-contain relative z-10 drop-shadow-sm">
                    </div>
                    <span class="text-[10px] font-bold text-secondary-sat text-center leading-tight line-clamp-2">${badge.title}</span>
                </div>
            ` : `
                <div class="flex flex-col items-center p-3 rounded-xl bg-tertiary-desat/20 border border-transparent" title="Sigue jugando Trivia para desbloquearla">
                    <div class="w-16 h-16 rounded-full bg-tertiary-desat flex items-center justify-center p-2 mb-2 grayscale opacity-40 shadow-inner overflow-hidden">
                        <svg class="w-8 h-8 text-tertiary-sat opacity-30" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                    </div>
                    <span class="text-[10px] font-semibold text-tertiary-sat text-center leading-tight">Misterio</span>
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
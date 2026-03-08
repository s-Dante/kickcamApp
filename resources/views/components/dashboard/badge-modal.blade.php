@props(['soccerCategories', 'userUnlockedIds'])

@php
    // Estructura de clases para limpiar el HTML
    $classes = [
        'overlay' => "{$ui['modal-backdrop']} opacity-0 pointer-events-none transition-opacity duration-300",
        'content' => "{$ui['modal-content']} w-[95vw] sm:w-[90vw] lg:max-w-7xl max-h-[85vh] flex flex-col transform scale-95 transition-transform duration-300",

        'header' => [
            'container' => 'flex items-center justify-between p-5 border-b border-tertiary',
            'title' => "{$ui['h2']} flex items-center capitalize",
            'closeBtn' => "{$ui['text-muted']} transition-colors hover:text-secondary bg-tertiary-desat hover:bg-tertiary rounded-full p-2",
            'icon' => 'w-5 h-5',
        ],

        'body' => [
            'container' => 'p-6 overflow-y-auto',
            'grid' => 'grid grid-cols-3 sm:grid-cols-4 md:grid-cols-5 lg:grid-cols-6 xl:grid-cols-8 gap-4',
        ],

        'footer' => [
            'container' => 'p-4 border-t border-tertiary bg-tertiary-desat/50 flex justify-between items-center rounded-b-2xl',
            'text' => "text-sm font-semibold {$ui['text-muted']}",
            'closeBtn' => $ui['btn-primary'],
        ]
    ];
@endphp

<div id="badgeModalOverlay" class="{{ $classes['overlay'] }}">
    <div class="{{ $classes['content'] }}" id="badgeModalContent">

        <!-- Modal Header -->
        <div class="{{ $classes['header']['container'] }}">
            <h3 class="{{ $classes['header']['title'] }}" id="modalTitle">
                <span class="mr-2" id="modalIcon">🌍</span> <span id="modalCategoryText">Colección</span>
            </h3>
            <button onclick="closeBadgeModal()" class="{{ $classes['header']['closeBtn'] }}">
                <svg class="{{ $classes['header']['icon'] }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12">
                    </path>
                </svg>
            </button>
        </div>

        <!-- Modal Body (Grid Scrollable) -->
        <div class="{{ $classes['body']['container'] }}">
            <div id="modalGrid" class="{{ $classes['body']['grid'] }}">
                <!-- Badges injected dynamically by JS -->
            </div>
        </div>

        <!-- Modal Footer -->
        <div class="{{ $classes['footer']['container'] }}">
            <span class="{{ $classes['footer']['text'] }}" id="modalProgressText">0 / 0 Desbloqueadas</span>
            <button onclick="closeBadgeModal()" class="{{ $classes['footer']['closeBtn'] }}">Cerrar Álbum</button>
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

    // Objeto JS para mantener las clases de los badges dinámicos limpias
    const badgeUI = {
        unlocked: {
            wrapper: "flex flex-col items-center p-3 rounded-xl bg-accent-desat/30 border border-accent shadow-sm transition-transform hover:scale-105",
            imgContainer: "w-20 h-20 rounded-2xl bg-primary flex items-center justify-center p-2 mb-3 shadow-inner border border-accent/40 relative",
            radialBg: "absolute inset-0 bg-radial-1 opacity-20 rounded-2xl",
            img: "w-full h-full object-contain relative z-10 drop-shadow-sm",
            title: "text-xs font-bold text-secondary-sat text-center leading-tight line-clamp-2"
        },
        locked: {
            wrapper: "flex flex-col items-center p-3 rounded-xl bg-tertiary-desat/20 border border-transparent",
            iconContainer: "w-20 h-20 rounded-2xl bg-tertiary-desat flex items-center justify-center p-2 mb-3 grayscale opacity-30 shadow-inner",
            icon: "w-8 h-8 text-tertiary-sat opacity-30",
            title: "text-xs font-semibold text-tertiary-sat text-center leading-tight"
        }
    };

    let iso2ToNameMap = {};
    fetch('/assets/country_state_city-data/countries.json')
        .then(res => res.json())
        .then(data => {
            if (Array.isArray(data)) {
                data.forEach(c => {
                    iso2ToNameMap[c.iso2] = c.translations?.es || c.name;
                });
            }
        }).catch(err => console.warn('Could not load country mappings for badge modal:', err));

    function formatBadgeTitle(title) {
        if (title && title.length === 2 && iso2ToNameMap[title.toUpperCase()]) {
            return iso2ToNameMap[title.toUpperCase()];
        }
        return title;
    }

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
                <div class="${badgeUI.unlocked.wrapper}" title="${badge.description}">
                    <div class="${badgeUI.unlocked.imgContainer}">
                        <div class="${badgeUI.unlocked.radialBg}"></div>
                        <img src="${badge.image_url}" alt="${formatBadgeTitle(badge.title)}" class="${badgeUI.unlocked.img}">
                    </div>
                    <span class="${badgeUI.unlocked.title}">${formatBadgeTitle(badge.title)}</span>
                </div>
            ` : `
                <div class="${badgeUI.locked.wrapper}" title="Sigue jugando Trivia para desbloquearla">
                    <div class="${badgeUI.locked.iconContainer}">
                        <svg class="${badgeUI.locked.icon}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                    </div>
                    <span class="${badgeUI.locked.title}">Misterio</span>
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
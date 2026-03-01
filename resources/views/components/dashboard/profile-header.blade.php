@php
    $classes = [
        'card' => "{$ui['card']} mb-6",
        'card_body' => "{$ui['card-body']} flex flex-col sm:flex-row items-center gap-6",
        'avatar' => [
            'container' => 'relative w-24 h-24 sm:w-32 sm:h-32 rounded-2xl bg-secondary-desat border-4 border-accent overflow-hidden shrink-0 shadow-lg group',
            'bg_linear' => 'absolute inset-0 bg-linear-1 opacity-20 pointer-events-none',
            'bg_pattern' => 'absolute inset-0 bg-[url(\'data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMjAiIGhlaWdodD0iMjAiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyI+PHBhdGggZD0iTTEgMWgyMHYyMEgxVjF6IiBmaWxsPSJub25lIiBzdHJva2U9IiMzMzMiIHN0cm9rZS13aWR0aD0iMSIgb3BhY2l0eT0iLjIiLz48L3N2Zz4=\')]',
            'content_wrapper' => 'w-full h-full flex flex-col items-center justify-center opacity-80 group-hover:opacity-100 transition-opacity',
            'icon' => 'w-8 h-8 text-accent-desat mb-1',
            'text' => 'text-[9px] font-bold text-accent-desat tracking-wider text-center leading-tight'
        ],
        'info' => [
            'container' => 'text-center sm:text-left flex-1',
            'name' => $ui['h1'],
            'username' => "{$ui['text-muted']} font-medium pb-2",
            'stats_wrapper' => 'flex flex-wrap items-center justify-center sm:justify-start gap-4 mt-2',
            'points_badge' => 'bg-accent-desat text-accent-sat dark:bg-accent-sat dark:text-accent-desat px-3 py-1 rounded-full text-sm font-bold flex items-center shadow-sm',
            'points_icon' => 'w-4 h-4 mr-1 pb-[1px]'
        ],
        'action' => [
            'container' => 'hidden sm:block',
            'btn' => $ui['btn-secondary']
        ]
    ];
@endphp

<!-- Perfil Encabezado -->
<div class="{{ $classes['card'] }}">
    <div class="{{ $classes['card_body'] }}">
        <!-- Avatar Genérico / 3D Placeholder -->
        <div class="{{ $classes['avatar']['container'] }}">
            <div class="{{ $classes['avatar']['bg_linear'] }}"></div>
            <!-- Placeholder Grid 3D -->
            <div class="{{ $classes['avatar']['bg_pattern'] }}"></div>

            <div class="{{ $classes['avatar']['content_wrapper'] }}">
                <svg class="{{ $classes['avatar']['icon'] }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M14 10l-2 1m0 0l-2-1m2 1v2.5M20 7l-2 1m2-1l-2-1m2 1v2.5M14 4l-2-1-2 1M4 7l2-1M4 7l2 1M4 7v2.5M12 21l-2-1m2 1l2-1m-2 1v-2.5M6 18l-2-1v-2.5M18 18l2-1v-2.5">
                    </path>
                </svg>
                <span class="{{ $classes['avatar']['text'] }}">CANVAS<br>3D</span>
            </div>
        </div>

        <!-- Info Usuario -->
        <div class="{{ $classes['info']['container'] }}">
            <h2 class="{{ $classes['info']['name'] }}">{{ auth()->user()->name }}</h2>
            <p class="{{ $classes['info']['username'] }}">@ {{ auth()->user()->username ?? 'usuario_invitado' }}</p>

            <!-- Mini Stats Bar -->
            <div class="{{ $classes['info']['stats_wrapper'] }}">
                <div class="{{ $classes['info']['points_badge'] }}">
                    <svg class="{{ $classes['info']['points_icon'] }}" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                    </svg>
                    {{ number_format(auth()->user()->points ?? 0) }} Puntos
                </div>
            </div>
        </div>

        <!-- Edición Desktop -->
        <div class="{{ $classes['action']['container'] }}">
            <a href="{{ route('profile.edit') }}" class="{{ $classes['action']['btn'] }}">
                Editar Perfil
            </a>
        </div>
    </div>
</div>
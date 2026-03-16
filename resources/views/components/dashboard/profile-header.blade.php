@php
    $classes = [
        'card' => "{$ui['card']} mb-8 relative overflow-hidden",
        'card_body' => "{$ui['card-body']} flex flex-row items-center gap-5 sm:gap-8 p-5 sm:p-6 relative z-10",
        'avatar' => [
            'container' => 'relative w-16 h-16 sm:w-24 sm:h-24 rounded-full bg-secondary-desat border-4 border-primary overflow-hidden shrink-0 shadow-md group ring-2 ring-accent/20',
            'bg_linear' => 'absolute inset-0 bg-linear-1 opacity-20 pointer-events-none',
            'bg_pattern' => 'absolute inset-0 bg-[url(\'data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMjAiIGhlaWdodD0iMjAiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyI+PHBhdGggZD0iTTEgMWgyMHYyMEgxVjF6IiBmaWxsPSJub25lIiBzdHJva2U9IiMzMzMiIHN0cm9rZS13aWR0aD0iMSIgb3BhY2l0eT0iLjIiLz48L3N2Zz4=\')]',
            'content_wrapper' => 'w-full h-full flex flex-col items-center justify-center opacity-80 group-hover:opacity-100 transition-opacity',
            'icon' => 'w-8 h-8 text-accent-desat',
        ],
        'info' => [
            'container' => 'text-left flex-1',
            'name' => "text-xl sm:text-3xl font-bold text-secondary leading-tight truncate",
            'username' => "text-xs sm:text-sm {$ui['text-muted']} font-medium pb-2",
            'stats_wrapper' => 'flex items-center justify-start gap-4 mt-1',
            'points_badge' => 'bg-accent/10 text-accent px-3 py-1 rounded-full text-xs sm:text-sm font-bold flex items-center shadow-sm border border-accent/20',
            'points_icon' => 'w-4 h-4 mr-1 pb-[1px]'
        ],
        'action' => [
            'container' => 'block',
            'btn' => "{$ui['btn-secondary']} px-4 py-2 text-sm rounded-full flex items-center gap-2"
        ],
        'bg_decor' => 'absolute -right-20 -top-20 w-64 h-64 bg-accent/5 rounded-full blur-3xl pointer-events-none'
    ];
@endphp

<!-- Perfil Encabezado Panorámico Estilizado -->
<div class="{{ $classes['card'] }}">
    <!-- Decoración de fondo -->
    <div class="{{ $classes['bg_decor'] }}"></div>

    <div class="{{ $classes['card_body'] }}">
        <!-- Avatar Compacto -->
        <div class="{{ $classes['avatar']['container'] }}">
            <div class="{{ $classes['avatar']['bg_linear'] }}"></div>
            <!-- Placeholder Grid 3D -->
            <div class="{{ $classes['avatar']['bg_pattern'] }}"></div>

            <div class="{{ $classes['avatar']['content_wrapper'] }}">
                <svg class="{{ $classes['avatar']['icon'] }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z">
                    </path>
                </svg>
            </div>
        </div>

        <!-- Info Usuario -->
        <div class="{{ $classes['info']['container'] }}">
            <h2 class="{{ $classes['info']['name'] }}">{{ auth()->user()->name }}</h2>
            <p class="{{ $classes['info']['username'] }}">{{ '@' . (auth()->user()->username ?? 'usuario_invitado') }}
            </p>

            <!-- Mini Stats Bar -->
            <div class="{{ $classes['info']['stats_wrapper'] }}">
                <div class="{{ $classes['info']['points_badge'] }}">
                    <svg class="{{ $classes['info']['points_icon'] }}" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                    </svg>
                    {{ number_format(auth()->user()->points ?? 0) }} PTS
                </div>
            </div>
        </div>

        <!-- Edición Button Estilizado -->
        <div class="{{ $classes['action']['container'] }}">
        <x-tooltip text="Ajustes de cuenta" position="left">
            <a href="{{ route('profile.edit') }}" class="{{ $classes['action']['btn'] }}">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z">
                    </path>
                </svg>
                <span class="hidden sm:inline">Editar Perfil</span>
            </a>
        </x-tooltip>
        </div>
    </div>
</div>
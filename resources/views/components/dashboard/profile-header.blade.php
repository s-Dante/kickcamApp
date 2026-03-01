<!-- Perfil Encabezado -->
<div class="{{ $ui['card'] }} mb-6">
    <div class="{{ $ui['card-body'] }} flex flex-col sm:flex-row items-center gap-6">
        <!-- Avatar Genérico / 3D Placeholder -->
        <div
            class="relative w-24 h-24 sm:w-32 sm:h-32 rounded-2xl bg-secondary-desat border-4 border-accent overflow-hidden shrink-0 shadow-lg group">
            <div class="absolute inset-0 bg-linear-1 opacity-20 pointer-events-none">
            </div>
            <!-- Placeholder Grid 3D -->
            <div
                class="absolute inset-0 bg-[url('data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMjAiIGhlaWdodD0iMjAiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyI+PHBhdGggZD0iTTEgMWgyMHYyMEgxVjF6IiBmaWxsPSJub25lIiBzdHJva2U9IiMzMzMiIHN0cm9rZS13aWR0aD0iMSIgb3BhY2l0eT0iLjIiLz48L3N2Zz4=')]">
            </div>

            <div
                class="w-full h-full flex flex-col items-center justify-center opacity-80 group-hover:opacity-100 transition-opacity">
                <svg class="w-8 h-8 text-accent-desat mb-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M14 10l-2 1m0 0l-2-1m2 1v2.5M20 7l-2 1m2-1l-2-1m2 1v2.5M14 4l-2-1-2 1M4 7l2-1M4 7l2 1M4 7v2.5M12 21l-2-1m2 1l2-1m-2 1v-2.5M6 18l-2-1v-2.5M18 18l2-1v-2.5">
                    </path>
                </svg>
                <span
                    class="text-[9px] font-bold text-accent-desat tracking-wider text-center leading-tight">CANVAS<br>3D</span>
            </div>
        </div>

        <!-- Info Usuario -->
        <div class="text-center sm:text-left flex-1">
            <h2 class="{{ $ui['h1'] }}">{{ auth()->user()->name }}</h2>
            <p class="{{ $ui['text-muted'] }} font-medium pb-2">@ {{ auth()->user()->username ?? 'usuario_invitado' }}
            </p>

            <!-- Mini Stats Bar -->
            <div class="flex flex-wrap items-center justify-center sm:justify-start gap-4 mt-2">
                <div
                    class="bg-accent-desat text-accent-sat dark:bg-accent-sat dark:text-accent-desat px-3 py-1 rounded-full text-sm font-bold flex items-center shadow-sm">
                    <svg class="w-4 h-4 mr-1 pb-[1px]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                    </svg>
                    {{ number_format(auth()->user()->points ?? 0) }} Puntos
                </div>
            </div>
        </div>

        <!-- Edición Desktop -->
        <div class="hidden sm:block">
            <a href="{{ route('profile.edit') }}" class="{{ $ui['btn-secondary'] }}">
                Editar Perfil
            </a>
        </div>
    </div>
</div>
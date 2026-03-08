@php
    $classes = [
        'page_header_bg' => 'bg-primary border-b border-tertiary/40 pb-24 pt-12 relative overflow-hidden',
        'page_title' => "{$ui['h1']} text-3xl sm:text-4xl relative z-10",
        'page_desc' => "mt-2 text-sm sm:text-base {$ui['text-muted']} relative z-10",
        'decor' => 'absolute right-0 top-0 w-1/3 h-full bg-linear-1 opacity-10 pointer-events-none rounded-bl-full',
        'container' => 'py-12 -mt-24 relative z-20',
        'wrapper' => "{$ui['container']} max-w-7xl",
        'grid' => 'grid grid-cols-1 lg:grid-cols-12 gap-8',
        'col_left' => 'lg:col-span-7 space-y-8',
        'col_right' => 'lg:col-span-5 space-y-8',
        'card' => "{$ui['card']} p-6 sm:p-8 shadow-sm hover:shadow-md transition-shadow duration-300 backdrop-blur-sm bg-primary/95",
        'card_danger' => "{$ui['card']} p-6 sm:p-8 shadow-sm hover:shadow-md transition-shadow duration-300 backdrop-blur-sm bg-primary/95 border-red-500/20"
    ];
@endphp

<x-app-layout>
    <!-- Modern Hero Header -->
    <div class="{{ $classes['page_header_bg'] }}">
        <div class="{{ $classes['decor'] }}"></div>
        <div class="{{ $ui['container'] }} max-w-7xl">
            <h2 class="{{ $classes['page_title'] }}">
                {{ __('Ajustes de Perfil') }}
            </h2>
            <p class="{{ $classes['page_desc'] }}">
                Administra tu información personal, opciones de seguridad y preferencias de apariencia.
            </p>
        </div>
    </div>

    <!-- Main Content Area -->
    <div class="{{ $classes['container'] }}">
        <div class="{{ $classes['wrapper'] }}">

            <div class="{{ $classes['grid'] }}">
                <!-- Left Column: Core Info & Preferences -->
                <div class="{{ $classes['col_left'] }}">
                    <div class="{{ $classes['card'] }}">
                        @include('profile.partials.update-profile-information-form')
                    </div>

                    <div class="{{ $classes['card'] }}">
                        @include('profile.partials.update-theme-form')
                    </div>
                </div>

                <!-- Right Column: Security & Danger Zone -->
                <div class="{{ $classes['col_right'] }}">
                    <div class="{{ $classes['card'] }}">
                        @include('profile.partials.update-password-form')
                    </div>

                    <div class="{{ $classes['card_danger'] }}">
                        @include('profile.partials.delete-user-form')
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
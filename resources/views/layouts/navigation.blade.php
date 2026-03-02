@php
    $classes = [
        'nav' => $ui['nav-bar'],
        'desktop' => [
            'container' => $ui['container'],
            'inner' => 'flex justify-between h-16',
            'left' => 'flex items-center',
            'logo_wrapper' => 'shrink-0 flex items-center',
            'logo_link' => 'flex items-center gap-2',
            'logo_icon' => 'block h-8 w-12 fill-current text-secondary-sat',
            'logo_text' => 'text-secondary-sat font-bold text-xl tracking-tight',
            'links' => 'hidden sm:space-x-8 sm:ms-10 sm:flex',
            'link_text' => 'text-secondary-desat hover:text-secondary',
            'link_icon' => 'text-secondary-desat hover:text-accent',
            'icon_svg' => 'w-5 h-5 mr-1',
            'dropdown_wrapper' => 'hidden sm:flex sm:items-center sm:ms-6',
            'dropdown_btn' => 'inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-secondary-desat bg-primary hover:text-secondary hover:bg-tertiary-desat focus:outline-none transition ease-in-out duration-150',
            'hamburger_wrapper' => '-me-2 flex items-center sm:hidden',
            'hamburger_btn' => 'inline-flex items-center justify-center p-2 rounded-md text-tertiary-sat hover:text-secondary hover:bg-tertiary-desat focus:outline-none transition duration-150 ease-in-out'
        ],
        'mobile_menu' => [
            'container' => 'hidden sm:hidden bg-primary border-t border-tertiary border-b absolute w-full shadow-lg z-50',
            'inner' => 'pt-4 pb-1',
            'info_wrapper' => 'px-4',
            'info_name' => 'font-medium text-base text-secondary',
            'info_email' => 'font-medium text-sm text-secondary-desat',
            'links' => 'mt-3 space-y-1',
            'link_text' => 'text-secondary-desat',
            'link_danger' => 'text-red-500'
        ]
    ];
@endphp

<nav x-data="{ open: false }" class="{{ $classes['nav'] }}">
    <!-- Primary Navigation Menu (Desktop & Tablet) -->
    <div class="{{ $classes['desktop']['container'] }}">
        <div class="{{ $classes['desktop']['inner'] }}">
            <div class="{{ $classes['desktop']['left'] }}">
                <!-- Logo -->
                <div class="{{ $classes['desktop']['logo_wrapper'] }}">
                    <a href="{{ route('dashboard') }}" class="{{ $classes['desktop']['logo_link'] }}">
                        <x-application-logo class="{{ $classes['desktop']['logo_icon'] }}" />
                        <span class="{{ $classes['desktop']['logo_text'] }}">{{ config('app.name', 'KickCam') }}</span>
                    </a>
                </div>

                <!-- Navigation Links (Desktop) -->
                <div class="{{ $classes['desktop']['links'] }}">
                    <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')"
                        class="{{ $classes['desktop']['link_text'] }}">
                        Perfil
                    </x-nav-link>
                    <x-nav-link :href="route('trivia.index')" :active="request()->routeIs('trivia.*')"
                        class="{{ $classes['desktop']['link_text'] }}">
                        Trivia
                    </x-nav-link>
                    <x-nav-link :href="route('multimedia.index')" :active="request()->routeIs('multimedia.*')"
                        class="{{ $classes['desktop']['link_text'] }}">
                        Multimedia
                    </x-nav-link>
                    <x-nav-link :href="route('scoreboard.index')" :active="request()->routeIs('scoreboard.*')"
                        class="{{ $classes['desktop']['link_text'] }}">
                        Marcadores
                    </x-nav-link>
                    <x-nav-link :href="route('arCamera')" :active="request()->routeIs('arCamera')"
                        class="{{ $classes['desktop']['link_icon'] }}">
                        <svg class="{{ $classes['desktop']['icon_svg'] }}" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z">
                            </path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        </svg>
                        AR Camera
                    </x-nav-link>
                    <x-nav-link :href="route('camera')" :active="request()->routeIs('camera')"
                        class="{{ $classes['desktop']['link_icon'] }}">
                        <svg class="{{ $classes['desktop']['icon_svg'] }}" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z">
                            </path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        </svg>
                        Camera
                    </x-nav-link>
                </div>
            </div>

            <!-- Settings Dropdown (Desktop) -->
            <div class="{{ $classes['desktop']['dropdown_wrapper'] }}">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="{{ $classes['desktop']['dropdown_btn'] }}">
                            <div>{{ Auth::user()->username ?? Auth::user()->name }}</div>

                            <div class="ms-1">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg"
                                    viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                        clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <x-dropdown-link :href="route('profile.edit')">
                            {{ __('Profile Settings') }}
                        </x-dropdown-link>

                        <!-- Authentication -->
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf

                            <x-dropdown-link :href="route('logout')" onclick="event.preventDefault();
                                                this.closest('form').submit();">
                                {{ __('Log Out') }}
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>

            <!-- Hamburger Button (Mobile Header) -->
            <div class="{{ $classes['desktop']['hamburger_wrapper'] }}">
                <button @click="open = ! open" class="{{ $classes['desktop']['hamburger_btn'] }}">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex"
                            stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round"
                            stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Mobile Top Menu (Only for Settings / Logout) -->
    <div :class="{'block': open, 'hidden': ! open}" class="{{ $classes['mobile_menu']['container'] }}">
        <div class="{{ $classes['mobile_menu']['inner'] }}">
            <div class="{{ $classes['mobile_menu']['info_wrapper'] }}">
                <div class="{{ $classes['mobile_menu']['info_name'] }}">{{ Auth::user()->name }}</div>
                <div class="{{ $classes['mobile_menu']['info_email'] }}">{{ Auth::user()->email }}</div>
            </div>

            <div class="{{ $classes['mobile_menu']['links'] }}">
                <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')"
                    class="{{ $classes['mobile_menu']['link_text'] }}">
                    {{ __('Perfil') }}
                </x-responsive-nav-link>

                <x-responsive-nav-link :href="route('trivia.index')" :active="request()->routeIs('trivia.*')"
                    class="{{ $classes['mobile_menu']['link_text'] }}">
                    {{ __('Trivia') }}
                </x-responsive-nav-link>

                <x-responsive-nav-link :href="route('multimedia.index')" :active="request()->routeIs('multimedia.*')"
                    class="{{ $classes['mobile_menu']['link_text'] }}">
                    {{ __('Multimedia') }}
                </x-responsive-nav-link>

                <x-responsive-nav-link :href="route('scoreboard.index')" :active="request()->routeIs('scoreboard.*')"
                    class="{{ $classes['mobile_menu']['link_text'] }}">
                    {{ __('Marcadores') }}
                </x-responsive-nav-link>

                <x-responsive-nav-link :href="route('arCamera')" :active="request()->routeIs('arCamera')"
                    class="{{ $classes['mobile_menu']['link_text'] }}">
                    {{ __('Cámara AR') }}
                </x-responsive-nav-link>

                <x-responsive-nav-link :href="route('camera')" :active="request()->routeIs('camera')"
                    class="{{ $classes['mobile_menu']['link_text'] }}">
                    {{ __('Cámara') }}
                </x-responsive-nav-link>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <x-responsive-nav-link :href="route('logout')" class="{{ $classes['mobile_menu']['link_danger'] }}"
                        onclick="event.preventDefault(); this.closest('form').submit();">
                        {{ __('Salir') }}
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>
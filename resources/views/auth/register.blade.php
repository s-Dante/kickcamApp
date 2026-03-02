@php
    $classes = [
        'input_wrapper' => 'mt-4',
        'input' => 'block mt-1 w-full',
        'error' => 'mt-2',
        'actions' => 'flex items-center justify-between mt-4',
        'link' => 'underline text-sm text-secondary-desat hover:text-secondary rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-accent transition-colors',
        'divider_container' => 'mt-6',
        'divider_relative' => 'relative',
        'divider_line_container' => 'absolute inset-0 flex items-center',
        'divider_line' => 'w-full border-t border-tertiary',
        'divider_text_container' => 'relative flex justify-center text-sm',
        'divider_text' => 'px-2 bg-primary text-secondary-desat',
        'social_grid' => 'mt-6 grid grid-cols-2 gap-3',
        'social_btn' => 'w-full flex items-center justify-center px-4 py-2 border-2 border-tertiary rounded-md shadow-sm text-sm font-bold text-secondary bg-primary hover:bg-tertiary-desat hover:border-tertiary-sat transition-all focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-accent',
        'social_icon' => 'h-5 w-5',
        'social_text' => 'ml-2',
        'github_icon' => 'h-5 w-5 text-secondary-sat fill-current'
    ];
@endphp

<x-guest-layout>
    <form method="POST" action="{{ route('register') }}">
        @csrf

        <!-- Name -->
        <div>
            <x-input-label for="name" :value="__('Name')" />
            <x-text-input id="name" class="{{ $classes['input'] }}" type="text" name="name" :value="old('name')"
                required autofocus autocomplete="name" />
            <x-input-error :messages="$errors->get('name')" class="{{ $classes['error'] }}" />
        </div>

        <!-- Father Lastname -->
        <div class="{{ $classes['input_wrapper'] }}">
            <x-input-label for="father_lastname" value="Apellido Paterno" />
            <x-text-input id="father_lastname" class="{{ $classes['input'] }}" type="text" name="father_lastname"
                :value="old('father_lastname')" required autocomplete="family-name" />
            <x-input-error :messages="$errors->get('father_lastname')" class="{{ $classes['error'] }}" />
        </div>

        <!-- Mother Lastname -->
        <div class="{{ $classes['input_wrapper'] }}">
            <x-input-label for="mother_lastname" value="Apellido Materno" />
            <x-text-input id="mother_lastname" class="{{ $classes['input'] }}" type="text" name="mother_lastname"
                :value="old('mother_lastname')" required autocomplete="family-name" />
            <x-input-error :messages="$errors->get('mother_lastname')" class="{{ $classes['error'] }}" />
        </div>

        <!-- Username -->
        <div class="{{ $classes['input_wrapper'] }}">
            <x-input-label for="username" value="Nombre de Usuario" />
            <x-text-input id="username" class="{{ $classes['input'] }}" type="text" name="username"
                :value="old('username')" required autocomplete="username" />
            <x-input-error :messages="$errors->get('username')" class="{{ $classes['error'] }}" />
        </div>

        <!-- Email Address -->
        <div class="{{ $classes['input_wrapper'] }}">
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="{{ $classes['input'] }}" type="email" name="email" :value="old('email')"
                required autocomplete="email" />
            <x-input-error :messages="$errors->get('email')" class="{{ $classes['error'] }}" />
        </div>

        <!-- Password -->
        <div class="{{ $classes['input_wrapper'] }}">
            <x-input-label for="password" :value="__('Password')" />

            <x-text-input id="password" class="{{ $classes['input'] }}" type="password" name="password" required
                autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password')" class="{{ $classes['error'] }}" />
        </div>

        <!-- Confirm Password -->
        <div class="{{ $classes['input_wrapper'] }}">
            <x-input-label for="password_confirmation" :value="__('Confirm Password')" />

            <x-text-input id="password_confirmation" class="{{ $classes['input'] }}" type="password"
                name="password_confirmation" required autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password_confirmation')" class="{{ $classes['error'] }}" />
        </div>

        <div class="{{ $classes['actions'] }}">
            <a class="{{ $classes['link'] }}" href="{{ route('login') }}">
                {{ __('Already registered?') }}
            </a>

            <x-primary-button>
                {{ __('Register') }}
            </x-primary-button>
        </div>

        <div class="{{ $classes['divider_container'] }}">
            <div class="{{ $classes['divider_relative'] }}">
                <div class="{{ $classes['divider_line_container'] }}">
                    <div class="{{ $classes['divider_line'] }}"></div>
                </div>
                <div class="{{ $classes['divider_text_container'] }}">
                    <span class="{{ $classes['divider_text'] }}">O regístrate con</span>
                </div>
            </div>

            <div class="{{ $classes['social_grid'] }}">
                <a href="{{ route('social.redirect', 'google') }}" class="{{ $classes['social_btn'] }}">
                    <svg class="{{ $classes['social_icon'] }}" aria-hidden="true" viewBox="0 0 24 24">
                        <path
                            d="M12.48 10.92v3.28h7.84c-.24 1.84-.853 3.187-1.787 4.133-1.147 1.147-2.933 2.4-6.053 2.4-4.827 0-8.6-3.893-8.6-8.72s3.773-8.72 8.6-8.72c2.6 0 4.507 1.027 5.907 2.347l2.307-2.307C18.747 1.44 16.133 0 12.48 0 5.867 0 .307 5.387.307 12s5.56 12 12.173 12c3.573 0 6.267-1.173 8.373-3.36 2.16-2.16 2.84-5.213 2.84-7.667 0-.76-.053-1.467-.173-2.053H12.48z"
                            fill="#4285F4" />
                    </svg>
                    <span class="{{ $classes['social_text'] }}">Google</span>
                </a>

                <a href="{{ route('social.redirect', 'github') }}" class="{{ $classes['social_btn'] }}">
                    <svg class="{{ $classes['github_icon'] }}" viewBox="0 0 20 20" aria-hidden="true">
                        <path fill-rule="evenodd"
                            d="M10 0C4.477 0 0 4.484 0 10.017c0 4.425 2.865 8.18 6.839 9.504.5.092.682-.217.682-.483 0-.237-.008-.868-.013-1.703-2.782.605-3.369-1.343-3.369-1.343-.454-1.158-1.11-1.466-1.11-1.466-.908-.62.069-.608.069-.608 1.003.07 1.531 1.032 1.531 1.032.892 1.53 2.341 1.088 2.91.832.092-.647.35-1.088.636-1.338-2.22-.253-4.555-1.113-4.555-4.951 0-1.093.39-1.988 1.029-2.688-.103-.253-.446-1.272.098-2.65 0 0 .84-.27 2.75 1.026A9.564 9.564 0 0110 4.844c.85.004 1.705.115 2.504.337 1.909-1.296 2.747-1.027 2.747-1.027.546 1.379.203 2.398.1 2.651.64.7 1.028 1.595 1.028 2.688 0 3.848-2.339 4.695-4.566 4.942.359.31.678.921.678 1.856 0 1.338-.012 2.415-.012 2.743 0 .269.18.58.688.482A10.019 10.019 0 0020 10.017C20 4.484 15.522 0 10 0z"
                            clip-rule="evenodd" />
                    </svg>
                    <span class="{{ $classes['social_text'] }}">GitHub</span>
                </a>
            </div>
        </div>
    </form>
</x-guest-layout>
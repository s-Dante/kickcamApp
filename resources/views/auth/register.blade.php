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

        <x-social-login-buttons />
    </form>
</x-guest-layout>
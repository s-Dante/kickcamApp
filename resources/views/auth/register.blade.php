@php
    $classes = [
        'grid_container' => 'grid grid-cols-1 sm:grid-cols-2 gap-x-4 gap-y-3 sm:gap-y-4',
        'grid_full' => 'sm:col-span-2',
        'input' => 'block w-full rounded-xl transition-colors duration-200 mt-1',
        'error' => 'mt-1 text-xs',
        'actions' => 'mt-6 space-y-3',
        'submit_btn_wrapper' => 'w-full',
        'submit_btn' => 'w-full justify-center py-2.5 sm:py-3 text-sm sm:text-base rounded-xl shadow-lg hover:shadow-xl hover:-translate-y-0.5 transition-all duration-200',
        'login_wrapper' => 'text-center pt-1',
        'link' => 'text-sm font-bold text-accent hover:text-accent-sat transition-colors underline-offset-2 hover:underline focus:outline-none focus:ring-2 focus:ring-accent focus:ring-offset-2 rounded-sm',
    ];
@endphp

<x-guest-layout>
    <form method="POST" action="{{ route('register') }}" class="mt-1">
        @csrf

        <div class="{{ $classes['grid_container'] }}">

            <!-- Name (Full Width) -->
            <div class="{{ $classes['grid_full'] }}">
                <x-input-label for="name" :value="__('Name')" />
                <x-text-input id="name" class="{{ $classes['input'] }}" type="text" name="name" :value="old('name')"
                    required autofocus autocomplete="name" />
                <x-input-error :messages="$errors->get('name')" class="{{ $classes['error'] }}" />
            </div>

            <!-- Father Lastname -->
            <div>
                <x-input-label for="father_lastname" value="Appellido Paterno" />
                <x-text-input id="father_lastname" class="{{ $classes['input'] }}" type="text" name="father_lastname"
                    :value="old('father_lastname')" required autocomplete="family-name" />
                <x-input-error :messages="$errors->get('father_lastname')" class="{{ $classes['error'] }}" />
            </div>

            <!-- Mother Lastname -->
            <div>
                <x-input-label for="mother_lastname" value="Apellido Materno" />
                <x-text-input id="mother_lastname" class="{{ $classes['input'] }}" type="text" name="mother_lastname"
                    :value="old('mother_lastname')" required autocomplete="family-name" />
                <x-input-error :messages="$errors->get('mother_lastname')" class="{{ $classes['error'] }}" />
            </div>

            <!-- Username -->
            <div>
                <x-input-label for="username" value="Nombre de Usuario" />
                <x-text-input id="username" class="{{ $classes['input'] }}" type="text" name="username"
                    :value="old('username')" required autocomplete="username" />
                <x-input-error :messages="$errors->get('username')" class="{{ $classes['error'] }}" />
            </div>

            <!-- Email Address -->
            <div>
                <x-input-label for="email" :value="__('Email')" />
                <x-text-input id="email" class="{{ $classes['input'] }}" type="email" name="email" :value="old('email')"
                    required autocomplete="email" />
                <x-input-error :messages="$errors->get('email')" class="{{ $classes['error'] }}" />
            </div>

            <!-- Password -->
            <div>
                <x-input-label for="password" :value="__('Password')" />
                <x-text-input id="password" class="{{ $classes['input'] }}" type="password" name="password" required
                    autocomplete="new-password" />
                <x-input-error :messages="$errors->get('password')" class="{{ $classes['error'] }}" />
            </div>

            <!-- Confirm Password -->
            <div>
                <x-input-label for="password_confirmation" :value="__('Confirm Password')" />
                <x-text-input id="password_confirmation" class="{{ $classes['input'] }}" type="password"
                    name="password_confirmation" required autocomplete="new-password" />
                <x-input-error :messages="$errors->get('password_confirmation')" class="{{ $classes['error'] }}" />
            </div>

        </div>

        <!-- Form Actions -->
        <div class="{{ $classes['actions'] }}">
            <div class="{{ $classes['submit_btn_wrapper'] }}">
                <x-primary-button class="{{ $classes['submit_btn'] }}">
                    {{ __('Register') }}
                </x-primary-button>
            </div>

            <div class="{{ $classes['login_wrapper'] }}">
                <span class="text-sm text-secondary-desat">¿Ya tienes una cuenta?</span>
                <a class="{{ $classes['link'] }} ml-1" href="{{ route('login') }}">Inicia Sesión</a>
            </div>
        </div>

        <!-- Social Login -->
        <div class="mt-6 pt-5 border-t border-tertiary-desat dark:border-tertiary/30">
            <x-social-login-buttons />
        </div>
    </form>
</x-guest-layout>
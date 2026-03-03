@php
    $classes = [
        'status' => 'mb-4',
        'input_wrapper' => 'mt-4',
        'input' => 'block mt-1 w-full',
        'error' => 'mt-2',
        'checkbox_wrapper' => 'block mt-4',
        'checkbox_label' => 'inline-flex items-center cursor-pointer',
        'checkbox_input' => 'rounded border-tertiary text-accent-sat shadow-sm focus:ring-accent transition-colors',
        'checkbox_text' => 'ms-2 text-sm text-secondary-desat',
        'actions' => 'flex items-center justify-between mt-4',
        'submit_group' => 'flex items-center',
        'link' => 'underline text-sm text-secondary-desat hover:text-secondary rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-accent transition-colors',
        'link_spaced' => 'underline text-sm text-secondary-desat hover:text-secondary rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-accent transition-colors mx-3',
    ];
@endphp

<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="{{ $classes['status'] }}" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <!-- Email Address -->
        <div>
            <x-input-label for="login" value="{{ __('Email') }} o Username" />
            <x-text-input id="login" class="{{ $classes['input'] }}" type="text" name="login" :value="old('login')"
                required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('login')" class="{{ $classes['error'] }}" />
        </div>

        <!-- Password -->
        <div class="{{ $classes['input_wrapper'] }}">
            <x-input-label for="password" :value="__('Password')" />

            <x-text-input id="password" class="{{ $classes['input'] }}" type="password" name="password" required
                autocomplete="current-password" />

            <x-input-error :messages="$errors->get('password')" class="{{ $classes['error'] }}" />
        </div>

        <!-- Remember Me -->
        <div class="{{ $classes['checkbox_wrapper'] }}">
            <label for="remember_me" class="{{ $classes['checkbox_label'] }}">
                <input id="remember_me" type="checkbox" class="{{ $classes['checkbox_input'] }}" name="remember">
                <span class="{{ $classes['checkbox_text'] }}">{{ __('Remember me') }}</span>
            </label>
        </div>

        <div class="{{ $classes['actions'] }}">
            <a class="{{ $classes['link'] }}" href="{{ route('register') }}">
                ¿No tienes cuenta? Regístrate aquí
            </a>

            <div class="{{ $classes['submit_group'] }}">
                @if (Route::has('password.request'))
                    <a class="{{ $classes['link_spaced'] }}" href="{{ route('password.request') }}">
                        {{ __('Forgot your password?') }}
                    </a>
                @endif

                <x-primary-button>
                    {{ __('Log in') }}
                </x-primary-button>
            </div>
        </div>

        <x-social-login-buttons />
    </form>
</x-guest-layout>
@php
    $classes = [
        'status' => 'mb-4 rounded-lg bg-green-500/10 p-3 text-sm text-green-600 dark:text-green-400 font-medium border border-green-500/20',
        'input_wrapper' => 'mt-4',
        'input' => 'block w-full rounded-xl transition-colors duration-200 mt-1',
        'error' => 'mt-1 text-xs',
        'checkbox_wrapper' => 'block mt-4',
        'checkbox_label' => 'inline-flex items-center cursor-pointer group',
        'checkbox_input' => 'rounded border-tertiary text-accent shadow-sm focus:ring-accent transition-colors',
        'checkbox_text' => 'ms-2 text-sm text-secondary-desat group-hover:text-secondary transition-colors',
        'forgot_pwd_wrapper' => 'flex justify-end mb-1',
        'forgot_pwd_link' => 'text-xs text-secondary-desat hover:text-accent font-medium transition-colors underline-offset-2 hover:underline focus:outline-none focus:ring-2 focus:ring-accent focus:ring-offset-2 rounded-sm',
        'actions' => 'mt-6 space-y-3',
        'submit_btn_wrapper' => 'w-full',
        'submit_btn' => 'w-full justify-center py-2.5 sm:py-3 text-sm sm:text-base rounded-xl shadow-lg hover:shadow-xl hover:-translate-y-0.5 transition-all duration-200',
        'register_wrapper' => 'text-center pt-1',
        'link' => 'text-sm font-bold text-accent hover:text-accent-sat transition-colors underline-offset-2 hover:underline focus:outline-none focus:ring-2 focus:ring-accent focus:ring-offset-2 rounded-sm',
    ];
@endphp

<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="{{ $classes['status'] }}" :status="session('status')" />

    <form method="POST" action="{{ route('login')}}">
        @csrf

        <!-- Email Address or Username -->
        <div>
            <x-input-label for="login" value="{{ __('Email') }} o Username" />
            <x-text-input id="login" class="{{ $classes['input'] }}" type="text" name="login" :value="old('login')"
                required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('login')" class="{{ $classes['error'] }}" />
        </div>

        <!-- Password -->
        <div class="{{ $classes['input_wrapper'] }}">
            <div class="flex justify-between items-baseline">
                <x-input-label for="password" :value="__('Password')" />
                @if (Route::has('password.request'))
                    <a class="{{ $classes['forgot_pwd_link'] }}" href="{{ route('password.request') }}">
                        ¿Olvidaste tu contraseña?
                    </a>
                @endif
            </div>

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

        <!-- Form Actions -->
        <div class="{{ $classes['actions'] }}">
            <div class="{{ $classes['submit_btn_wrapper'] }}">
                <x-primary-button class="{{ $classes['submit_btn'] }}">
                    {{ __('Log in') }}
                </x-primary-button>
            </div>

            <div class="{{ $classes['register_wrapper'] }}">
                <span class="text-sm text-secondary-desat">¿No tienes cuenta?</span>
                <a class="{{ $classes['link'] }} ml-1" href="{{ route('register') }}">Regístrate aquí</a>
            </div>
        </div>

        <!-- Social Login -->
        <div class="mt-6 pt-5 border-t border-tertiary-desat dark:border-tertiary/30">
            <x-social-login-buttons />
        </div>
    </form>
</x-guest-layout>
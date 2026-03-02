@php
    $classes = [
        'text_info' => 'mb-4 text-sm text-secondary-desat',
        'status' => 'mb-4',
        'input_wrapper' => '',
        'input' => 'block mt-1 w-full',
        'error' => 'mt-2',
        'actions' => 'flex items-center justify-end mt-4'
    ];
@endphp

<x-guest-layout>
    <div class="{{ $classes['text_info'] }}">
        {{ __('¿Olvidaste tu contraseña? No hay problema. Déjanos tu correo electrónico y te enviaremos un código seguro de recuperación.') }}
    </div>

    <!-- Session Status -->
    <x-auth-session-status class="{{ $classes['status'] }}" :status="session('status')" />

    <form method="POST" action="{{ route('password.email') }}">
        @csrf

        <!-- Email Address -->
        <div class="{{ $classes['input_wrapper'] }}">
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="{{ $classes['input'] }}" type="email" name="email" :value="old('email')"
                required autofocus />
            <x-input-error :messages="$errors->get('email')" class="{{ $classes['error'] }}" />
        </div>

        <div class="{{ $classes['actions'] }}">
            <x-primary-button>
                {{ __('Obtener Código de Recuperación') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
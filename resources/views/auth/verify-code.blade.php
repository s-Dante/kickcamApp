@php
    $classes = [
        'text_info' => 'mb-4 text-sm text-secondary-desat',
        'input_wrapper' => '',
        'input_pin' => 'block mt-1 w-full text-center tracking-widest text-2xl font-bold bg-primary text-secondary border border-tertiary focus:border-accent focus:ring-accent transition-colors',
        'error' => 'mt-2',
        'actions' => 'flex justify-end mt-4'
    ];
@endphp

<x-guest-layout>
    <div class="{{ $classes['text_info'] }}">
        {{ __('Hemos enviado un código seguro de 6 dígitos a tu correo electrónico. Ingrésalo a continuación para continuar.') }}
    </div>

    <form method="POST" action="{{ route('password.verify.code') }}">
        @csrf
        <input type="hidden" name="email" value="{{ session('reset_email') }}">

        <div class="{{ $classes['input_wrapper'] }}">
            <x-input-label for="pin" value="Código de Verificación (PIN)" />
            <x-text-input id="pin" class="{{ $classes['input_pin'] }}" type="text" name="pin" required autofocus
                autocomplete="one-time-code" maxlength="6" pattern="\d{6}" placeholder="000000" />
            <x-input-error :messages="$errors->get('pin')" class="{{ $classes['error'] }}" />
        </div>

        <div class="{{ $classes['actions'] }}">
            <x-primary-button>
                {{ __('Verificar Código') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
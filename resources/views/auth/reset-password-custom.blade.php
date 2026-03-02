@php
    $classes = [
        'text_info' => 'mb-4 text-sm text-secondary-desat',
        'input_wrapper' => 'mt-4',
        'input' => 'block mt-1 w-full',
        'error' => 'mt-2',
        'actions' => 'flex items-center justify-end mt-4'
    ];
@endphp

<x-guest-layout>
    <div class="{{ $classes['text_info'] }}">
        {{ __('Ingresa tu nueva contraseña.') }}
    </div>

    <form method="POST" action="{{ route('password.store.custom') }}">
        @csrf

        <input type="hidden" name="email" value="{{ $email }}">
        <input type="hidden" name="pin" value="{{ $pin }}">

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
            <x-primary-button>
                {{ __('Reset Password') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
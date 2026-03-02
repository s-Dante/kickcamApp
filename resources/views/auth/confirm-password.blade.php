@php
    $classes = [
        'text_info' => 'mb-4 text-sm text-secondary-desat',
        'input_wrapper' => '',
        'input' => 'block mt-1 w-full',
        'error' => 'mt-2',
        'actions' => 'flex justify-end mt-4'
    ];
@endphp

<x-guest-layout>
    <div class="{{ $classes['text_info'] }}">
        {{ __('This is a secure area of the application. Please confirm your password before continuing.') }}
    </div>

    <form method="POST" action="{{ route('password.confirm') }}">
        @csrf

        <!-- Password -->
        <div class="{{ $classes['input_wrapper'] }}">
            <x-input-label for="password" :value="__('Password')" />

            <x-text-input id="password" class="{{ $classes['input'] }}" type="password" name="password" required
                autocomplete="current-password" />

            <x-input-error :messages="$errors->get('password')" class="{{ $classes['error'] }}" />
        </div>

        <div class="{{ $classes['actions'] }}">
            <x-primary-button>
                {{ __('Confirm') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
@php
    $classes = [
        'header' => [
            'title' => $ui['h3'] ?? 'text-lg font-medium text-secondary',
            'desc' => "mt-1 {$ui['text-muted']}"
        ],
        'form' => 'mt-6 space-y-6',
        'input_group' => 'mt-1 block w-full',
        'error' => 'mt-2',
        'footer' => [
            'container' => 'flex items-center gap-4',
            'saved' => "text-sm {$ui['text-muted']}"
        ]
    ];
@endphp

<section>
    <header>
        <h2 class="{{ $classes['header']['title'] }}">
            {{ __('Update Password') }}
        </h2>

        <p class="{{ $classes['header']['desc'] }}">
            {{ __('Ensure your account is using a long, random password to stay secure.') }}
        </p>
    </header>

    <form method="post" action="{{ route('password.update') }}" class="{{ $classes['form'] }}">
        @csrf
        @method('put')

        <div>
            <x-input-label for="update_password_current_password" :value="__('Current Password')" />
            <x-text-input id="update_password_current_password" name="current_password" type="password"
                class="{{ $classes['input_group'] }}" autocomplete="current-password" />
            <x-input-error :messages="$errors->updatePassword->get('current_password')"
                class="{{ $classes['error'] }}" />
        </div>

        <div>
            <x-input-label for="update_password_password" :value="__('New Password')" />
            <x-text-input id="update_password_password" name="password" type="password"
                class="{{ $classes['input_group'] }}" autocomplete="new-password" />
            <x-input-error :messages="$errors->updatePassword->get('password')" class="{{ $classes['error'] }}" />
        </div>

        <div>
            <x-input-label for="update_password_password_confirmation" :value="__('Confirm Password')" />
            <x-text-input id="update_password_password_confirmation" name="password_confirmation" type="password"
                class="{{ $classes['input_group'] }}" autocomplete="new-password" />
            <x-input-error :messages="$errors->updatePassword->get('password_confirmation')"
                class="{{ $classes['error'] }}" />
        </div>

        <div class="{{ $classes['footer']['container'] }}">
            <x-primary-button>{{ __('Save') }}</x-primary-button>

            @if (session('status') === 'password-updated')
                <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)"
                    class="{{ $classes['footer']['saved'] }}">{{ __('Saved.') }}</p>
            @endif
        </div>
    </form>
</section>
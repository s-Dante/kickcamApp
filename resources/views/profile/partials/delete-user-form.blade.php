@php
    $classes = [
        'section' => 'space-y-6',
        'header' => [
            'title' => $ui['h3'] ?? 'text-lg font-medium text-secondary',
            'desc' => "mt-1 {$ui['text-muted']}"
        ],
        'modal' => [
            'form' => 'p-6',
            'title' => $ui['h3'] ?? 'text-lg font-medium text-secondary',
            'desc' => "mt-1 {$ui['text-muted']}",
            'input_group' => 'mt-6',
            'input' => 'mt-1 block w-3/4',
            'error' => 'mt-2',
            'footer' => 'mt-6 flex justify-end',
            'btn_danger' => 'ms-3'
        ]
    ];
@endphp

<section class="{{ $classes['section'] }}">
    <header>
        <h2 class="{{ $classes['header']['title'] }}">
            {{ __('Delete Account') }}
        </h2>

        <p class="{{ $classes['header']['desc'] }}">
            {{ __('Once your account is deleted, all of its resources and data will be permanently deleted. Before deleting your account, please download any data or information that you wish to retain.') }}
        </p>
    </header>

    <x-danger-button x-data=""
        x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')">{{ __('Delete Account') }}</x-danger-button>

    <x-modal name="confirm-user-deletion" :show="$errors->userDeletion->isNotEmpty()" focusable>
        <form method="post" action="{{ route('profile.destroy') }}" class="{{ $classes['modal']['form'] }}">
            @csrf
            @method('delete')

            <h2 class="{{ $classes['modal']['title'] }}">
                {{ __('Are you sure you want to delete your account?') }}
            </h2>

            <p class="{{ $classes['modal']['desc'] }}">
                {{ __('Once your account is deleted, all of its resources and data will be permanently deleted. Please enter your password to confirm you would like to permanently delete your account.') }}
            </p>

            <div class="{{ $classes['modal']['input_group'] }}">
                <x-input-label for="password" value="{{ __('Password') }}" class="sr-only" />

                <x-text-input id="password" name="password" type="password" class="{{ $classes['modal']['input'] }}"
                    placeholder="{{ __('Password') }}" />

                <x-input-error :messages="$errors->userDeletion->get('password')"
                    class="{{ $classes['modal']['error'] }}" />
            </div>

            <div class="{{ $classes['modal']['footer'] }}">
                <x-secondary-button x-on:click="$dispatch('close')">
                    {{ __('Cancel') }}
                </x-secondary-button>

                <x-danger-button class="{{ $classes['modal']['btn_danger'] }}">
                    {{ __('Delete Account') }}
                </x-danger-button>
            </div>
        </form>
    </x-modal>
</section>
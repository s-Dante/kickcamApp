@php
    $classes = [
        'header' => [
            'title' => $ui['h3'] ?? 'text-lg font-medium text-secondary',
            'desc' => "mt-1 {$ui['text-muted']}"
        ],
        'form' => 'mt-6 space-y-6',
        'grid' => 'grid grid-cols-1 sm:grid-cols-2 gap-4',
        'input_group' => 'mt-1 block w-full',
        'error' => 'mt-2',
        'verify' => [
            'text' => "text-sm mt-2 {$ui['text-muted']}",
            'btn' => "underline text-sm {$ui['text-muted']} hover:text-secondary rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-accent",
            'success' => 'mt-2 font-medium text-sm text-green-600'
        ],
        'footer' => [
            'container' => 'flex items-center gap-4',
            'saved' => "text-sm {$ui['text-muted']}"
        ]
    ];
@endphp

<section>
    <header>
        <h2 class="{{ $classes['header']['title'] }}">
            {{ __('Profile Information') }}
        </h2>

        <p class="{{ $classes['header']['desc'] }}">
            {{ __("Update your account's profile information and email address.") }}
        </p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" class="{{ $classes['form'] }}">
        @csrf
        @method('patch')

        <div>
            <x-input-label for="name" :value="__('Name')" />
            <x-text-input id="name" name="name" type="text" class="{{ $classes['input_group'] }}" :value="old('name', $user->name)"
                required autofocus autocomplete="name" />
            <x-input-error class="{{ $classes['error'] }}" :messages="$errors->get('name')" />
        </div>

        <div class="{{ $classes['grid'] }}">
            <div>
                <x-input-label for="father_lastname" value="Apellido Paterno" />
                <x-text-input id="father_lastname" name="father_lastname" type="text" class="{{ $classes['input_group'] }}"
                    :value="old('father_lastname', $user->father_lastname)" autocomplete="family-name" />
                <x-input-error class="{{ $classes['error'] }}" :messages="$errors->get('father_lastname')" />
            </div>

            <div>
                <x-input-label for="mother_lastname" value="Apellido Materno" />
                <x-text-input id="mother_lastname" name="mother_lastname" type="text" class="{{ $classes['input_group'] }}"
                    :value="old('mother_lastname', $user->mother_lastname)" />
                <x-input-error class="{{ $classes['error'] }}" :messages="$errors->get('mother_lastname')" />
            </div>
        </div>

        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" name="email" type="email" class="{{ $classes['input_group'] }}" :value="old('email', $user->email)" required autocomplete="username" />
            <x-input-error class="{{ $classes['error'] }}" :messages="$errors->get('email')" />

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && !$user->hasVerifiedEmail())
                <div>
                    <p class="{{ $classes['verify']['text'] }}">
                        {{ __('Your email address is unverified.') }}

                        <button form="send-verification"
                            class="{{ $classes['verify']['btn'] }}">
                            {{ __('Click here to re-send the verification email.') }}
                        </button>
                    </p>

                    @if (session('status') === 'verification-link-sent')
                        <p class="{{ $classes['verify']['success'] }}">
                            {{ __('A new verification link has been sent to your email address.') }}
                        </p>
                    @endif
                </div>
            @endif
        </div>

        <div class="{{ $classes['footer']['container'] }}">
            <x-primary-button>{{ __('Save') }}</x-primary-button>

            @if (session('status') === 'profile-updated')
                <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)"
                    class="{{ $classes['footer']['saved'] }}">{{ __('Saved.') }}</p>
            @endif
        </div>
    </form>
</section>
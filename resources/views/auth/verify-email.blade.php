@php
    $classes = [
        'text_info' => 'mb-4 text-sm text-secondary-desat',
        'status' => 'mb-4 font-medium text-sm text-accent-sat',
        'actions' => 'mt-4 flex items-center justify-between',
        'btn_submit' => 'underline text-sm text-secondary-desat hover:text-secondary rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-accent transition-colors'
    ];
@endphp

<x-guest-layout>
    <div class="{{ $classes['text_info'] }}">
        {{ __('Thanks for signing up! Before getting started, could you verify your email address by clicking on the link we just emailed to you? If you didn\'t receive the email, we will gladly send you another.') }}
    </div>

    @if (session('status') == 'verification-link-sent')
        <div class="{{ $classes['status'] }}">
            {{ __('A new verification link has been sent to the email address you provided during registration.') }}
        </div>
    @endif

    <div class="{{ $classes['actions'] }}">
        <form method="POST" action="{{ route('verification.send') }}">
            @csrf

            <div>
                <x-primary-button>
                    {{ __('Resend Verification Email') }}
                </x-primary-button>
            </div>
        </form>

        <form method="POST" action="{{ route('logout') }}">
            @csrf

            <button type="submit" class="{{ $classes['btn_submit'] }}">
                {{ __('Log Out') }}
            </button>
        </form>
    </div>
</x-guest-layout>
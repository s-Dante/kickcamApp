@php
    $classes = [
        'header' => $ui['h2'],
        'container' => 'py-12',
        'wrapper' => "{$ui['container']} space-y-6",
        'card' => "{$ui['card']} p-4 sm:p-8",
        'content' => 'max-w-xl'
    ];
@endphp

<x-app-layout>
    <x-slot name="header">
        <h2 class="{{ $classes['header'] }}">
            {{ __('Profile') }}
        </h2>
    </x-slot>

    <div class="{{ $classes['container'] }}">
        <div class="{{ $classes['wrapper'] }}">
            <div class="{{ $classes['card'] }}">
                <div class="{{ $classes['content'] }}">
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>

            <div class="{{ $classes['card'] }}">
                <div class="{{ $classes['content'] }}">
                    @include('profile.partials.update-theme-form')
                </div>
            </div>

            <div class="{{ $classes['card'] }}">
                <div class="{{ $classes['content'] }}">
                    @include('profile.partials.update-password-form')
                </div>
            </div>

            <div class="{{ $classes['card'] }}">
                <div class="{{ $classes['content'] }}">
                    @include('profile.partials.delete-user-form')
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
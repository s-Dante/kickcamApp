@php
    $classes = [
        'container' => 'py-6',
        'wrapper' => $ui['container']
    ];
@endphp

<x-app-layout>
    <div class="{{ $classes['container'] }}">
        <div class="{{ $classes['wrapper'] }}">
            <x-dashboard.profile-header />

            <x-dashboard.general-badges :generalBadges="$generalBadges" :userUnlockedIds="$userUnlockedIds" />

            <x-dashboard.ar-badges />
        </div>
    </div>

    <x-dashboard.badge-modal :soccerCategories="$soccerCategories" :userUnlockedIds="$userUnlockedIds" />
</x-app-layout>
<x-app-layout>
    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <x-dashboard.profile-header />

            <x-dashboard.general-badges :generalBadges="$generalBadges" :userUnlockedIds="$userUnlockedIds" />

            <x-dashboard.ar-badges />
        </div>
    </div>

    <x-dashboard.badge-modal :soccerCategories="$soccerCategories" :userUnlockedIds="$userUnlockedIds" />
</x-app-layout>
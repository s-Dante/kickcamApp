<x-app>
    <x-slot:title>{{ $title ?? 'KickCamApp' }}</x-slot:title>
    
    <x-slot:header>
        <x-header />
    </x-slot:header>

    <section class="">
        {{ $slot }}
    </section>
</x-app>
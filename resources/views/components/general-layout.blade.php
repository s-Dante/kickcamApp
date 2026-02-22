<x-app>
    <x-slot:title>{{ $title ?? 'KickCamApp' }}</x-slot:title>

    <nav>
        <img src="/KickCam-Logo.svg" alt="Logotipo de KickCamApp" class="w-[100px] h-[100px]">

        <a href="{{ route('profile.me') }}">Perfil</a>
        <a href="{{ route('arCamera') }}">Realidad Aumentada</a>
        <a href="{{ route('camera') }}">Camara</a>
        <a href="{{ route('multimedia.index') }}">Multiedia</a>
        <a href="{{ route('trivia.index') }}">Trivia</a>
        <a href="{{ route('scoreboard.index') }}">Marcadores</a>
    </nav>

    <section>
        {{ $slot }}
    </section>
</x-app>
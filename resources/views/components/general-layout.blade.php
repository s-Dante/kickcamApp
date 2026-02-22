<x-app>
    <x-slot:title>{{ $title ?? 'KickCamApp' }}</x-slot:title>

    <nav class="">
        <a href="{{ route('welcome') }}">
            <img src="/KickCam_Logo.svg" alt="Logotipo de KickCamApp" class="w-[50px] h-[50px]">
        </a>

        @auth
        {{-- Solo se muestra si el usuario inició sesión --}}
        <a href="{{ route('profile.me') }}">Perfil</a>
        <a href="{{ route('arCamera') }}">Realidad Aumentada</a>
        <a href="{{ route('camera') }}">Cámara</a>
        <a href="{{ route('multimedia.index') }}">Multimedia</a>
        <a href="{{ route('trivia.index') }}">Trivia</a>
        <a href="{{ route('scoreboard.index') }}">Marcadores</a>

        <form action="{{ route('auth.logout') }}" method="POST" class="inline">
            @csrf
            <button type="submit" class="">Cerrar sesión</button>
        </form>
        @else
        {{-- Solo se muestra si es invitado --}}
        <a href="{{ route('auth.login') }}">Iniciar Sesión</a>
        <a href="{{ route('auth.register') }}">Registrarse</a>
        @endauth
    </nav>

    <main class="">
        {{ $slot }}
    </main>
</x-app>
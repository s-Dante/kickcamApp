<nav class="">
    <img src="/KickCam_Logo.svg" alt="Logotipo de KickCamApp" class="w-[50px] h-[50px]">

    @auth
        {{-- Solo se muestra si el usuario inició sesión --}}
        <a href="{{ route('dashboard') }}">Perfil</a>
        <a href="{{ route('arCamera') }}">Realidad Aumentada</a>
        <a href="{{ route('camera') }}">Cámara</a>
        <a href="{{ route('multimedia.index') }}">Multimedia</a>
        <a href="{{ route('trivia.index') }}">Trivia</a>
        <a href="{{ route('scoreboard.index') }}">Marcadores</a>
        <a href="{{ route('countries.index') }}">Diccionario</a>

        <form action="{{ route('logout') }}" method="POST" class="inline">
            @csrf
            <button type="submit" class="hover:cursor-pointer">Cerrar sesión</button>
        </form>
    @else
        {{-- Solo se muestra si es invitado --}}
        <a href="{{ route('login') }}">Iniciar Sesión</a>
        <a href="{{ route('register') }}">Registrarse</a>
    @endauth
</nav>
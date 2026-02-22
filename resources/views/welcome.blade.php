<x-app>
    <x-slot:title>Bienvenido</x-slot:title>

    <section>
        <article>
            <h1>Todo el Mundial en un mismo lugar</h1>
            <p>La experiencia definitiva de realidad aumentada para fanáticos del fútbol.</p>
        </article>

        @auth
        <a href="{{ route('profile.me') }}" class="btn-primary">Ir a mi Perfil</a>
        @else
        <a href="{{ route('auth.login') }}" class="btn-primary">Iniciar Sesión</a>
        @endauth
    </section>
</x-app>
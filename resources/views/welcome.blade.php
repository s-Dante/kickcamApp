<x-app>
    <x-slot:title>Bienvenido</x-slot:title>

    <section>
        <article>
            <h1>Todo el Mundial en un mismo lugar</h1>
            <p>La experiencia definitiva de realidad aumentada para fanáticos del fútbol.</p>
        </article>

        <button>
            <a href="{{ route('auth.login') }}" role="button">Comenzar Ahora</a>
        </button>
    </section>
</x-app>
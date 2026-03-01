<x-app>
    <x-slot:title>Bienvenido</x-slot:title>

    @php
        $classes = [
            'section' => 'flex flex-col items-center justify-center min-h-[80vh] text-center px-4',
            'title' => "{$ui['h1']} mb-4",
            'subtitle' => "{$ui['text-muted']} mb-8 max-w-2xl mx-auto text-lg",
            'btn' => $ui['btn-primary']
        ];
    @endphp

    <section class="{{ $classes['section'] }}">
        <article>
            <h1 class="{{ $classes['title'] }}">Todo el Mundial en un mismo lugar</h1>
            <p class="{{ $classes['subtitle'] }}">La experiencia definitiva de realidad aumentada para fanáticos del
                fútbol.</p>
        </article>

        @auth
            <a href="{{ route('dashboard') }}" class="{{ $classes['btn'] }}">Ir a mi Perfil</a>
        @else
            <a href="{{ route('login') }}" class="{{ $classes['btn'] }}">Iniciar Sesión</a>
        @endauth
    </section>
</x-app>
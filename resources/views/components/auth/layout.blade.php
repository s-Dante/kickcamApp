@props(['title', 'description', 'action', 'method' => 'POST'])

<x-app>
    <x-slot:title>{{ $title ?? 'Autenticación' }}</x-slot:title>

    <section>
        <h1>
            <h1>{{ $title }}</h1>
            <p>{{ $description }}</p>
        </h1>

        <form method="{{ $method === 'GET' ? 'GET' : 'POST' }}" action="{{ $action }}" class="space-y-4">
            @csrf
            @if(!in_array($method, ['GET', 'POST']))
            @method($method)
            @endif

            {{ $slot }}
        </form>
    </section>
</x-app>
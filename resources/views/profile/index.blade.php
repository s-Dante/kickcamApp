<x-general-layout>
    <div class="">
        <h1 class="">{{ $user->full_name }}</h1>
        <p class="">@ {{ $user->username }}</p>
        <div class="">
            <span class="">Puntos: {{ $user->points }}</span>
        </div>

        <h2 class="">Mis Medallas:</h2>
        <div class="">
            @foreach($user->badges as $badge)
            <img src="{{ $badge->image_url }}" alt="{{ $badge->title }}" class="w-16 h-16">
            @endforeach
        </div>
    </div>
</x-general-layout>
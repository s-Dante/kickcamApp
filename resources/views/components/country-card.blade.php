@props(['href', 'country'])

<a href="{{ $href }}" class="group block {{ $ui['card'] }} hover:border-accent/40 transition-all duration-200">
    <div class="aspect-w-16 aspect-h-9 w-full bg-tertiary flex items-center justify-center relative overflow-hidden">
        @if($country->flag_url)
            <img src="{{ Str::startsWith($country->flag_url, 'http') ? $country->flag_url : asset('storage/' . $country->flag_url) }}"
                alt="{{ $country->name }} flag"
                class="w-full h-full object-cover filter brightness-[0.9] group-hover:scale-110 transition-transform duration-300">
        @else
            <span class="text-6xl filter drop-shadow-md group-hover:scale-110 transition-transform duration-300">🏳️</span>
        @endif
    </div>
    <div class="p-4 border-t border-tertiary">
        <h4 class="font-bold text-secondary-sat text-lg mb-1 group-hover:text-accent transition-colors">
            {{ $country->name }}
        </h4>
        <div class="flex items-center text-xs {{ $ui['text-muted'] }} font-medium mt-2">
            {{ $slot }}
        </div>
    </div>
</a>
@props(['href', 'country'])

@php
    $clases = [
        'link' => 'group ' . $ui['card'] . ' blockhover:border-accent/40 transition-all duration-200',
        'imageWrapper' => 'aspect-w-16 aspect-h-9 w-full bg-tertiary flex items-center justify-center relative overflow-hidden',
        'image' => 'w-full h-full object-cover filter brightness-[0.9] group-hover:scale-110 transition-transform duration-300',
        'emoji' => 'text-6xl filter drop-shadow-md group-hover:scale-110 transition-transform duration-300',
        'content' => 'p-4 border-t border-tertiary',
        'title' => 'font-bold text-secondary-sat text-lg mb-1 group-hover:text-accent transition-colors',
        'meta' => 'flex items-center text-xs ' . $ui['text-muted'] . ' font-medium mt-2',
    ];
@endphp

<a href="{{ $href }}" class="{{ $clases['link'] }}">
    <div class="{{ $clases['imageWrapper'] }}">
        @if($country->flag_url)
            <img src="{{ Str::startsWith($country->flag_url, 'http') ? $country->flag_url : asset('storage/' . $country->flag_url) }}"
                alt="{{ $country->name }} flag" class="{{ $clases['image'] }}">
        @else
            <span class="{{ $clases['emoji'] }}">🏳️</span>
        @endif
    </div>

    <div class="{{ $clases['content'] }}">
        <h4 class="{{ $clases['title'] }}">
            {{ $country->name }}
        </h4>

        <div class="{{ $clases['meta'] }}">
            {{ $slot }}
        </div>
    </div>
</a>
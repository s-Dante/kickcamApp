@php
    $classes = [
        'card' => $ui['card'],
        'card_body' => $ui['card-body'],
        'header' => [
            'container' => 'flex items-center justify-between border-b border-tertiary pb-4 mb-4',
            'title' => "{$ui['h2']} flex items-center",
            'icon' => 'text-2xl mr-2',
            'badge' => "text-xs font-semibold {$ui['text-muted']} bg-tertiary-desat px-2 py-1 rounded-full border border-tertiary"
        ],
        'grid' => 'grid grid-cols-2 xs:grid-cols-3 sm:grid-cols-4 md:grid-cols-5 gap-4',
        'item' => [
            'container' => 'w-full h-full flex flex-col items-center p-3 rounded-xl bg-accent-desat/20 border border-tertiary-sat shadow-sm cursor-pointer',
            'icon_wrapper' => 'w-16 h-16 rounded-full bg-primary flex items-center justify-center mb-2 shadow-inner border border-tertiary',
            'icon' => 'text-3xl drop-shadow-sm',
            'title' => 'text-xs font-bold text-secondary-sat text-center leading-tight uppercase tracking-wider',
            'link' => "text-[10px] {$ui['text-highlight']} font-semibold mt-1"
        ]
    ];

    $collections = [
        ['type' => 'flag', 'icon' => '🏳️', 'title' => 'Flags'],
        ['type' => 'shield', 'icon' => '🛡️', 'title' => 'Shields'],
        ['type' => 'ball', 'icon' => '⚽️', 'title' => 'Balls'],
        ['type' => 'fifa_logo', 'icon' => '🏆', 'title' => 'FIFA Logo'],
        ['type' => 'poster', 'icon' => '🖼️', 'title' => 'Posters'],
    ];
@endphp

<div class="{{ $classes['card'] }}">
    <div class="{{ $classes['card_body'] }}">
        <div class="{{ $classes['header']['container'] }}">
            <x-tooltip text="Esta es tu colección virtual interactiva. Escanea los códigos de las cartas reales usando tu cámara AR para desbloquearlos" position="right">
                <h3 class="{{ $classes['header']['title'] }}">
                    <span class="{{ $classes['header']['icon'] }}">🌍</span>
                    Colección Mundial (AR)
                </h3>
            </x-tooltip>
            <span class="{{ $classes['header']['badge'] }}">Deportes Oficiales</span>
        </div>

        <div class="{{ $classes['grid'] }}">
            @foreach($collections as $collection)
                <x-tooltip text="Ver colección de {{ $collection['title'] }}" position="top" class="block w-full h-full hover:scale-105 transition-transform">
                    <div onclick="openBadgeModal('{{ $collection['type'] }}')" class="{{ $classes['item']['container'] }}">
                        <div class="{{ $classes['item']['icon_wrapper'] }}">
                            <span class="{{ $classes['item']['icon'] }}">{{ $collection['icon'] }}</span>
                        </div>
                        <span class="{{ $classes['item']['title'] }}">{{ $collection['title'] }}</span>
                        <span class="{{ $classes['item']['link'] }}">Ver Álbum</span>
                    </div>
                </x-tooltip>
            @endforeach
        </div>
    </div>
</div>
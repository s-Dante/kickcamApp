@php
    $classes = [
        'page' => [
            'container' => 'py-6',
            'wrapper' => 'max-w-7xl mx-auto sm:px-6 lg:px-8',
            'header' => 'mb-6 px-4 sm:px-0',
            'back_link' => 'inline-flex items-center text-sm font-medium text-accent hover:text-accent-sat transition-colors mb-4',
            'back_icon' => 'h-4 w-4 mr-1',
            'header_row' => 'flex items-center gap-4',
            'flag' => 'w-16 h-12 object-cover rounded shadow-sm border border-tertiary',
            'flag_emoji' => 'text-4xl',
            'title' => "text-3xl font-extrabold text-secondary tracking-tight",
            'subtitle' => "text-sm {$ui['text-muted']}"
        ],
        'content' => [
            'container' => 'px-4 sm:px-0',
            'section_mb' => 'mb-10',
            'section_header' => 'flex items-center mb-6',
            'section_title' => $ui['h2'],
            'badge_photos' => 'ml-3 inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-accent-desat text-accent-sat',
            'badge_videos' => 'ml-3 inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800',
            'images_grid' => 'grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6',
            'image_card' => "{$ui['card']} overflow-hidden group",
            'image_wrapper' => 'aspect-w-4 aspect-h-3 bg-tertiary-desat relative overflow-hidden',
            'image' => 'w-full h-full object-cover group-hover:scale-105 transition-transform duration-300',
            'videos_grid' => 'grid grid-cols-1 md:grid-cols-2 gap-6',
            'video_card' => "{$ui['card']} overflow-hidden",
            'video_wrapper' => 'aspect-w-16 aspect-h-9 bg-primary-sat relative',
            'video' => 'w-full h-full object-cover',
            'empty_container' => 'bg-gradient-to-br from-tertiary-desat to-primary-desat border border-tertiary rounded-2xl p-10 text-center',
            'empty_icon_wrapper' => 'w-20 h-20 bg-primary rounded-full flex items-center justify-center mx-auto shadow-sm mb-4',
            'empty_icon' => 'w-10 h-10 text-accent-desat',
            'empty_title' => "{$ui['h3']} mb-2",
            'empty_desc' => "{$ui['text-muted']} max-w-md mx-auto"
        ]
    ];
@endphp

<x-app-layout>
    <div class="{{ $classes['page']['container'] }}">
        <div class="{{ $classes['page']['wrapper'] }}">
            <div class="{{ $classes['page']['header'] }}">
                <a href="{{ route('multimedia.index') }}" class="{{ $classes['page']['back_link'] }}">
                    <svg class="{{ $classes['page']['back_icon'] }}" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    Volver al catálogo
                </a>

                <div class="{{ $classes['page']['header_row'] }}">
                    @if($country->flag_url)
                        <img src="{{ Str::startsWith($country->flag_url, 'http') ? $country->flag_url : asset('storage/' . $country->flag_url) }}"
                            alt="{{ $country->name }} flag" class="{{ $classes['page']['flag'] }}">
                    @else
                        <span class="{{ $classes['page']['flag_emoji'] }}">🏳️</span>
                    @endif
                    <div>
                        <h1 class="{{ $classes['page']['title'] }}">{{ $country->name }}</h1>
                        <p class="{{ $classes['page']['subtitle'] }}">Galería y momentos destacados.</p>
                    </div>
                </div>
            </div>

            <!-- Media Container -->
            <div class="{{ $classes['content']['container'] }}">
                @if($country->multimedia && $country->multimedia->count() > 0)
                    @php
                        $images = $country->multimedia->where('category', \App\Enums\MultimediaCategoryEnum::IMAGE);
                        $videos = $country->multimedia->where('category', \App\Enums\MultimediaCategoryEnum::VIDEO);
                    @endphp

                    <!-- Photos Section -->
                    @if($images->isNotEmpty())
                        <div class="{{ $classes['content']['section_mb'] }}">
                            <div class="{{ $classes['content']['section_header'] }}">
                                <h2 class="{{ $classes['content']['section_title'] }}">Fotos Oficiales</h2>
                                <span class="{{ $classes['content']['badge_photos'] }}">
                                    {{ $images->count() }}
                                </span>
                            </div>
                            <div class="{{ $classes['content']['images_grid'] }}">
                                @foreach($images as $media)
                                    <div class="{{ $classes['content']['image_card'] }}">
                                        <div class="{{ $classes['content']['image_wrapper'] }}">
                                            <img src="{{ Str::startsWith($media->file_url, 'http') ? $media->file_url : asset($media->file_url) }}"
                                                alt="{{ $media->title ?? 'Foto' }}" class="{{ $classes['content']['image'] }}">
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    <!-- Videos Section -->
                    @if($videos->isNotEmpty())
                        <div>
                            <div class="{{ $classes['content']['section_header'] }}">
                                <h2 class="{{ $classes['content']['section_title'] }}">Videos y Momentos</h2>
                                <span class="{{ $classes['content']['badge_videos'] }}">
                                    {{ $videos->count() }}
                                </span>
                            </div>
                            <div class="{{ $classes['content']['videos_grid'] }}">
                                @foreach($videos as $media)
                                    <div class="{{ $classes['content']['video_card'] }}">
                                        <div class="{{ $classes['content']['video_wrapper'] }}">
                                            <video src="{{ asset($media->file_url) }}" controls
                                                class="{{ $classes['content']['video'] }}"></video>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif
                @else
                    <div class="{{ $classes['content']['empty_container'] }}">
                        <div class="{{ $classes['content']['empty_icon_wrapper'] }}">
                            <svg class="{{ $classes['content']['empty_icon'] }}" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                    d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z">
                                </path>
                            </svg>
                        </div>
                        <h3 class="{{ $classes['content']['empty_title'] }}">Próximamente</h3>
                        <p class="{{ $classes['content']['empty_desc'] }}">
                            Aún no hemos publicado contenido exclusivo para {{ $country->name }}. ¡Vuelve pronto para
                            descubrir videos y galerías épicas!
                        </p>
                    </div>
                @endif
            </div>

        </div>
    </div>
</x-app-layout>
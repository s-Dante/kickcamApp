@php
    $classes = [
        'page' => 'py-12 bg-primary-sat min-h-screen',
        'container' => 'max-w-7xl mx-auto px-4 sm:px-6 lg:px-8',
        'header' => 'mb-10 flex flex-col md:flex-row md:items-center md:justify-between gap-6',
        'title' => 'text-4xl font-black text-secondary-sat tracking-tighter uppercase',
        'subtitle' => 'mt-2 text-secondary-desat text-sm font-medium',
        'controls' => 'flex flex-col sm:flex-row items-end gap-4',
        'search_wrapper' => 'relative max-w-sm w-full',
        'search_input' => 'w-full pl-10 pr-4 py-2.5 bg-primary-desat border border-tertiary rounded-2xl text-secondary-sat focus:ring-2 focus:ring-accent focus:border-transparent transition-all outline-none shadow-inner',
        'search_icon' => 'absolute left-3 top-3 h-5 w-5 text-secondary-desat',
        'lang_select' => 'bg-primary-desat border border-tertiary text-secondary-sat text-sm rounded-xl focus:ring-accent focus:border-accent block w-full sm:w-44 p-2.5 font-bold shadow-sm cursor-pointer hover:bg-tertiary transition-colors',
        'grid' => 'grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-6',
        'pagination' => 'mt-12 flex justify-center',
    ];
@endphp

<x-app-layout>
    <div x-data="{ 
            lang: localStorage.getItem('trivia_lang') || '{{ $lang }}', 
            translations: @js($translations) 
         }"
         x-init="$watch('lang', val => localStorage.setItem('trivia_lang', val))"
         class="{{ $classes['page'] }}">
        
        <div class="{{ $classes['container'] }}">
            
            <!-- Header -->
            <div class="{{ $classes['header'] }}">
                <div>
                    <h1 class="{{ $classes['title'] }}">Explorador de Países</h1>
                    <p class="{{ $classes['subtitle'] }}">Consulta banderas, siluetas y datos oficiales de {{ $countries->total() }} territorios.</p>
                </div>

                <div class="{{ $classes['controls'] }}">
                    <!-- Search -->
                    <form action="{{ route('countries.index') }}" method="GET" class="{{ $classes['search_wrapper'] }}">
                        <svg class="{{ $classes['search_icon'] }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Nombre, ISO o traducción..." class="{{ $classes['search_input'] }}">
                        <input type="hidden" name="lang" :value="lang">
                    </form>

                    <!-- Language Selector -->
                    <div class="z-20">
                        <select x-model="lang" class="{{ $classes['lang_select'] }}">
                            <option value="es">🇪🇸 Español</option>
                            <option value="en">🇬🇧 English</option>
                            <option value="fr">🇫🇷 Français</option>
                            <option value="de">🇩🇪 Deutsch</option>
                            <option value="it">🇮🇹 Italiano</option>
                            <option value="pt">🇵🇹 Português</option>
                            <option value="ko">🇰🇷 한국어</option>
                            <option value="ja">🇯🇵 日本語</option>
                            <option value="ru">🇷🇺 Русский</option>
                        </select>
                    </div>
                </div>
            </div>

            <!-- Grid -->
            @if($countries->isEmpty())
                <div class="py-20 text-center bg-primary-desat border-2 border-dashed border-tertiary rounded-3xl">
                    <p class="text-secondary-desat font-bold">No se encontraron países que coincidan con tu búsqueda.</p>
                    <a href="{{ route('countries.index') }}" class="mt-4 inline-block text-accent font-bold hover:underline">Limpiar búsqueda</a>
                </div>
            @else
                <div class="{{ $classes['grid'] }}">
                    @foreach($countries as $country)
                        <x-country-card :country="$country" :href="route('countries.show', ['iso' => $country->iso2]) . '?lang=' . $lang">
                            <div class="flex items-center gap-2 text-[10px] font-black uppercase tracking-tighter opacity-60">
                                <span class="px-1.5 py-0.5 bg-tertiary rounded">{{ $country->iso2 }}</span>
                                <span class="px-1.5 py-0.5 bg-tertiary rounded">{{ $country->iso3 }}</span>
                            </div>
                        </x-country-card>
                    @endforeach
                </div>
            @endif

            <!-- Pagination -->
            <div class="{{ $classes['pagination'] }}">
                {{ $countries->appends(request()->query())->links() }}
            </div>

        </div>
    </div>
</x-app-layout>

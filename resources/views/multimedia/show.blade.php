<x-app-layout>
    <div class="py-6">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="mb-6 px-4 sm:px-0">
                <a href="{{ route('multimedia.index') }}"
                    class="inline-flex items-center text-sm font-medium text-blue-600 hover:text-blue-800 transition-colors mb-4">
                    <svg class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    Volver al catálogo
                </a>

                <div class="flex items-center gap-4">
                    @if($country->flag_url)
                        <img src="{{ Str::startsWith($country->flag_url, 'http') ? $country->flag_url : asset('storage/' . $country->flag_url) }}"
                            alt="{{ $country->name }} flag"
                            class="w-16 h-12 object-cover rounded shadow-sm border border-gray-200">
                    @else
                        <span class="text-4xl">🏳️</span>
                    @endif
                    <div>
                        <h1 class="text-3xl font-extrabold text-gray-900 tracking-tight">{{ $country->name }}</h1>
                        <p class="text-sm text-gray-500">Galería y momentos destacados.</p>
                    </div>
                </div>
            </div>

            <!-- Media Container -->
            <div class="px-4 sm:px-0">
                @if($country->multimedia && $country->multimedia->count() > 0)
                    @php
                        $images = $country->multimedia->where('category', \App\Enums\MultimediaCategoryEnum::IMAGE);
                        $videos = $country->multimedia->where('category', \App\Enums\MultimediaCategoryEnum::VIDEO);
                    @endphp

                    <!-- Photos Section -->
                    @if($images->isNotEmpty())
                        <div class="mb-10">
                            <div class="flex items-center mb-6">
                                <h2 class="text-2xl font-bold text-gray-900">Fotos Oficiales</h2>
                                <span
                                    class="ml-3 inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                    {{ $images->count() }}
                                </span>
                            </div>
                            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
                                @foreach($images as $media)
                                    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden group">
                                        <div class="aspect-w-4 aspect-h-3 bg-gray-100 relative overflow-hidden">
                                            <img src="{{ Str::startsWith($media->file_url, 'http') ? $media->file_url : asset($media->file_url) }}"
                                                alt="{{ $media->title ?? 'Foto' }}"
                                                class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    <!-- Videos Section -->
                    @if($videos->isNotEmpty())
                        <div>
                            <div class="flex items-center mb-6">
                                <h2 class="text-2xl font-bold text-gray-900">Videos y Momentos</h2>
                                <span
                                    class="ml-3 inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                    {{ $videos->count() }}
                                </span>
                            </div>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                @foreach($videos as $media)
                                    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                                        <div class="aspect-w-16 aspect-h-9 bg-gray-900 relative">
                                            <video src="{{ asset($media->file_url) }}" controls
                                                class="w-full h-full object-cover"></video>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif
                @else
                    <div
                        class="bg-gradient-to-br from-indigo-50 to-blue-50 border border-indigo-100 rounded-2xl p-10 text-center">
                        <div
                            class="w-20 h-20 bg-white rounded-full flex items-center justify-center mx-auto shadow-sm mb-4">
                            <svg class="w-10 h-10 text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                    d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z">
                                </path>
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 mb-2">Próximamente</h3>
                        <p class="text-gray-500 max-w-md mx-auto">
                            Aún no hemos publicado contenido exclusivo para {{ $country->name }}. ¡Vuelve pronto para
                            descubrir videos y galerías épicas!
                        </p>
                    </div>
                @endif
            </div>

        </div>
    </div>
</x-app-layout>
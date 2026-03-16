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
            'image_card' => "{$ui['card']} overflow-hidden group cursor-pointer",
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
    <div x-data="{ 
            isImageModalOpen: false, 
            currentImage: null, 
            currentTitle: '',
            filter: 'none',
            openImageModal(url, title) { 
                this.currentImage = url;
                this.currentTitle = title;
                this.filter = 'none';
                this.isImageModalOpen = true; 
            },
            isDownloading: false,
            downloadImage() {
                if(!this.currentImage || this.isDownloading) return;
                this.isDownloading = true;
                
                const img = new Image();
                img.crossOrigin = 'anonymous';
                img.src = this.currentImage;
                img.onload = () => {
                    const canvas = document.createElement('canvas');
                    canvas.width = img.width;
                    canvas.height = img.height;
                    const ctx = canvas.getContext('2d');
                    
                    let filterStr = 'none';
                    if (this.filter === 'bw') filterStr = 'grayscale(100%)';
                    if (this.filter === 'vintage') filterStr = 'sepia(100%)';
                    if (this.filter === 'pop') filterStr = 'contrast(125%) saturate(150%)';
                    if (this.filter === 'alien') filterStr = 'hue-rotate(90deg)';
                    
                    ctx.filter = filterStr;
                    ctx.drawImage(img, 0, 0, img.width, img.height);
                    
                    const link = document.createElement('a');
                    const cleanTitle = this.currentTitle ? this.currentTitle.replace(/\s+/g, '-').toLowerCase() : 'kickcam-media';
                    const filterName = this.filter !== 'none' ? '-' + this.filter : '';
                    link.download = cleanTitle + filterName + '.jpg';
                    link.href = canvas.toDataURL('image/jpeg', 0.95);
                    document.body.appendChild(link);
                    link.click();
                    document.body.removeChild(link);
                    this.isDownloading = false;
                };
                img.onerror = () => {
                    this.isDownloading = false;
                    alert('Hubo un error al procesar la imagen para descarga.');
                };
            }
        }" class="{{ $classes['page']['container'] }}">
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
                                    <x-tooltip text="Click para ver en grande y aplicar filtros" position="top">
                                        <div @click="openImageModal('{{ Str::startsWith($media->file_url, 'http') ? $media->file_url : asset($media->file_url) }}', '{{ $media->title ?? 'Foto' }}')" class="{{ $classes['content']['image_card'] }}">
                                            <div class="{{ $classes['content']['image_wrapper'] }}">
                                                <img src="{{ Str::startsWith($media->file_url, 'http') ? $media->file_url : asset($media->file_url) }}"
                                                    alt="{{ $media->title ?? 'Foto' }}" class="{{ $classes['content']['image'] }}">
                                            </div>
                                        </div>
                                    </x-tooltip>
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

        <!-- Visor Modal de Imágenes -->
        <div x-show="isImageModalOpen" 
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             class="fixed inset-0 z-[100] flex items-center justify-center bg-black/80 backdrop-blur-sm p-4"
             style="display: none;"
             @keydown.escape.window="isImageModalOpen = false">
             
             <!-- Modal Backdrop (Cierra al clikar fuera) -->
             <div class="absolute inset-0" @click="isImageModalOpen = false"></div>

             <div class="relative w-full max-w-5xl bg-primary dark:bg-primary-900 rounded-2xl shadow-2xl border border-tertiary overflow-hidden z-10 flex flex-col md:flex-row"
                  x-transition:enter="transition ease-out duration-300"
                  x-transition:enter-start="scale-95 opacity-0"
                  x-transition:enter-end="scale-100 opacity-100">
                 
                 <!-- Contenedor Principal Izq (Imagen) -->
                 <div class="w-full md:w-3/4 bg-black/95 relative flex items-center justify-center p-4 min-h-[50vh] md:min-h-[70vh]">
                     <button @click="isImageModalOpen = false" class="absolute top-4 left-4 z-20 text-white/50 hover:text-white bg-black/20 hover:bg-black/50 rounded-full p-2 transition-colors">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                     </button>
                    <!-- Apply CSS Filters based on the selected Alpine state -->
                     <img :src="currentImage" :alt="currentTitle" 
                          class="max-w-full max-h-full object-contain drop-shadow-2xl transition-all duration-300"
                          :class="{
                              'grayscale': filter === 'bw',
                              'sepia': filter === 'vintage',
                              'contrast-125 saturate-150': filter === 'pop',
                              'hue-rotate-90': filter === 'alien'
                          }">
                 </div>

                 <!-- Panel Derecho (Controles) -->
                 <div class="w-full md:w-1/4 p-8 flex flex-col justify-between border-l border-tertiary/20 bg-primary/50 backdrop-blur-sm relative z-20 shadow-inner">
                     <div class="flex-1">
                         <div class="mb-8">
                             <span class="inline-block px-3 py-1 bg-accent/10 text-accent font-bold text-[10px] rounded-full mb-3 uppercase tracking-widest border border-accent/20">Editor Visual</span>
                             <h3 class="text-2xl font-black text-secondary-sat dark:text-secondary-desat leading-tight mb-2" x-text="currentTitle"></h3>
                             <p class="text-sm text-secondary/80 dark:text-tertiary-desat mb-6 leading-relaxed">Selecciona un filtro para darle un toque increíble a tu imagen antes de descargarla.</p>
                         </div>

                         <!-- Selector de Filtros -->
                         <div class="space-y-3 mb-8">                             
                             <button @click="filter = 'none'" 
                                     class="w-full text-left px-5 py-3 rounded-xl text-sm border-2 font-bold transition-all flex items-center justify-between group"
                                     :class="filter === 'none' ? 'bg-accent/10 border-accent text-accent-sat shadow-sm' : 'bg-primary border-tertiary/50 text-secondary hover:border-tertiary hover:bg-tertiary-desat/30'">
                                 <span>Original</span>
                                 <span class="w-2 h-2 rounded-full transition-colors" :class="filter === 'none' ? 'bg-accent' : 'bg-transparent group-hover:bg-tertiary/50'"></span>
                             </button>
                             <button @click="filter = 'bw'" 
                                     class="w-full text-left px-5 py-3 rounded-xl text-sm border-2 font-bold transition-all flex items-center justify-between group"
                                     :class="filter === 'bw' ? 'bg-accent/10 border-accent text-accent-sat shadow-sm' : 'bg-primary border-tertiary/50 text-secondary hover:border-tertiary hover:bg-tertiary-desat/30'">
                                 <span>Blanco y Negro</span>
                                 <span class="w-2 h-2 rounded-full transition-colors" :class="filter === 'bw' ? 'bg-accent' : 'bg-transparent group-hover:bg-tertiary/50'"></span>
                             </button>
                             <button @click="filter = 'vintage'" 
                                     class="w-full text-left px-5 py-3 rounded-xl text-sm border-2 font-bold transition-all flex items-center justify-between group"
                                     :class="filter === 'vintage' ? 'bg-accent/10 border-accent text-accent-sat shadow-sm' : 'bg-primary border-tertiary/50 text-secondary hover:border-tertiary hover:bg-tertiary-desat/30'">
                                 <span>Retro Sepia</span>
                                 <span class="w-2 h-2 rounded-full transition-colors" :class="filter === 'vintage' ? 'bg-accent' : 'bg-transparent group-hover:bg-tertiary/50'"></span>
                             </button>
                             <button @click="filter = 'pop'" 
                                     class="w-full text-left px-5 py-3 rounded-xl text-sm border-2 font-bold transition-all flex items-center justify-between group"
                                     :class="filter === 'pop' ? 'bg-accent/10 border-accent text-accent-sat shadow-sm' : 'bg-primary border-tertiary/50 text-secondary hover:border-tertiary hover:bg-tertiary-desat/30'">
                                 <span>Pop Saturado</span>
                                 <span class="w-2 h-2 rounded-full transition-colors" :class="filter === 'pop' ? 'bg-accent' : 'bg-transparent group-hover:bg-tertiary/50'"></span>
                             </button>
                         </div>
                     </div>

                     <!-- Acciones -->
                     <button @click="downloadImage" :disabled="isDownloading" class="w-full py-4 px-4 bg-accent hover:bg-accent-sat text-white rounded-xl font-black uppercase tracking-wider shadow-lg hover:shadow-xl hover:-translate-y-0.5 transition-all flex items-center justify-center gap-2 disabled:opacity-50 disabled:hover:translate-y-0">
                         <svg x-show="!isDownloading" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                         <svg x-show="isDownloading" class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" style="display: none;"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                         <span x-text="isDownloading ? 'Generando...' : (filter !== 'none' ? 'Descargar con Filtro' : 'Descargar Original')"></span>
                     </button>
                 </div>

             </div>
        </div>

    </div>
</x-app-layout>
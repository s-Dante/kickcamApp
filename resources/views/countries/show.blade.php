@php
    $classes = [
        'page' => 'py-12 bg-primary-sat min-h-screen',
        'container' => 'max-w-6xl mx-auto px-4 sm:px-6 lg:px-8',
        'back_link' => 'inline-flex items-center text-sm font-bold text-secondary-desat hover:text-accent mb-8 transition-colors uppercase tracking-widest',
        'grid' => 'grid grid-cols-1 lg:grid-cols-3 gap-8',
        'sidebar' => 'space-y-8',
        'main' => 'lg:col-span-2 space-y-8',
        'card' => 'bg-primary-desat border border-tertiary rounded-3xl overflow-hidden shadow-2xl',
        'card_header' => 'p-8 bg-gradient-to-br from-tertiary to-primary-desat border-b border-tertiary flex items-center justify-between',
        'card_title' => 'text-xl font-black text-secondary-sat uppercase tracking-tighter',
        'card_body' => 'p-8',
        'flag_box' => 'w-full aspect-video bg-primary-sat rounded-2xl flex items-center justify-center overflow-hidden border border-tertiary shadow-inner mb-6 relative group',
        'flag_img' => 'w-full h-full object-cover group-hover:scale-105 transition-transform duration-500',
        'info_grid' => 'grid grid-cols-2 gap-6',
        'info_label' => 'text-[10px] font-black text-secondary-desat uppercase tracking-widest block mb-1 opacity-70',
        'info_value' => 'text-lg font-bold text-secondary-sat leading-tight',
        'translation_pill' => 'px-3 py-2 bg-primary-sat border border-tertiary rounded-xl text-xs font-bold text-secondary-desat flex items-center gap-2 hover:border-accent/40 transition-all',
        'translation_lang' => 'text-accent/80 uppercase font-black',
        'translation_name' => 'text-secondary-sat',
        'silhouette_box' => 'aspect-square bg-primary-sat rounded-2xl flex items-center justify-center relative border border-tertiary group overflow-hidden',
        'points_badge' => 'absolute top-4 right-4 bg-accent/10 border border-accent/20 text-accent text-[10px] font-black px-2 py-1 rounded-full uppercase tracking-tighter z-10',
        'state_item' => 'bg-primary-sat border border-tertiary rounded-2xl overflow-hidden mb-4 transition-all hover:border-accent/20',
        'state_trigger' => 'w-full flex items-center justify-between p-5 text-left focus:outline-none',
        'state_name' => 'text-sm font-black text-secondary-sat uppercase tracking-tight',
        'state_meta' => 'text-[10px] font-bold text-secondary-desat uppercase',
        'city_list' => 'p-5 pt-0 grid grid-cols-2 gap-3 border-t border-tertiary/50 bg-primary-desat/30',
        'city_item' => 'text-xs font-semibold text-secondary-desat flex items-center gap-2',
        'city_bullet' => 'w-1 h-1 bg-accent rounded-full',
    ];
@endphp

<x-app-layout>
    <div class="{{ $classes['page'] }}">
        <div class="{{ $classes['container'] }}">
            
            <a href="{{ route('countries.index', ['lang' => $lang]) }}" class="{{ $classes['back_link'] }}">
                ← Volver al Explorador
            </a>

            <div class="{{ $classes['grid'] }}">
                
                <!-- Sidebar: Identity -->
                <div class="{{ $classes['sidebar'] }}">
                    <div class="{{ $classes['card'] }}">
                        <div class="{{ $classes['card_header'] }}">
                            <h2 class="{{ $classes['card_title'] }}">Identidad</h2>
                            <span class="text-3xl">{{ $country->emoji }}</span>
                        </div>
                        <div class="{{ $classes['card_body'] }}">
                            <div class="{{ $classes['flag_box'] }}">
                                <img src="{{ $country->flag_url }}" alt="Bandera de {{ $country->name }}" class="{{ $classes['flag_img'] }}">
                            </div>

                            <div class="{{ $classes['info_grid'] }}">
                                <div class="col-span-2">
                                    <span class="{{ $classes['info_label'] }}">Nombre Oficial (Local)</span>
                                    <span class="{{ $classes['info_value'] }} text-xl text-accent">{{ $country->native }}</span>
                                </div>
                                <div>
                                    <span class="{{ $classes['info_label'] }}">ISO Alpha-2</span>
                                    <span class="{{ $classes['info_value'] }}">{{ $country->iso2 }}</span>
                                </div>
                                <div>
                                    <span class="{{ $classes['info_label'] }}">ISO Alpha-3</span>
                                    <span class="{{ $classes['info_value'] }}">{{ $country->iso3 }}</span>
                                </div>
                                <div>
                                    <span class="{{ $classes['info_label'] }}">Capital</span>
                                    <span class="{{ $classes['info_value'] }}">{{ $country->capital ?? 'N/A' }}</span>
                                </div>
                                <div>
                                    <span class="{{ $classes['info_label'] }}">Moneda</span>
                                    <span class="{{ $classes['info_value'] }}">{{ $country->currency }} ({{ $country->currency_symbol }})</span>
                                </div>
                                <div>
                                    <span class="{{ $classes['info_label'] }}">Región</span>
                                    <span class="{{ $classes['info_value'] }}">{{ $country->region }}</span>
                                </div>
                                <div>
                                    <span class="{{ $classes['info_label'] }}">Subregión</span>
                                    <span class="{{ $classes['info_value'] }}">{{ $country->subregion }}</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Silhouette Audit -->
                    <div class="{{ $classes['card'] }}">
                        <div class="{{ $classes['card_header'] }}">
                            <h2 class="{{ $classes['card_title'] }}">Motor de Silueta</h2>
                            @if($points)
                                <span class="{{ $classes['points_badge'] }}">{{ $points }} Pts</span>
                            @endif
                        </div>
                        <div class="{{ $classes['card_body'] }}">
                            <div class="{{ $classes['silhouette_box'] }}" id="d3-directory-container">
                                <svg class="w-full h-full text-secondary-sat group-hover:text-accent transition-all duration-700" id="d3-directory-svg"></svg>
                                
                                <div id="no-silhouette" class="hidden absolute inset-0 flex items-center justify-center p-8 text-center bg-primary-sat/80 backdrop-blur-md rounded-2xl">
                                    <p class="text-xs font-black text-secondary-desat italic uppercase tracking-widest">Silueta no indexada</p>
                                </div>
                            </div>
                            <div class="mt-6 p-4 bg-primary-sat rounded-2xl border border-tertiary">
                                <p class="text-[10px] text-secondary-desat uppercase font-black text-center leading-relaxed tracking-tighter">
                                    Proyección: Mercator <br>
                                    Estado del Juego: 
                                    @if($points && $points < 30)
                                        <span class="text-red-500">Filtrado (Bajo Detalle)</span>
                                    @elseif($points)
                                        <span class="text-green-500">Activo (Detalle OK)</span>
                                    @else
                                        <span class="text-yellow-500">Pendiente de Compilación</span>
                                    @endif
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Main Content: Data -->
                <div class="{{ $classes['main'] }}">
                    
                    <!-- Translations -->
                    <div class="{{ $classes['card'] }}">
                        <div class="{{ $classes['card_header'] }}">
                            <h2 class="{{ $classes['card_title'] }}">Traducciones Globales</h2>
                        </div>
                        <div class="{{ $classes['card_body'] }}">
                            <div class="grid grid-cols-2 sm:grid-cols-3 gap-3">
                                <div class="{{ $classes['translation_pill'] }} border-accent/40 bg-accent/5">
                                    <span class="{{ $classes['translation_lang'] }}">EN</span>
                                    <span class="{{ $classes['translation_name'] }} font-black">{{ $country->name }}</span>
                                </div>
                                @foreach($country->translations as $langCode => $alias)
                                    @if($alias && $alias !== $country->name)
                                        <div class="{{ $classes['translation_pill'] }}">
                                            <span class="{{ $classes['translation_lang'] }}">{{ $langCode }}</span>
                                            <span class="{{ $classes['translation_name'] }}">{{ $alias }}</span>
                                        </div>
                                    @endif
                                @endforeach
                            </div>
                        </div>
                    </div>

                    <!-- States -->
                    <div class="{{ $classes['card'] }}">
                        <div class="{{ $classes['card_header'] }}">
                            <h2 class="{{ $classes['card_title'] }}">Estados / Provincias ({{ count($country->states ?? []) }})</h2>
                        </div>
                        <div class="max-h-[800px] overflow-y-auto scrollbar-thin scrollbar-thumb-tertiary p-8">
                            @if(count($country->states ?? []) > 0)
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    @foreach($country->states as $stateName)
                                        <div class="p-4 bg-primary-sat border border-tertiary rounded-2xl flex items-center gap-3">
                                            <div class="w-1.5 h-1.5 bg-accent rounded-full shrink-0"></div>
                                            <span class="text-sm font-bold text-secondary-sat uppercase tracking-tight">{{ is_array($stateName) ? ($stateName['name'] ?? 'N/A') : $stateName }}</span>
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <div class="py-20 text-center bg-primary-sat border border-dashed border-tertiary rounded-3xl">
                                    <p class="text-secondary-desat text-sm font-bold uppercase tracking-widest">Sin datos de regiones internas.</p>
                                </div>
                            @endif
                        </div>
                    </div>

                </div>

            </div>

        </div>
    </div>

    <!-- D3 Silhouette logic -->
    <script src="https://d3js.org/d3.v7.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const iso2 = "{{ $country->iso2 }}";
            const nameRaw = "{{ $country->name }}";

            fetch('/data/silhouettes.geojson')
                .then(response => response.json())
                .then(data => {
                    const feature = data.features.find(f => {
                        if (f.properties.iso2 && f.properties.iso2.toLowerCase() === iso2.toLowerCase()) return true;
                        return f.properties.name.toLowerCase() === nameRaw.toLowerCase();
                    });

                    if (feature) {
                        renderDirectorySilhouette(feature);
                    } else {
                        document.getElementById('no-silhouette').classList.remove('hidden');
                    }
                })
                .catch(() => {
                    document.getElementById('no-silhouette').classList.remove('hidden');
                });

            function renderDirectorySilhouette(feature) {
                const svg = d3.select("#d3-directory-svg");
                const container = document.getElementById('d3-directory-container');
                const width = container.clientWidth;
                const height = container.clientHeight;

                const projection = d3.geoMercator().fitSize([width - 80, height - 80], feature);
                const pathGenerator = d3.geoPath().projection(projection);

                svg.append("path")
                    .datum(feature)
                    .attr("d", pathGenerator)
                    .attr("fill", "currentColor")
                    .attr("stroke", "currentColor")
                    .attr("stroke-width", 1.5)
                    .attr("transform", "translate(40, 40)");
            }
        });
    </script>
</x-app-layout>

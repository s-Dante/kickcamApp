@php
    $classes = [
        'page' => [
            'container' => 'h-[calc(100vh-4rem)] sm:h-[calc(100vh-5rem)] w-full flex flex-col lg:flex-row overflow-hidden relative',
        ],
        'camera' => [
            'outer_wrapper' => 'relative w-full h-full lg:w-3/4 flex flex-col overflow-hidden shrink-0 transition-all duration-300 pt-4 px-4 lg:p-6 lg:pl-8',
            'wrapper' => "relative w-full flex-1 {$ui['card']} rounded-[2.5rem] flex flex-col justify-center items-center overflow-hidden shrink-0 transition-all duration-300 shadow-xl",
        ],
        'sidebar' => [
            'container' => "hidden lg:flex lg:w-1/4 h-full {$ui['bg-primary']} border-l {$ui['border']} flex-col p-6 overflow-y-auto space-y-6",
        ],
        'mobile_ui' => [
            'controls_overlay' => 'absolute bottom-10 inset-x-0 w-full px-8 flex justify-between items-center z-30 pointer-events-none lg:hidden',
            'info_btn' => "w-16 h-16 rounded-full border-[3px] border-accent flex items-center justify-center p-1.5 cursor-pointer active:scale-95 transition-all backdrop-blur-md bg-black/60 pointer-events-auto shadow-[0_0_20px_rgba(var(--accent-rgb),0.4)] hidden",
            'flip_btn' => 'w-12 h-12 rounded-full bg-black/40 text-white flex items-center justify-center backdrop-blur-md hover:bg-black/60 transition-colors pointer-events-auto shadow-xl border border-white/10',
            'switch_btn' => 'w-12 h-12 rounded-full bg-black/40 text-white flex items-center justify-center backdrop-blur-md hover:bg-black/60 transition-colors pointer-events-auto shadow-xl border border-white/10'
        ],
        'desktop_ui' => [
            'outline_btn' => "w-full py-3 px-6 rounded-lg font-bold flex items-center justify-center gap-2 border-2 border-accent text-accent hover:bg-accent hover:text-black transition-colors hidden",
            'flip_btn' => "{$ui['btn-secondary']} w-full py-3 px-6 gap-2",
        ]
    ];
@endphp

<x-app-layout title="Escáner AR Oficial">

    @push('head-scripts')
        <script src="https://aframe.io/releases/1.5.0/aframe.min.js"></script>
        <script src="https://cdn.jsdelivr.net/gh/donmccurdy/aframe-extras@v7.0.0/dist/aframe-extras.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/mind-ar@1.2.5/dist/mindar-image-aframe.prod.js"></script>
        <style>
            /* Forzar a MindAR y A-Frame a cubrir el 100% del contenedor (efecto Fill/Crop) */
            #ar-container video,
            #ar-container canvas {
                width: 100% !important;
                height: 100% !important;
                object-fit: cover !important;
                position: absolute !important;
                top: 0 !important;
                left: 0 !important;
            }
        </style>
        <script>
            document.addEventListener("DOMContentLoaded", function () {
                const sceneEl = document.querySelector('a-scene');
                window.arSystem = null;
                sceneEl.addEventListener('loaded', function () {
                    window.arSystem = sceneEl.systems["mindar-image-system"];
                });
            });
        </script>
    @endpush

    <div class="{{ $classes['page']['container'] }}">

        <!-- Contenedor Principal (Cámara AR) -->
        <div class="{{ $classes['camera']['outer_wrapper'] }}">

            <div id="ar-container"
                class="{{ $classes['camera']['wrapper'] }} relative w-full h-full min-h-[50vh] z-10 overflow-hidden [&>video]:rounded-[2rem] [&>canvas]:rounded-[2rem]">

                <!-- Mensaje de Carga Inicial -->
                <div id="ar-loading-screen"
                    class="absolute inset-0 z-50 bg-[#1a1a1a] flex flex-col items-center justify-center pointer-events-none">
                    <div class="animate-spin rounded-full h-12 w-12 border-b-2 border-[var(--accent)] mb-4"></div>
                    <p class="text-white/60 font-bold animate-pulse text-center px-4">Iniciando Cámara AR y Modelos
                        3D...</p>
                </div>

                {{-- UI Overlay Dinámica 2D (Tarjeta Informativa) --}}
                <div id="team-info-card"
                    class="hidden absolute z-50 top-1/2 left-1/2 min-w-80 transform -translate-x-1/2 -translate-y-1/2 pointer-events-none transition-all duration-300 scale-95 opacity-0">
                    <div
                        class="flex flex-col items-center pointer-events-auto bg-[#111]/90 backdrop-blur-xl border border-white/10 p-6 rounded-2xl shadow-2xl">
                        <div
                            class="w-16 h-16 rounded-full bg-[#222] flex items-center justify-center mb-4 border border-[var(--accent)] p-2">
                            <img id="scanned-shield" src="" alt="Escudo" class="w-full h-full object-contain">
                        </div>
                        <h2 id="scanned-name"
                            class="text-xl font-black text-[var(--accent)] font-montserrat uppercase tracking-widest text-center">
                            ESCANEANDO...</h2>
                        <div class="mt-4 w-full bg-[#222] rounded-lg p-4 flex flex-col gap-2">
                            <p class="text-white/80 text-sm font-bold flex justify-between">
                                <span>🏟️ Estadio:</span>
                                <span id="scanned-stadium" class="text-white text-right">...</span>
                            </p>
                            <p class="text-white/80 text-sm font-bold flex justify-between">
                                <span>🗓️ Fundación:</span>
                                <span id="scanned-formed" class="text-white text-right">...</span>
                            </p>
                            <hr class="border-white/10 my-1">
                            <p id="scanned-data" class="text-white/70 text-xs italic text-center font-medium hidden">...
                            </p>
                        </div>
                        <button onclick="cerrarCard()"
                            class="mt-6 px-6 py-2 bg-[#222] border border-white/10 text-white rounded-full text-sm font-bold shadow-lg hover:bg-[var(--accent)] hover:border-[var(--accent)] hover:text-black transition-all">
                            Cerrar y Ver AR
                        </button>
                    </div>
                </div>

                <!-- Botones SUPERPUESTOS Móvil -->
                <div class="{{ $classes['mobile_ui']['controls_overlay'] }}">
                    <!-- Switch Cam (Rear/Front) -->
                    <button class="{{ $classes['mobile_ui']['switch_btn'] }} ar-btn-switch">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15">
                            </path>
                        </svg>
                    </button>

                    <!-- Reabrir Info Button -->
                    <button id="mobile-info-btn" class="{{ $classes['mobile_ui']['info_btn'] }}"
                        onclick="reabrirCard()">
                        <svg class="w-8 h-8 text-[var(--accent)]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </button>

                    <!-- Espejo / Voltear Cámara -->
                    <button class="{{ $classes['mobile_ui']['flip_btn'] }} ar-btn-flip">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"></path>
                        </svg>
                    </button>
                </div>

                <a-scene embedded style="width: 100%; height: 100%; position: absolute; left: 0; top: 0;"
                    mindar-image="imageTargetSrc: {{ asset('assets/targets-ar/shields-tracker-optimized.mind') }}; uiScanning:no; uiLoading:no; uiError:no; warmupTolerance:1; missTolerance:1;"
                    color-space="sRGB" renderer="colorManagement: true; physicallyCorrectLights: true"
                    vr-mode-ui="enabled: false" device-orientation-permission-ui="enabled: false">

                    <a-light type="ambient" intensity="0.6"></a-light>
                    <a-light type="directional" position="0 4 1" intensity="0.8" color="#d4d4d4"></a-light>

                    <a-assets>
                        <a-asset-item id="avatarModel"
                            src="{{ asset('assets/3d-models/character-idle.glb') }}"></a-asset-item>
                        <img id="avatarTexture" crossorigin="anonymous"
                            src="{{ asset('assets/3d-models/character-texture.png') }}">
                    </a-assets>

                    <a-camera position="0 0 0" look-controls="enabled: false"></a-camera>

                    {{-- Contenedor Maestro Holográfico (Personaje + UI 3D) --}}
                    <a-entity id="avatar-container" visible="false">

                        {{-- Modelo 3D del Mascota --}}
                        <a-gltf-model class="avatar-model" rotation="0 0 0" position="-0.5 -0.5 0" scale="0.8 0.8 0.8"
                            src="#avatarModel" animation-mixer>
                        </a-gltf-model>

                    </a-entity>

                    {{-- Generamos los 110 Targets pero VACÍOS para no saturar memoria --}}
                    @foreach($images as $index => $img)
                        <a-entity mindar-image-target="targetIndex: {{ $index }}" class="ar-target"
                            data-team="{{ str_replace('.jpg', '', $img) }}"></a-entity>
                    @endforeach

                </a-scene>
            </div>
        </div>

        <!-- PANEL LATERAL ESCRITORIO (LG+) -->
        <div class="{{ $classes['sidebar']['container'] }}">
            <div>
                <h2 class="text-2xl font-bold {{ $ui['h2'] }} mb-1">KickCam Pro V2</h2>
                <p class="{{ $ui['text-muted'] }} text-sm font-black uppercase tracking-widest">Escáner Oficial AR</p>
            </div>

            <div class="flex-1"></div> <!-- Spacer -->

            <div class="space-y-4">
                <button class="{{ $classes['desktop_ui']['flip_btn'] }} ar-btn-flip">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"></path>
                    </svg>
                    Voltear Cámara
                </button>
                <button class="{{ $classes['desktop_ui']['flip_btn'] }} ar-btn-switch">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15">
                        </path>
                    </svg>
                    Frontal / Trasera
                </button>
                <button id="desktop-info-btn" class="{{ $classes['desktop_ui']['outline_btn'] }}"
                    onclick="reabrirCard()">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    Ver Info del Equipo
                </button>
            </div>
        </div>
    </div>
    </div> <!-- Close page container flex -->

    @push('scripts')
        <script>
            // --- Variables de Estado ---
            let currentTeamCode = null;
            let currentTeamData = null;

            // Ocultar Tarjeta de UI
            window.cerrarCard = function () {
                const card = document.getElementById('team-info-card');
                card.classList.replace('scale-100', 'scale-95');
                card.classList.replace('opacity-100', 'opacity-0');
                setTimeout(() => card.classList.add('hidden'), 300);
            }

            // Botón para Reabrir Informativa Manualmente
            window.reabrirCard = function () {
                if (currentTeamCode) {
                    mostrarCard(currentTeamCode, currentTeamData);
                }
            }

            // Mostrar Tarjeta de UI
            window.mostrarCard = function (teamCode, data) {
                const card = document.getElementById('team-info-card');
                const img = document.getElementById('scanned-shield');
                const name = document.getElementById('scanned-name');
                const stadium = document.getElementById('scanned-stadium');
                const formed = document.getElementById('scanned-formed');
                const extData = document.getElementById('scanned-data');

                img.src = `/assets/country-teams-shields/${teamCode}.png`;

                if (data) {
                    name.innerText = data.name.toUpperCase();
                    if (stadium) stadium.innerText = data.stadium;
                    if (formed) formed.innerText = data.formed;

                    if (extData && data.data) {
                        extData.innerText = data.data;
                        extData.classList.remove('hidden');
                    } else if (extData) {
                        extData.classList.add('hidden');
                    }
                } else {
                    name.innerText = `CÓDIGO: ${teamCode.toUpperCase()}`;
                    if (stadium) stadium.innerText = "...";
                    if (formed) formed.innerText = "...";
                    if (extData) extData.classList.add('hidden');
                }
                card.classList.remove('hidden');
                // Timeout to allow display block to render before animating transform
                setTimeout(() => {
                    card.classList.replace('scale-95', 'scale-100');
                    card.classList.replace('opacity-0', 'opacity-100');
                }, 50);
            }

            document.addEventListener("DOMContentLoaded", function () {

                // Manejo del Loading Screen
                const sceneEl = document.querySelector('a-scene');
                sceneEl.addEventListener("arReady", (event) => {
                    document.getElementById('ar-loading-screen').classList.add('hidden');
                });

                // Manejo de la textura blanca a colores del personaje (GLTF)
                const texture = new AFRAME.THREE.TextureLoader().load(
                    "{{ asset('assets/3d-models/character-texture.png') }}"
                );
                // GLTF format dictates flipY MUST be false for textures to map correctly over UVs
                texture.flipY = false;
                // Previene que los colores se vean pálidos o lavados en WebGL
                if (AFRAME.THREE.SRGBColorSpace) {
                    texture.colorSpace = AFRAME.THREE.SRGBColorSpace;
                }

                const models = document.querySelectorAll(".avatar-model");
                models.forEach((model) => {
                    model.addEventListener("model-loaded", () => {
                        const mesh = model.getObject3D("mesh");
                        mesh.traverse((node) => {
                            if (node.isMesh) {
                                node.material.map = texture;
                                node.material.color.set(0xffffff);
                                node.material.metalness = 0;
                                node.material.roughness = 1;
                                node.material.needsUpdate = true;
                            }
                        });
                    });
                });

                // Lógica Ultra-Eficiente de Memory Management
                const avatarContainer = document.getElementById('avatar-container');
                const targets = document.querySelectorAll('.ar-target');
                let uiTimeout;

                targets.forEach(target => {
                    target.addEventListener("targetFound", async (event) => {
                        const teamCode = target.getAttribute('data-team');
                        console.log("¡Bandera Detectada!", teamCode);

                        // 1. Mover el modelo 3D al nodo del target a nivel WebGL (Sin tocar el DOM de A-Frame)
                        target.object3D.add(avatarContainer.object3D);
                        avatarContainer.setAttribute('visible', 'true');

                        // 2. Obtener Información del JSON Local y Mostrar la UI
                        try {
                            const response = await fetch(`/assets/data/teams.json`);
                            if (!response.ok) throw new Error('Archivo JSON No Encontrado');

                            const jsonData = await response.json();
                            const data = jsonData[teamCode];

                            if (!data) throw new Error('Equipo no registrado en el JSON Local');

                            console.log("Data JSON Obtenida:", data);

                            currentTeamCode = teamCode;
                            currentTeamData = data;
                            document.getElementById('mobile-info-btn').classList.remove('hidden');
                            document.getElementById('desktop-info-btn').classList.remove('hidden');

                            mostrarCard(teamCode, data);

                            // 3. Ocultar la UI automáticamente después de 8 segundos (ampliado para leer)
                            clearTimeout(uiTimeout);
                            uiTimeout = setTimeout(() => {
                                cerrarCard();
                            }, 8000);

                        } catch (e) {
                            console.warn("No se pudo cargar la info del JSON para AR", e);
                            mostrarCard(teamCode, null);
                        }
                    });

                    target.addEventListener("targetLost", event => {
                        console.log("Bandera Perdida");
                        avatarContainer.setAttribute('visible', 'false');
                        clearTimeout(uiTimeout);
                        cerrarCard();

                        currentTeamCode = null;
                        currentTeamData = null;
                        document.getElementById('mobile-info-btn').classList.add('hidden');
                        document.getElementById('desktop-info-btn').classList.add('hidden');
                    });
                });

            });

            // --- LOGICA DE BOTONES DE CAMARA ---
            const arContainer = document.getElementById('ar-container');

            // Flip (Mirror) Camera and Scene Canvas
            document.querySelectorAll('.ar-btn-flip').forEach(btn => {
                btn.addEventListener('click', () => {
                    arContainer.classList.toggle('scale-x-[-1]');
                });
            });

            // Switch Front / Rear Camera
            document.querySelectorAll('.ar-btn-switch').forEach(btn => {
                btn.addEventListener('click', () => {
                    if (window.arSystem && typeof window.arSystem.switchCamera === 'function') {
                        window.arSystem.switchCamera();
                    } else {
                        alert("No se pudo cambiar de cámara. Es posible que el navegador o dispositivo restrinjan el acceso a cámaras alternativas.");
                    }
                });
            });

        </script>
    @endpush
</x-app-layout>
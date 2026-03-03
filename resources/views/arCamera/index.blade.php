<x-app-layout title="Escáner AR">

    @push('head-scripts')
        <script src="https://aframe.io/releases/1.5.0/aframe.min.js"></script>
        <script src="https://cdn.jsdelivr.net/gh/donmccurdy/aframe-extras@v7.0.0/dist/aframe-extras.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/mind-ar@1.2.5/dist/mindar-image-aframe.prod.js"></script>
        <script>
            document.addEventListener("DOMContentLoaded", function () {
                const sceneEl = document.querySelector('a-scene');
                let arSystem;
                sceneEl.addEventListener('loaded', function () {
                    arSystem = sceneEl.systems["mindar-image-system"];
                });
                // arReady event triggered when ready
                sceneEl.addEventListener("arReady", (event) => {
                    // console.log("MindAR is ready")
                });
                // arError event triggered when something went wrong. Mostly browser compatbility issue
                sceneEl.addEventListener("arError", (event) => {
                    // console.log("MindAR failed to start")
                });
            });
        </script>
    @endpush

    <div class="max-w-5xl mx-auto p-6">

        <h1 class="text-2xl font-bold mb-4">Escáner de Escudos Oficial</h1>

        {{-- UI Overlay Dinámica (Se muestra al escanear un objetivo) --}}
        <div id="team-info-card"
            class="hidden absolute z-50 top-1/2 left-1/2 min-w-80 transform -translate-x-1/2 -translate-y-1/2 bg-[var(--bg-tertiary)]/90 backdrop-blur-xl border border-[var(--border-tertiary)] p-6 rounded-2xl shadow-2xl transition-all duration-300 scale-95 opacity-0">
            <div class="flex flex-col items-center">
                <div
                    class="w-16 h-16 rounded-full bg-[var(--bg-secondary)] flex items-center justify-center mb-4 border border-[var(--border-tertiary)] p-2">
                    <img id="scanned-shield" src="" alt="Escudo" class="w-full h-full object-contain">
                </div>
                <h2 id="scanned-name"
                    class="text-xl font-black text-[var(--accent)] font-montserrat uppercase tracking-widest text-center">
                    ESCANEANDO...</h2>
                <div class="mt-4 w-full bg-[var(--bg-secondary)] rounded-lg p-3 text-center">
                    <p class="text-[var(--text-secondary)] text-sm">Escudo de Equipo Reconocido en Realidad Aumentada
                    </p>
                </div>
                <button onclick="cerrarCard()"
                    class="mt-6 px-6 py-2 bg-[var(--bg-primary)] border border-[var(--border-tertiary)] text-[var(--text-primary)] rounded-full text-sm font-bold shadow-lg hover:bg-[var(--accent)] hover:text-white transition-all">
                    Seguir Escaneando
                </button>
            </div>
        </div>

        {{-- CONTENEDOR DEL RECUADRO AR --}}
        <div
            class="relative w-full aspect-[4/3] md:aspect-video border-4 border-black rounded-xl overflow-hidden shadow-lg bg-black z-10">

            <!-- Mensaje de Carga Inicial -->
            <div id="ar-loading-screen"
                class="absolute inset-0 z-50 bg-[var(--bg-secondary)] flex flex-col items-center justify-center">
                <div class="animate-spin rounded-full h-12 w-12 border-b-2 border-[var(--accent)] mb-4"></div>
                <p class="text-[var(--text-secondary)] font-bold animate-pulse text-center px-4">Iniciando Cámara AR y
                    110 Marcadores...</p>
            </div>

            <a-scene style="width: 100%; height: 100%; position: absolute; left: 0; top: 0; z-index: 20;"
                mindar-image="imageTargetSrc: {{ asset('assets/targets-ar/shields-tracker-optimized.mind') }}; uiScanning:no; uiLoading:no; uiError:no; warmupTolerance:1; missTolerance:1;"
                color-space="sRGB" renderer="colorManagement: true, physicallyCorrectLights" vr-mode-ui="enabled: false"
                device-orientation-permission-ui="enabled: false">

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

                    {{-- Panel Holográfico de Información (Glassmorphism 3D) --}}
                    <a-plane position="0.7 0 0" width="1.4" height="0.8" color="#000000"
                        material="opacity: 0.7; transparent: true" rounded="radius: 0.1">

                        {{-- Contenedor Dinámico de Trofeos 3D --}}
                        <a-entity id="trophies-container" position="0 0 0"></a-entity>

                        {{-- Nombre del Equipo --}}
                        <a-text id="ar-team-name" value="CARGANDO..." position="-0.6 0.25 0.01" color="#FFD700"
                            width="2">
                        </a-text>

                        {{-- Estadio del Equipo --}}
                        <a-text id="ar-stadium" value="..." position="-0.6 0 0.01" color="#FFFFFF" width="1.5">
                        </a-text>

                        {{-- Año de Fundación --}}
                        <a-text id="ar-formed" value="..." position="-0.6 -0.15 0.01" color="#A0AEC0" width="1.5">
                        </a-text>
                    </a-plane>

                </a-entity>

                {{-- Generamos los 110 Targets pero VACÍOS para no saturar memoria --}}
                @foreach($images as $index => $img)
                    <a-entity mindar-image-target="targetIndex: {{ $index }}" class="ar-target"
                        data-team="{{ str_replace('.jpg', '', $img) }}"></a-entity>
                @endforeach

            </a-scene>
        </div>

        @push('scripts')
            <script>
                // Ocultar Tarjeta de UI
                window.cerrarCard = function () {
                    const card = document.getElementById('team-info-card');
                    card.classList.replace('scale-100', 'scale-95');
                    card.classList.replace('opacity-100', 'opacity-0');
                    setTimeout(() => card.classList.add('hidden'), 300);
                }

                // Mostrar Tarjeta de UI
                window.mostrarCard = function (teamCode) {
                    const card = document.getElementById('team-info-card');
                    const img = document.getElementById('scanned-shield');
                    const name = document.getElementById('scanned-name');

                    img.src = `/assets/country-teams-shields/${teamCode}.png`;
                    name.innerText = `CÓDIGO: ${teamCode.toUpperCase()}`;

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

                            // 1. Mover el modelo 3D hijo al nodo del target detectado
                            target.appendChild(avatarContainer);
                            avatarContainer.setAttribute('visible', 'true');

                            // 2. Mostrar la UI inmediatamente con el escudo Local
                            mostrarCard(teamCode);

                            // 3. Ocultar la UI automáticamente después de 3 segundos
                            clearTimeout(uiTimeout);
                            uiTimeout = setTimeout(() => {
                                cerrarCard();
                            }, 3000);

                            // 4. Obtener Información del JSON Local
                            try {
                                const response = await fetch(`/assets/data/teams.json`);
                                if (!response.ok) throw new Error('Archivo JSON No Encontrado');

                                const jsonData = await response.json();
                                const data = jsonData[teamCode];

                                if (!data) throw new Error('Equipo no registrado en el JSON Local');

                                console.log("Data JSON Obtenida:", data);

                                // Actualizar los Textos AR 3D
                                const arName = document.getElementById('ar-team-name');
                                const arStadium = document.getElementById('ar-stadium');
                                const arFormed = document.getElementById('ar-formed');

                                // Removemos mozillavr fallback font issues by rendering native text
                                if (arName) {
                                    arName.setAttribute('value', data.name);
                                }
                                if (arStadium) {
                                    arStadium.setAttribute('value', "ESTADIO: " + data.stadium);
                                }
                                if (arFormed) {
                                    arFormed.setAttribute('value', "FUNDADO: " + data.formed);
                                }

                                // 5. Generar Trofeos 3D Dinámicamente
                                const trophiesContainer = document.getElementById('trophies-container');
                                if (trophiesContainer) {
                                    trophiesContainer.innerHTML = ''; // Limpiar anteriores

                                    const numTrophies = parseInt(data.trophies) || 0;
                                    const spacing = 0.4; // Espacio entre trofeos

                                    // Centramos los trofeos calculando un offset inicial
                                    const startX = -((numTrophies - 1) * spacing) / 2;

                                    for (let i = 0; i < numTrophies; i++) {
                                        // Usamos un primitivo octaedro dorado como placeholder fiable para el trofeo
                                        const trophy = document.createElement('a-entity');
                                        trophy.setAttribute('geometry', 'primitive: octahedron');
                                        trophy.setAttribute('material', 'color: gold; metalness: 0.8; roughness: 0.2');

                                        // Posicionamos los trofeos encima del panel holográfico
                                        trophy.setAttribute('position', `${startX + (i * spacing)} 0.5 0.05`);
                                        trophy.setAttribute('scale', '0.05 0.1 0.05');

                                        // Animación de rotación continua
                                        trophy.setAttribute('animation', 'property: rotation; to: 0 360 0; loop: true; dur: 4000; easing: linear');

                                        trophiesContainer.appendChild(trophy);
                                    }
                                }

                            } catch (e) {
                                console.warn("No se pudo cargar la info del JSON para AR", e);
                            }
                        });

                        target.addEventListener("targetLost", event => {
                            console.log("Bandera Perdida");
                            avatarContainer.setAttribute('visible', 'false');
                            clearTimeout(uiTimeout);
                            cerrarCard();
                        });
                    });

                });
            </script>
        @endpush
</x-app-layout>
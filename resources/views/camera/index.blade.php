@php
    use Illuminate\Support\Facades\File;

    // --- Dynamic Filters Scanning ---
    $faceFiltersDir = public_path('assets/face-tracking-filters');
    $faceFilters = [];
    if (File::exists($faceFiltersDir)) {
        foreach (File::files($faceFiltersDir) as $file) {
            if ($file->getExtension() === 'png') {
                $faceFilters[] = $file->getFilenameWithoutExtension();
            }
        }
    }

    $ballsDir = public_path('assets/wc-balls');
    $wcBalls = [];
    if (File::exists($ballsDir)) {
        foreach (File::files($ballsDir) as $file) {
            if ($file->getExtension() === 'png') {
                $wcBalls[] = $file->getFilename();
            }
        }
    }

    $classes = [
        'page' => [
            'container' => 'h-[calc(100vh-4rem)] sm:h-[calc(100vh-5rem)] w-full flex flex-col lg:flex-row bg-[#0a0a0a] overflow-hidden relative',
        ],
        'camera' => [
            // El wrapper contenedor ahora es más parecido a un celular con padding en móvil
            'outer_wrapper' => 'relative w-full h-full lg:w-3/4 flex flex-col overflow-hidden shrink-0 transition-all duration-300 pt-4 px-4 lg:p-0',
            // El recuadro gris redondeado
            'wrapper' => 'relative w-full flex-1 bg-[#1a1a1a] rounded-[2.5rem] lg:rounded-none flex flex-col justify-center items-center overflow-hidden shrink-0 transition-all duration-300 shadow-2xl border border-white/10 lg:border-none',
            'video' => 'hidden',
            // Visor principal
            'canvas_compositor' => 'absolute inset-0 w-full h-full object-cover',
            'canvas_face' => 'hidden'
        ],
        'sidebar' => [
            'container' => 'hidden lg:flex lg:w-1/4 h-full bg-[#111] border-l border-white/5 flex-col p-6 overflow-y-auto space-y-6',
        ],
        'mobile_ui' => [
            // Carrusel movido afuera y abajo
            'carousel_container' => 'lg:hidden w-full shrink-0 flex flex-col justify-center mt-4 mb-2 h-28',
            'carousel' => 'w-full overflow-x-auto scrollbar-hide flex gap-6 snap-x snap-mandatory px-4 items-center pointer-events-auto',
            'carousel_spacer' => 'min-w-[45vw] shrink-0', // Spacer to allow centering
            'filter_item' => 'snap-center shrink-0 flex flex-col items-center gap-2 cursor-pointer transition-transform duration-300',
            'filter_btn' => 'w-14 h-14 rounded-full border-2 border-white/30 bg-[#222] bg-cover bg-center overflow-hidden transition-all duration-300 shadow-lg',
            'filter_name' => 'text-white/80 text-xs font-medium drop-shadow-md transition-opacity duration-300',
            // Controles flotantes dentro del visor móvil
            'controls_overlay' => 'absolute bottom-6 inset-x-0 w-full px-8 flex justify-between items-center z-10 pointer-events-none lg:hidden',
            'shoot_btn' => 'w-20 h-20 rounded-full border-[5px] border-white/80 flex items-center justify-center p-1.5 cursor-pointer active:scale-95 transition-transform backdrop-blur-sm bg-black/20 mix-blend-screen pointer-events-auto shadow-[0_0_20px_rgba(0,0,0,0.5)]',
            'shoot_btn_inner' => 'w-full h-full rounded-full bg-white transition-all duration-300',
            'flip_btn' => 'w-12 h-12 rounded-full bg-black/40 text-white flex items-center justify-center backdrop-blur-md hover:bg-black/60 transition-colors pointer-events-auto shadow-xl border border-white/10'
        ],
        'desktop_ui' => [
            'btn' => 'w-full py-4 px-6 rounded-xl font-bold flex items-center justify-center gap-2 transition-all active:scale-95 text-white shadow-lg',
            'photo_btn' => 'bg-white text-black hover:bg-gray-200',
            'video_btn' => 'bg-red-500 hover:bg-red-600',
            'flip_btn' => 'w-full py-3 px-6 rounded-lg font-bold flex items-center justify-center gap-2 bg-[#222] text-white hover:bg-[#333] transition-colors border border-white/10',
            'select_wrapper' => 'space-y-3 w-full',
            'label' => 'text-xs font-bold uppercase tracking-wider text-white/50',
            'select' => 'w-full px-4 py-3 rounded-lg border border-white/10 bg-[#1a1a1a] text-white focus:border-white/50 outline-none appearance-none font-medium'
        ]
    ];
@endphp

<x-app-layout title="KickCam Pro V2">
    <!-- Pasar datos PHP a JS de forma segura -->
    <script>
        window.KICKCAM_FACE_FILTERS = @json($faceFilters);
        window.KICKCAM_WC_BALLS = @json($wcBalls);
    </script>

    <div class="{{ $classes['page']['container'] }}">

        <!-- Contenedor Principal Izquierdo -->
        <div class="{{ $classes['camera']['outer_wrapper'] }}">

            <!-- VISUALIZADOR 3D / CAMARA -->
            <div class="{{ $classes['camera']['wrapper'] }}">
                <!-- Elementos Ocultos -->
                <video id="input_video" class="{{ $classes['camera']['video'] }}" autoplay playsinline></video>
                <canvas id="output_face" class="{{ $classes['camera']['canvas_face'] }}"></canvas>

                <!-- Compositor WebGL Final -->
                <canvas id="output_canvas" class="{{ $classes['camera']['canvas_compositor'] }}"></canvas>

                <!-- Recording Indicator (Floating) -->
                <div id="recording-indicator"
                    class="absolute top-6 mx-auto flex items-center hidden bg-black/60 backdrop-blur-md px-4 py-2 rounded-full border border-white/10 shadow-2xl z-20 transition-all">
                    <div
                        class="w-3 h-3 bg-red-500 rounded-full animate-pulse mr-3 shadow-[0_0_10px_rgba(239,68,68,0.8)]">
                    </div>
                    <span id="recording-time" class="text-white font-mono text-sm font-bold tracking-wider">00:00</span>
                </div>

                <!-- Helper Text Overlay -->
                <div
                    class="absolute top-20 text-white/90 text-xs font-medium bg-black/50 px-4 py-1.5 rounded-full backdrop-blur-md shadow-lg pointer-events-none lg:hidden z-20">
                    Apunta con tu rostro
                </div>

                <!-- Botones SUPERPUESTOS en la cámara (Móvil) -->
                <div class="{{ $classes['mobile_ui']['controls_overlay'] }}">
                    <div class="w-12"></div> <!-- Espaciador Izquierdo -->

                    <!-- Botón Shutter Central -->
                    <button id="mobile-shutter" class="{{ $classes['mobile_ui']['shoot_btn'] }}">
                        <div id="mobile-shutter-inner" class="{{ $classes['mobile_ui']['shoot_btn_inner'] }}"></div>
                    </button>

                    <!-- Botón Flip Derecho -->
                    <button id="mobile-flip" class="{{ $classes['mobile_ui']['flip_btn'] }}">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15">
                            </path>
                        </svg>
                    </button>
                </div>
            </div>

            <!-- CARRUSEL DE FILTROS (Móvil: Debajo de la cámara) -->
            <div class="{{ $classes['mobile_ui']['carousel_container'] }}">
                <div id="mobile-carousel" class="{{ $classes['mobile_ui']['carousel'] }}">
                    <div class="{{ $classes['mobile_ui']['carousel_spacer'] }}"></div>
                    <!-- Generado desde JS -->
                    <div class="{{ $classes['mobile_ui']['carousel_spacer'] }}"></div>
                </div>
            </div>
        </div>

        <!-- PANEL LATERAL ESCRITORIO (LG+) -->
        <div class="{{ $classes['sidebar']['container'] }}">
            <div>
                <h2 class="text-2xl font-bold {{ $ui['h2'] }} mb-1">KickCam Pro V2</h2>
                <p class="{{ $ui['text-muted'] }} text-sm">Filtros y Shaders WebGL</p>
            </div>

            <div class="{{ $classes['desktop_ui']['select_wrapper'] }}">
                <label class="{{ $classes['desktop_ui']['label'] }}">Selecciona un Filtro</label>
                <div class="relative">
                    <select id="desktop-filter-select" class="{{ $classes['desktop_ui']['select'] }}">
                        <!-- Opciones dinámicas inyectadas por JS -->
                    </select>
                    <div
                        class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-4 text-secondary-desat">
                        <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                            <path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z" />
                        </svg>
                    </div>
                </div>
            </div>

            <div class="flex-1"></div> <!-- Spacer -->

            <div class="space-y-4">
                <button id="desktop-flip" class="{{ $classes['desktop_ui']['flip_btn'] }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15">
                        </path>
                    </svg>
                    Voltear Cámara
                </button>

                <div class="grid grid-cols-2 gap-3 pt-4 border-t border-tertiary/20">
                    <button id="desktop-photo"
                        class="{{ $classes['desktop_ui']['btn'] }} {{ $classes['desktop_ui']['photo_btn'] }}">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z">
                            </path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        </svg>
                        Foto
                    </button>
                    <!-- El boton de video cambia de estado a "Detener" -->
                    <button id="desktop-video"
                        class="{{ $classes['desktop_ui']['btn'] }} {{ $classes['desktop_ui']['video_btn'] }}">
                        <span id="desktop-video-icon">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z">
                                </path>
                            </svg>
                        </span>
                        <span id="desktop-video-text">Grabar</span>
                    </button>
                </div>
            </div>

        </div>
    </div>


    {{-- =========================
    DEPENDENCIAS DE CAMARA Y 3D
    ========================== --}}
    @push('head-scripts')
        <script type="importmap">
                                                                                        {
                                                                                            "imports": {
                                                                                                "three": "https://unpkg.com/three@0.160.0/build/three.module.js"
                                                                                            }
                                                                                        }
                                                                                    </script>
        <!-- Google MediaPipe (Carga global en window) -->
        <script src="https://cdn.jsdelivr.net/npm/@mediapipe/camera_utils/camera_utils.js" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/@mediapipe/face_mesh/face_mesh.js" crossorigin="anonymous"></script>
    @endpush

    @push('scripts')
        <script type="module">
            import * as THREE from 'three';
            import { uvs, faces } from '/assets/face-data.js';
            const FaceMesh = window.FaceMesh;
            const Camera = window.Camera;

            window.addEventListener("load", async () => {
                // DOM Elements
                const videoElement = document.getElementById('input_video');
                const canvasCompositor = document.getElementById('output_canvas');

                // Indicators
                const recordingIndicator = document.getElementById('recording-indicator');
                const recordingTime = document.getElementById('recording-time');

                // Mobile DOM
                const mobileCarousel = document.getElementById('mobile-carousel');
                const mobileShutter = document.getElementById('mobile-shutter');
                const mobileShutterInner = document.getElementById('mobile-shutter-inner');
                const mobileFlip = document.getElementById('mobile-flip');

                // Desktop DOM
                const desktopSelect = document.getElementById('desktop-filter-select');
                const desktopPhotoBtn = document.getElementById('desktop-photo');
                const desktopVideoBtn = document.getElementById('desktop-video');
                const desktopVideoText = document.getElementById('desktop-video-text');
                const desktopFlip = document.getElementById('desktop-flip');

                // State
                let currentFacingMode = 'user';
                let cameraObj = null;
                let activeFilter = 'none';
                let isRecording = false;
                let mediaRecorder = null;
                let recordedChunks = [];
                let recordStartTime = 0;
                let recordTimerInterval = null;

                // Build Unified Filters List
                const filtersList = [
                    { id: 'none', label: 'Normal', type: 'shader', effect: 0, thumb: 'bg-gray-800' },
                    { id: 'thermal', label: 'Térmico', type: 'shader', effect: 1, thumb: 'bg-gradient-to-tr from-blue-600 via-green-500 to-red-500' },
                    { id: 'pixelate', label: 'Pixelado', type: 'shader', effect: 2, thumb: 'bg-checkerboard bg-gray-600' },
                    { id: 'pastel', label: 'Pastel', type: 'shader', effect: 3, thumb: 'bg-pink-400' },
                    { id: 'blur', label: 'Desenfoque', type: 'shader', effect: 4, thumb: 'bg-gray-400 backdrop-blur-md' },
                    { id: 'confetti', label: 'Balones', type: 'confetti', thumb: 'bg-yellow-400' },
                    { id: 'frame_neon', label: 'Marco Neón', type: 'frame', thumb: 'border-2 border-pink-500 bg-black' }
                ];

                // Inject Face Filters from PHP
                window.KICKCAM_FACE_FILTERS.forEach(country => {
                    filtersList.push({
                        id: `mask_${country}`,
                        label: country.toUpperCase(),
                        type: 'mask',
                        code: country,
                        thumb: `bg-[url(/assets/face-tracking-filters/${country}.png)] bg-contain`
                    });
                });

                // ==========================================
                // THREE.JS WEBGL PIPELINE INITIALIZATION
                // ==========================================
                const renderer = new THREE.WebGLRenderer({ canvas: canvasCompositor, alpha: false, antialias: true, preserveDrawingBuffer: true });
                renderer.autoClear = false;

                // 1. Background Scene (Video + Shaders)
                const bgScene = new THREE.Scene();
                const bgCamera = new THREE.OrthographicCamera(-1, 1, 1, -1, 0, 1);
                const videoTexture = new THREE.VideoTexture(videoElement);
                videoTexture.minFilter = THREE.LinearFilter;
                videoTexture.magFilter = THREE.LinearFilter;
                videoTexture.format = THREE.RGBAFormat;

                const bgShaderMaterial = new THREE.ShaderMaterial({
                    uniforms: {
                        tDiffuse: { value: videoTexture },
                        u_effectType: { value: 0 },
                        u_resolution: { value: new THREE.Vector2(window.innerWidth, window.innerHeight) },
                        u_videoResolution: { value: new THREE.Vector2(1280, 720) },
                        u_isUserFacing: { value: 1.0 }
                    },
                    vertexShader: `
                                                                    varying vec2 vUv;
                                                                    uniform float u_isUserFacing;
                                                                    void main() {
                                                                        vUv = uv;
                                                                        if(u_isUserFacing > 0.5) vUv.x = 1.0 - vUv.x; // Mirror for selfie
                                                                        gl_Position = vec4(position, 1.0);
                                                                    }
                                                                `,
                    fragmentShader: `
                                                                            uniform sampler2D tDiffuse;
                                                                            uniform int u_effectType;
                                                                            uniform vec2 u_resolution;
                                                                            uniform vec2 u_videoResolution;
                                                                            varying vec2 vUv;

                                                                            void main() {
                                                                                vec2 uv = vUv;

                                                                                // Object-Fit Cover Logic en Shader puro
                                                                                float rs = u_resolution.x / u_resolution.y;
                                                                                float vs = u_videoResolution.x / u_videoResolution.y;

                                                                                if (rs > vs) {
                                                                                    float scale = vs / rs; 
                                                                                    uv.y = (uv.y - 0.5) * scale + 0.5;
                                                                                } else {
                                                                                    float scale = rs / vs;
                                                                                    uv.x = (uv.x - 0.5) * scale + 0.5;
                                                                                }

                                                                                if(uv.x < 0.0 || uv.x > 1.0 || uv.y < 0.0 || uv.y > 1.0) {
                                                                                    gl_FragColor = vec4(0.0, 0.0, 0.0, 1.0);
                                                                                    return;
                                                                                }

                                                                                // Pixelate
                                                                                if(u_effectType == 2) {
                                                                                    float pixels = 60.0;
                                                                                    uv = floor(uv * pixels) / pixels;
                                                                                }

                                                                                vec4 texel = texture2D(tDiffuse, uv);

                                                                                // Thermal
                                                                                if(u_effectType == 1) {
                                                                                    float lum = dot(texel.rgb, vec3(0.299, 0.587, 0.114));
                                                                                    vec3 heat;
                                                                                    if(lum < 0.33) heat = mix(vec3(0,0,1), vec3(0,1,0), lum/0.33);
                                                                                    else if(lum < 0.66) heat = mix(vec3(0,1,0), vec3(1,1,0), (lum-0.33)/0.33);
                                                                                    else heat = mix(vec3(1,1,0), vec3(1,0,0), (lum-0.66)/0.34);
                                                                                    texel.rgb = heat;
                                                                                }
                                                                                // Pastel
                                                                                else if(u_effectType == 3) {
                                                                                    vec3 p = texel.rgb;
                                                                                    texel.r = dot(p, vec3(0.393, 0.769, 0.189)) * 1.3;
                                                                                    texel.g = dot(p, vec3(0.349, 0.686, 0.168)) * 1.1;
                                                                                    texel.b = dot(p, vec3(0.272, 0.534, 0.131)) * 1.3;
                                                                                }
                                                                                // Blur
                                                                                else if(u_effectType == 4) {
                                                                                    vec2 offset = 4.0 / u_resolution;
                                                                                    vec4 sum = vec4(0.0);
                                                                                    sum += texture2D(tDiffuse, uv + vec2(-offset.x, -offset.y)) * 0.11;
                                                                                    sum += texture2D(tDiffuse, uv + vec2(0.0, -offset.y)) * 0.11;
                                                                                    sum += texture2D(tDiffuse, uv + vec2(offset.x, -offset.y)) * 0.11;
                                                                                    sum += texture2D(tDiffuse, uv + vec2(-offset.x, 0.0)) * 0.11;
                                                                                    sum += texture2D(tDiffuse, uv) * 0.12;
                                                                                    sum += texture2D(tDiffuse, uv + vec2(offset.x, 0.0)) * 0.11;
                                                                                    sum += texture2D(tDiffuse, uv + vec2(-offset.x, offset.y)) * 0.11;
                                                                                    sum += texture2D(tDiffuse, uv + vec2(0.0, offset.y)) * 0.11;
                                                                                    sum += texture2D(tDiffuse, uv + vec2(offset.x, offset.y)) * 0.11;
                                                                                    texel = sum;
                                                                                }

                                                                                gl_FragColor = texel;
                                                                            }
                                                                        `
                });
                const bgPlane = new THREE.Mesh(new THREE.PlaneGeometry(2, 2), bgShaderMaterial);
                bgScene.add(bgPlane);

                // 2. Foreground Scene (FaceMesh + Confetti + Frames)
                const fgScene = new THREE.Scene();
                const fgCamera = new THREE.OrthographicCamera(-1, 1, 1, -1, 0.1, 10);
                fgCamera.position.z = 1;

                // --- Face Mash Setup ---
                const textureLoader = new THREE.TextureLoader();
                const faceMaterial = new THREE.MeshBasicMaterial({ transparent: true, opacity: 1, side: THREE.DoubleSide });

                const faceGeometry = new THREE.BufferGeometry();
                faceGeometry.setIndex(faces);
                const uvArray = new Float32Array(468 * 2);
                for (let i = 0; i < 468; i++) {
                    uvArray[i * 2] = 1.0 - uvs[i][0]; // Flip texture X horizontally
                    uvArray[i * 2 + 1] = uvs[i][1];
                }
                faceGeometry.setAttribute('uv', new THREE.BufferAttribute(uvArray, 2));

                const positionArray = new Float32Array(468 * 3);
                const positionAttribute = new THREE.BufferAttribute(positionArray, 3);
                faceGeometry.setAttribute('position', positionAttribute);

                const faceMeshObj = new THREE.Mesh(faceGeometry, faceMaterial);
                faceMeshObj.visible = false;
                fgScene.add(faceMeshObj);
                const faceTextureCache = new Map();

                // --- Confetti / Particle Setup ---
                const numConfetti = 50;
                const confettiGeom = new THREE.PlaneGeometry(0.15, 0.15);
                const confettiMats = [];
                // Load balls as textures
                if (window.KICKCAM_WC_BALLS && window.KICKCAM_WC_BALLS.length > 0) {
                    window.KICKCAM_WC_BALLS.forEach(ball => {
                        const tex = textureLoader.load('/assets/wc-balls/' + ball);
                        tex.colorSpace = THREE.SRGBColorSpace;
                        confettiMats.push(new THREE.MeshBasicMaterial({ map: tex, transparent: true }));
                    });
                } else {
                    confettiMats.push(new THREE.MeshBasicMaterial({ color: 0xffd700 })); // Fallback
                }

                const confettiGroup = new THREE.Group();
                const confettiParticles = [];
                for (let i = 0; i < numConfetti; i++) {
                    const mat = confettiMats[Math.floor(Math.random() * confettiMats.length)];
                    const mesh = new THREE.Mesh(confettiGeom, mat);
                    mesh.position.set((Math.random() - 0.5) * 2, Math.random() * 2 + 1, 0); // Start above top
                    mesh.userData = {
                        speedY: Math.random() * 0.02 + 0.01,
                        speedRot: (Math.random() - 0.5) * 0.1,
                        xOff: Math.random() * Math.PI * 2,
                        xAmp: Math.random() * 0.005
                    };
                    confettiParticles.push(mesh);
                    confettiGroup.add(mesh);
                }
                confettiGroup.visible = false;
                fgScene.add(confettiGroup);

                // --- Frames Setup ---
                // Simple placeholder frame (Neon borders) generated dynamically via canvas
                const frameCanvas = document.createElement('canvas');
                frameCanvas.width = 512; frameCanvas.height = 1024;
                const fctx = frameCanvas.getContext('2d');
                fctx.strokeStyle = '#ff00ff'; fctx.lineWidth = 20;
                fctx.strokeRect(10, 10, 492, 1004);
                fctx.strokeStyle = '#00ffff'; fctx.lineWidth = 10;
                fctx.strokeRect(10, 10, 492, 1004);

                const frameTex = new THREE.CanvasTexture(frameCanvas);
                const frameMat = new THREE.MeshBasicMaterial({ map: frameTex, transparent: true });
                const frameMesh = new THREE.Mesh(new THREE.PlaneGeometry(2, 2), frameMat);
                frameMesh.visible = false;
                fgScene.add(frameMesh);

                let videoDrawW = 2;
                let videoDrawH = 2;

                // Resize Handling
                function resizeCanvases() {
                    const rect = canvasCompositor.parentElement.getBoundingClientRect();
                    if (rect.width === 0 || rect.height === 0) return;

                    canvasCompositor.width = rect.width;
                    canvasCompositor.height = rect.height;
                    renderer.setSize(rect.width, rect.height, false);

                    bgShaderMaterial.uniforms.u_resolution.value.set(rect.width, rect.height);

                    // bgCamera es 1:1 estático. El shader recorta para arreglar "aplastado"
                    bgCamera.left = -1; bgCamera.right = 1; bgCamera.top = 1; bgCamera.bottom = -1;
                    bgCamera.updateProjectionMatrix();

                    // fgCamera REQUIERE aspecto real para que el Confeti/Malla no se aplasten
                    const aspect = rect.width / rect.height;
                    fgCamera.left = -aspect;
                    fgCamera.right = aspect;
                    fgCamera.top = 1;
                    fgCamera.bottom = -1;
                    fgCamera.updateProjectionMatrix();

                    frameMesh.scale.set(aspect, 1, 1);

                    // Calcular Draw Constraints Exactos de MediaPipe
                    if (videoElement.videoWidth && videoElement.videoHeight) {
                        bgShaderMaterial.uniforms.u_videoResolution.value.set(videoElement.videoWidth, videoElement.videoHeight);
                        const vRatio = videoElement.videoWidth / videoElement.videoHeight;

                        if (aspect > vRatio) {
                            videoDrawW = 2 * aspect;
                            videoDrawH = (2 * aspect) / vRatio;
                        } else {
                            videoDrawH = 2;
                            videoDrawW = 2 * vRatio;
                        }
                    }
                }
                window.addEventListener('resize', resizeCanvases);
                window.addEventListener('orientationchange', () => setTimeout(resizeCanvases, 100));
                videoElement.addEventListener('loadedmetadata', resizeCanvases);

                // ==========================================
                // MEDIAPIPE FACE MESH INTEGRATION
                // ==========================================
                const mpFaceMesh = new FaceMesh({
                    locateFile: (file) => `https://cdn.jsdelivr.net/npm/@mediapipe/face_mesh/${file}`
                });

                mpFaceMesh.setOptions({
                    maxNumFaces: 1,
                    refineLandmarks: false,
                    minDetectionConfidence: 0.5,
                    minTrackingConfidence: 0.5
                });

                mpFaceMesh.onResults((results) => {
                    const activeObj = filtersList.find(f => f.id === activeFilter);

                    if (results.multiFaceLandmarks && results.multiFaceLandmarks.length > 0 && activeObj && activeObj.type === 'mask') {
                        const landmarks = results.multiFaceLandmarks[0];

                        let flipX = currentFacingMode === 'user' ? -1 : 1;

                        // Transformación Geométrica Real 3D (Mapeando Puntos Individuales a Aspect Ratio de cámara)
                        for (let i = 0; i < 468; i++) {
                            const pt = landmarks[i];
                            // Mapeo Ortográfico Perfecto desde Coordenadas MediaPipe a nuestro bounding box WebGL
                            let vx = (-videoDrawW / 2) + pt.x * videoDrawW;
                            let vy = (videoDrawH / 2) - pt.y * videoDrawH; // WebGL Y is inverted
                            // El Z determina la profundidad 3D de la nariz, pómulos, etc (es un factor dependiente del ancho de cámara en MediaPipe)
                            let vz = -pt.z * videoDrawW;

                            positionArray[i * 3] = vx * flipX;
                            positionArray[i * 3 + 1] = vy;
                            positionArray[i * 3 + 2] = vz;
                        }

                        // Avisar a Three.JS que los vértices del modelo se movieron este frame
                        positionAttribute.needsUpdate = true;

                        // Reseteamos el Objeto, la geometría internamente ya porta su posición, inclinación, y rotación global perfecta
                        faceMeshObj.position.set(0, 0, 0);
                        faceMeshObj.rotation.set(0, 0, 0);
                        faceMeshObj.visible = true;
                    } else {
                        faceMeshObj.visible = false;
                    }
                });

                // ==========================================
                // RENDER LOOP
                // ==========================================
                function animate() {
                    requestAnimationFrame(animate);

                    // Animate Confetti if active
                    if (confettiGroup.visible) {
                        confettiParticles.forEach(p => {
                            p.position.y -= p.userData.speedY; // Fall down
                            p.position.x += Math.sin(Date.now() * 0.005 + p.userData.xOff) * p.userData.xAmp;
                            p.rotation.z += p.userData.speedRot;
                            // Recycle
                            if (p.position.y < -1.2) p.position.y = 1.2;
                        });
                    }

                    // Render Bg (Video + Shader) then Fg (Mask, Confetti, Frames)
                    renderer.clear();
                    renderer.render(bgScene, bgCamera);
                    renderer.clearDepth();
                    renderer.render(fgScene, fgCamera);
                }
                animate();

                // ==========================================
                // UI LOGIC & FILTER MANAGEMENT
                // ==========================================
                function applyFilter(id) {
                    activeFilter = id;
                    const f = filtersList.find(x => x.id === id);

                    // Deactivate all features first
                    bgShaderMaterial.uniforms.u_effectType.value = 0;
                    faceMaterial.map = null;
                    faceMeshObj.visible = false;
                    confettiGroup.visible = false;
                    frameMesh.visible = false;

                    if (!f) return;

                    // Apply Shader
                    if (f.type === 'shader') {
                        bgShaderMaterial.uniforms.u_effectType.value = f.effect;
                    }
                    // Apply Face Mask
                    else if (f.type === 'mask') {
                        if (!faceTextureCache.has(f.code)) {
                            textureLoader.load(`/assets/face-tracking-filters/${f.code}.png`, tex => {
                                tex.colorSpace = THREE.SRGBColorSpace;
                                faceTextureCache.set(f.code, tex);
                                faceMaterial.map = tex;
                                faceMaterial.needsUpdate = true;
                            });
                        } else {
                            faceMaterial.map = faceTextureCache.get(f.code);
                            faceMaterial.needsUpdate = true;
                        }
                    }
                    // Apply Confetti
                    else if (f.type === 'confetti') {
                        confettiGroup.visible = true;
                    }
                    // Apply Frame
                    else if (f.type === 'frame') {
                        frameMesh.visible = true;
                    }

                    // Sync Select
                    desktopSelect.value = id;

                    // Sync Mobile UI sizes
                    document.querySelectorAll('.filter-item-btn').forEach(btn => {
                        if (btn.dataset.id === id) {
                            btn.classList.add('w-20', 'h-20', 'border-4', 'border-white', 'shadow-[0_0_15px_rgba(255,255,255,0.8)]');
                            btn.classList.remove('w-14', 'h-14', 'border-2', 'border-white/50', 'shadow-lg');
                        } else {
                            btn.classList.remove('w-20', 'h-20', 'border-4', 'border-white', 'shadow-[0_0_15px_rgba(255,255,255,0.8)]');
                            btn.classList.add('w-14', 'h-14', 'border-2', 'border-white/50', 'shadow-lg');
                        }
                    });
                }

                // Populate Desktop Select
                filtersList.forEach(f => {
                    const option = document.createElement('option');
                    option.value = f.id;
                    option.textContent = f.label;
                    desktopSelect.appendChild(option);
                });
                desktopSelect.addEventListener('change', (e) => applyFilter(e.target.value));

                // Populate Mobile Carousel
                filtersList.forEach((f, idx) => {
                    const wrapper = document.createElement('div');
                    wrapper.className = "{{ $classes['mobile_ui']['filter_item'] }}";

                    const btn = document.createElement('button');
                    btn.className = `filter-item-btn {{ $classes['mobile_ui']['filter_btn'] }} ${f.thumb}`;
                    btn.dataset.id = f.id;

                    const label = document.createElement('span');
                    label.className = "{{ $classes['mobile_ui']['filter_name'] }}";
                    label.textContent = f.label;

                    wrapper.appendChild(btn);
                    wrapper.appendChild(label);

                    // Insert before the last spacer
                    mobileCarousel.insertBefore(wrapper, mobileCarousel.children[mobileCarousel.children.length - 1]);

                    // Click selects it and centers it
                    wrapper.addEventListener('click', () => {
                        wrapper.scrollIntoView({ behavior: 'smooth', inline: 'center', block: 'nearest' });
                    });
                });

                // Auto Select on Scroll (Intersection Observer for Center)
                const observerOptions = {
                    root: mobileCarousel,
                    rootMargin: '0px -50% 0px -50%', // strict center line
                    threshold: 0
                };
                const centerObserver = new IntersectionObserver((entries) => {
                    entries.forEach(entry => {
                        if (entry.isIntersecting) {
                            const btn = entry.target.querySelector('.filter-item-btn');
                            if (btn) applyFilter(btn.dataset.id);
                        }
                    });
                }, observerOptions);

                mobileCarousel.querySelectorAll('.snap-center').forEach(el => centerObserver.observe(el));

                // Initialize with first filter
                applyFilter(filtersList[0].id);


                // ==========================================
                // CAMERA INITIALIZATION
                // ==========================================
                function startCamera() {
                    if (cameraObj) cameraObj.stop();
                    bgShaderMaterial.uniforms.u_isUserFacing.value = currentFacingMode === 'user' ? 1.0 : 0.0;

                    cameraObj = new Camera(videoElement, {
                        onFrame: async () => {
                            try {
                                // Update scale on first frame
                                resizeCanvases();
                                await mpFaceMesh.send({ image: videoElement });
                            } catch (e) { }
                        },
                        width: 1280,
                        height: 720,
                        facingMode: currentFacingMode
                    });
                    cameraObj.start();
                }

                const handleFlip = () => {
                    currentFacingMode = currentFacingMode === 'user' ? 'environment' : 'user';
                    startCamera();
                };
                mobileFlip.addEventListener('click', handleFlip);
                desktopFlip.addEventListener('click', handleFlip);

                startCamera();

                // ==========================================
                // RECORDING & SNAPSHOTS (DESKTOP & MOBILE)
                // ==========================================
                function flashScreen() {
                    const flash = document.createElement('div');
                    flash.className = 'absolute inset-0 bg-white z-50 opacity-100 transition-opacity duration-300 pointer-events-none';
                    canvasCompositor.parentElement.appendChild(flash);
                    setTimeout(() => flash.classList.add('opacity-0'), 50);
                    setTimeout(() => flash.remove(), 350);
                }

                function takePhoto() {
                    renderer.render(bgScene, bgCamera);
                    renderer.clearDepth();
                    renderer.render(fgScene, fgCamera); // Ensure latest frame rendered

                    const dataUrl = canvasCompositor.toDataURL('image/jpeg', 0.9);
                    const a = document.createElement('a');
                    a.href = dataUrl;
                    a.download = `kickcam_pro_${Date.now()}.jpg`;
                    a.click();
                    flashScreen();
                }

                function updateTimer() {
                    if (!isRecording) return;
                    const diff = Math.floor((Date.now() - recordStartTime) / 1000);
                    const m = String(Math.floor(diff / 60)).padStart(2, '0');
                    const s = String(diff % 60).padStart(2, '0');
                    recordingTime.textContent = `${m}:${s}`;
                }

                function startRecording() {
                    if (isRecording) return;
                    isRecording = true;
                    recordedChunks = [];
                    recordStartTime = Date.now();
                    recordingIndicator.classList.remove('hidden');
                    recordTimerInterval = setInterval(updateTimer, 1000);
                    updateTimer();

                    // Update UI Buttons
                    mobileShutterInner.classList.add('scale-50', 'bg-red-500', 'rounded-lg');
                    desktopVideoText.textContent = "Detener";
                    desktopVideoBtn.classList.replace('bg-red-500', 'bg-gray-800');

                    const stream = canvasCompositor.captureStream(30);
                    try {
                        mediaRecorder = new MediaRecorder(stream, { mimeType: 'video/webm; codecs=vp9' });
                    } catch (e) {
                        mediaRecorder = new MediaRecorder(stream);
                    }

                    mediaRecorder.ondataavailable = (e) => {
                        if (e.data.size > 0) recordedChunks.push(e.data);
                    };

                    mediaRecorder.onstop = () => {
                        const blob = new Blob(recordedChunks, { type: 'video/webm' });
                        const url = URL.createObjectURL(blob);
                        const a = document.createElement('a');
                        a.href = url;
                        a.download = `kickcam_pro_${Date.now()}.webm`;
                        a.click();
                        URL.revokeObjectURL(url);
                    };

                    mediaRecorder.start();
                }

                function stopRecording() {
                    if (!isRecording) return;
                    isRecording = false;
                    clearInterval(recordTimerInterval);
                    recordingIndicator.classList.add('hidden');

                    // Reset UI Buttons
                    mobileShutterInner.classList.remove('scale-50', 'bg-red-500', 'rounded-lg');
                    desktopVideoText.textContent = "Grabar";
                    desktopVideoBtn.classList.replace('bg-gray-800', 'bg-red-500');

                    if (mediaRecorder && mediaRecorder.state !== 'inactive') {
                        mediaRecorder.stop();
                    }
                }

                // Desktop Bindings
                desktopPhotoBtn.addEventListener('click', takePhoto);
                desktopVideoBtn.addEventListener('click', () => {
                    isRecording ? stopRecording() : startRecording();
                });

                // Mobile Multi-Touch Shutter
                let pressTimer;
                const startPress = (e) => {
                    e.preventDefault();
                    pressTimer = setTimeout(() => {
                        startRecording();
                    }, 400); // 400ms threshold for video
                };

                const endPress = (e) => {
                    e.preventDefault();
                    clearTimeout(pressTimer);
                    if (isRecording) {
                        stopRecording();
                    } else {
                        takePhoto();
                    }
                };

                mobileShutter.addEventListener('mousedown', startPress);
                mobileShutter.addEventListener('mouseup', endPress);
                mobileShutter.addEventListener('mouseleave', () => {
                    clearTimeout(pressTimer);
                    if (isRecording) stopRecording();
                });

                mobileShutter.addEventListener('touchstart', startPress, { passive: false });
                mobileShutter.addEventListener('touchend', endPress, { passive: false });
            });
        </script>
    @endpush

</x-app-layout>
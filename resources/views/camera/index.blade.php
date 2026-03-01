<!-- <x-general-layout title="Camara KickCamApp">

    @push('head-scripts')
    <script type="importmap">
        {
            "imports": {
                "three": "https://unpkg.com/three@0.160.0/build/three.module.js",
                "three/addons/": "https://unpkg.com/three@0.160.0/examples/jsm/",
                "mindar-face-three": "https://cdn.jsdelivr.net/npm/mind-ar@1.2.5/dist/mindar-face-three.prod.js"
            }
        }
    </script>
    @endpush

    <div class="">
        <h1 class="">KickCam Pro</h1>
        <p class="">Filtros AR en tiempo real</p>
    </div>

    <div id="container" class="relative w-full max-w-[640px] aspect-video rounded-xl overflow-hidden shadow-2xl mx-auto">
        <button id="capture-button" disabled
            class="absolute bottom-4 left-1/2 -translate-x-1/2 bg-red-600 hover:bg-red-700 text-white font-bold px-6 py-2 rounded-full shadow-lg z-20 transition-all active:scale-95 disabled:opacity-50">
            FOTO
        </button>
    </div>

    <div class="flex flex-wrap justify-center gap-4 mt-6">
        <div class="flex flex-col">
            <label class="text-xs font-bold uppercase text-gray-500 ml-1">Filtro de Color</label>
            <select id="filter" class="px-4 py-2 border-2 border-gray-300 rounded-lg shadow-sm focus:border-blue-500 outline-none">
                <option value="none">Sin filtro</option>
                <option value="pastel">Pastel (Suave)</option>
                <option value="boost">Color Intenso</option>
                <option value="thermal">Efecto Térmico</option>
            </select>
        </div>

        <div class="flex flex-col">
            <label class="text-xs font-bold uppercase text-gray-500 ml-1">Máscara País</label>
            <select id="country" class="px-4 py-2 border-2 border-gray-300 rounded-lg shadow-sm focus:border-blue-500 outline-none">
                <option value="">Sin máscara</option>
                <option value="mx">México</option>
                <option value="ar">Argentina</option>
                <option value="bz">Brasil</option>
            </select>
        </div>

        <button id="download-btn" class="self-end bg-green-600 hover:bg-green-700 text-white px-6 py-2 rounded-lg shadow-lg transition-colors">
            Guardar
        </button>
    </div>

    <div class="text-center mt-10">
        <h2 class="text-lg font-semibold mb-2">Resultado:</h2>
        <img id="photo" class="mx-auto rounded-lg shadow-lg max-w-full border-2 border-dashed border-gray-400 p-1" src="data:image/gif;base64,R0lGODlhAQABAIAAAAAAAP///yH5BAEAAAAALAAAAAABAAEAAAIBRAA7" />
    </div>

    @push('scripts')
    <script type="module">
        import * as THREE from 'three';
        import {
            MindARThree
        } from 'mindar-face-three';

        let mindarThree, renderer, scene, camera;
        let faceMesh;

        const container = document.querySelector("#container");
        const captureButton = document.getElementById("capture-button");

        async function startAR() {

            mindarThree = new MindARThree({
                container,
                renderer: {
                    preserveDrawingBuffer: true
                }
            });

            ({
                renderer,
                scene,
                camera
            } = mindarThree);

            const light = new THREE.HemisphereLight(0xffffff, 0xbbbbff, 1);
            scene.add(light);

            faceMesh = mindarThree.addFaceMesh();

            let texture = new THREE.TextureLoader().load(
                "{{ asset('assets/face-tracking-filters/mx.png') }}"
            );

            faceMesh.material = new THREE.MeshBasicMaterial({
                map: texture,
                transparent: true
            });

            await mindarThree.start();
            captureButton.disabled = false;

            renderer.setAnimationLoop(() => {
                renderer.render(scene, camera);
            });
        }

        startAR();

        /* =============================
           FILTROS CSS (GLOBAL REAL)
        ============================= */

        const filterStyles = {
            none: "none",
            pastel: "brightness(1.05) contrast(0.9) saturate(0.7)",
            boost: "brightness(1.05) contrast(1.3) saturate(1.8)",
            blur: "blur(4px)",
            thermal: "contrast(1.5) saturate(3)"
        };

        document.getElementById("filter").addEventListener("change", e => {
            container.style.filter = filterStyles[e.target.value] || "none";
        });

        /* =============================
           CAPTURA REAL
        ============================= */

        captureButton.addEventListener("click", () => {

            container.style.transform = "scale(0.95)";
            setTimeout(() => container.style.transform = "scale(1)", 150);

            const video = mindarThree.video;
            const canvas = renderer.domElement;

            const captureCanvas = document.createElement("canvas");
            captureCanvas.width = canvas.width;
            captureCanvas.height = canvas.height;

            const ctx = captureCanvas.getContext("2d");

            ctx.drawImage(video, 0, 0, captureCanvas.width, captureCanvas.height);
            ctx.drawImage(canvas, 0, 0);

            const dataURL = captureCanvas.toDataURL("image/png");
            document.getElementById("photo").src = dataURL;
        });

        /* =============================
           DESCARGA
        ============================= */

        document.getElementById("download-btn").addEventListener("click", () => {
            const photo = document.getElementById("photo");
            if (!photo.src) return;

            const link = document.createElement("a");
            link.href = photo.src;
            link.download = "kickcam-{{ date('d-m-Y') }}.png";
            link.click();
        });
    </script>
    @endpush

    <style>
        #container video {
            border-radius: 0.75rem;
        }

        .brightness-150 {
            filter: brightness(1.5);
            transition: filter 0.1s;
        }
    </style>
</x-general-layout> -->

@php
    $classes = [
        'page' => [
            'header' => 'text-center mb-6',
            'title' => "{$ui['h2']} font-bold",
            'subtitle' => $ui['text-muted']
        ],
        'camera' => [
            'container' => 'relative w-full max-w-[640px] aspect-video rounded-xl overflow-hidden shadow-2xl mx-auto border border-tertiary bg-primary'
        ],
        'controls' => [
            'wrapper' => 'flex flex-col items-center mt-6',
            'label' => 'text-xs font-bold uppercase text-secondary-desat mb-2',
            'select' => 'px-4 py-2 border-2 border-tertiary-sat rounded-lg shadow-sm focus:border-accent outline-none w-full max-w-[400px] bg-primary text-secondary'
        ]
    ];
@endphp

<x-general-layout title="KickCam Pro">

    {{-- =========================
    IMPORTMAP (SOLO ESTO EN HEAD)
    ========================== --}}
    @push('head-scripts')
        <script type="importmap">
            {
            "imports": {
                "three": "https://unpkg.com/three@0.160.0/build/three.module.js",
                "mindar-face-three": "https://cdn.jsdelivr.net/npm/mind-ar@1.2.5/dist/mindar-face-three.prod.js"
            }
        }
        </script>
    @endpush


    {{-- =========================
    UI
    ========================== --}}
    <div class="{{ $classes['page']['header'] }}">
        <h1 class="{{ $classes['page']['title'] }}">KickCam Pro</h1>
        <p class="{{ $classes['page']['subtitle'] }}">Filtros AR en tiempo real</p>
    </div>

    <div id="container" class="{{ $classes['camera']['container'] }}">
    </div>

    <div class="{{ $classes['controls']['wrapper'] }}">
        <label class="{{ $classes['controls']['label'] }}">
            Máscara País
        </label>

        <select id="country" class="{{ $classes['controls']['select'] }}">

            <option value="">Sin máscara</option>

            @foreach(\App\Enums\CountryEnum::cases() as $country)
                <option value="{{ $country->value }}">
                    {{ ucfirst(strtolower(str_replace('_', ' ', $country->name))) }}
                </option>
            @endforeach

        </select>
    </div>


    @push('scripts')
        <script type="module">
            import * as THREE from 'three';
            import {
                MindARThree
            } from 'mindar-face-three';

            window.addEventListener("load", async () => {

                const select = document.getElementById("country");
                const container = document.querySelector("#container");

                if (!select || !container) return;

                const mindarThree = new MindARThree({
                    container
                });
                const {
                    renderer,
                    scene,
                    camera
                } = mindarThree;

                renderer.setPixelRatio(Math.min(window.devicePixelRatio, 2));
                renderer.outputColorSpace = THREE.SRGBColorSpace;

                const light = new THREE.HemisphereLight(0xffffff, 0xbbbbff, 1);
                scene.add(light);

                const faceMesh = mindarThree.addFaceMesh();
                faceMesh.material = new THREE.MeshBasicMaterial({
                    transparent: true,
                    opacity: 1
                });

                await mindarThree.start();

                renderer.setAnimationLoop(() => {
                    renderer.render(scene, camera);
                });

                const textureLoader = new THREE.TextureLoader();
                const textureCache = new Map();

                select.addEventListener("change", async (e) => {

                    const code = e.target.value;

                    if (!code) {
                        faceMesh.material.map = null;
                        faceMesh.material.needsUpdate = true;
                        return;
                    }

                    if (!textureCache.has(code)) {
                        textureLoader.load(
                            `/assets/face-tracking-filters/${code}.png`,
                            texture => {
                                texture.colorSpace = THREE.SRGBColorSpace;
                                textureCache.set(code, texture);
                                faceMesh.material.map = texture;
                                faceMesh.material.needsUpdate = true;
                            }
                        );
                    } else {
                        faceMesh.material.map = textureCache.get(code);
                        faceMesh.material.needsUpdate = true;
                    }

                });

            });
        </script>
    @endpush

</x-general-layout>
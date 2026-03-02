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
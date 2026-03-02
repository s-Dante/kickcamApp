<x-general-layout title="Escáner AR">

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
                const exampleTarget = document.querySelector('#example-target');
                const examplePlane = document.querySelector('#example-plane');
                const startButton = document.querySelector("#example-start-button");
                const stopButton = document.querySelector("#example-stop-button");
                const pauseButton = document.querySelector("#example-pause-button");
                const pauseKeepVideoButton = document.querySelector("#example-pause-keep-video-button");
                const unpauseButton = document.querySelector("#example-unpause-button");
                startButton.addEventListener('click', () => {
                    console.log("start");
                    arSystem.start(); // start AR 
                });
                stopButton.addEventListener('click', () => {
                    arSystem.stop(); // stop AR 
                });
                pauseButton.addEventListener('click', () => {
                    arSystem.pause(); // pause AR, pause video
                });
                pauseKeepVideoButton.addEventListener('click', () => {
                    arSystem.pause(true); // pause AR, keep video
                });
                unpauseButton.addEventListener('click', () => {
                    arSystem.unpause(); // unpause AR and video
                });
                // arReady event triggered when ready
                sceneEl.addEventListener("arReady", (event) => {
                    // console.log("MindAR is ready")
                });
                // arError event triggered when something went wrong. Mostly browser compatbility issue
                sceneEl.addEventListener("arError", (event) => {
                    // console.log("MindAR failed to start")
                });
                // detect target found
                exampleTarget.addEventListener("targetFound", event => {
                    console.log("target found");
                });
                // detect target lost
                exampleTarget.addEventListener("targetLost", event => {
                    console.log("target lost");
                });
                // detect click event
                examplePlane.addEventListener("click", event => {
                    console.log("plane click");
                });
            });
        </script>
    @endpush

    <div class="max-w-5xl mx-auto p-6">

        <h1 class="text-2xl font-bold mb-4">Escanea tu escudo</h1>

        {{-- CONTENEDOR DEL RECUADRO --}}
        <div class="relative w-full  aspect-video border-4 border-black rounded-xl overflow-hidden shadow-lg">

            <a-scene embedded class="w-full h-full"
                mindar-image="imageTargetSrc: {{ asset('assets/targets-ar/Croatia.mind') }}; uiScanning:no; uiLoading:no; uiError:no; warmupTolerance:1; missTolerance:1;"
                color-space="sRGB" renderer="colorManagement: true, physicallyCorrectLights" vr-mode-ui="enabled: false"
                device-orientation-permission-ui="enabled: false">

                <a-light type="ambient" intensity="0.25"></a-light>
                <a-light type="directional" position="0 4 1" intensity="0.25" color="#d4d4d4"></a-light>
                <!-- <a-assets>
                    <a-asset-item id="characterModel" src="{{ asset('assets/3d-models/character-idle.gltf') }}"></a-asset-item>
                </a-assets> -->
                <a-assets>
                    <a-asset-item id="avatarModel"
                        src="{{ asset('assets/3d-models/character-idle.glb') }}"></a-asset-item>
                    <img id="avatarTexture" src="{{ asset('assets/3d-models/character-texture.png') }}">
                </a-assets>

                <a-camera position="0 0 0" look-controls="enabled: false"></a-camera>

                <a-entity mindar-image-target="targetIndex: 0">
                    <a-gltf-model class="avatar_model" rotation="0 0 0 " position="0 -0.5 0" scale="0.8 0.8 0.8"
                        src="#avatarModel" animation-mixer>
                    </a-gltf-model>
                </a-entity>
                <a-entity mindar-image-target="targetIndex: 1">
                    <a-gltf-model rotation="0 0 0 " position="0 -0.5 0" scale="0.8 0.8 0.8" src="#avatarModel"
                        animation-mixer>
                    </a-gltf-model>
                </a-entity>
                <a-entity mindar-image-target="targetIndex: 2">
                    <a-gltf-model class="avatar_model" rotation="0 0 0 " position="0 -0.5 0" scale="0.8 0.8 0.8"
                        src="#avatarModel" animation-mixer>
                    </a-gltf-model>
                </a-entity>
                <a-entity mindar-image-target="targetIndex: 3">
                    <a-gltf-model class="avatar_model" rotation="0 0 0 " position="0 -0.5 0" scale="0.8 0.8 0.8"
                        src="#avatarModel" animation-mixer>
                    </a-gltf-model>
                </a-entity>
                <a-entity mindar-image-target="targetIndex: 4">
                    <a-gltf-model class="avatar_model" rotation="0 0 0 " position="0 -0.5 0" scale="0.8 0.8 0.8"
                        src="#avatarModel" animation-mixer>
                    </a-gltf-model>
                </a-entity>
                <a-entity mindar-image-target="targetIndex: 5">
                    <a-gltf-model class="avatar_model" rotation="0 0 0 " position="0 -0.5 0" scale="0.8 0.8 0.8"
                        src="#avatarModel" animation-mixer>
                    </a-gltf-model>
                </a-entity>
                <a-entity mindar-image-target="targetIndex: 6">
                    <a-gltf-model class="avatar_model" rotation="0 0 0 " position="0 -0.5 0" scale="0.8 0.8 0.8"
                        src="#avatarModel" animation-mixer>
                    </a-gltf-model>
                </a-entity>
                <a-entity mindar-image-target="targetIndex: 7">
                    <a-gltf-model class="avatar_model" rotation="0 0 0 " position="0 -0.5 0" scale="0.8 0.8 0.8"
                        src="#avatarModel" animation-mixer>
                    </a-gltf-model>
                </a-entity>
                <a-entity mindar-image-target="targetIndex: 8">
                    <a-gltf-model class="avatar_model" rotation="0 0 0 " position="0 -0.5 0" scale="0.8 0.8 0.8"
                        src="#avatarModel" animation-mixer>
                    </a-gltf-model>
                </a-entity>
            </a-scene>
        </div>

        @push('scripts')
            <script>
                document.addEventListener("DOMContentLoaded", function () {

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

                });
            </script>
        @endpush
</x-general-layout>
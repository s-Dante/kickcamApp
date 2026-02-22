<!-- <!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CameraAR | KickCamApp</title>

    <script src="https://aframe.io/releases/1.5.0/aframe.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/mind-ar@1.2.5/dist/mindar-image-aframe.prod.js"></script>
</head>

<body>
    <p>Hola desde la camara de realidad aumentada</p>

    <a-scene mindar-image="imageTargetSrc: assets/targets-ar/Croatia.mind;" color-space="sRGB" renderer="colorManagement: true, physicallyCorrectLights" vr-mode-ui="enabled: false" device-orientation-permission-ui="enabled: false">
        <a-assets>
            <img id="card" src="https://cdn.jsdelivr.net/gh/hiukim/mind-ar-js@1.2.5/examples/image-tracking/assets/card-example/card.png" />
            <a-asset-item id="avatarModel" src="https://cdn.jsdelivr.net/gh/hiukim/mind-ar-js@1.2.5/examples/image-tracking/assets/card-example/softmind/scene.gltf"></a-asset-item>
        </a-assets>

        <a-camera position="0 0 0" look-controls="enabled: false"></a-camera>
        <a-entity mindar-image-target="targetIndex: 0">
            <a-plane src="#card" position="0 0 0" height="0.552" width="1" rotation="0 0 0"></a-plane>
            <a-gltf-model rotation="0 0 0 " position="0 0 0.1" scale="0.005 0.005 0.005" src="#avatarModel" animation="property: position; to: 0 0.1 0.1; dur: 1000; easing: easeInOutQuad; loop: true; dir: alternate">
        </a-entity>
    </a-scene>
</body>

</html> -->

<x-general-layout title="Cámara AR">
    <div class="text-center mb-4">
        <h1 class="text-xl font-bold">Escáner AR</h1>
        <p class="text-sm text-gray-500">Apunta a un escudo o balón para ver la magia</p>
    </div>

    <x-camera-frame>
        {{-- Aquí se inicializará MindAR --}}
        <canvas id="ar-canvas" class="w-full h-full"></canvas>

        <x-slot:topControls>
            <button class="bg-white/20 blur-md p-2 rounded-full text-white">
                <i class="fas fa-info-circle"></i>
            </button>
        </x-slot:topControls>

        <x-slot:bottomControls>
            {{-- Botones específicos de AR --}}
            <button class="w-16 h-16 bg-white rounded-full border-4 border-gray-300 shadow-lg flex items-center justify-center">
                 <div class="w-12 h-12 bg-blue-600 rounded-full"></div>
            </button>
        </x-slot:bottomControls>
    </x-camera-frame>
</x-general-layout>

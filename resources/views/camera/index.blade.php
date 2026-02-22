<x-general-layout title="Cámara KickCam">
    <div class="text-center mb-4">
        <h1 class="text-xl font-bold">Captura el Momento</h1>
    </div>

    <x-camera-frame>
        {{-- Video Standard --}}
        <video id="webcam" autoplay playsinline class="w-full h-full object-cover"></video>

        <x-slot:topControls>
             <select class="bg-black/50 text-white text-xs rounded px-2 py-1">
                <option>Sin Filtro</option>
                <option>Sepia</option>
                <option>Vintage</option>
             </select>
        </x-slot:topControls>

        <x-slot:bottomControls>
            {{-- Galería --}}
            <div class="w-10 h-10 bg-gray-400 rounded-lg overflow-hidden border border-white">
                <img src="https://via.placeholder.com/40" class="object-cover w-full h-full">
            </div>
            
            {{-- Disparador --}}
            <button id="capture-btn" class="w-20 h-20 bg-red-600 rounded-full border-8 border-white/30 shadow-xl active:scale-95 transition"></button>
            
            {{-- Switch Cámara --}}
            <button class="text-white text-2xl">
                <i class="fas fa-sync-alt"></i>
            </button>
        </x-slot:bottomControls>
    </x-camera-frame>
</x-general-layout>
<div class="relative mx-auto max-w-md w-full h-[70vh] bg-black rounded-3xl overflow-hidden border-4 border-gray-800 shadow-2xl mt-4">
    <div id="camera-container" class="w-full h-full">
        {{ $slot }}
    </div>

    {{-- Overlay de controles (UI sobre la cámara) --}}
    <div class="absolute inset-0 flex flex-col justify-between p-6 pointer-events-none">
        <div class="flex justify-between items-start pointer-events-auto">
            {{ $topControls ?? '' }}
        </div>

        <div class="flex justify-around items-end pointer-events-auto mb-4">
            {{ $bottomControls ?? '' }}
        </div>
    </div>
</div>
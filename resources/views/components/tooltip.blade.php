@props(['text', 'position' => 'top', 'multiline' => false])

@php
    $positionClasses = [
        'top' => 'bottom-full left-1/2 -translate-x-1/2 mb-2',
        'bottom' => 'top-full left-1/2 -translate-x-1/2 mt-2',
        'left' => 'right-full top-1/2 -translate-y-1/2 mr-2',
        'right' => 'left-full top-1/2 -translate-y-1/2 ml-2',
    ];

    $arrowClasses = [
        'top' => 'top-full left-1/2 -translate-x-1/2 border-t-gray-900 dark:border-t-gray-700 border-b-transparent border-l-transparent border-r-transparent',
        'bottom' => 'bottom-full left-1/2 -translate-x-1/2 border-b-gray-900 dark:border-b-gray-700 border-t-transparent border-l-transparent border-r-transparent',
        'left' => 'left-full top-1/2 -translate-y-1/2 border-l-gray-900 dark:border-l-gray-700 border-t-transparent border-b-transparent border-r-transparent',
        'right' => 'right-full top-1/2 -translate-y-1/2 border-r-gray-900 dark:border-r-gray-700 border-t-transparent border-b-transparent border-l-transparent',
    ];
@endphp

<div x-data="{ show: false, isMobile: window.innerWidth < 768 }" 
     @mouseenter="if(!isMobile) show = true" 
     @mouseleave="if(!isMobile) show = false" 
     @click.away="show = false"
     @resize.window="isMobile = window.innerWidth < 768"
     {{ $attributes->merge(['class' => 'relative group max-w-full block']) }}>
     
    <!-- Wrap the main content to handle click on mobile -->
    <div @click="if(isMobile) show = !show" class="cursor-pointer max-w-full w-full h-full relative">
        {{ $slot }}
        
        <!-- Mobile Help Icon Overlay - Placed absolute inside the slot wrapper to avoid breaking parent layout -->
        <button x-show="isMobile" @click.stop="show = !show" class="absolute top-1 right-1 z-20 md:hidden bg-secondary/80 hover:bg-secondary rounded-full w-6 h-6 flex items-center justify-center text-[11px] font-extrabold text-primary shadow-lg border-2 border-primary focus:outline-none transition-transform active:scale-95" type="button" aria-label="Mostrar información" style="display: none;">
            ?
        </button>
    </div>
    
    <div x-show="show"
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0 scale-95"
         x-transition:enter-end="opacity-100 scale-100"
         x-transition:leave="transition ease-in duration-150"
         x-transition:leave-start="opacity-100 scale-100"
         x-transition:leave-end="opacity-0 scale-95"
         class="absolute z-[100] {{ $multiline ? 'whitespace-normal w-48 text-center' : 'whitespace-nowrap' }} px-3 py-2 text-xs font-semibold text-white bg-gray-900/95 backdrop-blur-sm dark:bg-gray-800/95 rounded-lg shadow-[0_0_15px_rgba(0,0,0,0.5)] border border-white/20 {{ $positionClasses[$position] }}"
         style="display: none;">
        {{ $text }}
        
        <!-- Arrow -->
        <div class="absolute border-4 {{ $arrowClasses[$position] }}"></div>
    </div>
</div>

@props(['generalBadges', 'userUnlockedIds'])

<div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
    <div class="p-6">
        <div class="flex items-center justify-between border-b pb-4 mb-4">
            <h3 class="text-lg font-bold text-gray-800 flex items-center">
                <span class="text-2xl mr-2">🎯</span>
                Logros Generales
            </h3>
        </div>

        <div class="grid grid-cols-2 xs:grid-cols-3 sm:grid-cols-4 md:grid-cols-5 gap-4">
            @foreach($generalBadges as $badge)
                @php
                    $isUnlocked = in_array($badge->id, $userUnlockedIds);
                @endphp

                @if($isUnlocked)
                    <!-- Logro Desbloqueado -->
                    <div class="flex flex-col items-center p-3 rounded-xl bg-orange-50 border border-orange-100 shadow-sm transition-transform hover:scale-105 cursor-pointer"
                        title="{{ $badge->description }}">
                        <div
                            class="w-14 h-14 rounded-full bg-orange-200 flex items-center justify-center mb-2 shadow-inner border border-orange-300 overflow-hidden">
                            <img src="{{ $badge->image_url }}" alt="{{ $badge->title }}"
                                class="w-10 h-10 object-contain drop-shadow-md">
                        </div>
                        <span class="text-xs font-bold text-orange-900 text-center leading-tight">{{ $badge->title }}</span>
                    </div>
                @else
                    <!-- Logro Bloqueado -->
                    <div class="flex flex-col items-center p-3 rounded-xl bg-gray-50/50 border border-transparent"
                        title="{{ $badge->description }}">
                        <div
                            class="w-14 h-14 rounded-full bg-gray-200 flex items-center justify-center mb-2 grayscale opacity-50 relative overflow-hidden">
                            <img src="{{ $badge->image_url }}" alt="?"
                                class="w-8 h-8 object-contain filter drop-shadow opacity-50">
                            <!-- Diagonal Slash -->
                            <div class="absolute inset-0 flex items-center justify-center">
                                <svg class="w-8 h-8 text-gray-500 opacity-60" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z">
                                    </path>
                                </svg>
                            </div>
                        </div>
                        <span class="text-xs font-semibold text-gray-400 text-center leading-tight">Misterio</span>
                    </div>
                @endif
            @endforeach
        </div>
    </div>
</div>
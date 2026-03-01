@props(['generalBadges', 'userUnlockedIds'])

<div class="{{ $ui['card'] }} mb-6">
    <div class="{{ $ui['card-body'] }}">
        <div class="flex items-center justify-between border-b border-tertiary pb-4 mb-4">
            <h3 class="{{ $ui['h2'] }} flex items-center">
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
                    <div class="flex flex-col items-center p-3 rounded-xl bg-accent-desat/30 border border-accent/20 shadow-sm transition-transform hover:scale-105 cursor-pointer"
                        title="{{ $badge->description }}">
                        <div
                            class="w-14 h-14 rounded-full bg-accent-desat flex items-center justify-center mb-2 shadow-inner border border-accent overflow-hidden">
                            <img src="{{ $badge->image_url }}" alt="{{ $badge->title }}"
                                class="w-10 h-10 object-contain drop-shadow-md">
                        </div>
                        <span
                            class="text-xs font-bold text-accent-sat dark:text-accent-desat text-center leading-tight">{{ $badge->title }}</span>
                    </div>
                @else
                    <!-- Logro Bloqueado -->
                    <div class="flex flex-col items-center p-3 rounded-xl bg-tertiary-desat/10 border border-transparent"
                        title="{{ $badge->description }}">
                        <div
                            class="w-14 h-14 rounded-full bg-tertiary-desat flex items-center justify-center mb-2 grayscale opacity-50 relative overflow-hidden">
                            <img src="{{ $badge->image_url }}" alt="?"
                                class="w-8 h-8 object-contain filter drop-shadow opacity-50">
                            <!-- Diagonal Slash -->
                            <div class="absolute inset-0 flex items-center justify-center">
                                <svg class="w-8 h-8 text-tertiary-sat opacity-60" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z">
                                    </path>
                                </svg>
                            </div>
                        </div>
                        <span class="text-xs font-semibold text-tertiary-sat text-center leading-tight">Misterio</span>
                    </div>
                @endif
            @endforeach
        </div>
    </div>
</div>
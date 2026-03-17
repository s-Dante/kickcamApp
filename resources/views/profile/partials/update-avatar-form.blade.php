@php
    $classes = [
        'header' => [
            'title' => $ui['h3'] ?? 'text-lg font-medium text-secondary',
            'desc' => "mt-1 {$ui['text-muted']}"
        ],
        'form' => 'mt-6 space-y-6',
        'scroll_container' => 'flex overflow-x-auto gap-3 pb-4 snap-x no-scrollbar',
        'avatar_preview' => 'w-24 h-24 sm:w-28 sm:h-28 rounded-full object-cover border-4 border-primary ring-2 ring-accent/20',
        'avatar_option' => 'shrink-0 snap-start cursor-pointer w-14 h-14 sm:w-16 sm:h-16 rounded-full overflow-hidden border-2 border-transparent hover:border-accent transition-all ring-1 ring-primary/10',
        'avatar_option_selected' => 'shrink-0 snap-start cursor-pointer w-14 h-14 sm:w-16 sm:h-16 rounded-full overflow-hidden border-4 border-accent ring-2 ring-accent/50 scale-110 shadow-lg',
        'file_btn' => "inline-flex items-center px-4 py-2 bg-secondary/10 hover:bg-secondary/20 border border-transparent rounded-full font-medium text-xs text-secondary tracking-widest focus:outline-none focus:ring-2 focus:ring-secondary focus:ring-offset-2 transition ease-in-out duration-150 cursor-pointer shadow-sm",
        'footer' => [
            'container' => 'flex items-center gap-4 mt-8',
            'saved' => "text-sm {$ui['text-muted']}"
        ]
    ];
@endphp

<section x-data="{ 
    selectedAvatar: '{{ old('selected_avatar', $user->avatar) }}',
    previewUrl: '{{ $user->avatar_url }}',
    selectAvatar(url) {
        this.selectedAvatar = url;
        this.previewUrl = url;
        $refs.fileInput.value = '';
    },
    fileChosen(event) {
        if (event.target.files && event.target.files[0]) {
            this.selectedAvatar = '';
            var reader = new FileReader();
            reader.onload = (e) => {
                this.previewUrl = e.target.result;
            };
            reader.readAsDataURL(event.target.files[0]);
        }
    }
}">
    <header>
        <h2 class="{{ $classes['header']['title'] }}">
            {{ __('Foto de Perfil') }}
        </h2>

        <p class="{{ $classes['header']['desc'] }}">
            Sube tu propia foto o escoge entre las opciones predefinidas.
        </p>
    </header>

    <style>
        .no-scrollbar::-webkit-scrollbar {
            display: none;
        }
        .no-scrollbar {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }
    </style>

    <form method="post" action="{{ route('profile.avatar.update') }}" enctype="multipart/form-data" class="{{ $classes['form'] }}">
        @csrf
        @method('patch')

        <div class="flex flex-col sm:flex-row gap-6 items-center sm:items-start">
            <!-- Avatar Preview -->
            <div class="shrink-0 relative group">
                <img x-bind:src="previewUrl" alt="Avatar" class="{{ $classes['avatar_preview'] }}">
                
                <!-- Custom Upload Button Overlay -->
                <label for="avatar_file" class="absolute bottom-0 right-0 bg-accent text-primary p-2 rounded-full cursor-pointer shadow-lg hover:scale-110 transition-transform focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-accent">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                    <input type="file" id="avatar_file" name="avatar_file" accept="image/*" class="sr-only" x-ref="fileInput" @change="fileChosen">
                </label>
            </div>
            
            <div class="flex-1 w-full mt-2 sm:mt-0 text-center sm:text-left">
                <label for="avatar_file" class="{{ $classes['file_btn'] }}">
                    📁 Subir Imagen
                </label>
                <div class="mt-1 text-xs text-secondary-desat opacity-70">Recomendado: 1:1, Max 5MB.</div>
                <x-input-error class="mt-2" :messages="$errors->get('avatar_file')" />
            </div>
        </div>

        <div class="mt-8 border-t border-tertiary/20 pt-6">
            <x-input-label value="O escoge un avatar predefinido" class="mb-4 block" />
            
            <input type="hidden" name="selected_avatar" x-model="selectedAvatar">

            <!-- Horizontal Scrollable Container -->
            <div class="{{ $classes['scroll_container'] }}">
                @foreach($predefinedAvatars as $url)
                    <div 
                        @click="selectAvatar('{{ $url }}')"
                        :class="selectedAvatar === '{{ $url }}' ? '{{ $classes['avatar_option_selected'] }}' : '{{ $classes['avatar_option'] }}'"
                    >
                        <img src="{{ $url }}" alt="Predefined Avatar" loading="lazy" class="w-full h-full object-cover">
                    </div>
                @endforeach
            </div>
            <x-input-error class="mt-2" :messages="$errors->get('selected_avatar')" />
        </div>

        <div class="{{ $classes['footer']['container'] }}">
            <x-primary-button>{{ __('Guardar Foto') }}</x-primary-button>

            @if (session('status') === 'avatar-updated')
                <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)"
                    class="{{ $classes['footer']['saved'] }}">{{ __('Guardado.') }}</p>
            @endif
        </div>
    </form>
</section>

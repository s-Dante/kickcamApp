@php
    $classes = [
        'header' => [
            'title' => $ui['h3'] ?? 'text-lg font-medium text-secondary',
            'desc' => "mt-1 {$ui['text-muted']}"
        ],
        'form' => 'mt-6 space-y-6',
        'input_group' => [
            'container' => 'mt-1',
            'select' => "block w-full {$ui['text-input']}"
        ],
        'error' => 'mt-2',
        'footer' => [
            'container' => 'flex items-center gap-4',
            'saved' => "text-sm {$ui['text-muted']}"
        ]
    ];
@endphp

<section>
    <header>
        <h2 class="{{ $classes['header']['title'] }}">
            {{ __('Preferencias de Tema') }}
        </h2>

        <p class="{{ $classes['header']['desc'] }}">
            {{ __('Actualiza la visualización de la plataforma para tu cuenta.') }}
        </p>
    </header>

    <form method="post" action="{{ route('profile.update') }}" class="{{ $classes['form'] }}">
        @csrf
        @method('patch')

        <div class="{{ $classes['input_group']['container'] }}">
            <x-input-label for="theme" :value="__('Tema de Interfaz')" />
            <select id="theme" name="theme" class="{{ $classes['input_group']['select'] }}">
                <option value="system" {{ old('theme', $user->theme) === 'system' ? 'selected' : '' }}>
                    {{ __('Sistema Automático') }}
                </option>
                <option value="light" {{ old('theme', $user->theme) === 'light' ? 'selected' : '' }}>
                    {{ __('Modo Claro') }}
                </option>
                <option value="dark" {{ old('theme', $user->theme) === 'dark' ? 'selected' : '' }}>
                    {{ __('Modo Oscuro') }}
                </option>
            </select>
            <x-input-error class="{{ $classes['error'] }}" :messages="$errors->get('theme')" />
        </div>

        <div class="{{ $classes['footer']['container'] }}">
            <x-primary-button>{{ __('Guardar Preferencia') }}</x-primary-button>

            @if (session('status') === 'profile-updated')
                <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)"
                    class="{{ $classes['footer']['saved'] }}">{{ __('Guardado.') }}</p>
            @endif
        </div>
    </form>
</section>
<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
            {{ __('Preferencias de Tema') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
            {{ __('Actualiza la visualización de la plataforma para tu cuenta.') }}
        </p>
    </header>

    <form method="post" action="{{ route('profile.update') }}" class="mt-6 space-y-6">
        @csrf
        @method('patch')

        <div>
            <x-input-label for="theme" :value="__('Tema de Interfaz')" />
            <select id="theme" name="theme"
                class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm">
                <option value="system" {{ old('theme', $user->theme) === 'system' ? 'selected' : '' }}>
                    {{ __('Sistema Automático') }}
                </option>
                <option value="light" {{ old('theme', $user->theme) === 'light' ? 'selected' : '' }}>
                    {{ __('Modo Claro') }}
                </option>
                <option value="dark" {{ old('theme', $user->theme) === 'dark' ? 'selected' : '' }}>{{ __('Modo Oscuro') }}
                </option>
            </select>
            <x-input-error class="mt-2" :messages="$errors->get('theme')" />
        </div>

        <div class="flex items-center gap-4">
            <x-primary-button>{{ __('Guardar Preferencia') }}</x-primary-button>

            @if (session('status') === 'profile-updated')
                <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-gray-600 dark:text-gray-400">{{ __('Guardado.') }}</p>
            @endif
        </div>
    </form>
</section>
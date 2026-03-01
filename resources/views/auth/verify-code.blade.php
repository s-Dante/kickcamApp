<x-guest-layout>
    <div class="mb-4 text-sm text-gray-600">
        {{ __('Hemos enviado un código seguro de 6 dígitos a tu correo electrónico. Ingrésalo a continuación para continuar.') }}
    </div>

    <form method="POST" action="{{ route('password.verify.code') }}">
        @csrf
        <input type="hidden" name="email" value="{{ session('reset_email') }}">

        <div>
            <x-input-label for="pin" value="Código de Verificación (PIN)" />
            <x-text-input id="pin" class="block mt-1 w-full text-center tracking-widest text-2xl" type="text" name="pin" required autofocus autocomplete="one-time-code" maxlength="6" pattern="\d{6}" placeholder="000000" />
            <x-input-error :messages="$errors->get('pin')" class="mt-2" />
        </div>

        <div class="flex justify-end mt-4">
            <x-primary-button>
                {{ __('Verificar Código') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>

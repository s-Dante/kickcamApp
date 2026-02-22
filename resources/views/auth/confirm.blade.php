<x-auth.layout
    title="Password Recovery | Confirm"
    description="Ingresa el token que se te envio por correo para recuperar tu contraseña"
    :action="route('auth.reset')">

    <x-auth.input name="token" label="Token de recuperación" type="text" required />
    
    <button type="submit" class="cursor-pointer">Confirmar recuperación</button>

</x-auth.layout>
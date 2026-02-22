<x-auth.layout
    title="Password Recovery | Recovery"
    description="Cambia tu contraseña ingresando una nueva contraseña y confirmandola"
    :action="">

    <x-auth.input name="password" label="Nueva Contraseña" type="password" required />
    <x-auth.input name="password_confirmation" label="Confirmar Contraseña" type="password" required />
    
    <button type="submit" class="cursor-pointer">Cambiar contraseña</button>

</x-auth.layout>
<x-auth.layout
    title="Password Recovery | Email"
    description="Se enviara un correo con un token a tu correo para recuperar tu contraseña"
    :action="route('auth.confirm')">

    <x-auth.input name="email" label="Correo" type="email" required />
    
    <button type="submit" class="cursor-pointer">Enviar correo de recuperación</button>

    <span>
        ¿Ya tienes una cuenta?
        <a href="{{ route('auth.login') }}">Inicia sesión aquí</a>
    </span>
</x-auth.layout>
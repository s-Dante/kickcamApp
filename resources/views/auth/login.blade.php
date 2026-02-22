<x-auth.layout
    title="Log In"
    description="Accede a tu cuenta para continuar"
    :action="route('auth.login')">

    <x-auth.input name="email" label="Correo" type="email" required />
    <x-auth.input name="password" label="Contraseña" type="password" required />
    <span>
        <a href="{{ route('auth.email') }}">¿Has olvidado tu contraseña?</a>
    </span>
    
    <button type="submit" class="cursor-pointer">Entrar</button>

    <span>O inicia sesion con:</span>

    <a href="" class="inline-flex items-center gap-2 border rounded px-4 py-2">
        Google
    </a>

    <a href="" class="inline-flex items-center gap-2 border rounded px-4 py-2">
        Facebook
    </a>

    <span>
        ¿No tienes una cuenta?
        <a href="{{ route('auth.register') }}">Regístrate aquí</a>
    </span>

</x-auth.layout>
<x-auth.layout
    title="Sign In"
    description="Crea una cuenta para continuar"
    :action="route('auth.register')">
    
    <x-auth.input name="name" label="Nombre(s)" type="text" required />
    <x-auth.input name="father_lastname" label="Apellido Paterno" type="text" required />
    <x-auth.input name="mother_lastname" label="Apellido Materno" type="text" required />
    <x-auth.input name="email" label="Correo Electrónico" type="email" required />
    <x-auth.input name="password" label="Contraseña" type="password" required />

    <button type="submit" class="hover:cursor-pointer">Registrarse</button>

    <a href="" class="inline-flex items-center gap-2 border rounded px-4 py-2">
        Google
    </a>

    <a href="" class="inline-flex items-center gap-2 border rounded px-4 py-2">
        Facebook
    </a>

    <span>
        ¿Ya tienes una cuenta?
        <a href="{{ route('auth.login') }}">Inicia sesión aquí</a>
    </span>
</x-auth.layout>
<x-mail::message>
    # Recuperación de Contraseña

    Has solicitado restablecer tu contraseña. Ingresa el siguiente código de seguridad en la aplicación para proceder.

    <x-mail::panel>
        # {{ $pin }}
    </x-mail::panel>

    Si tú no solicitaste este cambio, por favor ignora este correo.

    Gracias,<br>
    {{ config('app.name') }}
</x-mail::message>
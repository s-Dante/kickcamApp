<x-mail::message>
    # Recuperación de Contraseña

    Hola,

    Recibimos una solicitud para restablecer la contraseña de tu cuenta en **{{ config('app.name') }}**.
    Por favor, ingresa el siguiente código de seguridad en la aplicación para crear una nueva contraseña:

    <x-mail::panel>
        <div style="text-align: center; font-size: 24px; font-weight: bold; letter-spacing: 5px; color: #18181b;">
            {{ $pin }}
        </div>
    </x-mail::panel>

    Este código es válido por 60 minutos. Si tú no solicitaste este cambio, por favor ignora este correo; tu cuenta
    sigue estando segura.

    Gracias,<br>
    El equipo de **{{ config('app.name') }}**
</x-mail::message>
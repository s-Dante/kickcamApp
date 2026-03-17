<!DOCTYPE html>
<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <title>Recuperación de Contraseña</title>
    <style>
        body {
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
            background-color: hsl(208, 24%, 16%);
            color: hsl(210, 20%, 96%);
            margin: 0;
            padding: 0;
            line-height: 1.6;
            -webkit-font-smoothing: antialiased;
        }
        .wrapper {
            width: 100%;
            background-color: hsl(208, 24%, 16%);
            padding: 40px 0;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            background-color: hsl(208, 28%, 12%);
            border-radius: 12px; /* rounded-xl */
            overflow: hidden;
            border: 1px solid hsla(234, 15%, 45%, 0.3); /* border-tertiary/30 */
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05); /* shadow-lg */
        }
        .header {
            padding: 30px;
            text-align: center;
            border-bottom: 1px solid hsla(234, 15%, 45%, 0.3);
            background: linear-gradient(135deg, hsl(208, 24%, 16%), hsl(208, 28%, 12%)); /* bg-linear-1 */
        }
        .header h1 {
            margin: 0;
            font-size: 24px;
            color: hsl(210, 20%, 96%);
            font-weight: 700;
            letter-spacing: 1px;
        }
        .content {
            padding: 40px 30px;
            text-align: center;
        }
        .content p {
            font-size: 16px;
            color: hsl(226, 21%, 90%); /* text-secondary-desat */
            margin-bottom: 24px;
        }
        .pin-wrapper {
            margin: 40px auto;
            max-width: 320px;
        }
        .pin-container {
            background-color: hsl(208, 24%, 16%);
            border: 2px solid hsl(227, 100%, 79%); /* border-accent */
            border-radius: 12px;
            padding: 24px;
            box-shadow: 0 0 15px hsla(227, 100%, 79%, 0.2);
        }
        .pin-code {
            font-size: 42px;
            font-weight: bold;
            color: hsl(227, 100%, 79%); /* text-accent */
            letter-spacing: 10px;
            margin: 0;
            text-align: center;
        }
        .footer {
            padding: 24px;
            text-align: center;
            font-size: 13px;
            color: hsl(169, 20%, 40%); /* tertiary-desat */
            border-top: 1px solid hsla(234, 15%, 45%, 0.3);
            background-color: hsl(208, 28%, 12%);
        }
        .highlight {
            color: hsl(227, 100%, 79%);
            font-weight: 600;
        }
    </style>
</head>
<body>
    <div class="wrapper">
        <div class="container">
            <div class="header">
                <h1>{{ config('app.name') }}</h1>
            </div>
            <div class="content">
                <p>Hola,</p>
                <p>Recibimos una solicitud para restablecer la contraseña de tu cuenta. Por favor, captura el siguiente código numérico de seguridad en la aplicación:</p>
                
                <div class="pin-wrapper">
                    <div class="pin-container">
                        <p class="pin-code">{{ $pin }}</p>
                    </div>
                </div>
                
                <p style="font-size: 14px; color: hsl(234, 15%, 45%); margin-top: 40px;">
                    Este código es válido por 60 minutos. Si tú no solicitaste este cambio, por favor ignora este correo; tu cuenta
                    sigue estando segura.
                </p>
            </div>
            <div class="footer">
                &copy; {{ date('Y') }} <span class="highlight">{{ config('app.name') }}</span>. Todos los derechos reservados.
            </div>
        </div>
    </div>
</body>
</html>
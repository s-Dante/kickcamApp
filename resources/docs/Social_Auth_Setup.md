# Guía de Autenticación Social (OAuth) para KickCam

Para que los botones de "Continuar con Google" y "Continuar con GitHub" funcionen, debes obtener las credenciales de desarrollador de ambas plataformas y añadirlas al archivo `.env` de tu proyecto. 

Nuestra aplicación requiere los siguientes valores:
```dotenv
GITHUB_CLIENT_ID=tu_client_id_aqui
GITHUB_CLIENT_SECRET=tu_client_secret_aqui
GITHUB_REDIRECT_URI=http://localhost:8000/auth/github/callback

GOOGLE_CLIENT_ID=tu_client_id_aqui
GOOGLE_CLIENT_SECRET=tu_client_secret_aqui
GOOGLE_REDIRECT_URL=http://localhost:8000/auth/google/callback
```
*(Nota: ajusta `localhost:8000` al dominio de tu aplicación en producción o a la URL de Laravel Herd, por ejemplo `http://kickcamapp.test/...`)*

---

## 1. Configurar GitHub

1. Inicia sesión en tu cuenta de GitHub y ve a **Settings** (Ajustes).
2. En la barra lateral izquierda, hasta abajo, da clic en **Developer settings**.
3. Selecciona **OAuth Apps** y luego da clic en **New OAuth App**.
4. Llena el formulario:
   - **Application name**: KickCam (o el nombre de tu proyecto)
   - **Homepage URL**: `http://localhost:8000` (o la URL de tu app)
   - **Authorization callback URL**: `http://localhost:8000/auth/github/callback` *(¡ESTO ES MUY IMPORTANTE, debe coincidir con `GITHUB_REDIRECT_URI`!)*
5. Da clic en **Register application**.
6. GitHub te mostrará el **Client ID**. Cópialo y pégalo en tu `.env` como `GITHUB_CLIENT_ID`.
7. Da clic en **Generate a new client secret**, cópialo y pégalo en tu `.env` como `GITHUB_CLIENT_SECRET` (solo te lo mostrarán una vez).

---

## 2. Configurar Google

1. Ve a la [Console de Google Cloud](https://console.cloud.google.com/).
2. Crea un nuevo proyecto (puedes llamarlo "KickCam Auth").
3. Ve al menú de navegación lateral (las tres rayas) -> **APIs & Services** -> **OAuth consent screen** (Pantalla de consentimiento de OAuth).
   - Elige **External** y da clic en Create.
   - Llena los datos obligatorios (Nombre de la App, Correo de soporte) y guarda.
4. Ahora ve a **Credentials** (Credenciales) en el menú lateral.
5. Da clic en **+ CREATE CREDENTIALS** arriba y elige **OAuth client ID**.
6. Selecciona tipo de aplicación: **Web application**.
7. En el apartado **Authorized redirect URIs**, debes agregar la URL exacta:
   - `http://localhost:8000/auth/google/callback`
8. Da clic en **Create**.
9. Aparecerá un cuadro con tu **Client ID** (cópialo a `GOOGLE_CLIENT_ID`) y tu **Client Secret** (cópialo a `GOOGLE_CLIENT_SECRET`).

¡Listo! Una vez que estos valores estén en el `.env`, puedes usar los botones en la app para registrar a los usuarios sin llenar formularios manuales.

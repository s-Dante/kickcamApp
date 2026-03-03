# Guía de Organización Multimedia para KickCam

Para mantener el proyecto Laravel ordenado, rápido y seguro a largo plazo (y para que sea fácil migrar a la nube como Amazon S3 en el futuro), se recomienda estructurar todos los recursos estáticos y dinámicos siguiendo estas convenciones:

## 1. Assets del Sistema (`public/`)
La carpeta `public/` en la raíz de tu proyecto **solo debe contener archivos que no cambian (inmutables)** y que son esenciales para que la app funcione.

**Ejemplos:**
- `public/KickCam_Logo.svg`
- `public/favicon.ico`
- `public/css/` y `public/js/` (Archivos compilados por Vite)
- `public/trivia-data/trivia.json` (Si es un catálogo estático que tú controlas)

## 2. Archivos Subidos por el Usuario (`storage/app/public/`)
Cualquier archivo que pueda subir el usuario (como fotos de perfil, imágenes tomadas con la cámara, o modelos generados dinámicamente) **deben guardarse en el Storage de Laravel**, no en la carpeta `public/` directa.

1. Debes correr el comando simbólico **una vez** en tu servidor/local:
   ```bash
   php artisan storage:link
   ```
2. Esto creará un acceso directo de `storage/app/public/` a `public/storage/`.

### Estructura Recomendada dentro de Storage:
Te sugiero implementar la siguiente estructura de carpetas cuando guardes archivos mediante código PHP (`$request->file('...')->store('folder', 'public')`):

```text
storage/app/public/
│
├── avatars/               # Fotos de perfil de los usuarios
│   ├── usr_1_avatar.jpg
│   └── usr_2_avatar.png
│
├── media/                 # Fotos/Videos tomados desde la app (La Galería)
│   ├── user_1/
│   │   ├── capture_123.jpg
│   │   └── clip_456.mp4
│   └── user_2/
│
├── ar_assets/             # Archivos necesarios para la Cámara AR
│   ├── targets/           # Archivos .mind compilados para Image Tracking
│   │   └── kicks_logo.mind
│   └── models/            # Modelos 3D (.gltf, .glb)
│       └── trophy.glb
│
└── filters/               # Texturas y máscaras para "KickCam Pro"
    ├── mask_neon.png
    └── face_mesh.obj
```

---

## 3. ¿Cómo acceder a ellos desde el código?

### Desde un Controlador Laravel (Para Guardar)
```php
$path = $request->file('photo')->store('media/' . auth()->id(), 'public');
// Se guardará en: storage/app/public/media/1/foto.jpg
```

### Desde las Vistas (HTML/Blade)
```html
<!-- Cargar el logo estático -->
<img src="{{ asset('KickCam_Logo.svg') }}" alt="Logo">

<!-- Cargar una foto dinámica del perfil de un usuario -->
<img src="{{ asset('storage/avatars/' . $user->avatar_file) }}" alt="Avatar">

<!-- Cargar un Target para MindAR -->
<a-scene mindar-image="imageTargetSrc: {{ asset('storage/ar_assets/targets/kicks_logo.mind') }}">
```

Mantener esta separación garantizará que cuando subas KickCam a Producción, tus repositorios de GitHub solo tengan el código fuente y las actualizaciones no borren las fotos de los usuarios.

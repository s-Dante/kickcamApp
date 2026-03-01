---
name: laravel-mvc
description: "Enforces the strict MVC + Repository/Service architecture pattern requested by the user. Activates for all controller, model, view, and database logic generation."
license: MIT
metadata:
  author: OmarFernandez
---

# Strict MVC & Repository Pattern Guidelines

## Controller Structure

Controllers must remain "Skinny". They act only as traffic directors.

```php
// BAD
public function index() {
    $users = User::where('active', 1)->get(); // Direct DB access forbidden
    return view('users.index', compact('users'));
}

// GOOD
public function index(UserService $userService): View {
    $users = $userService->getActiveUsers();
    return view('users.index', compact('users'));
}
```

## Service & Repository Layer
- Repositories (`app/Repositories`): Handle raw Eloquent queries (find, create, where).

- Services (`app/Services`): Handle business logic (calculations, external APIs like BeSoccer, multi-step processes).

### Frontend & CSS Strategy
#### Blade
Organize views strictly by role:
- `resources/views/auth/`
- `resources/views/profile/`
- `resources/views/ar/`

#### CSS
Use Tailwind Utility classes for 90% of styling.
- For complex views, use @push('css') or a dedicated CSS file.
- If a structure is reused often, suggest extracting to a CSS class using @apply.
- AR & 3D Implementation (MindAr / Model-Viewer)
When implementing AR, ensure assets are loaded correctly from public/.
- Use Blade Stacks (@push('scripts')) to inject MindAr/Three.js scripts only on pages that need them.
- When using Tailwind dont use it inline, instead create a variable that contains all tailwind styles for a class in a single variable
- Allways make use of the global configuration of css so if for some reasone we want to change the app color, style or something else we only change the less variables posible
    - So the `resources/css/app.csss` contains the global style bases
- Use a organized structure for all the styles, and also for the JavaScript scripts to, this organization must be an mirror of the view structure, so the folders and files in `resources/views/` are mirrored as folders and files for .css or .js in their corresponding folders belong the resources folder
    - The structure must be something like:
        ##### if we  have something like this in `resources/views`:
        - `resources/views/welcome.blade.php` or `resources/views/profile/index.blade.php`:
        #### We must have this folders and files in css and js:
        - `resources/views/welcome.css` and `resources/views/welcome.php`, also we have `resources/views/profile/index.css` and `resources/views/profile/index.php` (the welcome.php and index.php files must contains the variables in where we alocate our tailwind styles for the clases that we have in the view)
        - `resources/views/welcome.js` and `resources/views/profile/index.js`

---

### 2. Archivo: `.agents/skills/pest-testing/SKILL.md`
Este archivo define cómo se deben hacer las pruebas, enfocándose en tus Servicios.

```markdown
---
name: pest-testing
description: "Tests applications using the Pest 4 PHP framework. Focuses on testing Services and Repositories due to Skinny Controller architecture."
license: MIT
metadata:
  author: laravel
---
```

---

# Pest Testing 4

## Testing Strategy for This Project

Since this project uses **Skinny Controllers**, your testing strategy must shift:

1.  **Unit Tests (`tests/Unit`):** Heavy focus here. Test your **Services** and **Repositories** in isolation. Mock dependencies.
2.  **Feature Tests (`tests/Feature`):** Test the HTTP endpoints (Controllers) to ensure they correctly call the services and return the expected Views/JSON.

## Basic Usage

### Creating Tests
`php artisan make:test --pest {name}`

### Mocking Services
When testing controllers, always mock the Service layer to avoid hitting the DB or APIs (like BeSoccer).

```php
it('shows user dashboard', function () {
    $service = Mockery::mock(StudentService::class);
    $service->shouldReceive('getStats')->once()->andReturn([...]);
    
    $this->instance(StudentService::class, $service);
    
    get('/student/dashboard')->assertOk();
});
Documentation
Use search-docs for detailed Pest 4 patterns.
```

---

### 3. Archivo: `DOC_MAESTRO.md`
Este archivo va en la raíz de tu proyecto.


```markdown
# DOC_MAESTRO - Documentación Viva del Proyecto

Este archivo rastrea la evolución del proyecto, módulos implementados y decisiones técnicas.

## Estado Actual
- **Fecha de Inicio:** {{FECHA_ACTUAL}}
- **Stack:** Laravel 12, Tailwind, MySQL.
- **Patrón:** Repository/Service Pattern.

## Registro de Cambios (Log)

### [Inicialización]
- Configuración del entorno.
- Definición de reglas de arquitectura en GEMINI.md.
```
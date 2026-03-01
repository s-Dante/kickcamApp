# KICKCAM - Arquitectura v2

## Documento de Evolución Arquitectónica

---

# 1. Introducción

KickCam inició como una aplicación Laravel tradicional basada en Blade con una arquitectura MVC + Repository/Service Pattern.

Con la expansión del alcance funcional hacia Realidad Aumentada avanzada, FaceMesh dinámico, filtros con shaders y tracking espacial, el proyecto evoluciona hacia un enfoque API-First con un motor frontend modular desacoplado.

Este documento define la nueva arquitectura oficial del proyecto.

---

# 2. Cambio de Paradigma

## Arquitectura Anterior (Legacy v1)

* Blade como núcleo de renderizado.
* Scripts JS espejo por vista.
* Integración directa de librerías AR en vistas específicas.
* Enfoque View-Centric.

## Arquitectura Actual (v2)

* Laravel como Backend Core.
* Enfoque API-First.
* Frontend desacoplado y modular.
* Motor AR independiente.
* Arquitectura Mobile-First.

---

# 3. Backend - Laravel Core

## Responsabilidades

Laravel ahora cumple el rol de:

* Sistema de autenticación.
* Motor de juego (trivias, puntos, insignias).
* Gestión de equipos y contenido multimedia.
* Integración con APIs externas.
* Exposición de endpoints JSON.

## Controllers

* Deben ser Skinny.
* No contienen lógica de negocio.
* No acceden directamente a Eloquent.
* Retornan JSON o Blade Shell.

## Services

* Contienen la lógica de negocio.
* Orquestan múltiples repositorios.
* Preparan datos serializables para API.

## Repositories

* Encapsulan todas las consultas Eloquent.
* Ubicación: app/Repositories

---

# 4. Frontend - Motor Modular

## Principio Fundamental

El frontend ya no está organizado por vistas Blade.

Está organizado por dominios funcionales.

## Estructura Base

resources/js/
core/
KickCamApp.js
ar/
engine/
filters/
face/
tracking/
game/
api/
ui/

## Reglas del Motor

* Todo módulo debe ser clase ES6.
* Todo módulo debe implementar init() y destroy().
* No se permite lógica AR dentro de Blade.
* No se permiten variables globales.
* No se permite JS inline.

---

# 5. AR & Vision Stack

## Render

Three.js como motor principal de renderizado.

## Vision

MediaPipe para:

* FaceMesh
* Detección de objetos 2D

## Spatial AR

WebXR para:

* Hit Testing
* Anchors
* Colocación espacial

MindAR queda como opcional según necesidad específica.

---

# 6. Gestión de Memoria

Requisitos obligatorios:

* Dispose explícito de geometries.
* Dispose explícito de materiales.
* Dispose explícito de texturas.
* Cancelación de animation frames.
* Destrucción de sesiones WebXR.

Mobile performance es prioridad.

---

# 7. CSS Strategy

* Tailwind como base.
* Estilos globales centralizados en resources/css/app.css.
* Arquitectura basada en componentes.
* Eliminado el patrón espejo view/css/js.

---

# 8. Flujo de Inicialización

1. Blade carga únicamente el Shell.
2. KickCamApp inicializa módulos.
3. API se consume vía fetch/Axios.
4. AR Engine se activa bajo demanda.

---

# 9. Roadmap Técnico por Fases

## Fase 1

* API estable
* Sistema de juego completo

## Fase 2

* Cámara base
* Filtros shader simples

## Fase 3

* FaceMesh dinámico

## Fase 4

* Object Tracking
* WebXR espacial

---

# 10. Política de Evolución

Cualquier nueva funcionalidad debe:

* Respetar el enfoque modular.
* No reintroducir lógica en Blade.
* No mezclar responsabilidades.
* Priorizar estabilidad móvil.

---

# 11. Declaración Oficial

KickCam adopta oficialmente una arquitectura API-First con un motor frontend modular desacoplado.

El patrón MVC + Repository/Service continúa vigente en backend.

Las prácticas Blade-centric quedan marcadas como Legacy.

---

Fin del Documento.

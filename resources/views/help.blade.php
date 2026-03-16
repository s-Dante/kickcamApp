<x-app-layout>
    @php
        $classes = [
            'page' => [
                'container' => 'py-8 sm:py-12 bg-primary dark:bg-primary-sat min-h-screen relative overflow-hidden',
                'wrapper' => 'max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10',
                'header' => 'text-center mb-12',
                'title' => 'text-4xl md:text-5xl font-extrabold text-secondary-sat dark:text-secondary-desat tracking-tight drop-shadow-sm mb-4',
                'subtitle' => 'text-lg md:text-xl text-secondary dark:text-tertiary-desat max-w-2xl mx-auto',
            ],
            'section' => [
                'container' => 'mb-12 bg-primary/80 dark:bg-primary-900/80 backdrop-blur-md rounded-[2rem] p-6 sm:p-10 border border-tertiary/20 shadow-xl relative overflow-hidden',
                'header' => 'flex items-center gap-4 mb-6',
                'icon_wrapper' => 'w-12 h-12 rounded-2xl bg-accent/10 flex items-center justify-center text-accent ring-1 ring-accent/20 shadow-sm shrink-0',
                'title' => 'text-2xl font-bold text-secondary-sat dark:text-secondary-desat',
                'content' => 'text-secondary dark:text-tertiary-desat space-y-4 leading-relaxed',
                'grid' => 'grid grid-cols-1 md:grid-cols-2 gap-6 mt-8',
            ],
            'card' => [
                'container' => 'p-6 rounded-2xl bg-tertiary-desat/5 border border-tertiary/10 hover:bg-tertiary-desat/10 transition-colors',
                'icon' => 'text-3xl mb-4 block',
                'title' => 'text-lg font-bold text-secondary-sat dark:text-secondary-desat mb-2',
                'desc' => 'text-sm text-secondary dark:text-tertiary-desat',
            ],
            // Decoraciones de fondo minimalistas
            'bg_blob_1' => 'absolute top-0 right-0 w-[500px] h-[500px] bg-accent/5 rounded-full blur-[100px] pointer-events-none -mr-48 -mt-48',
            'bg_blob_2' => 'absolute bottom-0 left-0 w-[600px] h-[600px] bg-blue-500/5 rounded-full blur-[120px] pointer-events-none -ml-48 -mb-48',
        ];
    @endphp

    <div class="{{ $classes['page']['container'] }}">
        <!-- Minimal Background Decorations -->
        <div class="{{ $classes['bg_blob_1'] }}"></div>
        <div class="{{ $classes['bg_blob_2'] }}"></div>

        <div class="{{ $classes['page']['wrapper'] }}">
            
            <!-- Encabezado de la página -->
            <div class="{{ $classes['page']['header'] }}">
                <h1 class="{{ $classes['page']['title'] }}">Centro de Ayuda</h1>
                <p class="{{ $classes['page']['subtitle'] }}">
                    Conoce cómo funciona KickCam y saca el máximo provecho a todas sus características y coleccionables.
                </p>
            </div>

            <!-- Sección: ¿Qué es KickCam? -->
            <div class="{{ $classes['section']['container'] }}">
                <div class="{{ $classes['section']['header'] }}">
                    <div class="{{ $classes['section']['icon_wrapper'] }}">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <h2 class="{{ $classes['section']['title'] }}">Acerca del Proyecto</h2>
                </div>
                <div class="{{ $classes['section']['content'] }}">
                    <p>
                        <strong>KickCam</strong> es una plataforma interactiva diseñada para apasionados del deporte y el coleccionismo digital. 
                        Combina la emoción de seguir resultados en tiempo real con una rica experiencia de trivia y realidad aumentada.
                    </p>
                    <p>
                        A través de nuestra aplicación, puedes construir una colección virtual escaneando tarjetas físicas mediante la "Cámara AR", 
                        pon a prueba tus conocimientos sobre países e historia deportiva, y mantente al tanto de lo que sucede en el mundo 
                        con nuestros marcadores en vivo integrados.
                    </p>
                </div>
            </div>

            <!-- Sección: Guía de Navegación (Grid) -->
            <div class="{{ $classes['section']['container'] }}">
                <div class="{{ $classes['section']['header'] }}">
                    <div class="{{ $classes['section']['icon_wrapper'] }}">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"></path>
                        </svg>
                    </div>
                    <h2 class="{{ $classes['section']['title'] }}">Guía de Navegación</h2>
                </div>
                
                <div class="{{ $classes['section']['content'] }}">
                    <p>Explora las diferentes secciones de la plataforma desde el menú principal:</p>
                </div>

                <div class="{{ $classes['section']['grid'] }}">
                    <!-- Dashboard -->
                    <div class="{{ $classes['card']['container'] }}">
                        <span class="{{ $classes['card']['icon'] }}">👤</span>
                        <h3 class="{{ $classes['card']['title'] }}">Dashboard (Perfil)</h3>
                        <p class="{{ $classes['card']['desc'] }}">Tu centro personal. Aquí puedes ver tu progreso, puntos acumulados, logros generales desbloqueados y tu avance en la colección Mundial AR.</p>
                    </div>

                    <!-- Trivia -->
                    <div class="{{ $classes['card']['container'] }}">
                        <span class="{{ $classes['card']['icon'] }}">🧠</span>
                        <h3 class="{{ $classes['card']['title'] }}">Trivia</h3>
                        <p class="{{ $classes['card']['desc'] }}">Pon a prueba tus conocimientos en múltiples modos (Mundial, Banderas, Escudos e Idiomas) o selecciona un país en específico para jugar preguntas personalizadas.</p>
                    </div>

                    <!-- Marcadores -->
                    <div class="{{ $classes['card']['container'] }}">
                        <span class="{{ $classes['card']['icon'] }}">📊</span>
                        <h3 class="{{ $classes['card']['title'] }}">Marcadores</h3>
                        <p class="{{ $classes['card']['desc'] }}">Resultados deportivos actualizados desde TheSportsDB. Revisa las tablas generales, partidos recientes (incluyendo video highlights) y los próximos encuentros programados.</p>
                    </div>

                    <!-- AR Camera -->
                    <div class="{{ $classes['card']['container'] }}">
                        <span class="{{ $classes['card']['icon'] }}">📷</span>
                        <h3 class="{{ $classes['card']['title'] }}">Cámaras y Filtros</h3>
                        <p class="{{ $classes['card']['desc'] }}">Escanea objetivos físicos (marcadores de imágenes) para desbloquear modelos 3D en tu colección con la <strong>Cámara AR</strong>. Diviértete probando efectos faciales usando la <strong>Cámara de Filtros</strong>.</p>
                    </div>
                </div>
            </div>

            <!-- Sección: FAQ y Tips -->
            <div class="{{ $classes['section']['container'] }}">
                <div class="{{ $classes['section']['header'] }}">
                    <div class="{{ $classes['section']['icon_wrapper'] }}">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"></path>
                        </svg>
                    </div>
                    <h2 class="{{ $classes['section']['title'] }}">Tips para la mejor experiencia</h2>
                </div>
                <ul class="list-disc list-inside {{ $classes['section']['content'] }} space-y-2 marker:text-accent">
                    <li><strong>Aprovecha los Tooltips:</strong> Coloca el cursor (o toca) diferentes elementos de la pantalla para obtener más información y contexto de la interfaz.</li>
                    <li><strong>Permisos de Cámara:</strong> Para usar la Cámara AR o de Filtros, asegúrate de haber concedido los permisos de cámara a tu navegador.</li>
                    <li><strong>Desbloqueando Logros:</strong> Obtendrás "Logros Generales" como recompensa sorpresa conforme interactúas con diferentes módulos del sistema ocultos. ¡Sigue explorando!</li>
                    <li><strong>Ajustes Visuales:</strong> Desde "Editar Perfil", puedes personalizar el tema de la aplicación (Claro/Oscuro) a tu preferencia visual.</li>
                </ul>
            </div>

        </div>
    </div>
</x-app-layout>

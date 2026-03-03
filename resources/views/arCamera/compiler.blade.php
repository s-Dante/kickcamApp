<x-app-layout title="AR Compiler">
    <div
        class="max-w-2xl mx-auto p-8 mt-10 bg-[var(--bg-tertiary)] border border-[var(--border-tertiary)] rounded-xl shadow-2xl text-center">
        <h1 class="text-3xl font-black text-[var(--accent)] mb-4 uppercase tracking-wider font-montserrat">Generador
            Avanzado de Tracker AR</h1>
        <p class="text-[var(--text-secondary)] mb-8">Esta herramienta interna toma todos los {{ count($images) }}
            escudos procesados (con contraste de bordes blancos) y utiliza el compilador local de MindAR para empacarlos
            en el binario final de rastreo.</p>

        <div id="status-container" class="mb-8">
            <div class="text-xl font-bold text-[var(--text-primary)] mb-2" id="status-text">Listo para empezar</div>
            <div class="w-full bg-[var(--bg-secondary)] rounded-full h-4 relative overflow-hidden">
                <div id="progress-bar" class="bg-[var(--accent)] h-4 rounded-full transition-all duration-300"
                    style="width: 0%"></div>
            </div>
            <div id="progress-detail" class="text-sm text-[var(--text-secondary)] mt-2"></div>
        </div>

        <button id="start-btn" onclick="startCompile()"
            class="px-8 py-4 bg-[var(--accent)] text-white font-bold rounded-lg hover:bg-opacity-80 transition-all shadow-lg shadow-[var(--accent)]/20">
            COMPILAR TRACKER (.MIND)
        </button>
    </div>

    @push('scripts')
        <script type="module">
            import { Compiler } from 'https://cdn.jsdelivr.net/npm/mind-ar@1.2.5/dist/mindar-image.prod.js';
            window.MindARCompiler = Compiler;
            
            const imagePaths = @json($images);
            
            window.startCompile = async function() {
                const btn = document.getElementById('start-btn');
                const statusText = document.getElementById('status-text');
                const progressBar = document.getElementById('progress-bar');
                const progressDetail = document.getElementById('progress-detail');
                
                btn.disabled = true;
                btn.classList.add('opacity-50', 'cursor-not-allowed');
                statusText.innerText = "Cargando imágenes en memoria...";
                
                try {
                    const compiler = new window.MindARCompiler();
                    const imageElements = [];
                    
                    // Load all images sequentially
                    for(let i=0; i<imagePaths.length; i++) {
                        const imgName = imagePaths[i];
                        const img = new Image();
                        img.src = '/assets/ar-compiler-targets/' + imgName;
                        img.crossOrigin = "anonymous"; // just in case
                        await new Promise((resolve, reject) => {
                            img.onload = resolve;
                            img.onerror = reject;
                        });
                        imageElements.push(img);
                        progressDetail.innerText = `Cargado ${i+1}/${imagePaths.length}: ${imgName}`;
                    }
                    
                    statusText.innerText = "Compilando Topología de 110 Imágenes... (Esto puede tardar un minuto)";
                    progressDetail.innerText = "Extraing Keypoints para alta fidelidad AR";

                    // Compile Using MindAR built-in Engine
                    await compiler.compileImageTargets(imageElements, (progress) => {
                        const percents = Math.round(progress);
                        progressBar.style.width = percents + '%';
                        progressDetail.innerText = `Compilando Marcadores: ${percents}%`;
                    });

                    statusText.innerText = "Empaquetando Archivo Binario (.mind)...";
                    progressBar.style.width = '100%';
                    
                    const exportedBuffer = await compiler.exportData();
                    const blob = new Blob([exportedBuffer], {type: "application/octet-stream"});
                    const url = URL.createObjectURL(blob);
                    
                    const a = document.createElement('a');
                    a.href = url;
                    a.download = 'shields-tracker-optimized.mind';
                    document.body.appendChild(a);
                    a.click();
                    document.body.removeChild(a);
                    URL.revokeObjectURL(url);
                    
                    statusText.innerText = "¡Compilación Éxitosa!";
                    statusText.classList.replace('text-[var(--text-primary)]', 'text-green-400');
                    progressDetail.innerText = "Por favor mueve temporalmente 'shields-tracker-optimized.mind' a la carpeta public/assets/targets-ar/";
                    
                } catch (err) {
                    console.error("Compilation error:", err);
                    statusText.innerText = "Error en compilación";
                    statusText.classList.replace('text-[var(--text-primary)]', 'text-red-500');
                    progressDetail.innerText = err.message || "Ver consola para más detalles.";
                }
            }
        </script>
    @endpush
</x-app-layout>
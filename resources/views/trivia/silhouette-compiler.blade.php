<x-app-layout title="Compilador GeoJSON de Siluetas">
    <div class="max-w-2xl mx-auto p-8 mt-10 bg-[var(--bg-tertiary)] border border-[var(--border-tertiary)] rounded-xl shadow-2xl text-center">
        <h1 class="text-3xl font-black text-[var(--accent)] mb-4 uppercase tracking-wider font-montserrat">
            Convertidor de Shapefile a GeoJSON
        </h1>
        <p class="text-[var(--text-secondary)] mb-8">
            Para mejores resultados, usa los archivos de <b>10m (High Resolution)</b> de <a href="https://www.naturalearthdata.com/downloads/10m-cultural-vectors/" target="_blank" class="text-[var(--accent)] underline">Natural Earth</a>. 
            Sube los archivos <b>.shp</b>, <b>.dbf</b> y <b>.shx</b> para compilar un <code>silhouettes.geojson</code> optimizado y su índice <code>silhouettes-names.json</code>.
        </p>

        <div id="drop-zone" class="mb-8 border-4 border-dashed border-[var(--accent)]/50 rounded-xl p-10 bg-[var(--bg-secondary)] hover:bg-[var(--accent)]/10 transition-colors cursor-pointer">
            <input type="file" id="file-input" multiple accept=".shp,.dbf,.shx" class="hidden">
            <svg class="mx-auto h-12 w-12 text-[var(--accent)] mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path></svg>
            <p class="text-[var(--text-primary)] font-bold text-lg" id="drop-text">Arrastra los archivos .shp, .dbf (y .shx) aquí</p>
            <div id="file-list" class="mt-4 text-left text-sm text-[var(--text-secondary)]"></div>
        </div>

        <div id="status-container" class="mb-8 hidden">
            <div class="text-xl font-bold text-[var(--text-primary)] mb-2" id="status-text">Analizando y Compilando...</div>
            <div class="w-full bg-[var(--bg-secondary)] rounded-full h-4 relative overflow-hidden">
                <div id="progress-bar" class="bg-[var(--accent)] h-4 rounded-full transition-all duration-300 w-full animate-pulse"></div>
            </div>
            <div id="progress-detail" class="text-sm text-[var(--text-secondary)] mt-2">Leyendo binarios con shapefile.js</div>
        </div>

        <button id="start-btn" onclick="startCompile()" disabled
            class="px-8 py-4 bg-[var(--accent)] text-white font-bold rounded-lg hover:bg-opacity-80 transition-all shadow-lg shadow-[var(--accent)]/20 disabled:opacity-50 disabled:cursor-not-allowed">
            CONVERTIR A GEOJSON
        </button>
    </div>

    @push('scripts')
        <!-- Load Shapefile.js to parse the binary SHP/DBF entirely in the client-side -->
        <script src="https://unpkg.com/shapefile@0.6"></script>
        <script>
            let shpFileObj = null;
            let dbfFileObj = null;
            let shxFileObj = null;

            const dropZone = document.getElementById('drop-zone');
            const fileInput = document.getElementById('file-input');
            const startBtn = document.getElementById('start-btn');
            const fileList = document.getElementById('file-list');

            dropZone.addEventListener('click', () => fileInput.click());
            dropZone.addEventListener('dragover', (e) => { e.preventDefault(); dropZone.classList.add('bg-[var(--accent)]/20'); });
            dropZone.addEventListener('dragleave', () => dropZone.classList.remove('bg-[var(--accent)]/20'));
            dropZone.addEventListener('drop', (e) => {
                e.preventDefault();
                dropZone.classList.remove('bg-[var(--accent)]/20');
                handleFiles(e.dataTransfer.files);
            });
            fileInput.addEventListener('change', (e) => handleFiles(e.target.files));

            function handleFiles(files) {
                fileList.innerHTML = '';
                shpFileObj = null;
                dbfFileObj = null;
                
                for(let i=0; i<files.length; i++) {
                    const f = files[i];
                    fileList.innerHTML += `<div>📄 ${f.name}</div>`;
                    if (f.name.toLowerCase().endsWith('.shp')) shpFileObj = f;
                    if (f.name.toLowerCase().endsWith('.dbf')) dbfFileObj = f;
                    if (f.name.toLowerCase().endsWith('.shx')) shxFileObj = f; // Added support for shx index
                }

                if (shpFileObj && dbfFileObj) {
                    startBtn.disabled = false;
                } else {
                    startBtn.disabled = true;
                    fileList.innerHTML += `<div class="text-red-400 mt-2">Error: Debes seleccionar el archivo .shp y su acompañante .dbf</div>`;
                }
            }

            window.startCompile = async function() {
                if (!shpFileObj || !dbfFileObj) return;

                const statusContainer = document.getElementById('status-container');
                const statusText = document.getElementById('status-text');
                const progressDetail = document.getElementById('progress-detail');
                
                startBtn.disabled = true;
                dropZone.classList.add('hidden');
                statusContainer.classList.remove('hidden');
                
                try {
                    // Convert Files mapping to ArrayBuffers
                    statusText.innerText = "Cargando binarios a memoria...";
                    const shpBuffer = await shpFileObj.arrayBuffer();
                    const dbfBuffer = await dbfFileObj.arrayBuffer();
                    const shxBuffer = shxFileObj ? await shxFileObj.arrayBuffer() : null;
                    
                    statusText.innerText = "Transformando Geometrías (Parseando Shapefile)...";
                    
                    // Decode using specific UTF-8 override
                    const source = await shapefile.open(shpBuffer, dbfBuffer, {
                        encoding: 'utf-8',
                        shx: shxBuffer
                    });
                    
                    const geojson = {
                        type: "FeatureCollection",
                        features: []
                    };
                    
                    let result = await source.read();
                    let count = 0;
                    
                    const featureNames = [];
                    
                    while (!result.done) {
                        const feature = result.value;
                        
                        // Clean up: extract essential properties for robust matching
                        const name = feature.properties.NAME || feature.properties.ADMIN || null;
                        const iso2 = feature.properties.ISO_A2 || feature.properties.ADM0_A3_IS || null; // Match ISO2 if available
                        const iso3 = feature.properties.ISO_A3 || feature.properties.ADM0_A3 || null;

                        feature.properties = {};
                        if (name) {
                            const cleanName = name.replace(/\0/g, '').trim();
                            const cleanIso2 = iso2 ? iso2.replace(/\0/g, '').replace(/-99/g, '').trim() : null;
                            const cleanIso3 = iso3 ? iso3.replace(/\0/g, '').replace(/-99/g, '').trim() : null;

                            feature.properties.name = cleanName;
                            if (cleanIso2) feature.properties.iso2 = cleanIso2;
                            if (cleanIso3) feature.properties.iso3 = cleanIso3;

                            // Calculate point count for detail filtering
                            let pointCount = 0;
                            if (feature.geometry.type === 'Polygon') {
                                feature.geometry.coordinates.forEach(ring => pointCount += ring.length);
                            } else if (feature.geometry.type === 'MultiPolygon') {
                                feature.geometry.coordinates.forEach(polygon => {
                                    polygon.forEach(ring => pointCount += ring.length);
                                });
                            }
                            feature.properties.points = pointCount;

                            // Only add to our game if it has a valid name and geometry
                            if (feature.geometry) {
                                geojson.features.push(feature);
                                featureNames.push({
                                    name: cleanName,
                                    iso2: cleanIso2,
                                    iso3: cleanIso3,
                                    points: pointCount
                                });
                                count++;
                            }
                        }
                        
                        progressDetail.innerText = `Extraídas ${count} siluetas...`;
                        result = await source.read();
                    }
                    
                    statusText.innerText = "Finalizando y formateando JSON (para evitar errores en VSCode)...";
                    
                    // 1. Export GeoJSON (For Frontend D3 Rendering)
                    // Added null and 2 to format JSON across multiple lines.
                    // This creates a larger file but prevents VSCode's "Cannot Tokenize" error on huge single lines.
                    const jsonString = JSON.stringify(geojson, null, 2);
                    const blob = new Blob([jsonString], {type: "application/geo+json"});
                    const url = URL.createObjectURL(blob);
                    const a = document.createElement('a');
                    a.href = url;
                    a.download = 'silhouettes.geojson';
                    document.body.appendChild(a);
                    a.click();
                    document.body.removeChild(a);
                    URL.revokeObjectURL(url);
                    
                    // 2. Export Names Index (For Backend PHP fast parsing)
                    const namesString = JSON.stringify(featureNames);
                    const blobNames = new Blob([namesString], {type: "application/json"});
                    const urlNames = URL.createObjectURL(blobNames);
                    const aNames = document.createElement('a');
                    aNames.href = urlNames;
                    aNames.download = 'silhouettes-names.json';
                    document.body.appendChild(aNames);
                    // Slight delay to allow first download to prompt
                    setTimeout(() => {
                        aNames.click();
                        document.body.removeChild(aNames);
                        URL.revokeObjectURL(urlNames);
                    }, 500);

                    statusText.innerText = `¡Éxito! (${count} siluetas compiladas)`;
                    statusText.classList.replace('text-[var(--text-primary)]', 'text-green-400');
                    progressDetail.innerText = "Copia AMBOS archivos descargados ('silhouettes.geojson' y 'silhouettes-names.json') a tu carpeta public/data/";
                    
                } catch (err) {
                    console.error("Compilation error:", err);
                    statusText.innerText = "Error en conversión";
                    statusText.classList.replace('text-[var(--text-primary)]', 'text-red-500');
                    progressDetail.innerText = err.message || "Ver consola para más detalles.";
                }
            }
        </script>
    @endpush
</x-app-layout>

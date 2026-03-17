const fs = require('fs');
const readline = require('readline');

async function processSvg() {
    const fileStream = fs.createReadStream('public/data/silhouettes_raw.svg');
    const rl = readline.createInterface({
        input: fileStream,
        crlfDelay: Infinity
    });

    const silhouettes = {};
    const svgHeader = '<svg viewBox="0 0 1000 1000" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="xMidYMid meet">';
    let pathCount = 0;

    for await (const line of rl) {
        if (line.includes('<path')) {
            // Extract the ID (ISO or Name)
            const idMatch = line.match(/id="([^"]+)"/);
            if (idMatch && idMatch[1]) {
                const name = idMatch[1];
                
                // Keep the path but strip the hardcoded fill if present, let CSS control it
                const gLine = line.replace(/<path[^>]*d="([^"]+)"[^>]*>/i, '<path fill="currentColor" d="$1" />');
                
                // Also we need to ensure the svg wrapper scales correctly bounds. Mapshaper coords can be weird.
                // A better approach is to just keep the <path> we can throw it into an SVG wrapper later, or wrap it now.
                // We'll trust mapshaper's bounds for now, but we just want the path itself.
                const pathMatch = line.match(/d="([^"]+)"/);
                if (pathMatch && pathMatch[1]) {
                    // Just store the raw path data, we will wrap it in Blade
                    silhouettes[name] = pathMatch[1];
                    pathCount++;
                }
            }
        }
    }

    fs.writeFileSync('public/data/silhouettes.json', JSON.stringify(silhouettes));
    console.log(`Successfully generated silhouettes.json with ${pathCount} countries!`);
}

processSvg();

const fs = require('fs');
const sharp = require('sharp');

async function optimize() {
    const files = [
        { name: 'image1.webp', width: 1000 },
        { name: 'court.webp', width: 1000 },
        { name: 'tenis.jpg', width: 1000 },
        { name: 'tenis.webp', width: 1000 },
    ];

    for (let file of files) {
        const path = `public/image/${file.name}`;
        if (fs.existsSync(path)) {
            console.log(`Optimizing ${path}...`);
            const buffer = fs.readFileSync(path);
            await sharp(buffer)
                .resize(file.width, null, { withoutEnlargement: true })
                .webp({ quality: 60 }) // High compression for backgrounds
                .toFile(path);
            console.log(`Done optimizing ${path}`);
        }
    }
}

optimize().catch(console.error);

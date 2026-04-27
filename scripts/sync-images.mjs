import { cpSync, existsSync, mkdirSync, readdirSync, rmSync } from 'node:fs';
import { join, resolve } from 'node:path';

const rootDir = process.cwd();
const targetDir = resolve(rootDir, 'public', 'images');
const hotFile = resolve(rootDir, 'public', 'hot');

const sourceDirs = [
    {
        name: 'public/img',
        path: resolve(rootDir, 'public', 'img'),
    },
    {
        name: 'resources/images',
        path: resolve(rootDir, 'resources', 'images'),
    },
];

function copyContents(sourceDir, destinationDir) {
    const entries = readdirSync(sourceDir, { withFileTypes: true });

    for (const entry of entries) {
        const sourcePath = join(sourceDir, entry.name);
        const destinationPath = join(destinationDir, entry.name);

        cpSync(sourcePath, destinationPath, {
            recursive: true,
            force: true,
            errorOnExist: false,
            dereference: true,
        });
    }
}

if (existsSync(hotFile)) {
    rmSync(hotFile, { force: true });
    console.log('[sync-images] removed public/hot');
}

mkdirSync(targetDir, { recursive: true });

for (const sourceDir of sourceDirs) {
    if (!existsSync(sourceDir.path)) {
        console.warn(`[sync-images] skipped ${sourceDir.name}: not found`);
        continue;
    }

    copyContents(sourceDir.path, targetDir);
    console.log(`[sync-images] merged ${sourceDir.name} -> public/images`);
}

console.log('[sync-images] completed');
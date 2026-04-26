import { readFileSync } from 'node:fs';
import { globSync } from 'glob';
import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

function normalize(path) {
    return path.replace(/\\/g, '/');
}

function legacyCssSource(path) {
    const normalized = path.replace(/^\/+/, '');

    const exactMatches = {
        'css/app.css': 'resources/css/app.css',
        'css/core.css': 'resources/sass/core.scss',
        'css/overrides.css': 'resources/sass/overrides.scss',
        'css/custom-rtl.css': 'resources/sass/base/custom-rtl.scss',
        'css/plugins.css': 'resources/assets/scss/plugins.css',
        'css/style.css': 'resources/assets/scss/style.scss',
        'css/style-rtl.css': 'resources/assets/scss/style-rtl.scss',
    };

    if (exactMatches[normalized]) {
        return exactMatches[normalized];
    }

    if (normalized.startsWith('css/base/')) {
        return `resources/sass/${normalized.slice(4).replace(/\.css$/, '.scss')}`;
    }

    if (normalized.startsWith('vendors/css/')) {
        return `resources/${normalized}`;
    }

    return null;
}

function collectBladeCssInputs() {
    const assetPattern = /Helper::viteAsset\(['"]([^'"]+)['"]\)/g;
    const inputs = new Set();

    for (const view of globSync('resources/views/**/*.blade.php')) {
        const contents = readFileSync(view, 'utf8');

        for (const match of contents.matchAll(assetPattern)) {
            const source = legacyCssSource(match[1]);

            if (source) {
                inputs.add(normalize(source));
            }
        }
    }

    return [...inputs];
}

const inputs = [
    'resources/css/app.css',
    'resources/js/app.js',
    'resources/js/static-assets.js',
    ...collectBladeCssInputs(),
];

export default defineConfig({
    plugins: [
        laravel({
            input: [...new Set(inputs)],
            refresh: true,
        }),
    ],
    css: {
        preprocessorOptions: {
            scss: {
                loadPaths: ['resources/assets', 'resources/assets/scss', 'resources/sass'],
            },
        },
    },
    build: {
        manifest: true,
        rollupOptions: {
            output: {
                manualChunks: undefined,
            },
        },
    },
});

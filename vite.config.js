import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import vue from '@vitejs/plugin-vue';
import path from 'path';

export default defineConfig({
    server: {
        host: 'localhost', // hindari [::1]
        port: 5173,
        cors: true, // fix CORS error
    },
    resolve: {
        alias: {
            '@': path.resolve(__dirname, 'resources/js'), // perbaikan path
        },
    },
    build: {
        chunkSizeWarningLimit: 1500,
    },
    plugins: [
        vue({
            template: {
                transformAssetUrls: {
                    base: null,
                    includeAbsolute: false,
                },
            },
        }),
        laravel({
            input: [
                'resources/js/app.js',
                'resources/css/app.css',
            ],
            refresh: true,
        }),
    ],
});

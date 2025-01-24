import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import vue from '@vitejs/plugin-vue';

export default defineConfig({
    build: {
        resolve: {
            alias: {
              '@': '/resources/js',
            },
          },
        chunkSizeWarningLimit: 1500, // Sesuaikan batas ukuran chunk jika besar
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
                'resources/css/app.css'
            ],
            refresh: true,
        }),
    ],
});

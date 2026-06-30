import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
    input: [
        'resources/css/app.css',
        'resources/css/warehouse-map.css',

        'resources/js/app.js',
        'resources/js/warehouse-map.js',
    ],
    refresh: true,
    }),
    ],
});

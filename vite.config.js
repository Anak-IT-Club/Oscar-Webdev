import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/js/adminlte.js',
                'resources/js/landing.js',
            ],
            refresh: true,
        }),
    ],
});

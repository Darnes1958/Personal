import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import tailwindcss from '@tailwindcss/vite';

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js',
                'resources/css/filament/acc/theme.css',
                'resources/css/filament/admin/theme.css',
                'resources/css/filament/card/theme.css',
            ],
            refresh: true,
        }),
        tailwindcss(),
    ],
});

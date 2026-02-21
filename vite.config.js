import { defineConfig } from 'vite';
import laravel, {refreshPaths} from 'laravel-vite-plugin';
import tailwindcss from '@tailwindcss/vite';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/js/app.js',
                'resources/css/filament/team/theme.css',
                'resources/css/filament/team/custom-sidebar.css',
                'resources/css/filament/admin/theme.css',
            ],
            refresh: [
                ...refreshPaths,
                'app/Filament/**',
                'app/Livewire/**',
                'app/Providers/Filament/**',
            ],
        }),
        tailwindcss(),
    ],
    build: {
        rollupOptions: {
            output: {
                manualChunks: {
                    'vendor': ['aos', 'swiper']
                }
            }
        }
    }
});

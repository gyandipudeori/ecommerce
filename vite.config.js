import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/js/app.js'
            ],
            refresh: [
                'resources/views/**/*.blade.php',
                'resources/css/**/*.css'
            ],
        }),
    ],
    server: {
        watch: {
            usePolling: true,
            interval: 1000
        }
    },
    build: {
        manifest: true,
        rollupOptions: {
            output: {
                entryFileNames: `assets/[name]-[hash].js`,
                assetFileNames: `assets/[name]-[hash].[ext]`
            }
        }
    }
});
import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig(({ mode }) => {
    const isProduction = mode === 'production';

    return {
        plugins: [
            laravel({
                input: [
                    'resources/sass/app.scss',
                    'resources/js/app.js',
                ],
                refresh: true,
            }),
        ],
        build: {
            rollupOptions: {
                external: isProduction ? ['perfect-scrollbar'] : [],
            },
        },
    };
});

import inertia from '@inertiajs/vite';
import { wayfinder } from '@laravel/vite-plugin-wayfinder';
import tailwindcss from '@tailwindcss/vite';
import vue from '@vitejs/plugin-vue';
import laravel from 'laravel-vite-plugin';
import { bunny } from 'laravel-vite-plugin/fonts';
import { defineConfig } from 'vite';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/js/app.ts',
                'Modules/Admin/Resources/js/admin.js',
                'Modules/Admin/Resources/css/admin.css',
                'Modules/Auth/Resources/js/auth.js',
                'Modules/Auth/Resources/css/auth.css',
                'Modules/Country/Resources/js/country.js',
                'Modules/Country/Resources/css/country.css',
                'Modules/Delivery/Resources/js/delivery.js',
                'Modules/Delivery/Resources/css/delivery.css',
                'Modules/Shipment/Resources/js/shipment.js',
                'Modules/Shipment/Resources/css/shipment.css',
                'Modules/User/Resources/js/user.js',
                'Modules/User/Resources/css/user.css',
            ],
            refresh: true,
            fonts: [
                bunny('Instrument Sans', {
                    weights: [400, 500, 600],
                }),
            ],
        }),
        inertia(),
        tailwindcss(),
        vue({
            template: {
                transformAssetUrls: {
                    base: null,
                    includeAbsolute: false,
                },
            },
        }),
        wayfinder({
            formVariants: true,
        }),
    ],
});

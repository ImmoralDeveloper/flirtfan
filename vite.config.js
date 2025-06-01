import {
    defineConfig
} from 'vite';
import laravel from 'laravel-vite-plugin';
import tailwindcss from "@tailwindcss/vite";
import { globSync } from 'glob';


export default defineConfig({
    plugins: [
        laravel({
            input: [
                ...globSync('resources/css/**/*.css'),
                ...globSync('resources/js/**/*.js')
            ],
            refresh: [`resources/views/**/*`],
        }),
        tailwindcss(),
    ],
    server: {
        host: '127.0.0.1',
        port: 8000, // Aseguramos que no entre en conflicto con Laravel
        cors: true
    },
});
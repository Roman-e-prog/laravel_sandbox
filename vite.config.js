import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import tailwindcss from '@tailwindcss/vite';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.scss', 
                'resources/css/navbar.scss',
                'resources/css/mobile-navbar.scss',
                'resources/css/home.scss',
                'resources/css/register.scss',
                'resources/css/login.scss',
                'resources/css/about.scss',
                'resources/css/forum.scss',
                'resources/css/myAccount.scss',
                'resources/css/create.scss',
                'resources/css/forumposts.scss',
                'resources/css/postlikes.scss',
                'resources/css/adminmessages.scss',
                'resources/css/details.scss',
                'resources/css/blogarticles.scss',
                'resources/css/dashboard-articles.scss',
                'resources/js/app.js',],
            refresh: true,
        }),
        tailwindcss(),
    ],
});

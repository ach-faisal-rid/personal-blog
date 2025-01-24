import './bootstrap';
import '../css/app.css';

import { createApp, h } from 'vue';
import { createInertiaApp } from '@inertiajs/vue3';
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';
import { ZiggyVue } from '../../vendor/tightenco/ziggy';
import GuestLayout from './Layouts/GuestLayout.vue';
import AppLayout from './Layouts/AppLayout.vue';

window.Ziggy = Ziggy;

const appName = import.meta.env.VITE_APP_NAME || 'Laravel';
// Inisialisasi aplikasi Inertia.js
createInertiaApp({
    title: (title) => `${title} - ${appName}`,
    resolve: (name) => {
        const page = resolvePageComponent(`./Pages/${name}.vue`, import.meta.glob('./Pages/**/*.vue'));
        
        // Tentukan layout berdasarkan nama halaman atau logika lainnya
        page.layout = page.layout || (name.includes('Guest') ? GuestLayout : AppLayout);

        return page;
    },
    setup({ el, App, props, plugin }) {
        return createApp({
            render: () => h(App, props),
        })
            .use(plugin)
            .use(ZiggyVue)
            .mount(el);
    },
    progress: {
        color: '#4B5563',
    },
});

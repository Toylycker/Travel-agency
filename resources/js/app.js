import './bootstrap';
import '../css/app.css';

import { createApp, h } from 'vue';
import { createInertiaApp } from '@inertiajs/inertia-vue3';
import { InertiaProgress } from '@inertiajs/progress';
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';
import { ZiggyVue } from '../../vendor/tightenco/ziggy/dist/vue.m';
import { createPinia } from 'pinia';
import VueSplide from '@splidejs/vue-splide';
import i18n from './Locale/i18n';

import "bootstrap/dist/css/bootstrap.min.css"
// import "bootstrap/dist/js/bootstrap.js"

const appName = window.document.getElementsByTagName('title')[0]?.innerText || 'Laravel';
const pinia = createPinia();

// createInertiaApp({
//     title: (title) => `${title} - ${appName}`,
//     resolve: (name) => resolvePageComponent(`./Pages/${name}.vue`, import.meta.glob('./Pages/**/*.vue')),
//     setup({ el, app, props, plugin }) {
//         return createApp({ render: () => h(app, props) })
//             .use(plugin)
//             .use(i18n)
//             .use(pinia)
//             .use(VueSplide)
//             .use(ZiggyVue, Ziggy)
//             .mount(el);
//     },
// });

createInertiaApp({
    resolve: (name) => resolvePageComponent(`./Pages/${name}.vue`, import.meta.glob('./Pages/**/*.vue')),
    // app is changed to App
    setup({ el, App, props, plugin }) {

        const app = createApp({ render: () => h(App, props) })
            .use(plugin)
            .use(i18n)
            .use(pinia)
            .use(VueSplide)
            .use(ZiggyVue, Ziggy)

        const { t, locale } = i18n.global
        app.config.globalProperties.$langName = (target) => {
            if (locale.value == 'eng')
                return target.name;
            else if (locale.value == 'cn') {
                return target.name_cn?target.name_cn:target.name;
            }
        };

        app.config.globalProperties.$langBody = (target) => {
            if (locale.value == 'eng')
                return target.body;
            else if (locale.value == 'cn') {
                return target.body_cn?target.body_cn:target.body;
            }
        };

        app.mount(el);
    },
});


InertiaProgress.init({ color: '#4B5563' });

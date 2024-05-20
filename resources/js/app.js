import './bootstrap';
import '../css/app.css';

import {createApp, h} from 'vue';
import {createInertiaApp} from '@inertiajs/vue3';
import {resolvePageComponent} from 'laravel-vite-plugin/inertia-helpers';
import {ZiggyVue} from '../../vendor/tightenco/ziggy/dist/index.esm.js';
import {library} from '@fortawesome/fontawesome-svg-core';
import {FontAwesomeIcon} from "@fortawesome/vue-fontawesome";
import {
    faBars,
    faChevronDown,
    faChevronLeft,
    faChevronRight,
    faChevronUp,
    faClose,
    faMinus,
    faPen,
    faPlus,
    faTrash,
    faLocationDot,
    faEnvelope,
    faPhone
} from "@fortawesome/free-solid-svg-icons";

library.add(
    faMinus,
    faPlus,
    faClose,
    faBars,
    faChevronRight,
    faChevronLeft,
    faChevronUp,
    faChevronDown,
    faPen,
    faTrash,
    faLocationDot,
    faEnvelope,
    faPhone
);

createInertiaApp({
    title: (title) => `${title} | Blue Bird Big Band`,
    resolve: (name) => resolvePageComponent(`./Pages/${name}.vue`, import.meta.glob('./Pages/**/*.vue')),
    setup({el, App, props, plugin}) {
        return createApp({render: () => h(App, props)})
            .use(plugin)
            .use(ZiggyVue, Ziggy)
            .component('font-awesome-icon', FontAwesomeIcon)
            .mount(el);
    },
    progress: {
        color: '#48D621',
    },
});

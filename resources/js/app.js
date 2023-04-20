import './bootstrap';
import '../css/app.css';

import {createApp, h} from 'vue';
import {createInertiaApp} from '@inertiajs/vue3';
import {resolvePageComponent} from 'laravel-vite-plugin/inertia-helpers';
import {ZiggyVue} from '../../vendor/tightenco/ziggy/dist/vue.m';
import {library} from '@fortawesome/fontawesome-svg-core';
import {FontAwesomeIcon} from "@fortawesome/vue-fontawesome";
import {
    faBars,
    faChevronLeft,
    faChevronRight,
    faClose,
    faMinus,
    faPen,
    faPlus,
    faTrash
} from "@fortawesome/free-solid-svg-icons";

library.add(faMinus, faPlus, faClose, faBars, faChevronRight, faChevronLeft, faPen, faTrash);

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

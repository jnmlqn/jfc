import './bootstrap';  
import '../css/app.css';  
  
import { createApp, h, DefineComponent } from 'vue';  
import { createInertiaApp } from '@inertiajs/vue3';  
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';

const appName = window.document.getElementsByTagName('title')[0]?.innerText || 'JFC';

createInertiaApp({
    title: (title) => `${title} - ${appName}`,
    resolve: (name) => resolvePageComponent(`./Pages/${name}.vue`, import.meta.glob<DefineComponent>('./Pages/**/*.vue')),  
    setup({ el, App, props, plugin }) {
        const myApp = createApp({ render: () => h(App, props) })  
            .use(plugin);

        myApp.mount(el);
    },
    progress: {  
        color: '#4B5563',  
    },
});
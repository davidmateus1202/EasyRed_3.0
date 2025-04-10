import './bootstrap';

import { createApp } from 'vue';
import router from './Routes';
import app from './app.vue';
import PrimeVue from 'primevue/config';
import 'primeicons/primeicons.css'
import '../css/app.css';
import { createPinia } from 'pinia'
import piniaPluginPersistedstate from 'pinia-plugin-persistedstate'


const App = createApp(app);
const pinia = createPinia();
pinia.use(piniaPluginPersistedstate);

App.use(router)
    .use(pinia)
    .use(PrimeVue)
    .mount('#app');
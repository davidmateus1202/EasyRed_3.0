import './bootstrap';

import { createApp } from 'vue';
import router from './Routes';
import app from './app.vue';
import PrimeVue from 'primevue/config';
import 'primeicons/primeicons.css'
import '../css/app.css';


const App = createApp(app);

App.use(router)
    .use(PrimeVue)
    .mount('#app');
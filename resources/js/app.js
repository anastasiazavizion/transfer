import './bootstrap';

import App from "./App.vue";
import { createApp } from 'vue'

import 'bootstrap/dist/css/bootstrap.min.css';
import 'bootstrap/dist/js/bootstrap.bundle.min.js';

import router from "./router/index.js";
import store from "./store/index.js";
import { Ziggy } from './ziggy';

const app= createApp(App)
    .use(router)
    .use(store)
    .use(Ziggy)

app.mount('#app')

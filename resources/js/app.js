import './bootstrap';

import { createApp} from 'vue';
import { createPinia } from 'pinia';

import app from './layouts/app.vue'; 
import router from './router';
import 'remixicon/fonts/remixicon.css'
const pinia = createPinia();
const App = createApp(app)
App.use(pinia);
App.use(router);

App.mount("#app");
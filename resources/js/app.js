import './bootstrap';

import { createApp} from 'vue';
import { createPinia } from 'pinia';

import app from './layouts/app.vue'; 
import router from './router';
import 'remixicon/fonts/remixicon.css';
import { autoAnimatePlugin } from '@formkit/auto-animate/vue';

const pinia = createPinia();
const App = createApp(app);
App.use(pinia);
App.use(router);
App.use(autoAnimatePlugin);


App.mount("#app");
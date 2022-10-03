
import { createRouter, createWebHistory } from 'vue-router';

const routes = [
    {
        path: '/',
        name: 'dashboard',
        component: () => import('./pages/dashboard.vue'),
    },
    {
        path: '/login',
        name: 'login',
        component: () => import('./pages/login.vue'),
    },
    {
        path: '/register',
        name: 'register',
        component: () => import('./pages/register.vue'),
    }
    

];
const router = createRouter({
    history: createWebHistory(),
    routes,
});
export default router;
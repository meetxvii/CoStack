import {CheckAdminLogin} from './composables/checkAdminLogin';
import {useAdmin} from './stores/Admin';
import { createRouter, createRouterMatcher, createWebHistory } from 'vue-router';

const routes = [
    {
        path: '/',
        name: 'dashboard',
        component: () => import('./pages/dashboard.vue'),
    },
    {
        path: '/Technologies',
        name: 'technologies',
        component: () => import('./pages/Technologies.vue'),
    },
    {
        path: '/Featured',
        name: 'Featured',
        component: () => import('./pages/Featured.vue'),
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
    },
    {
        path: '/verification',
        name: 'verification',
        component: () => import('./pages/verification.vue'),
    },
    {
        path: '/verified/:token',
        name: 'verified',
        component: () => import('./pages/verified.vue'),
    },
    {
        path: '/reset-password',
        name: 'reset-password',
        component: () => import('./pages/ResetPassword.vue'),
    },
    {
        path: '/set-password/:token',
        name: 'set-password',
        component: () => import('./pages/SetPassword.vue'),
    },
    {
        path: '/admin',
        name: 'admin',
        component: () => import('./pages/admin/dashboard.vue'),
        meta:{requiresAdminAuth:true}
    },
    {
        path: '/admin/login',
        name: 'admin-login',
        component: () => import('./pages/admin/login.vue'),
    },
    {
        path: '/admin/users',
        name: 'admin-users',
        component: () => import('./pages/admin/Users.vue'),
        meta:{requiresAdminAuth:true}
    },
    {
        path: '/admin/technologies',
        name: 'admin-technologies',
        component: () => import('./pages/admin/Technologies.vue'),
        meta:{requiresAdminAuth:true}
    },
    
    {
        path: '/admin/reports',
        name: 'admin-reports',
        component: () => import('./pages/admin/Reports.vue'),
        meta:{requiresAdminAuth:true}
    },

    {
        path: '/technology/:name',
        name: 'technology',
        component: () => import('./pages/Technology.vue'),
    },
    {
        path: '/questions/user/:id',
        name: 'user-question',
        component: () => import('./pages/UserQuestions.vue'),
    },
    {
        path: '/question/:id',
        name: 'question',
        component: () => import('./pages/Question.vue'),
    },
    {
        path: '/:pathMatch(.*)*',
        name: '404',
        component: () => import('./pages/404.vue'),
    }
    

];
const router = createRouter({
    history: createWebHistory(),
    routes,
});

router.beforeEach(async(to, from, next) => {
    if(to.meta.requiresAdminAuth){
        await CheckAdminLogin();
        
        if(useAdmin().isLoggedIn){
            next();
        }
        else{
            next({name:'admin-login'});
        }
    }
    next();
    
});


export default router;
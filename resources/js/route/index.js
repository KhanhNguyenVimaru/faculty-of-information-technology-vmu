import { createRouter, createWebHistory } from 'vue-router';
import HeadNavigation from '../components/HeadNavigation.vue';
    
const routes = [
    { path: '/', component: HeadNavigation }
];

const router = createRouter({
    history: createWebHistory(),
    routes,
});

export default router;

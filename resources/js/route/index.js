import { createRouter, createWebHistory } from 'vue-router';
import HomeView from '../pages/HomeView.vue';
import LoginPage from '../pages/LoginPage.vue';
import DashBoardPage from '../pages/DashBoardPage.vue';

const routes = [
    { path: '/', component: HomeView},
    { path: '/login', component: LoginPage},
    { path: '/manage-dashboard', component: DashBoardPage}
];

const router = createRouter({
    history: createWebHistory(),
    routes,
});

export default router;

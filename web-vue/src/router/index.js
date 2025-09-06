import { createRouter, createWebHistory } from 'vue-router';

// Import các trang chính trực tiếp
import HomeView from '../pages/HomeView.vue';
import LoginPage from '../pages/LoginPage.vue';
import DashBoardPage from '../pages/manage/DashBoardPage.vue';

// Sử dụng lazy loading cho các route khác để tối ưu hiệu suất
const PostsPage = () => import('../pages/manage/PostsPage.vue');
const StudentsPage = () => import('../pages/manage/StudentsPage.vue');
const ProfessorsPage = () => import('../pages/manage/ProfessorsPage.vue');
const EducationManagementPage = () => import('../pages/manage/EducationManagementPage.vue');
const AdmissionPage = () => import('../pages/manage/AdmissionPage.vue');
const SettingsPage = () => import('../pages/manage/SettingsPage.vue');

const routes = [
    { path: '/', component: HomeView},
    { path: '/login', component: LoginPage},
    { path: '/manage-dashboard', component: DashBoardPage},
    { path: '/posts', component: PostsPage },
    { path: '/students', component: StudentsPage },
    { path: '/professors', component: ProfessorsPage },
    { path: '/education-management', component: EducationManagementPage },
    { path: '/admission', component: AdmissionPage },
    { path: '/settings', component: SettingsPage }
];

const router = createRouter({
    history: createWebHistory(),
    routes,
});

export default router;

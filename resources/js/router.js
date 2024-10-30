import { createRouter, createWebHistory } from 'vue-router';
import Index from './Components/Index.vue';
import axios from "axios";
import Create from "./Components/Create.vue";

const routes = [
    {
        path: '/',
        name: 'deals.index',
        component: Index,
    },
    {
        path: '/create',
        name: 'deals.create',
        component: Create,
    }
];

axios.interceptors.response.use(
    response => response,
    error => {
        if (error.response && error.response.status === 401) {
            window.location.href = '/login';
        }
        return Promise.reject(error);
    }
);

const router = createRouter({
    history: createWebHistory(),
    routes: routes,
});

export default router;

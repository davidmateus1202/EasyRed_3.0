import { createRouter, createWebHistory } from "vue-router";

import Login from "../Pages/Login.vue";
import Home from "../Pages/Home.vue";

const routes = [
    {
        path: "/login",
        name: "Login",
        component: Login,
    },
    {
        path: "/home",
        name: "Home",
        component: Home,
    }
];

const router = createRouter({
    history: createWebHistory(),
    routes
});

export default router;


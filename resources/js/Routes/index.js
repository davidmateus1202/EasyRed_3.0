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

router.beforeEach((to, from, next) => {
    const token = localStorage.getItem("token");

    if (to.name !== "Login" && !token) {
        next({ name: "Login" });
    }

    if (to.name === "Login" && token) {
        next({ name: "Home" });
    }

    next();
})

export default router;


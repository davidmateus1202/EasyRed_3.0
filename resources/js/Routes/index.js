import { createRouter, createWebHistory } from "vue-router";

import Login from "../Pages/Login.vue";
import Home from "../Pages/Home.vue";
import Register from "../Pages/Register.vue";

const routes = [
    {
        path: "/",
        name: "Login",
        component: Login,
    },
    {
        path: "/home",
        name: "Home",
        component: Home,
    },
    {
        path: "/register",
        name: "Register",
        component: Register,
    }
];

const router = createRouter({
    history: createWebHistory(),
    routes
});

router.beforeEach((to, from, next) => {
    const token = localStorage.getItem("token");

    if (to.name !== "Login" && to.name !== "Register" && !token) {
        return next({ name: "Login" });
    }

    if (to.name === "Login" && token) {
        return next({ name: "Home" });
    }

    if (to.name === "Register" && token) {
        return next({ name: "Home" });
    }

    next();
})

export default router;


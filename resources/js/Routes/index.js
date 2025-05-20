import { createRouter, createWebHistory } from "vue-router";

import Login from "../Pages/Login.vue";
import Home from "../Pages/Home.vue";
import Register from "../Pages/Register.vue";
import ProfilePage from "../Pages/ProfilePage.vue";

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
        requiredAuth: true,
    },
    {
        path: "/register",
        name: "Register",
        component: Register,
    },
    {
        path: "/profile",
        name: "Profile",
        component: ProfilePage,

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


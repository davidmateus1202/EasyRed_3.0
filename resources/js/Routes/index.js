import { createRouter, createWebHistory } from "vue-router";

import Login from "../Pages/Login.vue";
import Home from "../Pages/Home.vue";
import Register from "../Pages/Register.vue";
import GroupList from "../Components/Feed/GroupList.vue";
import GroupDetail from "../Components/Feed/GroupDetail.vue";

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
    },
    {
        path: "/groups",
        name: "GroupList",
        component: GroupList,
    },
    {
        path: "/groups/:id",
        name: "GroupDetail",
        component: GroupDetail,
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

    if ((to.name === "Login" || to.name === "Register") && token) {
        return next({ name: "Home" });
    }

    next();
});

export default router;

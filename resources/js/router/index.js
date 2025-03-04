import { createRouter, createWebHistory } from "vue-router";
import Home from "@/Pages/Home.vue";
import Destination from "@/Pages/Destination.vue";
import Success from "@/Pages/Success.vue";
import Admin from "@/Pages/Admin/Admin.vue";
import OrderEdit from "@/Pages/Admin/Orders/Edit.vue";
import Login from "@/Pages/Auth/Login.vue";
import store from "../store/index.js";

const routes = [
    {
        path: '/',
        name:"home",
        component: Home,
        meta: {
            middleware: ["guest"],
        },
    },

    {
        path: '/destination',
        name:"destination",
        component: Destination,
        meta: {
            middleware: ["guest"],
        },
    },

    {
        path: '/success/:orderId',
        name:"success",
        component: Success,
        meta: {
            middleware: ["guest"],
        },
    },

    {
        path: '/admin',
        name:"admin",
        component: Admin,
        meta: {
            middleware: ["admin"],
        },
    },

    {
        path: '/admin/order/:orderId',
        name:"admin.order",
        component: OrderEdit,
        meta: {
            middleware: ["admin"],
        },
    },

    {
        name:"login",
        path:"/auth/login",
        component:Login,
        meta:{
            middleware:"guest",
            title:`Login`
        }
    },

    {
        path:"/:notFound(.*)",
        redirect:'/'
    },
];

const router =  createRouter({
    history: createWebHistory(),
    routes,
});

router.beforeEach(async (to, from, next) => {
    const middleware = to.meta.middleware;
    if (middleware === "guest" || middleware === undefined) {
        next()
    } else {
        const isAdmin = store.getters['auth/user'].is_admin;
        if (isAdmin) {
            next()
        } else {
            await store.dispatch('auth/logout')
            next({name: "login"})
        }
    }
})

export default router;

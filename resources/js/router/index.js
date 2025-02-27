import { createRouter, createWebHistory } from "vue-router";
import Home from "@/Pages/Home.vue";
import Destination from "@/Pages/Destination.vue";
import Success from "@/Pages/Success.vue";

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
        path:"/:notFound(.*)",
        redirect:'/'
    },
];

const router =  createRouter({
    history: createWebHistory(),
    routes,
});

export default router;

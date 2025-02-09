import { createRouter, createWebHistory } from "vue-router";
import Home from "@/Pages/Home.vue";

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
        path:"/:notFound(.*)",
        redirect:'/'
    },
];

const router =  createRouter({
    history: createWebHistory(),
    routes,
});

export default router;

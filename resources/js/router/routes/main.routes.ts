import type { RouteRecordRaw } from "vue-router";

export default [
    {
        path: "/",
        name: "index",
        component: () => import("@/pages/Index.vue"),
    },
    {
        path: "/article/:slug",
        props: true,
        name: "article",
        component: () => import("@/pages/Article/Index.vue"),
    },
] as RouteRecordRaw[];

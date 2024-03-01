import type { RouteRecordRaw } from "vue-router";

export default [
    {
        path: "article/add",
        name: "admin.article.add",
        component: () => import("@/pages/Admin/Article/Add.vue"),
    },
    {
        path: "article/:slug/update",
        name: "admin.article.update",
        props: true,
        component: () => import("@/pages/Admin/Article/Update.vue"),
    },
] as RouteRecordRaw[];

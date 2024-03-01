import type { RouteRecordRaw } from "vue-router";
import adminRoutes from "./admin.routes";
import mainRoutes from "./main.routes";

export const routes = [
    ...mainRoutes,
    {
        path: "/admin",
        children: adminRoutes,
    },
    {
        path: "/:pathMatch(.*)*",
        name: "error.notFound",
        component: () => import("@/pages/Errors/NotFound.vue"),
    },
] as RouteRecordRaw[];

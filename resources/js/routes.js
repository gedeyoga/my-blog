import Vue from "vue";
import VueRouter from "vue-router";

import UserRoutes from "./modules/User/UserRoutes";
import RoleRoutes from "./modules/Role/RoleRoutes";
import DashboardRoutes from "./modules/Dashboard/DashboardRoutes";
import CategoryRoutes from "./modules/Category/CategoryRoutes";

Vue.use(VueRouter);

const routes = [
    ...UserRoutes,
    ...RoleRoutes,
    ...DashboardRoutes,
    ...CategoryRoutes
];

const router = new VueRouter({
    mode: "history",
    routes: routes,
});

export default router;
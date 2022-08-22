import Vue from "vue";
import VueRouter from "vue-router";

import UserRoutes from "./modules/User/UserRoutes";
import DashboardRoutes from "./modules/Dashboard/DashboardRoutes";

Vue.use(VueRouter);

const routes = [
    ...UserRoutes,
    ...DashboardRoutes
];

const router = new VueRouter({
    mode: "history",
    routes: routes,
});

export default router;
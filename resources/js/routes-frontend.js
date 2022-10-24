import Vue from "vue";
import VueRouter from "vue-router";
import FrontEndRoutes from "./modules/Frontend/FrontEndRoutes";

Vue.use(VueRouter);

const routes = [
    ...FrontEndRoutes,
];

const router = new VueRouter({
    mode: "history",
    routes: routes,
});

export default router;

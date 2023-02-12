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
    scrollBehavior(to, from, savedPosition) {
        // always scroll to top
        if (savedPosition) {
            return savedPosition;
        } else {
            return { y: 0 };
        }
    },
});

export default router;

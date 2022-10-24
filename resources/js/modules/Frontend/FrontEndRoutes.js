import HomeComponent from "./Pages/HomeComponent.vue";
import ArticleComponent from "./Pages/ArticleComponent.vue";

let meta = {
    layout: 'front-end'
};

export default [
    {
        path: "/",
        name: "home",
        component: HomeComponent,
        meta: meta,
    },
    {
        path: "/article/:slug",
        name: "article",
        component: ArticleComponent,
        meta: meta,
    },
];

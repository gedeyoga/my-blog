import HomeComponent from "./Pages/HomeComponent.vue";
import DetailArticleComponent from "./Pages/DetailArticleComponent.vue";
import ContentPageComponent from "./Pages/ContentPageComponent.vue";

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
        name: "article.detail",
        component: DetailArticleComponent,
        meta: meta,
    },
    {
        path: "/article",
        name: "article.list",
        component: ContentPageComponent,
        meta: meta,
    },
];

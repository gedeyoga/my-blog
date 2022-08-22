/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

window.Vue = require('vue').default;

import ElementUI  from "element-ui";
import locale from "element-ui/lib/locale/lang/en";
import Vue from "vue";
import App from "./components/core/App";
import routes from "./routes";

window.axios = require("axios");

window.axios.defaults.headers.common["X-Requested-With"] = "XMLHttpRequest";

/**
 * Next we will register the CSRF Token as a common header with Axios so that
 * all outgoing HTTP requests automatically have it attached. This is just
 * a simple convenience so we don't have to attach every token manually.
 */

const token = document.head.querySelector('meta[name="csrf-token"]');

if (token) {
    window.axios.defaults.headers.common["X-CSRF-TOKEN"] = token.content;
} else {
    console.error(
        "CSRF token not found: https://laravel.com/docs/csrf#csrf-x-csrf-token"
    );
}

const userApiToken = document.head.querySelector('meta[name="api-token"]');

if (userApiToken) {
    window.axios.defaults.headers.common.Authorization = `Bearer ${userApiToken.content}`;
} else {
    console.error("User API token not found in a meta tag.");
}


require("./mixins.js");
require("./components.js");

Vue.use(ElementUI, { locale });

const base_url = document.head.querySelector('meta[name="base-url"]').content;
Vue.prototype.$url = base_url;
Vue.prototype.$csrfToken = token;

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))



/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */
const app = new Vue({
    el: "#app",
    router: routes,
    render: (h) => h(App),
    methods: {
        splashScreen() {
            return this.$loading({
                lock: true,
                text: "Loading",
                spinner: "el-icon-loading",
                background: "rgba(0, 0, 0, 0.7)",
            });
        }
    },
    created() {
        this.splashScreen();
    },
    mounted() {
        this.splashScreen().close();
    }
});

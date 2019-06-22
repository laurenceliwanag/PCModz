/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require("./bootstrap");

import Vue from "vue";
import Vuetify from "vuetify";
import VueRouter from "vue-router";
import Vuex from "vuex";
import "./plugins/vuetify";
import "@fortawesome/fontawesome-free/css/all.css";
import "material-design-icons-iconfont/dist/material-design-icons.css";
import Axios from "axios";
import { isContext } from "vm";
import { resolve } from "url";
import { reject } from "q";

Vue.use(Vuex);
Vue.use(VueRouter);
Vue.use(Vuetify, {
    iconfont: "md"
});

window.Vue = require("vue");

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i);
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default));

//Main Components
Vue.component("main_vue", require("./components/Main.vue").default);

//User Components
Vue.component("signin", require("./components/user/Signin.vue").default);
Vue.component("signout", require("./components/user/Signout.vue").default);
Vue.component("navbar", require("./components/user/Navbar.vue").default);
Vue.component("v_footer", require("./components/user/Footer.vue").default);
Vue.component("cart", require("./components/user/Cart.vue").default);

Vue.component("home", require("./components/user/Home.vue").default);
Vue.component("products", require("./components/user/Products.vue").default);
Vue.component("product", require("./components/user/Product.vue").default);
Vue.component(
    "buildYourOwn",
    require("./components/user/BuildYourOwn.vue").default
);
Vue.component("gallery", require("./components/user/Gallery.vue").default);
Vue.component("checkout", require("./components/user/Checkout.vue").default);

const Home = { template: "<home></home>" };
const Products = { template: "<products></products>" };
const Product = { template: "<product></product>" };
const BuildYourOwn = { template: "<buildYourOwn></buildYourOwn>" };
const Gallery = { template: "<gallery></gallery>" };
const Signin = { template: "<signin></signin>" };
const Signout = { template: "<signout></signout>" };
const Checkout = { template: "<checkout></checkout>" };

//Admin Components
Vue.component("signin_admin", require("./components/admin/Signin.vue").default);
Vue.component(
    "signout_admin",
    require("./components/admin/Signout.vue").default
);
Vue.component("navbar_admin", require("./components/admin/Navbar.vue").default);
Vue.component(
    "v_footer_admin",
    require("./components/admin/Footer.vue").default
);

Vue.component("dashboard", require("./components/admin/Dashboard.vue").default);
Vue.component("inventory", require("./components/admin/Inventory.vue").default);
Vue.component(
    "categories",
    require("./components/admin/Categories.vue").default
);
Vue.component("orders", require("./components/admin/Orders.vue").default);
Vue.component("order", require("./components/admin/Order.vue").default);

const Dashboard = { template: "<dashboard></dashboard>" };
const Inventory = { template: "<inventory></inventory>" };
const Categories = { template: "<categories></categories>" };
const Orders = { template: "<orders></orders>" };
const Order = { template: "<order></order>" };
const Signin_admin = { template: "<signin_admin></signin_admin>" };
const Signout_admin = { template: "<signout_admin></signout_admin>" };

//Routes
const routes = [
    //User
    { path: "/", component: Home },
    { path: "/products", component: Products },
    { path: "/product/:id", component: Product },
    { path: "/build", component: BuildYourOwn },
    { path: "/gallery", component: Gallery },
    { path: "/checkout", component: Checkout, meta: { requiresAuth: true } },
    { path: "/signin", component: Signin, meta: { requiresVisitor: true } },
    { path: "/signout", component: Signout },

    //Admin
    { path: "/admin/", component: Dashboard, meta: { requiresAdmin: true } },
    {
        path: "/admin/inventory",
        component: Inventory,
        meta: { requiresAdmin: true }
    },
    {
        path: "/admin/categories",
        component: Categories,
        meta: { requiresAdmin: true }
    },
    {
        path: "/admin/orders",
        component: Orders,
        meta: { requiresAdmin: true }
    },
    {
        path: "/admin/order/:invoice",
        component: Order,
        meta: { requiresAdmin: true }
    },
    {
        path: "/admin/signin",
        component: Signin_admin,
        meta: { requiresVisitor_admin: true }
    },
    { path: "/admin/signout", component: Signout_admin }
];

const router = new VueRouter({
    routes // short for `routes: routes`
});

router.beforeEach((to, from, next) => {
    if (to.matched.some(record => record.meta.requiresAuth)) {
        if (!store.state.token) {
            next({
                path: "/signin"
            });
        } else {
            next();
        }
    } else if (to.matched.some(record => record.meta.requiresVisitor)) {
        if (store.state.token) {
            next({
                path: "/"
            });
        } else {
            next();
        }
    } else {
        next();
    }

    if (to.matched.some(record => record.meta.requiresAdmin)) {
        if (!store.state.token_admin) {
            next({
                path: "/admin/signin"
            });
        } else {
            next();
        }
    } else if (to.matched.some(record => record.meta.requiresVisitor_admin)) {
        if (store.state.token_admin) {
            next({
                path: "/admin/"
            });
        } else {
            next();
        }
    } else {
        next();
    }
});

//Vuex
const store = new Vuex.Store({
    state: {
        token: localStorage.getItem("access_token") || null,
        user: {},
        admin: {},
        token_admin: localStorage.getItem("access_token_admin") || null,
        component_title_admin: "",
        navbar_admin: false,
        products: [],
        dialog_carts: false,
        cart: [],
        cart_item: {},
        totalprice: "0",
        filter_name: ""
    },
    mutations: {
        addToCart(state, payload) {
            const existing = this.state.cart.find(p => p.id === payload.id);
            if (!existing) {
                this.state.cart_item = payload;
                this.state.cart.push(this.state.cart_item);
            } else {
                existing.quantity++;
            }

            this.state.cart_item = {};
        },
        removeCart(state, payload) {
            for (var i = 0; i < this.state.cart.length; i++) {
                if (this.state.cart[i] === payload) {
                    this.state.cart.splice(i, 1);
                }
            }
        },
        search_product(state, payload) {
            fetch(`api/search_product/${payload}`)
                .then(res => res.json())
                .then(res => {
                    this.state.products = res;
                })
                .catch(err => console.log(err));
        },
        filter(state, payload) {
            fetch(`api/filter_products/${payload.id}`)
                .then(res => res.json())
                .then(res => {
                    this.state.products = res;
                    this.state.filter_name = payload.name;
                })
                .catch(err => console.log(err));
        },
        load_admin(state, payload) {
            this.state.navbar_admin = true;
            this.state.component_title_admin = payload;
        },
        retrieveToken(state, token) {
            state.token = token;
        },
        retrieveToken_admin(state, token) {
            state.token_admin = token;
        },
        destroyToken(state) {
            state.token = null;
        },
        destroyToken_admin(state) {
            state.token_admin = null;
        }
    },
    actions: {
        fetchUser() {
            axios.defaults.headers.common["Authorization"] =
                "Bearer " + this.state.token;

            axios
                .get("/api/user")
                .then(res => {
                    this.state.user = res.data;
                })
                .catch(err => console.log(err));
        },
        fetchAdmin() {
            axios.defaults.headers.common["Authorization"] =
                "Bearer " + this.state.token_admin;

            axios
                .get("/api/user")
                .then(res => {
                    this.state.admin = res.data;
                })
                .catch(err => console.log(err));
        },
        destroyToken(state) {
            axios.defaults.headers.common["Authorization"] =
                "Bearer " + this.state.token;

            if (this.state.token) {
                return new Promise((resolve, reject) => {
                    axios
                        .post("api/signout")
                        .then(response => {
                            localStorage.removeItem("access_token");
                            state.commit("destroyToken");
                            resolve(response);
                            this.state.user = {};
                        })
                        .catch(error => {
                            localStorage.removeItem("access_token");
                            state.commit("destroyToken");
                            reject(error);
                        });
                });
            }
        },
        destroyToken_admin(state) {
            axios.defaults.headers.common["Authorization"] =
                "Bearer " + this.state.token_admin;

            if (this.state.token_admin) {
                return new Promise((resolve, reject) => {
                    axios
                        .post("api/signout")
                        .then(response => {
                            localStorage.removeItem("access_token_admin");
                            state.commit("destroyToken_admin");
                            resolve(response);
                            this.state.admin = {};
                        })
                        .catch(error => {
                            localStorage.removeItem("access_token_admin");
                            state.commit("destroyToken_admin");
                            reject(error);
                        });
                });
            }
        },
        retrieveToken(state, payload) {
            return new Promise((resolve, reject) => {
                axios
                    .post("api/signin", {
                        username: payload.username,
                        password: payload.password
                    })
                    .then(response => {
                        const token = response.data.access_token;
                        localStorage.setItem("access_token", token);
                        state.commit("retrieveToken", token);
                        resolve(response);
                        this.dispatch("fetchUser");
                    })
                    .catch(error => {
                        console.log(error);
                        reject(error);
                    });
            });
        },
        retrieveToken_admin(state, payload) {
            return new Promise((resolve, reject) => {
                axios
                    .post("api/signin", {
                        username: payload.username,
                        password: payload.password
                    })
                    .then(response => {
                        const token = response.data.access_token;
                        localStorage.setItem("access_token_admin", token);
                        state.commit("retrieveToken_admin", token);
                        resolve(response);
                        this.dispatch("fetchAdmin");
                    })
                    .catch(error => {
                        console.log(error);
                        reject(error);
                    });
            });
        },
        load_main() {
            this.state.navbar_admin = false;
        },
        load_admin(state, payload) {
            state.commit("load_admin", payload);
        },
        search_product(state, payload) {
            state.commit("search_product", payload);
        },
        filter(state, payload) {
            state.commit("filter", payload);
        },
        fetchProducts() {
            fetch("/api/active_products")
                .then(res => res.json())
                .then(res => {
                    this.state.products = res;
                    this.state.filter_name = "";
                })
                .catch(err => console.log(err));
        },
        openCart() {
            this.state.dialog_carts = true;
        },
        closeCart() {
            this.state.dialog_carts = false;
            this.state.cartAdded_message = "";
        },
        viewCart() {
            if (localStorage.getItem("cart")) {
                this.state.cart = JSON.parse(localStorage.getItem("cart"));
                this.state.totalprice = this.state.cart.reduce(
                    (total, item) => {
                        return total + item.quantity * item.srp;
                    },
                    0
                );
                this.state.totalprice = this.state.totalprice.toFixed(2);
            }
        },
        addToCart(state, payload) {
            state.commit("addToCart", payload);
            this.dispatch("storeCart");
            this.dispatch("openCart");
        },
        storeCart() {
            let parsed = JSON.stringify(this.state.cart);
            localStorage.setItem("cart", parsed);
            this.dispatch("viewCart");
        },
        removeCart(state, payload) {
            state.commit("removeCart", payload);
            this.dispatch("storeCart");
        },
        emptyCart() {
            this.state.cart = [];
            this.dispatch("storeCart");
        }
    },
    getters: {}
});

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    router,
    store
}).$mount("#app");

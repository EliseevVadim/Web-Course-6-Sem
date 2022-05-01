import Vue from "vue";
import Vuex from "vuex";
import user from "./modules/user";
import products from "./modules/products";
import orders from "./modules/orders";
import cart from "./modules/cart";
import posts from "./modules/posts";
import checkout from "./modules/checkout";

Vue.use(Vuex);

export const store = new Vuex.Store({
    state: {},
    getters: {},
    mutations: {},
    actions: {},
    modules: {
        user,
        products,
        orders,
        cart,
        posts,
        checkout
    }
});

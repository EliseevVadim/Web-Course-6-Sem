/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */
import {store} from "../../store";

require('./bootstrap');

window.Vue = require('vue').default;

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

Vue.component('example-component', require('./components/ExampleComponent.vue').default);
Vue.component('register-area', require('./components/RegisterArea.vue').default);
Vue.component('auth-area', require('./components/AuthorizationArea.vue').default);
Vue.component('account-settings', require('./components/AccountSettings.vue').default);
Vue.component('logout-button', require('./components/LogoutButton.vue').default);
Vue.component('product', require('./components/Product.vue').default);
Vue.component('product-list', require('./components/ProductList.vue').default);
Vue.component('product-details', require('./components/ProductDetails.vue').default);
Vue.component('cart-list', require('./components/CartArea.vue').default);
Vue.component('news-list', require('./components/NewsList.vue').default);
Vue.component('post', require('./components/Post.vue').default);
Vue.component('checkout-form', require('./components/CheckoutForm.vue').default);
Vue.component('social-redirecting', require('./components/SocialRedirecting.vue').default);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: '#app',
    store
});

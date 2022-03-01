/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');
const DataProcessingWindow = require("./components/DataProcessingWindow");

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

Vue.component('attachment-form', require('./components/AttachmentForm.vue').default);
Vue.component('request-result-window', require('./components/RequestResultWindow.vue').default);
Vue.component('data-processing-window', require('./components/DataProcessingWindow.vue').default);
Vue.component('add-record-button', require('./components/AddRecordButton.vue').default);
Vue.component('edit-record-button', require('./components/EditRecordButton.vue').default);
Vue.component('delete-record-button', require('./components/DeleteRecordButton.vue').default);
Vue.component('confirmation-form', require('./components/ConfirmationForm.vue').default);
Vue.component('delete-file-button', require('./components/DeleteFileButton.vue').default);
Vue.component('deletion-confirmation-form', require('./components/DeleteFileConfirmation.vue').default);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: '#app',
});

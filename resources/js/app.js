/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');
require('./my_scripts');

window.Vue = require('vue');

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i);
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default));
var token = $('meta[name="_token"]').attr('content');
var csrf = $('input[name="_token"]').attr('value');

axios.defaults.headers.common['Authorization'] = 'Bearer ' + token;
axios.defaults.headers.common['X-CSRF-TOKEN'] = csrf;

Vue.component('call-center-rejected-leads', require('./components/CallCenterRejectedLeads.vue').default);
Vue.component('account', require('./components/Account.vue').default);
Vue.component('manager-lead-free', require('./components/ManagerLeadFree.vue').default);
Vue.component('call-center-leads', require('./components/CallCenterLeads.vue').default);
Vue.component('manager-my-leads', require('./components/ManagerMyLeads.vue').default);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: '#app',
});
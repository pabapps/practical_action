
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

// require('./bootstrap');

window.Vue = require('vue');
window.axios = require('axios');
axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

 Vue.component('example', require('./components/Example.vue'));
 Vue.component('testing', require('./components/userController/userEdit.vue'));
 Vue.component('practical-user-list', require('./components/userController/userList.vue'));
 Vue.component('practical-theme', require('./components/contactsPab/themes/theme.vue'));
 Vue.component('practical-contact-display', require('./components/contactsPab/contactDisplay/contactDisplay.vue'));
 Vue.component('practical-contact-edit', require('./components/contactsPab/edit/contactEdit.vue'));
 Vue.component('practical-contract-create', require('./components/contract/contractCreate.vue'));
 Vue.component('practical-user-contract-list', require('./components/contract/contractList.vue'));
 
 

 import Vue from 'vue'
 import vSelect from 'vue-select'
 Vue.component('v-select', vSelect)

 var VueResource = require('vue-resource');
 Vue.use(VueResource)

 const app = new Vue({
 	el: '#app'
 });

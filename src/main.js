/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

 require('./bootstrap');

 window.Vue = require('vue');
 import moment from 'moment';
 import { Form, HasError, AlertError } from 'vform';
 import Gate from "./Gate";
 
 
 Vue.prototype.$gate = new Gate(window.user);
 /*
 require('@/assets/css/bd-wizard.css');
 require('@/assets/css/webcss1.min.css');
 require('@/assets/css/webcss2.min.css');
 */
 
 import swal from 'sweetalert2';
 window.swal = swal;
 const toast = swal.mixin({
   toast: true,
   position: 'top-end',
   showConfirmButton: false,
   timer: 3000,
   timerProgressBar: true,
   onOpen: (toast) => {
     toast.addEventListener('mouseenter', swal.stopTimer)
     toast.addEventListener('mouseleave', swal.resumeTimer)
   }
 });
 
 window.toast = toast;
 window.form = Form;
 Vue.component(HasError.name, HasError);
 Vue.component(AlertError.name, AlertError);
 Vue.component('pagination', require('laravel-vue-pagination'));
 import VueRouter from 'vue-router';
 
 Vue.use(VueRouter);
 
 import VueProgressBar from 'vue-progressbar';
 
 import Howl from 'howler';
 
 
 Vue.use(VueProgressBar, {
   color: 'rgb(143, 255, 199)',
   failedColor: 'red',
   height: '3px'
 })
 
 
 import BootstrapVue from "bootstrap-vue";
 Vue.use(BootstrapVue);
 
 let routes = [
   { path: '/dashboard', component: require('./js/components/Dashboard.vue').default },
   { path: '/profile', component: require('./js/components/Profile.vue').default },
   { path: '/users', component: require('./js/components/Users.vue').default },
   { path: '/developer', component: require('./js/components/Developer.vue').default },
   { path: '/payments', component: require('./js/components/Payments.vue').default },
   { path: '/terms', component: require('./js/components/Terms.vue').default },
 
 
   { path: '/orders', component: require('./js/components/Orders.vue').default },
   { path: '/order/:order_id', props: true, component: require('./js/components/OrderPage.vue').default },
 
   { path: '*', component: require('./js/components/NotFound.vue').default }
 
 
 ]
 
 var result = require('lodash.result');
 
 import LoadScript from 'vue-plugin-load-script';
 Vue.use(LoadScript);
 
 Vue.component('chat-messages', require('./js/components/ChatMessages.vue').default);
 Vue.component('chat-form', require('./js/components/ChatForm.vue').default);
 Vue.component('order-chat', require('./js/components/OrderChat.vue').default);
 Vue.component('order-chart', require('./js/components/charts/OrderChart.vue').default);
 Vue.component('user-chart', require('./js/components/charts/UserChart.vue').default);
 Vue.component('order-menu', require('./js/components/OrderMenu.vue').default);
 
 Vue.component('order-form', require('./js/components/OrderForm.vue').default);
 Vue.component('modal', require('./js/components/UserModal.vue').default);
 //Vue.component('notifications', require('./js/components/notifications.vue').default);
 
 
 Vue.component('user-image', require('./js/components/UserImage.vue').default);
 
 let uniqid = require('uniqid');
 const router = new VueRouter({
   mode: 'history',
   routes // short for `routes: routes`
 })
 
 Vue.filter('upText', function(text){
     return text.charAt(0).toUpperCase() + text.slice(1);
 });
 Vue.filter('myDate', function(created){
     return moment(created).format('MMMM Do YYYY, h:mm:ss a');
 });
 Vue.filter('myDate2', function(created){
     return moment(created).format('MMMM Do YYYY');
 });
 Vue.filter('messageDate', function(created){
     return moment(created).calendar();
 });
 
 //BELOW IS FOR EVENT DRIVEN DATABASE UPDATES
 let Fire = new Vue();
 window.Fire = Fire;
 
 
 //console.log(process.env);
 
 //$('#sideUserInfo')
 
 
 /**
  * The following block of code may be used to automatically register your
  * Vue components. It will recursively scan this directory for the Vue
  * components and automatically register them with their "basename".
  *
  * Eg. ./js/components/ExampleComponent.vue -> <example-component></example-component>
  */
 
 // const files = require.context('./', true, /\.vue$/i)
 // files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))
 import DataTable from 'laravel-vue-datatable';
 Vue.use(DataTable);
 
 
 
 Vue.component(
     'passport-clients',
     require('./js/components/passport/Clients.vue').default
 );
 
 Vue.component(
     'terms',
     require('./js/components/Terms.vue').default
 );
 
 Vue.component(
     'passport-authorized-clients',
     require('./js/components/passport/AuthorizedClients.vue').default
 );
 
 Vue.component(
     'passport-personal-access-tokens',
     require('./js/components/passport/PersonalAccessTokens.vue').default
 );
 
 
 Vue.component(
     'not-found',
     require('./js/components/NotFound.vue').default
 );
 
 
 Vue.component('example-component', require('./js/components/ExampleComponent.vue').default);
 
 /**
  * Next, we will create a fresh Vue application instance and attach it to
  * the page. Then, you may begin adding components to this application
  * or customize the JavaScript scaffolding to fit your unique needs.
  */
 ////console.log(process.env.PORT);
 //process.env.MIX_PORT = process.env.PORT || 3000;
 ////console.log(process.env.MIX_PORT);
 new Vue({
 
 
     el: '#app',
     router,
     data: {
         messages: [],
 
     },
 
     created() {
       //console.log(this.herokuPORT);
     },
 
     methods: {
         /*fetchMessages() {
             axios.get('/messages').then(response => {
                 this.messages = response.data;
             });
         },*/
         scrollToEnd() {
           var container = this.$el.querySelector("#scroller");
           container.scrollTop = container.scrollHeight;
         },
         addMessage(message) {
             this.messages.push(message);
 
             axios.post('/messages', message).then(response => {
               //console.log(response.data);
             });
         }
     }
 }).$mount("#app");
 
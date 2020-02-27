/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

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

Vue.component('example-component', require('./components/ExampleComponent.vue').default);
Vue.component('application-alert', require('./components/ApplicationAlert.vue').default);
Vue.component('application-notifications', require('./components/ApplicationNotification.vue').default);
Vue.component('gmapplication-alert', require('./components/gmApplicationAlert.vue').default);
Vue.component('gmapplication-notifications', require('./components/gmApplicationNotification.vue').default);
Vue.component('cashierapplication-alert', require('./components/cashierApplicationAlert.vue').default);
Vue.component('cashierapplication-notifications', require('./components/cashierApplicationNotification.vue').default);
/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: '#app',
    mounted(){
        Echo.channel('pizza-tracker')
        .listen('OrderStatusChanged',(e)=>{
            console.log('realtime cuz!');
        })
    }
});

import Vue from 'vue';
window.Vue = require('vue');
import VueCookies from 'vue-cookies';

import router from "./router";
import store from './store';
import 'es6-promise/auto';

Vue.use(VueCookies);

new Vue({
    el: '#app',
    router,
    store
});

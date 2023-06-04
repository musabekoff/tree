import vueRouter from 'vue-router';
import Vue from 'vue';
window.Vue = Vue;

Vue.use(vueRouter);

import PageNotFound             from './views/PageNotFound'
import ImagedItem               from "./views/ImagedItem";
import Imaged                   from "./views/Imaged";
import Index                    from './views/Index';
import Item                     from "./views/Item";

const routes = [
    {
        path: '/',
        component: Index,
        name: 'Index'
    },
    {
        path: '/item/:slug',
        component: Item,
        name: 'Item'
    },
    {
        path: '/imaged',
        component: Imaged,
        name: 'Imaged'
    },
    {
        path: '/imaged/item/:slug',
        component: ImagedItem,
        name: 'ImagedItem'
    },

    // and finally the default route, when none of the above matches:
    {
        path: "*",
        component: PageNotFound
    }
];

export default new vueRouter({
    mode: "history",
    routes
});

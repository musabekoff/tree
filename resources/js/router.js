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
        name: 'Index',
        meta: {
            simple: true
        }
    },
    {
        path: '/item/:slug',
        component: Item,
        name: 'Item',
        meta: {
            simple: true
        }
    },
    {
        path: '/imaged',
        component: Imaged,
        name: 'Imaged',
        meta: {
            simple: false
        }
    },
    {
        path: '/imaged/item/:slug',
        component: ImagedItem,
        name: 'ImagedItem',
        meta: {
            simple: false
        }
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

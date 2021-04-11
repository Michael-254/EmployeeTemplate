import Vue from "vue";
import VueRouter from 'vue-router';
Vue.use(VueRouter);

import Index from "./pages/Index";
import Admin from "./pages/Admin";
import View from "./pages/View";

const routes = [
    { path: '/', component: Index },
    { path: '/Employees', component: Admin },
    { path: '/AdminView/:id', component: View, name: 'admin.view' }
  ]

const router = new VueRouter({
    routes,
    hashbang: false,
    mode: "history"
})

export default router;

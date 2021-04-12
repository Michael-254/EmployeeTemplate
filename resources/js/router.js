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
});

router.beforeEach((to, from, next) => {
  let middleware = to.matched[0].components.default.middleware;
  
  if (middleware == "auth") {
      if (!window.loggedIn) {
         (window.location = "/login")
          return;
      }
  }

  next();
});

export default router;

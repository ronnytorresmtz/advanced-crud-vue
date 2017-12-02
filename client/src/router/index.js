import Vue from 'vue';
import Router from 'vue-router';
import Login from '@/pages/Login';
import Dashboard from '@/pages/Dashboard';
import Companies from '@/pages/Companies';
import Customers from '@/pages/Customers';
import Warehouses from '@/pages/Warehouses';


Vue.use(Router);

export default new Router({
  mode: 'history',
  routes: [
    {
      path: '/',
      name: 'Login',
      component: Login,
    },
    {
      path: '/dashboard',
      name: 'Dashboard',
      component: Dashboard,
    },
    {
      path: '/companies',
      name: 'Companies',
      component: Companies,
    },
    {
      path: '/customers',
      name: 'Customers',
      component: Customers,
    },
    {
      path: '/warehouses',
      name: 'Warehouses',
      component: Warehouses,
    },
  ],
});

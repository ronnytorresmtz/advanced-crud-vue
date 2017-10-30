import Vue from 'vue';
import Router from 'vue-router';
import Companies from '@/pages/Companies';
import Customers from '@/pages/Customers';

Vue.use(Router);

export default new Router({
  mode: 'history',
  routes: [
    {
      path: '/',
      name: 'Companies',
      component: Companies,
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
  ],
});

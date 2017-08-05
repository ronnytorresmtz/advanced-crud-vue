import Vue from 'vue';
import Router from 'vue-router';
import Hello from '@/pages/Hello';
import Companies from '@/pages/Companies';

Vue.use(Router);

export default new Router({
  routes: [
    {
      path: '/',
      name: 'Hello',
      component: Hello,
    },
    {
      path: '/companies',
      name: 'Companies',
      component: Companies,
    },
  ],
});

import Vue from 'vue';
import Router from 'vue-router';
import Companies from '@/pages/Companies';

Vue.use(Router);

export default new Router({
  mode: 'history',
  routes: [
    {
      path: '/companies',
      name: 'Companies',
      component: Companies,
    },
  ],
});

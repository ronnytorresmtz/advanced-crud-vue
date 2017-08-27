// The Vue build version to load with the `import` command
// (runtime-only or standalone) has been set in webpack.base.conf with an alias.
import Vue from 'vue';
import VueWorker from 'vue-worker';
import App from './App';
import router from './router';
import store from './store/Companies/Store';

window._ = require('lodash');
// require('bootstrap');
Vue.use(VueWorker);

Vue.config.productionTip = false;

/* eslint-disable no-new */
new Vue({
  el: '#app',
  router,
  store,
  template: '<App/>',
  components: { App },
});

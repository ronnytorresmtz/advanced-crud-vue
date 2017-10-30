// The Vue build version to load with the `import` command
// (runtime-only or standalone) has been set in webpack.base.conf with an alias.
import Vue from 'vue';
import VueWorker from 'vue-worker';
import App from './App';
import router from './router';
import store from './store/Store';

// window._ = require('lodash');

Vue.use(VueWorker);

Vue.config.productionTip = false;

/* eslint-disable no-new */
new Vue({
  el: '#app',
  router,
  store,
  template: '<App/>',
  components: {
    App,
  },

  created() {
    Promise.all([
      store.dispatch('getAllCompaniesIdAndNamesActive'),
      store.dispatch('getLocations'),
    ])
    .then(() => console.log('Init App -> OK [Companies, Locations Loaded]'))
    .catch(error => console.log(`Init App -> Error [${error}]`));
  },

});

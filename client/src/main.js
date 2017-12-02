import Vue from 'vue';
import App from './App';
import router from './router';
import store from './store/Store';

// window._ = require('lodash');

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
      store.dispatch('getAllCustomersIdAndNamesActive'),
      store.dispatch('getLocations'),
    ])
    .then(() => console.log('Init App -> OK [Companies, Locations Loaded]'))
    .catch(error => console.log(`Init App -> Error [${error}]`));
  },

});

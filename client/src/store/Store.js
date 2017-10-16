/* eslint no-param-reassign: ["error", { "props": false }] */
import Vue from 'vue';
import Vuex from 'vuex';
import companies from '../store/Companies/Store';

Vue.use(Vuex);
// Vue.prototype.$http = Axios;

const store = new Vuex.Store({
  modules: {
    companies,
  },
  state: {
    showSidebar: false,
  },
  mutations: {
    SHOW_SIDEBAR(state, show) {
      state.showSidebar = show;
    },
  },
  getters: {
    getShowSidebar: state => state.showSidebar,
  },
});

export default store;

/* eslint no-param-reassign: ["error", { "props": false }] */
import Vue from 'vue';
import Vuex from 'vuex';
import Axios from 'axios';
import companies from '../store/Companies/Store';
import customers from '../store/Customers/Store';

Vue.use(Vuex);
// Vue.prototype.$http = Axios;

const store = new Vuex.Store({
  modules: {
    companies,
    customers,
  },
  state: {
    showSidebar: false,
    baseUrlCompanies: 'http://localhost:8000/api/shippers/companies',
    baseUrlLocations: 'http://localhost:8000/api/admin/locations',
    companiesActive: [],
    locations: [],
  },
  mutations: {
    SHOW_SIDEBAR(state, show) {
      state.showSidebar = show;
    },
    UPDATE_COMPANIES_ACTIVE(state, companiesActive) {
      state.companiesActive = companiesActive;
    },
    UPDATE_LOCATIONS(state, locations) {
      state.locations = locations;
    },
  },
  actions: {
    getAllCompaniesIdAndNamesActive(context) {
      const baseUrl = context.getters.getBaseUrlCompanies;
      return Axios.get(`${baseUrl}/getAllCompaniesIdAndNamesActive`)
      .then((response) => {
        const companiesActive = response.data.map(obj => obj.company_name);
        context.commit('UPDATE_COMPANIES_ACTIVE', companiesActive);
      });
    },
    getLocations(context) {
      const baseUrl = context.getters.getBaseUrlLocations;
      return Axios.get(`${baseUrl}/getAllLocationsActive`)
      .then((response) => {
        const locations = response.data.map(obj => obj.location_name);
        context.commit('UPDATE_LOCATIONS', locations);
      });
    },
  },
  getters: {
    getShowSidebar: state => state.showSidebar,
    getBaseUrlCompanies: state => state.baseUrlCompanies,
    getBaseUrlLocations: state => state.baseUrlLocations,
    getAllCompaniesIdAndNamesActive: state => state.companiesActive,
    getLocations: state => state.locations,
  },
});

export default store;

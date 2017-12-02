/* eslint no-param-reassign: ["error", { "props": false }] */
import Vue from 'vue';
import Vuex from 'vuex';
import Axios from 'axios';
import login from '../store/Login/Store';
import dashboard from '../store/Dashboard/Store';
import companies from '../store/Companies/Store';
import customers from '../store/Customers/Store';
import warehouses from '../store/Warehouses/Store';

Vue.use(Vuex);
// Vue.prototype.$http = Axios;

const store = new Vuex.Store({
  modules: {
    login,
    dashboard,
    companies,
    customers,
    warehouses,
  },
  state: {
    showSidebar: false,
    baseUrlCompanies: 'http://localhost:8000/api/shippers/companies',
    baseUrlCustomers: 'http://localhost:8000/api/shippers/customers',
    baseUrlLocations: 'http://localhost:8000/api/admin/locations',
    isLogged: false,
    companiesActive: [],
    customersActive: [],
    locations: [],
  },
  mutations: {
    UPDATE_IS_LOGGED(state, isLogged) {
      state.isLogged = isLogged;
    },
    SHOW_SIDEBAR(state, show) {
      state.showSidebar = show;
    },
    UPDATE_COMPANIES_ACTIVE(state, companiesActive) {
      state.companiesActive = companiesActive;
    },
    UPDATE_CUSTOMERS_ACTIVE(state, customersActive) {
      state.customersActive = customersActive;
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
    getAllCustomersIdAndNamesActive(context) {
      const baseUrl = context.getters.getBaseUrlCustomers;
      console.log(`${baseUrl}/getAllCustomersIdAndNamesActive`);
      return Axios.get(`${baseUrl}/getAllCustomersIdAndNamesActive`)
      .then((response) => {
        console.log(`${baseUrl}/getAllCustomersIdAndNamesActive`);
        const customersActive = response.data.map(obj => obj.customer_name);
        context.commit('UPDATE_CUSTOMERS_ACTIVE', customersActive);
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
    getIsLogged: state => state.isLogged,
    getShowSidebar: state => state.showSidebar,
    getBaseUrlCompanies: state => state.baseUrlCompanies,
    getBaseUrlCustomers: state => state.baseUrlCustomers,
    getBaseUrlLocations: state => state.baseUrlLocations,
    getAllCompaniesIdAndNamesActive: state => state.companiesActive,
    getAllCustomersIdAndNamesActive: state => state.customersActive,
    getLocations: state => state.locations,
  },
});

export default store;

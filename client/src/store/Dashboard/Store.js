/* eslint no-param-reassign: ["error", { "props": false }] */
// import Vue from 'vue';
// import Axios from 'axios';

// import { storeInLocalStorage } from '../../lib/General';

const store = {
  namespaced: true,
  state: {
    moduleName: 'dashboard',
    baseUrlDashboard: 'http://localhost:8000/api/shippers/dashboard',
    loading: false,
    showPopUpMessage: false,
    message: {
      id: '',
      type: '',
      text: '',
      show: false,
    },
  },
  mutations: {
    UPDATE_LOADING(state, loading) {
      state.loading = loading;
    },
    SHOW_MESSAGE(state, response) {
      state.message.text = (response.data.message) ? response.data.message : 'The operation was NOT executed as expected, try again or please contact the support service';
      state.message.type = (response.data.error || !response.data.message) ? 'danger' : 'info';
      state.message.show = true;
      state.showPopUpMessage = true;
    },
    SHOW_MESSAGE_ERROR(state, message) {
      state.message.text = message;
      state.message.type = 'danger';
      state.message.show = true;
      state.showPopUpMessage = true;
    },
    CLOSE_MESSAGE(state, close) {
      state.message.show = close;
      state.showPopUpMessage = close;
    },
  },
  actions: {

  },
  getters: {
    getModuleName: state => state.moduleName,
    getBaseUrlDashboard: state => state.baseUrlDashboard,
    getMessage: state => state.message,
    getShowMessage: state => state.message.show,
    getShowPopUpMessage: state => state.showPopUpMessage,
    getLoading: state => state.loading,
  },
};

export default store;

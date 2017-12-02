/* eslint no-param-reassign: ["error", { "props": false }] */
// import Vue from 'vue';
import Axios from 'axios';
import router from '../../router';

const store = {
  namespaced: true,
  state: {
    moduleName: 'Login',
    baseUrlLogin: 'http://localhost:8000/api/',
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
      state.showPopUpMessage = false;
    },
  },
  actions: {
    checkLogIn(context, data) {
      context.commit('UPDATE_LOADING', true);
      const baseUrl = context.getters.getBaseUrlLogin;
      return Axios.post(`${baseUrl}login/logIn`, { username: data.username, password: data.password, remember_me: data.rememberMe })
      .then((response) => {
        if (response.data.error === false) {
          localStorage.setItem('rememberUserName', (data.rememberMe) ? data.username : '');
          router.push(data.url);
          context.commit('UPDATE_LOADING', false);
        } else {
          context.commit('SHOW_MESSAGE', response);
          context.commit('UPDATE_LOADING', false);
        }
      }).catch((error) => {
        context.commit('SHOW_MESSAGE_ERROR', error.message);
        context.commit('UPDATE_LOADING', false);
      });
    },
    sendEmail(context, email) {
      context.commit('UPDATE_LOADING', true);
      const baseUrl = context.getters.getBaseUrlLogin;
      return Axios.post(`${baseUrl}login/sendYourPassword`, { email })
      .then((response) => {
        context.commit('SHOW_MESSAGE', response);
        context.commit('UPDATE_LOADING', false);
      })
      .catch((error) => {
        context.commit('SHOW_MESSAGE_ERROR', error.message);
        context.commit('UPDATE_LOADING', false);
      });
    },
    logout(context) {
      const baseUrl = context.getters.getBaseUrlLogin;
      return Axios.get(`${baseUrl}login/logOut`)
      .then((response) => {
        router.push(response.data.url);
      })
      .catch((error) => {
        context.commit('SHOW_MESSAGE_ERROR', error.message);
      });
    },
  },
  getters: {
    getMessage: state => state.message,
    getShowPopUpMessage: state => state.showPopUpMessage,
    getShowMessage: state => state.message.show,
    getLoading: state => state.loading,
    getBaseUrlLogin: state => state.baseUrlLogin,
  },
};

export default store;

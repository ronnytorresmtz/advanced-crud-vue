/* eslint no-param-reassign: ["error", { "props": false }] */
import Vue from 'vue';
import Vuex from 'vuex';
import mockData from '../../store/Companies/MockData';

Vue.use(Vuex);

const store = new Vuex.Store({
  state: {
    data: [],
    item: {
      company_id: '',
      company_name: '',
      company_email: '',
      company_phone: '',
      company_status: 'Active',
    },
    message: {
      id: 'alert1',
      type: 'success',
      text: 'Operation was executed successfully',
      show: false,
    },
  },
  mutations: {
    INIT_DATA(state) {
      state.data = mockData;
    },
    ADD_ITEM(state, item) {
      item.company_id = state.data.length + 1;
      state.data.push(item);
      state.item = item;
    },
    UPDATE_ITEM(state, item) {
      state.data = state.data.map((obj) => {
        if (obj.company_id === item.company_id) {
          item.company_status = 'Active';
          return item;
        }
        return obj;
      });
      state.item = item;
    },
    DELETE_ITEM(state, id) {
      state.data.forEach((item) => {
        if (item.company_id === id) {
          item.company_status = 'Inactive';
        }
      });
    },
    RESET_ITEM(state) {
      state.item = {
        company_id: '',
        company_name: '',
        company_email: '',
        company_phone: '',
        company_status: '',
      };
    },
    UPDATE_MESSAGE(state, show) {
      state.message.show = show;
    },
  },
  getters: {
    getData: state => state.data,
    getItem: state => state.item,
    getMessage: state => state.message,
    getShowMessage: state => state.message.show,
  },
});

export default store;

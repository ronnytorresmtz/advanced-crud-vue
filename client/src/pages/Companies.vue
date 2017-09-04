<style scoped>
  tr {
    cursor:pointer;
  }
  .aster-red {
    color: red;
  }
  .panel-padding {
    padding-left:30px;
    padding-right:30px;
    padding-bottom:10px;
  }
  .btn-std-width {
    width: 70px;
  }
 .table-hscroll{
     white-space: nowrap;
     overflow-x: auto;
     overflow-y: auto;
  }
  .table-height{
    height: 280px;
  }
  .select-style {
    color: gray;
  }

  .select-option-style {
    background: white;
    color: black;
  }

</style>

<template>
  <div class="container-fluid" align="left">
    <transition enter-active-class="animated fadeInDown" leave-active-class="animated fadeOutUp">
      <popup v-if="showPopUpMessage"> </popup>
    </transition>
    <div class="panel panel-default panel-padding">
      <div class="row">
        <div class="col-xs-6">
          <h1> {{ ts['companyList']}}
          <span v-if="loading">
            <i class="fa fa-spinner fa-spin"></i>
          </span>
          </h1>
        </div>
        <div class="col-xs-6" style="margin-top: 30px" align="right">
          <button class="btn btn-sm btn-primary" @click.prevent="showAddForm()"> {{ ts['addCompany'] }} </button>
          <button class="btn btn-sm btn-primary" @click.prevent="exportData()"> 
            <span class="glyphicon glyphicon-arrow-down"></span>
          </button>
          <button class="btn btn-sm btn-primary" @click.prevent="importData()"> 
            <span class="glyphicon glyphicon-arrow-up"></span>
          </button>
        </div>
      </div>
      <hr>
      <div class="row">
        <div class="col-xs-3" >
        <div class="input-group">
          <input type="text" class="form-control" v-model="searchText" @keyup.enter="getDataFiltered" :placeholder="ts['typeForSearch']"></input>
          <span class="input-group-addon" @click="getDataFiltered"  style="cursor: pointer;">
            <span :class="(!searchText) ? 'glyphicon glyphicon-search' : 'glyphicon glyphicon-filter'"></span>
          </span>
        </div>
        </div>
        <div class="col-xs-6"></div>
        <div class="col-xs-3" align="right">
          <select class="form-control" v-model="optionSelected" @change="getDataFiltered">
            <option value="-1"> {{ ts['applyAFilter'] }} </option>
            <option value="0"> {{ ts['active'] }} </option>
            <option value="1"> {{ ts['inactive'] }} </option>
          </select>
        </div>
      </div>
      <hr>
      <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
              <h4 class="modal-title" v-text="(isUpdateBtnShow) ? ts['editCompany'] : ts['addCompany']"></h4>
            </div>
            <div class="modal-body">
              <div class="row" align="right" style="padding-right:20px" v-if="isUpdateBtnShow">
                <label> {{ ts['companyStatus'] }}: </label>
                <span v-if="(input.deleted_at===null)">
                  <button class="btn btn-xs btn-success btn-std-width" v-model="input.status"> {{ ts['active'] }} </button>
                </span>
                <span v-else>
                  <button class="btn btn-xs btn-danger btn-std-width" v-model="input.status"> {{ ts['inactive'] }} </button>
                </span>
              </div>
              <form>
                <div class="row">
                  <div class="col-xs-6">
                    <label> {{ ts['id'] }}: </label> <span class="aster-red" v-text="!input.id ? ' *' : ''"></span>
                    <input type="text" class="form-control" v-model="input.id" @keyup="validFieldsRequired" :disabled="true"></input>
                    <label> {{ ts['companyName'] }}: </label><span class="aster-red" v-text="!input.company_name ? ' *' : ''"></span>
                    <input type="text" class="form-control" v-model="input.company_name" @keyup="validFieldsRequired"></input>
                    <label> {{ ts['companyLegalName'] }}: </label><span class="aster-red" v-text="!input.company_legal_name ? ' *' : ''"></span>
                    <input type="text" class="form-control" v-model="input.company_legal_name" @keyup="validFieldsRequired"></input>
                    <label> {{ ts['companyTaxId'] }}: </label><span class="aster-red" v-text="!input.company_tax_id ? ' *' : ''"></span>
                    <input type="text" class="form-control" v-model="input.company_tax_id" @keyup="validFieldsRequired"></input>
                    <label> {{ ts['companyWebsite'] }}: </label><span class="aster-red" v-text="!input.company_website ? ' *' : ''"></span>
                    <input type="text" class="form-control" v-model="input.company_website" @keyup="validFieldsRequired"></input>
                    <label> {{ ts['companyContact'] }}: </label><span class="aster-red" v-text="!input.company_contact ? ' *' : ''"></span>
                    <input type="text" class="form-control" v-model="input.company_contact" @keyup="validFieldsRequired"></input>
                    <label> {{ ts['companyEmail'] }}: </label><span class="aster-red" v-text="!input.company_email ? ' *' : ''"></span>
                    <input type="text" class="form-control" v-model="input.company_email" @keyup="validFieldsRequired"></input>
                  </div>
                  <div class="col-xs-6">
                    <label> {{ ts['companyPhone'] }}: </label><span class="aster-red" v-text="!input.company_phone ? ' *' : ''"></span>
                    <input type="text" class="form-control" v-model="input.company_phone" @keyup="validFieldsRequired"></input>
                    <label> {{ ts['companyCellular'] }}: </label><span class="aster-red" v-text="!input.company_cellular ? ' *' : ''"></span>
                    <input type="text" class="form-control" v-model="input.company_cellular" @keyup="validFieldsRequired"></input>
                    <label> {{ ts['companyAddress'] }}: </label><span class="aster-red" v-text="!input.company_address ? ' *' : ''"></span>
                    <input type="text" class="form-control" v-model="input.company_address" @keyup="validFieldsRequired"></input>
                    <label> {{ ts['companyLocation'] }}: </label><span class="aster-red" v-text="!input.company_location ? ' *' : ''"></span>
                    <input type="text" class="form-control" v-model="input.company_location" @keyup="validFieldsRequired"></input>
                    <label> {{ ts['companyPostcode'] }}: </label><span class="aster-red" v-text="!input.company_postcode ? ' *' : ''"></span>
                    <input type="text" class="form-control" v-model="input.company_postcode" @keyup="validFieldsRequired"></input>
                    <label> {{ ts['companyLatitude'] }}: </label><span class="aster-red" v-text="!input.company_latitude ? ' *' : ''"></span>
                    <input type="text" class="form-control" v-model="input.company_latitude" @keyup="validFieldsRequired"></input>
                    <label> {{ ts['companyLongitude'] }}: </label><span class="aster-red" v-text="!input.company_longitude ? ' *' : ''"></span>
                    <input type="text" class="form-control" v-model="input.company_longitude" @keyup="validFieldsRequired"></input>
                  </div>
                </div>
              </form>
              <br>
              <div class="modal-footer">
                <div class="row">
                  <div class="col-xs-4" align="left">
                    <div v-show="!isUpdateBtnShow">
                      <input type="checkbox" v-model="closeAfterAction"> <span style="cursor:pointer" @click.prevent="closeAfterAction = !closeAfterAction"> {{ ts['closeAfterAction'] }} </span></input>
                    </div>
                  </div>
                  <div class="col-xs-8">
                    <button class="btn btn-sm btn-success btn-std-width" @click.prevent="addItem()" v-if="!isUpdateBtnShow" :disabled="isAddBtnDisable"> {{ ts['add'] }} </button>
                    <button class="btn btn-sm btn-success btn-std-width" @click.prevent="updateItem()" v-if="isUpdateBtnShow" :disabled="isUpdateBtnDisable"> {{ ts['update'] }} </button>
                    <button class="btn btn-sm btn-danger btn-std-width" @click.prevent="deleteItem()" v-if="isUpdateBtnShow"> {{ ts['delete'] }} </button>
                    <button class="btn btn-sm btn-default btn-std-width" @click.prevent="resetForm()"> {{ ts['reset'] }} </button>
                    <button class="btn btn-sm btn-default btn-std-width" @click.prevent="closeModal()"> {{ ts['close'] }} </button>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div> <!--End Modal-->

      <mytable :cols="headers" :rows="pageData"> </mytable>
            
      <br>

      <mypaginator
          url="http://localhost:8000/api/shippers/companies"
          filter="optionSelected"
          fieldToOrder="ID"
          order="asc"
      ></mypaginator>

    </diV>
    <hr>
    <h4>TODO</h4>
    <ul>
      <li>Implementar Export e Import</li>
      <li>ValidaFieldRequire requiere ajuste con los nuevos campos</li>
      <li>Instalar larave 5.5</li>
    </ul>
  </div>
</template>

<script>
// 3er Party Component
import Axios from 'axios';
// vuex store
import store from '../store/Companies/Store';
// my components
import popup from '../components/messages/Popup';
import mylang from '../components/languages/Languages';
import mytable from '../components/tables/Table';
import mypaginator from '../components/tables/Paginator';
// my libraries
import createObj, { resetObjVal } from '../lib/General';

export default {
  name: 'Companies',
  mixins: [mylang],
  components: {
    popup,
    mytable,
    mypaginator,
  },
  data() {
    return {
      title: 'Company',
      headers: [
        { name: 'id', label: 'id', width: '10%' },
        { name: 'deleted_at', label: 'companyStatus', width: '10%' },
        { name: 'company_name', label: 'companyName', width: '20%' },
        { name: 'company_contact', label: 'companyContact', width: '20%' },
        { name: 'company_email', label: 'companyEmail', width: '10%' },
        { name: 'company_phone', label: 'companyPhone', width: '10%' },
        { name: 'company_cellular', label: 'companyCellular', width: '10%' },
        { name: 'company_location', label: 'companyLocation', width: '10%' },
        { name: 'company_address', label: 'companyAddress', width: '10%' },
        { name: 'company_postcode', label: 'companyPostcode', width: '10%' },
        { name: 'company_latitude', label: 'companyLatitude', width: '10%' },
        { name: 'company_longitude', label: 'companyLongitude', width: '10%' },
        { name: 'company_legal_name', label: 'companyLegalName', width: '10%' },
        { name: 'company_tax_id', label: 'companyTaxId', width: '10%' },
        { name: 'company_website', label: 'companyWebsite', width: '10%' },
      ],
      totalRows: '',
      searchText: '',
      optionSelected: '-1',
      selectOptions: ['Apply A Filter', 'Active', 'Inactive'],
      input: {
        id: 'New',
        company_name: '',
        company_legal_name: '',
        company_tax_id: '',
        company_website: '',
        company_contact: '',
        company_email: '',
        company_phone: '',
        company_cellular: '',
        company_address: '',
        company_location: '',
        company_postcode: '',
        company_latitude: '',
        company_longitude: '',
        deleted_at: '',
      },
    };
  },

  created() {
    store.commit('UPDATE_OPTION_SELECT', this.optionSelected);
  },

  computed: {
    pageData() {
      return this.$store.getters.getPageData;
    },
    showPopUpMessage: {
      set() { },
      get() {
        return this.$store.getters.getShowMessage;
      },
    },
    loading() {
      return this.$store.getters.getloading;
    },
    showModal() {
      this.input = this.$store.getters.getItem;
      return this.$store.getters.getShowModal;
    },
    isUpdateBtnShow() {
      return this.$store.getters.getIsUpdateBtnShow;
    },
    isAddBtnDisable() {
      return this.$store.getters.getIsAddBtnDisable;
    },
    isUpdateBtnDisable() {
      return this.$store.getters.getIsUpdateBtnDisable;
    },
    closeAfterAction() {
      return this.$store.getters.getCloseAfterAction;
    },
  },

  methods: {
    getDataFiltered() {
      store.commit('UPDATE_SEARCH_TEXT', this.searchText);
      store.commit('UPDATE_OPTION_SELECT', this.optionSelected);
      store.dispatch('getDataFiltered');
    },
    addItem() {
      this.input.deleted_at = null;
      store.dispatch('addItem', createObj(this.input));
      this.closeModalAfterAction();
      this.resetForm();
      this.displayPopUpMessage();
    },
    updateItem() {
      this.input.deleted_at = null;
      store.dispatch('updateItem', createObj(this.input));
      this.resetForm();
      this.closeModal();
      this.displayPopUpMessage();
    },
    deleteItem() {
      const id = this.input.id;
      store.dispatch('deleteItem', id);
      if (this.input.id === id) {
        this.resetForm();
      }
      this.closeModal();
      this.displayPopUpMessage();
    },
    exportData() {
      store.commit('UPDATE_LOADING', true);
      const url = this.$store.getters.getPagination.path;
      Axios.get(`${url}/export`)
      .then((response) => {
        store.commit('SHOW_MESSAGE', response);
      })
      .then(() => {
        store.commit('UPDATE_LOADING', false);
      })
      .catch((response) => {
        store.commit('SHOW_MESSAGE', response);
        store.commit('UPDATE_LOADING', false);
      });
    },
    importData() {

    },
    resetForm() {
      store.commit('RESET_ITEM');
      const id = this.input.id;
      const status = this.input.deleted_at;
      this.input = resetObjVal(this.input);
      this.input.id = id;
      this.input.deleted_at = status;
      this.initModalButtons();
    },
    closeModal() {
      store.commit('SHOW_MODAL', false);
      this.resetForm();
      this.input.id = 'New';
      this.initModalButtons();
    },
    closeModalAfterAction() {
      if (this.closeAfterAction) {
        store.commit('SHOW_MODAL', false);
        $('#myModal').modal('hide');
      }
    },
    initModalButtons(value) {
      store.commit('SHOW_BTN_UPDATE', value);
      store.commit('SHOW_BTN_ADD_DISABLE', !value);
      store.commit('SHOW_BTN_UPDATE_DISABLE', !value);
      store.commit('SHOW_CLOSE_AFTERACTION_DEFAULT', false);
    },
    validFieldsRequired() {
      const emptyFields = Object.keys(this.input).filter(key => this.input[key] === '');
      if (emptyFields.length !== 0) {
        store.commit('SHOW_BTN_ADD_DISABLE', true);
        store.commit('SHOW_BTN_UPDATE_DISABLE', true);
      } else {
        store.commit('SHOW_BTN_ADD_DISABLE', false);
        store.commit('SHOW_BTN_UPDATE_DISABLE', false);
      }
    },
    displayPopUpMessage() {
      this.showPopUpMessage = this.$store.getters.getShowMessage;
    },
    showAddForm() {
      store.commit('SHOW_MODAL', true);
    },
  },
  watch: {
    showModal() {
      if (this.$store.getters.getShowModal) {
        $('#myModal').modal('show');
      } else {
        $('#myModal').modal('hide');
      }
    },
    searchText() {
      store.commit('UPDATE_SEARCH_TEXT', this.searchText);
      if (!this.searchText) {
        this.getDataFiltered();
      }
    },
  },
};
</script>

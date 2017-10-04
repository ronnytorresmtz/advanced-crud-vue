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
  <div class="container-fluid" align="left" style="margin-top: 75px">

    <!--Import component-->
    <myimport :url-import="baseUrlCompanies"></myimport>

    <!--message component-->
    <transition enter-active-class="animated fadeInDown" leave-active-class="animated fadeOutUp">
      <mypopup v-if="showPopUpMessage"> </mypopup>
    </transition>

    <!--Panel-->
    <div class="panel panel-default panel-padding">
      <div class="row">
        <div class="col-xs-6">
          <!--Page Title-->
          <h1> {{ ts['companyList']}}
          <!--Spin Icon-->
          <span v-if="loading">
            <i class="fa fa-spinner fa-spin"></i>
          </span>
          </h1>
        </div>
        
        <div class="col-xs-6" style="margin-top: 30px" align="right">
          <!--Add button-->
          <button class="btn btn-sm btn-primary" @click.prevent="showAddForm()"> {{ ts['addCompany'] }} </button>
          <!--Expot button-->
          <a :href="getExportUrl()" class="btn btn-sm btn-primary button-size" :title="ts['export']">
            <span class="glyphicon glyphicon-arrow-down"></span>
          </a>
          <!--Import button-->
          <button class="btn btn-sm btn-primary" @click.prevent="importData()" :title="ts['import']"> 
            <span class="glyphicon glyphicon-arrow-up"></span>
          </button>
        </div>
      </div>
      <hr>
      <div class="row">
        <!--Search Text-->
        <div class="col-xs-3 pull-left" style="padding-right:0px">
          <div class="input-group">
            <input type="text" class="form-control" v-model="searchText" @keyup.enter="getDataFiltered" :placeholder="ts['typeForSearch']"></input>
            <span class="input-group-addon" @click="getDataFiltered"  style="cursor: pointer">
              <span class="glyphicon glyphicon-search"></span>
            </span>
          </div>
        </div>

        <div class="col-xs-6">
          <!--Button Filter for SearchText-->
          <div class="col-xs-6 pull-left" style="padding:0px">
            <div v-show="isFilterBySearchText" @click.prevent="clearSearchTextFilter()" :title="ts['clearFilter']">
              <button class="btn btn-sm btn-warning" style="cursor: pointer"> 
                <span class="glyphicon glyphicon-filter"></span>
              </button>
            </div>
          </div>
          <!--Button Filer for Apply Filter-->
          <div class="col-xs-6 pull-right" style="padding:0px">
            <div v-show="isFilterApplied" @click.prevent="clearApplyFilter()" :title="ts['clearFilter']" align="right" >
              <button class="btn btn-sm btn-warning"> 
                <span class="glyphicon glyphicon-filter"></span>
              </button>
            </div>
          </div>

        </div>          
        <!--Apply Filter Select-->
        <div class="col-xs-3 pull-right" style="padding-left:0px">
          <select class="form-control" v-model="optionSelected" @change="getDataFiltered">
            <option value="-1"> {{ ts['applyAFilter'] }} </option>
            <option value="0"> {{ ts['active'] }} </option>
            <option value="1"> {{ ts['inactive'] }} </option>
          </select>
        </div>

      </div>
      <hr>
      <!--Modal Form-->
      <div class="modal fade" id="myModalForm" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="myModalFormLabel">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <!--Modal Title-->
              <h4 class="modal-title" v-text="(isUpdateBtnShow) ? ts['editCompany'] : ts['addCompany']"></h4>
            </div>
            <div class="modal-body">
              <div class="row" align="right" style="padding-right:20px" v-if="isUpdateBtnShow">
                <!--Modal Status-->
                <label> {{ ts['companyStatus'] }}: </label>
                <span v-if="(input.deleted_at===null)">
                  <button class="btn btn-xs btn-success btn-std-width" v-model="input.status"> {{ ts['active'] }} </button>
                </span>
                <span v-else>
                  <button class="btn btn-xs btn-danger btn-std-width" v-model="input.status"> {{ ts['inactive'] }} </button>
                </span>
              </div>
              <form>
                <!--Modal Form Fields-->
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
                    <mylocation v-model="input.company_location" @keyup="validFieldsRequired"></mylocation>
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
                  <!--Check box for Close After Action-->
                  <div class="col-xs-4" align="left">
                    <div v-show="!isUpdateBtnShow">
                      <input type="checkbox" v-model="closeAfterAction"> <span style="cursor:pointer" @click.prevent="closeAfterAction = !closeAfterAction"> {{ ts['closeAfterAction'] }} </span></input>
                    </div>
                  </div>
                  <!--Modal Footer Button-->
                  <div class="col-xs-8">
                    <button class="btn btn-sm btn-success btn-std-width" @click.prevent="addItem()" v-if="!isUpdateBtnShow" :disabled="isAddBtnDisable"> {{ ts['add'] }} </button>
                    <button class="btn btn-sm btn-success btn-std-width" @click.prevent="updateItem()" v-if="isUpdateBtnShow" :disabled="isUpdateBtnDisable"> {{ ts['update'] }} </button>
                    <button class="btn btn-sm btn-danger btn-std-width" @click.prevent="deleteItem()" v-if="isUpdateBtnShow"> {{ ts['delete'] }} </button>
                    <button class="btn btn-sm btn-default btn-std-width" @click.prevent="resetForm()" v-if="!isUpdateBtnShow"> {{ ts['reset'] }} </button>
                    <button class="btn btn-sm btn-default btn-std-width" @click.prevent="closeModal()"> {{ ts['close'] }} </button>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div> <!--End Modal-->

      <!--Table Component-->
      <mytable :cols="headers" :rows="pageData"> </mytable>
            
      <br>

      <!--Paginator Component-->
      <mypaginator :url="baseUrlCompanies"></mypaginator>

    </diV>
    <hr>
    <h4>TODO</h4>
    <ul>
      <li> Parametrizar el path de Store en cada componente pues trae Company-->Solucion Vuex Modules</li>
      <li>ValidaFieldRequire requiere ajuste con los nuevos campos</li>
      <li>Instalar larave 5.5</li>
      <li>Instalar admin-lte</li>
      <li>Estando en Edicion al dar en la forma Modal al boton de Reset se convierte de Edit a Add y no debería</li>
    </ul>
  </div>
</template>

<script>
// vuex store
import store from '../store/Companies/Store';
// my components
import mypopup from '../components/messages/Popup';
import mylang from '../components/languages/Languages';
import mytable from '../components/tables/Table';
import mylocation from '../components/tables/Location';
import myimport from '../components/tables/Import';
import mypaginator from '../components/tables/Paginator';
// my libraries
import createObj, { resetObjVal, getValueFromLocalStorage } from '../lib/General';

export default {
  name: 'Companies',
  mixins: [mylang],
  components: {
    mypopup,
    mytable,
    mylocation,
    myimport,
    mypaginator,
  },
  data() {
    return {
      title: 'Company',
      headers: [
        { name: 'id', label: 'id', display: true },
        { name: 'deleted_at', label: 'companyStatus', display: true },
        { name: 'company_name', label: 'companyName', display: true },
        { name: 'company_legal_name', label: 'companyLegalName', display: false },
        { name: 'company_tax_id', label: 'companyTaxId', display: false },
        { name: 'company_website', label: 'companyWebsite', display: false },
        { name: 'company_contact', label: 'companyContact', display: true },
        { name: 'company_email', label: 'companyEmail', display: true },
        { name: 'company_phone', label: 'companyPhone', display: true },
        { name: 'company_cellular', label: 'companyCellular', display: true },
        { name: 'company_location', label: 'companyLocation', display: false },
        { name: 'company_address', label: 'companyAddress', display: false },
        { name: 'company_postcode', label: 'companyPostcode', display: false },
        { name: 'company_latitude', label: 'companyLatitude', display: false },
        { name: 'company_longitude', label: 'companyLongitude', display: false },
      ],
      totalRows: '',
      searchText: '',
      isFilterBySearchText: false,
      isFilterApplied: false,
      optionSelected: '-1',
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
    const tableParams = this.getTableParamsFromLocalStorage();
    this.updateTableParams(tableParams);
    this.optionSelected = this.$store.getters.getOptionSelected;
    this.isFilterApplied = (this.optionSelected >= 0);
    store.dispatch('getData', `${this.baseUrlCompanies}?${this.getUrlParams()}`);
  },

  computed: {
    baseUrlCompanies() {
      return this.$store.getters.getBaseUrlCompanies;
    },
    pageData() {
      return this.$store.getters.getPageData;
    },
    perPage() {
      return this.$store.getters.getPerPage;
    },
    searchTextFilter() {
      return this.$store.getters.getSearchText;
    },
    fieldOrderBy() {
      return this.$store.getters.getFieldOrderBy;
    },
    orderBy() {
      return this.$store.getters.getOrderBy;
    },
    showPopUpMessage: {
      set() { },
      get() {
        return this.$store.getters.getShowMessage;
      },
    },
    loading() {
      return this.$store.getters.getLoading;
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
    closeAfterAction: {
      set() {
        store.commit('SHOW_CLOSE_AFTERACTION_DEFAULT', !this.$store.getters.getCloseAfterAction);
      },
      get() {
        return this.$store.getters.getCloseAfterAction;
      },
    },
  },

  methods: {
    getDataFiltered() {
      store.commit('UPDATE_SEARCH_TEXT', this.searchText);
      store.commit('UPDATE_OPTION_SELECT', this.optionSelected);
      store.dispatch('getDataFiltered');
      this.showFilterButtons();
    },
    showFilterButtons() {
      this.isFilterBySearchText = (this.searchText !== '');
      this.isFilterApplied = (this.optionSelected !== '-1');
    },
    addItem() {
      this.input.deleted_at = null;
      store.dispatch('addItem', createObj(this.input)).then(() => {
        if (this.$store.getters.getMessage.type !== 'danger') {
          this.resetForm();
          this.closeModalAfterAction();
        }
      });
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
    getExportUrl() {
      return `${this.$store.getters.getPagination.path}/export?
        searchText=${this.searchText}&
        optionSelected=${this.optionSelected}`;
    },
    importData() {
      store.commit('SHOW_IMPORT_MODAL', true);
    },
    resetForm() {
      store.commit('RESET_ITEM', this.input);
      this.input = resetObjVal(this.input);
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
        $('#myModalForm').modal('hide');
      }
    },
    initModalButtons(value) {
      store.commit('SHOW_BTN_UPDATE', value);
      store.commit('SHOW_BTN_ADD_DISABLE', !value);
      store.commit('SHOW_BTN_UPDATE_DISABLE', !value);
    },
    validFieldsRequired() {
      const emptyFields = Object.keys(this.input).filter(key => this.input[key] === '');
      const isEmptyFields = (emptyFields.length !== 0);
      store.commit('SHOW_BTN_ADD_DISABLE', isEmptyFields);
      store.commit('SHOW_BTN_UPDATE_DISABLE', isEmptyFields);
    },
    displayPopUpMessage() {
      this.showPopUpMessage = this.$store.getters.getShowMessage;
    },
    showAddForm() {
      store.commit('SHOW_MODAL', true);
    },
    clearSearchTextFilter() {
      this.searchText = '';
    },
    clearApplyFilter() {
      this.optionSelected = '-1';
      store.commit('UPDATE_OPTION_SELECT', this.optionSelected);
      this.getDataFiltered();
      this.isFilterApplied = false;
    },
    getUrlParams() {
      return `searchText=${this.searchText}&optionSelected=${this.optionSelected}&itemsByPage=${this.perPage}&fieldOrderBy=${this.fieldOrderBy}&orderBy=${this.orderBy}`;
    },
    getTableParamsFromLocalStorage() {
      const moduleName = this.$store.getters.getModuleName;
      const tableDefaults = JSON.stringify(this.$store.getters.getTableDefaults);
      const values = JSON.parse(getValueFromLocalStorage(moduleName, 'tableParams', tableDefaults));
      return values;
    },
    updateTableParams(tableParams) {
      store.commit('UPDATE_OPTION_SELECT', tableParams.optionSelected);
      store.commit('UPDATE_FIELD_ORDER_BY', tableParams.fieldOrderBy);
      store.commit('UPDATE_ORDER_BY', tableParams.orderBy);
      store.commit('UPDATE_PER_PAGE', tableParams.perPage);
    },
  },
  watch: {
    showModal() {
      const hideOrShow = (this.$store.getters.getShowModal) ? 'show' : 'hide';
      $('#myModalForm').modal(hideOrShow);
    },
    searchText() {
      store.commit('UPDATE_SEARCH_TEXT', this.searchText);
      if (!this.searchText) {
        this.getDataFiltered();
        this.isFilterBySearchText = false;
      }
    },
  },
};
</script>

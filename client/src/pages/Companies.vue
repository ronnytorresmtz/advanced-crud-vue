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
    <div class="row" >
      <div class="col-sm-2" v-if="showSidebar">
        <mysidebar id="sidebarCompanies"></mysidebar>
      </div>
      <!--div :class="`col-xs-${(showSidebar)? 10 : 12}`"-->
      <div class="col-xs-12" @mouseover.stop.prevent="collapseSidebar">
        <!--Import component-->
        <myimport :url-import="baseUrlCompanies"></myimport>

        <!--message component-->
        <transition enter-active-class="animated fadeInDown" leave-active-class="animated fadeOutUp">
          <mypopup v-if="showPopUpMessage"> </mypopup>
        </transition>

        <!--Panel-->
        <div class="panel panel-default panel-padding" style="margin-top: 75px">
          <div class="row">
            <div class="col-xs-6">
              <!--Page Title-->
              <h3> {{ ts['companyList']}}
              <!--Spin Icon-->
              <span v-if="loading">
                <i class="fa fa-spinner fa-spin" aria-hidden="true"></i>
              </span>
              </h3>
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
              <select class="form-control" v-model="filterSelected" @change.prevent="getDataFiltered">
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
          <li>Instalar larave 5.5</li>
        </ul>
      </div> 
    </div> 
  </div> 
</template>

<script>
// vuex store
import store from '../store/Store';
// my components
import mypopup from '../components/messages/Popup';
import mylang from '../components/languages/Languages';
import mytable from '../components/tables/Table';
import mylocation from '../components/tables/Location';
import myimport from '../components/tables/Import';
import mypaginator from '../components/tables/Paginator';
import mysidebar from '../components/layout/sidebar';
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
    mysidebar,
  },

  data() {
    return {
      title: 'Company',
      moduleName: 'companies',
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
      filterSelected: '-1',
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
    this.filterSelected = store.getters[`${this.moduleName}/getFilterSelected`];
    this.isFilterApplied = (this.filterSelected >= 0);
    store.dispatch(`${this.moduleName}/getData`, `${this.baseUrlCompanies}?${this.getUrlParams()}`);
  },
  computed: {
    baseUrlCompanies() {
      return store.getters[`${this.moduleName}/getBaseUrlCompanies`];
    },
    pageData() {
      return store.getters[`${this.moduleName}/getPageData`];
    },
    perPage() {
      return store.getters[`${this.moduleName}/getPerPage`];
    },
    searchTextFilter() {
      return store.getters[`${this.moduleName}/getSearchText`];
    },
    fieldOrderBy() {
      return store.getters[`${this.moduleName}/getFieldOrderBy`];
    },
    orderBy() {
      return store.getters[`${this.moduleName}/getOrderBy`];
    },
    showPopUpMessage: {
      set() { },
      get() {
        return store.getters[`${this.moduleName}/getShowMessage`];
      },
    },
    loading() {
      return store.getters[`${this.moduleName}/getLoading`];
    },
    showModal: {
      set() { },
      get() {
        this.input = store.getters[`${this.moduleName}/getItem`];
        return store.getters[`${this.moduleName}/getShowModal`];
      },
    },
    isUpdateBtnShow() {
      return store.getters[`${this.moduleName}/getIsUpdateBtnShow`];
    },
    isAddBtnDisable() {
      return store.getters[`${this.moduleName}/getIsAddBtnDisable`];
    },
    isUpdateBtnDisable() {
      return store.getters[`${this.moduleName}/getIsUpdateBtnDisable`];
    },
    closeAfterAction: {
      set() {
        store.commit(`${this.moduleName}/SHOW_CLOSE_AFTERACTION_DEFAULT`, !store.getters[`${this.moduleName}/getCloseAfterAction`]);
      },
      get() {
        return store.getters[`${this.moduleName}/getCloseAfterAction`];
      },
    },
    showSidebar() {
      return store.getters.getShowSidebar;
    },
  },

  methods: {
    collapseSidebar() {
      store.commit('SHOW_SIDEBAR', false);
    },
    getDataFiltered() {
      store.commit(`${this.moduleName}/UPDATE_SEARCH_TEXT`, this.searchText);
      store.commit(`${this.moduleName}/UPDATE_FILTER_SELECTED`, this.filterSelected);
      store.dispatch(`${this.moduleName}/getDataFiltered`);
      this.showFilterButtons();
    },
    showFilterButtons() {
      this.isFilterBySearchText = (this.searchText !== '');
      this.isFilterApplied = (this.filterSelected !== '-1');
    },
    addItem() {
      this.input.deleted_at = null;
      store.dispatch(`${this.moduleName}/addItem`, createObj(this.input)).then(() => {
        if (store.getters[`${this.moduleName}/getMessage.type`] !== 'danger') {
          this.resetForm();
          this.closeModalAfterAction();
        }
      });
    },
    updateItem() {
      this.input.deleted_at = null;
      store.dispatch(`${this.moduleName}/updateItem`, createObj(this.input));
      this.resetForm();
      this.closeModal();
    },
    deleteItem() {
      const id = this.input.id;
      store.dispatch(`${this.moduleName}/deleteItem`, id);
      if (this.input.id === id) {
        this.resetForm();
      }
      this.closeModal();
    },
    getExportUrl() {
      return `${store.getters[`${this.moduleName}/getPagination`].path}/export?
        searchText=${this.searchText}&
        filterSelected=${this.filterSelected}`;
    },
    importData() {
      store.commit(`${this.moduleName}/SHOW_IMPORT_MODAL`, true);
    },
    resetForm() {
      store.commit(`${this.moduleName}/RESET_ITEM`, this.input);
      this.input = resetObjVal(this.input);
      this.initModalButtons();
    },
    closeModal() {
      store.commit(`${this.moduleName}/SHOW_MODAL`, false);
      this.resetForm();
      this.input.id = 'New';
      this.initModalButtons();
    },
    closeModalAfterAction() {
      if (this.closeAfterAction) {
        store.commit(`${this.moduleName}/SHOW_MODAL`, false);
        $('#myModalForm').modal('hide');
      }
    },
    initModalButtons(value) {
      store.commit(`${this.moduleName}/SHOW_BTN_UPDATE`, value);
      store.commit(`${this.moduleName}/SHOW_BTN_ADD_DISABLE`, !value);
      store.commit(`${this.moduleName}/SHOW_BTN_UPDATE_DISABLE`, !value);
    },
    validFieldsRequired() {
      const emptyFields = Object.keys(this.input).filter(key => this.input[key] === '');
      const isEmptyFields = (emptyFields.length !== 0);
      store.commit(`${this.moduleName}/SHOW_BTN_ADD_DISABLE`, isEmptyFields);
      store.commit(`${this.moduleName}/SHOW_BTN_UPDATE_DISABLE`, isEmptyFields);
    },
    showAddForm() {
      store.commit(`${this.moduleName}/SHOW_MODAL`, true);
    },
    clearSearchTextFilter() {
      this.searchText = '';
    },
    clearApplyFilter() {
      this.filterSelected = '-1';
      store.commit(`${this.moduleName}/UPDATE_FILTER_SELECTED`, this.filterSelected);
      this.getDataFiltered();
      this.isFilterApplied = false;
    },
    getUrlParams() {
      return `searchText=${this.searchText}&filterSelected=${this.filterSelected}&itemsByPage=${this.perPage}&fieldOrderBy=${this.fieldOrderBy}&orderBy=${this.orderBy}`;
    },
    getTableParamsFromLocalStorage() {
      const tableDefaults = JSON.stringify(store.getters[`${this.moduleName}/getTableDefaults`]);
      const values = JSON.parse(getValueFromLocalStorage(this.moduleName, 'tableParams', tableDefaults));
      return values;
    },
    updateTableParams(tableParams) {
      store.commit(`${this.moduleName}/UPDATE_FILTER_SELECTED`, tableParams.filterSelected);
      store.commit(`${this.moduleName}/UPDATE_FIELD_ORDER_BY`, tableParams.fieldOrderBy);
      store.commit(`${this.moduleName}/UPDATE_ORDER_BY`, tableParams.orderBy);
      store.commit(`${this.moduleName}/UPDATE_PER_PAGE`, tableParams.perPage);
    },
  },
  watch: {
    showModal() {
      const hideOrShow = (store.getters[`${this.moduleName}/getShowModal`]) ? 'show' : 'hide';
      $('#myModalForm').modal(hideOrShow);
    },
    searchText() {
      store.commit(`${this.moduleName}/UPDATE_SEARCH_TEXT`, this.searchText);
      if (!this.searchText) {
        this.getDataFiltered();
        this.isFilterBySearchText = false;
      }
    },
  },
};
</script>

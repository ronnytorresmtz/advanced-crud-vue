<!--style src="vue-multiselect/dist/vue-multiselect.min.css"></style-->
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
        </div>
      </div>
      <hr>
      <div class="row">
        <div class="col-xs-3" >
        <div class="input-group">
          <input type="text"
                class="form-control"
                v-model="searchText"
                :placeholder="ts['typeForSearch']"
          >
          </input>
          <span class="input-group-addon" @click="getDataFiltered" style="cursor: pointer">
            <span :class="(!searchText) ? 'glyphicon glyphicon-search' : 'glyphicon glyphicon-filter'"></span>
          </span>
        </div>
        </div>
        <div class="col-xs-6"></div>
        <div class="col-xs-3" align="right">
          <!--div class="btn-group " data-toggle="buttons" @click.prevent="changeFilter">
            <label class="btn btn-md btn-default active">
              <input v-model="radioSelected" value="All" type="radio" label="Apply" name="options" id="option1" checked> All
            </label>
            <label class="btn btn-md btn-default">
              <input v-model="radioSelected" value="Active" type="radio" label="Active" name="options" id="option2"> Active
            </label>
            <label class="btn btn-md btn-default">
              <input v-model="radioSelected" value="Inactive" type="radio" label="Inactive" name="options" id="option3" > Inactive
            </label>
          </div-->
          <!--multiselect :taggable="true" v-model="optionSelected" :options="selectOptions"></multiselect-->
          <select
            class="form-control"
            v-model="optionSelected"
            @change="applySortAndFiltersToData()"
          >
            <option value="Apply a filter"> {{ ts['applyAFilter'] }} </option>
            <option value="null"> {{ ts['active'] }} </option>
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
      <li>ValidaFieldRequire requiere ajuste con los nuevos campos</li>
      <li>Instalar larave 5.5</li>
    </ul>
  </div>
</template>

<script>
// 3er Party Component
// import Multiselect from 'vue-multiselect';
// vuex store
import store from '../store/Companies/Store';
// my components
import popup from '../components/messages/Popup';
import mylang from '../components/languages/Languages';
import mytable from '../components/tables/Table';
import mypaginator from '../components/tables/Paginator';
// my libraries
import createObj, { resetObjVal, compareValues } from '../lib/General';

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
        { name: 'id', label: 'id', width: '5%' },
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
      // data: [],
      dataSortedAndFiltered: [],
      totalRows: '',
      searchText: '',
      optionSelected: 'Apply a filter',
      selectOptions: ['Apply A Filter', 'Active', 'Inactive'],
      lastFieldOrder: '',
      sortOrder: 'asc',
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
    getDataWithHeaders(cols, rows) {
      const dataRows = rows;
      Object.keys(rows).forEach((key) => {
        Object.keys(dataRows[key]).forEach((index) => {
          let exist = false;
          Object.keys(cols).forEach((i) => {
            if (index === cols[i].name) {
              exist = true;
            }
            if (index === 'deleted_at') {
              exist = true;
            }
          });
          if (!exist) {
            delete dataRows[key][index];
          }
        });
      });
      return dataRows;
    },
    getDataFiltered() {
      store.dispatch('getDataFiltered');
    },
    addItem() {
      this.input.deleted_at = null;
      // store.commit('ADD_ITEM_TO_PAGEDATA', createObj(this.input));
      store.dispatch('addItem', createObj(this.input));
      this.applySortAndFiltersToData();
      this.lastFieldOrder = 'id';
      this.sortOrder = 'desc';
      this.dataSortedAndFiltered = this.dataSortedAndFiltered.sort(
        compareValues(this.lastFieldOrder, this.sortOrder));
      this.closeModalAfterAction();
      this.resetForm();
      this.displayPopUpMessage();
    },
    updateItem() {
      this.input.deleted_at = null;
      store.dispatch('updateItem', createObj(this.input));
      // this.updateDataSortedAndFiltered(this.input);
      this.resetForm();
      this.closeModal();
      this.displayPopUpMessage();
    },
    deleteItem() {
      const id = this.input.id;
      store.dispatch('deleteItem', id);
      // this.applySortAndFiltersToData();
      if (this.input.id === id) {
        this.resetForm();
      }
      this.closeModal();
      this.displayPopUpMessage();
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
    applySortAndFiltersToData(e) {
      let obj = [];
      let objFiltered = [];
      if (this.searchText) {
        obj = this.findSearchText();
        objFiltered = this.applyFilter(obj);
      } else {
        objFiltered = this.applyFilter(this.$store.getters.getPageData);
      }
      this.dataSortedAndFiltered = this.sortData(e, objFiltered);
    },
    findSearchText() {
      const storeData = this.$store.getters.getPageData;
      const obj = [];
      storeData.forEach((item) => {
        let notFound = true;
        Object.values(item).forEach((value) => {
          if (String(value).toLowerCase().search(
              this.searchText.toLowerCase()) !== -1 && notFound) {
            obj.push(item);
            notFound = false;
          }
        });
      });
      return obj;
    },
    applyFilter(obj) {
      if (this.optionSelected !== 'Apply a filter') {
        const objFiltered = Object.values(obj).filter(item =>
          item.deleted_at === parseInt(this.optionSelected, 0));
        return objFiltered;
      }
      return obj;
    },
    sortData(e, obj) {
      if (e) {
        this.sortOrder = (this.sortOrder === 'asc') ? 'desc' : 'asc';
        obj.sort(compareValues(e.target.id, this.sortOrder));
        this.lastFieldOrder = e.target.id;
      } else {
        obj.sort(compareValues(this.lastFieldOrder, this.sortOrder));
      }
      return obj;
    },
    updateDataSortedAndFiltered(input) {
      Object.keys(this.dataSortedAndFiltered).forEach((key) => {
        if (this.dataSortedAndFiltered[key].id === input.id) {
          this.dataSortedAndFiltered[key] = createObj(input);
        }
      });
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
    },
  },
};
</script>

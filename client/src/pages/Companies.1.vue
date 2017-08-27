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
    padding-bottom:30px;
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
          <!--span v-if="!loading">
          ({{ totalRows }}) 
          </span-->
          </v-else>
          </h1>
        </div>
        <div class="col-xs-6" style="margin-top: 30px" align="right">
          <button class="btn btn-sm btn-primary" @click.prevent="showModalForm()"> {{ ts['addCompany'] }} </button>
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
                @keyup = "applySortAndFiltersToData()"
          >
          </input>
          <span class="input-group-addon" >
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
                    <button class="btn btn-sm btn-danger btn-std-width" @click.prevent="deleteItem()" v-if="isUpdateBtnShow" :disabled="isUpdateBtnDisable"> {{ ts['delete'] }} </button>
                    <button class="btn btn-sm btn-default btn-std-width" @click.prevent="resetForm()"> {{ ts['reset'] }} </button>
                    <button class="btn btn-sm btn-default btn-std-width" @click.prevent="closeModal()"> {{ ts['close'] }} </button>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div> <!--End Modal-->
      <div  class="table-responsive table-hscroll table-height">
        <table id="table1" class="table table-condensed table-hover">
          <th v-for="col in headers">
            <a @click.prevent="applySortAndFiltersToData($event)" style="cursor:pointer" :id="col.name">{{ ts[col.label] }}</a>
          </th>
         
          <tbody>
            <tr v-for="item in dataSortedAndFiltered" @click.prevent="editItem(item)">
            <!--tr v-for="item in data | search searchText" @click.prevent="editItem(item)"-->
              <td :min-width="item.width">{{item.id}}</td>
              <td :width="item.width">{{item.company_name}}</td>
              <td :width="item.width">{{item.company_contact}}</td>
              <td :width="item.width">{{item.company_email}}</td>
              <td :width="item.width">{{item.company_phone}}</td>
              <td :width="item.width">{{item.company_cellular}}</td>
              <td>
                <span v-if="(item.deleted_at===null)">
                  <button class="btn btn-xs btn-success btn-std-width"> {{ ts['active'] }}</button>
                </span>
                <span v-else>
                  <button class="btn btn-xs btn-danger btn-std-width"> {{ ts['inactive'] }}</button>
                </span> 
              </td>
              <td>
                <!--button class="btn btn-xs btn-primary btn-std-width" @click.prevent="editItem(item)">Edit</button-->
                <!--button class="btn btn-xs btn-danger btn-std-width" @click.prevent="deleteItem(item.company_id)">Delete</button-->
              </td>
            </tr>
          </tbody>
        </table>
      </div>
      <br><br>
      <mypaginator
          url="http://localhost:8000/api/shippers/companies"
          searchText="" 
          filter="" 
          fieldToOrder="" 
          order=""
        ></mypaginator>
      <!--mytable  
        table-id="table1"
        table-title="companyList" 
        select-fields='{	}'
        :columns-names="headers"
        url="http://localhost:8000/api/shippers/companies"
        icon-info='{	}'
        icon-actions='{		}'
      >
      </mytable-->
      <hr>
      <span v-if="(totalRows !== '')"><b> Count: {{ totalRows }} companies</b></span>
    </diV>
 
    <hr>
    <h4>TODO</h4>
    <ul>
      <li>ValidaFieldRequire requiere ajuste con los nuevos campos</li>
      <li>Instalar larave 5.5</li>
      <li>Configurar CORS</li>
      <li>Incorporar axios para extraer los datos</li>
      <li>traduccion en/sp desde los mensajes de usuario desde laravel/backend</li>
    </ul>

  </div>
</template>

<script>
// 3er Party Component
// import Multiselect from 'vue-multiselect';
import Axios from 'axios';
// vuex store
import store from '../store/Companies/Store';
// my components
import popup from '../components/messages/Popup';
import mylang from '../components/languages/Languages';
import mytable from '../components/tables/Table';
import mypaginator from '../components/tables/Paginator';
// my libraries
import createObj, { resetObjVal, compareValues } from '../lib/General';

// let count = 2;
// $(window).scroll(() => {
//   if ($(window).scrollTop() === $(document).height() - $(window).height()) {
//     // loadArticle(count);
//     // count++;
//     console.log('scroll');
//   }
// });

export default {
  name: 'Companies',
  mixins: [mylang],
  components: {
    popup,
    mytable,
    mypaginator,
    // Multiselect,
  },
  data() {
    return {
      title: 'Company',
      headers: [
        { name: 'id', label: 'id', width: '5%' },
        { name: 'company_name', label: 'companyName', width: '20%' },
        { name: 'company_contact', label: 'companyContact', width: '10%' },
        { name: 'company_email', label: 'companyEmail', width: '10%' },
        { name: 'company_phone', label: 'companyPhone', width: '10%' },
        { name: 'company_cellular', label: 'companyCellular', width: '10%' },
        { name: 'deleted_at', label: 'companyStatus', width: '10%' },
      ],
      // data: [],
      dataSortedAndFiltered: [],
      totalRows: '',
      searchText: '',
      optionSelected: 'Apply a filter',
      selectOptions: ['Apply A Filter', 'Active', 'Inactive'],
      lastFieldOrder: '',
      sortOrder: 'asc',
      loading: false,
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
      isUpdateBtnShow: false,
      isAddBtnDisable: true,
      isUpdateBtnDisable: true,
      closeAfterAction: true,
    };
  },

  mounted() {
    // this.loading = true;
    // store.dispatch('getAllData').then(() => {
    //   this.applySortAndFiltersToData();
    //   this.resetForm();
    //   this.loading = false;
    // });
    this.$worker.run(() => 'this.$worker run 1: Function in other thread')
    .then(console.log) // logs 'this.$worker run 1: Function in other thread'
    .catch(console.error);// logs any possible error

    this.$worker.run((arg1, arg2) => `this.$worker run 2: ${arg1} ${arg2}`, ['Another', 'function in other thread'])
    .then(console.log) // logs 'this.$worker run 2: Another function in other thread'
    .catch(console.error); // logs any possible error

    this.getAxios();
  },
  // filters: {
  //   search() {
  //    // return value;
  //   },
  // },
  computed: {
    showPopUpMessage() {
      return this.$store.getters.getShowMessage;
    },
  },

  methods: {
    getData10Items() {
      return Axios.get('http://localhost:8000/api/shippers/companies?page=1', { params: { per_pages: 100 } });
    },
    getDataAll() {
      return Axios.get('http://localhost:8000/api/shippers/companies');
    },
    getAxios() {
      this.loading = true;
      Axios.all([this.getData10Items(100)])
      .then(Axios.spread((response) => {
        this.totalRows = response.data.total;
        this.dataSortedAndFiltered = response.data.data;
      }));
      Axios.all([this.getDataAll()])
      .then(Axios.spread((response) => {
        response.data.data.splice(0, 100);
        this.dataSortedAndFiltered = [...new Set(
          [...this.dataSortedAndFiltered, ...response.data.data],
        )];
        this.loading = false;
      }));
    },
    addItem() {
      this.input.deleted_at = null;
      store.commit('ADD_ITEM', createObj(this.input));
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
      store.commit('UPDATE_ITEM', createObj(this.input));
      this.updateDataSortedAndFiltered(this.input);
      this.resetForm();
      this.closeModal();
      this.displayPopUpMessage();
    },
    editItem(row) {
      $('#myModal').modal('show');
      this.input = createObj(row);
      this.isUpdateBtnShow = true;
      this.isUpdateBtnDisable = false;
    },
    deleteItem() {
      const id = this.input.id;
      store.commit('DELETE_ITEM', id);
      this.applySortAndFiltersToData();
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
      this.isAddBtnDisable = true;
      this.isUpdateBtnDisable = true;
    },
    closeModal() {
      $('#myModal').modal('hide');
      this.resetForm();
      this.input.id = 'New';
      this.isUpdateBtnShow = false;
    },
    closeModalAfterAction() {
      if (this.closeAfterAction) {
        $('#myModal').modal('hide');
      }
    },
    applySortAndFiltersToData(e) {
      let obj = [];
      let objFiltered = [];
      if (this.searchText) {
        obj = this.findSearchText();
        objFiltered = this.applyFilter(obj);
      } else {
        objFiltered = this.applyFilter(this.$store.getters.getData);
      }
      this.dataSortedAndFiltered = this.sortData(e, objFiltered);
    },
    findSearchText() {
      const storeData = this.$store.getters.getData;
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
      if (this.input.id === '' || this.input.company_name === ''
        || this.input.company_email === '' || this.input.company_phone === '') {
        this.isAddBtnDisable = true;
        this.isUpdateBtnDisable = true;
      } else {
        this.isAddBtnDisable = false;
        this.isUpdateBtnDisable = false;
      }
    },
    displayPopUpMessage() {
      store.commit('UPDATE_MESSAGE', true);
      this.showPopUpMessage = this.$store.getters.getShowMessage;
    },
    showModalForm() {
      $('#myModal').modal('show');
    },
  },
};
</script>

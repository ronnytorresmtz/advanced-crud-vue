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
         <h1 v-text="ts['companyList']"></h1>
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
            <option value="Active"> {{ ts['active'] }} </option>
            <option value="Inactive"> {{ ts['inactive'] }} </option>
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
                <span v-if="(input.company_status==='Active')">
                  <button class="btn btn-xs btn-success btn-std-width" v-model="input.status"> {{ ts['active'] }} </button>
                </span>
                <span v-else>
                  <button class="btn btn-xs btn-danger btn-std-width" v-model="input.status"> {{ ts['inactive'] }} </button>
                </span>
              </div>
              <form>
                <label> {{ ts['companyId'] }}: </label> <span class="aster-red" v-text="!input.company_id ? ' *' : ''"></span>
                <input type="text" class="form-control" v-model="input.company_id" @keyup="validFieldsRequired" :disabled="true"></input>
                <label> {{ ts['companyName'] }}: </label><span class="aster-red" v-text="!input.company_name ? ' *' : ''"></span>
                <input type="text" class="form-control" v-model="input.company_name" @keyup="validFieldsRequired"></input>
                <label> {{ ts['companyEmail'] }}: </label><span class="aster-red" v-text="!input.company_email ? ' *' : ''"></span>
                <input type="text" class="form-control" v-model="input.company_email" @keyup="validFieldsRequired"></input>
                <label> {{ ts['companyPhone'] }}: </label><span class="aster-red" v-text="!input.company_phone ? ' *' : ''"></span>
                <input type="text" class="form-control" v-model="input.company_phone" @keyup="validFieldsRequired"></input>
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
        <table class="table table-condensed table-hover">
          <th v-for="col in headers">
            <a @click.prevent="applySortAndFiltersToData($event)" style="cursor:pointer" :id="col.name">{{ ts[col.label] }}</a>
          </th>
          <tbody>
            <tr v-for="item in dataSortedAndFiltered" @click.prevent="editItem(item)">
            <!--tr v-for="item in data | search searchText" @click.prevent="editItem(item)"-->
              <td :min-width="item.width">{{item.company_id}}</td>
              <td :width="item.width">{{item.company_name}}</td>
              <td :width="item.width">{{item.company_email}}</td>
              <td :width="item.width">{{item.company_phone}}</td>
              <td>
                <span v-if="(item.company_status==='Active')">
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
    </diV>

    <hr>
    <h4>TODO</h4>
    <ul>
      
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
// vuex store
import store from '../store/Companies/Store';
// my components
import popup from '../components/messages/Popup';
import mylang from '../components/languages/Languages';
// my libraries
import createObj, { resetObjVal, compareValues } from '../lib/General';


export default {
  name: 'Companies',
  mixins: [mylang],
  components: {
    popup,
    // Multiselect,
  },
  data() {
    return {
      title: 'Company',
      headers: [
        { name: 'company_id', label: 'companyId', width: '10%' },
        { name: 'company_name', label: 'companyName', width: '30%' },
        { name: 'company_email', label: 'companyEmail', width: '20%' },
        { name: 'company_phone', label: 'companyPhone', width: '20%' },
        { name: 'company_status', label: 'companyStatus', width: '10%' },
      ],
      // data: [],
      dataSortedAndFiltered: [],
      searchText: '',
      optionSelected: 'Apply a filter',
      selectOptions: ['Apply A Filter', 'Active', 'Inactive'],
      lastFieldOrder: '',
      sortOrder: 'asc',
      input: {
        company_id: 'New',
        company_name: '',
        company_email: '',
        company_phone: '',
        company_status: '',
      },
      isUpdateBtnShow: false,
      isAddBtnDisable: true,
      isUpdateBtnDisable: true,
      closeAfterAction: true,
    };
  },

  mounted() {
    store.commit('INIT_DATA');
    this.data = this.$store.getters.getData;
    this.applySortAndFiltersToData();
    this.resetForm();
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
    // changeFilter(e) {
    //   console.log(e.target.children.options.value);
    //   this.radioSelected = e.target.children.options.value;
    // },
    addItem() {
      this.input.company_status = 'Active';
      store.commit('ADD_ITEM', createObj(this.input));
      this.applySortAndFiltersToData();
      this.lastFieldOrder = 'company_id';
      this.sortOrder = 'desc';
      this.dataSortedAndFiltered = this.dataSortedAndFiltered.sort(
        compareValues(this.lastFieldOrder, this.sortOrder));
      this.closeModalAfterAction();
      this.resetForm();
      this.displayPopUpMessage();
    },
    updateItem() {
      this.input.company_status = 'Active';
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
      const id = this.input.company_id;
      store.commit('DELETE_ITEM', id);
      this.applySortAndFiltersToData();
      if (this.input.company_id === id) {
        this.resetForm();
      }
      this.closeModal();
      this.displayPopUpMessage();
    },
    resetForm() {
      store.commit('RESET_ITEM');
      const id = this.input.company_id;
      const status = this.input.company_status;
      this.input = resetObjVal(this.input);
      this.input.company_id = id;
      this.input.company_status = status;
      this.isAddBtnDisable = true;
      this.isUpdateBtnDisable = true;
    },
    closeModal() {
      $('#myModal').modal('hide');
      this.resetForm();
      this.input.company_id = 'New';
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
          item.company_status === this.optionSelected);
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
        if (this.dataSortedAndFiltered[key].company_id === input.company_id) {
          this.dataSortedAndFiltered[key] = createObj(input);
        }
      });
    },
    validFieldsRequired() {
      if (this.input.company_id === '' || this.input.company_name === ''
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

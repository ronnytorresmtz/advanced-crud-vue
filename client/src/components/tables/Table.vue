<style scoped>

 tr{
    cursor: pointer;
  }

  .table-hscroll{
     white-space: nowrap;
     overflow-x: auto;
     overflow-y: auto;
     width:auto
  }

  .table-height{
    height: 340px;
  }

  .table-cell-hide {
    display: none;
  }

  .table-cell-show {
    display: 'tab-cell';
  }

  .btn-width {
    width: 60px;
  }
  .icon-cog {
    padding-right: 20px;
    padding-bottom: 10px;
  }
  .dropdown-item-cog {
    padding-top: 2px;
    padding-left: 10px;
  }

  [v-cloak] {
    display: none;
  }

</style>

<template>
  <div>
    <div class="row icon-cog">
      <div class="dropdown">
        <!--Cog Icon -->
        <a class="dropdown-toggle pull-right" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
          <span class="glyphicon glyphicon-cog"></span>
        </a>
        <br>
        <!--Choose field to display-->
        <ul class="dropdown-menu pull-right" aria-labelledby="dropdownMenu1">
          <h6 class="dropdown-header">{{ ts['chooseAFieldToDisplay'] }}</h6>
          <li v-for="col in cols" class="dropdown-item-cog">
             <input type="checkbox":name="col.name" @change.stop.prevent="columnToDisplay($event)" :checked="col.display">
            {{ ts[col.label] }} 
            </input>
         </li>
        </ul>
      </div> 
    </div>
    <!--Table-->
    <div  class="table-responsive table-hscroll">
      <table id="table1" class="table table-hover">
        <!--Table Header-->
        <th v-for="(col, key) in cols" :class="`table-cell-${hideOrShowCell(col.name)}`">
          <a @click.prevent="sort($event)" style="cursor:pointer" :id="col.name"> 
            <span :class="isOrderBy()" v-show="isFieldOrder(col.name)"></span>
            {{ ts[col.label] }} 
          </a>
        </th>
        <tbody>
          <!--Table Rows-->
          <tr v-for="row in rows">
            <td v-for="(value, key) in row" @click.prevent="itemSelected(row)" :id="key" :class="`table-cell-${hideOrShowCell(key)}`" >
              <span v-if="key=='deleted_at'" >
                <span v-if="value==null" v>
                    <span class="btn btn-xs btn-success btn-width"> {{ ts['active'] }} </span>
                </span>
                <span v-else>
                    <span class="btn btn-xs btn-danger btn-width"> {{ ts['inactive'] }} </span>
                </span>
              </span>
              <span v-else>
                  {{value}}
              </span>
            </td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>

</template>

<script>
// vues store
// import store from '../../store/Companies/Store';
import store from '../../store/Store';
// my components
import MyLang from '../../components/languages/Languages';
// my libraries
import createObj, { getValueFromLocalStorage } from '../../lib/General';

export default {

  mixins: [MyLang],

  props: ['cols', 'rows'],

  data() {
    return {
    };
  },

  updated() {
    if (localStorage.getItem(`${this.$parent.moduleName}/colsHeaders`) !== null) {
      const colsInfo = JSON.parse(getValueFromLocalStorage(this.$parent.moduleName, 'colsHeaders'));
      Object.keys(colsInfo).forEach((key) => {
        this.cols[key].display = colsInfo[key].display;
      });
    }
  },

  methods: {
    hideOrShowCell(key) {
      let action = 'hide';
      Object.keys(this.cols).forEach((col) => {
        if (this.cols[col].name === key) {
          if (this.cols[col].display) {
            action = 'show';
          }
        }
      });
      return action;
    },
    columnToDisplay(e) {
      Object.keys(this.cols).forEach((col) => {
        if (this.cols[col].name === e.target.name) {
          this.cols[col].display = !this.cols[col].display;
        }
      });
      store.commit(`${this.$parent.moduleName}/UPDATE_COLS_HEADERS`, this.cols);
    },
    itemSelected(row) {
      const dataRow = store.getters[`${this.$parent.moduleName}/getPageData`].filter(item => item.id === row.id);
      store.commit(`${this.$parent.moduleName}/UPDATE_ITEM`, createObj(dataRow[0]));
      store.commit(`${this.$parent.moduleName}/SHOW_BTN_UPDATE`, true);
      store.commit(`${this.$parent.moduleName}/SHOW_BTN_ADD_DISABLE`, false);
      store.commit(`${this.$parent.moduleName}/SHOW_BTN_UPDATE_DISABLE`, false);
      store.commit(`${this.$parent.moduleName}/SHOW_CLOSE_AFTERACTION_DEFAULT`, false);
      store.commit(`${this.$parent.moduleName}/SHOW_MODAL`, true);
    },
    sort(e) {
      const fieldOrderBy = e.target.id;
      const orderBy = (store.getters[`${this.$parent.moduleName}/getOrderBy`] === 'asc' && fieldOrderBy === store.getters[`${this.$parent.moduleName}/getFieldOrderBy`]) ? 'desc' : 'asc';
      store.commit(`${this.$parent.moduleName}/UPDATE_ORDER_BY`, orderBy);
      store.commit(`${this.$parent.moduleName}/UPDATE_FIELD_ORDER_BY`, fieldOrderBy);
      store.dispatch(`${this.$parent.moduleName}/getDataFiltered`);
    },
    isFieldOrder(name) {
      return (name === store.getters[`${this.$parent.moduleName}/getFieldOrderBy`]);
    },
    isOrderBy() {
      if (store.getters[`${this.$parent.moduleName}/getOrderBy`] === 'asc') {
        return 'glyphicon glyphicon-sort-by-alphabet';
      }
      return 'glyphicon glyphicon-sort-by-alphabet-alt';
    },
  },
};
</script>

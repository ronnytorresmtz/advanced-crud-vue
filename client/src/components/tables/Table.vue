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
        <a class="dropdown-toggle pull-right" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
          <span class="glyphicon glyphicon-cog"></span>
          <!--span class="caret"></span-->
        </a>
        <br>
        <ul class="dropdown-menu pull-right" aria-labelledby="dropdownMenu1">
          <h6 class="dropdown-header">{{ ts['ChooseAFieldToDisplay'] }}</h6>
          <li v-for="col in cols" class="dropdown-item-cog">
            <input type="checkbox":name="col.name" @change.stop.prevent="columnToDisplay($event)" :checked="col.display">
            {{ ts[col.label] }} 
            </input>
         </li>
        </ul>
      </div>
    </div>
    <div  class="table-responsive table-hscroll table-height"> <!-- v-if="!loading"-->
      <table id="table1" class="table table-hover">
        <th v-for="(col, key) in cols" :class="`table-cell-${hideOrShowCell(col.name)}`">
          <a @click.prevent="sort($event)" style="cursor:pointer" :id="col.name"> <!--v-if="col.display"-->
            <span :class="isOrderBy()" v-show="isFieldOrder(col.name)"></span>
            {{ ts[col.label] }} 
          </a>
        </th>
        <tbody>
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
import store from '../../store/Companies/Store';
// my components
import MyLang from '../../components/languages/Languages';
// my libraries
import createObj from '../../lib/General';

export default {

  mixins: [MyLang],

  props: ['cols', 'rows'],

  data() {
    return {
    };
  },

  updated() {
    const colsInfo = JSON.parse(localStorage.getItem('colsInfo'));
    Object.keys(colsInfo).forEach((key) => {
      this.cols[key].display = colsInfo[key].display;
    });
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
      this.storeInLocalStorage('colsInfo', this.cols);
    },
    itemSelected(row) {
      const dataRow = this.$store.getters.getPageData.filter(item => item.id === row.id);
      store.commit('UPDATE_ITEM', createObj(dataRow[0]));
      store.commit('SHOW_BTN_UPDATE', true);
      store.commit('SHOW_BTN_ADD_DISABLE', false);
      store.commit('SHOW_BTN_UPDATE_DISABLE', false);
      store.commit('SHOW_CLOSE_AFTERACTION_DEFAULT', false);
      store.commit('SHOW_MODAL', true);
    },
    sort(e) {
      const fieldOrderBy = e.target.id;
      const orderBy = (this.$store.getters.getOrderBy === 'asc' && fieldOrderBy === this.$store.getters.getFieldOrderBy) ? 'desc' : 'asc';
      store.commit('UPDATE_ORDER_BY', orderBy);
      store.commit('UPDATE_FIELD_ORDER_BY', fieldOrderBy);
      store.dispatch('getDataFiltered');
    },
    isFieldOrder(name) {
      return (name === this.$store.getters.getFieldOrderBy);
    },
    isOrderBy() {
      if (this.$store.getters.getOrderBy === 'asc') {
        return 'glyphicon glyphicon-sort-by-alphabet';
      }
      return 'glyphicon glyphicon-sort-by-alphabet-alt';
    },
    storeInLocalStorage(key, value) {
      if (typeof (Storage) !== 'undefined') {
        localStorage.setItem(key, JSON.stringify(value));
      }
    },
  },
};
</script>

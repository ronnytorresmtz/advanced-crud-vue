<style scoped>

 tr{
    cursor: pointer;
  }

  .table-hscroll{
     white-space: nowrap;
     overflow-x: auto;
     overflow-y: auto;
     width:auto;
  }

  .table-height{
    height: 370px;
  }

  .btn-width {
    width: 60px;
  }


</style>

<template>

  <div  class="table-responsive table-hscroll table-height">
    <table id="table1" class="table table-condensed table-hover">
      <th v-for="col in cols">
        <a @click.prevent="sort($event)" style="cursor:pointer" :id="col.name">
          <span :class="isOrderBy()" v-show="isFieldOrder(col.name)"></span>
          {{ ts[col.label] }}
        </a>
      </th>
      <tbody>
        <tr v-for="row in rows">
          <td  v-for="(value, key) in row" @click.prevent="itemSelected(row)">
            <span v-if="key=='deleted_at'" >
              <span v-if="value==null">
                  <span class="btn btn-xs btn-success btn-width"> {{ ts['active'] }} </span>
              </span>
              <span v-else>
                  <span class="btn btn-xs btn-danger btn-width"> {{ ts['inactive'] }} </span>
              </span>
            </span>
            <span v-else >
                {{value}}
            </span>
          </td>
        </tr>
      </tbody>
    </table>
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

  methods: {
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
      console.log(fieldOrderBy);
      const orderBy = (this.$store.getters.getOrderBy === 'asc' && fieldOrderBy === this.$store.getters.getFieldOrderBy) ? 'desc' : 'asc';
      // if (fieldOrderBy !== this.$store.getters.getFieldOrderBy) {
      //   orderBy = 'asc';
      // }
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
  },
};
</script>

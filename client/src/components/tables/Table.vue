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

</style>

<template>

 

  <div  class="table-responsive table-hscroll table-height">
    <table id="table1" class="table table-condensed table-hover">
      <th v-for="col in cols">
        <a @click.prevent="sortAndFilter($event)" style="cursor:pointer" :id="col.name">{{ ts[col.label] }}</a>
      </th>
      <tbody>
        <tr v-for="row in rows">
          <td  v-for="(value, key) in row" @click.prevent="itemSelected(row)">
            <span v-if="key=='deleted_at'" >
              <span v-if="value==null">
                  <span class="btn btn-xs btn-success button-width-lg"> {{ ts['active'] }} </span>
              </span>
              <span v-else>
                  <span class="btn btn-xs btn-danger button-width-lg"> {{ ts['inactive'] }} </span>
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
    sortAndFilter(e) {
      console.log('sortAndFilter', e);
    },
  },
};
</script>

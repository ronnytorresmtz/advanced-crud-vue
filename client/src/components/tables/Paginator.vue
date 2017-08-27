<style scope>
  .button-width {
    width: 50px;
  }

  .pagination-showing {
    padding-top: 10px; 
    font-size: 14px;
    display: inline; 
  }
  
  .label-nomorepages {
    padding-right:20px; 
    color:gray;
    font: bold; 
    font: italic;
  }

</style>

<template>
  <div class="row">
    <div class="col-sm-6">
      <div align="left" class="pagination-showing">
        {{ ts['pages'] }}
        <select type="text" v-model="perPage" @change="getData(url)">
          <option v-for="item in perPagesList" :value="item">{{item}}</option>
        </select>
        <span> {{ ts['showing'] }}: {{pagination.from}} {{ ts['to'] }} {{pagination.to}} {{ ts['of'] }} {{pagination.total}} {{ ts['items'] }} </span>
      </div>
      
    </div>
    <div class="col-sm-6">
      <div align="right">
        <a class="btn btn-sm btn-primary button-width" 
        @click.prevent="getData(url)"> {{ ts['start'] }} </a>
        <a class="btn btn-sm btn-primary button-width" 
        @click.prevent="getData(pagination.prev_page_url)"> {{ ts['prev'] }} </a>
        <a class="btn btn-sm btn-primary button-width"
        @click.prevent="getData(pagination.next_page_url)"> {{ ts['next'] }} </a>
        <a class="btn btn-sm btn-primary button-width" 
        @click.prevent="getData(url + '?page=' + pagination.last_page)"> {{ ts['end'] }} </a>
        <br/> <br/>
      </div>
    </div>
    <div v-if="noMorePages" class="label-nomorepages" align="right">
      {{ ts['noMorePages'] }}
    </div>
  </div>
</template>

<script>
  // import Axios from 'axios';
  import store from '../../store/Companies/Store';
  // my components
  import MyLang from '../../components/languages/Languages';

  export default {

    mixins: [MyLang],

    props: ['url', 'searchText', 'filter', 'fieldToOrder', 'order'],

    data() {
      return {
        // pagination: {},
        noMorePages: false,
        perPagesList: ['5', '10', '25', '50', '100'],
        perPage: '10',
      };
    },

    created() {
      this.getData();
    },

    computed: {
      pagination() {
        return this.$store.getters.getPagination;
      },
    },

    methods: {
      getData(pageUrl) {
        store.commit('UPDATE_LOADING', true);
        this.noMorePages = false;
        if (pageUrl !== null) {
          const newPageUrl = pageUrl || this.url;
          store.dispatch('getData', newPageUrl, this.perPage)
          .then(() => {
            store.commit('UPDATE_LOADING', false);
          })
          .catch(() => {
            store.commit('SHOW_MESSAGE', 'Error');
            store.commit('UPDATE_LOADING', false);
          });
          // const self = this;
          // Axios.get(newPageUrl, { params: { per_pages: self.perPage } })
          // .then((response) => {
          //   self.setPagination(response.data);
          //   store.commit('UPDATE_PAGEDATA', response.data.data);
          //   store.commit('UPDATE_LOADING', false);
          // });
        } else {
          this.noMorePages = true;
          store.commit('UPDATE_LOADING', false);
        }
      },
      // setPagination(data) {
      //   const pagination = {
      //     current_page: data.current_page,
      //     from: data.from,
      //     last_page: data.last_page,
      //     next_page_url: data.next_page_url,
      //     path: data.path,
      //     per_page: data.per_page,
      //     prev_page_url: data.prev_page_url,
      //     to: data.to,
      //     total: data.total,
      //   };
      //   store.commit('UPDATE_PAGINATION', pagination);
      //   this.pagination = pagination;
      // },
    },
  };
</script>

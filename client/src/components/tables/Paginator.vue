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
        @click.prevent="setStartPageUrl"> {{ ts['start'] }} </a>
        <a class="btn btn-sm btn-primary button-width" 
        @click.prevent="setPrevPageUrl"> {{ ts['prev'] }} </a>
        <a class="btn btn-sm btn-primary button-width"
        @click.prevent="setNextPageUrl"> {{ ts['next'] }} </a>
        <a class="btn btn-sm btn-primary button-width" 
        @click.prevent="setEndPageUrl"> {{ ts['end'] }} </a>
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

    props: ['url', 'filter', 'fieldToOrder', 'order'],

    data() {
      return {
        noMorePages: false,
        perPagesList: ['5', '10', '25', '50', '100'],
        perPage: '10',
      };
    },

    created() {
      this.getData(this.pagination.path);
    },

    computed: {
      pagination() {
        return this.$store.getters.getPagination;
      },
      searchText() {
        return this.$store.getters.getSearchText;
      },
      optionSelected() {
        return this.$store.getters.getOptionSelected;
      },
    },

    methods: {
      setStartPageUrl() {
        const pageUrl = `${this.pagination.path}?searchText=${this.searchText}&optionSelected=${this.optionSelected}&itemsByPage=${this.perPage}`;
        this.getData(pageUrl);
      },
      setPrevPageUrl() {
        let pageUrl = '';
        if (this.pagination.prev_page_url) {
          pageUrl = `${this.pagination.prev_page_url}&searchText=${this.searchText}&optionSelected=${this.optionSelected}&itemsByPage=${this.perPage}`;
        } else {
          pageUrl = null;
        }
        this.getData(pageUrl);
      },
      setNextPageUrl() {
        let pageUrl = '';
        if (this.pagination.next_page_url) {
          pageUrl = `${this.pagination.next_page_url}&searchText=${this.searchText}&optionSelected=${this.optionSelected}&itemsByPage=${this.perPage}`;
        } else {
          pageUrl = null;
        }
        this.getData(pageUrl);
      },
      setEndPageUrl() {
        const pageUrl = `${this.pagination.path}?page=${this.pagination.last_page}&searchText=${this.searchText}&optionSelected=${this.optionSelected}&itemsByPage=${this.perPage}`;
        this.getData(pageUrl);
      },
      getData(pageUrl) {
        store.commit('UPDATE_LOADING', true);
        this.noMorePages = false;
        if (pageUrl !== null) {
          const newPageUrl = pageUrl || this.url;
          store.dispatch('getData', `${newPageUrl}?searchText=${this.searchText}&optionSelected=${this.optionSelected}&itemsByPage=${this.perPage}`)
          .then(() => {
            store.commit('UPDATE_LOADING', false);
          })
          .catch(() => {
            alert('Unexpected Error (Pagination Component - method getData)');
            store.commit('UPDATE_LOADING', false);
          });
        } else {
          this.noMorePages = true;
          store.commit('UPDATE_LOADING', false);
        }
      },
    },
  };
</script>

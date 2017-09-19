<style scoped>
  tr{
    cursor: pointer;
  }

  table {
    background: white;
    border: solid;
    border-width: 2px;
    border-color: #ccc;
    position: absolute;
    z-index: 9999;
   }

  input {
    margin-bottom: 10px;
  }

  .table-hscroll{
     white-space: nowrap;
     overflow-x: auto;
     overflow-y: auto;
     width:auto;
  }

  .table-height{
    height: auto;
  }

  nav ul{
    position: absolute;
    z-index: 9999;
    list-style-type: none;
    cursor: pointer;
    overflow:hidden; 
    overflow-y:scroll;
    width: 100%;
    height: 115px;
    margin-top: -12px;
    padding: 6px 6px;
    font-size: 14px;
    line-height: 1.42857143;
    color: #555;
    background-color: #fff;
    background-image: none;
    border: 1px solid #ccc;
    border-radius: 4px;
    -webkit-box-shadow: inset 0 1px 1px rgba(0,0,0,.075);
    box-shadow: inset 0 1px 1px rgba(0,0,0,.075);
    -webkit-transition: border-color ease-in-out .15s,-webkit-box-shadow ease-in-out .15s;
    -o-transition: border-color ease-in-out .15s,box-shadow ease-in-out .15s;
    transition: border-color ease-in-out .15s,box-shadow ease-in-out .15s;
  }

  li:hover{
    background: #f4f4f4;
  }

</style>

<template>
  <div>
    <input
      id="autocomplete"
      :placeholder= "ts['enterCityStateCountry']"
      @keyup="search($event)"
      v-model ="locationText"
      class="form-control"
      type="text">
    </input>
    <div class="row">
      <div class="col-xs-11">
        <div class="table-responsive" v-show="showSearchResults">
          <nav>
            <ul>
              <li v-for="location in locationsSelected" @click.prevent="selectItem($event)"> 
                {{location}} 
              </li>
            </ul>
          </nav>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
// vuex store
import store from '../../store/Companies/Store';
// my components
import mylang from '../../components/languages/Languages';

export default {

  mixins: [mylang],

  created() {
    this.initSearch();
    this.locationsSelected = this.locations;
  },

  data() {
    return {
      // locationText: '',
      locationsSelected: [],
      showSearchResults: false,
    };
  },

  computed: {
    locations() {
      return this.$store.getters.getLocations;
    },
    locationText: {
      set() { },
      get() {
        return this.$store.getters.getLocation;
      },
    },
  },

  methods: {

    initSearch() {
      store.dispatch('getLocations');
    },
    resetSearch() {
      if (this.locationText.length < 1) {
        this.showSearchResults = false;
        this.locationsSelected = [];
      }
    },
    showSearchResult() {
      if (this.locationsSelected.length > 0) {
        this.showSearchResults = true;
      } else {
        this.showSearchResults = false;
      }
    },
    autoSelectSearchResult() {
      if (this.locationsSelected.length === 1) {
        this.locationText = this.locationsSelected[0];
        this.showSearchResults = false;
        this.locationsSelected = [];
      }
    },
    getLocationsByLocationText() {
      if (this.locationText.length > 1) {
        this.locationsSelected = this.locations.filter(location =>
          location.toUpperCase().indexOf(this.locationText.toUpperCase()) !== -1,
        );
      }
      if (this.locationsSelected.length < 1) {
        this.showSearchResults = false;
      }
    },
    isEscKey(e) {
      if (e.keyCode === 27) {
        this.showSearchResults = false;
        this.locationsSelected = [];
        this.locationText = '';
        return true;
      }
      return false;
    },
     /*
      * KeyCodes:
      *   Backspace = 8, Delete = 46, LeftArrow =37,
      *   RightArrow=39, Start=36, End=35
      */
    search(e) {
      store.commit('UPDATE_LOCATION', e.target.value);
      if (!this.isEscKey(e)) {
        if (![8, 46, 37, 36, 37, 39].includes(e.keyCode)) {
          this.getLocationsByLocationText();
          this.showSearchResult();
        } else {
          this.resetSearch();
          this.getLocationsByLocationText();
          this.showSearchResult();
        }
      }
      this.validateLocationText();
    },
    selectItem(e) {
      store.commit('UPDATE_LOCATION', e.target.outerText);
      this.locationsSelected = [];
      this.showSearchResults = false;
    },
    validateLocationText() {
      const isEmptyFields = (this.locationText.length === 0);
      store.commit('SHOW_BTN_ADD_DISABLE', isEmptyFields);
      store.commit('SHOW_BTN_UPDATE_DISABLE', isEmptyFields);
    },
  },
};
</script>

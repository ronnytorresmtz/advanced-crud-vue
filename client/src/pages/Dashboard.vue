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
    <div class="row" >
      <div class="col-sm-2" v-if="showSidebar">
        <mysidebar id="sidebarCompanies"></mysidebar>
      </div>
      <!--div :class="`col-xs-${(showSidebar)? 10 : 12}`"-->
      <div class="col-xs-12" @mouseover.stop.prevent="collapseSidebar">

        <!--message component-->
        <transition enter-active-class="animated fadeInDown" leave-active-class="animated fadeOutUp">
          <mypopup v-if="showPopUpMessage"> </mypopup>
        </transition>

        <!--Panel-->
        <div class="panel panel-default panel-padding" style="margin-top: 75px">
          <div class="row">
            <div class="col-xs-6">
              <!--Page Title-->
              <h3> {{ ts['dashboard']}}
              <!--Spin Icon-->
              <span v-if="loading">
                <i class="fa fa-spinner fa-spin" aria-hidden="true"></i>
              </span>
              </h3>
            </div>
          </div>
           <hr>
          <div class="row">
          </div>
        </div>  
      </div>
    </div>
  </div> 
</template>

<script>
// vuex store
import store from '../store/Store';
// my components
import mypopup from '../components/messages/Popup';
import mylang from '../components/languages/Languages';
import mysidebar from '../components/layout/sidebar';
// my libraries

export default {
  name: 'dashboard',
  mixins: [mylang],
  components: {
    mypopup,
    mysidebar,
  },

  data() {
    return {
      title: 'Dashboard',
      moduleName: 'dashboard',
    };
  },

  created() {
  },

  computed: {
    baseUrlDashboad() {
      return store.getters[`${this.moduleName}/getBaseUrlDashboard`];
    },
    showPopUpMessage: {
      set() { },
      get() {
        return store.getters[`${this.moduleName}/getShowMessage`];
      },
    },
    loading() {
      return store.getters[`${this.moduleName}/getLoading`];
    },
    showSidebar() {
      return store.getters.getShowSidebar;
    },
  },

  methods: {
    collapseSidebar() {
      store.commit('SHOW_SIDEBAR', false);
    },
  },
  watch: {
  },
};
</script>

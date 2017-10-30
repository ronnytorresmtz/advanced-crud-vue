<style scoped>
  .topbar-icons {
    color:#e1ffff;
    padding-right:20px;
  }
  .brand {
    text-align: left !important;
    font-size: 22px;
    padding-left: 20px;
    line-height: 50px !important;
    background-color: #337ab7;
    line-height: 50px;
    display: block;
    text-align: center;
    font-size: 14px;
    color: #e1ffff;
    font-family: verdana;
  }
</style>



<template>
  <div>
    <nav class="navbar navbar-default navbar-fixed-top" style="background:#3c8dbc" >
      <div class="container-fluid">
        <div class="row">
          <div class="col-xs-1">
            <i class="fa fa-bars fa-lg" 
              style="margin-top:20px; color: white; cursor:pointer"
              @click="expandCollapse"> 
            </i>
          </div>
          <div class="col-xs-11">
            <div class="col-xs-11" align="right" style="margin-top:15px" @mouseover.stop.prevent="collapseSidebar">
                <i class="fa fa-bell-o topbar-icons"> </i>
                <i class="fa fa-comment-o topbar-icons"></i>
                <i class="fa fa-flag-o topbar-icons"></i>
            </div>
            <div class="col-xs-1" align="center" @click.stop.prevent="expandCollapse">
                <myavatar 
                  email="ronnytorresmtz@gmail.com" 
                  circle-size="32px" 
                  letter-size="1.5em">
                </myavatar>
            </div>
          </div>
        </div>      
      </div>
    </nav>
  </div>
</template>

<script>

  import store from '../../store/Store';
  import myavatar from '../../components/layout/avatar';

  export default {

    components: {
      myavatar,
    },

    data() {
      return {
      };
    },

    computed: {
      showSidebar() {
        return store.getters.getShowSidebar;
      },
    },

    methods: {
      collapseSidebar() {
        store.commit('SHOW_SIDEBAR', false);
      },
      expandCollapse() {
        store.commit('SHOW_SIDEBAR', !this.showSidebar);
      },
    },
  };
</script>

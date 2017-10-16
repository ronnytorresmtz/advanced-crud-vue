<style>
  .topbar-icons {
    color:#e1ffff;
    padding-right:20px;
  }
</style>

<template>
  <div>
    <nav class="navbar navbar-default navbar-fixed-top" style="background:#3c8dbc" >
      <div class="container-fluid">

        <div class="col-xs-3">
          
          <label style="padding-top:15px; margin-left:-20px; background-color:#3c8dbc; cursor:pointer" @click="expandCollapse">
            <i class="fa fa-bars fa-lg" style="color: white"> </i>
          </label>
        </div>
        <div class="col-xs-9" align="right">
            <i class="fa fa-bell-o topbar-icons"></i>
            <i class="fa fa-comment-o topbar-icons"></i>
            <i class="fa fa-flag-o topbar-icons"></i>
            <myavatar email="ronnytorresmtz@gamial.com" size="28"></myavatar>
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
      expandCollapse() {
        store.commit('SHOW_SIDEBAR', !this.showSidebar);
      },
    },
  };
</script>

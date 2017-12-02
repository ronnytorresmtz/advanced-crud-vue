<style scoped>
  .topbar-icons {
    color:#e1ffff;
    padding-right:20px;
    cursor: pointer;
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
            <i class="fa fa-bars fa-md" 
              style="margin-top:20px; color: white; cursor:pointer"
              @click="expandCollapse"> 
            </i>
          </div>
          <div class="col-xs-11">
            <div class="col-xs-8">
            </div>
            <div class="col-xs-4" align="right">
                <i class="fa fa-bell-o fa-md topbar-icons" aria-hidden="true"> </i>
                <i class="fa fa-comment-o fa-md topbar-icons" aria-hidden="true"></i>
                <i class="fa fa-flag-o fa-md topbar-icons" aria-hidden="true"></i>
                <myavatar 
                  email="ronnytorresmtz@gmail.com" 
                  circle-size="32px" 
                  letter-size="1.5em"
                  background="white"
                  color="black"
                  >
                </myavatar>
               <span style="padding-left:20px" @click="logout">
                <i class="fa fa-power-off fa-md topbar-icons"
                  aria-hidden="true"
                  :title="ts['logout']"
                > 
                </i>
               </span>
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
  import mylang from '../../components/languages/Languages';

  export default {

    mixins: [mylang],

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
      logout() {
        store.dispatch('login/logout');
      },
    },
  };
</script>

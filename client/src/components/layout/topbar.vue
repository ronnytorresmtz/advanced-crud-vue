<template>
  <div>
    <nav class="navbar navbar-default navbar-fixed-top" style="background:#3c8dbc" >
      <div class="container-fluid">

        <div class="col-xs-3">
          <label style="padding-top:15px; margin-left:-20px; background-color:#3c8dbc; cursor:pointer" @click="expandCollapse">
            <i class="fa fa-bars fa-lg" style="color: white"> </i>
          </label>
        </div>
      
      </div>

    </nav>
  </div>
</template>

<script>

  import store from '../../store/Store';

  export default {

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

<style scoped>
  body {
    margin: 0px;
    padding: 0px;
  }
  .nav-side-menu {
    overflow-y: auto;
    overflow-x: hidden;
    font-family: verdana;
    font-size: 12px;
    font-weight: 200;
    background-color: #2e353d;
    background:rgba(0,0,0,0.85);
    position: fixed;
    top: 0px;
    left: 0px;
    /*width: 225px;*/
    height: 100%;
    color: #e1ffff;
    z-index: 9999;
  }
  .nav-side-menu .brand {
    background-color: #337ab7;
    line-height: 50px;
    display: block;
    text-align: center;
    font-size: 14px;
  }
  .nav-side-menu .toggle-btn {
    display: none;
  }
  .nav-side-menu ul, .nav-side-menu li {
    list-style: none;
    padding: 0px;
    margin: 0px;
    line-height: 35px;
    cursor: pointer;
  }
  .nav-side-menu ul :not(collapsed) .arrow:before, 
  .nav-side-menu li :not(collapsed) .arrow:before {
    font-family: FontAwesome;
    content: "\f078";
    display: inline-block;
    padding-left: 10px;
    padding-right: 10px;
    vertical-align: middle;
    float: right;
  }
  .nav-side-menu ul .active, .nav-side-menu li .active {
    border-left: 3px solid #337ab7;
    background-color: #181c20;
  }
  .nav-side-menu ul .sub-menu li.active, .nav-side-menu li .sub-menu li.active {
   color: white;
  }
  .nav-side-menu ul .sub-menu li.active a, .nav-side-menu li .sub-menu li.active a {
    color: white;
  }
  .nav-side-menu ul .sub-menu li a {
     color: #b8c7ce;
   }
  .nav-side-menu ul .sub-menu li,  .nav-side-menu li .sub-menu li {
    background-color: #181c20;
    border: none;
    line-height: 28px;
    border-bottom: 1px solid #23282e;
    margin-left: 0px;
    background:rgba(0,0,0,0.5);
    
  }
  .nav-side-menu ul .sub-menu li:hover, .nav-side-menu li .sub-menu li:hover {
    /*background-color: #020203;*/
    background-color: #4f5b69;
  }
  .nav-side-menu ul .sub-menu li:before,   .nav-side-menu li .sub-menu li:before {
    font-family: FontAwesome;
    /*content: "\f105";*/
    content: "";
    display: inline-block;
    padding-left: 10px;
    padding-right: 10px;
    vertical-align: middle;
  }
  .nav-side-menu li {
    padding-left: 0px;
    border-left: 3px solid #2e353d;
    border-bottom: 1px solid #23282e;
    padding:7px;
  }
  .nav-side-menu li a {
    text-decoration: none;
    color: white;
  }
  .nav-side-menu li a i {
    padding-left: 10px;
    width: 20px;
    padding-right: 20px;
  }
  .nav-side-menu li:hover {
    border-left: 3px solid #337ab7;
    background-color: #4f5b69;
    -webkit-transition: all 1s ease;
    -moz-transition: all 1s ease;
    -o-transition: all 1s ease;
    -ms-transition: all 1s ease;
    transition: all 1s ease;
  }
  @media (max-width: 767px) {
    .nav-side-menu {
      position: relative;
      width: 100%;
      margin-bottom: 10px;
    }
    .nav-side-menu .toggle-btn {
      display: block;
      cursor: pointer;
      position: absolute;
      right: 10px;
      top: 10px;
      z-index: 10 !important;
      padding: 3px;
      background-color: #ffffff;
      color: #000;
      width: 40px;
      text-align: center;
    }
    .brand {
        text-align: left !important;
        font-size: 22px;
        padding-left: 20px;
        line-height: 50px !important;
    }
  }
  @media (min-width: 767px) {
    .nav-side-menu .menu-list .menu-content {
      display: block;
    }
  }

.sidebar-navigatorbar-title {
  margin-top: 5px;
  background:rgba(0,0,0,0.2);
  padding: 10px;
  text-align: center;
}
.sidebar-online {
    font-size: 10.5px;
  }
.sidebar-online-circle:before {
  content: ' \25CF';
  font-size: 20px;
  color: #03a51e;
}


</style>

<template>

<div class="container" >
  <div class="nav-side-menu">
    <div class="row">
      <div class="col-xs-12">
        <div class="row brand">
          <div class="col-xs-9">
            <span>
              Brand Logo <!--Karganos.com, Despachador.com, Kargaloz.com, Kargalox.com-->
            </span>
          </div>
          <div class="col-xs-3" >
            <i class="fa fa-chevron-left fa-lg" 
              style="margin-right: 50px;color: white; cursor:pointer"
              @click="expandCollapse"> 
            </i>
          </div>
        </div>  

        <div class="row">
          <div class="col-xs-4">
            <myavatar 
              email="ronnytorresmtz@gmail1.com" 
              circle-size="50px" 
              letter-size="2em"
            >
            </myavatar>
          </div>
          <div class="col-xs-8" style="margin-top:10px">
            <span>Ronny Torres</span>
            <p class="sidebar-online">
              <span class="sidebar-online-circle"></span> 
              Online
            </p>
          </div>
        </div>
            
        <div class="sidebar-navigatorbar-title">NAVIGATION BAR</div>
        <div class="menu-list">
            <ul id="menu-content" class="menu-content collapse out" v-for="row in menus">
              <li data-toggle="collapse" :data-target="`#${row.name}`" class="collapsed">
                <a>
                  <i :class="`fa ${row.icon} fa-lg`"></i> 
                  <span >{{ row.name }}</span> 
                  <span class="arrow"></span>
                </a>
              </li>
              <ul class="sub-menu collapse" :id="row.name">
                <li v-for="child in row.child" @click.prevent="expandCollapse">
                  <i :class="`fa ${child.icon} fa-lg`"></i>
                  <!--a :href="child.link">
                      {{ child.name }}
                  </a-->
                  <router-link :to="child.link" >
                    {{ child.name }}
                  </router-link>
                </li>
              </ul>
            </ul>
        </div>
      </div>
    </div>
  </div>
</div>
</template>

<script>
  import store from '../../store/Store';
  import mymenus from '../../components/layout/menus';
  import myavatar from '../../components/layout/avatar';

  export default {

    components: {
      myavatar,
    },

    data() {
      return {
        menus: [],
      };
    },

    created() {
      this.menus = mymenus;
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

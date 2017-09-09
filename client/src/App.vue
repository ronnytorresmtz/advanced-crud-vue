<template>
  <div id="app" style="margin:0px">
    <topbar></topbar>
    <router-view></router-view>
  </div>
</template>

<script>

import topbar from './components/layout/topbar';

export default {
  name: 'app',

  components: {
    topbar,
  },
};
</script>

<style>
#app {
  font-family: 'Avenir', Helvetica, Arial, sans-serif;
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
  text-align: center;
  color: #2c3e50;
  margin-top: 20px;
}

</style>

<style>
html {
  height: 100%;
}
body {
  background-color:#f2f2f2;
}
</style>

<template>
  <div id="app" style="margin:0px;">
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


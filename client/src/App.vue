<template>
  <div id="app" style="margin:0 px;">
    <topbar moduleName="companies"></topbar>
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

<style></style>

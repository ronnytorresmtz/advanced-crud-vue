<style scoped>
 .avatar {
    border-radius: 50%;
    -moz-border-radius: 50%;
    -webkit-border-radius: 50%;
  }
  .avatar-margin {
    margin:10px;
  }
  .avatar-border {
    border: solid 2px; 
    border-color: #e1ffff;
  }
  
</style>

<template>
    <img 
      class="avatar avatar-margin" 
      :src="`${gratavarImage}?s=${size}`" 
    >
</template>

<script>

  export default {

    props: ['email', 'size'],

    data() {
      return {
        gratavarImage: '',
      };
    },

    created() {
      // const md5Emal = md5(this.email);bf2eb61bb075298edd8d6a1f104e40de
      this.gratavarImage = 'https://www.gravatar.com/avatar/205e460b479e2e5b48aec07710c08d50';
    },
  };
</script>

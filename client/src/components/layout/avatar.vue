<style scoped>
 .gravatar {
    border-radius: 50%;
    -moz-border-radius: 50%;
    -webkit-border-radius: 50%;
  }
  .gravatar-margin {
    margin:10px;
  }
  .gravatar-border {
    border: solid 2px; 
    border-color: #e1ffff;
  }

  .color {
    background-color: white;
    color: black;
  }

  .cicle {
    margin: 10px;
    display: block;
    -moz-border-radius: 50%;
    border-radius: 50%;
   }

  .letter {
    text-align: center;
  }
    
 
</style>

<template>
  <span v-if="gravatar">
    <img class="gravatar gravatar-margin" :src="gratavarUrl">
  </span>
  <a v-else href="https://es.gravatar.com/"
    class="color cicle letter" 
    :style="`height:${circleSize}; width:${circleSize}; line-height:${circleSize}; font-size:${letterSize}`">
    {{ email[0].toUpperCase() }}
  </a>
</template>

<script>

  import md5 from 'crypto-js/md5';
  import Axios from 'axios';

  export default {

    props: ['email', 'circleSize', 'letterSize'],

    data() {
      return {
        gratavarUrl: '',
        gravatar: false,
      };
    },

    created() {
      // const md5Emal = md5(this.email);bf2eb61bb075298edd8d6a1f104e40de
      // const hash = '205e460b479e2e5b48aec07710c08d50';
      const hash = md5(this.email);
      this.gratavarUrl = `https://www.gravatar.com/avatar/${hash}?s=${this.circleSize}&d=404`;
      Axios.get(this.gratavarUrl)
      .then(() => {
        this.gravatar = true;
      })
      .catch(() => {
        this.gravatar = false;
      });
    },
  };
</script>

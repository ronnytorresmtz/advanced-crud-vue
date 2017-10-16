<style scope>

  .popup-position {
    padding: 15px;
    position: fixed;
    border: 1px solid transparent;
    border-radius: 4px;
    width: auto ;
    left:0px;
    right: 0px;
    top: 0px;
    text-align: center;
    z-index:  9999;
    padding: 15px;
  }

  .popup-info {
    color: #31708f;
    background-color: #d9edf7;
    border-color: #bce8f1;
  }

  .popup-success {
    color: #3c763d;
    background-color: #dff0d8;
    border-color: #d6e9c6;
  }

  .popup-warning {
    color: #8a6d3b;
    background-color: #fcf8e3;
    border-color: #faebcc;
  }

  .popup-danger {
    color: #a94442;
    background-color: #f2dede;
    border-color: #ebccd1;
  }

  .popup-close {
    position: absolute;
    margin-right: 10px;
    right: 0;
    top: 0;
    cursor: pointer;
    font-size: x-large;
  }

</style>

      <template>

        <div :id="message.id" :class="'popup-position popup-' + message.type" v-show="showAlert" >
            {{message.text}}
            <span class="popup-close" v-show="showAlert" @click.prevent="hideBoxMessage"> &times; </span>
        </div>
        <!--/div-->

      </template>

      <script>
        import store from '../../store/Store';

        export default {

          data() {
            return {
              message: {},
            };
          },

          created() {
            this.message = store.getters[`${this.$parent.moduleName}/getMessage`];
            this.hideBoxMessageByTime();
          },

          computed: {
            showAlert() {
              this.message = store.getters[`${this.$parent.moduleName}/getMessage`];
              return this.message.show;
            },
          },

          methods: {
            hideBoxMessage() {
              store.commit(`${this.$parent.moduleName}/CLOSE_MESSAGE`, false);
            },

            hideBoxMessageByTime() {
              if (this.message.type === 'info') {
                setTimeout(() => {
                  store.commit(`${this.$parent.moduleName}/CLOSE_MESSAGE`, false);
                }, 3000);
              }
            },
          },
        };
</script>

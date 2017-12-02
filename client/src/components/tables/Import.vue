<style>

</style>

<template>
  <!--Modal Form-->
  <div class="modal fade" id="myModalImport" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="myModalFormLabel">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header" style="background:#f5f5f5">
          <!--Modal Header-->
          <!--button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button-->
          <h4 class="modal-title" id="myModalImportLabel">{{ ts['importFile'] }}</h4>
        </div>
        <div class="modal-body">
          <Form>
            <!-- Input File -->
            <input type="file" @change.prevent="selectFile($event)">
            <br>
            <div class="modal-footer">
              <div class="row">
                <div class="col-md-12" align="right">
                  <!--Modal Buttons-->
                  <button class="btn btn-sm btn-success" @click.prevent="importFile($event)"> 
                  <span v-if="processing"> <i class="fa fa-spinner fa-spin" aria-hidden="true"></i> </span>
                  {{ ts['import'] }}
                  </button>
                  <button type="reset" @click.prevent="resetFile" class="btn btn-sm btn-success">{{ ts['reset'] }}</button>
                  <button class="btn btn-sm btn-default" data-dismiss="modal" @click.prevent="closeModal">{{ ts['close'] }}</button>
                </div>
              </div>
            </div>
          </Form>
        </div>
      </div>
    </div>
  </div>
 </div>


</template>

<script>
  // vuex store
  // import store from '../../store/Companies/Store';
  import store from '../../store/Store';
  // my components
  import MyLang from '../../components/languages/Languages';

  export default {

    mixins: [MyLang],

    props: ['urlImport'],

    data() {
      return {
        processing: false,
        file: '',
      };
    },

    computed: {
      showImportModal() {
        return store.getters[`${this.$parent.moduleName}/getShowImportModal`];
      },
    },

    methods: {
      selectFile(e) {
        this.file = e.target.files[0];
      },
      importFile() {
        if (this.file.name !== undefined) {
          this.processing = true;
          store.dispatch(`${this.$parent.moduleName}/importFile`, this.file).then(() => {
            this.resetFile();
          });
        } else {
          const message = { data: { message: 'Select a file to import and try again', error: 400 } };
          store.commit(`${this.$parent.moduleName}/SHOW_MESSAGE`, message);
        }
      },
      resetFile() {
        $('input[type=file]').val('');
        this.file = '';
      },
      closeModal() {
        this.resetFile();
        store.commit(`${this.$parent.moduleName}/SHOW_IMPORT_MODAL`, false);
      },
    },

    watch: {
      showImportModal() {
        if (store.getters[`${this.$parent.moduleName}/getShowImportModal`]) {
          this.processing = false;
          $('#myModalImport').modal('show');
          $('input[type=file]').val('');
        } else {
          $('#myModalImport').modal('hide');
        }
      },
    },
  };
</script>

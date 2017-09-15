<style>

</style>

<template>
  <!--Modal Form-->
  <div class="modal fade" id="myModalImport" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="myModalFormLabel">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header" style="background:#f5f5f5">
          <!--Modal Header-->
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title" id="myModalImportLabel">{{ ts['importFile'] }}</h4>
        </div>
        <div class="modal-body">
          <Form>
            <!-- Input File -->
            <input type="file" name="fileToImport" id="fileToImport" @change.prevent="selectFile($event)">
            <br>
            <div class="modal-footer">
              <div class="row">
                <div class="col-md-12" align="right">
                  <!--Modal Buttons-->
                  <button class="btn btn-sm btn-success" @click.prevent="importFile($event)"> 
                  <span v-if="processing"> <i class="fa fa-spinner fa-spin"></i> </span>
                  {{ ts['import'] }}
                  </button>
                  <button type="reset" class="btn btn-sm btn-success">{{ ts['reset'] }}</button>
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
  import store from '../../store/Companies/Store';
  // my components
  import MyLang from '../../components/languages/Languages';

  export default {

    mixins: [MyLang],

    props: ['urlImport'],

    data() {
      return {
        processing: false,
      };
    },

    computed: {
      showImportModal() {
        return this.$store.getters.getShowImportModal;
      },
    },

    methods: {
      selectFile(e) {
        this.file = e.target.files[0];
      },
      importFile() {
        this.processing = true;
        store.dispatch('importFile', this.file);
      },
    },

    watch: {
      showImportModal() {
        if (this.$store.getters.getShowImportModal) {
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

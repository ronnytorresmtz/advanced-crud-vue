<style scoped>

  .processing{
    color:blue;
    padding-left: 5px;
  }

</style>

<template>
  <div class="modal fade" id="myModalImport" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="myModalFormLabel">
  <!--div class="modal fade" id="myModalImport" tabindex="-1" role="dialog" aria-labelledby="myModalImportLabel" aria-hidden="true" data-backdrop="false"-->
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header" style="background:#f5f5f5">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title" id="myModalImportLabel">{{ ts['importFile'] }}</h4>
        </div>
        <div class="modal-body">
          <Form>
            <input type="file" name="fileToImport" id="fileToImport" @change.prevent="selectFile($event)">
            <br>
            <div class="modal-footer">
              <div class="row">
                <div class="col-md-6" align="left">
                  <div v-if="processing">
                    <span class="processing" align="left">
                      <!--img src="/assets/icons/loading_image.gif"/> {{ ts['processing'] }} -->
                    </span>
                  </div>
                  <div v-else>
                    &nbsp;
                  </div>
                </div>
                <div class="col-md-6" align="right">
                  <button class="btn btn-sm btn-success" @click.prevent="importFile($event)"> {{ ts['import'] }}</button>
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
  import Axios from 'axios';
  import MyLang from '../../components/languages/Languages';
  import store from '../../store/Companies/Store';

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
      // importItems() {
      //   // instance of FileReader
      //   const self = this;
      //   const reader = new FileReader();
      //   self.loading = true;
      //   // load file to memory. convert to json and execute an ajax call
      //   self.fileProcessMsg = 'importing file';
      //   reader.onload = () => {
      //     const rows = reader.result.split('\r\n');
      //     const fields = rows[0].split(',');
      //     const data = self.convertoToJson(fields, rows);
      //     self.sendDataViaAjax(data);
      //   };
      //   reader.onerror = () => {
      //     // self.displayErrorMessage(e.target.error.code);
      //     self.displayPopUpMessage(null);
      //   };
      //   // read the file
      //   reader.readAsText(this.files[0]);
      // },
      // sendDataViaAjax(data) {
      //   // No me gusta como quedo - el manejo de errores no es bueno
      //   // El mensaje que se regresa de cuando se agregaron y cuantos
      //   // de actualizaron no se regresa bien
      //   // vue-resourece no nos funciona serí ideal utilizarlo.
      //   console.log(this.urlImport);
      //   this.processing = true;
      //   const self = this;
      //   Axios.post('http://localhost:8000/api/shippers/companies/import', { data })
      //   .then((response) => {
      //     if (!response.data.error) {
      //       self.reloadAfterAction();
      //     }
      //     store.commit('SHOW_IMPORT_MODAL', false);
      //     store.commit('SHOW_MESSAGE', response);
      //   })
      //   .catch((response) => {
      //     store.commit('SHOW_IMPORT_MODAL', false);
      //     store.commit('SHOW_MESSAGE', response);
      //   });
        // $.ajax({
        //   method: 'POST',
        //   dataType: 'json',
        //   url: this.urlImport,
        //   data: { values: data },
        // }).error((response) => {
        //   self.displayPopUpMessage(response);
        //   store.commit('SHOW_IMPORT_MODAL', false);
        // }).success((response) => {
        //   if (!response.error) {
        //     self.reloadAfterAction();
        //   }
        //   self.displayPopUpMessage(response);
        //   store.commit('SHOW_IMPORT_MODAL', false);
        // });
      // },
      // convert rows/fields to json
      // convertoToJson(fields, rows) {
      //   let data = '{';
      //   // for (let i = 1; i < rows.length; i++) {
      //   Object.keys(rows).forEach((i) => {
      //     let rowData = `"${i}":{`;
      //     const row = rows[i].split(',');
      //     // for (let j = 0; j < row.length; j++) {
      //     Object.keys(row).forEach((j) => {
      //       rowData = `${rowData}"${fields[j]}":"${row[j]}",`;
      //     });
      //     rowData = `${rowData.substr(0, rowData.length - 1)}}`;
      //     data = `${data}${rowData},`;
      //   });
      //   data = `${data.substr(0, data.length - 1)}}`;
      //   return data;
      // },
      importFile() {
        const formData = new FormData();
        formData.append('fileToImport', this.file);
        Axios.post('http://localhost:8000/api/shippers/companies/import', formData)
        .then((response) => {
          if (!response.data.error) {
            self.reloadAfterAction();
          }
          store.commit('SHOW_IMPORT_MODAL', false);
          store.commit('SHOW_MESSAGE', response);
        })
        .catch((response) => {
          store.commit('SHOW_IMPORT_MODAL', false);
          store.commit('SHOW_MESSAGE', response);
        });
      },
      reloadAfterAction() {
        const url = this.$store.getters.getPagination.path;
        store.dispatch('getData', url);
      },
      closeModal() {
        store.commit('SHOW_IMPORT_MODAL', false);
      },
      displayPopUpMessage(response) {
        store.commit('SHOW_MESSAGE', response);
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

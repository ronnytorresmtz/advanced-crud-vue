<style scoped>

  .processing{
    color:blue;
    padding-left: 5px;
  }
 
</style>

<template>
  <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="false">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header" style="background:#f5f5f5">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title" id="myModalLabel">{{ ts['importFile'] }}</h4>
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
                      <img src="/assets/icons/loading_image.gif"/> {{ ts['processing'] }}
                    </span>
                  </div>
                  <div v-else>
                    &nbsp;
                  </div>
                </div>
                <div class="col-md-6" align="right">
                  <button class="btn btn-sm btn-success" @click.prevent="importItems($event)"> {{ ts['import'] }}</button>
                  <button type="reset" class="btn btn-sm btn-success">{{ ts['reset'] }}</button>
                  <button class="btn btn-sm btn-default" data-dismiss="modal" @click.prevent="closeModal">{{ ts['close'] }}</button>
                <div>
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
  import MyLang from '../../components/languages/Languages.vue';

  module.exports = {

    mixins: [MyLang],

    props: ['urlImport'],

    data: function() {
      return {
        processing: false
      }
    },

    methods: {

      selectFile: function(e){
        this.files = e.target.files;
      },

      importItems: function(e){
        //instance of FileReader
        var self=this;
        var reader = new FileReader();
        self.loading= true;
        //load file to memory. convert to json and execute an ajax call
        self.fileProcessMsg='importing file';
        reader.onload = function()  {
          var rows = reader.result.split('\r\n');
          var fields = rows[0].split(',');
          var data = self.convertoToJson(fields, rows);
          self.sendDataViaAjax(data);
        };
        reader.onerror = function(e) {
            self.displayErrorMessage(evt.target.error.code);
        };
        //read the file  
        reader.readAsText(this.files[0]);
      },

      sendDataViaAjax:function(data){

        //No me gusta como quedo - el manejo de errores no es bueno
        //El mensaje que se regresa de cuando se agregaron y cuantos de actualizaron no se regresa bien
        //vue-resourece no nos funciona serí ideal utilizarlo.
        this.processing = true;
        var self=this;
        $.ajax({
          method: "POST", 
          dataType: "json",
          url: this.urlImport,
          data: {values: data}
        }).error(function(response) {
          $('#myModal').modal('hide');
          self.displayErrorMessage(response);
        }).success(function(response) {
          if (! response.error){
            self.reloadAfterAction();
            $('#myModal').modal('hide');
            self.displayPopUpMessage(response);
          }else{
            $('#myModal').modal('hide');
            self.displayErrorMessage(response);
          }
        });

      },

      //convert rows/fields to json
      convertoToJson: function(fields, rows){
        var data='{';
        for (var i = 1; i < rows.length ; i++) {
          var rowData='"' + i + '":{';
          var row=rows[i].split(',')
          for (var j = 0; j < row.length ; j++) {
            rowData=rowData + '"' + fields[j] + '":"' + row[j] + '",' ;
          }
          rowData= rowData.substr(0,rowData.length-1) + '}';
          data=data + rowData + ",";
        };
        data=data.substr(0,data.length-1) + '}';

        return data;
      },

      reloadAfterAction: function(){
       this.$dispatch('reloadTable');
      },

      closeModal: function(){
        $('#myModal').modal('hide');          
      },

      displayPopUpMessage: function(response){
        this.$dispatch('displayAlert', 'success', response.message + ' (200)');
      },

      displayErrorMessage: function(response){
        this.$dispatch('displayAlert', 'danger', response.message + ' (400)');
      },

    },

    events: {

      selectImportFile: function(e){
        this.processing=false;
        $('#myModal').modal('show');
        $('input[type=file]').val('');
      }
  
    }
  
  }
</script>

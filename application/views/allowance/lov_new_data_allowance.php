<div id="modal_allowance" class="modal fade" tabindex="-1" style="overflow-y: scroll;">
    <div class="modal-dialog" style="width:700px;">
        <div class="modal-content">
            <!-- modal title -->
            <div class="modal-header no-padding">
                <div class="table-header">
                    <span class="form-add-edit-title"> Create New Data Allowance</span>
                </div>
            </div>

            <!-- modal body -->
            <div class="modal-body">
                <div class="form-horizontal" >
                    <div class="form-body">
                        <!--/row-->
                        <div class="row">
                          <div class="col-md-12">
                              <form action="#" class="form-horizontal" id="form_data" method="post" enctype="multipart/form-data" accept-charset="utf-8">
                                <div class="form-body">
                                    <!--/row-->
                                    <div class="row">
                                      <div class="col-md-8">
                                          <div class="col-md-12">
                                                  <div class="form-group">
                                                      <label class="control-label col-md-3">Start Date</label>
                                                      <div class="col-md-9">
                                                      <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
                                                          <input type="text" id="start_date" name="start_date" readonly required class="form-control datepickerform required"> 
                                                          <input type="hidden" id="emp_master_id" name="emp_master_id">
                                                      </div>
                                                  </div>
                                              </div>
                                              <div class="col-md-12">
                                                  <div class="form-group">
                                                      <label class="control-label col-md-3">End Date </label>
                                                      <div class="col-md-9">
                                                          <input type="text" id="end_date" name="end_date"  readonly required class="form-control datepickerform required"> </div>
                                                  </div>
                                              </div>
                                              <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label class="control-label col-md-3"> </label>
                                                        <div class="col-md-9">
                                                          <select class="form-control required" required name="allowance_type" id="allowance_type">
                                                            <?php echo getDataRef3('allowancetype');?>
                                                          </select>
                                                    </div>
                                                </div>
                                            </div>
                                              <div class="col-md-12">
                                                  <div class="form-group">
                                                      <label class="control-label col-md-3"> </label>
                                                      <div class="col-md-9">
                                                          <input type="submit" class="btn btn-default" value="Submit">
                                                  </div>
                                              </div>
                                      </div>
                                    </div>
                                  </div>
                                </div>
                              </form>
                            </div>
                    </div>
                </div>
            </div>
            </div>

            <!-- modal footer -->
            <div class="modal-footer no-margin-top">
                <div class="bootstrap-dialog-footer">
                    <div class="bootstrap-dialog-footer-buttons">
                        <button class="btn btn-danger btn-sm radius-4" data-dismiss="modal">
                            <i class="fa fa-times"></i>
                            Close
                        </button>
                    </div>
                </div>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.end modal -->

<script type="text/javascript">
  $(document).ready(function(){

     $("#form_data").on('submit', (function (e) {
          e.preventDefault();
          var data = new FormData(this); 

          url = '<?php echo WS_JQGRID."allowance.allowancebatchs_controller/submitData"; ?>';  
          
          $.ajax({
            type: 'POST',
            url: url,
            data: data,
            contentType: false, // The content type used when sending data to the server.
            cache: false, // To unable request pages to be cached
            processData: false,
            success: function(response) {
                response = JSON.parse(response);
              if(response.success) {
                  swal({title: 'Info', text: response.message, html: true, type: "info"});
                  $("#modal_lov_icon").modal("toggle");
              }else{
                  swal({title: 'Attention', text: response.message, html: true, type: "warning"});
              }
            }

          });

          return false;
      }));
     var active_dates = ["21/5/2014","25/5/2014"];
      $('.datepickerform').datepicker({
          format: 'dd-mm-yyyy',
          autoclose:false,
          multidate:true, 
          beforeShowDay: function(date){
           var d = date;
           var curr_date = d.getDate();
           var curr_month = d.getMonth() + 1; //Months are zero based
           var curr_year = d.getFullYear();
           var formattedDate = curr_date + "/" + curr_month + "/" + curr_year

             if ($.inArray(formattedDate, active_dates) != -1){
                 return {
                    classes: 'activeClass'
                 };
             }
            return;
        }
      });

  });
        $(function($) {
            $("#modal_lov_icon_btn_blank").on('click', function() {
                $("#"+ $("#modal_lov_icon_id_val").val()).val("");
                $("#"+ $("#modal_lov_icon_code_val").val()).val("");
                $("#modal_lov_icon").modal("toggle");
            });
        });
        function loadFormDataOneDate(id){
            attr = $('#dataform_'+id).attr('dataform');
            attr = attr.split('|');

            $('#dateLov').val(attr[0]+ ' - ' + attr[1]);
            $('#statusLov').val(attr[2]);
            $('#idLov').val(id);
        }
        function loadFormDataAllData(){
            
        }
        function modal_allowance_show(id) {
            $('#emp_master_id').val(id);
            $("#modal_allowance").modal({backdrop: 'static'});
        }

        function setDataAll(){

        }
        function setData(){
            id = $('#idLov').val();
            attr = $('#dataform_'+id).attr('dataform');
            tipeText = $("#allowance_typeLov option:selected").text();
            tipeId = $("#allowance_typeLov").val();
            message = ' | '+$("#messageLov").val();
            formData = attr + '|' + tipeId +'|'+message;
            $('#dataform_'+id).attr('formData',formData);
            $('#TPD'+id).html('');
            $('#TPD'+id).html(tipeText +  message);
        }
    
</script>
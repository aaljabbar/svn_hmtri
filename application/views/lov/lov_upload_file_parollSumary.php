<div id="modal_lov_uploadSumay" class="modal fade" tabindex="-1" style="overflow-y: scroll;">
    <div class="modal-dialog">
        <div class="modal-content">
            <!-- modal title -->
            <div class="modal-header no-padding">
                <div class="table-header">
                    <span class="form-add-edit-title"> Evidence </span>
                </div>
            </div>

            
            
                <form role="form" id="form_legal" name="form_legal" method="post" enctype="multipart/form-data" accept-charset="utf-8">
                    <input type="hidden" id="payrollsummary_id" name="payrollsummary_id">
                    <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">

                    <!-- modal body -->
                     <div class="modal-body">
		                <div class="row">
		                    <div class="col-md-12">
		                        <div class="portlet light bordered">
		                            <div class="form-body">
		                                <div class="space-2"></div>
			                            <div class="row">
		                                    <label class="control-label col-md-3">Upload File</label>
		                                    <div class="input-group col-md-7">
		                                    	<input type="file" id="filename" name="filename" required/>
		                                    </div>
			                            </div><!-- 
		                                <div class="space-2"></div>
		                                <div class="row">
		                                    <label class="control-label col-md-3">Deskripsi</label>
		                                    <div class="input-group col-md-7">
		                                        <textarea rows="5" class="form-control" id="deskripsi" name="deskripsi" ></textarea>   
		                                    </div>
		                                </div> -->
		                            </div>  
		                        </div>       
		                    </div>   
		                </div>
		            </div>
                    <!-- modal footer -->
                    <div class="modal-footer no-margin-top">
		                <div class="bootstrap-dialog-footer">
		                    <div class="bootstrap-dialog-footer-buttons">
		                        <button class="btn btn-sm green-jungle radius-4">
		                            <i class="ace-icon fa fa-check"></i>
		                            Save
		                        </button>
		                        <button class="btn btn-danger btn-sm radius-4" data-dismiss="modal">
		                            <i class="fa fa-times"></i>
		                            Close
		                        </button>
		                    </div>
		                </div>
		            </div>
                </form>
           

            
            
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.end modal -->



<script>    

    $(function() {
        /* submit */
        $("#form_legal").on('submit', (function (e) {
            e.preventDefault();   
            var data = new FormData(this);
            //console.log(data);

            $.ajax({
                url: "<?php echo WS_JQGRID."process.flaging_payment_controller/readUpdate"; ?>" ,
                type: "POST",
                dataType: "json",
                data: data,
                timeout: 10000,
                contentType: false,       // The content type used when sending data to the server.
                cache: false,             // To unable request pages to be cached
                processData: false, 
                success: function (data) {
                    //console.log(data);
                    if (data.success){
                        swal({title: "Success!", text: data.message, html: true, type: "success"});
                        $('#filename').val('');
                        $('#modal_lov_uploadSumay').modal('hide');
                    }else{
                        swal({title: "Error!", text: data.message, html: true, type: "error"});
                    }
                    $("#grid-table").trigger("reloadGrid");
                },
                error: function (xhr, status, error) {
                    swal({title: "Error!", text: xhr.responseText, html: true, type: "error"});
                }
            });
                
            return false;
        }));
        
    });

    function modal_lov_uploadSumay_show(payrollsummary_id) {
        modal_lov_uploadSumay_init(payrollsummary_id);
        $("#modal_lov_uploadSumay").modal({backdrop: 'static'});
    }

    function modal_lov_uploadSumay_init(payrollsummary_id) {

        $('#payrollsummary_id').val( payrollsummary_id );
    }

     


    
</script>
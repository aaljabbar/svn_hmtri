<div id="modal_lov_show_picture" class="modal fade" tabindex="-1" style="overflow-y: scroll;">
    <div class="modal-dialog">
        <div class="modal-content">
            <!-- modal title -->
            <div class="modal-header no-padding">
                <div class="table-header">
                    <span class="form-add-edit-title"> Picture </span>
                </div>
            </div>

            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <img id="image" class="col-md-12" src="">
                    </div>   
                </div>
            </div>
            <!-- modal footer -->
            <div class="modal-footer no-margin-top">
                <div class="bootstrap-dialog-footer">
                    <div class="bootstrap-dialog-footer-buttons">
                        <button class="btn btn-sm green-jungle radius-4" data-dismiss="modal">
                            <i class="fa fa-times"></i>
                            Close
                        </button>
                    </div>
                </div>
            </div>
            
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.end modal -->



<script>    

    

    function modal_lov_show_picture_show(path_name) {
        modal_lov_show_picture_init(path_name);
        $("#modal_lov_show_picture").modal({backdrop: 'static'});
    }

    function modal_lov_show_picture_init(path_name) {
        $("#image").attr("src",path_name);
    }

     


    
</script>
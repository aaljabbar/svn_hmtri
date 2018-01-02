<div id="modal_allowance" class="modal fade" tabindex="-1" style="overflow-y: scroll;">
    <div class="modal-dialog" style="width:700px;">
        <div class="modal-content">
            <!-- modal title -->
            <div class="modal-header no-padding">
                <div class="table-header">
                    <span class="form-add-edit-title"> Set Allowance</span>
                </div>
            </div>

            <!-- modal body -->
            <div class="modal-body">
                <div class="form-horizontal" >
                    <div class="form-body">
                        <!--/row-->
                        <div class="row">
                            <div class="col-md-12">
                              <div class="col-md-12">
                                      <div class="form-group">
                                          <label class="control-label col-md-3">Date</label>
                                          <div class="col-md-9">
                                              <input class="form-control " type="hidden" readonly name="idLov" id="idLov">
                                              <input class="form-control " type="hidden" readonly name="tipeLov" id="tipeLov">
                                              <input class="form-control " type="text" readonly name="dateLov" id="dateLov">
                                          </div>
                                      </div>
                                  </div>
                                   <div class="col-md-12">
                                      <div class="form-group">
                                          <label class="control-label col-md-3">Status</label>
                                          <div class="col-md-9">
                                              <input class="form-control " type="text" readonly name="statusLov" id="statusLov">
                                          </div>
                                      </div>
                                  </div>
                                  <div class="col-md-12">
                                    <div class="form-group">
                                          <label class="control-label col-md-3"> </label>
                                          <div class="col-md-9">
                                            <select class="form-control required" required name="allowance_typeLov" id="allowance_typeLov">
                                              <?php echo getDataRef3('allowancetype');?>
                                            </select>
                                      </div>
                                    </div>
                                  </div>
                                  <div class="col-md-12">
                                      <div class="form-group">
                                          <label class="control-label col-md-3">Message</label>
                                          <div class="col-md-9">
                                              <textarea class="form-control col-md-3" id="messageLov" row="3"></textarea>
                                          </div>
                                      </div>
                                  </div>
                                  <div class="col-md-12">
                                      <div class="form-group">
                                          <label class="control-label col-md-3"></label>
                                          <div class="col-md-9">
                                              <button type="button" class="btn btn-default" onclick="setData()">
                                                  <i class="fa fa-check"></i> Set Data
                                              </button>
                                          </div>
                                      </div>
                                  </div>
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
        $(function($) {
            $("#modal_lov_icon_btn_blank").on('click', function() {
                $("#"+ $("#modal_lov_icon_id_val").val()).val("");
                $("#"+ $("#modal_lov_icon_code_val").val()).val("");
                $("#modal_lov_icon").modal("toggle");
            });
        });
        function loadFormDataOneDate(id){
            
            //attr = id.split('|');

            $('#dateLov').val(id);
            //$('#statusLov').val(attr[2]);
            $('#idLov').val(id);
        }
        function loadFormDataAllData(){
            $('#dateLov').val('');
            //$('#statusLov').val(attr[2]);
            $('#idLov').val('');
        }
        function modal_allowance_show(mode, id) {
            $('#dateLov').val('');
            $('#idLov').val('');

            if(mode == 'oneDate'){
                loadFormDataOneDate(id);
                $('#tipeLov').val(0);
            }else{
                loadFormDataAllData();
                $('#tipeLov').val(1);
            }
            $("#modal_allowance").modal({backdrop: 'static'});
        }

        function setDataAll(){

        }

        function setData(){
          if($('#tipeLov').val() > 0){

            $('.dateAllow').each(function(){
                allowance_type_id = $('#allowance_typeLov').val();
                messageLov = $('#messageLov').val();
                $(this).attr('allowance_type_id',allowance_type_id);
                $(this).attr('description',messageLov);
                $(this).removeClass('btn-default');
                $(this).addClass('btn-primary');
                $(this).addClass('set');

            });
             
          }else{
                id  = $('#idLov').val();
                allowance_type_id = $('#allowance_typeLov').val();
                messageLov = $('#messageLov').val();
                $('.'+id).attr('allowance_type_id',allowance_type_id);
                $('.'+id).attr('description',messageLov);
                $('.'+id).removeClass('btn-default');
                $('.'+id).addClass('btn-primary');
                $('.'+id).addClass('set');

          }
            $("#modal_allowance").modal({backdrop: 'static'});
        }
    
</script>
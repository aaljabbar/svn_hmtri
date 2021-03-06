<link href="<?php echo base_url(); ?>assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.css" rel="stylesheet" type="text/css" />
<!-- breadcrumb -->

<div class="page-bar">
    <ul class="page-breadcrumb">
        <li>
            <a href="<?php base_url(); ?>">Home</a>
            <i class="fa fa-circle"></i>
        </li>
        <li>
            <span>Master Data </span>
        </li>
        <li>
            <span>Employee Master</span>
        </li>
    </ul>
</div>
<!-- end breadcrumb -->
<div class="space-4"></div>


<div class="space-4"></div>

 <div class="portlet light bordered" style="min-height:700px;">
        <div class="portlet-title">
            <div class="caption">
                <i class="icon-equalizer font-red-sunglo"></i>
                <span class="caption-subject font-red-sunglo bold uppercase">Add New Data Employee | <?php echo getSessionData('bu_name'); ?> </span>
                <!-- <span class="caption-helper">some info...</span> -->
            </div>
            <!-- <div class="tools">
                <a href="" class="collapse"> </a>
                <a href="#portlet-config" data-toggle="modal" class="config"> </a>
                <a href="" class="reload"> </a>
                <a href="" class="remove"> </a>
            </div> -->
        </div>
        <div class="portlet-body form">
                <ul class="nav nav-tabs ">
                    <li class="active">
                        <a href="#tab_5_4" data-toggle="tab"> <b>Employee Data</b> </a>
                    </li>
                    <li class="" >
                        <a href="#tab_5_1" id="litab_5_1" data-toggle="tab"> <b>Personal Info</b> </a>
                    </li>
                    <!-- <li>
                        <a href="#tab_5_3" data-toggle="tab"> <b>Salary</b> </a>
                    </li> -->
                </ul>
                <div class="tab-content">
                <div class="tab-pane active" id="tab_5_4">
                    <div class="row">
                        <div class="col-md-12">
                            <table id="grid-table"></table>
                            <div id="grid-pager"></div>
                        </div>
                    </div>
                    <div class="space-4"></div>
                    <div class="row">
                        <div class="col-md-12" id="detail_placeholder" style="display:none;">
                            <table id="grid-table_salary"></table>
                            <div id="grid-pager_salary"></div>
                        </div>
                    </div>
                    <input type="hidden" id="temp_cellValue" name="">
                </div>
                <div class="tab-pane " id="tab_5_1">
                    <div class="space-4"></div>
                    <!-- BEGIN FORM-->
                        <form action="#" class="form-horizontal" id="form_data" method="post" enctype="multipart/form-data" accept-charset="utf-8">
                            <div class="form-body">
                            <h5><b>Employee Data </b></h5>
                                <!--/row-->
                                <div class="row">
                                <div class="col-md-7">
                                    <div class="col-md-12">
                                            <div class="form-group">
                                                <label class="control-label col-md-3">Emp Id / NIK</label>
                                                <div class="col-md-9">
                                                <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
                                                    <input type="hidden" id="bussinessunit_id" name="bussinessunit_id" value="<?php echo getSessionData('bu_id'); ?>">
                                                    <input type="text" id="nik" name="nik" required class="form-control required"> 
                                                    <input type="hidden" id="emp_master_id" name="emp_master_id">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label class="control-label col-md-3">Full Name </label>
                                                <div class="col-md-9">
                                                    <input type="text" id="emp_name" name="emp_name"  required class="form-control required"> </div>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label class="control-label col-md-3">Nick Name</label>
                                                <div class="col-md-9">
                                                    <input type="text" id="nickname" name="nickname" class="form-control"> </div>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                        <div class="form-group">
                                                <label class="control-label col-md-3">Gender</label>
                                                <div class="col-md-9">
                                                    <select id="jenis_kelamin" name="jenis_kelamin" required class="form-control required">
                                                        <option value="L">Male</option>
                                                        <option value="P">Female</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label class="control-label col-md-3">Birth Place</label>
                                                <div class="col-md-9">
                                                    <input type="text" id="tmpt_lhr" name="tmpt_lhr" required class="form-control required"> </div>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label class="control-label col-md-3">Birth Date</label>
                                                <div class="col-md-9">
                                                    <input type="text" id="tgl_lhr" name="tgl_lhr" class="form-control datepickerform required"> </div>
                                            </div>
                                        </div>

                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label class="control-label col-md-3">Id Card Number</label>
                                                <div class="col-md-9">
                                                    <input type="text" id="no_ktp" name="no_ktp" class="form-control"> </div>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label class="control-label col-md-3">Address</label>
                                                <div class="col-md-9">
                                                    <textarea id="address" name="address" required class="form-control required" rows="3"></textarea> </div>
                                            </div>
                                        </div>
                                     
                               <!--  <h5><b>Finance</b></h5>
                                    <div class="col-md-12">
                                            <div class="form-group">
                                                <label class="control-label col-md-3">Salary Rate</label>
                                                <div class="col-md-9">
                                                    <input type="text" class="form-control" id="salary_rate" name="salary_rate" > </div>
                                            </div>
                                        </div>
                                    <div class="col-md-12">
                                            <div class="form-group">
                                                <label class="control-label col-md-3">Salary Valid From</label>
                                                <div class="col-md-9">
                                                    <input type="text" class="form-control datepickerform" id="valid_from" name="valid_from" > </div>
                                            </div>
                                        </div>
                                    <div class="col-md-12">
                                            <div class="form-group">
                                                <label class="control-label col-md-3">Payment Date</label>
                                                <div class="col-md-9">
                                                    <input type="text" class="form-control datepickerform" id="payment_date" name="payment_date" > </div>
                                            </div>
                                        </div> -->
                                    </div>
                                    <div class="col-md-5">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label class="control-label col-md-3">Photo</label>
                                                <div class="fileinput fileinput-new col-md-9" data-provides="fileinput">
                                                    <div class="fileinput-new thumbnail col-md-9" style="width: 220px; height: 280px;">
                                                        <img src=""  id="image_prev" alt="" /><!-- <img src="http://www.placehold.it/220x280/EFEFEF/AAAAAA&amp;text=no+image"  id="image_prev" alt="" /> --> </div>
                                                    <div class="fileinput-preview fileinput-exists thumbnail col-md-9" style="width: 220px; height: 280px;"> </div>
                                                    <div>
                                                        <span class="btn default btn-file col-md-6">
                                                            <span class="fileinput-new " > Select image </span>
                                                            <span class="fileinput-exists"> Change </span>
                                                            <input type="file" id="path_name" name="path_name">
                                                            </span>
                                                        <a href="javascript:;" class="btn danger fileinput-exists col-md-3" data-dismiss="fileinput"> Remove </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label class="control-label col-md-3">Join Date</label>
                                                    <div class="col-md-9">
                                                        <input type="text" id="start_dat" name="start_dat" required class="form-control datepickerform required"> </div>
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label class="control-label col-md-3">Status</label>
                                                    <div class="col-md-9">
                                                        <select id="status" name="status" required class="form-control required">
                                                            <?php echo  getParameterListByCode2('6'); ?>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label class="control-label col-md-3">BPJS TK Code</label>
                                                    <div class="col-md-9">
                                                        <input type="text" name="bpjs_tk_code" id="bpjs_tk_code" class="form-control"> </div>
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label class="control-label col-md-3">BPJS Kes Code</label>
                                                    <div class="col-md-9">
                                                        <input type="text" name="bpjs_kes_code" id="bpjs_kes_code" class="form-control"> </div>
                                                </div>
                                            </div>
                                            </div>
                                    </div>

                                </div>
                            </div>
                            <div class="form-actions">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="row">
                                            <div class="col-md-offset-3 col-md-9">
                                                <button type="submit" id="submit" name="submit" class="btn green">Submit</button>
                                                <button type="button" id="cancel" name="cancel" onclick="resetForm('form_data')" class="btn default">Reset</button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6"> </div>
                                </div>
                            </div>
                        </form>
                        <!-- END FORM-->
                    </div>
                    <div class="tab-pane" id="tab_5_3">
                        
                    </div>
                </div>

        </div>
    </div>
    <input type="hidden" id="temp_rowid">
    <input type="hidden" id="form_mode">
<script>
  function loadDataEmp(rowid){
     
     path = 'application/third_party/uploads/emp_images/';
     $('#submit').text('Update');
     $('#form_mode').val('update');

     $('#emp_master_id').val( $('#grid-table').jqGrid('getCell', rowid, 'emp_master_id') );
     $('#bussinessunit_id').val( $('#grid-table').jqGrid('getCell', rowid, 'bussinessunit_id') );
     $('#emp_name').val( $('#grid-table').jqGrid('getCell', rowid, 'emp_name') );
     $('#nick_name').val( $('#grid-table').jqGrid('getCell', rowid, 'nick_name') );
     $('#address').val( $('#grid-table').jqGrid('getCell', rowid, 'address') );
     $('#nik').val( $('#grid-table').jqGrid('getCell', rowid, 'nik') );
     $('#image_prev').attr("src", '');
     $('#image_prev').attr("src", path+$('#grid-table').jqGrid('getCell', rowid, 'path_name') );
     $('#npwp_code').val( $('#grid-table').jqGrid('getCell', rowid, 'npwp_code') );
     $('#no_ktp').val( $('#grid-table').jqGrid('getCell', rowid, 'no_ktp') );
     $('#tgl_lhr').val( $('#grid-table').jqGrid('getCell', rowid, 'tgl_lhr') );
     $('#tmpt_lhr').val( $('#grid-table').jqGrid('getCell', rowid, 'tmpt_lhr') );
     $('#start_dat').val( $('#grid-table').jqGrid('getCell', rowid, 'start_dat') );
     $('#end_dat').val( $('#grid-table').jqGrid('getCell', rowid, 'end_dat') );
     $('#status').val( $('#grid-table').jqGrid('getCell', rowid, 'status') );
     $('#emp_code').val( $('#grid-table').jqGrid('getCell', rowid, 'emp_code') );
     $('#bpjs_tk_code').val( $('#grid-table').jqGrid('getCell', rowid, 'bpjs_tk_code') );
     $('#bpjs_kes_code').val( $('#grid-table').jqGrid('getCell', rowid, 'bpjs_kes_code') );
     $('#jenis_kelamin selected').val( $('#grid-table').jqGrid('getCell', rowid, 'jenis_kelamin') );
     /*
     $('#created_by').val( $('#grid-table').jqGrid('getCell', rowid, 'created_by') );
     $('#created_date').val( $('#grid-table').jqGrid('getCell', rowid, 'created_date') );
     $('#update_date').val( $('#grid-table').jqGrid('getCell', rowid, 'update_date') );
     $('#update_by').val( $('#grid-table').jqGrid('getCell', rowid, 'update_by') );*/

  }
  function newDataForm(){
    $('#litab_5_1').trigger('click');
    resetForm('form_data');
  }
  function resetForm(form){
    $('#'+form)[0].reset();
    $('#image_prev').attr("src", '');
  }
/*  function test(){
    $.ajax({
        type: "POST",
        url: "<?php echo WS_JQGRID.'master_data.empmaster_controller/getPramData'; ?>",
        data: { a:1 },
        success: function (data) {
           //swal({title: 'Info', text: 'Selesai, Step selanjutnya adalah mengisi data kontrak !', html: true, type: "info"});
            }
     });

    }*/
  $(document).ready(function(){
    
    $("#form_data").on('submit', (function (e) {

          e.preventDefault();
          var data = new FormData(this);

          if($('#form_mode').val() == 'update'){
            url = '<?php echo WS_JQGRID."master_data.empmaster_controller/updateData"; ?>';
          }else{
            url = '<?php echo WS_JQGRID."master_data.empmaster_controller/submitData"; ?>';  
          }
          
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
              }else{
                  swal({title: 'Attention', text: response.message, html: true, type: "warning"});
              }
            }

          });

          return false;
      }));

      $('.datepickerform').datepicker({
        format: 'dd-mm-yyyy',
        autoclose:true
      });
  });

</script>
<script>

    jQuery(function($) {
        var grid_selector = "#grid-table";
        var pager_selector = "#grid-pager";

        jQuery("#grid-table").jqGrid({
            url: '<?php echo WS_JQGRID."master_data.empmaster_controller/crud"; ?>',
            datatype: "json",
            mtype: "POST",
            colModel: [
				{label: 'ID', name: 'emp_master_id', key: true, width: 5, sorttype: 'number', editable: true, hidden: true},
 				{label: 'Bussinessunit Id',name: 'bussinessunit_id' ,width: 100, align: 'right',editable: false,hidden: true,
  					  editoptions:{
   						     size: 30,
  						     maxlength:22
  					 },editrules: {required: false}
                },
                {label: 'Nik',name: 'nik' ,width: 100, align: 'left',editable: true,
  					  editoptions:{
   						     size: 30,
  						     maxlength:30
  					 },editrules: {required: false}
   				 },
 				{label: 'Name',name: 'emp_name' ,width: 200, align: 'left',editable: true,
  					  editoptions:{
   						     size: 30,
  						     maxlength:50
  					 },editrules: {required: false}
   				 },
 				{label: 'Nick Name',name: 'nick_name' ,width: 100, align: 'left',editable: true,hidden: true,
  					  editoptions:{
   						     size: 30,
  						     maxlength:10
  					 },editrules: {required: false}
   				 },
 				{label: 'Address',name: 'address' ,width: 250, align: 'left',editable: true,
  					  edittype:'textarea',
  					  editoptions:{
   						     size: 30,
  						     maxlength:250
  					 },editrules: {required: false}
   				 },
 				{label: 'Path Name',name: 'path_name' ,width: 250, align: 'left',editable: true,hidden: true,
  					  edittype:'textarea',
  					  editoptions:{
   						     size: 30,
  						     maxlength:250
  					 },editrules: {required: false}
   				 },
 				{label: 'Npwp Code',name: 'npwp_code' ,width: 100, align: 'left',editable: true,
  					  editoptions:{
   						     size: 30,
  						     maxlength:30
  					 },editrules: {required: false}
   				 },
 				{label: 'No Ktp',name: 'no_ktp' ,width: 100, align: 'left',editable: true,hidden: true,
  					  editoptions:{
   						     size: 30,
  						     maxlength:30
  					 },editrules: {required: false}
   				 },
 				{label: 'Tgl Lhr',name: 'tgl_lhr' ,width: 100, align: 'left',editable: true,hidden: true,
  					  editoptions:{
   						     size: 30,
  						     maxlength:7
  					 },editrules: {required: false}
   				 },
 				{label: 'Tmpt Lhr',name: 'tmpt_lhr' ,width: 100, align: 'left',editable: true,hidden: true,
  					  editoptions:{
   						     size: 30,
  						     maxlength:30
  					 },editrules: {required: false}
   				 },
 				{label: 'Start Dat',name: 'start_dat' ,width: 100, align: 'left',editable: true,
  					  editoptions:{
   						     size: 30,
  						     maxlength:7
  					 },editrules: {required: false}
   				 },
 				{label: 'End Dat',name: 'end_dat' ,width: 100, align: 'left',editable: true,
  					  editoptions:{
   						     size: 30,
  						     maxlength:7
  					 },editrules: {required: false}
   				 },
 				{label: 'Status',name: 'status' ,width: 100, align: 'right',editable: true,
  					  editoptions:{
   						     size: 30,
  						     maxlength:22
  					 },editrules: {required: false}
   				 },
 				{label: 'Emp Code',name: 'emp_code' ,width: 100, align: 'left',editable: true,hidden: true,
  					  editoptions:{
   						     size: 30,
  						     maxlength:100
  					 },editrules: {required: false}
   				 },
 				{label: 'Bpjs Tk Code',name: 'bpjs_tk_code' ,width: 100, align: 'left',editable: true,hidden: true,
  					  editoptions:{
   						     size: 30,
  						     maxlength:60
  					 },editrules: {required: false}
   				 },
 				{label: 'Bpjs Kes Code',name: 'bpjs_kes_code' ,width: 100, align: 'left',editable: true,hidden: true,
  					  editoptions:{
   						     size: 30,
  						     maxlength:60
  					 },editrules: {required: false}
   				 },
                 {label: 'Action',name: 'bpjs_kes_code' ,width: 100, align: 'left',editable: true,hidden: true,
                      editoptions:{
                             size: 30,
                             maxlength:60
                     },editrules: {required: false}
                 }

            ],
            height: '200px',
            width: '100%',
            autowidth: true,
            viewrecords: true,
            rowNum: 10,
            rowList: [10,20,50],
            rownumbers: true, // show row numbers
            rownumWidth: 35, // the width of the row numbers columns
            altRows: true,
            shrinkToFit: true,
            multiboxonly: true,
            onSelectRow: function (rowid) {
                /*do something when selected*/
                $('#temp_rowid').val(rowid);
                loadDataEmp(rowid);
                var celValue = $('#grid-table').jqGrid('getCell', rowid, 'emp_master_id');
                var celCode = $('#grid-table').jqGrid('getCell', rowid, 'emp_name');

                var grid_detail = jQuery("#grid-table_salary");
                if (rowid != null) {
                    grid_detail.jqGrid('setGridParam', {
                        url: "<?php echo WS_JQGRID."master_data.empsalary_controller/crud"; ?>",
                        postData: {celValue: celValue}
                    });
                    var strCaption = 'Salary  :: ' + celCode;
                    grid_detail.jqGrid('setCaption', strCaption);
                    $("#temp_cellValue").val(celValue);
                    $("#grid-table_salary").trigger("reloadGrid");
                    $("#detail_placeholder").show();
                }
                responsive_jqgrid("#grid-table_salary", "#grid-pager_salary");
            },
            sortorder:'',
            pager: '#grid-pager',
            jsonReader: {
                root: 'rows',
                id: 'id',
                repeatitems: false
            },
            loadComplete: function (response) {
                if(response.success == false) {
                    swal({title: 'Attention', text: response.message, html: true, type: "warning"});
                }

            },
            //memanggil controller jqgrid yang ada di controller crud
            editurl: '<?php echo WS_JQGRID."master_data.empmaster_controller/crud"; ?>',
            caption: "Employee Master"

        });

        jQuery('#grid-table').jqGrid('navGrid', '#grid-pager',
            {   //navbar options
                edit: false,
                editicon: 'fa fa-pencil blue bigger-120',
                add: false,
                addicon: 'fa fa-plus-circle purple bigger-120',
                del: true,
                delicon: 'fa fa-trash-o red bigger-120',
                search: true,
                searchicon: 'fa fa-search orange bigger-120',
                refresh: true,
                afterRefresh: function () {
                    // some code here
                    jQuery("#detailsPlaceholder").hide();
                },

                refreshicon: 'fa fa-refresh green bigger-120',
                view: false,
                viewicon: 'fa fa-search-plus grey bigger-120'
            },
            {
                // options for the Edit Dialog
                closeAfterEdit: true,
                closeOnEscape:true,
                recreateForm: true,
                serializeEditData: serializeJSON,
                width: 'auto',
                errorTextFormat: function (data) {
                    return 'Error: ' + data.responseText
                },
                beforeShowForm: function (e, form) {
                    var form = $(e[0]);
                    style_edit_form(form);

                },
                afterShowForm: function(form) {
                    form.closest('.ui-jqdialog').center();
                },
                afterSubmit:function(response,postdata) {
                    var response = jQuery.parseJSON(response.responseText);
                    if(response.success == false) {
                        return [false,response.message,response.responseText];
                    }
                    return [true,"",response.responseText];
                }
            },
            {
                //new record form
                closeAfterAdd: false,
                clearAfterAdd : true,
                closeOnEscape:true,
                recreateForm: true,
                width: 'auto',
                errorTextFormat: function (data) {
                    return 'Error: ' + data.responseText
                },
                serializeEditData: serializeJSON,
                viewPagerButtons: false,
                beforeShowForm: function (e, form) {
                    var form = $(e[0]);
                    style_edit_form(form);
                },
                afterShowForm: function(form) {
                    form.closest('.ui-jqdialog').center();
                },
                afterSubmit:function(response,postdata) {
                    var response = jQuery.parseJSON(response.responseText);
                    if(response.success == false) {
                        return [false,response.message,response.responseText];
                    }

                    $(".tinfo").html('<div class="ui-state-success">' + response.message + '</div>');
                    var tinfoel = $(".tinfo").show();
                    tinfoel.delay(3000).fadeOut();


                    return [true,"",response.responseText];
                }
            },
            {
                //delete record form
                serializeDelData: serializeJSON,
                recreateForm: true,
                beforeShowForm: function (e) {
                    var form = $(e[0]);
                    style_delete_form(form);

                },
                afterShowForm: function(form) {
                    form.closest('.ui-jqdialog').center();
                },
                onClick: function (e) {
                    //alert(1);
                },
                afterSubmit:function(response,postdata) {
                    var response = jQuery.parseJSON(response.responseText);
                    if(response.success == false) {
                        return [false,response.message,response.responseText];
                    }
                    return [true,"",response.responseText];
                }
            },
            {
                //search form
                closeAfterSearch: false,
                recreateForm: true,
                afterShowSearch: function (e) {
                    var form = $(e[0]);
                    style_search_form(form);
                    form.closest('.ui-jqdialog').center();
                },
                afterRedraw: function () {
                    style_search_filters($(this));
                }
            },
            {
                //view record form
                recreateForm: true,
                beforeShowForm: function (e) {
                    var form = $(e[0]);
                }
            }

        )
        .navButtonAdd('#grid-pager',{
           caption:"", 
           buttonicon:'fa fa-plus-circle purple bigger-120', 
           onClickButton: function(){ 
             newDataForm();
           }, 
           position:"first"
        });
        
    });

    function responsive_jqgrid(grid_selector, pager_selector) {

        var parent_column = $(grid_selector).closest('[class*="col-"]');
        $(grid_selector).jqGrid( 'setGridWidth', $(".page-content").width() );
        $(pager_selector).jqGrid( 'setGridWidth', parent_column.width() );

    }

</script>
<script>

    jQuery(function($) {
        var grid_selector = "#grid-table_salary";
        var pager_selector = "#grid-pager_salary";

        jQuery("#grid-table_salary").jqGrid({
            url: '<?php echo WS_JQGRID."master_data.empsalary_controller/crud"; ?>',
            datatype: "json",
            mtype: "POST",
            colModel: [
                {label: 'ID', name: 'empsalary_id', key: true, width: 5, sorttype: 'number', editable: true, hidden: true}, 
                {label: 'Emp Master Id',name: 'emp_master_id' ,width: 100, align: 'right',editable: false,hidden:true,
                      editoptions:{
                             size: 30,
                             maxlength:22
                     },editrules: {required: false}
                 }, 
                 {label: 'Nik',name: 'nik' ,width: 100, align: 'left',editable: false,hidden:true,
                      editoptions:{
                             size: 30,
                             maxlength:22
                     },editrules: {required: false}
                 }, 
                 {label: 'Emp Name',name: 'emp_name' ,width: 100, align: 'left',editable: false,hidden:true,
                      editoptions:{
                             size: 30,
                             maxlength:22
                     },editrules: {required: false}
                 }, 
                 {label: 'Salary',name: 'salary' ,width: 100, align: 'right',editable: true,hidden:true,
                      editoptions:{
                             size: 30,
                             maxlength:22
                     },editrules: {edithidden: true, required: true}
                 }, 
                {label: 'Salary',name: 'salary' ,width: 100, align: 'right',editable: false,
                      editoptions:{
                             size: 30,
                             maxlength:22
                     },editrules: {required: true},
                     formatter:'currency', formatoptions:{decimalSeparator:",", thousandsSeparator: ".", decimalPlaces: 0, prefix: " "},
                 }, 
                 {label: 'Valid From',name: 'valid_from' ,width: 100, align: 'left',editable: true,
                    editoptions: {
                            dataInit: function (element) {
                                $(element).prop('readonly',true);
                                $(element).datepicker({
                                    autoclose: true,
                                    format: 'yyyy-mm-dd',
                                    orientation: 'up',
                                    todayHighlight: true
                                });
                            },
                            size: 25
                        },editrules: {required: true}
                 }, 
                 {label: 'Valid Until',name: 'valid_until' ,width: 100, align: 'left',editable: true,
                    editoptions: {
                            dataInit: function (element) {
                                $(element).prop('readonly',true);
                                $(element).datepicker({
                                    autoclose: true,
                                    format: 'yyyy-mm-dd',
                                    orientation: 'up',
                                    todayHighlight: true
                                });
                            },
                            size: 25
                        },editrules: {required: false}
                 }, 
                 {
                    label: 'Payment Type',
                    name: 'p_reference_list_id',
                    width: 150,
                    align: "left",
                    editable: true,
                    edittype: 'select',
                    hidden: true,
                    editrules: {edithidden: true, required: true},
                    editoptions: {dataUrl: '<?php echo WS_JQGRID.'allowance.allowancetariff_controller/getListParam'; ?>',
                        postData: function (rowid) {
                            paramid = 5;
                            return { paramid: paramid };
                        },
                        dataInit: function (elem) {
                            $(elem).width(240);  // set the width which you need
                        }
                    }
                },
                {label: 'Payment Type',name: 'reference_name' ,width: 100, align: 'left',editable: false,hidden:false,
                      editoptions:{
                             size: 30,
                             maxlength:22
                     },editrules: {required: false}
                 },
                {label: 'P Reference List Id',name: 'p_reference_list_id' ,width: 100, align: 'right',editable: false,hidden:true,
                      editoptions:{
                             size: 30,
                             maxlength:22
                     },editrules: {required: false}
                 }
              
            ],
            height: '100%',
            autowidth: true,
            viewrecords: true,
            rowNum: 10,
            rowList: [10,20,50],
            rownumbers: true, // show row numbers
            rownumWidth: 35, // the width of the row numbers columns
            altRows: true,
            shrinkToFit: true,
            multiboxonly: true,
            onSelectRow: function (rowid) {
                /*do something when selected*/

            },
            sortorder:'',
            pager: '#grid-pager_salary',
            jsonReader: {
                root: 'rows',
                id: 'id',
                repeatitems: false
            },
            loadComplete: function (response) {
                if(response.success == false) {
                    swal({title: 'Attention', text: response.message, html: true, type: "warning"});
                }

            },
            //memanggil controller jqgrid yang ada di controller crud
            editurl: '<?php echo WS_JQGRID."master_data.empsalary_controller/crud"; ?>',
            caption: "Empsalary"

        });

        jQuery('#grid-table_salary').jqGrid('navGrid', '#grid-pager_salary',
            {   //navbar options
                edit: true,
                editicon: 'fa fa-pencil blue bigger-120',
                add: true,
                addicon: 'fa fa-plus-circle purple bigger-120',
                del: true,
                delicon: 'fa fa-trash-o red bigger-120',
                search: true,
                searchicon: 'fa fa-search orange bigger-120',
                refresh: true,
                afterRefresh: function () {
                    // some code here
                    jQuery("#detailsPlaceholder").hide();
                },

                refreshicon: 'fa fa-refresh green bigger-120',
                view: false,
                viewicon: 'fa fa-search-plus grey bigger-120'
            },

            {
                // options for the Edit Dialog
                closeAfterEdit: true,
                closeOnEscape:true,
                recreateForm: true,
                serializeEditData: serializeJSON,
                width: 'auto',
                errorTextFormat: function (data) {
                    return 'Error: ' + data.responseText
                },
                beforeShowForm: function (e, form) {
                    var form = $(e[0]);
                    style_edit_form(form);

                },
                afterShowForm: function(form) {
                    form.closest('.ui-jqdialog').center();
                },
                afterSubmit:function(response,postdata) {
                    var response = jQuery.parseJSON(response.responseText);
                    if(response.success == false) {
                        return [false,response.message,response.responseText];
                    }
                    return [true,"",response.responseText];
                }
            },
            {
                //new record form
                closeAfterAdd: false,
                clearAfterAdd : true,
                closeOnEscape:true,
                recreateForm: true,
                width: 'auto',
                errorTextFormat: function (data) {
                    return 'Error: ' + data.responseText
                },
                serializeEditData: serializeJSON,
                viewPagerButtons: false,
                beforeShowForm: function (e, form) {
                    var form = $(e[0]);
                    style_edit_form(form);
                },
                afterShowForm: function(form) {
                    form.closest('.ui-jqdialog').center();
                },
                afterSubmit:function(response,postdata) {
                    var response = jQuery.parseJSON(response.responseText);
                    if(response.success == false) {
                        return [false,response.message,response.responseText];
                    }

                    $(".tinfo").html('<div class="ui-state-success">' + response.message + '</div>');
                    var tinfoel = $(".tinfo").show();
                    tinfoel.delay(3000).fadeOut();


                    return [true,"",response.responseText];
                }
            },
            {
                //delete record form
                serializeDelData: serializeJSON,
                recreateForm: true,
                beforeShowForm: function (e) {
                    var form = $(e[0]);
                    style_delete_form(form);

                },
                afterShowForm: function(form) {
                    form.closest('.ui-jqdialog').center();
                },
                onClick: function (e) {
                    //alert(1);
                },
                afterSubmit:function(response,postdata) {
                    var response = jQuery.parseJSON(response.responseText);
                    if(response.success == false) {
                        return [false,response.message,response.responseText];
                    }
                    return [true,"",response.responseText];
                }
            },
            {
                //search form
                closeAfterSearch: false,
                recreateForm: true,
                afterShowSearch: function (e) {
                    var form = $(e[0]);
                    style_search_form(form);
                    form.closest('.ui-jqdialog').center();
                },
                afterRedraw: function () {
                    style_search_filters($(this));
                }
            },
            {
                //view record form
                recreateForm: true,
                beforeShowForm: function (e) {
                    var form = $(e[0]);
                }
            }
        );

    });

    function responsive_jqgrid(grid_selector, pager_selector) {

        var parent_column = $(grid_selector).closest('[class*="col-"]');
        $(grid_selector).jqGrid( 'setGridWidth', $(".page-content").width() );
        $(pager_selector).jqGrid( 'setGridWidth', parent_column.width() );

    }

</script>
<script src="<?php echo base_url(); ?>assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.js" type="text/javascript"></script>

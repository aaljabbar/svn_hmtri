<link href="<?php echo base_url(); ?>assets/js/bootstrap-datetimepicker.min.css" rel="stylesheet" type="text/css"/>
<script src="<?php echo base_url(); ?>assets/js/moment.min.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/js/bootstrap-datetimepicker.min.js" type="text/javascript"></script>
<!-- breadcrumb -->
<div class="page-bar">
    <ul class="page-breadcrumb">
        <li>
            <a href="<?php base_url(); ?>">Home</a>
            <i class="fa fa-circle"></i>
        </li>
        <li>
            <span>Adjustment</span>
        </li>
    </ul>
</div>
<!-- end breadcrumb -->
<div class="space-4"></div>
<div class="row">
    <ul class="nav nav-tabs">
        <li class="" id="tab-1">
            <a data-toggle="tab"> Employee </a>
        </li>
        <li class="active" id="tab-2">
            <a data-toggle="tab"> Adjustment </a>
        </li>
    </ul>
    <div class="row">
        <div class="col-md-12">
            <div class="portlet light bordered">
                <div class="form-body">

                    <div class="row">
                        <label class="control-label col-md-1">Date</label>
                        <div class="col-md-4">
                            <div class="input-group ">
                                <input type="text" class="form-control datepicker1 " name="start_adj_date" id="start_adj_date"  >
                                <span class="input-group-addon"> s/d </span>
                                <input type="text" class="form-control datepicker1 " name="end_adj_date" id="end_adj_date">
                            </div>
                        </div>
                        <button class="btn btn-primary" type="button" onclick="findAjustment()">Find</button>
                    </div>

                    <div class="space-2"></div>

                    <div class="row">
                        <div class="col-md-12">
                            <input type="hidden" name="emp_master_id" id="emp_master_id" value="<?php echo $_POST['emp_master_id'] ?>">
                            <table id="grid-table"></table>
                            <div id="grid-pager"></div>
                        </div>
                    </div>

                    <div class="space-2"></div>

                    <div class="panel panel-primary">
                        <div class="panel-heading"  id="captionDetail">ADD Adjustment</div>
                        <div class="panel-body">
                            <div class="form-body">
                                <div class="row">
                                    <label class="control-label col-md-3">Adjustment Type</label>
                                    <div class="col-md-3">
                                       <div id="comboDoc"></div>
                                    </div>
                                    <input type="hidden" name="adjusment_id" id="adjusment_id" >
                                </div>

                                <div class="space-2"></div>
                                <div class="row">
                                    <label class="control-label col-md-3">Adjustment Date</label>
                                    <div class="col-md-3">
                                        <input type="text" class="form-control datepicker1 required" required name="adj_date" id="adj_date"  >
                                    </div>
                                </div>

                                <div class="space-2"></div>
                                <div class="row">
                                    <label class="control-label col-md-3">Adjustment Money</label>
                                    <div class="col-md-3">
                                        <input type="text" class="form-control required priceformat" required name="adj_mny" id="adj_mny"  >
                                    </div>
                                </div>

                                <div class="space-2"></div>
                                <div class="form-actions">
                                    <div class="row">
                                        <div class="col-md-offset-3 col-md-9">
                                            <a href="javascript:;" class="btn btn-outline green button-next" id="btn-tambah">ADD
                                            </a>
                                            <a href="javascript:;" class="btn  btn-primary " id="btn-update"> SAVE
                                            </a>
                                            <a href="javascript:;" class="btn  btn-primary " id="btn-insert"> SAVE
                                            </a>
                                            <a href="javascript:;" class="btn  btn-danger " id="btn-delete"> DELETE
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>



<script type="text/javascript">
    $('.datepicker1').datetimepicker({
        format: 'YYYY-MM-DD',
        //defaultDate: new Date()
    });

    $(".priceformat").number( true, 0 , '.',','); /* price number format */
    $(".priceformat").css("text-align", "right");

    $('#btn-insert').css('display','');
    $('#btn-delete').css('display','none');
    $('#btn-update').css('display','none');
    $('#btn-tambah').css('display','none');

    $.ajax({
        url: "<?php echo WS_JQGRID."adjustment.adjustment_controller/readDataCombo"; ?>" ,
        type: "POST",
        dataType: "json",
        data: {},
        success: function (data) {
            console.log(data.items);
            $("#comboDoc").html(data.items);
        },
        error: function (xhr, status, error) {
            swal({title: "Error!", text: xhr.responseText, html: true, type: "error"});
        }
    });

    $('#btn-tambah').on('click',function(){
        $('#adjusment_id').val(null);
        $('#adjtype_id').val(null);
        $('#adj_date').val(null);
        $('#adj_mny').val(null);
        jQuery('#grid-table').jqGrid('setSelection','');
        
        $('#btn-insert').css('display','');
        $('#btn-delete').css('display','none');
        $('#btn-update').css('display','none');
        $('#btn-tambah').css('display','none');
        $('#captionDetail').text('ADD Adjustment');


    });


    function setDaftar_adjustment(rowid){
        var adjusment_id = $('#grid-table').jqGrid('getCell', rowid, 'adjusment_id');
        var adjtype_id = $('#grid-table').jqGrid('getCell', rowid, 'adjtype_id');
        var adj_date = $('#grid-table').jqGrid('getCell', rowid, 'adj_date');
        var adj_mny = $('#grid-table').jqGrid('getCell', rowid, 'adj_mny');
        
        $('#adjusment_id').val(adjusment_id);
        $('#adjtype_id').val(adjtype_id);
        $('#adj_date').val(adj_date);
        $('#adj_mny').val(adj_mny);
    }

    function findAjustment(){
        var start_adj_date = $('#start_adj_date').val();
        var end_adj_date = $('#end_adj_date').val();
        var emp_master_id = $("#emp_master_id").val();


        jQuery(function($) {
            var grid_selector = "#grid-table";

            jQuery("#grid-table").jqGrid('setGridParam',{
                url: '<?php echo WS_JQGRID."adjustment.adjustment_controller/crud"; ?>',
                postData: {emp_master_id:emp_master_id,start_adj_date:start_adj_date,end_adj_date:end_adj_date,oper:'read'}
            });
            $("#grid-table").trigger("reloadGrid");
        });
    }
</script>

<script type="text/javascript">
    function crud(oper){
        var adjusment_id = $('#adjusment_id').val();
        var adjtype_id = $('#adjtype_id').val();
        var adj_date = $('#adj_date').val();
        var adj_mny = $('#adj_mny').val();
        var emp_master_id = $('#emp_master_id').val();
        
        var item = {adjusment_id:adjusment_id,
                    adjtype_id:adjtype_id,
                    adj_date:adj_date,
                    adj_mny:adj_mny,
                    emp_master_id:emp_master_id
                    };

        var itemJSON = JSON.stringify(item);

        if (oper=='del')
            itemJSON = adjusment_id;

        $.ajax({
            url: "<?php echo WS_JQGRID."adjustment.adjustment_controller/crud"; ?>" ,
            type: "POST",
            dataType: "json",
            data: {items:itemJSON,oper:oper},
            success: function (data) {
                if (data.success){
                    swal({title: "INFORMATION!", text: data.message, html: true, type: "info"});
                    $("#grid-table").trigger("reloadGrid");
                }else{
                    swal({title: "Error!", text: data.message, html: true, type: "error"});
                }
            },
            error: function (xhr, status, error) {
                swal({title: "Error!", text: xhr.responseText, html: true, type: "error"});
            }
        });
    }

    $('#btn-insert').on('click',function(){
        crud('add');
    }); 

    $('#btn-update').on('click',function(){
        crud('edit');
    });

    $('#btn-delete').on('click',function(){
        swal(
            {
              title: "Do you want to delete this Data?",
              text: "",
              type: "warning",
              showCancelButton: true,
              confirmButtonClass: "btn-danger",
              confirmButtonText: "Yes!",
              closeOnConfirm: false
            },
            function(){
                crud('del');
            }
        );
    }); 
</script>

<script>

    $(function($) {
      $("#tab-1").on( "click", function() {
          loadContentWithParams("adjustment.employee_adjustment", {});
      });
    });

    jQuery(function($) {
        var grid_selector = "#grid-table";
        var pager_selector = "#grid-pager";
        var emp_master_id = $("#emp_master_id").val();

        jQuery("#grid-table").jqGrid({
            url: '<?php echo WS_JQGRID."adjustment.adjustment_controller/crud"; ?>',
            datatype: "json",
            mtype: "POST",
            postData:{emp_master_id:emp_master_id},
            colModel: [
				{label: 'ID', name: 'adjusment_id', key: true, width: 5, sorttype: 'number', editable: true, hidden: true}, 
 				{label: 'Adjtype Id',name: 'adjtype_id' ,width: 100, align: 'right',editable: true, hidden: true,
  					  editoptions:{
   						     size: 30,
  						     maxlength:22
  					 },editrules: {required: false}
   				 }, 
 				{label: 'Emp Master Id',name: 'emp_master_id' ,width: 100, align: 'right',editable: true, hidden: true,
  					  editoptions:{
   						     size: 30,
  						     maxlength:22
  					 },editrules: {required: false}
   				 }, 
 				{label: 'Date',name: 'adj_date2' ,width: 100, align: 'left',editable: true,
  					  editoptions:{
   						     size: 30,
  						     maxlength:7
  					 },editrules: {required: false}
   				 },
                {label: 'Date',name: 'adj_date' ,width: 100, align: 'right',editable: true, hidden: true,
                      editoptions:{
                             size: 30,
                             maxlength:22
                     },editrules: {required: false}
                 },
                {label: 'Type',name: 'desc_adjtype' ,width: 100, align: 'left',editable: true,
                      editoptions:{
                             size: 30,
                             maxlength:7
                     },editrules: {required: false}
                 },  
 				{label: 'Money',name: 'adj_mny' ,width: 100, align: "right", formatter:'currency', formatoptions: {prefix:"", thousandsSeparator:','}
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
                setDaftar_adjustment(rowid);

                $('#btn-insert').css('display','none');
                $('#btn-delete').css('display','');
                $('#btn-update').css('display','');
                $('#btn-tambah').css('display','');

                $('#captionDetail').text('Information Detail');

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

                setTimeout(function(){
                      $("#grid-table").setSelection($("#grid-table").getDataIDs()[0],true);
                },500);

            },
            //memanggil controller jqgrid yang ada di controller crud
            editurl: '<?php echo WS_JQGRID."adjustment.adjustment_controller/crud"; ?>',
            caption: "Adjustment :: " +'<?php echo $_POST['emp_name'] ?>'

        });

        jQuery('#grid-table').jqGrid('navGrid', '#grid-pager',
            {   //navbar options
                edit: false,
                editicon: 'fa fa-pencil blue bigger-120',
                add: false,
                addicon: 'fa fa-plus-circle purple bigger-120',
                del: false,
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
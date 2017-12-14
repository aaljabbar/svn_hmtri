<!-- breadcrumb -->
<div class="page-bar">
    <ul class="page-breadcrumb">
        <li>
            <a href="<?php base_url(); ?>">Home</a>
            <i class="fa fa-circle"></i>
        </li>
        <li>
            <span>deduction</span>
        </li>
    </ul>
</div>
<!-- end breadcrumb -->
<div class="space-4"></div>
<div class="row">
    <ul class="nav nav-tabs">
        <li class="active" id="tab-1">
            <a data-toggle="tab"> Employee </a>
        </li>
        <li class="" id="tab-2">
            <a data-toggle="tab"> Deduction </a>
        </li>
    </ul>
    <div class="col-md-12">
        <table id="grid-table"></table>
        <div id="grid-pager"></div>
    </div>
</div>

<script>

  $(function($) {
      $("#tab-2").on( "click", function() {
          var grid = $('#grid-table');
          selRowId = grid.jqGrid ('getGridParam', 'selrow');

          var emp_master_id = grid.jqGrid ('getCell', selRowId, 'emp_master_id');
          var emp_name = grid.jqGrid ('getCell', selRowId, 'emp_name');

          if(selRowId == null) {
              swal("Informasi", "Silahkan Pilih Salah Satu Baris Data", "info");
              return false;
          }

          loadContentWithParams("deduction.deduction", {
              emp_master_id: emp_master_id,
              emp_name:emp_name
          });
      });
  });


    jQuery(function($) {
        var grid_selector = "#grid-table";
        var pager_selector = "#grid-pager";

        jQuery("#grid-table").jqGrid({
            url: '<?php echo WS_JQGRID."deduction.employee_deduction_controller/crud"; ?>',
            datatype: "json",
            mtype: "POST",
            colModel: [
				{label: 'ID', name: 'emp_master_id', key: true, width: 5, sorttype: 'number', editable: true, hidden: true}, 
 				{label: 'Bussinessunit Id',name: 'bussinessunit_id' ,width: 100, align: 'right',editable: true, hidden: true,
  					  editoptions:{
   						     size: 30,
  						     maxlength:22
  					 },editrules: {required: false}
   				 }, 
        {label: 'Perusahaan',name: 'bu_name' ,width: 100, align: 'left',editable: true,
              editoptions:{
                   size: 30,
                   maxlength:50
             },editrules: {required: false}
           }, 
 				{label: 'Emp Name',name: 'emp_name' ,width: 100, align: 'left',editable: true,
  					  editoptions:{
   						     size: 30,
  						     maxlength:50
  					 },editrules: {required: false}
   				 }, 
 				{label: 'Nick Name',name: 'nick_name' ,width: 100, align: 'left',editable: true,
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
 				{label: 'Nik',name: 'nik' ,width: 100, align: 'left',editable: true,
  					  editoptions:{
   						     size: 30,
  						     maxlength:30
  					 },editrules: {required: false}
   				 }, 
 				{label: 'Npwp Code',name: 'npwp_code' ,width: 100, align: 'left',editable: true,
  					  editoptions:{
   						     size: 30,
  						     maxlength:30
  					 },editrules: {required: false}
   				 }, 
 				{label: 'No Ktp',name: 'no_ktp' ,width: 100, align: 'left',editable: true,
  					  editoptions:{
   						     size: 30,
  						     maxlength:30
  					 },editrules: {required: false}
   				 }, 
 				{label: 'Tempat Tanggal Lahir',name: 'tanggal_lahir' ,width: 100, align: 'left',editable: true,
  					  editoptions:{
   						     size: 30,
  						     maxlength:7
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
 				{label: 'Bpjs Tk Code',name: 'bpjs_tk_code' ,width: 100, align: 'left',editable: true,
  					  editoptions:{
   						     size: 30,
  						     maxlength:60
  					 },editrules: {required: false}
   				 }, 
 				{label: 'Bpjs Kes Code',name: 'bpjs_kes_code' ,width: 100, align: 'left',editable: true,
  					  editoptions:{
   						     size: 30,
  						     maxlength:60
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
            editurl: '<?php echo WS_JQGRID."deduction.employee_deduction_controller/crud"; ?>',
            caption: "Employee"

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
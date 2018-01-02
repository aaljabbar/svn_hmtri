
<link href='<?php echo base_url(); ?>assets/fullcalendar/fullcalendar.min.css' rel='stylesheet' />
<!-- <link href='<?php echo base_url(); ?>assets/fullcalendar/fullcalendar.print.min.css' rel='stylesheet' media='print' /> -->

<!-- breadcrumb -->
<div class="page-bar">
    <ul class="page-breadcrumb">
        <li>
            <a href="<?php base_url(); ?>">Home</a>
            <i class="fa fa-circle"></i>
        </li>
        <li>
            <span>allowancebatchs</span>
        </li>
    </ul>
</div>
<!-- end breadcrumb -->
<div class="space-4"></div>
<button type="button" class="btn btn-primary" id="addForm" >
    <i class="fa fa-plus"></i> Add New Data
</button>
<button type="button" class="btn btn-warning" id="editForm" style="display:none;">
    <i class="fa fa-edit"></i> Edit Data
</button>
<div class="space-4"></div>
<div class="row">
    <div class="col-md-12" >
        <table id="grid-table_emp"></table>
        <div id="grid-pager_emp"></div>
        <input type="hidden" id="temp_cellValue" name="temp_cellValue">
    </div>
</div>

<div class="space-4"></div>
<div class="row">
    <div class="col-md-6" id="detail_placeholder2" style="display:none;">
        <table id="grid-table"></table>
        <div id="grid-pager"></div>
    </div>
    <div class="col-md-6">
            <div class="col-md-12" id="detail_placeholder" style="display:none;">
                <table id="grid-table-detail"></table>
                <div id="grid-pager-detail"></div>
        </div>
    </div>
</div>



<?php $this->load->view('allowance/lov_new_data_allowance'); ?>

<input type="hidden" id="temp_emp_master_id" name="temp_emp_master_id">
<input type="hidden" id="emp_name" name="emp_name">
<input type="hidden" id="dateContainer" name="date">
<input type="hidden" id="temp_corporate_id" >
<input type="hidden" id="temp_allow_batch_id" >
<script type="text/javascript">
    function loadForm(mode){
        if(mode == 'add'){
            param = {emp_master_id:$('#temp_emp_master_id').val(),emp_name:$('#emp_name').val()};
        }else{
            param = {emp_master_id:$('#temp_emp_master_id').val(),allow_batch_id:$('#temp_allow_batch_id').val()};
        }
            id = 'allowance.allowancebatch_addform';
            loadContentWithParams(id,param);
    }

    $(document).ready(function(){
        $('#addForm').click(function(){
            //loadForm('add');
            var emp_master_id = $('#temp_emp_master_id').val();
            if( emp_master_id !== ''){
                //modal_allowance_show(emp_master_id);
                loadForm('add');
            }else{
                swal({title: 'Warning', text: 'Please Choose Employee ! ', html: true, type: "warning"});
            }
        });
        $('#editForm').click(function(){
            loadForm('edit');
        });
    });

</script>
<?php $this->load->view('lov/lov_upload_file_allowance'); ?>
<?php $this->load->view('lov/lov_show_picture'); ?>
<script>

    jQuery(function($) {
        var grid_selector = "#grid-table_emp";
        var pager_selector = "#grid-pager_emp";

        jQuery("#grid-table_emp").jqGrid({
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
                 {label: 'Next Pay dtm',name: 'next_pay_dtm' ,width: 100, align: 'left',editable: true,
                      editoptions:{
                             size: 30,
                             maxlength:7
                     },editrules: {required: false}
                 },
                {label: 'Status',name: 'status' ,width: 100, align: 'left',editable: true,
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
                 /*{label: 'Action',name: 'bpjs_kes_code' ,width: 100, align: 'left',editable: true,hidden: true,
                      editoptions:{
                             size: 30,
                             maxlength:60
                     },editrules: {required: false}
                 }*/

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
                
                var celValue = $('#grid-table_emp').jqGrid('getCell', rowid, 'emp_master_id');
                var celCode = $('#grid-table_emp').jqGrid('getCell', rowid, 'emp_name');
                
                var grid_detail = jQuery("#grid-table");
                if (rowid != null) {
                    grid_detail.jqGrid('setGridParam', {
                        url: "<?php echo WS_JQGRID."allowance.allowancebatchs_controller/crud"; ?>",
                        postData: {celValue: celValue}
                    });
                    var strCaption = 'Allowance  :: ' + celCode;
                    grid_detail.jqGrid('setCaption', strCaption);
                    $("#temp_cellValue").val(celValue);
                    $("#temp_emp_master_id").val(celValue);
                    $("#emp_name").val(celCode);
                    $("#grid-table").trigger("reloadGrid");
                    $("#detail_placeholder2").show();
                }
                responsive_jqgrid("#grid-table", "#grid-pager");
                
            },
            sortorder:'',
            pager: '#grid-pager_emp',
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
            editurl: '<?php echo WS_JQGRID."allowance.allowancebatchs_controller/crud"; ?>',
            caption: "Employee Master"

        });

        jQuery('#grid-table_emp').jqGrid('navGrid', '#grid-pager_emp',
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

    function paymentLov(allow_batch_id){
        modal_lov_upload_show(allow_batch_id);
    }

    function showPicture(path_name){
        modal_lov_show_picture_show(path_name);
    }

</script>
<script>

    jQuery(function($) {
        var grid_selector = "#grid-table";
        var pager_selector = "#grid-pager";

        jQuery("#grid-table").jqGrid({
            url: '<?php echo WS_JQGRID."allowance.allowancebatchs_controller/crud"; ?>',
            datatype: "json",
            mtype: "POST",
            colModel: [
                {label: 'ID', name: 'allow_batch_id', key: true, width: 5, sorttype: 'number', editable: true, hidden: true}, 
        				{label: 'Batch Number', name: 'allow_batch_id',  width: 50, sorttype: 'number', editable: false, hidden: false},
                {name: 'Options',width: 100, align: "center",
                  formatter:function(cellvalue, options, rowObject) {
                      var allow_batch_id = rowObject['allow_batch_id'];
                      var status = rowObject['status'];
                      var path_name = rowObject['path_name'];


                      if (path_name == null && (status == null || status == 'TRF' )){
                          //return '<a class="btn btn-danger btn-xs" href="#" onclick="payment('+payrollsummary_id+');">Transfer</a>';

                          return '<a class="btn btn-danger btn-xs radius-4" href="#" onclick="paymentLov('+allow_batch_id+');">Transfer</a>';
                      }else{
                          return '<a class="btn btn-sm green-jungle radius-4 btn-xs" href="#" onclick="showPicture(\''+path_name+'\');">View</a>';
                      }
                  }
                },
         				{label: 'Emp Master Id',name: 'emp_master_id' ,width: 100, align: 'left',editable: true,hidden:true,
          					  editoptions:{
           						     size: 30,
          						     maxlength:22
          					 },editrules: {required: false}
           				 }, 
                 {label: 'Name',name: 'emp_name' ,width: 100, align: 'left', hidden: true,editable: true,
                      editoptions:{
                             size: 30,
                             maxlength:22
                     },editrules: {required: false}
                 }, 
         				{label: 'Period',name: 'period' ,width: 100, align: 'left',editable: true,
          					  editoptions:{
           						     size: 30,
          						     maxlength:10
          					 },editrules: {required: false}
           				 }, 
         				{label: 'Status',name: 'status' ,width: 100, align: 'left',editable: true,
          					  editoptions:{
           						     size: 30,
          						     maxlength:10
          					 },editrules: {required: false}
           				 }
              
            ],
            height: '200',
            width: '100%',
            autowidth: false,
            viewrecords: true,
            rowNum: 10,
            rowList: [10,20,50],
            rownumbers: true, // show row numbers
            rownumWidth: 35, // the width of the row numbers columns
            altRows: true,
            shrinkToFit: true,
            multiboxonly: true,
            subGrid: true, // set the subGrid property to true to show expand buttons for each row
                 subGridRowExpanded: showChildGrid, // javascript function that will take care of showing the child grid
                 subGridOptions : {
                     // load the subgrid data only once
                     // and the just show/hide
                     reloadOnExpand :true,
                     // select the row when the expand column is clicked
                     selectOnExpand : true,
                     plusicon : "ace-icon fa fa-plus center bigger-110 blue",
                     minusicon  : "ace-icon fa fa-minus center bigger-110 blue"
                    // openicon : "ace-icon fa fa-chevron-right center orange"
                 },
            onSelectRow: function (rowid) {
                /*do something when selected*/
                var celValue = $('#grid-table').jqGrid('getCell', rowid, 'allow_batch_id');
                var celCode = $('#grid-table').jqGrid('getCell', rowid, 'period');
                var emp_master_id = $('#grid-table').jqGrid('getCell', rowid, 'emp_master_id');
                $("#temp_emp_master_id").val(emp_master_id);
                var grid_detail = jQuery("#grid-table-detail");
                if (rowid != null) {
                    grid_detail.jqGrid('setGridParam', {
                        url: "<?php echo WS_JQGRID."allowance.allowancedetail_controller/crud"; ?>",
                        postData: {celValue: celValue}
                    });
                    var strCaption = 'Allowance Detail Periode  :: ' + celCode;
                    grid_detail.jqGrid('setCaption', strCaption);
                    $("#temp_emp_master_id").val(emp_master_id);
                    $("#temp_corporate_id").val(celValue);
                    $("#grid-table-detail").trigger("reloadGrid");
                    $("#detail_placeholder").show();
                }
                responsive_jqgrid("#grid-table-detail", "#grid-pager-detail");
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
                $("#grid-table-detail").trigger("reloadGrid");
                $("#detail_placeholder").hide();

            },
            //memanggil controller jqgrid yang ada di controller crud
            editurl: '<?php echo WS_JQGRID."allowance.allowancebatchs_controller/crud"; ?>',
            caption: "Allowancebatchs"

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
                width:400,
                beforeShowForm: function (e) {
                    var form = $(e[0]);
                    style_delete_form(form);

                    $("td.delmsg", form).html("Are you sure to Delete This Data ? ");

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
    function showChildGrid(parentRowID, parentRowKey) {
        var childGridID = parentRowID + "_table";
        var childGridPagerID = parentRowID + "_pager";

        // send the parent row primary key to the server so that we know which grid to show
        var childGridURL = "<?php echo WS_JQGRID.'allowance.allowancebatchs_controller/readSub'; ?>";

        // add a table and pager HTML elements to the parent grid row - we will render the child grid here
        $('#' + parentRowID).append('<table id=' + childGridID + '></table><div id=' + childGridPagerID + ' class=scroll></div>');

        $("#" + childGridID).jqGrid({
            url: childGridURL,
            mtype: "POST",
            datatype: "json",
            page: 1,
            rownumbers: true, // show row numbers
            rownumWidth: 35,
            shrinkToFit: true,
//            scrollbar : false,
            postData:{celValue:encodeURIComponent(parentRowKey)},
            colModel: [
                { label: 'ID', name: 'allow_batch_id', key: true, width:10, sorttype:'number', editable: false,hidden:true },
                { label: 'Description', name: 'desc_allowance', width:250, align:"left", editable:false},
                { label: 'Estimated Amount', name: 'amount', width:150, align:"right", editable:false, formatter:'currency', formatoptions:{decimalSeparator:",", thousandsSeparator: ".", decimalPlaces: 0, prefix: " "}}
            ],
//            loadonce: true,
            width: "100%",
            height: '100%',
            jsonReader: {
                root: 'rows',
                id: 'id',
                repeatitems: false
            }
//            pager: "#" + childGridPagerID
        });

    }
    function responsive_jqgrid(grid_selector, pager_selector) {

        var parent_column = $(grid_selector).closest('[class*="col-"]');
        $(grid_selector).jqGrid( 'setGridWidth', $(".page-content").width() );
        $(pager_selector).jqGrid( 'setGridWidth', parent_column.width() );

    }

</script>
<script>

    jQuery(function($) {
        var grid_selector = "#grid-table-detail";
        var pager_selector = "#grid-pager-detail";

        jQuery("#grid-table-detail").jqGrid({
            url: '<?php echo WS_JQGRID."allowance.allowancedetail_controller/crud"; ?>',
            datatype: "json",
            mtype: "POST",
            colModel: [
                {label: 'ID', name: 'allowancedet_id', key: true, width: 5, sorttype: 'number', editable: true, hidden: true}, 
                {label: 'Allow Batch Id',name: 'allow_batch_id' ,width: 100, align: 'right',editable: true,hidden:true,
                      editoptions:{
                             size: 30,
                             maxlength:22
                     },editrules: {required: false}
                 }, 
                {
                    label: 'Allowance Type',
                    name: 'allowance_type_id',
                    width: 150,
                    align: "left",
                    editable: true,
                    edittype: 'select',
                    hidden: true,
                    editrules: {edithidden: true, required: true},
                    editoptions: {dataUrl: '<?php echo WS_JQGRID.'allowance.allowancedetail_controller/getListParam1'; ?>',
                        postData: function (rowid) {
                            paramid = 4;
                            return { paramid: paramid, table:'1' };
                        },
                        dataInit: function (elem) {
                            $(elem).width(240);  // set the width which you need
                        }
                    }
                },
                {label: 'Allowance Type',name: 'desc_allowance' ,width: 150, align: 'left',editable: false,
                      editoptions:{
                             size: 30,
                             maxlength:22
                     },editrules: {required: false}
                 }, 
                {label: 'Allowance Dat',name: 'allowance_dat' ,width: 100, align: 'left',editable: true,
                      editoptions:{ 
                        dataInit: function (element) {
                            $(element).prop('readonly',true);
                            $(element).datepicker({
                                autoclose: true,
                                format: 'yyyy-mm-dd',
                                orientation: 'up',
                                todayHighlight: true
                            });
                        },
                             size: 30,
                             maxlength:7
                     },editrules: {required: true}
                 }, 
                 {label: 'Rate',name: 'trf_amount' ,width: 75, align: 'right',editable: false,
                      editoptions:{
                             size: 30,
                             maxlength:22
                     },editrules: {required: false},
                     formatter:'currency', formatoptions:{decimalSeparator:",", thousandsSeparator: ".", decimalPlaces: 0, prefix: " "},
                 },
                {label: 'Description',name: 'description' ,width: 100, align: 'left',editable: true,
                      editoptions:{
                             size: 30,
                             maxlength:60
                     },editrules: {required: false}
                 }              
            ],
            height: '200',
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

            },
            sortorder:'',
            pager: '#grid-pager-detail',
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
            editurl: '<?php echo WS_JQGRID."allowance.allowancedetail_controller/crud"; ?>',
            caption: "Allowancedetail"

        });

        jQuery('#grid-table-detail').jqGrid('navGrid', '#grid-pager-detail',
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
                 editData: {
                    emp_master_id: function() {
                        var selRowId =  $("#grid-table").jqGrid ('getGridParam', 'selrow');
                        var emp_master_id = $("#grid-table").jqGrid('getCell', selRowId, 'emp_master_id');

                        return emp_master_id;
                    },
                    allow_batch_id: function() {
                        var selRowId =  $("#grid-table").jqGrid ('getGridParam', 'selrow');
                        var allow_batch_id = $("#grid-table").jqGrid('getCell', selRowId, 'allow_batch_id');

                        return allow_batch_id;
                    }
                },
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
        $(grid_selector).jqGrid( 'setGridWidth', $(".col-md-6").width() );
        $(pager_selector).jqGrid( 'setGridWidth', parent_column.width() );

    }

</script>
<script src='<?php echo base_url(); ?>assets/fullcalendar/lib/moment.min.js'></script>
<!-- <script src='<?php echo base_url(); ?>assets/fullcalendar/lib/jquery.min.js'></script> -->
<script src='<?php echo base_url(); ?>assets/fullcalendar/fullcalendar.min.js'></script>
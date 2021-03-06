<!-- breadcrumb -->
<div class="page-bar">
    <ul class="page-breadcrumb">
        <li>
            <a href="<?php base_url(); ?>">Home</a>
            <i class="fa fa-circle"></i>
        </li>
        <li>
            <span>allowancetype</span>
        </li>
    </ul>
</div>
<!-- end breadcrumb -->
<div class="space-4"></div>
<div class="row">
    <div class="col-md-12">
        <table id="grid-table"></table>
        <div id="grid-pager"></div>
    </div>
</div>
<div class="space-4"></div>
            <hr>
            <div class="row" id="detail_placeholder" style="display:none;">
                <div class="col-xs-12">
                    <table id="grid-table-detail"></table>
                    <div id="grid-pager-detail"></div>
                </div>
                <input type="hidden" id="temp_cellValue">
            </div>

<script>

    jQuery(function($) {
        var grid_selector = "#grid-table";
        var pager_selector = "#grid-pager";

        jQuery("#grid-table").jqGrid({
            url: '<?php echo WS_JQGRID."allowancetype.allowancetype_controller/crud"; ?>',
            datatype: "json",
            mtype: "POST",
            colModel: [
				{label: 'ID', name: 'allowance_type_id', key: true, width: 5, sorttype: 'number', editable: true, hidden: true}, 
 				{label: 'Code',name: 'code' ,width: 100, align: 'left',editable: true,
  					  editoptions:{
   						     size: 30,
  						     maxlength:10
  					 },editrules: {required: false}
   				 }, 
 				{label: 'Desc Allowance',name: 'desc_allowance' ,width: 250, align: 'left',editable: true,
  					  edittype:'textarea',
  					  editoptions:{
   						     size: 30,
  						     maxlength:250
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
                var celValue = $('#grid-table').jqGrid('getCell', rowid, 'allowance_type_id');
                var celCode = $('#grid-table').jqGrid('getCell', rowid, 'desc_allowance');

                var grid_detail = jQuery("#grid-table-detail");
                if (rowid != null) {
                    grid_detail.jqGrid('setGridParam', {
                        url: "<?php echo WS_JQGRID."allowance.allowancetariff_controller/crud"; ?>",
                        postData: {celValue: celValue}
                    });
                    var strCaption = 'Allowance Tariff  :: ' + celCode;
                    grid_detail.jqGrid('setCaption', strCaption);
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

            },
            //memanggil controller jqgrid yang ada di controller crud
            editurl: '<?php echo WS_JQGRID."allowancetype.allowancetype_controller/crud"; ?>',
            caption: "Allowancetype"

        });

        jQuery('#grid-table').jqGrid('navGrid', '#grid-pager',
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

        jQuery("#grid-table-detail").jqGrid({
            url: '<?php echo WS_JQGRID."allowance.allowancetariff_controller/crud"; ?>',
            datatype: "json",
            mtype: "POST",
            colModel: [
                {label: 'ID', name: 'allowancetrf_id', key: true, width: 5, sorttype: 'number', editable: true, hidden: true}, 
                {label: 'Tariff Amount',name: 'trf_amount' ,width: 100, align: 'right',editable: false,
                      editoptions:{
                             size: 30,
                             maxlength:22
                     },editrules: {required: false},
                     formatter:'currency', formatoptions:{decimalSeparator:",", thousandsSeparator: ".", decimalPlaces: 0, prefix: " "},
                 }, 
                {label: 'Trf Amount',name: 'trf_amount' ,width: 50, align: 'right',hidden:true,editable: true,
                      editoptions:{
                             size: 30,
                             maxlength:22
                     },editrules: {edithidden: true,required: true}
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
                {label: 'Allowance Type Id',name: 'allowance_type_id' ,width: 100, align: 'right',hidden:true,editable: true,
                      editoptions:{
                             size: 30,
                             maxlength:22
                     },editrules: {required: false}
                 }, 
                {label: 'Reference List Id',name: 'reference_list_id' ,width: 100, align: 'right',hidden:true,editable: true,
                      editoptions:{
                             size: 30,
                             maxlength:22
                     },editrules: {required: false}
                 }, 
                 {
                    label: 'Allowance Type',
                    name: 'reference_list_id',
                    width: 150,
                    align: "left",
                    editable: true,
                    edittype: 'select',
                    hidden: true,
                    editrules: {edithidden: true, required: true},
                    editoptions: {dataUrl: '<?php echo WS_JQGRID.'allowance.allowancetariff_controller/getListParam'; ?>',
                        postData: function (rowid) {
                            paramid = 4;
                            return { paramid: paramid };
                        },
                        dataInit: function (elem) {
                            $(elem).width(240);  // set the width which you need
                        }
                    }
                },
                 {label: 'Description',name: 'description' ,width: 100, align: 'left',hidden:false,editable: false,
                      editoptions:{
                             size: 30,
                             maxlength:22
                     },editrules: {required: false}
                 }
            ],
            height: '100%',
            //autowidth: false,
            width:500,
            viewrecords: true,
            rowNum: 5,
            rowList: [5, 10, 20],
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
            editurl: "<?php echo WS_JQGRID.'allowance.allowancetariff_controller/crud'; ?>",
            caption: "Allowance Tariff"

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
                viewPagerButtons: false,
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
                    allowance_type_id: function() {
                        var selRowId =  $("#grid-table").jqGrid ('getGridParam', 'selrow');
                        var allowance_type_id = $("#grid-table").jqGrid('getCell', selRowId, 'allowance_type_id');

                        return allowance_type_id;
                    }
                },
                serializeEditData: serializeJSON,
                //new record form
                closeAfterAdd: true,
                clearAfterAdd : true,
                closeOnEscape:true,
                recreateForm: true,
                width: 'auto',
                errorTextFormat: function (data) {
                    return 'Error: ' + data.responseText
                },
                viewPagerButtons: false,
                beforeShowForm: function (e, form) {
                    var form = $(e[0]);
                    style_edit_form(form);
                },
                beforeInitData: function () {
                    $('#grid-table-detail').jqGrid('resetSelection');
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
<!-- breadcrumb -->
<div class="page-bar">
    <ul class="page-breadcrumb">
        <li>
            <a href="<?php base_url(); ?>">Home</a>
            <i class="fa fa-circle"></i>
        </li>
        <li>
            <span>Preferencetype</span>
        </li>
    </ul>
</div>
<!-- end breadcrumb -->
<div class="space-4"></div>
<div class="row">
    <div class="col-md-12">
        <div class="tabbable">
            <ul class="nav nav-tabs">
                <li class="active">
                    <a href="javascript:;" data-toggle="tab" aria-expanded="true" id="tab-1">
                        <i class="blue"></i>
                        <strong> Preferencetype </strong>
                    </a>
                </li>
            </ul>
        </div>

        <div class="tab-content no-border">
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
            </div>
        </div>
    </div>
</div>

<script>
    jQuery(function($) {

        var grid_selector = "#grid-table";
        var pager_selector = "#grid-pager";

        jQuery("#grid-table").jqGrid({
            url: '<?php echo WS_JQGRID."preferencetype.preferencetype_controller/crud"; ?>',
            datatype: "json",
            mtype: "POST",
            colModel: [
                {label: 'ID', name: 'p_reference_type_id', key: true, width: 5, sorttype: 'number', editable: true, hidden: true}, 
                {label: 'Code',name: 'code' ,width: 100, align: 'left',editable: true,
                      editoptions:{
                             size: 30,
                             maxlength:64
                     },editrules: {required: false}
                 }, 
                {label: 'Reference Name',name: 'reference_name' ,width: 100, align: 'left',editable: true,
                      editoptions:{
                             size: 30,
                             maxlength:64
                     },editrules: {required: false}
                 }, 
                {label: 'Description',name: 'description' ,width: 128, align: 'left',editable: true,
                      edittype:'textarea',
                      editoptions:{
                             size: 30,
                             maxlength:128
                     },editrules: {required: false}
                 }, 
                {label: 'Creation Date',name: 'creation_date' ,width: 100, align: 'left',editable: true, hidden: true,
                      editoptions:{
                             size: 30,
                             maxlength:7
                     },editrules: {required: false}
                 }, 
                {label: 'Updated Date',name: 'updated_date' ,width: 100, align: 'left',editable: true, hidden: true,
                      editoptions:{
                             size: 30,
                             maxlength:7
                     },editrules: {required: false}
                 }, 
                {label: 'Updated By',name: 'updated_by' ,width: 100, align: 'left',editable: true, hidden: true,
                      editoptions:{
                             size: 30,
                             maxlength:16
                     },editrules: {required: false}
                 }
              
            ],
            height: '100%',
            autowidth: true,
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
                var celValue = $('#grid-table').jqGrid('getCell', rowid, 'p_reference_type_id');
                var celCode = $('#grid-table').jqGrid('getCell', rowid, 'reference_name');

                var grid_detail = jQuery("#grid-table-detail");
                if (rowid != null) {
                    grid_detail.jqGrid('setGridParam', {
                        url: "<?php echo WS_JQGRID."preferencetype.preferencelist_controller/crud"; ?>",
                        postData: {p_reference_type_id: celValue}
                    });
                    var strCaption = 'Mapping Reference Type List : ' + celCode;
                    grid_detail.jqGrid('setCaption', strCaption);
                    $("#temp_user_id").val(celValue);
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
            editurl: '<?php echo WS_JQGRID."preferencetype.preferencetype_controller/crud"; ?>',
            caption: "Preferencetype"

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
                    $("#detail_placeholder").hide();
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
                    /*form.css({"height": 0.50*screen.height+"px"});
                    form.css({"width": 0.60*screen.width+"px"});*/

                    $("#user_name").prop("readonly", false);

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
                    /*form.css({"height": 0.50*screen.height+"px"});
                    form.css({"width": 0.60*screen.width+"px"});*/

                    $("#tr_user_password", form).show();
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


        /* ------------------------------  detail grid --------------------------------*/
        jQuery("#grid-table-detail").jqGrid({
            url: "<?php echo WS_JQGRID.'preferencetype.preferencelist_controller/crud'; ?>",
            datatype: "json",
            mtype: "POST",
            colModel: [
                {label: 'ID', name: 'p_reference_list_id', key: true, width: 5, sorttype: 'number', editable: true, hidden: true},
                {label: 'Reference List ID', name: 'p_reference_list_id', width: 120, sorttype: 'number', editable: true, hidden: true},
                {label: 'Reference Type', name: 'p_reference_type_id', width: 120, align: "left", editable: true, hidden:true,
                    editrules: {edithidden: false, required:false},
                    //edittype: 'select',
                   /* editoptions: {
                        dataUrl: "<?php echo WS_JQGRID.'preferencetype.preferencelist_controller/html_select_options_roles'; ?>",
                        dataInit: function(elem) {
                            $(elem).width(250);  // set the width which you need
                        },
                        postData : {
                            p_reference_list_id : function() {
                                var selRowId =  $("#grid-table").jqGrid ('getGridParam', 'selrow');
                                var p_reference_list_id = $("#grid-table").jqGrid('getCell', selRowId, 'p_reference_list_id');

                                return p_reference_list_id;
                            },
                            p_reference_type_id : function(){
                                var selRowId =  $("#grid-table-detail").jqGrid ('getGridParam', 'selrow');
                                var p_reference_type_id = $("#grid-table-detail").jqGrid('getCell', selRowId, 'p_reference_type_id');

                                return p_reference_type_id;
                            }
                        },
                        buildSelect: function (data) {
                            try {
                                var response = $.parseJSON(data);
                                if(response.success == false) {
                                    swal({title: 'Attention', text: response.message, html: true, type: "warning"});
                                    return "";
                                }
                            }catch(err) {
                                return data;
                            }
                        }
                    }*/
                },
                {label: 'Reference Name', name: 'reference_name', width: 120, align: "left", editable: true},
                {label: 'Code', name: 'code', width: 120, align: "left", editable: true},
                {label: 'Listing No', name: 'listing_no', width: 120, align: "left", editable: true, formatter:'number'},
                {label: 'Description', name: 'description', width: 120, align: "left", editable: true}
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
				/*var celCode = $('#grid-table-detail').jqGrid('getCell', rowid, 'p_reference_type_id');
                if (rowid = null) {
                    grid_detail.jqGrid('setGridParam', {
                        url: "<?php echo WS_JQGRID."preferencetype.preferencelist/validate"; ?>",
                        postData: {p_reference_type_id: celValue}
                    });
                    
                }*/
				var celValue = $('#grid-table-detail').jqGrid('getCell', rowid, 'p_reference_type_id');
				//alert(celValue);
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
            editurl: "<?php echo WS_JQGRID.'preferencetype.preferencelist_controller/crud'; ?>",
            caption: "Reference"

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
                    p_reference_type_id: function() {
                        var selRowId =  $("#grid-table").jqGrid ('getGridParam', 'selrow');
                        var p_reference_type_id = $("#grid-table").jqGrid('getCell', selRowId, 'p_reference_type_id');
						//alert(p_reference_type_id);
                        return p_reference_type_id;
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
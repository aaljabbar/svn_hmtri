<div>
    <div class="page-bar">
        <ul class="page-breadcrumb">
            <li>
                <a href="<?php base_url();?>">Home</a>
                <i class="fa fa-circle"></i>
            </li>
            <li>
                <a href="#">Background Job</a>
                <i class="fa fa-circle"></i>
            </li>
            <li>
                <span>Daftar Background Job</span>
            </li>
        </ul>
    </div>
    <div class="space-4"></div> 
    <div class="col-md-12">        
            <ul class="nav nav-tabs">
                <li class="active">
                    <a data-toggle="tab"> Daftar Background Job </a>
                </li>
                <li id="tab-2">
                    <a data-toggle="tab"> Daemon Manager </a>
                </li>
            </ul>
            <div class="row">
                <div class="col-md-8">
                    <i id="force_process" class="btn btn-success"> Force Process </i>
                </div>
            </div>

            <div class="space-4"></div> 
            <div class="row">
                <div class="col-md-6">
                    <div class="tab-content">
                        <div class="tab-pane active">
                            <table id="grid-table"></table>
                            <div id="grid-pager"></div>
                        </div>
                    </div>  
                </div>

                <div class="col-md-6">
                    <div class="tab-content">
                        <div class="tab-pane active" id="table_log" style="display:none;">
                            <table id="grid-table-log"></table>
                            <div id="grid-pager-log"></div>
                        </div>
                    </div>
                </div>
            </div>

    </div>
    
</div>
<script>

    $(function($) {

        $("#tab-2").on( "click", function() {  
            // var grid = $('#grid-table');
            // selRowId = grid.jqGrid ('getGridParam', 'selrow');

            // var idd = grid.jqGrid ('getCell', selRowId, 'job_control_id');
            // var code = grid.jqGrid ('getCell', selRowId, 'job');

            loadContentWithParams("process.daemon_manager", {            
            });
        });
        
        $("#force_process").on( "click", function() {           
            $.ajax({
                url: '<?php echo WS_JQGRID."process.background_job_controller/force_scheduler"; ?>',
                type: "POST",
                dataType: "json",
                data: {},
                success: function (data) {
                    if(data.success){
                        swal("", "Start Daemon success", "success");
                    }else{
                        swal("Informasi", "Start Daemon failed", "info"); 
                    }
                },
                error: function (xhr, status, error) {
                    swal({title: "Error!", text: xhr.responseText, html: true, type: "error"});
                }
            });
        });

    });
    
    jQuery(function($) {
        var grid_selector = "#grid-table";
        var pager_selector = "#grid-pager";

        jQuery("#grid-table").jqGrid({
            url: '<?php echo WS_JQGRID."process.background_job_controller/crud"; ?>',
            datatype: "json",
            mtype: "POST",
            colModel: [
                {label: 'Job Code', name: 'job', hidden: true},                
                {label: 'Job Control ID', name: 'job_control_id', hidden: true},                
                {label: 'Proses', name: 'procedure_name', hidden: false}
            ],
            height: '100%',
            autowidth: true,
            viewrecords: false,
            rowNum: 10,
            rowList: [10,20,50],
            rownumbers: true, // show row numbers
            rownumWidth: 35, // the width of the row numbers columns
            altRows: true,
            shrinkToFit: true,
            multiboxonly: true,
            onSelectRow: function (rowid) {
                /*do something when selected*/
                var celValue = $('#grid-table').jqGrid('getCell', rowid, 'job_control_id');

                if (rowid != null) {
                    jQuery("#grid-table-log").jqGrid('setGridParam', {
                        url: '<?php echo WS_JQGRID."process.log_payroll_controller/crud"; ?>',
                        postData: {job_control_id: celValue}
                    });
                    $("#grid-table-log").trigger("reloadGrid");
                    $("#table_log").show();

                }

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
                // responsive_jqgrid(grid_selector,pager_selector);
            },
            //memanggil controller jqgrid yang ada di controller crud
            //editurl: '',
            caption: "Daftar Background Job"

        });

        jQuery('#grid-table').jqGrid('navGrid', '#grid-pager',
            {   //navbar options
                edit: false,
                excel: true,
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
                    $("#table_log").hide();

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
    });
    
    jQuery(function($) {
        var grid_selector = "#grid-table-log";
        var pager_selector = "#grid-pager-log";

        jQuery("#grid-table-log").jqGrid({
            // url: '<?php echo WS_JQGRID."proses.log_billing_controller/crud"; ?>',
            datatype: "json",
            mtype: "POST",
            colModel: [
                {label: 'counter_no', name: 'counter_no', hidden: true},                
                {label: 'Time', name: 'log_date', hidden: false, width: 20},                
                {label: 'Message', name: 'log_message', hidden: false}
            ],
            height: '100%',
            autowidth: false,
            width: 500,
            viewrecords: false,
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
            pager: '#grid-pager-log',
            jsonReader: {
                root: 'rows',
                id: 'id',
                repeatitems: false
            },
            loadComplete: function (response) {
                if(response.success == false) {
                    swal({title: 'Attention', text: response.message, html: true, type: "warning"});
                }
                // responsive_jqgrid(grid_selector,pager_selector);
            },
            //memanggil controller jqgrid yang ada di controller crud
            //editurl: '',
            caption: "Log Proses"

        });

        jQuery('#grid-table-log').jqGrid('navGrid', '#grid-pager-log',
            {   //navbar options
                edit: false,
                excel: true,
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
    });
    
    function serializeJSON(postdata) {
        var items;
        if(postdata.oper != 'del') {
            items = JSON.stringify(postdata, function(key,value){
                if (typeof value === 'function') {
                    return value();
                } else {
                  return value;
                }
            });
        }else {
            items = postdata.id;
        }

        var jsondata = {items:items, oper:postdata.oper, '<?php echo $this->security->get_csrf_token_name(); ?>' : '<?php echo $this->security->get_csrf_hash(); ?>'};
        return jsondata;
    }

    function style_edit_form(form) {

        //update buttons classes
        var buttons = form.next().find('.EditButton .fm-button');
        buttons.addClass('btn btn-sm').find('[class*="-icon"]').hide();//ui-icon, s-icon
        buttons.eq(0).addClass('btn-primary');
        buttons.eq(1).addClass('btn-danger');


    }

    function style_delete_form(form) {
        var buttons = form.next().find('.EditButton .fm-button');
        buttons.addClass('btn btn-sm btn-white btn-round').find('[class*="-icon"]').hide();//ui-icon, s-icon
        buttons.eq(0).addClass('btn-danger');
        buttons.eq(1).addClass('btn-default');
    }

    function style_search_filters(form) {
        form.find('.delete-rule').val('X');
        form.find('.add-rule').addClass('btn btn-xs btn-primary');
        form.find('.add-group').addClass('btn btn-xs btn-success');
        form.find('.delete-group').addClass('btn btn-xs btn-danger');
    }

    function style_search_form(form) {
        var dialog = form.closest('.ui-jqdialog');
        var buttons = dialog.find('.EditTable')
        buttons.find('.EditButton a[id*="_reset"]').addClass('btn btn-sm btn-info').find('.ui-icon').attr('class', 'fa fa-retweet');
        buttons.find('.EditButton a[id*="_query"]').addClass('btn btn-sm btn-inverse').find('.ui-icon').attr('class', 'fa fa-comment-o');
        buttons.find('.EditButton a[id*="_search"]').addClass('btn btn-sm btn-success').find('.ui-icon').attr('class', 'fa fa-search');
    }

    function responsive_jqgrid(grid_selector, pager_selector) {

        var parent_column = $(grid_selector).closest('[class*="col-"]');
        $(grid_selector).jqGrid( 'setGridWidth', $(".page-content").width() );
        $(pager_selector).jqGrid( 'setGridWidth', parent_column.width() );

    }
    
    function swal_terminate(){
      swal({
            title: "Apakah Anda Yakin?",
            text: "Anda akan menghentikan/terminasi schema",
            type: "warning",
            showCancelButton: true,
            confirmButtonClass: "btn-danger",
            confirmButtonText: "Ya, terminasi schema",
            closeOnConfirm: false
            },
            function(){
                swal("Terminated", "Terminasi berhasil", "success");
            });
    };
</script>
<div>
    <div class="page-bar">
        <ul class="page-breadcrumb">
            <li>
                <a href="<?php base_url();?>">Home</a>
                <i class="fa fa-circle"></i>
            </li>
            <li>
                <a href="#">Job</a>
                <i class="fa fa-circle"></i>
            </li>
            <li>
                <span>Posting Payroll</span>
            </li>
        </ul>
    </div>
    <div class="space-4"></div>
    <div class="col-md-12">
        <div class="tabbable tabbable-tabdrop">
            <ul class="nav nav-tabs">
                <li id="tab-1">
                    <a data-toggle="tab"> Periode </a>
                </li>
                <li id="tab-2" class="active">
                    <a data-toggle="tab"> Posting Payroll </a>
                </li>
                <li id="tab-3">
                    <a data-toggle="tab"> Proses </a>
                </li>
            </ul>
            <div class="tab-content">
                <div class="tab-pane active">
                    <table id="grid-table-payroll"></table>
                    <div id="grid-pager-payroll"></div>
                </div>
            </div>
        </div>
    </div>  
</div>
<script>
    $(function($) {
        $("#tab-1").on( "click", function() {    
            loadContentWithParams("process.posting_payroll", {                
            });
        });

        $("#tab-3").on( "click", function() {    
            var grid = $('#grid-table-payroll');
            selRowId = grid.jqGrid ('getGridParam', 'selrow');
            
            var idd = grid.jqGrid ('getCell', selRowId, 'input_data_control_id');
            var file_name = grid.jqGrid ('getCell', selRowId, 'input_file_name');
            
            if(selRowId == null) {
                swal("Informasi", "Silahkan Pilih Salah Satu Baris Data", "info");
                return false;
            }
            loadContentWithParams("process.posting_payroll_proc", {
                input_data_control_id: idd,
                input_file_name : file_name,
                p_finance_period_id : "<?php echo $this->input->post('p_finance_period_id'); ?>",
                finance_period_code : "<?php echo $this->input->post('finance_period_code'); ?>",
                period_status_code :  "<?php echo $this->input->post('period_status_code'); ?>"                  
                
            });
        });
    });
    jQuery(function($) {
        var grid_selector = "#grid-table-payroll";
        var pager_selector = "#grid-pager-payroll";

        jQuery("#grid-table-payroll").jqGrid({
            url: '<?php echo WS_JQGRID."process.batch_posting_payroll_controller/crud"; ?>',
            datatype: "json",
            mtype: "POST",
            postData: {
                p_finance_period_id : <?php echo $this->input->post('p_finance_period_id'); ?>
            },
            colModel: [
                {label: 'ID', name: 'input_data_control_id', hidden: false},                
                {label: 'Periode', name: 'finance_period_code', hidden: false},                
                {label: 'Invoice Date', name: 'invoice_date', hidden: false},                
                {label: 'Batch', name: 'input_file_name', width :350, hidden: false, editable: true,
                    editoptions: {
                        size: 40,
                        maxlength:250,
                        readonly: true
                    },
                    editrules: {required: false}
                },                
                {label: 'Finish?', name: 'is_finish_processed', hidden: false},                
                {label: 'Status', name: 'data_status_code', hidden: false}
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
            pager: '#grid-pager-payroll',
            jsonReader: {
                root: 'rows',
                id: 'id',
                repeatitems: false
            },
            loadComplete: function (response) {
                if(response.success == false) {
                    swal({title: 'Attention', text: response.message, html: true, type: "warning"});
                }
                responsive_jqgrid(grid_selector,pager_selector);

                var grid = $("#grid-table-payroll"),
                gid = $.jgrid.jqID(grid[0].id);
                var $td = $('#add_' + gid);

                var status = "<?php echo $this->input->post('period_status_code'); ?>";
                if (status == "CLOSED"){
                    $td.hide();
                }else{
                    $td.show();
                }
            },
            //memanggil controller jqgrid yang ada di controller crud
            editurl: '<?php echo WS_JQGRID."process.batch_posting_payroll_controller/crud"; ?>',
            caption: "Batch Payroll :: <?php echo $this->input->post('finance_period_code'); ?>"

        });

        jQuery('#grid-table-payroll').jqGrid('navGrid', '#grid-pager-payroll',
            {   //navbar options
                edit: false,
                excel: true,
                editicon: 'fa fa-pencil blue bigger-120',
                add: true,              
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
                editData: {
                    p_finance_period_id: function() {
                        return <?php echo $this->input->post('p_finance_period_id'); ?>;
                    }
                },
                closeAfterAdd: true,
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
        $(grid_selector).jqGrid( 'setGridWidth', $(".form-body").width() );
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
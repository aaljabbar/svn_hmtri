<!-- breadcrumb -->
<div class="page-bar">
    <ul class="page-breadcrumb">
        <li>
            <a href="<?php base_url(); ?>">Home</a>
            <i class="fa fa-circle"></i>
        </li>
        <li>
            <span>payrollsummary</span>
        </li>
    </ul>
</div>
<!-- end breadcrumb -->
<div class="space-4"></div>
<div class="row">
    <div class="col-md-12">
        <div class="row">
            <label class="control-label col-md-1">Period</label>
            <div class="col-md-2">
                <div id="comboYear"></div>
            </div>
            <div class="col-md-2">
                <div id="comboPeriod"></div>
            </div>
            <button class="btn btn-primary" type="button" onclick="find()">Find</button>
            <button class="btn btn-danger" style="display: none" type="button" onclick="cetakPDF()">Mold All</button>
        </div>
    </div>
</div>

<div class="space-4"></div>
<div class="row">
    <div class="col-md-12">
        <table id="grid-table"></table>
        <div id="grid-pager"></div>
    </div>
</div>

<script type="text/javascript">
    function find(){
        var p_finance_period_id = $('#p_finance_period_id').val();

        if (p_finance_period_id == ''||p_finance_period_id==null){
            swal({title: "Error!", text: 'Period Harus Diisi', html: true, type: "error"});
            return false;
        }

        jQuery(function($) {
            var grid_selector = "#grid-table";

            jQuery("#grid-table").jqGrid('setGridParam',{
                url: '<?php echo WS_JQGRID."process.flaging_payment_controller/crud"; ?>',
                postData: {p_finance_period_id:p_finance_period_id,oper:'read'}
            });
            $("#grid-table").trigger("reloadGrid");
            //jQuery("#detail_placeholder").hide();
        });
    }

    $.ajax({
        url: "<?php echo WS_JQGRID."process.flaging_payment_controller/readDataComboYear"; ?>" ,
        type: "POST",
        dataType: "json",
        data: {},
        success: function (data) {
            //console.log(data.items);
            $("#comboYear").html(data.items);
        },
        error: function (xhr, status, error) {
            swal({title: "Error!", text: xhr.responseText, html: true, type: "error"});
        }
    });

    $.ajax({
        url: "<?php echo WS_JQGRID."process.flaging_payment_controller/readDataComboPeriod"; ?>" ,
        type: "POST",
        dataType: "json",
        data: {},
        success: function (data) {
            //console.log(data.items);
            $("#comboPeriod").html(data.items);
        },
        error: function (xhr, status, error) {
            swal({title: "Error!", text: xhr.responseText, html: true, type: "error"});
        }
    });

    function changePeriod(){
        var p_year_period_id = $('#p_year_period_id').val();

        $.ajax({
            url: "<?php echo WS_JQGRID."process.flaging_payment_controller/readDataComboPeriod"; ?>" ,
            type: "POST",
            dataType: "json",
            data: {year:p_year_period_id},
            success: function (data) {
                //console.log(data.items);
                $("#comboPeriod").html(data.items);
            },
            error: function (xhr, status, error) {
                swal({title: "Error!", text: xhr.responseText, html: true, type: "error"});
            }
        });
    }


    function payment(payrollsummary_id){
        $.ajax({
            url: "<?php echo WS_JQGRID."process.flaging_payment_controller/readUpdate"; ?>" ,
            type: "POST",
            dataType: "json",
            data: {payrollsummary_id:payrollsummary_id},
            success: function (data) {
                console.log(data);
                $("#grid-table").trigger("reloadGrid");
            },
            error: function (xhr, status, error) {
                swal({title: "Error!", text: xhr.responseText, html: true, type: "error"});
            }
        });
    } 

</script>


<script>

    jQuery(function($) {
        var grid_selector = "#grid-table";
        var pager_selector = "#grid-pager";

        jQuery("#grid-table").jqGrid({
            url: '<?php echo WS_JQGRID."process.flaging_payment_controller/crud"; ?>',
            datatype: "json",
            mtype: "POST",
            colModel: [
				{label: 'ID', name: 'payrollsummary_id', key: true, width: 5, sorttype: 'number', editable: true, hidden: true}, 
 				{label: 'Bussiness Unit',name: 'bu_name' ,width: 100, align: 'left',editable: true,
  					  editoptions:{
   						     size: 30,
  						     maxlength:10
  					 },editrules: {required: false}
   				 }, 
 				{label: 'Name',name: 'emp_name' ,width: 100, align: 'left',editable: true,
                      editoptions:{
                             size: 30,
                             maxlength:10
                     },editrules: {required: false}
                 }, 
                {label: 'Emp Master Id',name: 'emp_master_id' ,width: 100, align: 'right',editable: true,hidden: true,
                      editoptions:{
                             size: 30,
                             maxlength:22
                     },editrules: {required: false}
                 }, 
                {label: 'Payment Status',name: 'payment_status' ,width: 100, align: 'left',editable: true,
                      editoptions:{
                             size: 30,
                             maxlength:3
                     },editrules: {required: false}
                 }, 
                {label: 'Total Transfer',name: 'total_transfer' ,width: 100, align: 'right',editable: true,formatter:'currency', formatoptions: {prefix:"", thousandsSeparator:','},
                      editoptions:{
                             size: 30,
                             maxlength:22
                     },editrules: {required: false}
                 }, 
                {label: 'Tot Remain',name: 'tot_remain' ,width: 100, align: 'right',editable: true,formatter:'currency', formatoptions: {prefix:"", thousandsSeparator:','},
                      editoptions:{
                             size: 30,
                             maxlength:22
                     },editrules: {required: false}
                 }, 
                {label: 'Tot Money',name: 'tot_mny' ,width: 100, align: 'right',editable: true,formatter:'currency', formatoptions: {prefix:"", thousandsSeparator:','},
                      editoptions:{
                             size: 30,
                             maxlength:22
                     },editrules: {required: false}
                 }, 
                {label: 'Periode',name: 'periode' ,width: 100, align: 'left',editable: true,
                      editoptions:{
                             size: 30,
                             maxlength:10
                     },editrules: {required: false}
                 },
                 {name: 'Options',width: 100, align: "center",
                    formatter:function(cellvalue, options, rowObject) {
                        var payrollsummary_id = rowObject['payrollsummary_id'];
                        var payment_status = rowObject['payment_status'];


                        if (payment_status == null ){
                            return '<a class="btn btn-danger btn-xs" href="#" onclick="payment('+payrollsummary_id+');">Pay</a>';
                        } 
                        
                        return '';
                        
                        
                    }
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
            editurl: '<?php echo WS_JQGRID."process.flaging_payment_controller/crud"; ?>',
            caption: "Payrollsummary"

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
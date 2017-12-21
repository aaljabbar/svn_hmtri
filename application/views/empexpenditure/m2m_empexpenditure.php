<!-- breadcrumb -->
<div class="page-bar">
    <ul class="page-breadcrumb">
        <li>
            <a href="<?php base_url(); ?>">Home</a>
            <i class="fa fa-circle"></i>
        </li>
        <li>
            <span>empexpenditure</span>
        </li>
    </ul>
</div>
<!-- end breadcrumb -->
<div class="space-4"></div>
<div class="row">
    <div class="col-md-12">

        <div class="row">
            <label class="control-label col-md-1">Periode</label>
            <div class="col-md-2">
                <div id="comboYear"></div>
            </div>
            <div class="col-md-2">
                <div id="comboPeriod"></div>
            </div>
            <button class="btn btn-primary" type="button" onclick="find()">Find</button>
        </div>

        <div class="space-2"></div>

        <div class="row">
            <div class="col-md-12">
                <table id="grid-table"></table>
                <div id="grid-pager"></div>
            </div>
        </div>

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
                url: '<?php echo WS_JQGRID."empexpenditure.m2m_empexpenditure_controller/crud"; ?>',
                postData: {p_finance_period_id:p_finance_period_id,oper:'read'}
            });
            $("#grid-table").trigger("reloadGrid");
            jQuery("#detail_placeholder").hide();
        });
    }

    $.ajax({
        url: "<?php echo WS_JQGRID."empexpenditure.m2m_empexpenditure_controller/readDataComboYear"; ?>" ,
        type: "POST",
        dataType: "json",
        data: {},
        success: function (data) {
            ////console.log(data.items);
            $("#comboYear").html(data.items);
        },
        error: function (xhr, status, error) {
            swal({title: "Error!", text: xhr.responseText, html: true, type: "error"});
        }
    });

    $.ajax({
        url: "<?php echo WS_JQGRID."empexpenditure.m2m_empexpenditure_controller/readDataComboPeriod"; ?>" ,
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
            url: "<?php echo WS_JQGRID."empexpenditure.m2m_empexpenditure_controller/readDataComboPeriod"; ?>" ,
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
</script>

<script>

    

    jQuery(function($) {
        var grid_selector = "#grid-table";
        var pager_selector = "#grid-pager";
        var p_finance_period_id = $("#p_finance_period_id").val();


        jQuery("#grid-table").jqGrid({
            url: '<?php echo WS_JQGRID."empexpenditure.m2m_empexpenditure_controller/crud"; ?>',
            datatype: "json",
            postData:{p_finance_period_id:p_finance_period_id},
            mtype: "POST",
            colModel: [
				{label: 'ID', name: 'empexpenditure_id', key: true, width: 5, sorttype: 'number', editable: true, hidden: true}, 
                {label: 'Bussiness unit',name: 'bu_name' ,width: 100, align: 'left', editable: true,
                      editoptions:{
                             size: 30,
                             maxlength:22
                     },editrules: {required: false}
                 }, 
 				
 				{label: 'Bussinessunit Id',name: 'bussinessunit_id' ,width: 100, align: 'right', hidden: true,editable: true,
  					  editoptions:{
   						     size: 30,
  						     maxlength:22
  					 },editrules: {required: false}
   				 },
                 {label: 'Periode Before',name: 'periode_before' ,width: 100, align: 'left',editable: true,
                      editoptions:{
                             size: 30,
                             maxlength:22
                     },editrules: {required: false}
                 }, 
                {label: 'Exp Amount Before',name: 'exp_amount_before' ,width: 100, align: 'right',editable: true,formatter:'currency', formatoptions: {prefix:"", thousandsSeparator:','},
                      editoptions:{
                             size: 30,
                             maxlength:22
                     },editrules: {required: false}
                 },
                 {label: 'Periode',name: 'periode' ,width: 100, align: 'left',editable: true,
                      editoptions:{
                             size: 30,
                             maxlength:22
                     },editrules: {required: false}
                 }, 
 				{label: 'Exp Amount',name: 'exp_amount' ,width: 100, align: 'right',editable: true,formatter:'currency', formatoptions: {prefix:"", thousandsSeparator:','},
  					  editoptions:{
   						     size: 30,
  						     maxlength:22
  					 },editrules: {required: false}
   				 },
                 {label: 'Growth',name: 'growth' ,width: 100, align: 'right', hidden: false,editable: true,
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
            editurl: '<?php echo WS_JQGRID."empexpenditure.m2m_empexpenditure_controller/crud"; ?>',
            caption: "Empexpenditure"

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
                    jQuery("#detail_placeholder").hide();
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
<!-- begin swal -->
<!-- <script src="<?php echo base_url(); ?>assets/swal/sweetalert.min.js"></script>
<script src="<?php echo base_url(); ?>assets/swal/sweetalert-dev.js"></script> -->

<!-- end swal -->
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
                <span>Daemon Manager</span>
            </li>
        </ul>
    </div>
    <div class="space-4"></div> 
    <div class="col-md-12">        
            <ul class="nav nav-tabs">
                <li id="tab-1">
                    <a data-toggle="tab"> Daftar Background Job </a>
                </li>
                <li class="active">
                    <a data-toggle="tab"> Daemon Manager </a>
                </li>
            </ul>

            <br>
            <br>
            <div class="space-4"></div> 
            <div class="tab-content">
                <div class="tab-pane active">
                    <form class="form-horizontal" action="#" id="submit_form" method="POST">
                        <input type="hidden" class="form-control required" id="job" name="job" />

                        <div class="form-group">
                            <label class="control-label col-md-4">Procedure Name
                                <span> * </span>
                            </label>
                            
                            <div class="input-group col-md-4">
                                <input type="text" class="form-control" id="procedure_name" name="procedure_name" placeholder="Procedure Name" readonly />
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label col-md-4">Schema User
                                <span> * </span>
                            </label>
                            
                            <div class="input-group col-md-4">
                                <input type="text" class="form-control" id="schema_user" name="schema_user" placeholder="Schema User" readonly />
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label col-md-4">Last Date
                                <span> * </span>
                            </label>
                            
                            <div class="input-group col-md-4">
                                <input type="text" class="form-control" id="last_date" name="last_date" placeholder="Last Date" readonly />
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label col-md-4">Next Date
                                <span> * </span>
                            </label>
                            
                            <div class="input-group col-md-4">
                                <input type="text" class="form-control" id="next_date" name="next_date" placeholder="Next Date" readonly />
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-4"></div>
                            <div class="input-group col-md-8">
                                <i id="start_daemon" class="btn btn-primary"> Start Daemon </i>
                                <i id="force_process" class="btn btn-warning"> Force Process </i>
                                <i id="stop_daemon" class="btn btn-danger"> Stop Daemon </i>
                                <i id="refresh" class="btn btn-success"> Refresh </i>
                            </div>
                        </div>

                    </form>
                </div>
            </div>  


    </div>
    
</div>
<script>

    $(function($) {

        $("#tab-1").on( "click", function() {  
            loadContentWithParams("process.background_job", {});
        });
        
        $.ajax({
            type: 'POST',
            datatype: "json",
            url: '<?php echo WS_JQGRID."process.background_job_controller/read_daemon";?>',
            timeout: 10000,
            data: {},
            success: function(data) {      
             var response = JSON.parse(data);  
                if(response.success){
                    $('#job').val(response.data.job);
                    $('#procedure_name').val(response.data.procedure_name);
                    $('#schema_user').val(response.data.schema_user);
                    $('#last_date').val(response.data.last_date);
                    $('#next_date').val(response.data.next_date);
                    $('#start_daemon').hide();
                }else{
                    $('#start_daemon').show();
                    $('#force_process').hide();
                    $('#stop_daemon').hide();
                }
            }
        });

        $("#start_daemon").on( "click", function() {           
            $.ajax({
                url: '<?php echo WS_JQGRID."process.background_job_controller/start_daemon"; ?>',
                type: "POST",
                dataType: "json",
                data: {},
                timeout: 10000,
                success: function (data) {
                    if(data.success){
                        swal("", "Start Daemon success", "success");
                    }else{
                        swal("Informasi", "Start Daemon failed", "info"); 
                    }

                    loadContentWithParams("process.daemon_manager", {});
                },
                error: function (xhr, status, error) {
                    swal({title: "Error!", text: xhr.responseText, html: true, type: "error"});
                }
            });
        });

        $("#force_process").on( "click", function() {           
            $.ajax({
                url: '<?php echo WS_JQGRID."process.background_job_controller/force_scheduler"; ?>',
                type: "POST",
                dataType: "json",
                data: {},
                timeout: 10000,
                success: function (data) {
                    if(data.success){
                        swal("", "Start Daemon success", "success");
                    }else{
                        swal("Informasi", "Start Daemon failed", "info"); 
                    }

                    loadContentWithParams("process.daemon_manager", {});
                },
                error: function (xhr, status, error) {
                    swal({title: "Error!", text: xhr.responseText, html: true, type: "error"});
                }
            });
        });

        $("#stop_daemon").on( "click", function() {           
            $.ajax({
                url: '<?php echo WS_JQGRID."process.background_job_controller/stop_daemon"; ?>',
                type: "POST",
                dataType: "json",
                data: {},
                timeout: 10000,
                success: function (data) {
                    if(data.success){
                        swal("", "Start Daemon success", "success");
                    }else{
                        swal("Informasi", "Start Daemon failed", "info"); 
                    }

                    loadContentWithParams("process.daemon_manager", {});
                },
                error: function (xhr, status, error) {
                    swal({title: "Error!", text: xhr.responseText, html: true, type: "error"});
                }
            });
        });

        $("#refresh").on( "click", function() {           
            loadContentWithParams("process.daemon_manager", {});
        });

    });
    
</script>
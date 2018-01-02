
<link href='<?php echo base_url(); ?>assets/fullcalendar/fullcalendar.min.css' rel='stylesheet' />
<!-- <link href='<?php echo base_url(); ?>assets/fullcalendar/fullcalendar.print.min.css' rel='stylesheet' media='print' /> -->
<style type="text/css">
.datepicker,
.table-condensed {
  width: 300px;
  height:300px;
  font: bold;
}
.datepicker,th{
  font: bold;
}
</style>
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
<button type="button" class="btn default btn-xs" onclick="loadForm()">
    <i class="fa fa-arrow-left"></i> Back
</button>
<span  class="btn btn-default btn-xs" >
    <i class="fa fa-user" ></i>  <?php echo getVarClean('emp_name','str','');?> 
    <input type="hidden" name="emp_master_id" id="emp_master_id">
</span>


<div class="space-4"></div>
<h5>Add New Data Allowance</h5>
<div class="portlet " style="min-height:700px;">
        <div class="portlet-body form">
            <div class="form-body">
                <!--/row-->
                <div class="row">
                  <div class="col-md-4">
                      <div class="col-md-12">
                            <div class="form-group">
                                  <div class="col-md-12">
                                      <div class="datepickerformMultidate"></div>
                                      <input type="hidden" id="a_emp_master_id" name="emp_master_id">
                                  </div>
                              </div>
                          </div>
                          <div class="col-md-12">
                            <div class="form-group">
                                      <label class="control-label col-md-3"> </label>
                                      <div class="col-md-9">
                                          <button type="button" class="btn btn-default btn-xs" id="setAllData">
                                              <i class="fa fa-calendar-check-o"></i> Set All Data
                                          </button>
                                  </div>
                              </div>
                              <div class="form-group">
                                <label class="control-label col-md-2"> </label>
                                      <div class="col-md-10">
                                          <div class="btn-group">
                                              <button type="button" class="btn btn-default btn-xs" onclick="submitForm()">
                                                  <i class="fa fa-check"></i> Submit</button>
                                              <button type="button" class="btn btn-default btn-xs" onclick="reloadForm()">
                                                  <i class="fa fa-undo"></i> Reset  </button>
                                          </div>
                                  </div>
                              </div>
                              
                          </div>
                        </div>
                        <div class="col-md-8">
                          <!--  <span  class="btn btn-default btn-xs" >
                                <i class="fa fa-user" > </i>  Weekday : 0
                            </span>
                            <span  class="btn btn-default btn-xs" >
                                <i class="fa fa-user" > </i>  Weekend : 0
                            </span> -->

                          <div class="form-group">
                            <div class="col-md-12" id="dateCont">
                                <div class="table-scrollable">
                                    <table class="table table-bordered table-hover">
                                        <thead>
                                           
                                        </thead>
                                        <tbody id="tbDate">

                                        </tbody>
                                    </table>
                                </div>
                            </div>
                          </div>
                        </div>
                </div>
        </div>
</div>

<div class="space-4"></div>

<!-- <div class="row">
    <div class="col-md-4">
       <div id='calendar'></div>
    </div>
    <div class="col-md-2">
        <a href="javascript:;" class="btn btn-icon-only purple">
            <i class="fa " id="countDateSelected"></i>
        </a>
    </div>
</div> -->
<input type="hidden" id="dateContainer" name="date">
<input type="hidden" id="temp_corporate_id" >
<input type="hidden" id="emp_master_id" name="emp_master_id">

<?php $this->load->view('allowance/lov_allowance'); ?>

<script src='<?php echo base_url(); ?>assets/fullcalendar/lib/moment.min.js'></script>
<script src='<?php echo base_url(); ?>assets/fullcalendar/fullcalendar.min.js'></script>
<script type="text/javascript">


function setCaption(){
    $('#totalWeekend').html(0);
    $('#totalWeekday').html(0);
    weekday = $('.weekday').length;
    weekend = $('.weekend').length;
    $('#totalWeekend').html(weekend);
    $('#totalWeekday').html(weekday);
}
function submitForm(){
    jmlClass = $('.dateAllow').length;
    jmlSet  = $('.set').length;
    emp_master_id  = $('#emp_master_id').val().trim();
    if(jmlSet != jmlClass){
      swal({title: 'Info', text: 'Please Set All Data', html: true, type: "info"});
    }else{
      dataform = {}
      i =0;
      $('.dateAllow').each(function(){
        allowance_type_id = $(this).attr('allowance_type_id');
        description = $(this).attr('description');
        date = $(this).attr('valClass');
        dataform[i] = { allowance_dat:date, 
                        allowance_type_id:allowance_type_id,
                        description:description
                      };
        i++;
      });
      dataform = JSON.stringify(dataform);
      $.ajax({
        type: "POST",
        url: "<?php echo WS_JQGRID.'allowance.allowancebatchs_controller/submitDataForm'; ?>",
        data: { emp_master_id:emp_master_id, dataform:dataform},
        success: function (data) {
             //
             //ret = JSON.parse(data);
             swal({title: 'Info', text: 'Success', html: true, type: "info"});
            }
     });
    }
    
}
function loadDate(){
  start = $('#start_date').val();
  end = $('#end_date').val();
  $.ajax({
        type: "POST",
        url: "<?php echo WS_JQGRID.'allowance.allowancebatchs_controller/generateDate'; ?>",
        data: { start_date: start, end_date:end },
        success: function (data) {
             //swal({title: 'Info', text: 'Selesai, Step selanjutnya adalah mengisi data kontrak !', html: true, type: "info"});
             ret = JSON.parse(data);
             $('#tableDayBody').html('');
             $('#tableDayBody').html(ret.data);
             setCaption();
             //alert(ret.data);
            }
     });
}
function loadForm(){
            id = 'allowance.allowancebatchs';
            param = {};
            loadContentWithParams(id,param);
    }
function reloadForm(){
            id = 'allowance.allowancebatch_addform';
            param = {};
            loadContentWithParams(id,param);
    }
$(document).ready(function() {
    
    var emp_master_id  = "<?php echo getVarClean('emp_master_id','str','');?> ";
    var emp_name  = "<?php echo getVarClean('emp_name','str','');?> ";

    if(emp_master_id.length > 0 ){
      $('#emp_master_id').val(emp_master_id);
    }else{
      swal({title: 'warning', text: 'Please Choose Employee', html: true, type: "info"});
      loadForm();
    }

    $('#datePick').change(function(){
        dat = $(this).val();
        dat = dat.split(',');
        //alert(dat[dat.length-1]);
        for(i=0;i<=dat.length;i++){
          elem = '<span  class="btn btn-default btn-xs" >'+
               '<i class="fa fa-calendar-check-o" ></i> '+
               '<input type="hidden" name="emp_master_id" id="emp_master_id"></span>';
        }
        

    });
  /*  $('.datepickerformMultidate').on('dp.change', function(event) {
      //console.log(moment(event.date).format('MM/DD/YYYY h:mm a'));
      //console.log(event.date.format('MM/DD/YYYY h:mm a'));
      //$('#selected-date').text(event.date);
      alert();
      var formatted_date = event.date.format('MM/DD/YYYY h:mm a');
        $('#my_hidden_input').val(formatted_date);
      
      $('#hidden-val').text($('#my_hidden_input').val());
      $('#emp_master_id').val(formatted_date);
    });*/
    var objDate = {};
    $(".datepickerformMultidate").on("changeDate", function(event) {
        //console.log(event)
        //alert($(this).datepicker("getDate"))
        $("#a_emp_master_id").val(
            $(this).datepicker('getFormattedDate')
        )
        dat = $('#a_emp_master_id').val();
        if(dat.length <=10){
          if(dat.length > 0){
            countClass1 = $('.'+dat).length;
              if(countClass1 < 1){
                  elem = '<span  class="dateAllow '+dat+' btn btn-default btn-xs" valClass="'+dat+'" onclick="modal_allowance_show(\'oneDate\',\''+dat+'\')"  >'+
                     '<i class="fa fa-calendar-check-o" > </i>  '+dat+' </span>';
                     //alert(dat.length)
                    $('#tbDate').prepend(elem);
              }
          }
          
        }else{
            dat = $('#a_emp_master_id').val().split(',');
              for(i=0;i<dat.length;i++){
                countClass = $('.'+dat[i]).length;
                if(countClass < 1 ){
                  elem = '<span  class="dateAllow '+dat[i]+' btn btn-default btn-xs" valClass="'+dat[i]+'" onclick="modal_allowance_show(\'oneDate\',\''+dat[i]+'\')"  >'+
                         '<i class="fa fa-calendar-check-o" ></i> '+dat[i]+' </span>';
                  $('#tbDate').prepend(elem);
                }
              }
        }

        $('.dateAllow').each(function(){
          str = $(this).attr("valClass").trim();
          dataDate = $('#a_emp_master_id').val();
            if(dataDate.indexOf(str) < 0){
              $(this).remove();
              //alert(dataDate + ' | '+ str +' | '+dataDate.indexOf(str) )
            }
        });
        
    });
    $('.datepickerform').datepicker({
        format: 'dd-mm-yyyy',
        autoclose:true
      });
    var active_dates = ["21/12/2017","25/12/2017"];
      $('.datepickerformMultidate').datepicker({
          format: 'dd-mm-yyyy',
          autoclose:false,
          multidate:true, 
          daysOfWeekHighlighted: "0,6",
          todayBtn: true,
          todayHighlight: true,
          beforeShowDay: function(date){
           var d = date;
           var curr_date = d.getDate();
           var curr_month = d.getMonth() + 1; //Months are zero based
           var curr_year = d.getFullYear();
           var formattedDate = curr_date + "/" + curr_month + "/" + curr_year

             if ($.inArray(formattedDate, active_dates) != -1){
                 return {
                    classes: 'activeClass'
                 };
             }
            return;
          },
        
        });

      $('.datepickerformMultidate').datepicker().on('dp.change',function(e){
            console.log(e)
        })

    $('#setAllData').click(function(){
      
      if($('.dateAllow').length < 1){
        swal({title: 'warning', text: 'Please Choose Date', html: true, type: "warning"});
      }else{
        modal_allowance_show('1',1);
      }
      
    });

    $('.dateAllow').click(function(){
      
        id = $(this).attr('valClass');
        date = $(this).attr('valClass');
        msg = $(this).attr('message');
        modal_allowance_show('oneDate',id + '|' + date + '|' + msg);
    });

    $('#calendar').fullCalendar({
      //themeSystem:'united',
      header: {
        left: 'prev,next today',
        center: 'title',
        right: 'month,agendaWeek,agendaDay,listWeek'
      },
      dayClick: function(date, jsEvent, view) {

        /*alert('Clicked on: ' + date.format());

        alert('Coordinates: ' + jsEvent.pageX + ',' + jsEvent.pageY);

        alert('Current view: ' + view.name);*/
        if($(this).hasClass('dateClicked')){
            /*$(this).css('background-color', 'white');*/
            $(this).removeClass('dateClicked');
        }else{
            /*$(this).css('background-color', 'red');*/
            $(this).addClass('dateClicked');
            dateContainer = $('#dateContainer').val() + date.format() + '|';
        }
        $('#dateContainer').val(dateContainer);
        // change the day's background color just for fun
        $('#countDateSelected').html($('.dateClicked').length);

    },
       eventClick: function(calEvent, jsEvent, view) {

        alert('Event: ' + calEvent.title);
        alert('Coordinates: ' + jsEvent.pageX + ',' + jsEvent.pageY);
        alert('View: ' + view.name);

        // change the border color just for fun
        $(this).css('border-color', 'red');

    },
        eventRender: function (event, element) {
            element.attr('href', 'javascript:void(0);');
            element.click(function() {
                /*$("#startTime").html(moment(event.start).format('MMM Do h:mm A'));
                $("#endTime").html(moment(event.end).format('MMM Do h:mm A'));
                $("#eventInfo").html(event.description);
                $("#eventLink").attr('href', event.url);
                $("#eventContent").dialog({ modal: true, title: event.title, width:350});*/
                //alert(moment(event.start).format('MMM Do h:mm A'));
            });
        },
      defaultDate: '2017-12-12',
      navLinks: true, // can click day/week names to navigate views
      editable: true,
      eventLimit: true, // allow "more" link when too many events
      events: [
       /* {
          title: 'All Day Event',
          start: '2017-12-01',
        },
        {
          title: 'Long Event',
          start: '2017-12-07',
          end: '2017-12-10'
        },
        {
          id: 999,
          title: 'Repeating Event',
          start: '2017-12-09T16:00:00'
        },
        {
          id: 999,
          title: 'Repeating Event',
          start: '2017-12-16T16:00:00'
        },
        {
          title: 'Conference',
          start: '2017-12-11',
          end: '2017-12-13'
        },
        {
          title: 'Meeting',
          start: '2017-12-12T10:30:00',
          end: '2017-12-12T12:30:00'
        },
        {
          title: 'Lunch',
          start: '2017-12-12T12:00:00'
        },
        {
          title: 'Meeting',
          start: '2017-12-12T14:30:00'
        },
        {
          title: 'Happy Hour',
          start: '2017-12-12T17:30:00'
        },
        {
          title: 'Dinner',
          start: '2017-12-12T20:00:00'
        },
        {
          title: 'Birthday Party',
          start: '2017-12-13T07:00:00'
        },
        {
          title: 'Click for Google',
          url: 'http://google.com/',
          start: '2017-12-28'
        }*/
      ],
    });
  });
</script>
<style type="text/css">
    .fc-sun { background-color:#d5b8b3; }
    .fc-sat { background-color:#d5b8b3; }
    .fc-fri { background-color:#42b418; }
    .fc-day-number { font:bold }
    .dateClicked{background-color:#2997ae;}
</style>
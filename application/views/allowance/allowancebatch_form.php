
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
<button type="button" class="btn default" onclick="loadForm()">
    <i class="fa fa-arrow-left"></i> Back
</button>

<div class="space-4"></div>

<div class="portlet light bordered" style="min-height:700px;">
        <div class="portlet-title">
            <div class="caption">
                <i class="icon-equalizer font-red-sunglo"></i>
                <span class="caption-subject font-red-sunglo bold uppercase">Add New Data Allowance </span>
            </div>
        </div>
        <div class="portlet-body form">
          <form action="#" class="form-horizontal" id="form_data" method="post" enctype="multipart/form-data" accept-charset="utf-8">
            <div class="form-body">
                <!--/row-->
                <div class="row">
                  <div class="col-md-4">
                      <div class="col-md-12">
                              <div class="form-group">
                                  <label class="control-label col-md-3">Start Date</label>
                                  <div class="col-md-9">
                                  <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
                                      <input type="text" id="start_date" name="start_date" readonly required class="form-control datepickerform required"> 
                                      <input type="hidden" id="emp_master_id" name="emp_master_id">
                                  </div>
                              </div>
                          </div>
                          <div class="col-md-12">
                              <div class="form-group">
                                  <label class="control-label col-md-3">End Date </label>
                                  <div class="col-md-9">
                                      <input type="text" id="end_date" name="end_date"  readonly required class="form-control datepickerform required"> </div>
                              </div>
                          </div>
                          <div class="col-md-12">
                              <div class="form-group">
                                  <label class="control-label col-md-3">Generate </label>
                                  <div class="col-md-9">
                                      <button type="button" class="btn btn-default" onclick="loadDate()">
                                          <i class="fa fa-calendar-minus-o"></i> Generate
                                      </button>
                              </div>
                          </div>
                  </div>
                   <div class="col-md-12">
                          <div class="form-group">
                              <label class="control-label col-md-3">Weekday </label>
                              <div class="col-md-9">
                                  <button type="button" class="btn btn-default" id="totalWeekday">
                                      0
                                  </button>
                          </div>
                      </div>
                  </div>
                  <div class="col-md-12">
                          <div class="form-group">
                              <label class="control-label col-md-3">Weekend </label>
                              <div class="col-md-9">
                                  <button type="button" class="btn btn-danger" id="totalWeekend">
                                      0
                                  </button>
                          </div>
                      </div>
                  </div>
                  <div class="col-md-12">
                          <div class="form-group">
                              <label class="control-label col-md-3"> </label>
                              <div class="col-md-9">
                                  <button type="button" class="btn btn-default" id="setAllData">
                                      <i class="fa fa-calendar-check-o"></i> Set All Weekday
                                  </button>
                          </div>
                      </div>
                  </div>
                  <div class="col-md-12">
                          <div class="form-group">
                              <label class="control-label col-md-3"> </label>
                              <div class="col-md-9">
                                <select class="form-control required" required name="allowance_type" id="allowance_type">
                                  <?php echo getDataRef3('allowancetype');?>
                                </select>
                          </div>
                      </div>
                  </div>
                  <div class="col-md-12">
                          <div class="form-group">
                              <label class="control-label col-md-3"> </label>
                              <div class="col-md-9">
                                  <button type="button" class="btn btn-primary" id="totalWeekend">
                                      <i class="fa fa-calendar-check-o"></i> Submit
                                  </button>
                                  <button type="button" class="btn btn-default" id="totalWeekend" onclick="reloadForm()">
                                      <i class="fa fa-undo"></i> Reset
                                  </button>
                          </div>
                      </div>
                  </div>
                </div>
                <div class="col-md-8">
                    <div class="table-scrollable">
                          <table class="table table-bordered table-hover">
                              <thead>
                                  <tr class="active">
                                      <td width="10%" align="center"><b> # </b></td>
                                      <td width="20%" align="left"><b> DATE </b></td>
                                      <td width="20%" align="left"><b> DAY </b></td>
                                      <td width="20%" align="left"><b> STATUS </b></td>
                                      <td width="30%" align="left"><b> TPD </b></td>
                                      <td width="20%" align="center"><b> ACTION </b></td>
                                  </tr>
                              </thead>
                              <tbody id="tableDayBody">
                                  
                              </tbody>
                          </table>
                      </div>
                  </div>
                  </div>
                </form>
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
            id = 'allowance.allowancebatch_form';
            param = {};
            loadContentWithParams(id,param);
    }
$(document).ready(function() {

    $('.datepickerform').datepicker({
        format: 'dd-mm-yyyy',
        autoclose:true
      });

    var empmasterid = "<?php echo getVarClean('emp_master_id','int',0); ?>";
    $('#emp_master_id').val(empmasterid);
    
    $('#setAllData').click(function(){
      modal_allowance_show('1',1);
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
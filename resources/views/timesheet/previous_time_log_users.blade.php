@extends('layout.main')
@section('styles')
<!-- DataTables -->
<link rel="stylesheet" href="{{asset('plugins/datatables/dataTables.bootstrap.css')}}">
<link rel="stylesheet" href="{{asset('plugins/datepicker/datepicker3.css')}}">

@endsection
@section('content')


<div class="box-body">

  <div class="row">

    {!! Form::open(array('id'=>'search_form', )) !!}
    <div class="col-md-3">
      <div class="form-group">
        <label>Start Date</label>

        <div class="input-group date">
          <div class="input-group-addon">
            <i class="fa fa-calendar"></i>
          </div>
          <input type="text" class="form-control pull-right onchange" name="start_date" data-date-format="dd-mm-yyyy" id="start-date" placeholder="Start Date">
        </div>
        <!-- /.input group -->
      </div>
    </div>

    <div class="col-md-3">
      <div class="form-group">
        <label>End Date</label>

        <div class="input-group">
          <div class="input-group-addon">
            <i class="fa fa-calendar"></i>
          </div>
          <input type="text" class="form-control pull-right onchange" name="end_date" data-date-format="dd-mm-yyyy" id="end-date" placeholder="End Date">
        </div>
        <!-- /.input group -->
      </div>
    </div>

    <div class="col-md-4"style="padding-top:24px;" >
     <div class="form-group">
      <button type="submit" class="btn  btn-success" id="search-query">Search</button>
    </div>
  </div>
  {!! Form::close() !!}

</div>


<div class="row">
  <div class="col-xs-12">
    <div class="box">
      <div class="box-header">
        <h3 class="box-title">Previous Time Log</h3>
      </div>
      <!-- /.box-header -->
      <div class="box-body">
        <table id="chart-of-account" class="table table-bordered table-hover">
          <thead>
            <tr>
              <th>Project Name</th>
              <th>Date</th>
              <th>Star time</th>
              <th>End time</th>
              <th>Activity</th>
              <th>Options</th>
            </tr>
          </thead>
          <tbody>

          </tbody>
          <tfoot>
            <tr>
              <th>Project Name</th>
              <th>Date</th>
              <th>Star time</th>
              <th>End time</th>
              <th>Activity</th>
              <th>Options</th>
            </tr>
          </tfoot>
        </table>
      </div>
      <!-- /.box-body -->
    </div>
    <!-- /.box -->
  </div>
  <!-- /.col -->
</div>






</div>





@endsection
@section('script')


<script src="{{asset('dist/js/utils.js')}}"></script>
<script src="{{asset('plugins/datatables/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('plugins/datepicker/bootstrap-datepicker.js')}}"></script>

<script >


$('#start-date').datepicker({

  autoclose: true

});

$('#end-date').datepicker({

  autoclose: true

});



$('#search_form').submit(function( event ){

  event.preventDefault();

  var not_empty = true;

  var start_date=  $("#start-date").datepicker({ dateFormat: 'dd-mm-yy' }).val();

  var end_date=$("#end-date").datepicker({ dateFormat: 'dd-mm-yy' }).val();

  if(start_date!="" && end_date!=""){
    not_empty = true;
  }else{
    not_empty = false;
  }


  

  if(not_empty){

    var startDate=  $("#start-date").datepicker('getDate');
    var endDate=$("#end-date").datepicker('getDate');

    console.log("teistn");

    //
    if(calcDaysBetween(startDate, endDate) < 0){
      alert("dates are not properly set please check!");
      return;
    };




    var table = $('#chart-of-account').DataTable( {
      "processing": true,
        "serverSide": true,
      "bDestroy": true,
      "ajax": "{{URL::to('/')}}/timesheet/previous_details_time_log_users/"+start_date+"/"+end_date,
      "columns": [
      { "data": "project_name" },
      { "data": "date" },
      { "data": "start_time" },
      { "data": "end_time" },
      { "data": "activity" },
      { "data": "action", name: 'action', orderable: false, searchable: false}
      ],
      "order": [[1, 'asc']]
    } );

  }else{
    alert("please set the dates!");
    return;
  } 


});

</script>
@endsection



























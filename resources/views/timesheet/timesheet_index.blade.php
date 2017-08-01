	@extends('layout.main')
  @section('styles')
  <!-- DataTables -->
  <link rel="stylesheet" href="{{asset('plugins/datatables/dataTables.bootstrap.css')}}">
  <link rel="stylesheet" href="{{asset('plugins/datepicker/datepicker3.css')}}">
  @endsection

  @section('content')

  <section class="content">
    <!-- SELECT2 EXAMPLE -->
    <div class="box box-default">
      <div class="box-header with-border">
        <h3 class="box-title">Time Sheet Log</h3>

        <div class="box-tools pull-right">
          <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
          <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-remove"></i></button>
        </div>
      </div>

      <div class="box-body">
        <div class="row">
          <div class="col-md-3">

           <div class="form-group">
            <label>Please select one of the projects</label>
            <select id="project-id" name="project_id"  style="width: 100%;" class="col-lg-8 form-control" >

              @if(isset($project_list))
              @foreach($project_list as $project)
              <option value="{{$project->project_id}}">{{$project->project_name}}</option>
              @endforeach
              <option value="all">All</option>
              @else
              <option value="-1">No projecs has been assigned for you yet</option>
              @endif

            </select>
          </div>

        </div>
        <!-- /.col -->

        <div class="col-md-2">
          <div class="form-group">
            <label>Start date</label>

            <div class="input-group date">
              <div class="input-group-addon">
                <i class="fa fa-calendar"></i>
              </div>
              <input type="text" class="form-control pull-right onchange" name="start_date"
              data-date-format="dd-mm-yyyy" id="start-date" placeholder="start">
            </div>
            <!-- /.input group -->
          </div>
        </div>

        <div class="col-md-2">
          <div class="form-group">
            <label>End date</label>

            <div class="input-group date">
              <div class="input-group-addon">
                <i class="fa fa-calendar"></i>
              </div>
              <input type="text" class="form-control pull-right onchange" name="end_date"
              data-date-format="dd-mm-yyyy" id="end-date" placeholder="end">
            </div>
            <!-- /.input group -->
          </div>
        </div>

        <div class="col-md-1">
          <div class="form-group">

            <button type="submit" id="project-select-id" class="btn btn-primary" style="margin-top: 25px">Show logs</button>

          </div>
        </div>
        
        <div class="col-md-1">
          <div class="form-group">

            <a href="{{URL::to('/')}}/timesheet/old_time_logs_users">

              <button type="button"  class="btn btn-success" style="margin-top: 25px">Previous/submitted logs</button>
            </a>
          </div>
        </div>

      </div>
      <!-- /.row -->

      <div class="box-body">
        <table id="time-sheet-log" class="table table-bordered table-hover">
          <thead>
            <tr>
              <th>Project Name</th>
              <th>Date</th>
              <th>Time</th>
              <th>Activity</th>
              <th>Edit</th>

            </tr>
          </thead>
          <tbody>

          </tbody>
          <tfoot>
            <tr>
              
            </tr>
          </tfoot>
        </table>
      </div>

      {!! Form::open(array('url'=>'/timesheet/send_to_linemanager', 'id'=>'participant-form')) !!}

      <div class="form-group">

        <button type="submit" id="time_sheet" class="btn btn-primary">Submit</button>

      </div>

      {!! Form::close() !!}
      
    </div>
    
    <!-- /.box-body -->


  </div>
  <!-- /.box -->
</section>

@if (count($errors) > 0)
<div class="alert alert-danger">
  <ul>
    @foreach ($errors->all() as $error)
    <li>{{ $error }}</li>
    @endforeach
  </ul>
</div>
@endif
@endsection



@section('script')

<script src="{{asset('plugins/datatables/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('plugins/datatables/dataTables.bootstrap.min.js')}}"></script>
<script src="{{asset('plugins/datepicker/bootstrap-datepicker.js')}}"></script>
<script src="{{asset('dist/js/utils.js')}}"></script>
<script type="text/javascript">
$( document ).ready(function() {

  $('#start-date').datepicker({
    autoclose: true

  });
  $('#end-date').datepicker({
    autoclose: true

  });

  var table;

  $( "#project-select-id" ).click(function() {

    event.preventDefault();

    var project_id = $('#project-id').val();

    var start_date = $("#start-date").datepicker({ dateFormat: 'dd-mm-yy' }).val();

    var end_date = $("#end-date").datepicker({ dateFormat: 'dd-mm-yy' }).val();

    var start_date_1=  $("#start-date").datepicker('getDate');
    var end_date_1=$("#end-date").datepicker('getDate');

    
    if(start_date=="" || end_date==""){
      alert("please select a start date and an end date");
      return;
    }


    if(calcDaysBetween(start_date_1, end_date_1) < 0){
      alert('"start" date cannot be more than "end" date');
      return;
    }

    if(project_id == -1){

      alert("It looks like you have not been assigned any projects yet.");

      return;

    }else{

      table = $('#time-sheet-log').DataTable( {
        "processing": true,
        "serverSide": true,
        "bDestroy": true,
        "paging": false,
        "lengthChange": true,
        "searching": true,
        "ordering": true,
        "info": true,
        "autoWidth": false,
        "scrollX": true,
        "bDestroy": true,
        "ajax": "{{URL::to('/')}}/timesheet/project_details_for_timesheet/"+project_id+"/"+start_date+"/"+end_date,
        "columns": [
        { "data": "project_name" },
        { "data": "date" },
        { "data": "time_spent" },
        { "data": "activity" }, 
        { "data": "action", name: 'action', orderable: false, searchable: false}
        ],
        "order": [[1, 'asc']]
      } );
      


    }

  });


  $( "#participant-form" ).submit(function(event){

    event.preventDefault();

    var array = [],count = 0;

    if(table === undefined){

      alert("please select a project first");

      return;

    }


    table.rows().every( function ( rowIdx, tableLoop, rowLoop ) {
      var data = this.data();

      array[count] = data['id'];

      count++;
      

    });

    var $form = $( this ),
    url = $form.attr( "action" ),
    token = $("[name='_token']").val();

    $.post( url, {'array_time_log':array, '_token': token }, function( data ) {

    }).done(function() {

      alert("your time sheet has been sent to your line manager!");

      location.reload();

      // window.location.assign('{{URL::to('/')}}/set_trainer');
    });


  });


});




  </script>
  @endsection



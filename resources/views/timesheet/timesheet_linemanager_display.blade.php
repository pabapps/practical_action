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
        <h3 class="box-title">Time sheet log for managers</h3>

        <div class="box-tools pull-right">
          <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
          <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-remove"></i></button>
        </div>
      </div>

      <div class="box-body">
        <div class="row">
          <div class="col-md-6">

           <div class="form-group">
            <label>Please select one of the users</label>
            <select id="user-id" name="user_id"  style="width: 100%;" class="col-lg-8 form-control select2" >

            </select>
          </div>

        </div>
        <!-- /.col -->

        <div class="col-md-3">
          <div class="form-group">
            <label>Month</label>

            <div class="input-group date">
              <div class="input-group-addon">
                <i class="fa fa-calendar"></i>
              </div>
              <input type="text" class="form-control pull-right onchange" name="start_date" data-date-format="dd-mm-yyyy" id="month" placeholder="Month">
            </div>
            <!-- /.input group -->
          </div>
        </div>

        <div class="col-md-1">
          <div class="form-group">

            <button type="submit" id="user-select-id" class="btn btn-primary" style="margin-top: 25px">Show log</button>

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
              <th>Star time</th>
              <th>End time</th>
              <th>Activity</th>
              <th>Edit</th>

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
              <th>Edit</th>

            </tr>
          </tfoot>
        </table>
      </div>

      {!! Form::open(array('url'=>'/timesheet/submit_to_accounts_manager', 'id'=>'participant-form')) !!}

      <div class="form-group">

        <button type="submit" id="time-sheet-submit" class="btn btn-primary">Submit</button>

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

<script type="text/javascript">
$( document ).ready(function() {

  $('#month').datepicker({

     format: "mm-yyyy",
    startView: "months", 
    minViewMode: "months",

    autoclose: true

  });


  $('#user-id').select2({
    placeholder: 'Select an option',
    ajax: {
      dataType: 'json',
      url: '{{URL::to('/')}}/timesheet/get_submitted_users',
      delay: 250,
      data: function(params) {
        return {
          term: params.term
        }
      },
      processResults: function (data, params) {
        params.page = params.page || 1;
        return {
          results: data
        };
      },
    }
  });

  var table;

  $( "#user-select-id" ).click(function() {

    event.preventDefault();

    var user_id = $('#user-id').val();

    var month = $("#month").datepicker({ dateFormat: 'dd-mm-yy' }).val();

    if(user_id == null || month == ""){

      alert("OPS! please select an user and the month.");

      return;

    }else{

      table = $('#time-sheet-log').DataTable( {
        "processing": true,
        "serverSide": true,
        "bDestroy": true,
        "ajax": "{{URL::to('/')}}/timesheet/time_log_for_submitted_users/"+user_id+"/"+month,
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
      


    }

  });


  $( "#participant-form" ).submit(function(event){

    event.preventDefault();

    var array = [],count = 0;

    if(table === undefined){

      alert("please fill the table first");

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

      // /alert("your time sheet has been sent to the accounts manager!");

      // location.reload();

      
    });

  });











});




  </script>
  @endsection



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
          <div class="col-md-3">

           <div class="form-group">
            <label>Please select one of the users</label>
            <select id="user-id" name="user_id"  style="width: 100%;" class="col-lg-8 form-control select2" >

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

            <button type="submit" id="user-select-id" class="btn btn-primary" style="margin-top: 25px">Show log</button>

          </div>
        </div>

        <div class="col-md-1">
          <div class="form-group">

            <a href="{{URL::to('/')}}/timesheet/lineManager_to_accountManager">

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
              <th>Id</th>
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

      {!! Form::open(array('url'=>'/timesheet/submit_to_accounts_manager', 'id'=>'participant-form')) !!}
      <div class="col-md-1">
        <div class="form-group">

          <button type="submit" id="time-sheet-submit" class="btn btn-primary">Submit</button>

        </div>
      </div>

      {!! Form::close() !!}

      {!! Form::open(array('url'=>'/timesheet/linemanager_refer_back_subordinate', 'id'=>'reverse-form')) !!}
      <div class="col-md-1">
        <div class="form-group">

          <button type="submit" id="time-sheet-submit" class="btn btn-danger">Send Back</button>

        </div>
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

    var table = $('#time-sheet-log').DataTable( {});

    $( "#user-select-id" ).click(function() {

      event.preventDefault();

      var user_id = $('#user-id').val();


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

      if(user_id == null ){

        alert("OPS! please select an user and the month.");

        return;

      }else{

       table.clear().draw();

       var jqxhr = $.get("{{URL::to('/')}}/timesheet/time_log_for_submitted_users", {user_id: user_id ,start_date: start_date,end_date:end_date }, function(time_sheet_log){

        var object = JSON.parse(time_sheet_log);

        for (var i = 0; i < object.length; i++) {

          table.row.add( [
            object[i].id,
            object[i].project_name,
            object[i].date,
            object[i].time_spent,
            object[i].activity,
            '<a href="{{URL::to('/')}}/timesheet/'+object[i].id+'/edit" class="btn btn-primary btn-danger"><i class="glyphicon   glyphicon-list"></i> Details</a>'
            ] ).draw( false );



        }

      });

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

        array[count] = data[0];

        count++;


      });


      var $form = $( this ),
      url = $form.attr( "action" ),
      token = $("[name='_token']").val();

      $.post( url, {'array_time_log':array, '_token': token }, function( data ) {

      }).done(function() {

        // alert("your time sheet has been sent to the accounts manager!");

        // location.reload();


      });

    });


    $( "#reverse-form" ).submit(function(event){

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

      if(count==0){
        alert("sorry!! you cananot submit the table without any data");
        return;
      }

      var $form = $( this ),
      url = $form.attr( "action" ),
      token = $("[name='_token']").val();

      $.post( url, {'array_time_log':array, '_token': token }, function( data ) {

      }).done(function() {

        alert("The time sheet has been sent back for correction!");

        location.reload();


      });

    });











  });




</script>
@endsection



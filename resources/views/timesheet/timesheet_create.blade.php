	@extends('layout.main')
  @section('styles')
  <!-- DataTables -->
  <link rel="stylesheet" href="{{asset('plugins/datatables/dataTables.bootstrap.css')}}">
  <link rel="stylesheet" href="{{asset('plugins/daterangepicker/daterangepicker-bs3.css')}}">
  <link rel="stylesheet" href="{{asset('plugins/datepicker/datepicker3.css')}}">
  <link rel="stylesheet" href="{{asset('plugins/timepicker/bootstrap-timepicker.min.css')}}">
  @endsection
  @section('content')

  <section class="content">
    <!-- SELECT2 EXAMPLE -->
    <div class="box box-default">
      <div class="box-header with-border">
        <h3 class="box-title">Time Sheet</h3>

        <div class="box-tools pull-right">
          <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
          <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-remove"></i></button>
        </div>
      </div>


      <div class="box-body">
        <div class="row">
          <div class="col-md-6">

           <div class="form-group">
            <label>Name</label>
            @if(isset($user_info->id))
            <input type="text" class="form-control" name="name" id="name"  value="{{$user_info->name}}" readonly>   
            @endif
          </div>

        </div>
        <!-- /.col -->
        <div class="col-md-6">
          <div class="form-group">
            <label>Designation</label>
            @if(isset($user_info->id))
            <input type="text" class="form-control" name="project_code" id="project-code"  value="{{$user_info->position_name}}" readonly>   
            @endif
          </div>

        </div>
        <!-- /.col -->
      </div>
      
    </div>
    <!-- /.box-body -->
  </div>
  <div class="box">
    <div class="box-header">
      <h3 class="box-title">Projects</h3>
    </div>
    <!-- /.box-header -->
    <div class="box-body">
      <table id="time-sheet-table" class="table table-bordered table-striped">
        <thead>
          <tr>
            <th>Projects</th>
            <th>Allocated Time(days)</th>
            <th>Allocated Time(hours)</th>
            <th>Remaining Time (hours)</th>
          </tr>
        </thead>
        <tbody>

          @if(isset($final_array))
          @foreach($final_array as $projects)
          <tr>
            <td>{{$projects['project_name']}}</td>
            <td>{{$projects['allocated_days']}}</td>
            <td>{{$projects['allocated_time']}}</td>
            <td>{{$projects['final_deducted_time']}}</td>
          </tr>
          @endforeach
          @else
          @foreach($user_projects as $projects)
          <tr>
            <td>{{$projects->project_name}}</td>
            <td>{{$projects->allocated_days}}</td>
            <td>{{$projects->allocated_time}}</td>
            <td>--</td>
          </tr>
          @endforeach
          @endif
        </tbody>
        <tfoot>
          <tr>
          </tr>
        </tfoot>
      </table>
      <div class="form-group">


        <!-- <button type="submit" class="btn bg-navy btn-flat margin">.btn.bg-navy.btn-flat</button> -->
        <button type="submit" data-toggle="modal" class="btn bg-purple btn-flat margin" data-target="#add-new-entry">Save new entry</button>

      </div>
    </div>
    <!-- /.box-body -->
  </div>
  <!-- /.box -->
  
  <div class="modal fade" id="add-new-entry" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header" style="border-bottom: 0px;height: 50px;">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
          <h3 class="modal-title">create new time sheet entry</h3>
        </div>

        {!! Form::open(['method'=>'POST', 'action'=>['TimeSheetController@store'], 'id'=>'time-sheet-form']) !!}

        <div class="modal-body">
          <div class="form-group" >
            <label>Project Name</label>
            <select id="project-name-modal" name="project_name_modal"  class="form-control " required>
              @if(isset($user_projects))
              @foreach($user_projects as $project)
              <option value="{{$project->project_id}}">{{$project->project_name}} </option>
              @endforeach
              @endif
              
            </select>
          </div>

          <div class="form-group">
            <label>Date:</label>

            <div class="input-group date">
              <div class="input-group-addon">
                <i class="fa fa-calendar"></i>
              </div>
              <input type="text" class="form-control pull-right" name="entry_date" data-date-format="dd-mm-yyyy" id="entry-date" required>
            </div>
            <!-- /.input group -->
          </div>

          <div class="form-group">
            <label>Time</label>
            <select id="time-sheet" name="time_sheet"  class="form-control" required>
              <option value="3000">30 mins</option>
              <option value="010000">1 hour</option>
              <option value="013000">1 hour 30 mins</option>
              <option value="020000">2 hours</option>
              <option value="023000">2 hours 30 mins</option>
              <option value="030000">3 hours</option>
              <option value="033000">3 hours 30 mins</option>
              <option value="040000">4 hours</option>
              <option value="043000">4 hours 30 mins</option>
              <option value="050000">5 hours</option>
              <option value="053000">5 hours 30 mins</option>
              <option value="060000">6 hours</option>
              <option value="063000">6 hours 30 mins</option>
              <option value="070000">7 hours</option>
              <option value="073000">7 hours 30 mins</option>
              <option value="080000">8 hours</option>
            </select>
          </div>

          <div class="form-group">
            <label>Activity</label>
            <select id="activity" name="activity"  class="form-control" required>
              <option value="Project Management">Project Management</option>
              <option value="Financial/Grants management">Financial/Grants management</option>
              <option value="Communicaiton/Documentation">Communication/Documentation</option>
              <option value="Knowledge mgt">Knowledge mgt</option>
              <option value="meeting">Meeting</option>
              <option value="Workshop/Training">Workshop/Training</option>
              <option value="Exposure visit">Exposure visit</option>
              <option value="Field visit">Field visit</option>
              <option value="It support">It support</option>
              <option value="Administrative work">Adminstrative work</option>
              <option value="Logistic support">Logistic support</option>
              <option value="HR management">HR management</option>
              <option value="Monitoring">Monitoring</option>
            </select>
          </div>

          <div class="form-group">
            <label>Location</label>
            <input type="text" id="location-modal" name="location_modal" class="form-control" placeholder="Dhaka...." required>
          </div>

          <div class="form-group">
            <label>Remarks</label>
            <input type="text" id="remarks-modal"name="remarks_modal" class="form-control" placeholder="a short description of what you did.....(optional)">
          </div>

          <div class="form-group hidden">
            <label>User id</label>
            @if(isset($user_info->id))
            <input type="text" class="form-control" name="user_id" id="user-id"  value="{{$user_info->id}}" readonly>   
            @endif
          </div>


        </div>

        <div class="modal-footer">
          <div class="col-lg-12 entry_panel_body ">
            <h3></h3>
            <button type="submit" class="btn btn-primary">Submit</button>
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          </div>
        </div>
        {!! Form::close() !!}

      </div>
    </div>
  </div>

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
<script src="{{asset('plugins/daterangepicker/daterangepicker.js')}}"></script>
<script src="{{asset('plugins/datepicker/bootstrap-datepicker.js')}}"></script>
<script src="{{asset('plugins/timepicker/bootstrap-timepicker.min.js')}}"></script>

<script type="text/javascript">
$( document ).ready(function() {


  $("#time-sheet-table").DataTable();

  $('#entry-date').datepicker({
    autoclose: true

  });

  $("#entry-date").datepicker('setDate', new Date());
  
  $( "#time-sheet-form" ).submit(function( event ) {
    // Stop form from submitting normally
    
    event.preventDefault();
    
    console.log("testing");

    var $form = $( this ),
    url = $form.attr( "action" );

    // Send the data using post
    var posting = $.post( url, $form.serialize() );
    // Put the results in a div
    posting.done(function( data ) {

      $('#add-new-entry').modal('toggle');

      // location.reload();
      window.location.assign('{{URL::to('/')}}/timesheet/create');

    });

    


  });


});




</script>
@endsection



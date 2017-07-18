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
        <h3 class="box-title">Time Sheet Edit</h3>

        <div class="box-tools pull-right">
          <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
          <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-remove"></i></button>
        </div>
      </div>

      {!! Form::open(array('route' => array('timesheet.update', $time_sheet_data->id), 'id' => 'project-edit-form', 'method'=>'PUT')) !!}

      <div class="box-body">
        <div class="row">
          <div class="col-md-6">

           <div class="form-group">
            <label>Project Name</label>
            <input type="text" class="form-control" name="project_name" id="project-name" value="{{$project->project_name}}" readonly>   
          </div>

        </div>
        <!-- /.col -->


        <div class="col-md-6">
          <div class="form-group">
            <label>Date:</label>

            <div class="input-group date">
              <div class="input-group-addon">
                <i class="fa fa-calendar"></i>
              </div>
              <input type="text" class="form-control pull-right" name="entry_date" data-date-format="dd-mm-yyyy" id="entry-date" value="{{$date}}" required>
            </div>
            <!-- /.input group -->
          </div>
        </div>

        
        <div class="col-md-6">
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
              <option value="083000">8 hours 30 mins</option>
              <option value="090000">9 hours</option>
              <option value="093000">9 hours 30 mins</option>
              <option value="100000">10 hours </option>
              <option value="103000">10 hours 30 mins</option>
              <option value="110000">11 hours </option>
              <option value="113000">11 hours 30 mins</option>
              <option value="120000">12 hours </option>
            </select>
          </div>
        </div>

        <div class="col-md-6">
          <div class="form-group">
            <label>Activity</label>
            <select id="activity" name="activity"  class="form-control" required>
              <option value="{{$time_sheet_data->activity}}" selected >{{$time_sheet_data->activity}}</option>
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
       </div>

       <div class="col-md-6">
        <div class="form-group">
          <label>Location</label>
          <input type="text" id="location-modal" name="location_modal" class="form-control" placeholder="Dhaka...." value="{{$time_sheet_data->location}}" required>
        </div>
      </div>

      <div class="col-md-6">
        <div class="form-group">
          <label>Remarks</label>
          <input type="text" id="remarks-modal"name="remarks_modal" class="form-control" placeholder="a short description of what you did.....(optional)" value="{{$time_sheet_data->remarks}}">
        </div>
      </div>

      <div class="form-group hidden">
        <label>User id</label>
        @if(isset($user_id))
        <input type="text" class="form-control" name="user_id" id="user-id"  value="{{$user_id}}" readonly>   
        @endif
      </div>

      <div class="form-group hidden">


        <input type="text" class="form-control" name="user_timesheet" id="user-timesheet"  value="1" readonly>   

      </div>

      <!-- /.col -->
    </div>
    <!-- /.row -->
    @if($time_sheet_data->sent_to_manager != 0)
    <div class="form-group hidden">

      <button type="submit" class="btn btn-primary">Update</button>

    </div>
    @else
    <div class="form-group">

      <button type="submit" class="btn btn-primary">Update</button>

    </div>
    @endif

  </div>
  {!! Form::close() !!}
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
<script src="{{asset('plugins/daterangepicker/daterangepicker.js')}}"></script>
<script src="{{asset('plugins/datepicker/bootstrap-datepicker.js')}}"></script>
<script src="{{asset('plugins/timepicker/bootstrap-timepicker.min.js')}}"></script>

<script type="text/javascript">
$( document ).ready(function() {


  $('#entry-date').datepicker({
    autoclose: true

  });

  






});




</script>
@endsection



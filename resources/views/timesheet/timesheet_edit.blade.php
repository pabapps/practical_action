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
            <label>Project Code</label>
            <input type="number" class="form-control" name="project_code" id="project-code" placeholder="please enter the code" value="{{old('project_code')}}" required>   
          </div>

        </div>


        <div class="col-md-6">
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
        </div>

        <div class="col-md-6">
           <div class="bootstrap-timepicker ">
            <div class="form-group">
              <label>Start Time:</label>

              <div class="input-group">
                <input type="text" class="form-control timepicker" id="start-time" name="start_time" required>

                <div class="input-group-addon">
                  <i class="fa fa-clock-o"></i>
                </div>
              </div>
              <!-- /.input group -->
            </div>
          </div>
        </div>
        
        <div class="col-md-6">
          <div class="bootstrap-timepicker ">

            <div class="form-group">
              <label>End Time:</label>

              <div class="input-group">
                <input type="text" class="form-control timepicker" id="end-time" name="end_time" required>

                <div class="input-group-addon">
                  <i class="fa fa-clock-o"></i>
                </div>
              </div>
              <!-- /.input group -->
            </div>

          </div>
        </div>

        <div class="col-md-6">
          <div class="form-group">
            <label>Activity</label>
            <select id="activity" name="activity"  class="form-control" required>
              <option value="project management">Project Management</option>
              <option value="monitoring evalution">Monitoring & Evalution</option>
              <option value="field visit">Field visit</option>
              <option value="training">Training</option>
              <option value="meeting (outside office)">Meeting (Outside Office)</option>
              <option value="meeting (inside office)">Meeting (Inside Office)</option>
            </select>
          </div>
        </div>

        <div class="col-md-6">
          <div class="form-group">
            <label>Location</label>
            <input type="text" id="location-modal" name="location_modal" class="form-control" placeholder="Dhaka...." required>
          </div>
        </div>

        <div class="col-md-6">
          <div class="form-group">
            <label>Remarks</label>
            <input type="text" id="remarks-modal"name="remarks_modal" class="form-control" placeholder="a short description of what you did.....(optional)">
          </div>
        </div>

        <div class="form-group hidden">
            <label>User id</label>
            @if(isset($user_info->id))
            <input type="text" class="form-control" name="user_id" id="user-id"  value="{{$user_info->id}}" readonly>   
            @endif
          </div>

        <!-- /.col -->
      </div>
      <!-- /.row -->
      <div class="form-group">

        <button type="submit" class="btn btn-primary">Update</button>

      </div>
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

  $("#entry-date").datepicker('setDate', new Date());

  $("#start-time").timepicker({
    showMeridian:false,
    showSeconds:true,
    showInputs: false
  });

  $("#end-time").timepicker({
    showMeridian:false,
    showSeconds:true,
    showInputs: false
  });






});




</script>
@endsection



	@extends('layout.main')
	@section('content')

	<section class="content">
		<!-- SELECT2 EXAMPLE -->
    <div class="box box-default">
      <div class="box-header with-border">
        <h3 class="box-title">Create New Project</h3>

        <div class="box-tools pull-right">
          <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
          <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-remove"></i></button>
        </div>
      </div>

      {!! Form::open(array('route'=>'projects.store', 'files'=>true, 'id'=>'customer_form')) !!}

      <div class="box-body">
        <div class="row">
          <div class="col-md-6">

           <div class="form-group">
            <label>Name</label>
            <input type="text" class="form-control" name="program_name" id="program-name" placeholder="Name of the program" value="{{old('program_name')}}" required>   
          </div>

          <div class="form-group">
            <label>Start date:</label>

            <div class="input-group date">
              <div class="input-group-addon">
                <i class="fa fa-calendar"></i>
              </div>
              <input type="text" class="form-control pull-right" name="start_date" data-date-format="dd-mm-yyyy" id="start-date" placeholder="joining date" >
            </div>
            <!-- /.input group -->
          </div>

        </div>
        <!-- /.col -->
        <div class="col-md-6">
          <div class="form-group">
            <label>Project Code</label>
            <input type="text" class="form-control" name="project_code" id="project-code" placeholder="please enter the code" value="{{old('project_code')}}" required>   
          </div>

          <div class="form-group">
            <label>End date:</label>

            <div class="input-group date">
              <div class="input-group-addon">
                <i class="fa fa-calendar"></i>
              </div>
              <input type="text" class="form-control pull-right" name="end_date" data-date-format="dd-mm-yyyy" id="end-date" placeholder="joining date" >
            </div>
            <!-- /.input group -->
          </div>

        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
      <div class="form-group">

        <button type="submit" class="btn btn-primary">Submit</button>

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
<script src="{{asset('dist/js/utils.js')}}"></script>
<script src="{{asset('plugins/datepicker/bootstrap-datepicker.js')}}"></script>
<script src="{{asset('plugins/timepicker/bootstrap-timepicker.min.js')}}"></script>

<script type="text/javascript">
$( document ).ready(function() {


  $('#start-date').datepicker({
    autoclose: true

  });

  $('#end-date').datepicker({
    autoclose: true

  });




});




</script>
@endsection



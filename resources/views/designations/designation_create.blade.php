	@extends('layout.main')
	@section('content')

	<section class="content">
		<!-- SELECT2 EXAMPLE -->
    <div class="box box-default">
      <div class="box-header with-border">
        <h3 class="box-title">Create a new designation</h3>

        <div class="box-tools pull-right">
          <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
          <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-remove"></i></button>
        </div>
      </div>
      <!-- /.box-header -->


      {!! Form::open(array('route'=>'designation.store', 'files'=>true, 'id'=>'designation-create-form')) !!}


      <div class="box-body">
        <div class="row">
          <div class="col-md-6">

           <!-- product type -->

           <div class="form-group">
            <label>Name of the Designation</label>
            <!-- <input type="text" class="form-control" name="sales_name" id="sales-name" placeholder="Enter sales center name" required>    -->
            <div class="row">
              <div class="col-lg-11" style="padding-right:0;">
                <input type="text" class="form-control" name="designation_name" id="designation-name" placeholder="Enter the designation" required>
              </div>
            </div>
          </div>

        </div>
        <!-- /.col -->
        <div class="col-md-6">  
          <div class="form-group">

            <label>Department Name</label>
            <div class="row">
              <div class="col-lg-11 " style="padding-right:0;">
                <input type="text" class="form-control" name="department_name" id="department-name" placeholder="Enter the department" required>   
              </div>
            </div>
          </div>
        
          
          <!-- coa_id -->
          
             

        <!-- /.form-group -->
      </div>
      <!-- /.col -->
    </div>
    <!-- /.row -->
    <div class="form-group">
      <!-- description -->

      <button type="submit" class="btn btn-primary center-block btn-flat">Submit</button>
    </div>
  </div>
  {!! Form::close() !!}
  <!-- /.box-body -->

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
<script src="{{asset('dist/js/utils.js')}}"></script>
<script type="text/javascript">
$( document ).ready(function() {

 

  

  $("#designation-create-form").validate({
   rules: {
    // simple rule, converted to {required:true}
    designation_name: {"required":true, "minlength": 2},
    department_name: {"required":true, "minlength": 2},
    
    // compound rule

  },
  messages: {
    designation_name: {"required":"Please specify the name", "minlength": "minlength"},
    department_name: {"required":"Please specify the name", "minlength": "minlength"},
   
  }
});
  </script>
  @endsection



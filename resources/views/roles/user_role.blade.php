	@extends('layout.main')
	@section('content')

	<section class="content">
		<!-- SELECT2 EXAMPLE -->
    <div class="box box-default">
      <div class="box-header with-border">
        <h3 class="box-title">Assign a role to this user</h3>

        <div class="box-tools pull-right">
          <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
          <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-remove"></i></button>
        </div>
      </div>
      <!-- /.box-header -->


      {!! Form::open(array('url' => '/roles/submit_user_role', 'id' => 'role-form')) !!}


      <div class="box-body">
        <div class="row">
          <div class="col-md-6">

           <!-- product type -->

           <div class="form-group">
            <label>Name</label>
            <!-- <input type="text" class="form-control" name="sales_name" id="sales-name" placeholder="Enter sales center name" required>    -->
            <div class="row">
              <div class="col-lg-11" style="padding-right:0;">
                @if(isset($user->id))
                <input type="text" class="form-control" name="user_name" id="user-name" value="{{$user->name}}" readonly>
                @endif
              </div>
            </div>
          </div>

        </div>
        <!-- /.col -->
        <div class="col-md-6">  
          <div class="form-group">
            <label>Roles</label>
            <!-- <input type="text" class="form-control" name="sales_name" id="sales-name" placeholder="Enter sales center name" required>    -->
            <div class="row">
              <div class="col-lg-11" style="padding-right:0;">
                <select id="department-id" name="department_id" placeholder="" style="width: 100%;" class="col-lg-8 form-control select2 validate[required]" required>
                  @if(isset($role->id))
                  <option value='{{$role->id}}' selected>{{$role->name}}</option>
                  @endif
                </select>
              </div>
            </div>
          </div>
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


  $('#department-id').select2({
    placeholder: 'Select an option',
    ajax: {
      dataType: 'json',
      url: '{{URL::to('/')}}/ajax/ajax_get_departments',
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


});
</script>
@endsection



	@extends('layout.main')
	@section('content')

	<section class="content">
		<!-- SELECT2 EXAMPLE -->
    <div class="box box-default">
      <div class="box-header with-border">
        <h3 class="box-title">Add/edit projects</h3>

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
            <input type="text" class="form-control" name="name" id="name" placeholder="Name of the program" value="{{$user->name}}" readonly>   
          </div>

        </div>
        <!-- /.col -->
        <div class="col-md-6">
            <div class="form-group">
            <label>Email</label>
            <input type="email" class="form-control" name="user_email" id="user-email" placeholder="please enter the code" value="{{$user->email}}" readonly>   
          </div>

        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
      <div class="row">
    <div class="col-lg-12">
      <table id="recieve-voucher-table" class="table table-bordered table-hover">
        <thead>
          <tr>
            <th style="text-align: center; width:50%;">Project name</th>
            <th style="text-align: center; width:20%;">Project code</th>
            <th style="text-align: center; width:20%">Allocated hours</th>
            <th style="text-align: center;">Add</th>
          </tr>
        </thead>

        <thead>

          <tr>
            <form id="voucher-info">
              <th>
                <select style="width: 100%; margin-left:8px;" class="form-control select2" id="project-name" name="project_name">
                </select>

              </th>
              <th ><input type="text" style="width: 100%; margin-left: 8px;" name="project_code" class="form-control" id="project-code" placeholder readonly ></th>
              <th ><input type="text" style="width: 100%; margin-left: 8px; margin-right: 8px" name="project_hours" class="form-control" id="project-hours" ></th>
              <th><button type="button" id="add" style="width: 100%; margin-left: 8px;" class="btn btn-primary btn-block btn-flat">Add</button></th>

            </tr>
          </thead>

          <tbody>

          </tbody>

        </table>

        <div class="col-lg-4 pull-right">
          <span class="">Total:</span><input type="text" name="amount" class="col-lg-10 pull-right" id="total-amount" placeholder="Total Amount" readonly>
        </div>


      </div>
    </div>
    <button type="submit" class="btn btn-primary center-block btn-flat">Submit</button>
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

<script type="text/javascript">
$( document ).ready(function() {

  





});




  </script>
  @endsection



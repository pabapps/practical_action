	@extends('layout.main')
	@section('content')

	<section class="content">
		<!-- SELECT2 EXAMPLE -->
    <div class="box box-default">
      <div class="box-header with-border">
        <h3 class="box-title">Edit Category</h3>

        <div class="box-tools pull-right">
          <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
          <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-remove"></i></button>
        </div>
      </div>

      {!! Form::open(array('route' => array('contact_categories.update', $category->id), 'id' => 'category-edit-form', 'method'=>'PUT')) !!}

      <div class="box-body">
        <div class="row">
          <div class="col-md-6">

           <div class="form-group">
            <label>Category Name</label>
            <input type="text" class="form-control" name="category_name" id="category-name" placeholder="Enter the Category"  value="{{$category->name}}" required>   
          </div>

        </div>
        <!-- /.col -->
        <div class="col-md-6">
            
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

<script type="text/javascript">
$( document ).ready(function() {

  





});




  </script>
  @endsection



    @extends('layout.main')
    @section('content')

    <section class="content">
      <!-- SELECT2 EXAMPLE -->
      <div class="box box-default">
        <div class="box-header with-border">
          <h3 class="box-title">Create new permission</h3>

          <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
            <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-remove"></i></button>
          </div>
        </div>
        <!-- /.box-header -->
        {!! Form::open(array('route'=>'permissions.store', 'files'=>true, 'id'=>'permission-form')) !!}

        
        <div class="box-body">
          <div class="row">
            <div class="col-md-6">

              <!-- Customer type -->

              <div class="form-group">
                <label>Name</label>
                <input type="text" class="form-control" type="text" id="permission-name"name="permission_name" placeholder="Enter a unique name for this permission" value="{{ old('permission_name') }}" >   

              </div>

              <div class="form-group">
                <label>Description</label>
                <input type="text" class="form-control" type="text" id="description" name="description" placeholder="just give a short description of this permission" value="{{ old('description') }}" required >   

              </div>
            </div>
            <!-- /.col -->
            <div class="col-md-6">

              <div class="form-group">
                <label>Display name</label>
                <input type="text" class="form-control" name="display_name" id="display-name" placeholder="Enter a name that might not be unique" value="{{old('display_name')}}" required>   
              </div>
            </div>
          </div>

          <div class="form-group">

            <button type="submit" class="btn center-block btn-primary">Submit</button>

            

          </div>
        </div>
        {!! Form::close() !!}
        <!-- /.box-body -->
        <div class="form-group">
         @if (count($errors) > 0)
         <div class="alert alert-danger">
          <ul>
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
          </ul>
        </div>
        @endif
      </div>      
    </div>
  </section>

  @endsection



  @section('script')

  <script type="text/javascript">

  $("#permission-form").validate({
   rules: {
    // simple rule, converted to {required:true}
    permission_name: {"required":true, "minlength": 2}
    

  },
  messages: {
    permission_name: {"required":"Please specify a permission name", "minlength": "minlength"}
    
  }
});

  </script>
  @endsection



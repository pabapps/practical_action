    @extends('layout.main')
    @section('content')

    <section class="content">
        <!-- SELECT2 EXAMPLE -->
    <div class="box box-default">
      <div class="box-header with-border">
        <h3 class="box-title">Select2</h3>

        <div class="box-tools pull-right">
          <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
          <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-remove"></i></button>
        </div>
      </div>
      <!-- /.box-header -->
      {!! Form::open(array('url' => '/permission/submitpermission', 'id' => 'role-form')) !!}

        
        <div class="box-body">
          
          <h2>Permission info</h2>
        <div class="row">
          <div class="col-md-4">

            <div class="form-group">
              <label>Name</label>
              <input type="text" id="name"name="name" class="form-control"placeholder="enter the name">
            </div>

          </div>


          <div class="col-md-4" >
            <div class="form-group">
              <label>Description</label>
              <input type="text" id="display-name"name="display_name" class="form-control"placeholder="enter the  description">
            </div>
          </div>

          <div class="col-md-2" >

          </div>

          <div class="col-md-2" >

          </div>


          <div class="col-md-4" >
            <div class="form-group">
              <button type="submit" class="btn btn-primary center-block btn-flat" style="margin-top: 1.7em">Submit</button>
            </div>     
          </div>


          </div> 


          
          <!-- /.box-body -->

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

  $("#role-form").validate({
   rules: {
    // simple rule, converted to {required:true}
    name: {"required":true, "minlength": 2}
    

  },
  messages: {
    name: {"required":"Please specify your username", "minlength": "minlength"}
    
  }
});

  </script>
  @endsection



    @extends('layout.main')

    @section('styles')
    <!-- DataTables -->
    <link rel="stylesheet" href="{{asset('plugins/daterangepicker/daterangepicker-bs3.css')}}">
    <link rel="stylesheet" href="{{asset('plugins/datepicker/datepicker3.css')}}">
    <link rel="stylesheet" href="{{asset('plugins/timepicker/bootstrap-timepicker.min.css')}}">
    @endsection

    @section('content')

    <section class="content">
      <!-- SELECT2 EXAMPLE -->
      <div class="box box-default">
        <div class="box-header with-border">
          <h3 class="box-title">Register User page</h3>

          <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
            <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-remove"></i></button>
          </div>
        </div>
        <!-- /.box-header -->
        {!! Form::open(array('url' => '/register', 'id' => 'register-form')) !!}


        <div class="box-body">
          <div class="row">
            <div class="col-md-6">

              <!-- Customer type -->

              <div class="form-group">
                <label>Name</label>
                <input type="text" class="form-control" id="name" name="name" placeholder="Enter User Name" value="{{ old('name') }}">   
              </div>

              <div class="form-group">
                <label>Phone</label>
                <input type="number" class="form-control" id="phone-num" name="phone_num" placeholder="please enter the phone number" value="{{ old('phone_num') }}">   
              </div>


              <div class="form-group">
                <label>Password</label>
                <input type="password" class="form-control" id="password" name="password"placeholder="Enter password" >

              </div>


              <div class="form-group">
                <label>Joining date:</label>

                <div class="input-group date">
                  <div class="input-group-addon">
                    <i class="fa fa-calendar"></i>
                  </div>
                  <input type="text" class="form-control pull-right" name="joining_date" data-date-format="dd-mm-yyyy" id="joining-date" placeholder="joining date">
                </div>
                <!-- /.input group -->
              </div>

            </div>

            <div class="col-md-6">
              <div class="form-group">

                <div class="form-group">
                  <label>E-mail</label>
                  <input type="email" class="form-control" id="email" name="email" value="{{ old('email') }}" placeholder="Enter Email address">

                </div>


                <div class="form-group">
                  <label>Gender</label>
                  <select style="width: 100%; " class="form-control" id="gender" name="gender">
                    <option value="male">Male</option>
                    <option value="female">Female</option>
                  </select>  
                </div>


                <div class="form-group">
                  <label>Confirm password</label>
                  <input type="password" class="form-control" id="password_confirm" name="password_confirmation"placeholder="please enter your password again" >

                </div>

              </div>

            </div>

          </div>

          <div class="form-group">
            <!-- description -->

            <button type="submit" class="btn btn-primary center-block ">Register</button>
          </div>
          <!-- /.row -->

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
    <!-- /.box -->


  </section>




  @endsection



  @section('script')
  <script src="{{asset('dist/js/utils.js')}}"></script>
  <script src="{{asset('plugins/daterangepicker/daterangepicker.js')}}"></script>
  <script src="{{asset('plugins/datepicker/bootstrap-datepicker.js')}}"></script>
  <script src="{{asset('plugins/timepicker/bootstrap-timepicker.min.js')}}"></script>
  <script src="{{asset('plugins/datatables/jquery.dataTables.min.js')}}"></script>
  <script src="{{asset('plugins/datatables/dataTables.bootstrap.min.js')}}"></script>
  <script type="text/javascript">

  $( document ).ready(function() {


    $('#joining-date').datepicker({
      autoclose: true

    });










  });

  </script>
  @endsection




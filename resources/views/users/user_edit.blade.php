    @extends('layout.main')
    @section('styles')


    <link rel="stylesheet" href="{{asset('plugins/daterangepicker/daterangepicker-bs3.css')}}">
    <link rel="stylesheet" href="{{asset('plugins/datepicker/datepicker3.css')}}">
    <link rel="stylesheet" href="{{asset('plugins/timepicker/bootstrap-timepicker.min.css')}}">
    @endsection
    @section('content')

    <section class="content">
      <!-- SELECT2 EXAMPLE -->
      <div class="box box-default">
        <div class="box-header with-border">
          <h3 class="box-title">Edit the contents of this user</h3>

          <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
            <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-remove"></i></button>
          </div>
        </div>
        <!-- /.box-header -->
        {!! Form::open(array('route' => array('users.update', $user->id), 'id' => 'user-edit-form', 'method'=>'PATCH')) !!}


        <div class="box-body">
          <div class="row">
            <div class="col-md-6">

              <!-- Customer type -->

              <div class="form-group">
                <label>Name</label>
                <input type="text" class="form-control" id="name" name="name" placeholder="Enter User Name" value="{{ $user->name }}">   
              </div>

              <div class="form-group">
                <label>Phone</label>
                <input type="number" class="form-control" id="phone-num" name="phone_num" 
                placeholder="please enter the phone number" value="{{ $user->phone_num }}">   
              </div>

              <div class="form-group">
                <label>line manager</label>
                <select id="line-manager" name="line_manager" placeholder="" style="width: 100%;" 
                class="col-lg-8 form-control select2 validate[required]">
                @if(isset($user->line_manager_id))

                <option value='{{$line_manager->id}}' selected>{{$line_manager->name}}</option>
                
                @endif
              </select>
            </div>

            <div class="form-group">
              <label>Designation</label>
              <select id="designation" name="designation" placeholder="" style="width: 100%;" 
              class="col-lg-8 form-control select2 validate[required]">
              @if(isset($user_designation->position_name))
              <option value='{{$user_designation->id}}' selected>{{$user_designation->position_name}}</option>
              @endif
            </select>
          </div>

          <div class="form-group">
            <label>Designation Changed Date:</label>

            <div class="input-group date">
              <div class="input-group-addon">
                <i class="fa fa-calendar"></i>
              </div>
              @if(isset($user_designation_date))
              <input type="text" class="form-control pull-right" name="designation_changed_date" data-date-format="dd-mm-yyyy" id="designation-changed-date"  value="{{$user_designation_date}}" >
              @else
              <input type="text" class="form-control pull-right" name="designation_changed_date" data-date-format="dd-mm-yyyy" id="designation-changed-date"  value="" >
              @endif
            </div>
            <!-- /.input group -->
          </div>


          <div class="form-group">
            <label>Password</label>
            <input type="password" class="form-control" id="password" name="password" placeholder="Enter password" >

          </div>


          <div class="form-group">
            <label>Roles</label>
            <!-- <input type="text" class="form-control" name="sales_name" id="sales-name" placeholder="Enter sales center name" required>    -->
            <div class="row">
              <div class="col-lg-11" style="padding-right:0;">
                <select id="role-id" name="role_id[]" placeholder="" style="width: 100%;" multiple="multiple"
                class="col-lg-8 form-control select2 validate[required]" >
                @if(isset($role->id))
                <option value='{{$role->id}}' selected>{{$role->name}}</option>
                @endif
              </select>
            </div>
          </div>
        </div>

      </div>

      <div class="col-md-6">
        <div class="form-group">

          <div class="form-group">
            <label>E-mail</label>
            <input type="email" class="form-control" id="email" name="email" value="{{ $user->email }}" placeholder="Enter Email address">

          </div>


          <div class="form-group">
            <label>Gender</label>
            <select style="width: 100%; " class="form-control" id="gender" name="gender">
              @if($user->gender == 'male')
              <option value="male" selected>Male</option>
              <option value="female">Female</option>
              @else
              <option value="male">Male</option>
              <option value="female" selected>Female</option>
              @endif
            </select>  
          </div>

          <div class="form-group">
            <label>Matrix Manager</label>
            <select id="matrix-manager" name="matrix_manager" placeholder="" style="width: 100%;" class="col-lg-8 form-control select2 validate[required]">
              @if(isset($user->matrix_manager_id))
              <option value='{{$matrix_manager->id}}' selected>{{$matrix_manager->name}}</option>
              @endif
            </select>
          </div>

          <div class="form-group">
            <label>Joining date:</label>

            <div class="input-group date">
              <div class="input-group-addon">
                <i class="fa fa-calendar"></i>
              </div>
              <input type="text" class="form-control pull-right" name="joining_date" data-date-format="dd-mm-yyyy" id="joining-date" placeholder="joining date" value="{{$date}}">
            </div>
            <!-- /.input group -->
          </div>


          <div class="form-group">
            <label>Confirm password</label>
            <input type="password" class="form-control" id="password_confirm" name="password_confirm"
            placeholder="please enter your password again" >

          </div>

          <div class="form-group">
            <label>User Location</label>
            <input type="text" class="form-control" id="user-location" name="user_location" 
            value="{{ $user->user_location }}" placeholder="User location">

          </div>

          <div class="form-group">
            <div class="checkbox">
              <label>
                @if(isset($user->byPass_line_manger) && $user->byPass_line_manger ==1)
                <input type="checkbox" name="skip_line_manager" value="1" checked>
                <b>Skip line manager</b>
                @else
                <input type="checkbox" name="skip_line_manager" value="1">
                <b>Skip line manager</b>
                @endif
              </label>
            </div>                  
          </div>

        </div>

      </div>

    </div>
    <!-- /.row -->

    <div class="col-md-12">
      <div class="box">
        <div class="box-header with-border">
          <h3 class="box-title">Role Table</h3>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
          <table class="table table-bordered" id="role-table">
            <tr>
              <th style="width: 10px">#</th>
              <th>Role</th>
              <th>Description</th>
            </tr>
            
          </table>
        </div>
      </div>
    </div>
    <div class="form-group">
      <button type="submit" class="btn btn-primary center-block ">Update</button>
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
<!-- /.box -->


</section>




@endsection



@section('script')
<script src="{{asset('dist/js/utils.js')}}"></script>
<script src="{{asset('plugins/datepicker/bootstrap-datepicker.js')}}"></script>
<script src="{{asset('plugins/timepicker/bootstrap-timepicker.min.js')}}"></script>
<script src="{{asset('plugins/datatables/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('plugins/datatables/dataTables.bootstrap.min.js')}}"></script>
<script src="{{asset('js/app.js')}}"></script>
<script type="text/javascript">

  $( document ).ready(function() {


    $('#joining-date').datepicker({
      autoclose: true

    });

    $('#designation-changed-date').datepicker({
      autoclose: true

    });



    $('#line-manager').select2({
      placeholder: 'Select an option',
      ajax: {
        dataType: 'json',
        url: '{{URL::to('/')}}/users/get_line_managers',
        delay: 250,
        data: function(params) {
          return {
            term: params.term,
            id : "{{$user->id}}"
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


    $('#matrix-manager').select2({
      placeholder: 'Select an option',
      ajax: {
        dataType: 'json',
        url: '{{URL::to('/')}}/users/get_line_managers',
        delay: 250,
        data: function(params) {
          return {
            term: params.term,
            id : "{{$user->id}}"
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


    $('#designation').select2({
      placeholder: 'Select an option',
      ajax: {
        dataType: 'json',
        url: '{{URL::to('/')}}/select2/select2_all_designations',
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


  $('#role-id').select2({
    placeholder: 'Select an option',
    ajax: {
      dataType: 'json',
      url: '{{URL::to('/')}}/role/ajax/get_all_roles',
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


    //ajax request
    $.get( "{{URL::to('/')}}/roles/roles_for_specific_user",{ user_id: "{{$user->id}}" }, function( role_array ) {
      // console.log(role_array);

      var object = JSON.parse(role_array);

      var count = 1;

      var trHTML = '';

      for (var i = 0; i < object.length; i++) { 

       trHTML += '<tr><td>' + count + '</td><td>' + object[i].name + '</td><td>' + object[i].description+ '</td></tr>';

       count++;
     }

     $('#role-table').append(trHTML);


   });

 </script>
 @endsection




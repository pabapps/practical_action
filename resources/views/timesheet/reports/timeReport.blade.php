  @extends('layout.main')

  @section('styles')
  <link rel="stylesheet" href="{{asset('plugins/datepicker/datepicker3.css')}}">
  @endsection

  @section('content')

  <section class="content">
    <!-- SELECT2 EXAMPLE -->
    <div class="box box-default">
      <div class="box-header with-border">
        <h3 class="box-title">Generate Report</h3>

        <div class="box-tools pull-right">
          <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
          <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-remove"></i></button>
        </div>
      </div>

      {!! Form::open(array('route'=>'timesheet_Reports.store', 'files'=>true, 'id'=>'department-form')) !!}

      <div class="box-body">
        <div class="row">
          <div class="col-md-4">

           <div class="form-group">
            <label>Users</label>
            <select id="user-id" name="user_id"  style="width: 100%;" class="form-control select2" >
              @if(isset($users))
              <option value="-1"></option>
              @foreach($users as $user)
              <option value="{{$user->id}}">{{$user->name}}</option>
              @endforeach
              @endif

            </select>
          </div>

        </div>
        <!-- /.col -->
        <div class="col-md-2">
          <div class="form-group">
            <label>Start date</label>

            <div class="input-group date">
              <div class="input-group-addon">
                <i class="fa fa-calendar"></i>
              </div>
              <input type="text" class="form-control pull-right onchange" name="start_date"
              data-date-format="dd-mm-yyyy" id="start-date" placeholder="start">
            </div>
            <!-- /.input group -->
          </div>
        </div>

        <div class="col-md-2">
          <div class="form-group">
            <label>End date</label>

            <div class="input-group date">
              <div class="input-group-addon">
                <i class="fa fa-calendar"></i>
              </div>
              <input type="text" class="form-control pull-right onchange" name="end_date"
              data-date-format="dd-mm-yyyy" id="end-date" placeholder="end">
            </div>
            <!-- /.input group -->
          </div>
        </div>
        <!-- /.col -->

        <div class="col-md-4">

         <div class="form-group">
          <label>Projects</label>
          <select id="user-projects" name="user_projects[]"  style="width: 100%;" multiple="multiple" class="form-control select2" required>
            
          </select>
        </div>

      </div>
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
<script src="{{asset('plugins/datepicker/bootstrap-datepicker.js')}}"></script>
<script src="{{asset('dist/js/utils.js')}}"></script>
<script type="text/javascript">
$( document ).ready(function() {


  $('#start-date').datepicker({
    autoclose: true

  });
  $('#end-date').datepicker({
    autoclose: true

  });

  $("#user-id").select2();


  $( "#user-id" ).change(function() {

    var user_id = $('#user-id').val();

    if(user_id!=-1){

      $('#user-projects').select2({
        placeholder: 'Select an option',
        ajax: {
          dataType: 'json',
          url: '{{URL::to('/')}}/timesheet_Reports/get_user_projects',
          delay: 250,
          data: function(params) {
            return {
              term: params.term,
              id : user_id
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

    }else{
      alert("please select a user from the list");

      return;

    }

    

    
  });


  





});




</script>
@endsection



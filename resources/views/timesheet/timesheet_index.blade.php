	@extends('layout.main')
  @section('styles')
  <!-- DataTables -->
  <link rel="stylesheet" href="{{asset('plugins/datatables/dataTables.bootstrap.css')}}">
  @endsection

  @section('content')

  <section class="content">
    <!-- SELECT2 EXAMPLE -->
    <div class="box box-default">
      <div class="box-header with-border">
        <h3 class="box-title">Time Sheet Log</h3>

        <div class="box-tools pull-right">
          <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
          <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-remove"></i></button>
        </div>
      </div>

      <div class="box-body">
        <div class="row">
          <div class="col-md-6">

           <div class="form-group">
            <label>Please select on of the projects</label>
            <select id="project-id" name="project_id"  style="width: 100%;" class="col-lg-8 form-control select2" >

            </select>
          </div>

        </div>
        <!-- /.col -->

        <div class="col-md-6">
          <div class="form-group">

            <button type="submit" id="project-select-id" class="btn btn-primary" style="margin-top: 25px">Show log</button>

          </div>
        </div>
      </div>
      <!-- /.row -->

      <div class="box-body">
        <table id="time-sheet-log" class="table table-bordered table-hover">
          <thead>
            <tr>
              <th>Project Name</th>
              <th>Date</th>
              <th>Star date</th>
              <th>End date</th>
              <th>Activity</th>
              <th>Edit</th>

            </tr>
          </thead>
          <tbody>

          </tbody>
          <tfoot>
            <tr>
              <th>Project Name</th>
              <th>Date</th>
              <th>Star date</th>
              <th>End date</th>
              <th>Activity</th>
              <th>Edit</th>

            </tr>
          </tfoot>
        </table>
      </div>

      <div class="form-group">

        <button type="submit" id="time-sheet-submit" class="btn btn-primary">Submit</button>

      </div>
      
    </div>
    
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

<script src="{{asset('plugins/datatables/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('plugins/datatables/dataTables.bootstrap.min.js')}}"></script>

<script type="text/javascript">
$( document ).ready(function() {


  $('#project-id').select2({
    placeholder: 'Select an option',
    ajax: {
      dataType: 'json',
      url: '{{URL::to('/')}}/timesheet/get_user_projecs',
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

  var table;

  $( "#project-select-id" ).click(function() {

    event.preventDefault();

    var project_id = $('#project-id').val();

    if(project_id == null){

      alert("OPS! please select a project.");

      return;

    }else{

      table = $('#time-sheet-log').DataTable( {
        "processing": true,
        "serverSide": true,
        "bDestroy": true,
        "ajax": "{{URL::to('/')}}/timesheet/project_details_for_timesheet/"+project_id,
        "columns": [
        { "data": "project_name" },
        { "data": "date" },
        { "data": "start_time" },
        { "data": "end_time" },
        { "data": "activity" },
        { "data": "action", name: 'action', orderable: false, searchable: false}
        ],
        "order": [[1, 'asc']]
      } );
      


    }

  });


  $( "#time-sheet-submit" ).click(function() {


    table.rows().every( function ( rowIdx, tableLoop, rowLoop ) {
      var data = this.data();
      
      console.log(data);

    } );

  });











});




  </script>
  @endsection



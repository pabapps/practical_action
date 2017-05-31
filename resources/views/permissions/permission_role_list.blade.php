@extends('layout.main')
@section('styles')
<!-- DataTables -->
 <link rel="stylesheet" href="{{asset('plugins/datatables/dataTables.bootstrap.css')}}">
@endsection
@section('content')
    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
          <div class="box">
            <div class="box-header">
              <h3 class="box-title">User role permission table</h3>
            </div>
            <a href="permissions/create"><h1>Create new permission</h1></a>
            <!-- /.box-header -->
            <div class="box-body">
              <table id="role-permission-table" class="table table-bordered table-hover">
                <thead>
                <tr>
                  <th>Role</th>
                  <th>Description</th>
                  <th>Edit</th>
                </tr>
                </thead>
                <tbody>

                </tbody>
                <tfoot>
                <tr>
                  
                </tr>
                </tfoot>
              </table>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
    </section>
    <!-- /.content -->
@endsection

@section('script')
<!-- DataTables -->
<script src="{{asset('plugins/datatables/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('plugins/datatables/dataTables.bootstrap.min.js')}}"></script>
<script>
$(document).ready(function() {
  var table = $('#role-permission-table').DataTable( {
    "processing": true,
    "serverSide": true,
    "paging": true,
    "lengthChange": true,
    "searching": true,
    "ordering": true,
    "info": true,
    "autoWidth": false,
    "ajax": "{{URL::to('/')}}/permissions/user_role_permissions_details",
    "columns": [
    { "data": "name" },
    { "data": "description" },
    { "data": "action", name: 'action', orderable: false, searchable: false}
    ],
    "order": [[1, 'asc']]
  } );
});
</script>
@endsection
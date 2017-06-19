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
              <h3 class="box-title">Data Table</h3>
            </div>
            
            <!-- /.box-header -->
            <div class="box-body">
              <table id="user-role-table" class="table table-bordered table-hover">
                <thead>
                <tr>
                  <th>id</th>
                  <th>User Name</th>
                  <th>Role</th>
                  <th>Edit</th>
                </tr>
                </thead>
                <tbody>

                </tbody>
                <tfoot>
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
  var table = $('#user-role-table').DataTable( {
    "processing": true,
    "serverSide": true,
    "paging": true,
    "lengthChange": true,
    "searching": true,
    "ordering": true,
    "info": true,
    "autoWidth": false,
    "scrollX": true,
    "ajax": "{{URL::to('/')}}/role/get_all_users_role",
    "columns": [
    { "data": "id" },
    { "data": "name" },
    { "data": "roles_name" },
    { "data": "action", name: 'action', orderable: false, searchable: false}
    ],
    "order": [[1, 'asc']]
  } );
});
</script>
@endsection
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
            <a href="roles/create"><h1>Create new Role</h1></a>
            <!-- /.box-header -->
            <div class="box-body">
              <table id="products" class="table table-bordered table-hover">
                <thead>
                <tr>
                  <th>Unique Name</th>
                  <th>Name</th>
                  <th>Description</th>
                  <th>Edit</th>
                </tr>
                </thead>
                <tbody>

                </tbody>
                <tfoot>
                <tr>
                  <th>Unique Name</th>
                  <th>Name</th>
                  <th>Description</th>
                  <th>Edit</th>
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
  var table = $('#products').DataTable( {
    "processing": true,
    "serverSide": true,
    "ajax": "{{URL::to('/')}}/roles/get_all_roles",
    "columns": [
    { "data": "name" },
    { "data": "display_name" },
    { "data": "description" },
    { "data": "action", name: 'action', orderable: false, searchable: false}
    ],
    "order": [[1, 'asc']]
  } );
});
</script>
@endsection
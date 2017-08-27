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
          <h3 class="box-title">Contact list</h3>
        </div>
        <a href="{{URL::to('/') . '/pab_contacts/create'}}"><h1>Create new Contacts</h1></a>
        <!-- /.box-header -->
        <div class="box-body">
          <table id="contacts" class="table table-bordered table-hover">
            <thead>
              <tr>
                <th>id</th>
                <th>Name</th>
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

  <div class="modal fade" id="edit-modal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
          <h3 class="modal-title">create new time sheet entry</h3>
        </div>

        {!! Form::open(['method'=>'POST', 'action'=>['TimeSheetController@store'], 'id'=>'time-sheet-form']) !!}

        <div class="modal-body">

         
          <div class="form-group">
            <label>Theme</label>
            <div class="row">
              <div class="col-lg-12">
                <select id="theme-id" name="theme_id[]" placeholder="" style="width: 100%;" class="col-lg-8 form-control select2 validate[required]" multiple="multiple" required>

                </select>
              </div>
            </div>
          </div>






        </div>

        <div class="modal-footer">
          <div class="col-lg-12 entry_panel_body ">
            <h3></h3>
            <button type="submit" class="btn btn-primary">Submit</button>
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          </div>
        </div>
        {!! Form::close() !!}

      </div>
    </div>
  </div>

</section>
<!-- /.content -->
@endsection

@section('script')
<!-- DataTables -->
<script src="{{asset('plugins/datatables/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('plugins/datatables/dataTables.bootstrap.min.js')}}"></script>
<script>
  $(document).ready(function() {
    var table = $('#contacts').DataTable( {
      "processing": true,
      "serverSide": true,
      "paging": true,
      "lengthChange": true,
      "searching": true,
      "ordering": true,
      "info": true,
      "autoWidth": false,
      "scrollX": true,
      "ajax": "{{URL::to('/')}}/pab_contacts/get_all_contacts",
      "columns": [
      { "data": "id" },
      { "data": "name" },
      { "data": "action", name: 'action', orderable: false, searchable: false}
      ],
      "order": [[1, 'asc']]
    } );


    $('#contacts tbody').on( 'click', 'tr', function () {

     var cell = table.cell( this );

     data = table.row( this ).data();

     console.log(data);

     $("#edit-modal").modal('show');

   });



    $('#theme-id').select2({
    placeholder: 'Select an option',
    ajax: {
      dataType: 'json',
      url: '{{URL::to('/')}}/pab_contacts/get_all_themes',
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
</script>
@endsection
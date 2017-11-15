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


        <div id="app">
          <practical-contact-display></practical-contact-display>
        </div>
        
        <!-- /.box-body -->
      </div>
      <!-- /.box -->
    </div>
    <!-- /.col -->
  </div>
  <!-- /.row -->

  
</div>

</section>
<!-- /.content -->
@endsection

@section('script')
<!-- DataTables -->
<script src="{{asset('plugins/datatables/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('plugins/datatables/dataTables.bootstrap.min.js')}}"></script>
<script src="{{asset('js/app.js')}}"></script>
<script>
  $(document).ready(function() {

   

  });
</script>
@endsection
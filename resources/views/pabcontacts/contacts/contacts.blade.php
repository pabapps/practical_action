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
          <h3 class="modal-title">Details</h3>
        </div>

        {!! Form::open(['method'=>'POST', 'action'=>['TimeSheetController@store'], 'id'=>'eidt-form']) !!}

        <div class="modal-body">

         <div class="row">
           <div class="col-md-6">

            <div class="box box-primary">
              <div class="box-body box-profile">
                <img id="person-pic" class="img-responsive" src="" alt="picture">

                <h3 class="profile-username text-center">Nina Mcintire</h3>

                <p class="text-muted text-center">Software Engineer</p>
              </div>
              <!-- /.box-body -->
            </div>
          </div>
        </div>

        <div class="form-group">
          <label>Name of the person</label>
          <div class="row">
            <div class="col-lg-12">
              <input type="text" class="form-control" name="name" id="name" placeholder="please enter the name of the person" value="{{old('name')}}" required>   
            </div>
          </div>
        </div>

        <div class="form-group">
          <label>Designation</label>
          <div class="row">
            <div class="col-lg-12">
              <input type="text" class="form-control" name="designation" id="designation" placeholder="Designation of the person" value="{{old('designation')}}" required>   
            </div>
          </div>
        </div>

        <div class="form-group">
          <label>Organization</label>
          <div class="row">
            <div class="col-lg-12">
              <input type="text" class="form-control" name="organization" id="organization" placeholder="Please enter the organization" value="{{old('organization')}}" required>   
            </div>
          </div>
        </div>

        <div class="form-group">
          <label>Category</label>
          <div class="row">
            <div class="col-lg-12">
              <select id="category-id" name="category_id" placeholder="" style="width: 100%;" class="col-lg-8 form-control select2 validate[required]" required>

              </select>
            </div>
          </div>
        </div>

        <div class="box-header with-border">
              <h3 class="box-title">Themes</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <table id="theme-table" class="table table-bordered">
                <tr>
                  <th style="width: 10px">#</th>
                  <th>Id</th>
                  <th>Name</th>
                </tr>
                <tr>
                </tr>
              </table>
            </div>

        <div class="form-group">
          <label>Theme</label>
          <div class="row">
            <div class="col-lg-12">
              <select id="theme-id" name="theme_id[]" placeholder="" style="width: 100%;" class="col-lg-8 form-control select2 validate[required]" multiple="multiple" required>

              </select>
            </div>
          </div>
        </div>

        <div class="form-group">
          <label>Picture</label>
          <div class="row">
            <div class="col-lg-12">
              <input type="file" name="pic" accept="image/*" name="pic" id="pic">
            </div>
          </div>
        </div>


        <div class="form-group">
          <label>Email 1</label>
          <div class="row">
            <div class="col-lg-12">
              <input type="email" class="form-control" name="primary_email" id="primary-email" placeholder="please enter primary email" value="{{old('primary_email')}}" required>   
            </div>
          </div>
        </div>

        <div class="form-group">
          <label>Email 2</label>
          <div class="row">
            <div class="col-lg-12">
              <input type="email" class="form-control" name="secondary_email" id="secondary-email" placeholder="please enter secondary email" value="{{old('secondary_email')}}" >   
            </div>
          </div>
        </div>

        <div class="form-group">
          <label>Mobile</label>
          <div class="row">
            <div class="col-lg-12">
              <input type="number" class="form-control" name="mobile" id="mobile" placeholder="please enter the mobile number" value="{{old('mobile')}}" required>   
            </div>
          </div>
        </div>

        <div class="form-group">
          <label>Phone/Landline</label>
          <div class="row">
            <div class="col-lg-12">
              <input type="number" class="form-control" name="phone" id="phone" placeholder="please enter the phone number" value="{{old('phone')}}" >   
            </div>
          </div>
        </div>

        <div class="form-group">
          <label>Address</label>
          <div class="row">
            <div class="col-lg-12">
              <textarea type="text" rows="4" class="form-control" name="address" id="address" placeholder="Please enter the address" value="{{old('address')}}" required>

              </textarea>
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

    $('#category-id').select2({
      placeholder: 'Select an option',
      ajax: {
        dataType: 'json',
        url: '{{URL::to('/')}}/pab_contacts/get_all_catogies',
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

     console.log(data['id']);

     $.get(  "{{URL::to('/')}}/pab_contacts/get_specific_contact",{ contact_id: data['id'] }, function( final_array ) {

      var object = JSON.parse(final_array);

      var pic_path = "{{URL::to('/')}}"+object['contact']['pic_path'];      

      $("#person-pic").attr("src",pic_path);
      $("#name").val(object['contact']['name']);
      $("#designation").val(object['contact']['designation']);
      $("#organization").val(object['contact']['organization']);
      $("#primary-email").val(object['contact']['email1']);
      $("#secondary-email").val(object['contact']['email2']);
      $("#mobile").val(object['contact']['mobile']);
      $("#phone").val(object['contact']['phone']);
      $("#address").val(object['contact']['address']);

      var category_id = object['category']['id'];
      var category_name = object['category']['name'];

      var categoryOption = $("<option></option>").val(category_id).text(category_name);

      $("#category-id").append(categoryOption).trigger('change');

      $("#theme-table td").remove();


      var themes = object['theme_array'];

      var count = 1;

      var trHTML = '';

      for (var i = 0; i < themes.length; i++) { 
        
       trHTML += '<tr><td>' + count + '</td><td>' + themes[i]['id'] + '</td><td>' + themes[i]['name']+ '</td></tr>';

       count++;
     }

     $('#theme-table').append(trHTML);




    });

     $("#edit-modal").modal('show');

   });









  });
</script>
@endsection
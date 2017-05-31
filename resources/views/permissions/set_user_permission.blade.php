	@extends('layout.main')
	@section('content')

	<section class="content">
		<!-- SELECT2 EXAMPLE -->
    <div class="box box-default">
      <div class="box-header with-border">
        <h3 class="box-title">Add permissions</h3>

        <div class="box-tools pull-right">
          <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
          <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-remove"></i></button>
        </div>
      </div>

      {!! Form::open(array('url'=>'/permissions/submit_role_permission', 'id'=>'role-permission-form')) !!}

      <div class="box-body">
        <div class="row">
          <div class="col-md-6">

           <div class="form-group">
            <label>Role</label>
            <input type="text" class="form-control" name="name" id="name"  value="{{$role->name}}" readonly>   
          </div>

        </div>
        <!-- /.col -->
        <div class="col-md-6">
          <div class="form-group">
            <label>Description</label>
            <input type="email" class="form-control" name="user_email" id="user-email"  value="{{$role->description}}" readonly>   
          </div>

        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
      <div class="row">
        <div class="col-lg-12">
          <table id="permission-table" class="table table-bordered table-hover">
            <thead>
              <tr>
                <th style="text-align: center; width:25%;">Permission name</th>
                <th style="text-align: center; width:65%;">Description</th>
                <th style="text-align: center;">Add</th>
              </tr>
            </thead>

            <thead>

              <tr>
                <form id="voucher-info">
                  <th>
                    <select style="width: 100%; margin-left:8px;" class="form-control select2" id="permission-name" name="permission_name">
                    </select>

                  </th>
                  <th ><input type="text" style="width: 100%; margin-left: 8px;" name="project_code" class="form-control" id="project-code" placeholder readonly ></th>
                  
                  <th><button type="button" id="add" style="width: 100%; margin-left: 8px;" class="btn btn-primary btn-block btn-flat">Add</button></th>

                </tr>
              </thead>

              <tbody>

              </tbody>

            </table>

            <div class="col-lg-4 pull-right">
              <span class="">Total:</span><input type="text" name="amount" class="col-lg-10 pull-right" id="total" placeholder="Total" readonly>
            </div>


          </div>
        </div>
        <button type="submit" class="btn btn-primary center-block btn-flat">Submit</button>
      </div>
      {!! Form::close() !!}
      

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
  <script src="{{asset('dist/js/utils.js')}}"></script>

  <script type="text/javascript">

  $( document ).ready(function() {


    $('#permission-name').select2({
      placeholder: 'Select an option',
      ajax: {
        dataType: 'json',
        url: '{{URL::to('/')}}/permissions/get_permissions_for_roles',
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



    $("#permission-name").change(function(){

      var permission_id = $("#permission-name").val();

      var jqxhr = $.get( "{{URL::to('/')}}/permissions/permission_details", { name: permission_id },function(data) {

        // console.log(data.project_code);

        $('#project-code').val(data.description);

      });
    });

    
    var permission_data = [];
    var total = 0 ;

    var permission_table = $("#permission-table").DataTable({
      "searching": false,
      "paging": false,
      "ordering": false,
      "autoWidth": false
    });

    var role_id = "{{$role->id}}";

    var jqxhr = $.get( "{{URL::to('/')}}/permissions/get_old_permissions_roles", { id: role_id },function(data) {

            // working
            // console.log(data);
            $.each(data, function( index, value ) {
              var entry = [
              value.permission_name,
              value.description,
              '<button class="btn btn-danger btn-block delete-button" id="' + '">Delete</button>',
              value.id

              ];

              permission_data.push(entry);
              permission_table.row.add(entry).draw(false);

              total = total + 1;

              $("#total").val(total);
            });

          }).done(function(){



          });



          $('#add').click(function(event){
            event.preventDefault();

            var permission_name = $("#permission-name option:selected").text(),
            permisson_id = $("#permission-name").val(),
            permission_description = $("#project-code").val();

            if(isBlank(!permisson_id)){

              var entry = [
              permission_name,
              permission_description,
              '<button class="btn btn-danger btn-block delete-button" id="' + '">Delete</button>',
              permisson_id
              ];

              var project_id = entry[3];
              var booleanValue = true;
              if(permission_data.length >= 1){
                for(i=0; i<permission_data.length; i++){
                  if(permission_data[i][3] == permisson_id){
                    booleanValue=false;

                  }
                }
              }

              if(booleanValue){

                permission_data.push(entry);

                total = total + 1;

                permission_table.row.add(entry).draw(false);

                $("#total").val(total);

                $("#project-code").val('');  

              }else{
                alert("this permission has already been entered");  
              }
            }else{
              alert("please fill the row properly");
            }

          });


  //delete row on button click
  $('#permission-table tbody').on( 'click', '.delete-button', function () {
    event.preventDefault();
    //get the index of 
    var index = permission_table
    .row( $(this).parents('tr') )
    .index();

    total = total - 1;
    // console.log(total);
        //remove index from data
        $('#total').val(total);
        permission_data.splice(index,1);

        permission_table
        .row( $(this).parents('tr') )
        .remove()
        .draw();
      });


  $( "#role-permission-form" ).submit(function(event){
  //validation

  event.preventDefault();


  var $form = $( this ),
  url = $form.attr( "action" ),
  token = $("[name='_token']").val();
  
  if(permission_data.length>0){
    $.post( url, {'user_id':'{{$role->id}}','data':permission_data, 'form_data': $form.serializeArray(), '_token': token }, function( data ) {

    }).done(function(value) {

      if(value == -1){

        alert("sorry you don't the permission to modify");

      }else{

        window.location.assign('{{URL::to('/')}}/permissions/roles_list');

      }

      

    });
  }else{

    alert("please fill in the details before submitting");

  }
});








});




  </script>
  @endsection



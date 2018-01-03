	@extends('layout.main')
	@section('content')

	<section class="content">
		<!-- SELECT2 EXAMPLE -->
    <div class="box box-default">
      <div class="box-header with-border">
        <h3 class="box-title">Create a Contact</h3>

        <div class="box-tools pull-right">
          <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
          <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-remove"></i></button>
        </div>
      </div>

      {!! Form::open(array('route'=>'pab_contacts.store', 'files'=>true, 'id'=>'contact-form')) !!}

      <div class="box-body">
        <div class="row">
          <div class="col-md-6">

           <div class="form-group">
            <label>Name of the person *</label>
            <input type="text" class="form-control" name="name" id="name" placeholder="please enter the name of the person" value="{{old('name')}}" required>   
          </div>

          <div class="form-group">
            <label>Designation</label>
            <input type="text" class="form-control" name="designation" id="designation" placeholder="Designation of the person" value="{{old('designation')}}" required>   
          </div>

          <div class="form-group">
            <label>Organization *</label>
            <input type="text" class="form-control" name="organization" id="organization" placeholder="Please enter the organization" value="{{old('organization')}}" required>   
          </div>

          <div class="form-group">
            <label>Category *</label>
            <div class="row">
              <div class="col-lg-11" style="padding-right:0;">
                <select id="category-id" name="category_id" placeholder="" style="width: 100%;" class="col-lg-8 form-control select2 validate[required]" required>

                </select>
              </div>
            </div>
          </div>

          <div class="form-group">
            <label>Theme *</label>
            <div class="row">
              <div class="col-lg-11" style="padding-right:0;">
                <select id="theme-id" name="theme_id[]" placeholder="" style="width: 100%;" class="col-lg-8 form-control select2 validate[required]" multiple="multiple" required>

                </select>
              </div>
            </div>
          </div>
          
          <div class="form-group">
            <label>Picture</label>
            <input type="file" name="pic" accept="image/*" name="pic" id="pic">
            <div class="avatar"> <img id="blah" src="#" alt="your image" /></div>

          </div>



        </div>
        <!-- /.col -->
        <div class="col-md-6">

          <div class="form-group">
            <label>Email 1 *</label>
            <input type="email" class="form-control" name="primary_email" id="primary-email" placeholder="please enter primary email" value="{{old('primary_email')}}" required>   
          </div>

          <div class="form-group">
            <label>Email 2</label>
            <input type="email" class="form-control" name="secondary_email" id="secondary-email" placeholder="please enter secondary email" value="{{old('secondary_email')}}" >   
          </div>

          <div class="form-group">
            <label>Mobile</label>
            <input type="number" class="form-control" name="mobile" id="mobile" placeholder="please enter the mobile number" value="{{old('mobile')}}" required>   
          </div>

          <div class="form-group">
            <label>Phone/Landline</label>
            <input type="number" class="form-control" name="phone" id="phone" placeholder="please enter the phone number" value="{{old('phone')}}" >   
          </div>

          <div class="form-group">
            <label>Address</label>
            <textarea type="text" rows="4" class="form-control" name="address" id="address" placeholder="Please enter the address" value="{{old('address')}}" required></textarea>
          </div>



        </div>
        <!-- /.col -->
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

<script type="text/javascript">
  $( document ).ready(function() {


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

    function readURL(input) {

      if (input.files && input.files[0]) {
        var reader = new FileReader();

        reader.onload = function(e) {
          $('#blah').attr('src', e.target.result);
        }

        reader.readAsDataURL(input.files[0]);
      }
    }

    $("#pic").change(function() {
      readURL(this);
    });




  });




</script>
@endsection



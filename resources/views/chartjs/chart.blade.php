	@extends('layout.main')
	@section('styles')
	<!-- DataTables -->

	@endsection
	@section('content')

	<section class="content">
		<div style="width:50%;">
    {!! $chartjs->render() !!}
</div>
		


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
	<script src="{{asset('plugins/daterangepicker/daterangepicker.js')}}"></script>
	<script src="{{asset('plugins/datepicker/bootstrap-datepicker.js')}}"></script>
	<script src="{{asset('plugins/timepicker/bootstrap-timepicker.min.js')}}"></script>

	<script type="text/javascript">
	$( document ).ready(function() {


		

	});




	</script>
	@endsection



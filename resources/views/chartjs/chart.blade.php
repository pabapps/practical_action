	@extends('layout.main')
	@section('styles')
	<!-- DataTables -->

	@endsection
	@section('content')
	 
	<section class="content">
		<div class="row">
        <div class="col-md-6">
		<div class="box box-danger">
			<div class="box-header with-border">
				<h3 class="box-title">Donut Chart</h3>

			</div>
			<div class="box-body">
				<canvas id="pieChart" style="height:250px"></canvas>
			</div>
			<!-- /.box-body -->
		</div>
	</div>

	<div style="width:75%;">
     {!! $chart->render() !!}
</div>
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
	


	
	<script type="text/javascript">
	$( document ).ready(function() {


		




});




	</script>
	@endsection



	@extends('layout.main')
	@section('styles')
	<!-- DataTables -->

	@endsection
	@section('content')

	<section class="content">
		<div class="box box-default">
			<div class="box-header with-border">
				<div class="box-body">

					<div class="col-md-12">
						<div class="row">
							<div style="width:85%;">
								{!! $chart->render() !!}
							</div>
						</div>
					</div>
				</div>
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



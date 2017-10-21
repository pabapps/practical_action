<template>
	<div>
		<div class="modal fade" id="add-new-entry" tabindex="-1" role="dialog" aria-hidden="true">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header" style="border-bottom: 0px;height: 50px;">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
						<h3 class="modal-title">create new time sheet entry</h3>
					</div>
					

					<form method="POST" @submit.prevent="onSubmit">


						<div class="modal-body">
							<div class="form-group" >
								<label>Previous Line Manager</label>
								<p>{{line_manager_name}}</p>
							</div>

							<div class="form-group">
								<label>Date:</label>

								<div class="input-group date">
									<div class="input-group-addon">
										<i class="fa fa-calendar"></i>
									</div>
									<input type="text" class="form-control pull-right" name="entry_date" data-date-format="dd-mm-yyyy" id="entry-date" >
								</div>
								<!-- /.input group -->
							</div>

							<div class="form-group">
								<label>New Line Manager</label>
								<select class="js-example-basic-multiple " name="states[]" multiple="multiple">
									<option value="AL">Alabama</option>
									...
									<option value="WY">Wyoming</option>
								</select>

								
							</div>

						</div>

						<div class="modal-footer">
							<div class="col-lg-12 entry_panel_body ">
								<h3></h3>
								<button type="submit" class="btn btn-primary">Submit</button>
								<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
							</div>
						</div>

					</form>
				</div>
			</div>
		</div>
	</div>
</template>

<script>
export default {

	name: 'userEdit',

	props:['line_manager_id','line_manager_name'],

	mounted() {
		$('#entry-date').datepicker({
			autoclose: true

		});

		$("#entry-date").datepicker('setDate', new Date());

		$('.js-example-basic-multiple').select2();
	},

	data () {
		return {

		};
	},
	methods:{
		onSubmit(){
			console.log("testing");

			axios.post('/user/modal_designation', {

			})
			.then(function (response) {
				console.log(response);
			})
			.catch(function (error) {
				console.log(error);
			});


		}
	}
};
</script>
























<style lang="css" scoped>
</style>
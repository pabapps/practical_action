<template>
	<div>
		<button type="button" class="btn bg-purple margin" data-toggle="modal" data-target="#myModal">New Contract</button>

		<div id="myModal" class="modal fade" role="dialog">
			<div class="modal-dialog">
				<form method="POST" @submit.prevent="onSubmit" >
					<!-- Modal content-->
					<div class="modal-content">
						<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal">&times;</button>
							<h4 class="modal-title">New Contract</h4>
						</div>
						
						<div class="form-group" >
							<label>New Designation</label>
							<v-select 
							:on-search="getOptions"
							:on-change="consoleCallback"
							:options="options"
							label="text"


							></v-select>
						</div>

						<div class="form-group">
							<label>Start Date:</label>

							<div class="input-group date">
								<div class="input-group-addon">
									<i class="fa fa-calendar"></i>
								</div>
								<input type="text" class="form-control pull-right" name="entry_date" data-date-format="dd-mm-yyyy" id="start-date" v-model="startDate">
							</div>
							<!-- /.input group -->
						</div>
						<div class="form-group">
							<label>End Date:</label>

							<div class="input-group date">
								<div class="input-group-addon">
									<i class="fa fa-calendar"></i>
								</div>
								<input type="text" class="form-control pull-right" name="entry_date" data-date-format="dd-mm-yyyy" id="end-date" v-model="endDate">
							</div>
							<!-- /.input group -->
						</div>

						<div class="modal-footer">
							<button type="submit" class="btn btn-primary" >Submit</button>
							<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
						</div>
					</div>

				</form>
			</div>
		</div>
	</div>
</template>

<script>
export default {

	name: 'contractCreate',
	mounted(){
		$('#start-date').datepicker({
			autoclose: true

		});
		$('#end-date').datepicker({
			autoclose: true

		});

		$("#start-date").datepicker('setDate', new Date());
		$("#end-date").datepicker('setDate', new Date());

		this.startDate = $("#start-date").val();
		this.endDate = $("#end-date").val();
	},
	data () {
		return {

			options: [],
			startDate:"",
			endDate:"",
			name_to: ""

		}
	},
	methods:{
		onSubmit(){
			console.log("working ");
			// axios.post('/contact_theme', {
			// 	theme : this.theme
			// })
			// .then(function (response) {
			// 	console.log(response);
			// 	location.reload();
			// })
			// .catch(function (error) {
			// 	console.log(error);
			// });
		},
		consoleCallback(val) {
			
			this.name_to = val.id;
			
			console.log(val.id);
		},
		getOptions(search, loading) {
			

			loading(true)
			this.$http.get('/contracts/get_all_users', {
				term: search
			}).then(users => {
				this.options = users.body;
				loading(false);

				console.log(this.options);
			})

		}
	}
}
</script>

<style lang="css" scoped>
</style>
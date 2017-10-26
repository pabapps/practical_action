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
					

					<form method="POST" @submit.prevent="onSubmit" >


						<div class="modal-body">
							<div class="form-group" >
								<label>Old Designation</label>
								<input type="text" class="form-control" v-model="designation_name" readonly>
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
								<label>Date:</label>

								<div class="input-group date">
									<div class="input-group-addon">
										<i class="fa fa-calendar"></i>
									</div>
									<input type="text" class="form-control pull-right" name="entry_date" data-date-format="dd-mm-yyyy" id="entry-date" v-model="date">
								</div>
								<!-- /.input group -->
							</div>

						</div>

						<div class="modal-footer">
							<div class="col-lg-12 entry_panel_body ">
								<h3></h3>
								<button type="submit" class="btn btn-primary" >Submit</button>
								<button type="button" class="btn btn-default" data-dismiss="modal" @close="showModal = false">Close</button>
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

	props:['user_designation_id','designation_name',"user_id"],

	mounted() {
		$('#entry-date').datepicker({
			autoclose: true

		});

		$("#entry-date").datepicker('setDate', new Date());

		this.date = $("#entry-date").val();
	},

	data () {
		return {
			selected: [],
			options: [],
			name_to: "",
			showModal: false,
			date:""
		};
	},
	methods:{

		consoleCallback(val) {
			
			this.name_to = val.id;
			
			// console.log(val.id);
		},

		onSubmit(){


			axios.post('/user/modal_designation', {
				old_designation : this.user_designation_id,
				new_designation: this.name_to,
				date: this.date,
				user_id : this.user_id
			})
			.then(function (response) {
				console.log(response);
				location.reload();
			})
			.catch(function (error) {
				console.log(error);
			});


		},




		getOptions(search, loading) {
			

			loading(true)
			this.$http.get('/select2/select2_all_designations', {
				term: search
			}).then(users => {
				this.options = users.body;
				loading(false);

				console.log(this.options);
			})

			// this.$http.get('/select2/select2_all_designations', {
			// 	term: search
			// }).then(users => {
			// 	// console.log(resp.data[0].id);
			// 	var testing = JSON.parse(users);

			// 	console.log(testing);

			// 	for(var key in users.data){
			// 		// console.log(resp.data[key].text);
			// 		this.options[users.data[key].id] = users.data[key].text;
			// 	}
			// 	console.log(this.options);


			// 	// this.options = resp.data.items
			// 	loading(false)
			// })
		}
	}
};
</script>
























<style lang="css" scoped>
</style>
<template>
	<div>
		<button type="button" class="btn bg-purple margin" data-toggle="modal" data-target="#myModal">New Theme</button>

		<!-- Modal -->
		<div id="myModal" class="modal fade" role="dialog">
			<div class="modal-dialog">
				<form method="POST" @submit.prevent="onSubmit" >
					<!-- Modal content-->
					<div class="modal-content">
						<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal">&times;</button>
							<h4 class="modal-title">Modal Header</h4>
						</div>
						<div class="modal-body">
							<div class="form-group" >
								<label>Theme</label>
								<input type="text" class="form-control" v-model="theme">
							</div>

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

	name: 'theme',

	mounted() {
		
	},

	data () {
		return {
			theme:""
		}
	},
	methods:{
		onSubmit(){
			console.log("working ");
			axios.get('/contact_theme', {
				theme : this.theme
			})
			.then(function (response) {
				console.log(response);
				// location.reload();
			})
			.catch(function (error) {
				console.log(error);
			});
		}
	}
}
</script>

<style lang="css" scoped>
</style>
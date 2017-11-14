<template>
	<div>
		<button type="button" class="btn bg-purple margin" data-toggle="modal" data-target="#myModal">New Theme</button>

		<table id="themes" class="table table-bordered table-hover">
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

		var table = $('#themes').DataTable( {});

		table.clear().draw();

		var jqxhr = $.get("/contact_theme/get_all_themes",function(themes){

			var object = JSON.parse(themes);

			// console.log(object);

			for (var i = 0; i < object.length; i++) {

				table.row.add( [
					object[i].id,
					object[i].name,
					'<a href="/contact_theme/'+object[i].id+'/edit" class="btn btn-primary btn-danger"><i class="glyphicon   glyphicon-list"></i> Details</a>'
					] ).draw( false );



			}

		});
		
	},

	data () {
		return {
			theme:""
		}
	},
	methods:{
		onSubmit(){
			console.log("working ");
			axios.post('/contact_theme', {
				theme : this.theme
			})
			.then(function (response) {
				console.log(response);
				location.reload();
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
<template>
	<div>
		<div class="box-body">
			<table id="contacts" class="table table-bordered table-hover">
				<thead>
					<tr>
						<th>id</th>
						<th>Name</th>
						<th>Email</th>
						<th>Edit</th>
					</tr>
				</thead>
				<tbody>
					<tr v-for="skill in contacts">
						<td>{{skill.id}}</td>
						<td>{{skill.name}}</td>
						<td>{{skill.email1}}</td>
						<td><button v-on:click="greet(skill.id)" class="btn btn-primary" >Details</button></td>
					</tr>

				</tbody>
				<tfoot>
					<tr>
					</tr>
				</tfoot>
			</table>
		</div>

		

		<!-- Modal -->
		<div id="myModal" class="modal fade" role="dialog">
			<div class="modal-dialog">

				<!-- Modal content-->
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal">&times;</button>
						<h4 class="modal-title">Modal Header</h4>
					</div>
					<div class="modal-body">
						<section class="content">


							<!-- Profile Image -->
							<div class="box box-primary">
								<div class="box-body box-profile">
									<img class="profile-user-img img-responsive " src="" alt="User profile picture" id="contact-image" height="200" width="200">


									<h3 class="profile-username text-center">Nina Mcintire</h3>

								</div>
								<!-- /.box-body -->
							</div>
							<!-- /.box -->
							
							
						</section>

					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
					</div>
				</div>

			</div>
		</div>



	</div>
</template>

<script>
export default {

	name: 'contactEdit',

	props:['contacts'],

	data () {
		return {

		}
	},
	mounted (){

		$('#contacts').DataTable();

	},
	methods:{

		greet(id){
			console.log(id);

			axios.get('/pab_contacts/get_specific_contact', {
				params: {
					contact_id: id
				}
			})
			.then(function (response) {
				console.log(response.data['contact'].pic_path);
				$('#myModal').modal('show');


				var edit_save = document.getElementById("contact-image");
				edit_save.src = ""+response.data['contact'].pic_path;
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
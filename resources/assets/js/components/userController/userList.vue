<template>
	<div>
		<table id="user-lists" class="table table-bordered table-hover">
			<thead>
				<tr>
					<th>id</th>
					<th>Name</th>
					<th>Department</th>
					<th>Designation</th>
					<th>Contract</th>
					<th>Edit</th>
				</tr>
			</thead>
			<tbody>

				<tr v-for="user_list in active_user_lists">
					<td>{{user_list.user_id}}</td>
					<td>{{user_list.user_name}}</td>
					<td>{{user_list.user_department}}</td>
					<td>{{user_list.user_designation}}</td>
					<td>{{user_list.user_contract_time}}</td>
					<td><button v-on:click="user_edit(user_list.user_id)" class="btn btn-primary" >Edit</button>
						<button v-on:click="user_project(user_list.user_id)" class="btn btn-primary" >Projects</button>
					</td>
					
				</tr>

			</tbody>
			<tfoot>
				<tr>

				</tr>
			</tfoot>
		</table>
	</div>
</template>

<script>
export default {

	name: 'userList',

	props:['active_user_lists'],

	mounted(){

		//console.log(this.active_user_lists);

			 $('#user-lists').DataTable( {
				"paging": true,
				"lengthChange": true,
				"searching": true,
				"ordering": true,
				"info": true,
				"autoWidth": false,
				"scrollX": true
			} );

		},

		data () {
			return {

			}
		},
		methods:{
			user_edit(id){
				window.location.replace('/users/'+id+'/edit', '_blank');
				// window.open("{{URL::to('/') . '/users/"+id+"/roles_list'}}", '_blank');
			},
			user_project(id){
				window.location.replace('/user/'+id+'/user_projects', '_blank');
			}

		}
	}
	</script>


	<style lang="css" scoped>
	</style>
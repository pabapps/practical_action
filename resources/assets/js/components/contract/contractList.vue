<template>
	<div>

		<table id="user-contract-list" class="table table-bordered table-hover">
			<thead>
				<tr>
					<th>id</th>
					<th>Name</th>
					<th>Start Date</th>
					<th>End Date</th>
					<th>Options</th>
				</tr>
			</thead>
			<tbody>

				<tr v-for="user_list in user_contract_list">
					<td>{{user_list.id}}</td>
					<td>{{user_list.user_name}}</td>
					<td>{{user_list.start_date}}</td>
					<td>{{user_list.end_date}}</td>
					<td><button v-on:click="end_notification(user_list.id)" class="btn btn-primary" >End Notification</button>
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

	name: 'contractList',

	props:['user_contract_list'],

	mounted(){

		$('#user-contract-list').DataTable( {
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

		end_notification(id){
			console.log(id);

			axios.post('/user', {
				firstName: 'Fred',
				lastName: 'Flintstone'
			})
			.then(function (response) {
				console.log(response);
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
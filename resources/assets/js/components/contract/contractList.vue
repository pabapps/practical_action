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
	}
}
</script>

<style lang="css" scoped>
</style>
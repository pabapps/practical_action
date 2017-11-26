<template>
	<div>
		<table id="active-user-lists" class="table table-bordered table-hover">
			<thead>
				<tr>
					<th>id</th>
					<th>Name</th>
					<th>Email</th>
					<th>Phone</th>
					<th>Gender</th>
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
	</div>
</template>

<script>
export default {

	name: 'userList',

	mounted(){

		/*"processing": true,
			"serverSide": true,
			"paging": true,
			"lengthChange": true,
			"searching": true,
			"ordering": true,
			"info": true,
			"autoWidth": false,
			"scrollX": true,*/

		var table = $('#active-user-lists').DataTable( {


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
<template>
	<div>
		<div class="box-body">
			<table id="contacts" class="table table-bordered table-hover">
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
		</div>
	</div>
</template>

<script>
export default {

	name: 'contactDisplay',


	
	data () {
		return {
			skills:[]
		}
	},
	mounted:  function (){

		console.log("testing");
		axios.get('/pab_contacts/get_all_contacts', {

		})
		.then(function (response) {
			self.skills = response.data
			console.log(self.skills);
		})
		.catch(function (error) {
			console.log(error);
		});

	},
	methods:{

	}
}
</script>

<style lang="css" scoped>
</style>
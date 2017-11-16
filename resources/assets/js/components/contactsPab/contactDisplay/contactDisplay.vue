<template>
	<div>
		<div class="box-body">
			<table id="contacts" class="table table-bordered table-hover">
				<thead>
					<tr>
						<th>id</th>
						<th>Name</th>
						<th>Email</th>
					</tr>
				</thead>
				<tbody>
					<tr v-for="skill in contacts">
						<td>{{skill.id}}</td>
						<td>{{skill.name}}</td>
						<td>{{skill.email1}}</td>
					</tr>

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

	props:['contacts'],

	
	data () {
		return {
			skills:[]
		}
	},
	mounted (){

		$('#contacts').DataTable();

		this.backEnd();

		this.$http.get('/pab_contacts/get_all_contacts', {
				
			}).then(query_contacts => {
				this.skills = query_contacts.body;

				// console.log(this.skills[0].name);
			})


			console.log(this.contacts);

	},
	methods:{

		backEnd(){

			console.log("testing");
			// axios.get('/pab_contacts/get_all_contacts', {

			// })
			// .then(function (response) {
			// 	this.skills = response.data
			// 	console.log(this.skills);
			// })
			// .catch(function (error) {
			// 	console.log(error);
			// });


			

		}

	}
}
</script>

<style lang="css" scoped>
</style>
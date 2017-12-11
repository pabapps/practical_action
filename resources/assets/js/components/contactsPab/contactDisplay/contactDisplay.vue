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


			

		},
		greet(id){
			console.log(id);

			axios.get('/pab_contacts/get_specific_contact', {
				params: {
					contact_id: id
				}
			})
			.then(function (response) {
				console.log(response.data['category'].name);
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
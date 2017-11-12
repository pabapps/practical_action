<template>
	<div>
		<button type="button" class="btn bg-purple margin" data-toggle="modal" data-target="#myModal">.btn.bg-purple</button>

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
						<p>Some text in the modal.</p>
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

	name: 'theme',

	mounted() {
		console.log("testing");
	},

	data () {
		return {

		}
	}
}
</script>

<style lang="css" scoped>
</style>
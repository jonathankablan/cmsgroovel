 @section('loadingwindow')
<div class="modal fade" id="pleaseWaitDialog" style="width:100%">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h1 style='width:50%'>Processing...Please Wait</h1>
			</div>
			<div class="modal-body">
				<div class="progress">
					<div id='progress-bar'
						class="progress-bar progress-bar-success progress-striped"
						role="progressbar" aria-valuenow="0" aria-valuemin="0"
						aria-valuemax="100" style="width: 0%;"></div>
				</div>
			</div>
		</div>
	</div>
</div>
@show
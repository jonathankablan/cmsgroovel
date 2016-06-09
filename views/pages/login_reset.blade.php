@extends('cmsgroovel.layouts.groovel_admin_login')
@section('content')

	<div class="col-md-12">
		To enter a new password Please fullfill the form :
	</div>
	<br>
	<div class="row col-md-12">
		@if (Session::has('error'))
			<div class="col-md-9">
        <div class="alert alert-danger">
    			{!! Session::get('error') !!}
				</div>
			</div>
		@endif
		<div class="col-md-9">
		<form method="POST" action="{{ url('admin/auth/remind/reset') }}" accept-charset="UTF-8" class="form-horizontal well">	
			{{csrf_field()}}
					<div class="form-group">
						<label for="email" class="col-md-4 control-label">Email :</label>
						<div class="col-md-8">
							<input class="form-control" name="email" type="text" value="" id="email">
						</div>
					</div>
					<div class="form-group">
						<label for="password" class="col-md-4 control-label">Password :</label>
						<div class="col-md-8">
							<input class="form-control" name="password" type="password" id="password">
						</div>
					</div>
					<div class="form-group">
						<label for="password_confirmation" class="col-md-4 control-label">Password confirmation :</label>
						<div class="col-md-8">
							<input class="form-control" name="password_confirmation" type="password" id="password_confirmation">
						</div>
					</div>
		      <div class="form-group">
		          <div class="col-md-offset-4 col-md-8">
		               <input type="submit" id="submitForm" value="send"  class="btn btn-success"/>
		          </div>
		      </div>
			</form>
		</div>
	</div>
@stop
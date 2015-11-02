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
	    {!! Form::open(array('url' => 'admin/auth/remind/reset', 'method' => 'POST', 'class' => 'form-horizontal well')) !!}
			
			{!! Form::hidden('token', $token)!!}
			<div class="form-group">
				{!! Form::label('email', 'Mail :', array('class' => 'col-md-4 control-label')) !!}
				<div class="col-md-8">
					{!! Form::text('email', '', $attributes = array('class' => 'form-control')) !!}
				</div>
			</div>
			<div class="form-group">
				{!! Form::label('password', 'Password :', array('class' => 'col-md-4 control-label')) !!}
				<div class="col-md-8">
					{!! Form::password('password', $attributes = array('class' => 'form-control')) !!}
				</div>
			</div>
			<div class="form-group">
				{!! Form::label('password_confirmation', 'Password confirmation :', array('class' => 'col-md-4 control-label')) !!}
				<div class="col-md-8">
					{!! Form::password('password_confirmation', $attributes = array('class' => 'form-control')) !!}
				</div>
			</div>
      <div class="form-group">
          <div class="col-md-offset-4 col-md-8">
              {!! Form::submit('Send', array('class' => 'btn btn-success')) !!}
          </div>
      </div>
			{!! Form::close()!!}
		</div>
	</div>
@stop
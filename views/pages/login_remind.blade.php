@extends('cmsgroovel.layouts.groovel_admin_login')
@section('content')

<br>
<div class="row col-md-12">
	@if (!Session::has('flash_notice'))
		<div class="col-md-12" style="margin-bottom:50px">
		You forget your password, Please fill your email to send you a new password
		</div>
	@endif
	<br />
	@if (Session::has('error'))
    <div class="col-md-8">
      <div class="alert alert-danger">
				{!! Session::get('error') !!}         
      </div>
    </div>
	@endif
	@if (Session::has('status'))
		<div class="col-md-8">
			<div class="alert alert-success">
				{!! Session::get('status') !!}
			</div>
		</div>
	@else
		<div class="col-md-8">
        <form method="POST" action="{{ url('admin/auth/login/remind') }}" accept-charset="UTF-8" id="rem_form" class="form-horizontal well">
      		{{csrf_field()}}
		     <input style='display:none;' type='text' id='ctrl1' name='ctrl1' value='spamcontroller'>
			 <input style='display:none;' type='text' id='ctrl2' name='ctrl2' value=''>
             <input type='hidden' name='leave_blank'/>
			<div class="form-group {!! $errors->has('email') ? 'error' : '' !!}">
				<label for="email" class="col-md-2 control-label">Email :</label>
				<div class="col-md-10">
					<input class="form-control" name="email" type="text" value="" id="email">
				</div>
			</div>
      <div class="form-group">
          <div class="col-md-offset-2 col-md-10">
                <input type="submit" id="submitForm" value="send"  class="btn btn-default"/>
          </div>
      </div>
	</form>
		</div>
	@endif
</div>

<script>
 $("#submitForm").click(function (event) {
	 $('#rem_form').submit(function() {
		  $( '#ctrl2' ).val($( '#ctrl1' ).val());
		});
 })

 
 </script>
@stop


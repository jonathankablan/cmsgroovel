@extends('cmsgroovel.layouts.groovel_admin_login')

@section('content')
    <div class="row" style="margin-bottom:30px;margin-top:50px">
    	 <div class="col-lg-5 col-lg-offset-3 col-md-9 col-sm-6 col-sm-offset-3">
    	To subscribe Please full fill this formular
    	 </div>
    </div>
    <br>
    <div class="row">
        @if ($errors->count() > 0)
            <div class="col-md-9">
                <div class="alert alert-danger">
                    @foreach($errors->all() as $message)
                        {!! $message !!}<br />
                    @endforeach           
                </div>
            </div>
        @endif
        <div class="col-lg-6 col-lg-offset-3 col-md-9 col-xs-11 col-sm-6 col-sm-offset-3">
             <form method="POST" action=" {{ url('admin/groovelcms/auth/subscribe') }}" accept-charset="UTF-8" id="sub_form" class="form-horizontal well">
            
             {{csrf_field()}}
           
             <input style='display:none;' type='text' id='ctrl1' name='ctrl1' value='spamcontroller'>
			 <input style='display:none;' type='text' id='ctrl2' name='ctrl2' value=''>
             <input type='hidden' name='leave_blank'/>
             <div class="form-group">
                <label for="username" class="col-md-4 control-label required">Username :</label>
                <div class="col-md-8">
                    <input class="form-control" name="username" type="text" value="" id="username">
                </div>
            </div>
             <div class="form-group">
                <label for="pseudo" class="col-md-4 control-label required">Pseudo :</label>
                <div class="col-md-8">
                    <input class="form-control" name="pseudo" type="text" value="" id="pseudo">
                </div>
            </div>
    		<div class="form-group {!! $errors->has('email') ? 'error' : '' !!}">
    			<label for="email" class="col-md-4 control-label required">Mail :</label>
    			<div class="col-md-8">
    				<input class="form-control" name="email" type="text" value="" id="email">
    			</div>
    		</div>
    		<div class="form-group {!! $errors->has('password') ? 'error' : '' !!}">
    			<label for="password" class="col-md-4 control-label required">Password :</label>
    			<div class="col-md-8">
    				<input class="form-control" name="password" type="password" value="" id="password">
    			</div>
    		</div>
    		<div class="form-group">
    			<label for="password_confirmation" class="col-md-4 control-label required">Password Confirm :</label>
    			<div class="col-md-8">
    				<input class="form-control" name="password_confirmation" type="password" value="" id="password_confirmation">
    			</div>
    		</div>
            <div class="form-group">
                <div class="col-md-offset-4 col-md-8">
                     <input type="submit" id="submitForm" value="send"  class="btn btn-default"/>
                </div>
            </div>
    		</form>
        </div>
    </div>
 <script>
 $("#submitForm").click(function (event) {
	 $('#sub_form').submit(function() {
		  $( '#ctrl2' ).val($( '#ctrl1' ).val());
		});
 })

 
 </script>
@stop
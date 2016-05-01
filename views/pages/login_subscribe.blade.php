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
            {!! Form::open(array('id'=>'sub_form','url' => 'admin/auth/subscribe', 'method' => 'POST', 'class' => 'form-horizontal well')) !!}
             <input style='display:none;' type='text' id='ctrl1' name='ctrl1' value='spamcontroller'>
			 <input style='display:none;' type='text' id='ctrl2' name='ctrl2' value=''>
             <input type='hidden' name='leave_blank'/>
             <div class="form-group">
                {!! Form::label('username', 'Username :', array('class' => 'col-md-4 control-label required')) !!}
                <div class="col-md-8">
                    {!! Form::text('username', '', $attributes = array('class' => 'form-control')) !!}
                </div>
            </div>
             <div class="form-group">
                {!! Form::label('pseudo', 'Pseudo :', array('class' => 'col-md-4 control-label required')) !!}
                <div class="col-md-8">
                    {!! Form::text('pseudo', '', $attributes = array('class' => 'form-control')) !!}
                </div>
            </div>
    		<div class="form-group {!! $errors->has('email') ? 'error' : '' !!}">
    			{!! Form::label('email', 'Mail :', array('class' => 'col-md-4 control-label required')) !!}
    			<div class="col-md-8">
    				{!! Form::text('email', '', $attributes = array('class' => 'form-control')) !!}
    			</div>
    		</div>
    		<div class="form-group {!! $errors->has('password') ? 'error' : '' !!}">
    			{!! Form::label('password', 'Password :', array('class' => 'col-md-4 control-label required')) !!}
    			<div class="col-md-8">
    				{!! Form::password('password', $attributes = array('class' => 'form-control')) !!}
    			</div>
    		</div>
    		<div class="form-group">
    			{!! Form::label('password_confirmation', 'Password Confirm :', array('class' => 'col-md-4 control-label required')) !!}
    			<div class="col-md-8">
    				{!! Form::password('password_confirmation', $attributes = array('class' => 'form-control')) !!}
    			</div>
    		</div>
            <div class="form-group">
                <div class="col-md-offset-4 col-md-8">
                    <!-- {!! Form::submit('Send', array('id'=>'submitForm','class' => 'btn btn-success')) !!}-->
                     <input type="submit" id="submitForm" value="send"  class="btn btn-default"/>
                </div>
            </div>
    		{!! Form::close()!!}
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
@extends('cmsgroovel::layouts.groovel_admin_login')
@section('content')


<div class="col-md-12" style="margin-bottom:50px">
       To connect please full fill the form with your pseudo and password:
    </div>
    <br>
    <div class="row col-md-12">
   
        @if (Session::has('flash_error'))
            <div class="col-md-7">
                <div class="alert alert-danger">
                    {{ Session::get('flash_error') }}
                </div>
            </div>
        @endif
        @if (count($errors)>0)
         <div class="col-md-7">
                <div class="alert alert-danger">
                	@foreach($errors->get('username') as $message)
                	<ul>
	                     <li>{{ $message }}</li>
	           		 </ul>
					@endforeach	@foreach($errors->get('email') as $message)
                	<ul>
	                     <li>{{ $message }}</li>
	           		 </ul>
					@endforeach
	           </div>
         </div>
         @endif
         @if (Session::has('flash_notice'))
            <div class="col-md-7">
                <div class="alert alert-danger">
                    {{ Session::get('flash_notice') }}
                </div>
            </div>
        @endif
        <div class="col-md-7">
            {{ Form::open(array('url' => 'admin/auth/login/form', 'method' => 'POST', 'class' => 'form-horizontal well')) }}
                <input type='hidden' name='leave_blank'/>
      
             <div class="form-group form-inline">
                {{ Form::label('pseudo', 'Pseudo :', array('class' => 'col-md-5 control-label required')) }}
                <div class="col-md-5">
                    {{ Form::text('pseudo', '', $attributes = array('class' => 'form-control')) }}
                </div>
            </div>
            <div class="form-group form-inline">
                {{ Form::label('password', 'Password :', array('class' => 'col-md-5 control-label required')) }}
                <div class="col-md-5">
                    {{ Form::password('password', $attributes = array('class' => 'form-control')) }}
                </div>
            </div>
            <div class="checkbox pull-right">
                {{ Form::checkbox('rememberme') }}Remember me
            </div>
            <div class="form-group">
                <div class="col-md-offset-3 col-md-9">
                    {{ Form::submit('Send', array('class' => 'btn btn-success')) }}
                </div>
            </div>
            {{ Form::close()}}
        </div>
        
    </div>
    <div class="col-md-2">
            <p>
                {{ link_to('admin/auth/login/remind/form', 'I forget my password...', array('class' => 'btn btn-success')) }}
            </p>
    </div>
    <div class="col-md-8 col-md-offset-2">
        If you haven't got an account click under below <br/>
         <br/>
        {{ link_to('admin/auth/subscribe/form', 'I subscribe !', array('class' => 'btn btn-info')) }}
    </div>
@stop
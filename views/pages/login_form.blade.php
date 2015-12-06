@extends('cmsgroovel.layouts.groovel_admin_login')
@section('content')

 <div class="row-fluid">
	  <div class="col-md-12 col-md-offset-3">
   
        @if (Session::has('flash_error'))
            <div class="col-md-7">
                <div class="alert alert-danger">
                    {!! Session::get('flash_error') !!}
                </div>
            </div>
        @endif
        @if (count($errors)>0)
         <div class="col-md-7">
                <div class="alert alert-danger">
                	@foreach($errors->get('username') as $message)
                	<ul>
	                     <li>{!! $message !!}</li>
	           		 </ul>
					@endforeach	@foreach($errors->get('email') as $message)
                	<ul>
	                     <li>{!! $message !!}</li>
	           		 </ul>
					@endforeach
	           </div>
         </div>
         @endif
         @if (Session::has('flash_notice'))
            <div class="col-md-7">
                <div class="alert alert-danger">
                    {!! Session::get('flash_notice') !!}
                </div>
            </div>
        @endif
	        <div class="col-md-6">
	            {!! Form::open(array('url' => 'admin/auth/login/form', 'method' => 'POST', 'class' => 'form-horizontal well')) !!}
	                <input type='hidden' name='leave_blank'/>
	      
	             <div class="form-group form-inline font">
	                {!! Form::label('pseudo', 'Pseudo :', array('class' => 'col-md-5 control-label required')) !!}
	                <div class="col-md-5">
	                    {!! Form::text('pseudo', '', $attributes = array('class' => 'form-control')) !!}
	                </div>
	            </div>
	            <div class="form-group form-inline font">
	                {!! Form::label('password', 'Password :', array('class' => 'col-md-5 control-label required')) !!}
	                <div class="col-md-5">
	                    {!! Form::password('password', $attributes = array('class' => 'form-control')) !!}
	                </div>
	            </div>
	            <div class="checkbox pull-right font">
	                {!! Form::checkbox('rememberme') !!}Remember me
	            </div>
	            <div class="form-group" style='margin-top:50px'>
	                <div class="col-md-2">
	                    {!! Form::submit('Connect', array('class' => 'btn btn-success font')) !!}
	                </div>
	                 <div class="col-md-2">
				         {!! link_to('admin/auth/subscribe/form', 'I subscribe !', array('class' => 'btn btn-info font')) !!}
				    </div>
		             <div class="col-md-2">
		                {!! link_to('admin/auth/login/remind/form', 'I forget my password...', array('class' => 'btn btn-success font')) !!}
				    </div>
				   
			     </div>
	      
	            {!! Form::close()!!}
	        </div>
      </div>   
   
    
        
    </div>

@stop
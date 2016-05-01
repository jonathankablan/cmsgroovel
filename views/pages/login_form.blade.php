@extends('cmsgroovel.layouts.groovel_admin_login')
@section('content')

 <div class="row">
	  <div class="col-lg-5 col-lg-offset-3 col-sm-8 col-sm-offset-2  col-md-8 col-md-offset-3 col-xs-12  " style='margin-top:50px'>
   
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
	            {!! Form::open(array('url' => 'admin/auth/login/form', 'method' => 'POST', 'class' => 'form-horizontal well')) !!}
	                <input type='hidden' name='leave_blank'/>
	      			<input type="hidden" name="_token" value="{{csrf_token()}}" />
	             <div class="form-group form-inline">
	                {!! Form::label('pseudo', 'Pseudo :', array('class' => 'col-md-5 control-label required')) !!}
	                <div class="col-md-5">
	                    {!! Form::text('pseudo', '', $attributes = array('class' => 'form-control')) !!}
	                </div>
	            </div>
	            <div class="form-group form-inline">
	                {!! Form::label('password', 'Password :', array('class' => 'col-md-5 control-label required')) !!}
	                <div class="col-md-5">
	                    {!! Form::password('password', $attributes = array('class' => 'form-control')) !!}
	                </div>
	            </div>
	            <div class="checkbox pull-right">
	                {!! Form::checkbox('rememberme') !!}Remember me
	            </div>
	            <div class="row" style='margin-top:50px'>
	                <div class="col-lg-2 col-md-2 col-sm-2 col-xs-4">
	                    {!! Form::submit('Connect', array('class' => 'btn btn-success')) !!}
	                </div>
	                 <div class="col-lg-2 col-sm-2 col-md-2 col-xs-5 col-xs-offset-1">
				         {!! link_to('admin/auth/subscribe/form', 'I subscribe !', array('class' => 'btn btn-info')) !!}
				    </div>
		             <div class="col-lg-3 col-sm-2 col-sm-offset-1 col-md-2  col-md-offset-1 col-xs-7">
		                {!! link_to('admin/auth/login/remind/form', 'I forget my password...', array('class' => 'btn btn-success')) !!}
				    </div>
				   
			     </div>
	      
	            {!! Form::close()!!}
      </div>   
   
    
        
    </div>

@stop
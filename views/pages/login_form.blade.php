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
         @if ($errors->count() > 0)
            <div class="col-md-9">
                <div class="alert alert-danger">
                    @foreach($errors->all() as $message)
                        {!! $message !!}<br />
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
	             <form class="form-horizontal well" role="form" method="POST" action="{{ url('admin/auth/login/form') }}">
	                <input type='hidden' name='leave_blank'/>
	      			<input type="hidden" name="_token" value="{{csrf_token()}}" />
	             <div class="form-group form-inline">
	                 <label class="col-md-5 control-label required">Pseudo:</label>
	                <div class="col-md-5">
	                    <input type='text' name='pseudo' class="form-control"/>
	                </div>
	            </div>
	            <div class="form-group form-inline">
	                <label class="col-md-5 control-label required">Password:</label>
	                <div class="col-md-5">
	                    <input type="password" class="form-control" name="password">
	                </div>
	            </div>
	            <div class="checkbox pull-right">
	                 <input type="checkbox" name="rememberme">Remember me
	            </div>
	            <div class="row" style='margin-top:50px'>
	                <div class="col-lg-2 col-md-2 col-sm-2 col-xs-4">
	                      <input class="btn btn-success" value="Log in" type="submit">
	                </div>
	                 <div class="col-lg-2 col-sm-2 col-md-2 col-xs-5 col-xs-offset-1">
				          <a class="btn btn-info" href="{{ url('admin/auth/subscribe/form') }}">I subscribe !</a>
				    </div>
		             <div class="col-lg-3 col-sm-2 col-sm-offset-1 col-md-2  col-md-offset-1 col-xs-7">
		                 <a class="btn btn-success" href="{{ url('admin/auth/login/remind/form') }}">I forget my password... !</a>
				    </div>
				   
			     </div>
	      
	        </form>
      </div>   
   
    
        
    </div>

@stop
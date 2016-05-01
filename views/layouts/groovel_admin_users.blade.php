<!DOCTYPE html>
<html lang="en">
  <head>
    @include('cmsgroovel.includes.groovel_admin_users_head')
  </head>

  <body>
  <div class="container-fluid">
	   @if(Session::get('user_privileges')!=null)
		  @if(Session::get('user_privileges')['role']==null)
		      @include('cmsgroovel.includes.groovel_default_user_header')
		  @elseif(Session::get('user_privileges')['role']=='ADMIN')
		   @include('cmsgroovel.includes.groovel_admin_header')
		   @else
		   @include('cmsgroovel.includes.groovel_default_user_header')
		  @endif
		@endif
	 	<div class="row">   
		    @if(Session::get('user_privileges')!=null)
		        	@if(Session::get('user_privileges')['role']=='ADMIN')
		        	  <div class="col-sm-2">
		      			@include('cmsgroovel.includes.groovel_admin_sidebar')
		      		  </div>
		      	    @endif
				@endif
		         <div class="col-lg-8 col-lg-offset-3 col-sm-9 col-sm-offset-1 col-xs-12 col-md-12 col-md-offset-2">
		 			   @yield('content')
		        </div>
		  </div>
  </div>

    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
 
  </body>
</html>


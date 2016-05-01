<!DOCTYPE html>
<html lang="en">
  <head>
    @include('cmsgroovel.includes.groovel_admin_layout_head')
  </head>

  <body>
  @include('cmsgroovel.toolkits.popup.popupModal')   
  
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
		         <div class="col-sm-6 col-sm-offset-2 col-xs-12 col-md-9 col-md-offset-0">
		 			   @yield('content')
		        </div>
		  </div>
  </div>
 

    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
 
  </body>
</html>


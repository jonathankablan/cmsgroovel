<!DOCTYPE html>
<html lang="en">
  <head>
    @include('cmsgroovel.includes.groovel_admin_menu_head')
  </head>

  <body>
  @if(Session::get('user_privileges')!=null)
	  @if(Session::get('user_privileges')['role']==null)
	      @include('cmsgroovel.includes.groovel_default_user_header')
	  @elseif(Session::get('user_privileges')['role']=='ADMIN')
	   @include('cmsgroovel.includes.groovel_admin_header')
	   @else
	   @include('cmsgroovel.includes.groovel_default_user_header')
	  @endif
	@endif
    <div class="container-fluid">
      <div class="row">
        @if(Session::get('user_privileges')!=null)
        	@if(Session::get('user_privileges')['role']=='ADMIN')
      			@include('cmsgroovel.includes.groovel_admin_sidebar')
      	    @endif
		@endif
        <div class="col-xs-11 col-md-11 col-md-offset-2">
 			   @yield('content')
       </div>
      </div>
    </div>

    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
 
  </body>
</html>


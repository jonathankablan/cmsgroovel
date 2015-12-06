<!DOCTYPE html>
<html lang="en">
  <head>
    @include('cmsgroovel.includes.groovel_admin_content_head')
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
        <div class="col-xs-12 col-md-12 col-md-offset-0.75">
 			   @yield('content')
       </div>
      </div>
    </div>

    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
 
  </body>
</html>


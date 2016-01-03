<!DOCTYPE html>
<html lang="en">
  <head>
    @include('cmsgroovel.includes.groovel_admin_login_head')
  </head>

  <body>
	 <div id='wrap' class="container-fluid">
		 <div class="row-fluid">
			 <div class="col-md-10 col-md-offset-3 title" style="margin-bottom:50px;font-family: times new roman;color:#0489B1">
			   Welcome to groovel platform
			 </div>
		</div>
		 @yield('content')
	</div>
	 <footer>  
     	<div class="row-fluid">
     		<div class="col-md-10 col-md-offset-3">
	        	{!! HTML::image('packages/groovel/cmsgroovel/groovel/admin/images/groovel.png', $alt="groovel", $attributes = array('style'=>'width:100px;height:50px')) !!} Maintained by the <a href="http://www.groovelcms.com/">groovel core team</a> 
			    Code licensed <a rel="license" href="https://github.com/groovel/cmsgroovel/blob/master/LICENCE.txt" target="_blank">GNU GENERAL PUBLIC LICENSE</a>
			</div>
       </div>
      
	 </footer>
  </body>
</html>


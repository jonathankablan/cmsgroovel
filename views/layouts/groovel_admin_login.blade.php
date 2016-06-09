<!DOCTYPE html>
<html lang="en">
  <head>
    @include('cmsgroovel.includes.groovel_admin_login_head')
  </head>

  <body>
	 <div id='wrap' class="container-fluid">
		 @yield('content')
	</div>
	 <footer>  
     	<div class="row">
     		<div class="col-md-10 col-md-offset-3">
	        	<img src="/groovel/cmsgroovel/groovel/admin/images/groovel.png" style="width:100px;height:50px" alt="groovel">Maintained by the <a href="http://www.groovelcms.com/">groovel</a> 
			    Code licensed <a rel="license" href="https://github.com/groovel/cmsgroovel/blob/master/LICENCE.txt" target="_blank">GNU GENERAL PUBLIC LICENSE</a>
			</div>
       </div>
      
	 </footer>
  </body>
</html>


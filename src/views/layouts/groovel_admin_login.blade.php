<!DOCTYPE html>
<html lang="en">
  <head>
    @include('cmsgroovel::includes.groovel_admin_head')
  </head>

  <body>
 <div id="logo" class="col-md-12 col-md-offset-2" style="font-size: 50px;margin-bottom:50px;">
   Welcome to Groovel CMS artisan
 </div>

  <div id="content" class="col-md-8 col-md-offset-3">
      @yield('content')
    </div>
 
  </body>
</html>


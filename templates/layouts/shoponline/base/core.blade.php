<!DOCTYPE html>
<html>
    <head>
        @include('includes.head')
    </head>
<body>
    <!-- menubar -->
    <header>
        @include('includes.header')
    </header><!-- /header -->
   <div class="line">
     	@yield('content')
	</div>
  
 
    <!-- footer -->
    <footer>
        @include('includes.footer')
    </footer>
</body>
</html>
<!DOCTYPE html>
 <html>
<title>{!!$layouts['title']!!}</title>  
    <head>
        @include('blog.includes.head')
    </head>

<body>
    <!-- menubar -->
     @include('blog.includes.header')
     @yield('content') 
 
 
	 

 
    <!-- footer -->
    <footer>
        @include('blog.includes.footer')
    </footer>
</body>
</html>
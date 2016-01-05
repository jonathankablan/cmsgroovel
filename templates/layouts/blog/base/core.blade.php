<!DOCTYPE html>
 <html>
<title>Groovel Blog</title>  
    <head>
        @include('blog.includes.head')
    </head>

<body>
    <!-- menubar -->
     @include('blog.includes.header')
     @yield('content') 
 
    {!!HTML::style('blog/css/bootstrap.min.css')!!}
  {!!HTML::style('blog/css/clean-blog.min.css')!!}
 {!!HTML::script('blog/js/jquery.js')!!}

 
    <!-- footer -->
    <footer>
        @include('blog.includes.footer')
    </footer>
</body>
</html>
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
 
    <!-- content -->
    <article>
        @yield('content')
    </article>
 
    <!-- footer -->
    <footer>
        @include('includes.footer')
    </footer>
</body>
</html>
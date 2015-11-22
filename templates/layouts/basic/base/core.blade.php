<!DOCTYPE html>
<html>
    <head>
        @include('basic.includes.head')
    </head>
<body>
    <!-- menubar -->
    <header>
        @include('basic.includes.header')
    </header><!-- /header -->
 
    <!-- content -->
    <article>
        @yield('content')
    </article>
 
    <!-- footer -->
    <footer>
        @include('basic.includes.footer')
    </footer>
</body>
</html>
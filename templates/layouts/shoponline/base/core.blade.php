<!DOCTYPE html>
<html>
    <head>
        @include('shoponline.includes.head')
    </head>
<body>
    <!-- menubar -->
    <header>
        @include('shoponline.includes.header')
    </header><!-- /header -->
   <div class="line">
     	@yield('content')
     	@foreach ($contents as $content)
     	            @if($content['contentType']=='product')
                  	<div class="s-12 l-4" style="margin-top:50px;margin-left:50px;">
                          {!! HTML::image($content['content']['myfiles'],$alt='test', $attributes =array('style'=>'width:200px;height:200px')) !!}
                         <p class="margin-bottom">Name : {{$content['title']}} </p>
                         <p class="margin-bottom">Price : {{$content['content']['price']}} </p>
                          <p class="margin-bottom">Devise : {{$content['content']['devise']}} </p>
                        <form class="customform s-12" action="">
                           <div class="margin-bottom"><button type="submit">Add to Cart</button></div>
                        </form>
                     </div>
                    @endif
         @endforeach
	</div>
  
 
    <!-- footer -->
    <footer>
        @include('shoponline.includes.footer')
    </footer>
</body>
</html>
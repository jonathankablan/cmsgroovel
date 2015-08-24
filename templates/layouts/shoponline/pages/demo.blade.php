@extends('base.core')
@section('content')



<div id = "divBackground" style="position: fixed; z-index: 999; height: 100%; width: 100%; top: 0; left:0; background-color: Black; filter: alpha(opacity=60); opacity: 0.6; -moz-opacity: 0.8;display:none">

</div>


         <div class="box">
            <div class="margin">
               <!-- CONTENT -->
               <section class="s-12 l-9 right">
                  <h1>Content</h1>
                  <div class="margin"> 
                  
                  @foreach ($contents as $content)
                  		<div class="s-12 l-4">
                         <!--  {{ HTML::image('styles/img/330x190-3.jpg') }}-->
                          {{ HTML::image($content['myfiles']) }}
                         <p class="margin-bottom">Name : {{$content['title']}} </p>
                         <p class="margin-bottom">Price : {{$content['price']}} </p>
                          <p class="margin-bottom">Devise : {{$content['devise']}} </p>
                        <form class="customform s-12" action="">
                           <div class="margin-bottom"><button type="submit">Add to Cart</button></div>
                        </form>
                     </div>
                   @endforeach
                    
                  </div>
               </section>
               <!-- ASIDE NAV -->
               <aside class="s-12 l-3">
                  <h3>Navigation</h3>
                  <div class="aside-nav">
                     <ul>
                        <li><a>Home</a></li>
                        <li>
                           <a>Product</a>
                           <ul>
                              <li><a>Product 1</a></li>
                              <li><a>Product 2</a></li>
                              <li>
                                 <a>Product 3</a>
                                 <ul>
                                    <li><a>Product 3-1</a></li>
                                    <li><a>Product 3-2</a></li>
                                    <li><a>Product 3-3</a></li>
                                 </ul>
                              </li>
                           </ul>
                        </li>
                        <li>
                           <a>Company</a>
                           <ul>
                              <li><a>About</a></li>
                              <li><a>Location</a></li>
                           </ul>
                        </li>
                         <li><a onclick='showModalPopUp()'>Contact</a></li>
                         <div id='dialog'>
                         @include('cmsgroovel::pages.contact_form')
                         </div>
                      </ul>
                  </div>
               </aside>
            </div>
         </div>

<script type = "text/javascript">

$(document).ready(function() {
	var bcgDiv = document.getElementById("dialog");
	bcgDiv.style.display="none";
});
                  
function showModalPopUp(){
	 var bcgDiv = document.getElementById("dialog");
     bcgDiv.style.display="block";
     $('#modal').modal('show');
}
</script>

@stop
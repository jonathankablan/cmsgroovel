@extends('blog.base.core')
@section('content')   
   <!-- Main Content -->
    <!-- Page Content -->
    <div class="container">
 		   
 	   <div class="row">

            <!-- Blog Entries Column -->
            <div class="col-md-12">
                       @if($content['contentType']=='blog')
		                    <h2>
		                 		<a href="{{url('blog/content/show?contenttranslationid='.$content['contenttranslationid'].'&contentid='.$content['contentid'])}}"> {!!$content['title']!!}</a>
		             		</h2>
		             		<p class="lead">
		                    	by {!!$content['author']!!}
		                    </p>
		                    <p><span class="glyphicon glyphicon-time"></span> Posted on {!!$content['created_at']!!}</p>
							<hr>
							@if(array_key_exists('myfiles',$content['content']))
							 	@if($content['content']['myfiles']!=null)
			                	<img class="img-responsive" src={!!$content['content']['myfiles']!!} alt="">
			                	@endif	
			         		@endif	                        
			                
		     	            <div id='morecomments' style='display:block'>
		     	            {!!$content['content']['post']!!}
		     	            <hr>
		     	        
				     	      <div class='row'>  
					     	      <div class="col-md-8">  
						     	         <!-- Comments Form -->
						               @include('cmsgroovel.toolkits.comment.comment_form')
						
						                <hr>
						     	        
						     	        <!-- Comment -->
						     	         @foreach ($content['comments'] as $comment)
						                <div class="media">
						                    <a class="pull-left" href="#">
						                        @if($comment['author_picture']!=null)
						                           <img class="media-object" src={!!$comment['author_picture'] !!} style='width:60px;height:60px'>
						                        @else
						                        	<img class="media-object" src="http://placehold.it/64x64" alt="">
						                        @endif
						                    </a>
						                    <div class="media-body">
						                        <h4 class="media-heading">{!!$comment['author_pseudo']!!}
						                            <small>{!!$comment['created_at']!!}</small>
						                        </h4>
						                        {!!$comment['comment']!!}
						                    </div>
						                </div>
										@endforeach
					            </div>
					         </div>
					      </div>
			           	@endif
	                <hr>
		        </div>
           </div>
        </div>  
         <style>
          .content{display :none;}
         </style>

    
@stop

@extends('blog.base.core')
@section('content')   
   <!-- Main Content -->
    <!-- Page Content -->
    <div class="container">
 		   
 	   <div class="row">

            <!-- Blog Entries Column -->
            <div class="col-md-12">
            @if($contents!=null)
        	 @foreach ($contents as $content)
        	   <div class="col-md-12">
		                   @if($content['contentType']=='blog')
		                    <h2>
		                 		<a href="#"> {!!$content['title']!!}</a>
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
			                <hr>
		     	            <p>{!!$content['description']!!}</p>
		     	            <a class="btn btn-primary" href="#" id='readmore'>Read More <span class="glyphicon glyphicon-chevron-right"></span></a>
		     	            <hr>
		     	            <div id='morecomments' style='display:none'>
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
					    </div>
			           	@endif
		             @endforeach
		           @endif 
		                <hr>
		        </div>
     	         <!-- Pager -->
                 <ul class="pager">
					{!! $contents->render() !!}
	             </ul>
            
         </div>
        </div>  
         <style>
          .content{display :none;}
         </style>

    
@stop

@extends('blog.base.core')
@section('content')   
   <!-- Main Content -->
    <div class="container">
        <div class="row">
            <div class="col-lg-8 col-lg-offset-2 col-md-10 col-md-offset-1">
                @foreach ($contents as $content)
     	            @if($content['contentType']=='blog')
                  	<div class="post-preview">
                        <h2 class="post-title">
                           {{$content['title']}}
                        </h2>
						<div>
						@if(array_key_exists('subtitle',$content['content']) )
							{!!$content['content']['subtitle']!!}
						@endif
						</div>
						<div>
						@if(array_key_exists('blogtitle',$content['content']) )
                       	 {!!$content['content']['blogtitle']!!}
                       	@endif
						</div>
               		@if(array_key_exists('myfiles',$content) )
                    	{!! HTML::image($content['content']['myfiles'],$alt='test', $attributes =array('style'=>'width:200px;height:200px')) !!}
					@endif
					</div>
					
                    @endif
				@endforeach
             <hr>
                <!-- Pager -->
                <ul class="pager">
                    <li class="next">
                        <a href="#">Older Posts &rarr;</a>
                    </li>
                </ul>
            </div>
        </div>
    </div>

    <hr>
@stop

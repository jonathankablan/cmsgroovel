<div class="col-xs-8 col-sm-8 col-lg-8" style='margin-top:100px;margin-left:100px;width:1080px'>
    
    <div id='dialog'>
       @include('cmsgroovel.pages.forum.newreply_form')
   </div>
  
    <table align="center" border="0" cellpadding="6" cellspacing="0" width="100%">
   		<tbody>
   				     <tr valign="top">
					<td  width="120px">
						<div class='thumbnail'>
							&nbsp;
							@if($topic_author->picture==null)
								<img src="/groovel/cmsgroovel/groovel/admin/images/avatar.png" alt="default avatar">
							@endif
							@if($topic_author->picture!=null)
								<img src="/{{$topic_author->picture}}">
							@endif
						</div>
						<div >
							&nbsp;<br>
							<div>Join Date: {!!$topic_author->created_at!!}</div>
							<div>{!!$topic_author->pseudo!!}    </div>
						</div>
				      </td>
						<td id={!!$topic_id!!} style='padding-left:10px'>
								<!-- icon and title -->
								<div>
								<img src="/groovel/cmsgroovel/ionicons/png/email.png" alt="email" style='width:20px;height:20px'>
							    {!!$topic_date!!}
								<strong>{!!$topic!!}</strong>
								</div>
							<br/>
							<br/>
							<!-- message -->
							<div id={!!$topic_id!!}>	
								{!!$question!!}
							</div>		
							</td>
			</tr>
			<tr>
				<td class="alt2" >
				</td>
				<td class="alt1">
					<!-- controls -->
						@if(\Auth::user()!=null)
		        			<a href="#" style="margin-left:500px;color:black;font-size:1.3em" class="color:black" onclick="showModalPopUp()">Reply</a>
		        		@else
		        			<a href="#" style="margin-left:500px;color:black;font-size:1.3em" class="color:black" onclick="pleaseConnect()">Reply</a>
		        		@endif
		        		 <a style='margin-left:40px;color:black;font-size:1.3em' class='color:black' href="#" rel="nofollow" onclick='loadComments()'>More Comments</a>
				</td>
			</tr>
	   	     @foreach ($answers as $answer)
		   	     <tr valign="top" name='morecomments' style='display: none'>
		   	    	<td  width="120px">
						<div class='thumbnail'>
							&nbsp;
							@if( $answer->answer_author->picture==null)
								<img src="/groovel/cmsgroovel/groovel/admin/images/avatar.png" alt="default avatar">
							@endif
							@if( $answer->answer_author->picture!=null)
								<img src="/{{$answer->answer_author->picture}}">
							@endif
						</div>
						<div >
							&nbsp;<br>
							<div>Join Date: {!! $answer->answer_author->created_at!!}</div>
							<div>{!! $answer->answer_author->pseudo!!}    </div>
							<div>    </div>
						</div>
				      </td>
						<td id={!!$answer->id!!} style='padding-left:10px'>
								<!-- icon and title -->
								<div>
									<img src="/groovel/cmsgroovel/ionicons/png/email.png" alt="email" style='width:20px;height:20px'>
							        {!!$answer->created_at!!}             
									<strong><!-- google_ad_section_start -->Re:{!!$topic!!}<!-- google_ad_section_end --></strong>
								</div>
							<br/>
							<br/>
							<!-- message -->
							<div id={!!$answer->id!!}>	
							{!!$answer->answer!!}
							</div>		
							</td>
			</tr>
			<tr  name='morecomments_link' style='display: none'>
				<td class="alt2" >
				</td>
				<td class="alt1">
					<!-- controls -->
						@if(\Auth::user()!=null)
		        			<a href="#" style="margin-left:500px;color:black;font-size:1.3em" class="color:black" onclick="showModalPopUp()">Reply</a>
		        		@else
		        			<a href="#" style="margin-left:500px;color:black;font-size:1.3em" class="color:black" onclick="pleaseConnect()">Reply</a>
		        		@endif
		        		 <a style='margin-left:40px;color:black;font-size:1.3em' class='color:black' href="#" rel="nofollow" onclick='loadComments()'>More Comments</a>
		        		 @if(Session::get('user_privileges')['role']=='ADMIN')
		        		<!--{!! HTML::link('forum/topic/answer/delete/?forumid='.$forumid.'&answerid='.$answer->id, 'Delete',array('style'=>'margin-left:10px;color:black;font-size:1.3em','class'=>'color:black'))!!}-->
		        		 <a href="{{url('forum/topic/answer/delete/?forumid='.$forumid.'&answerid='.$answer->id) }}" style="margin-left:10px;color:black;font-size:1.3em" class="forumlink">Delete</a>
					                  					
		        		@endif
				</td>
			</tr>
			
	         @endforeach
		</tbody>
	</table>
	
</div>
<script>
function loadComments(){
	  var comments=document.getElementsByName('morecomments');
	  var comments_link=document.getElementsByName('morecomments_link');
	  for(i=0;i<comments.length;i++){
	    comments[i].style='visible';
	    comments_link[i].style='visible';
	  }
	}

function showModalPopUp(){
	var bcgDiv = document.getElementById("dialog");
    bcgDiv.style.display="block";
    $('#modal').modal('show');
}
</script>
@stop
 
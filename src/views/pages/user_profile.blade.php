@extends('cmsgroovel::layouts.groovel_admin_editor')
 @section('content')
<!-- place in header of your html document -->
<div class="col-sm-12 main">
 	<div class="col-md-12" style='margin-top:50px' id='content'>
 	    {{ HTML::image('packages/groovel/cmsgroovel/groovel/admin/images/edit.jpg', $alt="edit", $attributes = array('id' => 'editButton','style'=>'width:20px;height:20px','class'=>'btnEditUserProfile')) }}
					                   
 
		<div id="userphoto" class="thumbnail">
		@if(Session::get('user')['userpicture']==null)
			{{ HTML::image('packages/groovel/cmsgroovel/groovel/admin/images/avatar.png', $alt="default avatar") }}
		@endif
		@if(Session::get('user')['userpicture']!=null)
		{{HTML::image( Session::get('user')['userpicture'],'')}}
		@endif
		</div>
		<h1>{{Session::get('user')['username']}}</h1>
		<input type="hidden" id="user" value={{Session::get('user')['id']}}>

		<!--<nav id="profiletabs">
			<ul class="clearfix">
				<li><a href="#settings">Settings</a></li>
			</ul>
		</nav>

		<section id="bio">
			<p>
				Various content snippets courtesy of <a
					href="http://bluthipsum.com/">Bluth Ipsum</a>.
			</p>

			<p>Can't a guy call his mother pretty without it seeming strange?
				Amen. I think that's one of Mom's little fibs, you know, like I'll
				sacrifice anything for my children.</p>

			<p>She's always got to wedge herself in the middle of us so that she
				can control everything. Yeah. Mom's awesome. I run a pretty tight
				ship around here. With a pool table.</p>
		</section>

			 <section id="activity" class="hidden">
			<p>Most recent actions:</p>

			<p class="activity">@10:15PM - Submitted a news article</p>

			<p class="activity">@9:50PM - Submitted a news article</p>

			<p class="activity">@8:15PM - Posted a comment</p>

			<p class="activity">
				@4:30PM - Added <strong>someusername</strong> as a friend
			</p>

			<p class="activity">@12:30PM - Submitted a news article</p>
		</section>

	<section id="friends" class="hidden">
			<p>Friends list:</p>

			<ul id="friendslist" class="clearfix">
				<li><a href="#"><img src="images/avatar.png" width="22" height="22">
						Username</a></li>
				<li><a href="#"><img src="images/avatar.png" width="22" height="22">
						SomeGuy123</a></li>
				<li><a href="#"><img src="images/avatar.png" width="22" height="22">
						PurpleGiraffe</a></li>
			</ul>
		</section>-->
	<div class="col-md-12" 
		<section id="settings" >
			
			<p class="setting">
			<span>Pseudo</span>
				@if(Session::get('user')['pseudo']==null)
				N/A
				@endif
				@if(Session::get('user')['pseudo']!=null)
				{{Session::get('user')['pseudo']}}
				@endif
			</p>
			<p class="setting">
			<span>Name</span>
				@if(Session::get('user')['username']==null)
				N/A
				@else
				 {{Session::get('user')['username']}}
				@endif
			</p>
			<p class="setting">
			<span>E-mail Address</span>
				@if(Session::get('user')['email']==null)
				N/A
				@else
				 {{Session::get('user')['email']}}
				@endif
			</p>
			<!--<p class="setting">
			<span>Country</span>
				@if(Session::get('user')['email']==null)
				N/A
				@else
				 {{Session::get('user')['email']}}
				@endif
			</p>-->
		</section>
		</div>
	</div>
	<!-- @end #content -->
</div>

<script>
$(function(){
	  $('#profiletabs ul li a').on('click', function(e){
	    e.preventDefault();
	    var newcontent = $(this).attr('href');
	    
	    $('#profiletabs ul li a').removeClass('sel');
	    $(this).addClass('sel');
	    
	    $('#content section').each(function(){
	      if(!$(this).hasClass('hidden')) { $(this).addClass('hidden'); }
	    });
	    
	    $(newcontent).removeClass('hidden');
	  });
	});
</script>
<!-- @end #w -->

@stop

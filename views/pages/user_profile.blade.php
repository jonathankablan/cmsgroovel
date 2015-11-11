@extends('cmsgroovel.layouts.groovel_admin_editor')
 @section('content')
<!-- place in header of your html document -->
<div class="col-sm-12 main">
 	<div class="col-md-12" style='margin-top:50px' id='content'>
 	    {!! HTML::image('packages/groovel/cmsgroovel/groovel/admin/images/edit.jpg', $alt="edit", $attributes = array('id' => 'editButton','style'=>'width:20px;height:20px','class'=>'btnEditUserProfile')) !!}
					                   
 
		<div id="userphoto" class="thumbnail">
		@if(Session::get('user')['userpicture']==null)
			{!! HTML::image('packages/groovel/cmsgroovel/groovel/admin/images/avatar.png', $alt="default avatar") !!}
		@endif
		@if(Session::get('user')['userpicture']!=null)
		{!!HTML::image( Session::get('user')['userpicture'],'')!!}
		@endif
		</div>
		<h1>{!!Session::get('user')['username']!!}</h1>
		<input type="hidden" id="user" value={!!Session::get('user')['id']!!}>


	<div class="col-md-12"> 
		<section id="settings" >
			
			<p class="setting">
			<span>Pseudo</span>
				@if(Session::get('user')['pseudo']==null)
				N/A
				@endif
				@if(Session::get('user')['pseudo']!=null)
				{!!Session::get('user')['pseudo']!!}
				@endif
			</p>
			<p class="setting">
			<span>Name</span>
				@if(Session::get('user')['username']==null)
				N/A
				@else
				 {!!Session::get('user')['username']!!}
				@endif
			</p>
			<p class="setting">
			<span>E-mail Address</span>
				@if(Session::get('user')['email']==null)
				N/A
				@else
				 {!!Session::get('user')['email']!!}
				@endif
			</p>
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

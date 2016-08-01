@extends('cmsgroovel.layouts.groovel_admin_userprofile')
 @section('content')
<!-- place in header of your html document -->
 	<div class="col-sm-5 col-sm-offset-4 col-md-12 col-md-offset-2" style='margin-top:100px' id='content'>
 	 <div class="panel panel-default">
		  <div class="panel-body">
			  <div class='row'>
				  <div class='col-md-1'>
			     	<span id='editButton' class="glyphicon glyphicon-pencil btnEditUserProfile" aria-hidden="true"></span>
				   </div>	 
				 <div id="userphoto" class="col-md-3 thumbnail">
					@if(Session::get('user')['userpicture']==null)
						<i class="glyphicon glyphicon-user"></i>
					@endif
					@if(Session::get('user')['userpicture']!=null)
					<img src="/{{Session::get('user')['userpicture']}}">
					@endif
				</div>
				 
					   <div class='col-md-2'>
						<span>Pseudo:</span>
							@if(Session::get('user')['pseudo']==null)
							N/A
							@endif
							@if(Session::get('user')['pseudo']!=null)
							{!!Session::get('user')['pseudo']!!}
							@endif
						</div>
						<div class='col-md-2'>
						<span>Name:</span>
							@if(Session::get('user')['username']==null)
							N/A
							@else
							 {!!Session::get('user')['username']!!}
							@endif
						</div>
						<div class='col-md-4'>
						<span>E-mail Address:</span>
							@if(Session::get('user')['email']==null)
							N/A
							@else
							 {!!Session::get('user')['email']!!}
							@endif
						</div>
			 </div> 
			  	<div class='row'><div class='col-md-3 col-md-offset-1'><h1>{!!Session::get('user')['username']!!}</h1></div>
		      </div> 
			<input type="hidden" id="user" value={!!Session::get('user')['id']!!}>
		  </div>
	   </div>
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

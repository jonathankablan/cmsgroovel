@extends('cmsgroovel.layouts.groovel_admin_userprofile')  
@section('content')
<!-- place in header of your html document -->
	      

	<div class="col-sm-12 main">
				<div class="col-md-12 col-md-offset-4">
				   @if(Session::get('msg'))
			             <div>{!!var_dump(Session::get('msg'))!!}</div>
			        @endif
			    </div>
		 
	     <div class="col-md-12">
		<div id='error' style='display:none'></div>
		
			 <form method="POST" action="{{url('admin/user/update')}}" accept-charset="UTF-8" id="user_form" class="form-horizontal">
			   <div id='modal' class="modal fade" style="display: none;overflow:scroll;z-index: 1041" data-keyboard="true" data-backdrop="static" tabindex='-1' >
			     	 	  <div class="modal-dialog">
						  	<div class="modal-content">
							 	<div class="modal-header" style='background-color:#E5E4E2'>
							 	   <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
							      <h4 class="modal-title">Board User</h4>
							    </div>
								 @if($errors->has()|| Session::get('messages'))
										<div class="span3">
											<div class="col-md-12">
											 
										           @foreach ($errors->all() as $error)
										              <div style="color:#FF0000;">{!! $error !!}</div>
										          @endforeach
										     
										       @if(Session::get('messages'))
										             <div>{!!var_dump(Session::get('messages'))!!}</div>
										        @endif
										    </div>
										</div>
								@endif
							     <div id='form-modal' class="modal-body">
									<div class="panel-body">
										 	     <input id="id" name="id" type="hidden" value={{Session::get('user_edit')['id']}}>
										 		 {{ csrf_field() }}
										 		 <input id='action' type="hidden" name="action" value="admin/user/update">
		                	
										 		<div class="form-group form-inline">
				     							  @include('cmsgroovel.sections.picture_user')
				     							</div>
												<div class="form-group form-inline">
													<label for="username" class="required">username</label>
													<input class="form-control" style="width:100%" readonly="readonly" name="username" type="text" value={{Session::get('user_edit')['username']}} id="username">
												</div>
												<div class="form-group form-inline">
													<label for="pseudo" class="required">pseudo</label>
													<input class="form-control" style="width:100%" readonly="readonly" name="pseudo" type="text" value={{ Session::get('user_edit')['pseudo']}} id="pseudo">
												</div>
												<div class="form-group form-inline">
													<label for="email" class="required">email</label>
													<input class="form-control" style="width:100%" name="email" type="text" value={{Session::get('user_edit')['email']}} id="email">
												</div>
												<div class="form-group form-inline">
													<label for="password">password reset</label>
													<input class="form-control" style="width:100%" name="password" type="text" value="" id="password">
												</div>
											    <div class="form-group form-inline">
									                <?php   $states=['0'=>'disabled','1'=>'enabled'];
														$state_filter=array();
														$notification_email_enable=Session::get('user_edit')['notification_email_enable'];
												 	?>	
												 	@if(Session::get('user_edit')!=null)		
									                   <label for="notification_email_enable" style="margin-right:60px">notification by email</label>
									                    @foreach($states as $key=>$state)
											                 @if($notification_email_enable!=$key)
											                 	<?php $state_filter[$key]=$state;?>
											                 @endif
								             			 @endforeach
										                <select name="notification_email_enable" class='form-control'>
															<option value=<?php echo $notification_email_enable?>><?php echo $states[$notification_email_enable]?></option>
															@foreach($state_filter as $key=>$state)
															<option value=<?php echo $key?>><?php echo $state?></option>
															@endforeach
											     		</select>
											     	@endif
											   </div>
											   
											@if(Session::get('user_privileges')['role']=='ADMIN')
											<div class="form-group form-inline">
									                <?php   $states=['0'=>'disabled','1'=>'enabled'];
														$state_filter=array();
														$activate=Session::get('user_edit')['activate'];
												 	?>	
												 	@if(Session::get('user_edit')!=null)		
									                   <label for="activate" style="margin-right:105px">activate user</label>
									           			  @foreach($states as $key=>$state)
											                 @if($activate!=$key)
											                 	<?php $state_filter[$key]=$state;?>
											                 @endif
								             			 @endforeach
										                <select name="activate" class='form-control'>
															<option value=<?php echo $activate?>><?php echo $states[$activate]?></option>
															@foreach($state_filter as $key=>$state)
															<option value=<?php echo $key?>><?php echo $state?></option>
															@endforeach
											     		</select>
											     	@endif
											   </div>
											   @endif
				 				   		</div>
								 </div>
								 <div class="modal-footer">
					       			 <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
					       			 <input type="submit" id="submitForm" value="Save"  class="btn btn-default" data-dismiss="modal" data-token="{{ csrf_token() }}"/>
					        	 </div>
					        	 
							</div>
					 </div>
				</div>
			</form>
		</div>
	 </div>
<script>
$(document).ready(function() {
	bindFileEvents("user_form");
	$('#modal').modal('show');
});

$("#submitForm").click(function (event) {
	//add token form
	document.getElementById('user_form').appendChild( document.getElementById('token'));
	form=$('#user_form').serialize();
	validateUser(form);
	if($('#light').children().length==0){
	    var status=postPicture();
	    if(!status){
			return false;
		}
		form=$('#user_form').serialize();
		postUser(form,'update');
	}
	return false;
});





</script>
<style>
 .thumb {
    height: 75px;
    border: 1px solid #000;
    margin: 10px 5px 0 0;
  }
#fade{
    display: none;
    position: fixed;
    top: 0%;
    left: 0%;
    width: 100%;
    height: 100%;
    background-color: #000;
    z-index:1001;
    -moz-opacity: 0.7;
    opacity:.70;
    filter: alpha(opacity=70);
}
#light{
    display: none;
    position: absolute;
    top: 50%;
    left: 50%;
    width: 300px;
    height: 200px;
    margin-left: -150px;
    margin-top: -100px;                 
    padding: 10px;
    border: 2px solid #FFF;
    z-index:1002;
    overflow:visible;
}		
.closer {
 position: absolute;
top: 0px;
right: 10px;
transition: all 200ms ease 0s;
font-size: 20px;
font-weight: bold;
text-decoration: none;
color: #333;
}	

</style>

@stop
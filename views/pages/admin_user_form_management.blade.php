@extends('cmsgroovel.layouts.groovel_admin_editor')
@section('content')
<!-- place in header of your html document -->


	<div class="col-sm-12 main">
				<div class="col-md-12 col-md-offset-4">
				   @if(Session::get('msg'))
			             <div>{!!var_dump(Session::get('msg'))!!}</div>
			        @endif
			    </div>
			    <div class="col-md-12">
			      	<form method="POST" action="{{url('admin/user/add')}}" accept-charset="UTF-8" id="user_form" class="form-horizontal">
				   	 	<div id='modal' class="modal fade" style="display: none;" data-keyboard="true" data-backdrop="static" tabindex='-1'>
						  <div class="modal-dialog">
						  	<div class="modal-content">
							 	<div class="modal-header" style='background-color: #E5E4E2'>
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
								<div id='error' style='display:none'></div>
								<div id='light'></div>
								<div id='fade'></div>
						       <div id='form-modal' class="modal-body">
						     					<div class="panel-body">
												{{ csrf_field() }}
									 	  	 	<input id='action' type="hidden" name="action" value="admin/user/add">
										 	  	<div class="form-group form-inline">
												  @include('cmsgroovel.sections.picture_new_user')
												</div>
												<div class="form-group form-inline">
													<label for="username" class="required">username</label>
													<input class="form-control" style="width:450px;margin-left:50px" name="username" type="text" id="username">
												</div>
												<div class="form-group form-inline">
													<label for="pseudo" class="required">pseudo</label>
													<input class="form-control" style="width:450px;margin-left:65px" name="pseudo" type="text" id="pseudo">
												</div>
												<div class="form-group form-inline">
													<label for="email" class="required">email</label>
													<input class="form-control" style="width:450px;margin-left:80px" name="email" type="text" id="email">
												</div>
												<div class="form-group form-inline">
													<label for="password">password reset</label>
													<input class="form-control" style="width:450px;margin-left:90px" name="password" type="text" id="password">
												</div>
												 <div class="form-group form-inline">
								                 <label for="notification_email_enable" style="margin-right:80px">enable notification by email</label>
								              		<select name="notification_email_enable"  class='form-control'>
														<option value='0'>disabled</option>
														<option value='1'>enabled</option>
													</select>
												</div>
												<div class="form-group form-inline">
													<span class="label label-info" style="margin-right:50px" >Status: </span>
													<span class="label label-info" style="margin-left:50px">activate user?</span>	
													<select name="activate">
														<option value="default">Please Select</option>
														<option value="0">NotActivate</option><option value="1">Activate</option>
													</select>
												</div>
									   		</div>
								 </div>
								 <div class="modal-footer">
								     <p class='required' style='font-size:15px;margin-right:80%'>Fields are required</p>
			       		
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
	form=$('#user_form').serialize();
	validateUser(form);
	if($('#error').text()==""){
	    var status=postPicture();
	    if(!status){
			return false;
		}
		form=$('#user_form').serialize();
		postUser(form,'add');
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
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
			     <div id='modal' class="modal fade" style="display: none;overflow:scroll;z-index: 1041" data-keyboard="false" data-backdrop="static" >
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
								<div id='light'></div>
								<div id='fade'></div>
							     <div id='form-modal' class="modal-body">
									<div class="panel-body">
												{!! Form::open(array('id'=>'user_form','url' => 'admin/user/update', 'method' => 'POST', 'class' => 'form-horizontal well ')) !!}
										 	   {!! Form::hidden('id', Session::get('user_edit')['id'], array('id' => 'id')) !!}
										
										 		<div class="form-group form-inline">
				     							  @include('cmsgroovel.sections.picture_user')
				     							</div>
												<div class="form-group form-inline">
													{!! Form::label('username', 'username',array('class'=>'required')).Form::text('username', Session::get('user_edit')['username'],  $attributes = array('class' => 'form-control','style'=>'width:450px;margin-left:110px','readonly')) !!}
												</div>
												<div class="form-group form-inline">
													{!! Form::label('pseudo', 'pseudo',array('class'=>'required')).Form::text('pseudo', Session::get('user_edit')['pseudo'],  $attributes = array('class' => 'form-control','style'=>'width:450px;margin-left:125px','readonly')) !!}
												</div>
												<div class="form-group form-inline">
													{!! Form::label('email', 'email',array('class'=>'required')).Form::text('email', Session::get('user_edit')['email'],  $attributes = array('class' => 'form-control','style'=>'width:450px;margin-left:138px')) !!}
												</div>
												<div class="form-group form-inline">
													{!! Form::label('password', 'password reset').Form::text('password', Session::get('user_edit')['password'],  $attributes = array('class' => 'form-control','style'=>'width:450px;margin-left:90px')) !!}
												</div>
											    <div class="form-group form-inline">
									                <?php   $states=['0'=>'disabled','1'=>'enabled'];
														$state_filter=array();
														$notification_email_enable=Session::get('user_edit')['notification_email_enable'];
												 	?>	
												 	@if(Session::get('user_edit')!=null)		
									                {!! Form::label('notification_email_enable', 'notification by email',array('style'=>'margin-right:60px'))!!}
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
									                {!! Form::label('activate', 'activate user',array('style'=>'margin-right:105px'))!!}
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
											<!-- {!! Form::submit('Submit',array('class'=>'btn btn-default'))!!}-->
										
				  				   		</div>
								 </div>
								 <div class="modal-footer">
					       			 <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
					       			 <input type="submit" id="submitForm" value="Save"  class="btn btn-default" data-dismiss="modal" data-token="{{ csrf_token() }}"/>
					        	 </div>
							</div>
								{!! Form::close() !!}
						  </div>
						</div>
		 	 	</div>
	 </div>
<script>
$(document).ready(function() {
	fileEvents();
	$('#modal').modal('show');
});

$("#submitForm").click(function (event) {
  var token = $(this).data('token');
  var divSuccess = document.getElementById('success_message');
  var divError = document.getElementById('error_message');
	if(divSuccess!=null){
		divSuccess.innerHTML =null;
		}
	if(divError!=null){
		divError.innerHTML =null;
	    }
	getFileOldList();
	var status=true;
	var form=$('#user_form').serialize();
	document.getElementById('my-file').value='';
	status=validateFiles(storedFiles,filesAlreadyStored);
if(status){
     var ajaxData = new FormData();
	    for(i=0;i<storedFiles.length;i++){
		   // console.log(storedFiles[i]);
		    var xhr = new XMLHttpRequest();
		    ajaxData.append("file", storedFiles[i]);
		    ajaxData.append("_token",token);
		    xhr.onreadystatechange = function () {
			  	response = this.responseText;
			  	//console.log(response);
			  	if(response!=""){
		     	  	var url = JSON.parse(response);
		     	//  	console.log(url);
				  	urlimg[storedFiles[i]['name']]=url.datas[storedFiles[i]['name']];
				//	console.log(urlimg);
			  	}
		  	}
		    xhr.open("POST", "/admin/file/upload",false);
  		    xhr.send(ajaxData);
	    }
	var urls=[];	
    var rem= document.getElementById("myfiles");
    if(rem!=null){rem.remove();}
	var input = document.createElement('input');
	input.type='hidden';
	input.name='myfiles';
    input.id='myfiles';
	for(var filename in urlimg)
	{
     urls.push(urlimg[filename]);
	}
	for(var i=0;i<filesAlreadyStored.length;i++)
	{     urls.push(filesAlreadyStored[i].value);
	}
	//ajout ancienne image
    input.value=urls;
    //if(storedFiles.length>0){//si volontaire on change de image
		document.getElementById('list').insertBefore(input, null);
    //}
	form=$('#user_form').serialize();
	//console.log(form);
	$.post('/admin/user/update', form, function (data, textStatus) {
		urlimg={};
		//console.log(data);
		var parsed = JSON.parse(data);
		if(parsed['success']){
	           window.scrollTo(0,0);
		        document.getElementById('light').style.display='block';
		        document.getElementById('light').className='alert alert-success fade in';
		        document.getElementById('light').innerHTML ='user has been updated successfully';
		        document.getElementById('fade').style.display='block';  
		        a=document.createElement('a');
				a.className='closer';
				a.href='#';
				a.innerHTML='x';
				a.onclick = function(e) {  
					document.getElementById('light').style.display='none';
					document.getElementById('fade').style.display='none';
				    return false;
				};
				document.getElementById('light').appendChild(a);
				button=document.createElement('button');
	  			button.innerHTML='OK';
	  			button.style='margin-left:90px;margin-top:100px;width:100px;height:40px';
	  			button.onclick = function(e) {  
	  				document.getElementById('light').style.display='none';
	  				document.getElementById('fade').style.display='none';
	  			    return false;
	  			};
	  			div=document.createElement('div');
	  			div.id='mess';
	  			document.getElementById('light').appendChild(div);
	  			document.getElementById('mess').appendChild(button);

	  		  if(storedFiles.length>0){
	  		  	var rem= document.getElementById("picture");
	  	      	if(rem!=null){rem.innerHTML=null;}
	  	      //	picture=
	  		  }
         }
          else if(parsed['success']==false){
        	  window.scrollTo(0,0);
		        document.getElementById('light').style.display='block';
		        document.getElementById('light').className='alert alert-danger fade in';
		        document.getElementById('light').innerHTML =  parsed['errors']['reason'];
		        document.getElementById('fade').style.display='block';  
		        a=document.createElement('a');
				a.className='closer';
				a.href='#';
				a.innerHTML='x';
				a.onclick = function(e) {  
				document.getElementById('light').style.display='none';
				document.getElementById('fade').style.display='none';
				    return false;
				};
				document.getElementById('light').appendChild(a);
				button=document.createElement('button');
	  			button.innerHTML='OK';
	  			button.style='margin-left:90px;margin-top:100px;width:100px;height:40px';
	  			button.onclick = function(e) {  
	  				document.getElementById('light').style.display='none';
	  				document.getElementById('fade').style.display='none';
	  			    return false;
	  			};
	  			div=document.createElement('div');
	  			div.id='mess';
	  			document.getElementById('light').appendChild(div);
	  			document.getElementById('mess').appendChild(button);
         }
	 });
	return false;
}else{
 return false;	
}
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
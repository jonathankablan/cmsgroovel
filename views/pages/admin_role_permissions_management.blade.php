@extends('cmsgroovel.layouts.groovel_admin_default')
@section('content')
	 <div class="col-md-12">
        <div id='modal' class="modal fade" style="display: none" data-keyboard="true" data-backdrop="static" tabindex='-1'>
			<div class="modal-dialog"  style='width:100%'>
				<div class="modal-content">
					 <div class="modal-header" style='background-color: #E5E4E2'>
					 	  <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					      <h4 class="modal-title">Board Role Permission</h4>
					  </div>
					  @if($errors->has()|| Session::get('messages'))
									<div class="span3">
										<div class="col-md-12 col-md-offset-2">
										 
									           @foreach ($errors->all() as $error)
									              <div style="color:#FF0000;">Warning :: {!! $error !!}</div>
									          @endforeach
									     
									       @if(Session::get('messages'))
									              <div style="color:#FF0000;">Warning :: {!!Session::get('messages')!!}</div>
									        @endif
									    </div>
									</div>
					  @endif
					   <div id='light'></div>
						<div id='fade'></div> 
				      <div id='form-modal' class="modal-body" >
				      	<div class="panel-body">
						  <div class="span3">
			            	<div class="col-md-12">
				            	<?php $pseudo=Session::get('pseudo')?>
				            	
							 	<form method="POST"  action="{{url('admin/role/permission/add')}}" accept-charset="UTF-8" id="role_permissions_form">
				         			 {{csrf_field()}}
				         			<input id="role_id" name="role_id" type="hidden" value="">
		                	 
									<div class="col-sm-2 required" style="margin-bottom:20px">Role</div>
							      	<div class="col-sm-4" style="margin-bottom:20px">
							       	 <input class="form-control" required="required" name="role" type="text">
							      	</div>
									<div class="col-sm-12" style="margin-left:10px" >
									<INPUT type="button" value="Add Role permissions" onclick="addRow('table_role_permissions')" />
								   	<INPUT type="button" value="Delete Role permissions" onclick="deleteRow('table_role_permissions')" />
								   	</div>
								    <div  class="col-sm-12" style="margin-top:20px">
								    <table id="table_role_permissions" class="line-items editable table table-bordered">
								         <thead class="panel-heading">
										     			<th></th>
											            <th>create</th>
											            <th>read</th>
											            <th>update</th>
											            <th>delete</th>
											            <th class='required'>uri</th>
											            <th>own content</th>
											            <th>other contents</th>
									    </thead>
								        <tr>
								         <td class="col-sm-1"><INPUT  id='chk' type="checkbox" name="chk[]"/></td>
								           <td class="col-sm-2">	      		
								          	<select name="create[]">
														<option value='0'>no</option>
														<option value='1'>yes</option>
											</select>
										  </td>
										   <td class="col-sm-2">	      		
								          	<select name="read[]">
														<option value='0'>no</option>
														<option value='1'>yes</option>
											</select>
										  </td>
										   <td class="col-sm-2">	      		
								          	<select name="update[]">
														<option value='0'>no</option>
														<option value='1'>yes</option>
											</select>
										  </td>
										   <td class="col-sm-2">	      		
								          	<select name="delete[]">
														<option value='0'>no</option>
														<option value='1'>yes</option>
											</select>
										  </td>
										  <td class="col-sm-3">
									           <select name='uris[]'>
												    <option name='uri'></option>
												    @foreach(Session::get('uris') as $uri)
												    <?php if(!empty($uri)):?>
												    <option value="{!! $uri['uri'] !!}">{!! $uri['uri'] !!}</option>
												    <?php endif;?>
												    @endforeach
												</select>
								            </td>
							              <td class="col-sm-4">
								           	 <select name="owncontent[]">
								           	 	<option value="yes">yes</option>
								           	 	<option value="no">no</option>
								           	 </select>
								            </td>
							              <td class="col-sm-4">
								         	 <select name="othercontent[]">
								           	 	<option value="yes">yes</option>
								           	 	<option value="no">no</option>
								           	 </select>
										  </td>
										          
								        </tr>
								    </table>
								</div>
							</form>			    
						</div>
					</div>
						<div  class="col-sm-12" style="margin-top:20px">
							 <div class="modal-footer">
							     <p class='required' style='font-size:15px;margin-right:80%'>Fields are required</p>
			       		
				       			 <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				       			 <input type="submit" id="submitForm" value="Save"  class="btn btn-default"/>
				        	 </div>
						</div>
				  	</div>
				 </div>
			</div>
		</div>
   	</div>
 </div>
 <script type="text/javascript">
$("#submitForm").click(function (event) {
	var divSuccess = document.getElementById('success_message');
	var divError = document.getElementById('error_message');
	if(divSuccess!=null){
		divSuccess.innerHTML =null;
	}
	if(divError!=null){
		divError.innerHTML =null;
	}
	form=$('#role_permissions_form').serialize();
	$.post('/admin/role/permission/add', form, function (data, textStatus) {
		var parsed = JSON.parse(data);
		if(parsed['success']){
		        $("#role_id").attr("value",parsed['datas']['id']);
	      	    window.scrollTo(0,0);
		        document.getElementById('light').style.display='block';
		        document.getElementById('light').className='alert alert-success fade in';
		        document.getElementById('light').innerHTML ='permission has been added  successfully';
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
});

$(document).ready(function() {
	 $('#modal').modal('show');
});
</script>
 <style>
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
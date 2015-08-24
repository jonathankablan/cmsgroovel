@extends('cmsgroovel::layouts.groovel_admin_default')
@section('content')
	 <div class="col-md-12">
        <div id='modal' class="modal fade" style="display: none" data-keyboard="false" data-backdrop="static">
			<div class="modal-dialog"  style='width:960px'>
				<div class="modal-content">
					 <div class="modal-header" style='background-color: #00FF40'>
					 	  <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					      <h4 class="modal-title">Board Permission User </h4>
					  </div>
					  @if($errors->has()|| Session::get('messages'))
									<div class="span3">
										<div class="col-md-12 col-md-offset-2">
										 
									           @foreach ($errors->all() as $error)
									              <div style="color:#FF0000;">Warning :: {{ $error }}</div>
									          @endforeach
									     
									       @if(Session::get('messages'))
									              <div style="color:#FF0000;">Warning :: {{Session::get('messages')}}</div>
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
							 	{{ Form::open(array('id'=>'user_permission_form','url' => 'admin/user/permission/add', 'method' => 'POST')) }}
						
									<div class="col-sm-2 required" style="margin-bottom:20px">Username</div>
							      	<div class="col-sm-4" style="margin-bottom:20px">
							      	 {{Form::text('pseudo', $pseudo,  $attributes = array('class' => 'form-control','required'=>'required')) }}
							      	</div>
									<div class="col-sm-12" style="margin-left:10px" >
									<INPUT type="button" value="Add User permissions" onclick="addRow('table_user_permissions')" />
								   	<INPUT type="button" value="Delete User permissions" onclick="deleteRow('table_user_permissions')" />
								   	</div>
								    <div  class="col-sm-12" style="margin-top:20px">
								    <table id="table_user_permissions" class="line-items editable table table-bordered">
								         <thead class="panel-heading">
										     			<th></th>
											            <th>retrieve</th>
											            <th>delete</th>
											            <th>edit</th>
											            <th>save</th>
											            <th>update</th>
											            <th>add</th>
											            <th>content types</th>
											            <th>own content</th>
											            <th>other contents</th>
											  
									    </thead>
								        <tr>
								         <td class="col-sm-1"><INPUT  id='chk' type="checkbox" name="chk[]"/></td>
								           <td class="col-sm-2">	      		
								          	<select name="retrieve[]">
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
										   <td class="col-sm-2">	      		
								          	<select name="edit[]">
														<option value='0'>no</option>
														<option value='1'>yes</option>
											</select>
										  </td>
										   <td class="col-sm-2">	      		
								          	<select name="save[]">
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
								          	<select name="add[]">
														<option value='0'>no</option>
														<option value='1'>yes</option>
											</select>
										  </td>
							                <td class="col-sm-3">
								           <!--  {{Form::select('content_types', Session::get('content_types'),'default',$attributes = array('class' => 'form-control','required'=>'required'));}}-->
								           
								           <select name='content_types[]'>
											    <option name='content_types'></option>
											    @foreach(Session::get('content_types') as $type)
											    <?php if(!empty($type)):?>
											    <option value="{{ $type}}">{{ $type }}</option>
											    <?php endif;?>
											    @endforeach
											</select>
								         
								            </td>
								             <td class="col-sm-4">
								           	 {{Form::select('owncontent[]',
										        array(
										            'yes' => 'yes',
										            'no' => 'no'
										              )
										        );
									    	}}
								            </td>
							              <td class="col-sm-4">
								               	 {{Form::select('othercontent[]',
										        array(
										            'yes' => 'yes',
										            'no' => 'no'
										              )
										        );
									    	}}
										     </td>
										          
								        </tr>
								    </table>
								</div>
								
								 <div  class="col-sm-12" style="margin-top:20px;margin-bottom:20px">
								 <div class="col-sm-12" style="margin-top:20px;margin-bottom:20px">
									<INPUT type="button" value="Add User System permissions" onclick="addRow('table_user_system_permissions')" />
								   	<INPUT type="button" value="Delete User System permissions" onclick="deleteRow('table_user_system_permissions')" />
								 </div>
								 <table id="table_user_system_permissions" class="line-items editable table table-bordered">
								         <thead class="panel-heading">
										     			<th></th>
											            <th>retrieve</th>
											            <th>delete</th>
											            <th>edit</th>
											            <th>save</th>
											            <th>update</th>
											            <th>add</th>
											            <th>System types</th>
											             <th>own content</th>
											            <th>other contents</th>
									    </thead>
								        <tr>
								         <td class="col-sm-1"><INPUT  id='chk' type="checkbox" name="chk[]"/></td>
								          <td class="col-sm-2">	      		
								          	<select name="retrieve[]">
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
										   <td class="col-sm-2">	      		
								          	<select name="edit[]">
														<option value='0'>no</option>
														<option value='1'>yes</option>
											</select>
										  </td>
										   <td class="col-sm-2">	      		
								          	<select name="save[]">
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
								          	<select name="add[]">
														<option value='0'>no</option>
														<option value='1'>yes</option>
											</select>
										  </td>
										   <td class="col-sm-3">
								           <!--  {{Form::select('content_types', Session::get('content_types'),'default',$attributes = array('class' => 'form-control','required'=>'required'));}}-->
								           
								           <select name='content_types[]'>
											    <option name='content_types'></option>
											    @foreach(Session::get('system_types') as $type)
											    <?php if(!empty($type)):?>
											    <option value="{{ $type}}">{{ $type }}</option>
											    <?php endif;?>
											    @endforeach
											</select>
								         
								            </td>
								              <td class="col-sm-4">
								           	 {{Form::select('owncontent[]',
										        array(
										            'yes' => 'yes',
										            'no' => 'no'
										              )
										        );
									    	}}
								            </td>
							              <td class="col-sm-4">
								               	 {{Form::select('othercontent[]',
										        array(
										            'yes' => 'yes',
										            'no' => 'no'
										              )
										        );
									    	}}
										     </td>
								        </tr>
								    </table>
								   </div> 
								    
						</div>
						  {{ Form::close() }}
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
	form=$('#user_permission_form').serialize();
	$.post('/admin/user/permission/add', form, function (data, textStatus) {
		var parsed = JSON.parse(data);
		if(parsed['success']){
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
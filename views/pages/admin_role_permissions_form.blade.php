@extends('cmsgroovel.layouts.groovel_admin_default')
@section('content')


<div class="col-md-12 main">   
	<div id='modal' class="modal fade" style="display: none;" data-keyboard="true" data-backdrop="static" tabindex='-1'>
		<div class="modal-dialog">
			<div class="modal-content">
			 	<div class="modal-header" style='background-color: #E5E4E2'>
			 	  <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			      <h4 class="modal-title">Board Role </h4>
			    </div>
			    <div id='light'></div>
				<div id='fade'></div> 
			    
        	     <div id='form-modal' class="modal-body">
					     <div class="panel-body">
						  <div class="span3">
						   <form method="POST" action="{{url('admin/role/permission/update')}}" accept-charset="UTF-8" id="role_permission_form">
						    {{csrf_field()}}
						  	<div class="col-md-12">
			                  	<div  class="col-sm-12 form-inline" style="margin-top:20px">
							      	<?php $permissions=Session::get('permissions')?>
							      	<?php $role=Session::get('role')?>
							      	 <?php $uris=Session::get('uris')?>
							    	 <label for="role" style="margin-right:50px">Role</label>
						      		 <input class="form-control" style="width:250px" readonly="readonly" name="role" type="text" value={{$role}}>
						      		 <input id="role" name="role" type="hidden" value={{$role}}>
							
						     	</div>
								<div class="col-sm-12" style="margin-left:10px;margin-top:20px" >
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
									    @foreach($permissions as $permission)
									    
								        <tr>
								        <td class="col-sm-1"><INPUT  id='chk' type="checkbox" name="chk[]"/></td>
								           
								        <td class="col-sm-2">	      		
								          	<select name="create[]">
														<option value=<?php echo $permission['create']?>>@if($permission['create']==1)yes @else no @endif</option>
														@if($permission['create']==1)<option value='0'>no</option> @else <option value='1'>yes</option> @endif
											</select>
										  </td>
										   <td class="col-sm-2">	      		
								          	<select name="read[]">
													    <option value=<?php echo $permission['read']?>>@if($permission['read']==1)yes @else no @endif</option>
														@if($permission['read']==1)<option value='0'>no</option> @else <option value='1'>yes</option> @endif
											</select>
										  </td>
										   <td class="col-sm-2">	      		
								          	<select name="update[]">
														<option value=<?php echo $permission['update']?>>@if($permission['update']==1)yes @else no @endif</option>
														@if($permission['update']==1)<option value='0'>no</option> @else <option value='1'>yes</option> @endif
											</select>
										  </td>
										   <td class="col-sm-2">	      		
								          	<select name="delete[]">
														<option value=<?php echo $permission['delete']?>>@if($permission['delete']==1)yes @else no @endif</option>
														@if($permission['delete']==1)<option value='0'>no</option> @else <option value='1'>yes</option> @endif	
											</select>
										  </td>
										  <td class="col-sm-3">
									             @foreach($uris as $key=>$state)
									                 @if($uris[$permission['uri']]!=$key)
									                	<?php $state_filter[$key]=$state;?>
									                 @endif
								       			 @endforeach
									            <select name="uris[]" class='form-control'>
													<option value="{!! $permission['uri'] !!}">{!!$permission['uri'] !!}</option>
														@foreach($state_filter as $key=>$state)
															<option value=<?php echo $key?>><?php echo $state?></option>
														@endforeach
												</select>
								          </td>
										 
								         <?php $choices=array(
								            'yes' => 'yes',
								            'no' => 'no'
								            );?>
									    	
								             <td class="col-sm-4">
								             <select name='owncontent[]'>
									             <option name='owncontent' value=<?php echo $permission['owncontent']?>><?php echo $permission['owncontent']?></option>
												    @foreach($choices as $choice)
												    <?php if(!empty($choice) && $choice!= $permission['owncontent']):?>
												    <option value="{!! $choice!!}">{!! $choice !!}</option>
												    <?php endif;?>
												    @endforeach
											  </select>
								           </td>
							              <td class="col-sm-4">
							              <select name='othercontent[]'>
								              <option name='othercontent' value=<?php echo $permission['othercontent']?>><?php echo $permission['othercontent']?></option>
											    @foreach($choices as $choice)
											    <?php if(!empty($choice) && $choice!= $permission['othercontent']):?>
											    <option value="{!! $choice!!}">{!! $choice !!}</option>
											    <?php endif;?>
											    @endforeach
											</select>
								           </td>
										          
								        </tr>
								        @endforeach
								    </table>
									 </div>
							   </div>
			        	 </form>
					</div>
					<div  class="col-sm-12" style="margin-top:20px">
						<div class="modal-footer">
						     <p class='required' style='font-size:15px;margin-right:80%'>Fields are required</p>
			       		
					       	  <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
					       	  <button type="button" class="btn btn-default" data-dismiss="modal">Delete</button>
					       	  <input type="submit" id="submitForm" value="Save"  class="btn btn-default" />
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
	form=$('#role_permission_form').serialize();
	$.post('/admin/role/permission/update', form, function (data, textStatus) {
		var parsed = JSON.parse(data);
		if(parsed['success']){
	            window.scrollTo(0,0);
		        document.getElementById('light').style.display='block';
		        document.getElementById('light').className='alert alert-success fade in';
		        document.getElementById('light').innerHTML ='role has been updated  successfully';
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
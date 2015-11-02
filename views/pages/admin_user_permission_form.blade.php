@extends('cmsgroovel.layouts.groovel_admin_default')
@section('content')

<div class="col-md-12 main">   
	<div id='modal' class="modal fade" style="display: none;" data-keyboard="false" data-backdrop="static">
		<div class="modal-dialog">
			<div class="modal-content">
			 	<div class="modal-header" style='background-color: #00FF40'>
			 	  <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			      <h4 class="modal-title">Board Permission User </h4>
			    </div>
			    <div id='light'></div>
				<div id='fade'></div> 
			    
        	     <div id='form-modal' class="modal-body">
					     <div class="panel-body">
						  <div class="span3">
			            	<div class="col-md-12">
			                  	<div  class="col-sm-12 form-inline" style="margin-top:20px">
									{!! Form::open(array('id'=>'user_permission_form','url' => 'admin/user/permission/update', 'method' => 'POST')) !!}
							
							      	<?php $permission=Session::get('user_permissions')?>
							      	 {!!Form::label('Pseudo', 'Pseudo',array('style'=>'margin-right:50px')).Form::text('pseudo', $permission['pseudo'],  $attributes = array('class'=>'form-control','style'=>'width:250px','readonly')) !!}
						      	</div>
							
									 {!! Form::hidden('permission_id', Session::get('user_permissions')['id'], array('id' => 'id')) !!}
				  
								    <div  class="col-sm-12" style="margin-top:20px">
								    <table id="table_user_permissions" class="line-items editable table table-bordered">
								         <thead class="panel-heading">
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
								        <td class="col-sm-2">	      		
								          	<select name="retrieve[]">
														<option value=<?php echo $permission['retrieve']?>>@if($permission['retrieve']==1)yes @else no @endif</option>
														@if($permission['retrieve']==1)<option value='0'>no</option> @else <option value='1'>yes</option> @endif
											</select>
										  </td>
										   <td class="col-sm-2">	      		
								          	<select name="delete[]">
													    <option value=<?php echo $permission['retrieve']?>>@if($permission['delete']==1)yes @else no @endif</option>
														@if($permission['delete']==1)<option value='0'>no</option> @else <option value='1'>yes</option> @endif
											</select>
										  </td>
										   <td class="col-sm-2">	      		
								          	<select name="edit[]">
														<option value=<?php echo $permission['edit']?>>@if($permission['edit']==1)yes @else no @endif</option>
														@if($permission['edit']==1)<option value='0'>no</option> @else <option value='1'>yes</option> @endif
											</select>
										  </td>
										   <td class="col-sm-2">	      		
								          	<select name="save[]">
														<option value=<?php echo $permission['save']?>>@if($permission['save']==1)yes @else no @endif</option>
														@if($permission['save']==1)<option value='0'>no</option> @else <option value='1'>yes</option> @endif	
											</select>
										  </td>
										   <td class="col-sm-2">	      		
								          	<select name="update[]">
														<option value=<?php echo $permission['update']?>>@if($permission['update']==1)yes @else no @endif</option>
														@if($permission['update']==1)<option value='0'>no</option> @else <option value='1'>yes</option> @endif
											</select>
										  </td>
										  <td class="col-sm-2">	      		
								          	<select name="add[]">
														<option value=<?php echo $permission['add']?>>@if($permission['add']==1)yes @else no @endif</option>
														@if($permission['add']==1)<option value='0'>no</option> @else <option value='1'>yes</option> @endif
											</select>
										  </td>
								         <?php $choices=array(
								            'yes' => 'yes',
								            'no' => 'no'
								            );?>
									    	<td class="col-sm-3">
								               <select name='content_types[]'>
											    <option name='content_types' value=<?php echo $permission['contentTypeName']?>><?php echo $permission['contentTypeName']?></option>
											    @foreach(Session::get('content_types') as $type)
											    <?php if(!empty($type) && $type!= $permission['contentTypeName']):?>
											    <option value="{!! $type!!}">{!! $type !!}</option>
											    <?php endif;?>
											    @endforeach
											</select>
								         
								            </td>
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
								    </table>
									 </div>
							   </div>
			        	  {!! Form::close() !!}
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
	form=$('#user_permission_form').serialize();
	$.post('/admin/user/permission/update', form, function (data, textStatus) {
		var parsed = JSON.parse(data);
		if(parsed['success']){
	            window.scrollTo(0,0);
		        document.getElementById('light').style.display='block';
		        document.getElementById('light').className='alert alert-success fade in';
		        document.getElementById('light').innerHTML ='permission has been updated  successfully';
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
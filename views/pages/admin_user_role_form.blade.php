@extends('cmsgroovel.layouts.groovel_admin_default')
@section('content')
	 <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
     
        
        <div id='modal' class="modal fade" style="display: none;" data-keyboard="true" data-backdrop="static" tabindex='-1'>
				  <div class="modal-dialog">
				  	<div class="modal-content">
					 	<div class="modal-header" style='background-color: #E5E4E2'>
					 	  <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					      <h4 class="modal-title">Board update role user </h4>
					    </div>
					    @if($errors->has())
				           @foreach ($errors->all() as $error)
				              <div style="color:#FF0000;">{!! $error !!}</div>
				           @endforeach
        				@endif
				       @if(Session::get('messages'))
				             <div>{!!var_dump(Session::get('messages'))!!}</div>
				        @endif
				        <div id='light'></div>
						<div id='fade'></div> 
			     <div id='form-modal' class="modal-body">
						 	  <form method="POST" action="{{url('admin/user/role/update')}}" accept-charset="UTF-8" id="role_form" class='form-horizontal well' style='width:100%'>
						         {{csrf_field()}}
						 	   	<input id="id" name='id' type="hidden" value={{Session::get('user_role')['id']}}>
						     	<div class="form-group form-inline">
						      		 <label for="Pseudo" style="margin-right:50px">Pseudo</label>
						      		 <input class="form-control" style="width:250px" readonly="readonly" name="pseudo" type="text" value={{ Session::get('user_role')['pseudo']}}>
						  		</div>
								<?php $user_role=Session::get('user_role')?>
								<?php $roles=Session::get('roles')?>
								<div class="form-group form-inline">
								    @foreach( $roles as $role)
					                 @if( $user_role['role']!=$role)
					                 	<?php $roles_filter[$role]=$role;?>
					                 @endif
									@endforeach
									<div class="form-group form-inline" style='margin-left:1px;margin-right:65px'>Role</div>
							
					                <select name="role[]">
										<option  value=<?php echo $user_role['role']?>><?php echo  $user_role['role']?></option>
										@foreach($roles_filter as $role)
										<option value=<?php echo $role?>><?php echo $role?></option>
										@endforeach
						     		</select>
								</div> 
							<div class="modal-footer">
			       			 <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
			       			 <input type="submit" id="submitForm" value="Save"  class="btn btn-default" />
			        	 </div>
			        	 </form>
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
	form=$('#role_form').serialize();
	$.post('/admin/user/role/update', form, function (data, textStatus) {
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
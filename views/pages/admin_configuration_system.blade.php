<!DOCTYPE html>
<html lang="en">
  <head>
    @include('cmsgroovel.includes.groovel_admin_head')
  </head>

  <body>
      @include('cmsgroovel.includes.groovel_admin_header')
     <div class="container-fluid">
     <div class="col-md-12"  style='margin-top:150px'>
 	 	<div id='light'></div>
		<div id='fade'></div>
	</div>
	   <div class="col-md-6"  style='margin-top:50px'>
		
		<div class="panel panel-primary">
		   <div class="panel-heading">
		        <h3 class="panel-title"><i class="fa fa-clock-o"></i>Tracking user config</h3>
		    </div>
		    
			<div class="row" style='margin-top:25px'>
			 {!! Form::open(array('id'=>'admin_config_form_location','url' => 'admin/configuration/update_audit', 'method' => 'POST')) !!}
				<div class="row">
					<div class="col-md-5 col-md-offset-1" ><p class="text-left" style='font-size:18px'>enable audit users tracking</p></div>
					<?php   $states=['0'=>'Disabled','1'=>'Enabled'];
					$state_filter=array();
					$audit_tracking=Session::get('configuration')['audit_tracking'];
			 		?>		
					<div class="col-md-3">
						  @foreach($states as $key=>$state)
			                 @if(Session::get('configuration')['audit_tracking']!=$key)
			                 	<?php $state_filter[$key]=$state;?>
			                 @endif
			             @endforeach
		                <select name="tracking_service"  class='form-control'>
							<option value=<?php echo $audit_tracking?>><?php echo $states[$audit_tracking]?></option>
							@foreach($state_filter as $key=>$state)
							<option value=<?php echo $key?>><?php echo $state?></option>
							@endforeach
			     		</select>
					</div>
				</div>
				
				<div class="row">
					<div class="col-md-3 col-md-offset-1" ><p class="text-left" style='font-size:18px'>Enable world map location</p></div>
					<?php   $states=['0'=>'Disabled','1'=>'Enabled'];
					$state_filter=array();
					$map_locate=Session::get('configuration')['map_locate'];
			 		?>		
					<div class="col-md-3 col-md-offset-2">
						  @foreach($states as $key=>$state)
			                 @if(Session::get('configuration')['map_locate']!=$key)
			                 	<?php $state_filter[$key]=$state;?>
			                 @endif
			             @endforeach
		                <select name="worldmap_service" class='form-control'>
							<option value=<?php echo $map_locate?>><?php echo $states[$map_locate]?></option>
							@foreach($state_filter as $key=>$state)
							<option value=<?php echo $key?>><?php echo $state?></option>
							@endforeach
			     		</select>
					</div>
				</div>
				<input type="submit" id="admin_config_form_location" value="Save Configuration"  class="btn btn-default" style="margin-left:490px;margin-bottom:20px"/>
				{!! Form::close() !!}	
			</div>
		</div>
		<div class="panel panel-primary" >
			  	    <div class="panel-heading">
			        	<h3 class="panel-title"><i class="fa fa-clock-o"></i>Audit tracking history</h3>
					</div>
			        <div class="row">
				        <div class="panel-body">
				    		<div class="col-md-4"><p class="text-left" style='font-size:18px'>clear history</p></div>
							<div class="col-md-3 col-md-offset-2"><button class="btn btn-default" id="clearHistoryTrackingUser" >clear history</button></div>
						</div>
					</div>
		</div>
		<!-- <div class="panel panel-primary" >
			  	    <div class="panel-heading">
			        	<h3 class="panel-title"><i class="fa fa-clock-o"></i>Filtering audit tracking url</h3>
					</div>
			        <div class="row">
				        <div class="panel-body">
				    		<div class="col-md-4"><p class="text-left" style='font-size:18px'>Choose url to audit</p></div>
				    		<div class="col-md-1  col-md-offset-2"><button class="btn btn-default" onclick="window.location.href='/admin/routes'"  style='width:100px'>view</button></div>
						</div>
					</div>
		</div>-->
		<div class="panel panel-primary" >
			  	    <div class="panel-heading">
			        	<h3 class="panel-title"><i class="fa fa-clock-o"></i>Activate automatically users at registration</h3>
					</div>
		
		 <div class="row">
		  {!! Form::open(array('id'=>'admin_config_activate_user_form','url' => 'admin/configuration/activate/users', 'method' => 'POST')) !!}
		 
			<?php   $states=['0'=>'Disabled','1'=>'Enabled'];
					$state_filter=array();
					$activate_users=Session::get('configuration')['activate_users'];
			 ?>							      
		      <div class="panel-body">
	    		<div class="col-md-4"><p class="text-left" style='font-size:18px'>Users function activate at registration</p></div>
				<div class="col-md-4">
				    	  @foreach($states as $key=>$state)
			                 @if(Session::get('configuration')['activate_users']!=$key)
			                 	<?php $state_filter[$key]=$state;?>
			                 @endif
			             @endforeach
		                <select name="activate_users"  class='form-control'>
							<option value=<?php echo $activate_users?>><?php echo $states[$activate_users]?></option>
							@foreach($state_filter as $key=>$state)
							<option value=<?php echo $key?>><?php echo $state?></option>
							@endforeach
			     		</select>
				</div>
				<input type="submit" id="admin_config_activate_user_form" value="Save Configuration"  class="btn btn-default" style="margin-left:370px;margin-top:50px;margin-bottom:25px"/>
				{!! Form::close() !!}
			</div>
		</div>
		</div>
	</div>
		  		
				
				<!-- <div class="row">
					<div class="panel panel-primary" style='width:624px;margin-left:32px;border:none'>
						<div class="panel-heading">
				        	<h3 class="panel-title"><i class="fa fa-clock-o"></i>update country files</h3>
				        </div>
				        <div class="panel-body">
				    		<div class="col-md-4"><p class="text-left" style='font-size:18px'>update country files</p></div>
							<div class="col-md-3 col-md-offset-2"><button class="btn btn-default" id="update_country_files">update files</button></div>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="panel panel-primary" style='width:624px;margin-left:32px;border:none'>
						<div class="panel-heading">
				        	<h3 class="panel-title"><i class="fa fa-clock-o"></i>update city files</h3>
				        </div>
				        <div class="panel-body">
				    		<div class="col-md-4"><p class="text-left" style='font-size:18px'>update city files</p></div>
							<div class="col-md-3 col-md-offset-2"><button class="btn btn-default" id="update_city_files">update files</button></div>
						</div>
					</div>
				</div>-->
	<div class="col-md-5"  style='margin-top:50px'>
		<div class="panel panel-primary">
		   <div class="panel-heading">
		        <h3 class="panel-title"><i class="fa fa-clock-o"></i>Search engine</h3>
		   </div>
			<div class="row" style='margin-top:25px'>
			 {!! Form::open(array('id'=>'admin_config_search_form','url' => 'admin/configuration/update_search_engine', 'method' => 'POST')) !!}
			
			<?php   $states=['0'=>'Disabled','1'=>'Enabled'];
					$state_filter=array();
					$elastic=Session::get('configuration')['elastic'];
			 ?>			 	  
				<div class="col-md-4 col-md-offset-1"><p class="text-left" style='font-size:18px'>Elasticsearch</p></div>
				<div class="col-md-3">
				    	  @foreach($states as $key=>$state)
			                 @if(Session::get('configuration')['elastic']!=$key)
			                 	<?php $state_filter[$key]=$state;?>
			                 @endif
			             @endforeach
		                <select name="elasticsearch_service"  class='form-control'>
							<option value=<?php echo $elastic?>><?php echo $states[$elastic]?></option>
							@foreach($state_filter as $key=>$state)
							<option value=<?php echo $key?>><?php echo $state?></option>
							@endforeach
			     		</select>
				</div>
				<input type="submit" id="admin_config_search_form" value="Save Configuration"  class="btn btn-default" style="margin-left:370px;margin-top:50px;margin-bottom:25px"/>
				{!! Form::close() !!}
			</div>
		</div>
	<div class="panel panel-primary">
	 		<div class="panel-heading">
		        <h3 class="panel-title"><i class="fa fa-clock-o"></i>Maintenance site</h3>
		   </div>
		 <div class="row">
		  {!! Form::open(array('id'=>'admin_config_maintenance_form','url' => 'admin/configuration/maintenance', 'method' => 'POST')) !!}
		 	<?php   $states=['0'=>'Disabled','1'=>'Enabled'];
					$state_filter=array();
					$maintenance=Session::get('configuration')['maintenance'];
			 ?>							      
		      <div class="panel-body">
	    		<div class="col-md-4"><p class="text-left" style='font-size:18px'>Maintenance</p></div>
				<div class="col-md-4">
				    	  @foreach($states as $key=>$state)
			                 @if(Session::get('configuration')['maintenance']!=$key)
			                 	<?php $state_filter[$key]=$state;?>
			                 @endif
			             @endforeach
		                <select name="maintenance_service"  class='form-control'>
							<option value=<?php echo $maintenance?>><?php echo $states[$maintenance]?></option>
							@foreach($state_filter as $key=>$state)
							<option value=<?php echo $key?>><?php echo $state?></option>
							@endforeach
			     		</select>
				</div>
				<input type="submit" id="admin_config_maintenance_form" value="Save Configuration"  class="btn btn-default" style="margin-left:370px;margin-top:50px;margin-bottom:25px"/>
				{!! Form::close() !!}
			</div>
		</div>
	</div>
	
	
	<div class="panel panel-primary">
	 		<div class="panel-heading">
		        <h3 class="panel-title"><i class="fa fa-clock-o"></i>Email settings</h3>
		   </div>
		 <div class="row">
		  {!! Form::open(array('id'=>'admin_config_email_form','url' => 'admin/configuration/email', 'method' => 'POST')) !!}
		 
			<?php   $states=['0'=>'Disabled','1'=>'Enabled'];
					$state_filter=array();
					$email=Session::get('configuration')['email'];
			 ?>							      
		      <div class="panel-body">
	    		<div class="col-md-4"><p class="text-left" style='font-size:18px'>Email function activate</p></div>
				<div class="col-md-4">
				    	  @foreach($states as $key=>$state)
			                 @if(Session::get('configuration')['email']!=$key)
			                 	<?php $state_filter[$key]=$state;?>
			                 @endif
			             @endforeach
		                <select name="email_service"  class='form-control'>
							<option value=<?php echo $email?>><?php echo $states[$email]?></option>
							@foreach($state_filter as $key=>$state)
							<option value=<?php echo $key?>><?php echo $state?></option>
							@endforeach
			     		</select>
				</div>
				<input type="submit" id="admin_config_email_form" value="Save Configuration"  class="btn btn-default" style="margin-left:370px;margin-top:50px;margin-bottom:25px"/>
				{!! Form::close() !!}
			</div>
		</div>
		
	</div>
      
 </div>

    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
 
  </body>
</html>

<script type="text/javascript">
$("#clearHistoryTrackingUser").click(function (event) {
	$.post('configuration/clear_history_tracking_users',
            {
                "function": "clearHistoryTrackingUser"
             },
    function(data) {
        var parsed = JSON.parse(data);
        if(parsed['success']){
            window.scrollTo(0,0);
	        document.getElementById('light').style.display='block';
	        document.getElementById('light').className='alert alert-success fade in';
	        document.getElementById('light').innerHTML ='history cleared';
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
})
		
$("#update_country_files").click(function (event) {
	$.post('configuration/update_audit',
            {
                "function": "updateCountryFiles"
             },
    function(data) {
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
         }
    });
})

$("#update_city_files").click(function (event) {
	$.post('configuration/update_audit',
            {
                "function": "updateCityFiles"
             },
    function(data) {
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
         }
    });
})

$("#admin_config_form_location").click(function (event) {
	form=$('#admin_config_form_location').serialize();
	$.post('/admin/configuration/update_audit', form, function (data, textStatus) {
		console.log(data);
		var parsed = JSON.parse(data);
		if(parsed['success']){
	            window.scrollTo(0,0);
		        document.getElementById('light').style.display='block';
		        document.getElementById('light').className='alert alert-success fade in';
		        document.getElementById('light').innerHTML ='config has been changed';
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

$("#admin_config_search_form").click(function (event) {
	form=$('#admin_config_search_form').serialize();
	$.post('/admin/configuration/update_search_engine', form, function (data, textStatus) {
		console.log(data);
		var parsed = JSON.parse(data);
		if(parsed['success']){
	            window.scrollTo(0,0);
		        document.getElementById('light').style.display='block';
		        document.getElementById('light').className='alert alert-success fade in';
		        document.getElementById('light').innerHTML ='config has been changed';
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
	         }
	 });
	return false;
});
$("#admin_config_maintenance_form").click(function (event) {
	form=$('#admin_config_maintenance_form').serialize();
	$.post('/admin/configuration/maintenance', form, function (data, textStatus) {
		console.log(data);
		var parsed = JSON.parse(data);
		if(parsed['success']){
	            window.scrollTo(0,0);
		        document.getElementById('light').style.display='block';
		        document.getElementById('light').className='alert alert-success fade in';
		        document.getElementById('light').innerHTML ='config has been changed';
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

$("#admin_config_email_form").click(function (event) {
	form=$('#admin_config_email_form').serialize();
	$.post('/admin/configuration/email', form, function (data, textStatus) {
		console.log(data);
		var parsed = JSON.parse(data);
		if(parsed['success']){
	            window.scrollTo(0,0);
		        document.getElementById('light').style.display='block';
		        document.getElementById('light').className='alert alert-success fade in';
		        document.getElementById('light').innerHTML ='config has been changed';
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



$("#admin_config_activate_user_form").click(function (event) {
	form=$('#admin_config_activate_user_form').serialize();
	$.post('/admin/configuration/activate/users', form, function (data, textStatus) {
		console.log(data);
		var parsed = JSON.parse(data);
		if(parsed['success']){
	            window.scrollTo(0,0);
		        document.getElementById('light').style.display='block';
		        document.getElementById('light').className='alert alert-success fade in';
		        document.getElementById('light').innerHTML ='config has been changed';
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


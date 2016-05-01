<!DOCTYPE html>
<html lang="en">
  <head>
    @include('cmsgroovel.includes.groovel_admin_head')
  </head>

  <body>
      @include('cmsgroovel.includes.groovel_admin_header')
  <div class='container-fluid' style='margin-top:80px'>
      @include('cmsgroovel.toolkits.popup.popupModal')
 
	 <div class='row'>
	  	<div class="col-md-6">
	 		<div class="panel panel-primary">
			   <div class="panel-heading">
			        <h3 class="panel-title"><i class="fa fa-clock-o"></i><font color='black'>Tracking user config</font></h3>
			    </div>
			    
				<div class="row" style='margin-top:25px'>
				 {!! Form::open(array('id'=>'admin_config_form_location','url' => 'admin/configuration/update_audit', 'method' => 'POST')) !!}
					<div class="row">
						<div class="col-md-5 col-md-offset-1 col-xs-offset-2" ><p class="text-left" style='font-size:18px'>enable audit users tracking</p></div>
						<?php   $states=['0'=>'Disabled','1'=>'Enabled'];
						$state_filter=array();
						$audit_tracking=Session::get('configuration')['audit_tracking'];
				 		?>		
						<div class="col-md-3 col-xs-10 col-xs-offset-1">
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
					<div class="row" style='margin-top:50px;margin-bottom:25px'>
						<div class="col-md-3 col-md-offset-4 col-sm-offset-2 col-xs-offset-2">
							<input type="submit" id="admin_config_form_location_submit" value="Save Configuration"  class="btn btn-primary"/>
						</div>
					</div>
					{!! Form::close() !!}	
				</div>
			</div>
		</div>
			<div class="col-md-6">
				<div class="panel panel-primary" >
					  	    <div class="panel-heading">
					        	<h3 class="panel-title"><i class="fa fa-clock-o"></i><font color='black'>Audit tracking history</font></h3>
					        	 <input id='token' type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
							</div>
					        <div class="row">
						        <div class="panel-body">
						    		<div class="col-md-4"><p class="text-left" style='font-size:18px'>clear history</p></div>
									<div class="col-md-3 col-md-offset-2 col-sm-offset-2 col-xs-offset-2"><button class="btn btn-primary" id="clearHistoryTrackingUser" >clear history</button></div>
								</div>
							</div>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-md-6">	
				<div class="panel panel-primary" >
			  	    <div class="panel-heading">
			        	<h3 class="panel-title"><i class="fa fa-clock-o"></i><font color='black'>Activate automatically users at registration</font></h3>
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
						</div>
						</div>
						<div class="row">
							<div class="col-md-4 col-md-offset-4 col-sm-offset-2 col-xs-offset-2">
								<input type="submit" id="admin_config_activate_user_form_submit" value="Save Configuration"  class="btn btn-primary" style="margin-top:50px;margin-bottom:25px"/>
							</div>
							{!! Form::close() !!}
						</div>
					
				</div>
			</div>
			<div class="col-md-6">
				<div class="panel panel-primary">
				 		<div class="panel-heading">
					        <h3 class="panel-title"><i class="fa fa-clock-o"></i><font color='black'>Maintenance site</font></h3>
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
						</div>
						<div class="row">
							<div class="col-md-4 col-md-offset-4 col-sm-offset-2 col-xs-offset-2">
								<input type="submit" id="admin_config_maintenance_form_submit" value="Save Configuration"  class="btn btn-primary" style="margin-top:50px;margin-bottom:25px"/>
							</div>
							{!! Form::close() !!}
						</div>
					</div>
				</div>
			</div>
	</div>
	 <div class='row'>
	 	<div class="col-md-6">
			<div class="panel panel-primary">
			 		<div class="panel-heading">
				        <h3 class="panel-title"><i class="fa fa-clock-o"></i><font color='black'>Email settings</font></h3>
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
					</div>
					 <div class="row">
						 <div class="col-md-4 col-md-offset-4 col-sm-offset-2 col-xs-offset-2">
							<input type="submit" id="admin_config_email_form_submit" value="Save Configuration"  class="btn btn-primary" style="margin-top:50px;margin-bottom:25px"/>
						</div>
						{!! Form::close() !!}
					</div>
				</div>
			</div>
		</div>
		<div class="col-md-6">
				<div class="panel panel-primary">
				 		<div class="panel-heading">
					        <h3 class="panel-title"><i class="fa fa-clock-o"></i><font color='black'>Number contents by page</font></h3>
					   </div>
					 <div class="row">
					  {!! Form::open(array('id'=>'admin_config_contents_form','url' => 'admin/configuration/number_contents_by_page', 'method' => 'POST')) !!}
					 	<?php   
								$max_contents=Session::get('configuration')['max_contents'];
						 ?>							      
					      <div class="panel-body">
				    		<div class="col-md-4"><p class="text-left" style='font-size:18px'>max number contents</p></div>
							<div class="col-md-4">
							   {!!Form::text('max_contents',Session::get('configuration')['max_contents']) !!}
							</div>
						</div>
						<div class="row">
							<div class="col-md-4 col-md-offset-4 col-sm-offset-2 col-xs-offset-2">
								<input type="submit" id="admin_config_contents_form_submit" value="Save Configuration"  class="btn btn-primary" style="margin-top:50px;margin-bottom:25px"/>
							</div>
							{!! Form::close() !!}
						</div>
					</div>
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
        		"_token": $('#token').val(),
                "function": "clearHistoryTrackingUser"
             },
    function(data) {
        var parsed = JSON.parse(data);
        if(parsed['success']){
			  $("#alertmsg").css("color","green");
			  $("#alertmsg").text('config has been changed successfully');
			  $("#error").empty();
	    } else if(parsed['success']==false){
	    	 $("#alertmsg").css("color","red");
           	 $("#alertmsg").text(parsed['errors']['reason']);
             $("#error").text(parsed['errors']['reason']);
	     }

		 $("#popupModal").modal({                   
		        "backdrop"  : "static",
		        "keyboard"  : true,
		        "show"      : true                     
		      });
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
			  $("#alertmsg").css("color","green");
			  $("#alertmsg").text('config has been changed successfully');
			  $("#error").empty();
	    } else if(parsed['success']==false){
	    	 $("#alertmsg").css("color","red");
           $("#alertmsg").text(parsed['errors']['reason']);
           $("#error").text(parsed['errors']['reason']);
	     }

		 $("#popupModal").modal({                   
		        "backdrop"  : "static",
		        "keyboard"  : true,
		        "show"      : true                     
		      });
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
			  $("#alertmsg").css("color","green");
			  $("#alertmsg").text('config has been changed successfully');
			  $("#error").empty();
	    } else if(parsed['success']==false){
	    	 $("#alertmsg").css("color","red");
           $("#alertmsg").text(parsed['errors']['reason']);
           $("#error").text(parsed['errors']['reason']);
	     }

		 $("#popupModal").modal({                   
		        "backdrop"  : "static",
		        "keyboard"  : true,
		        "show"      : true                     
		      });
    });
})

$("#admin_config_form_location").click(function (event) {
	form=$('#admin_config_form_location').serialize();
	$.post('/admin/configuration/update_audit', form, function (data, textStatus) {
		var parsed = JSON.parse(data);
		if(parsed['success']){
			  $("#alertmsg").css("color","green");
			  $("#alertmsg").text('config has been changed successfully');
			  $("#error").empty();
	    } else if(parsed['success']==false){
	    	 $("#alertmsg").css("color","red");
           $("#alertmsg").text(parsed['errors']['reason']);
           $("#error").text(parsed['errors']['reason']);
	     }

		 $("#popupModal").modal({                   
		        "backdrop"  : "static",
		        "keyboard"  : true,
		        "show"      : true                     
		      });
	 });
	return false;
});

$("#admin_config_search_form").click(function (event) {
	form=$('#admin_config_search_form').serialize();
	$.post('/admin/configuration/update_search_engine', form, function (data, textStatus) {
		var parsed = JSON.parse(data);
		if(parsed['success']){
			  $("#alertmsg").css("color","green");
			  $("#alertmsg").text('config has been changed successfully');
			  $("#error").empty();
	    } else if(parsed['success']==false){
	    	 $("#alertmsg").css("color","red");
           $("#alertmsg").text(parsed['errors']['reason']);
           $("#error").text(parsed['errors']['reason']);
	     }

		 $("#popupModal").modal({                   
		        "backdrop"  : "static",
		        "keyboard"  : true,
		        "show"      : true                     
		      });
	 });
	return false;
});
$("#admin_config_maintenance_form_submit").click(function (event) {
	form=$('#admin_config_maintenance_form').serialize();
	$.post('/admin/configuration/maintenance', form, function (data, textStatus) {
		console.log(data);
		var parsed = JSON.parse(data);
		if(parsed['success']){
			  $("#alertmsg").css("color","green");
			  $("#alertmsg").text('config has been changed successfully');
			  $("#error").empty();
	    } else if(parsed['success']==false){
	    	 $("#alertmsg").css("color","red");
           $("#alertmsg").text(parsed['errors']['reason']);
           $("#error").text(parsed['errors']['reason']);
	     }

		 $("#popupModal").modal({                   
		        "backdrop"  : "static",
		        "keyboard"  : true,
		        "show"      : true                     
		      });
	 });
	return false;
});

$("#admin_config_email_form_submit").click(function (event) {
	form=$('#admin_config_email_form').serialize();
	$.post('/admin/configuration/email', form, function (data, textStatus) {
		console.log(data);
		var parsed = JSON.parse(data);
		if(parsed['success']){
			  $("#alertmsg").css("color","green");
			  $("#alertmsg").text('config has been changed successfully');
			  $("#error").empty();
	    } else if(parsed['success']==false){
	    	 $("#alertmsg").css("color","red");
           $("#alertmsg").text(parsed['errors']['reason']);
           $("#error").text(parsed['errors']['reason']);
	     }

		 $("#popupModal").modal({                   
		        "backdrop"  : "static",
		        "keyboard"  : true,
		        "show"      : true                     
		      });
	 });
	return false;
});



$("#admin_config_activate_user_form_submit").click(function (event) {
	form=$('#admin_config_activate_user_form').serialize();
	$.post('/admin/configuration/activate/users', form, function (data, textStatus) {
		console.log(data);
		var parsed = JSON.parse(data);
		if(parsed['success']){
			  $("#alertmsg").css("color","green");
			  $("#alertmsg").text('config has been changed successfully');
			  $("#error").empty();
	    } else if(parsed['success']==false){
	    	 $("#alertmsg").css("color","red");
           $("#alertmsg").text(parsed['errors']['reason']);
           $("#error").text(parsed['errors']['reason']);
	     }

		 $("#popupModal").modal({                   
		        "backdrop"  : "static",
		        "keyboard"  : true,
		        "show"      : true                     
		      });
	 });
	return false;
});





$("#admin_config_contents_form_submit").click(function (event) {
	form=$('#admin_config_contents_form').serialize();
	$.post('/admin/configuration/number_contents_by_page', form, function (data, textStatus) {
		console.log(data);
		var parsed = JSON.parse(data);
		if(parsed['success']){
			  $("#alertmsg").css("color","green");
			  $("#alertmsg").text('config has been changed successfully');
			  $("#error").empty();
	    } else if(parsed['success']==false){
	    	 $("#alertmsg").css("color","red");
             $("#alertmsg").text(parsed['errors']['reason']);
             $("#error").text(parsed['errors']['reason']);
	     }

		 $("#popupModal").modal({                   
		        "backdrop"  : "static",
		        "keyboard"  : true,
		        "show"      : true                     
		      });
	 });
	 
	return false;
});

</script>



@extends('cmsgroovel.layouts.groovel_admin_default')
@section('content')
	 <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
        <div id='modal' class="modal fade" style="display: none;" data-keyboard="false" data-backdrop="static">
				  <div class="modal-dialog">
				   	<div class="modal-content">
				   	 	<div class="modal-header" style='background-color: #E5E4E2'>
					 	  <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					      <h4 class="modal-title">Board update Route </h4>
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
				        	<div class="btn-group" role="group" aria-label="..." style='margin-left:400px;margin-bottom:30px'>
								  <button type="button" class="btn btn-primary" onclick="normalMode();">Normal Mode(for beginners)</button>
								  <button type="button" class="btn btn-primary" onclick="expertMode();">Expert Mode(for professionals)</button>
							</div>
						 	   {!! Form::open(array('id'=>'route_form','url' => 'admin/routes/update', 'method' => 'POST', 'class' => 'form-horizontal well ','style'=>'width:850px')) !!}
						 	   {!! Form::hidden('id', Session::get('route_edit')['id'], array('id' => 'id')) !!}
						     	<!-- 	<div class="form-group form-inline" >
								{!! Form::label('domain', 'domain').Form::text('domain', Session::get('route_edit')['domain'],  $attributes = array('class' => 'form-control','style'=>'width:450px;margin-left:80px')) !!}
								</div>-->
							
								 {!! Form::hidden('domain','', array('id' => 'id')) !!}
				  
								<div class="form-group form-inline" id="uri" data-toggle="tooltip" title="the url which you call your page example test and to get your page you call it http://yourserver//test">
								{!! Form::label('uri', 'uri',array('class'=>'required','style'=>'margin-right:60px')).Form::text('uri', Session::get('route_edit')['uri'],  $attributes = array('class' => 'form-control','style'=>'width:450px;margin-left:110px')) !!}
								</div>
								<div class="form-group form-inline" id="name" data-toggle="tooltip" title="the name of your route">
								{!! Form::label('name', 'name',array('class'=>'required','style'=>'margin-right:60px')).Form::text('name', Session::get('route_edit')['name'],  $attributes = array('class' => 'form-control','style'=>'width:450px;margin-left:90px')) !!}
								</div>
								<div class="form-group form-inline" id="controller" data-toggle="tooltip" title="specific class to give if you want develop a specific feature before to render the page">
								{!! Form::label('controller', 'controller',array('style'=>'margin-right:75px')).Form::text('controller', Session::get('route_edit')['controller'], $attributes = array('class' => 'form-control','style'=>'width:450px;margin-left:65px')) !!}
								</div>
								<div class="form-group form-inline" id="method" data-toggle="tooltip" title="method name which will be called and which will do some stuffs before to render your page">
								{!! Form::label('method', 'method',array('style'=>'margin-right:72px')).Form::text('method', Session::get('route_edit')['method'], $attributes = array('class' => 'form-control','style'=>'width:450px;margin-left:80px')) !!}
								</div>
									<?php $actions=array(
														'op_retrieve' => 'retrieve',
											            'op_delete' => 'delete',
											            'op_edit' => 'edit',
											            'op_save' => 'save',
											            'op_update' => 'update',
											            'op_add' => 'add',
									           			'none'=>'none'
											            );
									?>
								    @foreach( $actions as $action=>$value)
						                 @if( Session::get('route_edit')['action']!=$action)
						                 	<?php $actions_filter[$action]=$value;?>
						                 @endif
									@endforeach
									<div class="form-group form-inline" id="action" data-toggle="tooltip" title="action is when you want to access to a page is it for doing some update or save data or..action will be used to set some permissions rules">
									{!! Form::label('action', 'action',array('style'=>'margin-right:70px'))!!}
										<select name="action[]" class='form-control' style='width:450px;margin-left:85px'>
											<option value=<?php echo  Session::get('route_edit')['action']?>><?php echo $actions[Session::get('route_edit')['action']]?></option>
											@foreach($actions_filter as $action=>$value)
											<option value=<?php echo $action?>><?php echo $value?></option>
											@endforeach
							     		</select>	
									</div>
								<div class="form-group form-inline" id="view" data-toggle="tooltip" title="the name of your view (page name) that will be called">
								{!! Form::label('view', 'view',array('style'=>'margin-right:70px')).Form::text('view', Session::get('route_edit')['view'],  $attributes = array('class' => 'form-control','style'=>'width:450px;margin-left:100px')) !!}
								</div>
								<div class="form-group form-inline" id="before_filter" data-toggle="tooltip" title="filter settings name that will be called before to render data to a view">
								{!! Form::label('before_filter', 'before_filter',array('style'=>'margin-right:73px')).Form::text('before_filter',Session::get('route_edit')['before_filter'],  $attributes = array('class' => 'form-control','style'=>'width:450px;margin-left:50px')) !!}
								</div>
								<div class="form-group form-inline" id="after_filter" data-toggle="tooltip" title="filter settings name that will be called after data rendered in view">
								{!! Form::label('after_filter', 'after_filter',array('style'=>'margin-right:70px')).Form::text('after_filter', Session::get('route_edit')['after_filter'],  $attributes = array('class' => 'form-control','style'=>'width:450px;margin-left:65px')) !!}
								</div>
								<div class="form-group form-inline" id="type" data-toggle="tooltip" title="name of your application it is optional but it will be easy to find your route if you have got a lot of routes">
								{!! Form::label('type', 'type',array('style'=>'margin-right:74px')).Form::text('type', Session::get('route_edit')['type'],  $attributes = array('class' => 'form-control','style'=>'width:450px;margin-left:100px')) !!}
								</div>
							    <?php $subtypes= Session::get('subtypes')?>
								    @foreach( $subtypes as $subtype)
						                 @if( Session::get('route_edit')['subtype']!=$subtype)
						                 	<?php $subtypes_filter[$subtype]=$subtype;?>
						                 @endif
									@endforeach
									<div class="form-group form-inline" id="subtype" data-toggle="tooltip" title="what type of content is your page is it a view,some contents, a route.., it will be used to set permissions rules">
									{!! Form::label('subtype', 'subtype',array('style'=>'margin-right:70px','class'=>'required'))!!}
									<select name="subtype[]" class='form-control' style='width:450px;margin-left:60px'>
											<option value=<?php echo  Session::get('route_edit')['subtype']?>><?php echo Session::get('route_edit')['subtype']?></option>
											@foreach($subtypes_filter as $subtype)
											<option value=<?php echo $subtype?>><?php echo $subtype?></option>
											@endforeach
							     		</select>	
									</div>
				               
				                <div class="form-group form-inline" id="audit_url" data-toggle="tooltip" title="if you want some statistics on access this uri enable it">
				                <?php   $states=['0'=>'Disabled','1'=>'Enabled'];
									$state_filter=array();
									$audit_tracking_url_enable=Session::get('route_edit')['audit_tracking_url_enable'];
							 	?>	
							 	@if(Session::get('route_edit')!=null)		
				                {!! Form::label('audit url', 'audit_url',array('style'=>'margin-right:140px'))!!}
				           			  @foreach($states as $key=>$state)
						                 @if($audit_tracking_url_enable!=$key)
						                 	<?php $state_filter[$key]=$state;?>
						                 @endif
			             			 @endforeach
					                <select name="audit_tracking_url_enable" class='form-control'>
										<option value=<?php echo $audit_tracking_url_enable?>><?php echo $states[$audit_tracking_url_enable]?></option>
										@foreach($state_filter as $key=>$state)
										<option value=<?php echo $key?>><?php echo $state?></option>
										@endforeach
						     		</select>
						     	@endif
						   </div>
						      <div class="form-group form-inline" id="activate_route" data-toggle="tooltip" title="enable it to access to your page by this uri">
				                <?php   $states=['0'=>'Disabled','1'=>'Enabled'];
									$state_filter=array();
									$activate_route=Session::get('route_edit')['activate_route'];
							 	?>	
							 	@if(Session::get('route_edit')!=null)
							    {!! Form::label('activate_route', 'activate_route',array('style'=>'margin-right:105px'))!!}
				            		  @foreach($states as $key=>$state)
						                 @if($activate_route!=$key)
						                 	<?php $state_filter[$key]=$state;?>
						                 @endif
			             			 @endforeach
					                <select name="activate_route" class='form-control'>
										<option value=<?php echo $activate_route?>><?php echo $states[$activate_route]?></option>
										@foreach($state_filter as $key=>$state)
										<option value=<?php echo $key?>><?php echo $state?></option>
										@endforeach
						     		</select>
						     	@endif
						   </div>
						   <div class="modal-footer">
						     <p class='required' style='font-size:15px;margin-right:80%'>Fields are required</p>
			       		
			       			 <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
			       			 <input type="submit" id="submitForm" value="Save"  class="btn btn-default"/>
			        	 </div>
			        	  {!! Form::close() !!}
					</div>
				  </div>
				</div>
				</div>
   	</div>
<script type="text/javascript">
$("#submitForm").click(function (event) {
	form=$('#route_form').serialize();
	 
	$.post('/admin/routes/update', form, function (data, textStatus) {
		var parsed = JSON.parse(data);
		if(parsed['success']){
            window.scrollTo(0,0);
	        document.getElementById('light').style.display='block';
	        document.getElementById('light').className='alert alert-success fade in';
	        document.getElementById('light').innerHTML ='route has been updated successfully';
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

$(document).ready(function(){
    $('[data-toggle="tooltip"]').tooltip();
});


$(document).ready(function() {
	 $('#modal').modal('show');
});

$(document).ready(function() { 
	normalMode();
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
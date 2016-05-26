@extends('cmsgroovel.layouts.groovel_admin_route')
@section('content')
	 <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
        <div id='modal' class="modal fade" style="display: none;" data-keyboard="true" data-backdrop="static" tabindex='-1'>
				  <div class="modal-dialog">
				   	<div class="modal-content">
				   	 	<div class="modal-header" style='background-color: #E5E4E2'>
					 	  <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					      <h4 class="modal-title">Board update Page </h4>
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
						 	   {!! Form::open(array('id'=>'route_form','url' => 'admin/routes/update', 'method' => 'POST', 'class' => 'form-horizontal well ','style'=>'width:100%')) !!}
						 	   {!! Form::hidden('id', Session::get('route_edit')['id'], array('id' => 'id')) !!}
						     	<!-- 	<div class="form-group form-inline" >
								{!! Form::label('domain', 'domain').Form::text('domain', Session::get('route_edit')['domain'],  $attributes = array('class' => 'form-control','style'=>'width:450px;margin-left:80px')) !!}
								</div>-->
							
								 {!! Form::hidden('domain','', array('id' => 'id')) !!}
				  
								<div class="form-group form-inline" data-toggle="tooltip" title="the url which you call your page example test and to get your page you call it http://yourserver//test">
								{!! Form::label('uri', 'uri',array('class'=>'required','style'=>'margin-right:60px')).Form::text('uri', Session::get('route_edit')['uri'],  $attributes = array('class' => 'form-control','style'=>'width:450px;margin-left:110px')) !!}
								</div>
								<div class="form-group form-inline" id="name" data-toggle="tooltip" title="the name of your route">
								{!! Form::label('name', 'name',array('class'=>'required','style'=>'margin-right:60px')).Form::text('name', Session::get('route_edit')['name'],  $attributes = array('class' => 'form-control','style'=>'width:450px;margin-left:90px')) !!}
								</div>
								<div class="form-group form-inline" id="controller" data-toggle="tooltip" title="specific class to give if you want develop a specific feature before to render the page">
								{!! Form::label('controller', 'controller',array('style'=>'margin-right:70px')).Form::text('controller', Session::get('route_edit')['controller'], $attributes = array('class' => 'form-control','style'=>'width:450px;margin-left:65px')) !!}
								</div>
								<div class="form-group form-inline" id="method" data-toggle="tooltip" title="method name which will be called and which will do some stuffs before to render your page">
								{!! Form::label('method', 'method',array('style'=>'margin-right:71px')).Form::text('method', Session::get('route_edit')['method'], $attributes = array('class' => 'form-control','style'=>'width:450px;margin-left:80px')) !!}
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
									<div class="form-group form-inline" id="action" data-toggle="tooltip" title="action it is when you want to access to a page in order to update or save data or..action will be used to set some permissions rules">
									{!! Form::label('action', 'action',array('style'=>'margin-right:70px'))!!}
										<select name="action[]" class='form-control' style='width:450px;margin-left:85px'>
											<option value=<?php echo  Session::get('route_edit')['action']?>><?php echo $actions[Session::get('route_edit')['action']]?></option>
											@foreach($actions_filter as $action=>$value)
											<option value=<?php echo $action?>><?php echo $value?></option>
											@endforeach
							     		</select>	
									</div>
								<div class="form-group form-inline" data-toggle="tooltip" title="the name of your view (page name) that will be called">
								{!! Form::label('view', 'page',array('style'=>'margin-right:68px')).Form::text('view', Session::get('route_edit')['view'],  $attributes = array('class' => 'form-control','style'=>'width:450px;margin-left:99px')) !!}
								</div>
							
																
								@if(Session::get('layouts')!=null)
									<div class="form-group form-inline" id='type' data-toggle="tooltip" title="name of your application it is optional but it will be easy to find your route if you have got a lot of routes">
									  {!! Form::label('type', 'type',array('class'=>'required col-md-2','style'=>'margin-right:50px;margin-left:-15px'))!!}
										<select name="type" class='form-control' style='width:45%'>
											    @foreach(Session::get('layouts') as  $key=>$value)
											    	@if($key!=Session::get('route_edit')['type'])
											    		<option value="{!!$key!!}">{!!$value!!}</option>
											    	@elseif($key==Session::get('route_edit')['type'])
											    		<option selected='selected'value="{!!$key!!}">{!!$value!!}</option>
											    	@endif
											    @endforeach
							     		</select>
						     		</div>
							    @endif
					
							    <?php $subtypes= Session::get('subtypes')?>
								    @foreach( $subtypes as $subtype)
						                 @if( Session::get('route_edit')['subtype']!=$subtype)
						                 	<?php $subtypes_filter[$subtype]=$subtype;?>
						                 @endif
									@endforeach
									<div class="form-group form-inline" id="subtype" data-toggle="tooltip" title="what type of content is your page: is it a view?,some contents?, a route.., it will be used to set permissions rules">
									{!! Form::label('subtype', 'subtype',array('style'=>'margin-right:68px','class'=>'required'))!!}
									<select name="subtype[]" class='form-control' style='width:445px;margin-left:60px'>
											<option value=<?php echo  Session::get('route_edit')['subtype']?>><?php echo Session::get('route_edit')['subtype']?></option>
											@foreach($subtypes_filter as $subtype)
											<option value=<?php echo $subtype?>><?php echo $subtype?></option>
											@endforeach
							     		</select>	
									</div>
				               
				                <div class="form-group form-inline" id="audit_url" data-toggle="tooltip" title="if you want some statistics on access this uri, you can enable it">
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
							    {!! Form::label('activate_route', 'activate',array('style'=>'margin-right:145px'))!!}
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
			       			 <button type="button" class="btn btn-default" data-dismiss="modal" id='preview'>Preview</button>
			       			 <button type="button" class="btn btn-default" data-dismiss="modal" id='delete'>Delete</button>
			        	 </div>
			        	  {!! Form::close() !!}
			 
				        <div class="form-group" style='margin-left:10px;margin-top:50px'>
					     <span class="glyphicon glyphicon-pencil"></span> Edition Page(code view)
						     <div class="toggle-view panel">
						    {!! Form::open(array('id'=>'page_editcode_form','url' => 'admin/pages/code/save', 'method' => 'POST')) !!}
						     <input id='token' type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
							     <div class="form-group form-inline">
										 <!--edit page  -->
									
										<textarea id='page_edit' cols='130' rows='20'>{!!Session::get('page')!!}</textarea>
										<!--{!!Form::textarea('page_edit',\Session::get('page'), $attributes = array('id'=>'page_edit','cols'=>'130','rows'=>'20')) !!}-->
								 </div>
					    	{!! Form::close() !!}
					    		<button class="btn btn-info" type="submit" id='submitFormCode'>Save modification code</button>		 	
					        </div>
				   		 </div>	 	 
					</div>
				  </div>
				</div>
				</div>
   	</div>
<style type="text/css">
  .CodeMirror {border-top: 1px solid #eee; border-bottom: 1px solid #eee; line-height: 1.3; height: 500px}
  .CodeMirror-linenumbers { padding: 0 8px; }
   .panel {
         display:none;
    }
   .glyphicon.glyphicon-pencil {  
    cursor: pointer; 
    }
</style>
<script type="text/javascript">
$(document).delegate(".glyphicon.glyphicon-pencil", "click", function() {
	   var text =  $('.toggle-view.panel');
	    if (text.is(':hidden')) {
	        text.slideDown('200');
	    } else {
	        text.slideUp('200');
	    }
	});


var value = "// The bindings defined specifically in the Sublime Text mode\nvar bindings = {\n";
var map = CodeMirror.keyMap.sublime;
for (var key in map) {
  var val = map[key];
  if (key != "fallthrough" && val != "..." && (!/find/.test(val) || /findUnder/.test(val)))
    value += "  \"" + key + "\": \"" + val + "\",\n";
}
value += "}\n\n// The implementation of joinLines\n";
value += CodeMirror.commands.joinLines.toString().replace(/^function\s*\(/, "function joinLines(").replace(/\n  /g, "\n") + "\n";
										
var editor = CodeMirror.fromTextArea(document.getElementById("page_edit"), {
	  value: value,
	    lineNumbers: true,
	    mode: "javascript",
	    keyMap: "sublime",
	    autoCloseBrackets: true,
	    matchBrackets: true,
	    showCursorWhenSelecting: true,
	    theme: "monokai",
	    tabSize: 2
	});

function updateTextArea() {
    editor.save();
}
editor.on('change', updateTextArea);


$("#delete").click(function (event) {
	var form=$('#route_form').serialize();
	$.post('/admin/routes/delete', form, function (data, textStatus) {
		console.log(data);
		var parsed = JSON.parse(data);
		console.log('ici');
		console.log(data);
		if(parsed['success']){
			$('#route_form')[0].reset();
			$('#page_editcode_form')[0].reset();
		    window.scrollTo(0,0);
	        document.getElementById('light').style.display='block';
	        document.getElementById('light').className='alert alert-success fade in';
	        document.getElementById('light').innerHTML ='page has been deleted successfully';
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
				
		}else if(parsed['success']==false){
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
		return false;
	})
  event.preventDefault();
 return false;
})



$("#preview").click(function (event) {
	 var href=$('#uri').val();
	 var link = $('<a href="http://'+ window.location.host + '/' + href + '" />');
	 link.attr('target', '_blank');
	 window.open(link.attr('href'));
	 event.preventDefault();
	 return false;
})

										
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


$("#submitFormCode").click(function (event) {
    var form = $('#page_editcode_form').serializeArray();
    form = form.concat([
        {name: "page", value: editor.getValue()},
    ]);
    form = form.concat([
                        {name: "page_name", value: $("#view").val()},
                    ]);
	$.post('/admin/pages/code/save', form, function (data, textStatus) {
		var parsed = JSON.parse(data);
		if(parsed['success']){
		    $("#page_id").attr("value",parsed['datas']['id']);
	        window.scrollTo(0,0);
	        document.getElementById('light').style.display='block';
	        document.getElementById('light').className='alert alert-success fade in';
	        document.getElementById('light').innerHTML ='page code has been saved successfully';
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
	 event.preventDefault();
})






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
@extends('cmsgroovel.layouts.groovel_admin_page')
@section('content')
<!-- place in header of your html document -->
	<div class="col-md-8 main" style='margin-top:100px'>
				<div class="col-md-10 col-md-offset-4">
				   @if(Session::get('msg'))
			             <div>{!!var_dump(Session::get('msg'))!!}</div>
			        @endif
			    </div>
			    <div id='light'></div>
				<div id='fade'></div>
			   <!-- uri name page view type subtype -->
			    {!! Form::open(array('id'=>'page_form','url' => 'admin/pages/add', 'method' => 'POST')) !!}
				<input id='page_id' type="hidden" name='page_id' value=''>
			    
			    <div class="form-group form-inline" id="name" data-toggle="tooltip" title="the title of your page">
				    {!! Form::label('title', 'title',array('class'=>'required col-md-2')).Form::text('title', Input::old('title'), array('class'=>'form-control','style'=>'width:50%')) !!}
				  </div>
			    
			    
			     <div class="form-group form-inline" id="name" data-toggle="tooltip" title="the name of your page">
				    {!! Form::label('view', 'page name',array('class'=>'required col-md-2')).Form::text('view', Input::old('view'), array('class'=>'form-control','style'=>'width:50%')) !!}
				  </div>
				
				
			   	 <div class="form-group form-inline" id="uri" data-toggle="tooltip" title="the url which you call your page example test and to get your page you call it http://yourserver//test">
				      {!! Form::label('url', 'url',array('class'=>'required col-md-2')).Form::text('url', Input::old('url'), array('class'=>'form-control','style'=>'width:50%')) !!}
				  </div>
		
		    		@if($layouts!=null)
						<div class="form-group form-inline">
						  {!! Form::label('type', 'type',array('class'=>'required col-md-2'))!!}
					
							<select name="template" class='form-control' style='width:50%'>
								@foreach($layouts as $layout)
								<option value=<?php echo $layout?>><?php echo $layout?></option>
								@endforeach
				     		</select>
			     		</div>
					@endif
				
				<!-- public-->
			     <div class="form-group form-inline" id="activate_route" data-toggle="tooltip" title="enable it to access to your page by this uri">
				   {!! Form::label('activate_route', 'activate',array('class'=>'col-md-2'))!!}
	               		<select name="activate_route"  class='form-control'>
							<option value='0'>disabled</option>
							<option value='1'>enabled</option>
						</select>
				 </div>
				
				{!! Form::close() !!}
				 	<button class="btn btn-info" type="submit" id='submitForm'>Save</button>
					<button class='btn btn-info' id='delete'>delete</button>
				    <button class='btn btn-info' id='preview'>preview</button>
				
		
		       
		     	  <div class="form-group" style='margin-left:10px;margin-top:50px'>
				     <span class="glyphicon glyphicon-pencil"></span> Edition Page(code view)
				     <div class="toggle-view panel">
				    {!! Form::open(array('id'=>'page_editcode_form','url' => 'admin/pages/code/save', 'method' => 'POST')) !!}
					     <div class="form-group form-inline">
								 <!--edit page  -->
							
								<textarea id='page_edit' cols='130' rows='20'>{!!Session::get('page_edit')!!}</textarea>
						 </div>
			    	{!! Form::close() !!}
			    		<button class="btn btn-info" type="submit" id='submitFormCode'>Save modification code</button>		 	
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
<script>
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

								
$(document).ready(function(){
    $('[data-toggle="tooltip"]').tooltip();
    $("#preview").attr("disabled", "disabled");
    $("#delete").attr("disabled", "disabled");
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


$("#submitForm").click(function (event) {
	var alphanumers = /^[a-zA-Z0-9]+$/;
	if(!alphanumers.test($("#view").val())){
	    window.scrollTo(0,0);
        document.getElementById('light').style.display='block';
        document.getElementById('light').className='alert alert-danger fade in';
        document.getElementById('light').innerHTML = 'only alphabets and numbers are allowed for page name';
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
	    return;
	}
	
	var form=$('#page_form').serialize();
	
	$.post('/admin/pages/add', form, function (data, textStatus) {
		var parsed = JSON.parse(data);
		if(parsed['success']){
		    $("#page_id").attr("value",parsed['datas']['id']);
	        window.scrollTo(0,0);
	        document.getElementById('light').style.display='block';
	        document.getElementById('light').className='alert alert-success fade in';
	        document.getElementById('light').innerHTML ='page has been created successfully';
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
				 $("#preview").removeAttr("disabled");
				 $("#delete").removeAttr("disabled");
				 $("#preview").click(function (event) {
					 var href=parsed['datas']['url'];
					 var link = $('<a href="http://'+ window.location.host + '/' + href + '" />');
					 link.attr('target', '_blank');
					 window.open(link.attr('href'));
				})

				$("#delete").click(function (event) {
					var form=$('#page_form').serialize();
					$.post('/admin/pages/delete', form, function (data, textStatus) {
						var parsed = JSON.parse(data);
						if(parsed['success']){
							$("#delete").attr("disabled", "disabled");
							$("#preview").attr("disabled", "disabled");
							$('#page_form')[0].reset();
						    $("#page_id").attr("value",parsed['datas']['id']);
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

					})

				})
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
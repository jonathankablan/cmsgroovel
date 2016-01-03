@extends('cmsgroovel.layouts.groovel_admin_default')
@section('content')
	    <div id='modal' class="modal fade" style="display: none" data-keyboard="false" data-backdrop="static">
				  <div class="modal-dialog">
				  	<div class="modal-content">
					 	<div class="modal-header" style='background-color: #E5E4E2'>
					 	 <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					      <h4 class="modal-title">Board new Route </h4>
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
			     <div id='form-modal' class="modal-body" >
			     			<div class="btn-group" role="group" aria-label="..." style='margin-bottom:30px'>
								  <button type="button" class="btn btn-primary" onclick="normalMode();">Normal Mode(for beginners)</button>
								  <button type="button" class="btn btn-primary" onclick="expertMode();">Expert Mode(for professionals)</button>
							</div>
							{!!Form::open(array('id'=>'route_form','url' => 'admin/routes/add', 'method' => 'post'))!!}
				               {!! Form::hidden('domain','', array('id' => 'id')) !!}
				  
				              <div class="form-group form-inline" id="uri" data-toggle="tooltip" title="the url which you call your page example test and to get your page you call it http://yourserver//test">
				                {!! Form::label('uri', 'uri',array('class'=>'required col-md-2')).Form::text('uri', Input::old('uri'), array('class'=>'form-control','style'=>'width:50%','placeholder' => 'awesome@awesome.com')) !!}
				              </div>
				              
				              <div class="form-group form-inline" id="name" data-toggle="tooltip" title="the name of your route">
				                {!! Form::label('name', 'name',array('class'=>'required col-md-2')).Form::text('name', Input::old('name'), array('class'=>'form-control','style'=>'width:50%','placeholder' => 'awesome@awesome.com')) !!}
				              </div>
				                <div class="form-group form-inline" id="controller" data-toggle="tooltip" title="specific class to give if you want develop a specific feature before to render the page">
				                {!! Form::label('controller', 'controller',array('class'=>'col-md-2')).Form::text('controller', Input::old('controller'), array('id'=>'controller','class'=>'form-control','style'=>'width:50%','placeholder' => 'awesome@awesome.com')) !!}
				              </div>
				                <div class="form-group form-inline" id="method" data-toggle="tooltip" title="method name which will be called and which will do some stuffs before to render your page">
				                {!! Form::label('method', 'method',array('class'=>'col-md-2')).Form::text('method', Input::old('method'), array('class'=>'form-control','style'=>'width:50%','placeholder' => 'awesome@awesome.com')) !!}
				              </div>
				                <div class="form-group form-inline" id="action" data-toggle="tooltip" title="action it is when you want to access to a page in order to update or save data or..action will be used to set some permissions rules">
				                 {!!Form::label('action', 'action',array('class'=>'col-md-2')).Form::select('action[]',
										        array(
										         'op_retrieve' => 'retrieve',
										            'op_delete' => 'delete',
										            'op_edit' => 'edit',
										            'op_save' => 'save',
										            'op_update' => 'update',
										            'op_add' => 'add'
										             ),null,array('class'=>'form-control','style'=>'width:50%')
										        );
									    	!!}
				                </div>
				                <div class="form-group form-inline" id="view" data-toggle="tooltip" title="the name of your view (page name) that will be called">
				                {!! Form::label('view', 'view',array('class'=>'col-md-2')).Form::text('view', Input::old('view'), array('class'=>'form-control','style'=>'width:50%','placeholder' => 'awesome@awesome.com')) !!}
				              </div>
				               
				               <div class="form-group form-inline"  id="type" data-toggle="tooltip" title="name of your application it is optional but it will be easy to find your route if you have got a lot of routes">
				                {!! Form::label('type', 'type',array('class'=>'col-md-2')).Form::text('type', Input::old('type'), array('class'=>'form-control','style'=>'width:50%','placeholder' => 'awesome@awesome.com')) !!}
				              </div>
				              <div class="form-group form-inline" id="subtype" data-toggle="tooltip" title="what type of content is your page: is it a view?,some contents?, a route..,? it will be used to set permissions rules">
				               {!!Form::label('subtype', 'subtype',array('class'=>'required col-md-2'))!!}  
								<select name="subtype[]" class='form-control' style='width:50%'>
								    @foreach ($subtypes as $subtype)
									<option value={!!$subtype!!}>{!! $subtype!!}</option>
									@endforeach
								</select>
				              </div>
				               <div class="form-group form-inline" id="audit_url" data-toggle="tooltip" title="if you want some statistics on access this uri you can enable it">
				                {!! Form::label('audit url', 'audit_url',array('class'=>'col-md-2'))!!}
				               		<select name="audit_tracking_url_enable"  class='form-control'>
										<option value='0'>disabled</option>
										<option value='1'>enabled</option>
									</select>
								</div>
								 <div class="form-group form-inline" id="activate_route" data-toggle="tooltip" title="enable it to access to your page by this uri">
				                {!! Form::label('activate_route', 'activate_route',array('class'=>'col-md-2'))!!}
				               		<select name="activate_route"  class='form-control'>
										<option value='0'>disabled</option>
										<option value='1'>enabled</option>
									</select>
								</div>
			     	        
				           <!-- {!! Form::submit('Submit',array('class'=>'btn btn-default'))!!}-->
				           
						 </div>
						 <div class="modal-footer">
						     <p class='required' style='font-size:15px;margin-right:80%'>Fields are required</p>
			       		
			       			 <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
			       			 <input type="submit" id="submitForm" value="Save Changes"  class="btn btn-default" data-dismiss="modal"/>
			        	 </div>
			        	  {!! Form::close() !!}
					</div>
				  </div>
		</div>

<script type="text/javascript">



$(document).ready(function(){
    $('[data-toggle="tooltip"]').tooltip();
});

$(document).ready(function() { 
	normalMode();
});

$(document).ready(function() { 
	 $('#modal').modal('show');
});


$("#submitForm").click(function (event) {
	form=$('#route_form').serialize();
	$.post('/admin/routes/add', form, function (data, textStatus) {
		var parsed = JSON.parse(data);
		if(parsed['success']){
            window.scrollTo(0,0);
	        document.getElementById('light').style.display='block';
	        document.getElementById('light').className='alert alert-success fade in';
	        document.getElementById('light').innerHTML ='route has been added successfully';
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
								    
#hidden {
    visibility: hidden;
    height: 0;
}

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
@extends('cmsgroovel.layouts.groovel_admin_default')
@section('content')
	 <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
        
        
        <div id='modal' class="modal fade" style="display: none" data-keyboard="false" data-backdrop="static">
				  <div class="modal-dialog">
				  	<div class="modal-content">
					 	<div class="modal-header" style='background-color: #00FF40'>
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
							{!!Form::open(array('id'=>'route_form','url' => 'admin/routes/add', 'method' => 'post'))!!}
				             <!--  <div class="form-group form-inline">
				                {!! Form::label('domain', 'domain').Form::text('domain', Input::old('domain'), array('class'=>'form-control','placeholder' => 'awesome@awesome.com')) !!}
				              </div> -->
				  
				               {!! Form::hidden('domain','', array('id' => 'id')) !!}
				  
				              <div class="form-group form-inline">
				                {!! Form::label('uri', 'uri',array('class'=>'required','style'=>'margin-right:80px')).Form::text('uri', Input::old('uri'), array('class'=>'form-control','style'=>'width:450px','placeholder' => 'awesome@awesome.com')) !!}
				              </div>
				                <div class="form-group form-inline">
				                {!! Form::label('name', 'name',array('class'=>'required','style'=>'margin-right:60px')).Form::text('name', Input::old('name'), array('class'=>'form-control','style'=>'width:450px','placeholder' => 'awesome@awesome.com')) !!}
				              </div>
				                <div class="form-group form-inline">
				                {!! Form::label('controller', 'controller',array('style'=>'margin-right:50px')).Form::text('controller', Input::old('controller'), array('class'=>'form-control','style'=>'width:450px','placeholder' => 'awesome@awesome.com')) !!}
				              </div>
				                <div class="form-group form-inline">
				                {!! Form::label('method', 'method',array('style'=>'margin-right:60px')).Form::text('method', Input::old('method'), array('class'=>'form-control','style'=>'width:450px','placeholder' => 'awesome@awesome.com')) !!}
				              </div>
				                <div class="form-group form-inline">
				                 {!!Form::label('action', 'action',array('style'=>'margin-right:70px')).Form::select('action[]',
										        array(
										         'op_retrieve' => 'retrieve',
										            'op_delete' => 'delete',
										            'op_edit' => 'edit',
										            'op_save' => 'save',
										            'op_update' => 'update',
										            'op_add' => 'add'
										             ),null,array('class'=>'form-control','style'=>'width:450px')
										        );
									    	!!}
				                </div>
				                <div class="form-group form-inline">
				                {!! Form::label('view', 'view',array('style'=>'margin-right:80px')).Form::text('view', Input::old('view'), array('class'=>'form-control','style'=>'width:450px','placeholder' => 'awesome@awesome.com')) !!}
				              </div>
				                <div class="form-group form-inline">
				                {!! Form::label('before_filter', 'before_filter',array('style'=>'margin-right:30px')).Form::text('before_filter', Input::old('before_filter'), array('class'=>'form-control','style'=>'width:450px','placeholder' => 'awesome@awesome.com')) !!}
				              </div>
				                <div class="form-group form-inline">
				                {!! Form::label('after_filter', 'after_filter',array('style'=>'margin-right:40px')).Form::text('after_filter', Input::old('after_filter'), array('class'=>'form-control','style'=>'width:450px','placeholder' => 'awesome@awesome.com')) !!}
				              </div>
				               <div class="form-group form-inline">
				                {!! Form::label('type', 'type',array('style'=>'margin-right:75px')).Form::text('type', Input::old('type'), array('class'=>'form-control','style'=>'width:450px','placeholder' => 'awesome@awesome.com')) !!}
				              </div>
				              <div class="form-group form-inline">
				               {!!Form::label('subtype', 'subtype',array('style'=>'margin-right:35px','class'=>'required'))!!}  
								<select name="subtype[]" class='form-control' style='width:450px'>
								    @foreach ($subtypes as $subtype)
									<option value={!!$subtype!!}>{!! $subtype!!}</option>
									@endforeach
								</select>
				              </div>
				               <div class="form-group form-inline">
				                {!! Form::label('audit url', 'audit_url',array('style'=>'margin-right:40px'))!!}
				               		<select name="audit_tracking_url_enable"  class='form-control'>
										<option value='0'>disabled</option>
										<option value='1'>enabled</option>
									</select>
								</div>
								 <div class="form-group form-inline">
				                {!! Form::label('activate_route', 'activate_route',array('style'=>'margin-right:5px'))!!}
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
          
  
 	</div>
<script type="text/javascript">
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
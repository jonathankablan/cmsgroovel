@extends('cmsgroovel.layouts.groovel_admin_editor')  
@section('content')
<!-- place in header of your html document -->
	      

	<div class="col-sm-12 main">
				<div class="col-md-12 col-md-offset-4">
				   @if(Session::get('msg'))
			             <div>{!!var_dump(Session::get('msg'))!!}</div>
			        @endif
			    </div>
		 
			    <div class="col-md-12">
			     <div id='modal' class="modal fade" style="display: none;overflow:scroll;z-index: 1041" data-keyboard="false" data-backdrop="static" >
			     	 	  <div class="modal-dialog">
						  	<div class="modal-content">
							 	<div class="modal-header" style='background-color: #E5E4E2'>
							 	   <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
							      <h4 class="modal-title">Board Template</h4>
							    </div>
								 @if($errors->has()|| Session::get('messages'))
										<div class="span3">
											<div class="col-md-12">
											 
										           @foreach ($errors->all() as $error)
										              <div style="color:#FF0000;">{!! $error !!}</div>
										          @endforeach
										     
										       @if(Session::get('messages'))
										             <div>{!!var_dump(Session::get('messages'))!!}</div>
										        @endif
										    </div>
										</div>
								@endif
								<div id='light'></div>
								<div id='fade'></div>
							     <div id='form-modal' class="modal-body">
							     	<form method="POST" action="{{ url('admin/template/add') }}" accept-charset="UTF-8" id="template_form" class="form-horizontal well " style="width:100%">
						    			<div class="panel-body">
													@if($templates!=null)
														<div class="form-group form-inline">
														  {!! Form::label('template', 'template')!!}
													
															<select name="template" class='form-control' style='margin-left:55px'>
																@foreach($templates as $template)
																 	@if($template!='vendor' and $template!='errors') 
																		<option value=<?php echo $template?>><?php echo $template?></option>
																	@endif
																@endforeach
												     		</select>
											     		</div>
										     		@endif
													<div class="form-group form-inline"  id="controller" data-toggle="tooltip" title="the setting to be called and doing stuffs before rendering your page, optional field,leave it blank otherwhise">
														<label for="controller" style="margin-right:70px">controller</label>
									                	<input class="form-control" style="width:450px;margin-left:65px" name="controller" type="text" value={{Session::get('template')['controller']}} id="controller">
													</div>
													<div class="form-group form-inline" id="url" data-toggle="tooltip" title="url of your page">
														<label for="url" class="required" style="margin-left:80px">url</label>
														<input class="form-control" style="'width:450px;margin-left:80px" name="url" type="text" value={{Session::get('template')['url']}} id="url">
													</div>
									  	</div>
										 <div class="modal-footer">
										     <input type="submit" id="submitForm" value="Create"  class="btn btn-default" data-dismiss="modal" style='margin-left:600px'/>
							 				 <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
							        	 </div>
					        	 </form>
							</div>
						  </div>
						</div>
		 	 	</div>
	 </div>
 </div>
<script type="text/javascript">
$(document).ready(function(){
    $('[data-toggle="tooltip"]').tooltip();
});

$("#submitForm").click(function (event) {
	form=$('#template_form').serialize();
	 
	$.post('/admin/templates/add', form, function (data, textStatus) {
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
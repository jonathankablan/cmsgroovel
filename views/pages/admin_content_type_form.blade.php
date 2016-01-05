@extends('cmsgroovel.layouts.groovel_admin_content_type')
@section('content')

<div class="container-fluid" style="margin-top:100px;height:700px">
 <input id='token' type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
 <input id='content_type_id' type="hidden" name='content_type_id' value={!!\Session::get('content_type_edit')['id']!!}>
	
	<div id='light'></div>
	<div id='fade'></div>
	<div class="col-md-2" style="margin-top:100px">
				
		<ul id="form-fields">
	    		<li class="glyphicon glyphicon-calendar" style='margin-top: 25px;width:100%'><span>Date Field</span>
	    		 <input type="date" name="textbox"  class="val"/>
		    		 <div class="toggle-view panel">
	            		<div class="row" style='margin-bottom:25px'>
		            		<div class="col-md-4"><span class="required">Name</span><input type="text" id="name"  name="name" style='margin-left:4px'/></div>
		            		<div class="col-md-4">Description<input type="text" id="description" name="description" style='margin-left:4px'/></div>
		            		<div class="col-md-1">Required<input type="checkbox" id="required" name="required" style='margin-left:2px'/></div>
		            		<div class="col-md-1" style="display:none"><input id="type" type="text" name="type" value='date'/></div>
		            	</div>
	        		</div>
	    		</li>
				<li class="glyphicon glyphicon-check" style='margin-top: 25px;width:100%'><span>Checkbox</span> <input type="checkbox" name="textbox"  class="val"/>
					<div class="toggle-view panel">
						<div class="row" style='margin-bottom:25px'>
		            		<div class="col-md-4"><span class="required">Name</span><input type="text" id="name"  name="name" style='margin-left:4px'/></div>
		            		<div class="col-md-4">Description<input type="text" id="description" name="description" style='margin-left:4px'/></div>
		            		<div class="col-md-1">Required<input type="checkbox" id="required" name="required" style='margin-left:2px'/></div>
		            		<div class="col-md-1" style="display:none"><input id="type" type="text" name="type" value='checkbox'/></div>
		            	</div>
	            	</div>
				</li>
				<li class="glyphicon glyphicon-th-list" style='margin-top: 25px;width:100%'><span>Radio Group</span><input type="radio" name="textbox"  class="val"/>
					<div class="toggle-view panel">
						<div class="row" style='margin-bottom:25px'>
		            		<div class="col-md-4"><span class="required">Name</span><input type="text" id="name"  name="name" style='margin-left:4px'/></div>
		            		<div class="col-md-4">Description<input type="text" id="description" name="description" style='margin-left:4px'/></div>
		            		<div class="col-md-1">Required<input type="checkbox" id="required" name="required" style='margin-left:2px'/></div>
		            		<div class="col-md-1" style="display:none"><input id="type" type="text" name="type" value='radio group'/></div>
		            	</div>
	            	</div>
				</li>
				<li class="glyphicon glyphicon-pencil" style='margin-top: 25px;width:100%'><span>Rich Text Editor</span><textarea rows="4" cols="50" class="val"></textarea>
					<div class="toggle-view panel" style='margin-bottom:25px'>
						<div class="row">
		            		<div class="col-md-4"><span class="required">Name</span><input type="text" id="name"  name="name" style='margin-left:4px;width:100px'/></div>
		            		<div class="col-md-4">Description<input type="text" id='description' name="description" style='margin-left:4px;width:100px'/></div>
		            		<div class="col-md-1">Required<input id='required' type="checkbox" name="required" style='margin-left:2px'/></div>
		            		<div class="col-md-1" style='margin-left:30px'>widget<select id='widget' name="widget"><option value="tinymce">tinymce</option><option value="none">none</option></select></div>
							<div class="col-md-1" style="display:none"><input id="type" type="text" name="type" value='textarea'/></div>	            	
		            	</div>
	            	</div>
				</li>
				<li class="glyphicon glyphicon-list-alt" style='margin-top: 25px;width:100%'><span>Select</span><select class="val"><option value="option1">option1</option></select>
					<div class="toggle-view panel">
						<div class="row" style='margin-bottom:25px'>
		            		<div class="col-md-4"><span class="required">Name</span><input type="text" id="name"  name="name" style='margin-left:4px'/></div>
		            		<div class="col-md-4">Description<input type="text" id="description" name="description" style='margin-left:4px'/></div>
		            		<div class="col-md-1">Required<input type="checkbox" id="required" name="required" style='margin-left:2px'/></div>
		            		<div class="col-md-1" style="display:none"><input id="type" type="text" name="type" value='select'/></div>
		            	</div>
		            	<table id="table" class="table table-striped" style='margin-bottom:25px'>
		            	  <thead>
		            	  	<tr>
			            	    <th>name</th>
			            	    <th>value</th>
			            	    <th></th>
			            	    <th></th>
			            	</tr>
		            	   </thead>
		            	   <tbody>
			            	    <tr class='tr_clone'>
			            	    	<td><input type="text" id="optional_name" style='width:100px' val=''/></td>
			            	    	<td><input type="text" id="optional_value" style='width:100px' val=''/></td>
			            	     	<td><div class="glyphicon glyphicon-plus"></div></td>
			            	     	<td><div class="glyphicon glyphicon-minus"></div></td>
			            	     	<td></td>
			              	    </tr>
		              	     </tbody>
		            	</table>
		            	<div class='col-md-2' style='margin-top:10px'><button id="refresh_list" type="button" class="btn btn-success">refresh list</button></div>
	            	</div>
				</li>
				<li class="glyphicon glyphicon-text-width" style='margin-top: 25px;width:100%'><span>Text Field</span><input type="text" name="textbox" class="val" />
					<div class="toggle-view panel">
						<div class="row" style='margin-bottom:25px'>
		            		<div class="col-md-4"><span class="required">Name</span><input type="text" id="name"  name="name" style='margin-left:4px'/></div>
		            		<div class="col-md-4">Description<input type="text" id="description" name="description" style='margin-left:4px'/></div>
		            		<div class="col-md-1">Required<input type="checkbox" id="required" name="required" style='margin-left:2px'/></div>
		            		<div class="col-md-1" style="display:none"><input id="type" type="text" name="type" value='text'/></div>
		            	</div>
	            	</div>
				</li>
				<li class="glyphicon glyphicon-upload" style='margin-top: 25px;width:100%'><span>upload files</span><div class='val'> @include('cmsgroovel.sections.uploadfile')</div>
					<div class="toggle-view panel">
						<div class="row" style='margin-bottom:25px'>
		            	<div class="col-md-4"><span class="required">Name</span><input type="text" id="name"  name="name" style='margin-left:4px'/></div>
		            		<div class="col-md-4">Description<input type="text" id="description" name="description" style='margin-left:4px'/></div>
		            		<div class="col-md-1">Required<input type="checkbox" id="required" name="required" style='margin-left:2px'/></div>
		            		<div class="col-md-1" style="display:none"><input id="type" type="text" name="type" value='file'/></div>
		            	</div>
	            	</div>
				</li>
	    </ul>
	</div>

	<!-- where you drag and drop your content -->
	<div class="col-md-9">
			  <div class='row' style='margin-bottom:50px;background-color:#FAFAFA;z-index:2'>
			  	<div class='col-md-2'><button type="button" class="btn btn-success" onclick='saveTemplate()'>Save Template</button></div>
			  	<div class='col-md-2'><button type="button" class="btn btn-danger" onclick='deleteTemplate()'>Delete Template</button></div>
			  </div>
			  <div class='row' style='margin-bottom:50px;background-color:#FAFAFA;z-index:2'>
			   <div class='col-md-1'>
			   <span class="required">Title</span> 
			   </div>
			    <div class='col-md-8'>
					<input class="form-control" placeholder="Title" id="form-title" type="text" value={!! Session::get('content_type_edit')['title']!!}>
				</div>
			  </div>
		 <div class='row' style='margin-bottom:50px;background-color:#FAFAFA;z-index:2'>
			 <div class='col-md-12' id="selected-content" style="height:100%">
				<div class="droppedFields" class='background-color:grey' style="height:600px;background-color:#FAFAFA;z-index:2;border: 2px groove rgb(0,0,102);overflow:scroll">
						 @if($node=Session::get('content_type_edit'))
						 	@foreach($node['fields']  as $field)
						 	  @if($field['type']=='date')
						 	  <div class='field'>
						 	  	<div class="row" style="background-color:#E6E6E6;width:100% ">
						 	  		<div id="title" class="title col-md-2">{!!$field['name']!!}</div>
						 			<div class="col-md-8">
										 <input type="date" name="textbox"  class="val"/>
											<div class="toggle-view panel">
											 	  <div class="row" style='margin-bottom:25px'>
									            		<div class="col-md-4"><span class="required">Name</span><input type="text" id="name"  name="name" style='margin-left:4px' value={!!$field['name']!!}></div>
									            		<div class="col-md-4">Description<input type="text" id="description" name="description" style='margin-left:4px' value={!!$field['description']!!}></div>
									            		<div class="col-md-1">Required
									            		@if($field['required']==1)
									            		<input type="checkbox" id="required" name="required" style='margin-left:2px' value={!!$field['required']!!} checked='checked'></div>
									            		@else
									            		<input type="checkbox" id="required" name="required" style='margin-left:2px' value={!!$field['required']!!}></div>
									            		@endif
									            		<div class="col-md-1" style="display:none"><input id="type" type="text" name="type" value='date'/></div>
								            	  </div>
							            	</div>
							            </div>
							            <div class="glyphicon glyphicon-pencil col-md-1"></div>
							            <div id='del' class="glyphicon glyphicon-remove col-md-1"></div>
							     </div>
							  </div> 
						 	  @endif
						 	  @if($field['type']=='checkbox')
						 	  <div class='field'>
						 	  	<div class="row" style="background-color:#E6E6E6;width:100% ">
						 	  		<div id="title" class="title col-md-2">{!!$field['name']!!}</div>
						 			<div class="col-md-8">
										 <input type="checkbox" name="textbox"  class="val"/>
											<div class="toggle-view panel">
											 	  <div class="row" style='margin-bottom:25px'>
									            		<div class="col-md-4"><span class="required">Name</span><input type="text" id="name"  name="name" style='margin-left:4px'value={!!$field['name']!!}></div>
									            		<div class="col-md-4">Description<input type="text" id="description" name="description" style='margin-left:4px' value={!!$field['description']!!}></div>
									            		<div class="col-md-1">Required
									            		@if($field['required']==1)
									            		<input type="checkbox" id="required" name="required" style='margin-left:2px' value={!!$field['required']!!} checked='checked'></div>
									            		@else
									            		<input type="checkbox" id="required" name="required" style='margin-left:2px' value={!!$field['required']!!}></div>
									            		@endif
									            		<div class="col-md-1" style="display:none"><input id="type" type="text" name="type" value='checkbox'/></div>
								            	  </div>
							            	</div>
							            </div>
							            <div class="glyphicon glyphicon-pencil col-md-1"></div>
							            <div id='del' class="glyphicon glyphicon-remove col-md-1"></div>
							     </div>
							  </div> 
						 	  
						 	  @endif
						 	  @if($field['type']=='radio group')
						 	  <div class='field'>
						 	  	<div class="row" style="background-color:#E6E6E6;width:100% ">
						 	  		<div id="title" class="title col-md-2">{!!$field['name']!!}</div>
						 			<div class="col-md-8">
										 <input type="radio" name="textbox"  class="val"/>
											<div class="toggle-view panel">
											 	  <div class="row" style='margin-bottom:25px'>
									            		<div class="col-md-4"><span class="required">Name</span><input type="text" id="name"  name="name" style='margin-left:4px'value={!!$field['name']!!}></div>
									            		<div class="col-md-4">Description<input type="text" id="description" name="description" style='margin-left:4px' value={!!$field['description']!!}></div>
									            		<div class="col-md-1">Required
									            		@if($field['required']==1)
									            		<input type="checkbox" id="required" name="required" style='margin-left:2px' value={!!$field['required']!!} checked='checked'></div>
									            		@else
									            		<input type="checkbox" id="required" name="required" style='margin-left:2px' value={!!$field['required']!!}></div>
									            		@endif
									            		<div class="col-md-1" style="display:none"><input id="type" type="text" name="type" value='radio group'/></div>
								            	  </div>
							            	</div>
							            </div>
							            <div class="glyphicon glyphicon-pencil col-md-1"></div>
							            <div id='del' class="glyphicon glyphicon-remove col-md-1"></div>
							     </div>
							  </div> 
						 	  
						 	  @endif
						 	  @if($field['type']=='textarea')
						 	  <div class='field'>
						 	  	<div class="row" style="background-color:#E6E6E6;width:100% ">
						 	  		<div id="title" class="title col-md-2">{!!$field['name']!!}</div>
						 			<div class="col-md-8">
										 <textarea rows="4" cols="50" class="val"></textarea>
											<div class="toggle-view panel">
											 	<div class="row" style='margin-bottom:25px'>
											 	  <div class="col-md-4"><span class="required">Name</span><input type="text" id="name"  name="name" style='margin-left:4px;width:100px' value={!!$field['name']!!}></div>
								            	  <div class="col-md-4">Description<input type="text" id='description' name="description" style='margin-left:4px;width:100px' value={!!$field['description']!!}></div>
								            	  <div class="col-md-1">Required
								            	 	@if($field['required']==1)
									            		<input type="checkbox" id="required" name="required" style='margin-left:2px' value={!!$field['required']!!} checked='checked'></div>
									            		@else
									            		<input type="checkbox" id="required" name="required" style='margin-left:2px' value={!!$field['required']!!}></div>
									            		@endif
								            	  <div class="col-md-1" style='margin-left:30px'>widget<select id='widget' name="widget"><option value="tinymce">tinymce</option><option value="none">none</option></select></div>
												  <div class="col-md-1" style="display:none"><input id="type" type="text" name="type" value='textarea'/></div>	    
										     	</div>
										     </div>
							            </div>
							            <div class="glyphicon glyphicon-pencil col-md-1"></div>
							            <div id='del' class="glyphicon glyphicon-remove col-md-1"></div>
							     </div>
							  </div> 
						 	  @endif
						 	  @if($field['type']=='select')
						 	  <div class='field'>
						 	  	<div class="row" style="background-color:#E6E6E6;width:100% ">
						 	  		<div id="title" class="title col-md-2">{!!$field['name']!!}</div>
						 			<div class="col-md-8">
										 <select class="val"><option value="option1">option1</option></select>
											<div class="toggle-view panel">
											 	  <div class="row" style='margin-bottom:25px'>
								            		<div class="col-md-4"><span class="required">Name</span><input type="text" id="name"  name="name" style='margin-left:4px' value={!!$field['name']!!}></div>
								            		<div class="col-md-4">Description<input type="text" id="description" name="description" style='margin-left:4px' value={!!$field['description']!!}></div>
								            		<div class="col-md-1">Required
								            			@if($field['required']==1)
									            		<input type="checkbox" id="required" name="required" style='margin-left:2px' value={!!$field['required']!!} checked='checked'></div>
									            		@else
									            		<input type="checkbox" id="required" name="required" style='margin-left:2px' value={!!$field['required']!!}></div>
									            		@endif
								            		<div class="col-md-1" style="display:none"><input id="type" type="text" name="type" value='select'/></div>
		            							 </div>
								            	<table id="table" class="table table-striped" style='margin-bottom:25px'>
								            	  <thead>
								            	  	<tr>
									            	    <th>name</th>
									            	    <th>value</th>
									            	    <th></th>
									            	    <th></th>
									            	</tr>
								            	   </thead>
								            	   <tbody>
									            	    <tr class='tr_clone'>
									            	    	<td><input type="text" id="optional_name" style='width:100px' val=''/></td>
									            	    	<td><input type="text" id="optional_value" style='width:100px' val=''/></td>
									            	     	<td><div class="glyphicon glyphicon-plus"></div></td>
									            	     	<td><div class="glyphicon glyphicon-minus"></div></td>
									            	     	<td></td>
									              	    </tr>
								              	     </tbody>
								            	</table>
		            							<div class='col-md-2' style='margin-top:10px'><button id="refresh_list" type="button" class="btn btn-success">refresh list</button></div>
							            	</div>
							            </div>
							            <div class="glyphicon glyphicon-pencil col-md-1"></div>
							            <div id='del' class="glyphicon glyphicon-remove col-md-1"></div>
							     </div>
							  </div> 
						 	  
						 	  @endif
						 	  @if($field['type']=='text')
						 	  <div class='field'>
						 	  	<div class="row" style="background-color:#E6E6E6;width:100% ">
						 	  		<div id="title" class="title col-md-2">{!!$field['name']!!}</div>
						 			<div class="col-md-8">
										<input type="text" name="textbox" class="val" />
											<div class="toggle-view panel">
											 	  <div class="row" style='margin-bottom:25px'>
									            		<div class="col-md-4"><span class="required">Name</span><input type="text" id="name"  name="name" style='margin-left:4px' value={!!$field['name']!!}></div>
									            		<div class="col-md-4">Description<input type="text" id="description" name="description" style='margin-left:4px' value={!!$field['description']!!}></div>
									            		<div class="col-md-1">Required
									            		@if($field['required']==1)
									            		<input type="checkbox" id="required" name="required" style='margin-left:2px' value={!!$field['required']!!} checked='checked'></div>
									            		@else
									            		<input type="checkbox" id="required" name="required" style='margin-left:2px' value={!!$field['required']!!}></div>
									            		@endif
									            		<div class="col-md-1" style="display:none"><input id="type" type="text" name="type" value='text'/></div>
								            	  </div>
							            	</div>
							            </div>
							            <div class="glyphicon glyphicon-pencil col-md-1"></div>
							            <div id='del' class="glyphicon glyphicon-remove col-md-1"></div>
							     </div>
							  </div> 
						 	  
						 	  @endif
						 	  @if($field['type']=='file')
						 	  <div class='field'>
						 	  	<div class="row" style="background-color:#E6E6E6;width:100% ">
						 	  		<div id="title" class="title col-md-2">{!!$field['name']!!}</div>
						 			<div class="col-md-8">
										 <div class='val'> @include('cmsgroovel.sections.uploadfile')</div>
											<div class="toggle-view panel">
											 	  <div class="row" style='margin-bottom:25px'>
									            		<div class="col-md-4"><span class="required">Name</span><input type="text" id="name"  name="name" style='margin-left:4px' value={!!$field['name']!!}></div>
									            		<div class="col-md-4">Description<input type="text" id="description" name="description" style='margin-left:4px' value={!!$field['description']!!}></div>
									            		<div class="col-md-1">Required
									            		@if($field['required']==1)
									            		<input type="checkbox" id="required" name="required" style='margin-left:2px' value={!!$field['required']!!} checked='checked'></div>
									            		@else
									            		<input type="checkbox" id="required" name="required" style='margin-left:2px' value={!!$field['required']!!}></div>
									            		@endif
									            		<div class="col-md-1" style="display:none"><input id="type" type="text" name="type" value='upload files'/></div>
								            	  </div>
							            	</div>
							            </div>
							            <div class="glyphicon glyphicon-pencil col-md-1"></div>
							            <div id='del' class="glyphicon glyphicon-remove col-md-1"></div>
							     </div>
							  </div> 
						 	  
						 	  @endif
						    @endforeach
						 @endif
				
				
				
				</div>
			</div>
		</div>
	</div>
</div>


<style>
	.title{
	 font-size:1.1em;
	}
	#form-fields li .val{display: none;}
	
	.droppedFields li .val{display: inline-block}
	
	.droppedFields li .txt{display: none}
	
	.ui-draggable-dragging .val{display: none !important}
	
	.field div{cursor: pointer;}
	
	.field{
		margin-left:100px;
		margin-top:50px;
		margin-bottom:50px;
	}		
	.val{
	 width:100%;
	 margin-bottom:50px;
	 margin-top:25px;
	}	
	
	<!--toggle panels for edit properties-->
	
	.toggle-view {
    list-style:none;    
    font-family:arial;
    font-size:11px;
    margin:0;
    padding:0;
    width:300px;
	}
	
	 .panel {
        margin:5px 0;
        margin-bottom:25px;
        display:none;
    }    
	
	
</style>



<!-- End of templates -->


<script>
$(document).ready(dragContentType());   
 
</script>
@stop
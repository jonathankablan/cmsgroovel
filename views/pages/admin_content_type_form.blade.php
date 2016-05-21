@extends('cmsgroovel.layouts.groovel_admin_content_type')
@section('content')

<div class="container-fluid" style="margin-top:100px;height:700px">
 <input id='token' type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
 <input id='content_type_id' type="hidden" name='content_type_id' value={!!\Session::get('content_type_edit')['id']!!}>
	
	<div id='error' style='display:none'></div>
	

	<!-- where you drag and drop your content -->
	  <div class='row'>
			<div class="col-md-12">
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
			 </div>	  
		</div>
		<div class='row' style='margin-bottom:50px;background-color:#FAFAFA;z-index:2'>
			   <div class='col-md-1'>
			   	<span class="required">Layout</span> 
			   </div>
			    <div class='col-md-11'>
					 @if(Session::get('layouts')!=null)
						<select id="form-type" name="type" class='form-control' style='width:56%'>
							    @foreach(Session::get('layouts') as  $key=>$value)
							    	@if($key!=Session::get('content_type_edit')['template'])
							    		<option value="{!!$key!!}">{!!$value!!}</option>
							    	@elseif($key==Session::get('content_type_edit')['template'])
							    		<option selected='selected'value="{!!$key!!}">{!!$value!!}</option>
							    	@endif
							    @endforeach
			     		</select>
			 		@endif
				</div>
		  </div>
	  
		  <div class='row'>
		  	<div class='col-md-1 col-sm-1 col-xs-1' style='margin-bottom:50px;background-color:#FAFAFA;z-index:2'>
			   	 <div id="form-fields">
				   	   <div class ='row'>
				    		<div class="glyphicon glyphicon-calendar" style='margin-top: 25px'><span>Date Field</span>
				    		 <input type="date" name="textbox"  class="val"/>
					    		 <div class="toggle-view panel">
				            		<div class="row" style='margin-bottom:25px'>
					            		<div class="col-md-3" style="margin-top:10%"><span class="required">Name</span><input type="text" id="name"  name="name" style='margin-left:0%'/></div>
					            		<div class="col-md-3" style="margin-top:10%;margin-left:2%">Description<input type="text" id="description" name="description" style='margin-left:0%'/></div>
					            		<div class="col-md-1" style="margin-top:10%;margin-left:2%">Required<input type="checkbox" id="required" name="required" style='margin-left:0%'/></div>
					            		<div class="col-md-1" style="display:none"><input id="type" type="text" name="type" value='date'/></div>
					            	</div>
				        		</div>
				    		</div>
					  </div>
				     <div class ='row'>		
						<div class="glyphicon glyphicon-pencil" style='margin-top: 25px'><span>Rich Text Editor</span><textarea rows="4" cols="50" class="val"></textarea>
							<div class="toggle-view panel" style='margin-bottom:25px'>
								<div class="row">
				            		<div class="col-md-4" style='margin-left:0%'><span class="required">Name</span><input type="text" id="name"  name="name" style='width:100%'/></div>
				            		<div class="col-md-4" style='margin-left:0%'>Description<input type="text" id='description' name="description" style='width:100%'/></div>
				            		<div class="col-md-1" style='margin-left:0%'>Required<input id='required' type="checkbox" name="required" /></div>
				            		<div class="col-md-1 col-md-offset-3" style="margin-left:0%">
				            		<div  class="col-md-1 col-md-offset-7">widget</div>
					            		<select id='widget' name="widget" class="col-md-offset-7">
						            		<option value="tinymce">tinymce</option>
						            		<option value="none">none</option>
					            		</select>
				            		</div>          	
				            	</div>
			            	</div>
						</div>
					</div>
					<div class ='row'>	
						<div class="glyphicon glyphicon-text-width" style='margin-top: 25px'><span>Text Field</span><input type="text" name="textbox" class="val" />
							<div class="toggle-view panel">
								<div class="row" style='margin-bottom:25px'>
				            		<div class="col-md-3" style="margin-top:10%"><span class="required">Name</span><input type="text" id="name"  name="name" style='margin-left:0%'/></div>
				            		<div class="col-md-3" style="margin-top:10%;margin-left:2%">Description<input type="text" id="description" name="description" style='margin-left:0%'/></div>
				            		<div class="col-md-1" style="margin-top:10%;margin-left:2%">Required<input type="checkbox" id="required" name="required" style='margin-left:0%'/></div>
				            		<div class="col-md-1" style="display:none"><input id="type" type="text" name="type" value='text'/></div>
				            	</div>
			            	</div>
						</div>
					</div>
					<div class ='row'>
						<div class="glyphicon glyphicon-upload" style='margin-top: 25px'><span>upload files</span><div class='val'> @include('cmsgroovel.sections.uploadfile')</div>
							<div class="toggle-view panel">
								<div class="row" style='margin-bottom:25px'>
				            	<div class="col-md-3" style="margin-top:10%"><span class="required">Name</span><input type="text" id="name"  name="name" style='margin-left:0%'/></div>
				            		<div class="col-md-3" style="margin-top:10%;;margin-left:0%">Description<input type="text" id="description" name="description" style='margin-left:0%'/></div>
				            		<div class="col-md-1" style="margin-top:10%;;margin-left:0%">Required<input type="checkbox" id="required" name="required" style='margin-left:0%'/></div>
				            		<div class="col-md-1" style="display:none"><input id="type" type="text" name="type" value='file'/></div>
				            	</div>
			            	</div>
						</div>
					</div>
			 </div>
		</div>  
  
	<div class='col-md-10 col-sm-8 col-sm-offset-1 col-xs-8 col-xs-offset-1' id="selected-content" style="height:100%;margin-top:2%">
		<div class="droppedFields" class='background-color:grey' style="height:600px;background-color:#FAFAFA;z-index:2;border: 2px groove rgb(0,0,102);overflow:scroll">
						 @if($node=Session::get('content_type_edit'))
						 	@foreach($node['fields']  as $field)
						 	  @if($field['type']=='date')
						 	   <div class='field'>
							  	  	<div class="row" style="background-color:#E6E6E6;width:100% ">
								 	  		   <div id="title" class="title col-md-2">{!!$field['name']!!}</div>
								 	  		   <div id='del' class="glyphicon glyphicon-remove pull-right" style='margin-left:2%'></div>
								 			   <div class="col-md-8">
												 <input type="date" name="textbox"  class="val"/>
												     <div class="toggle-view">
						            				 	  <div class="row" style='margin-bottom:25px'>
												            		<div class="col-md-4" style="margin-top:10%"><span class="required">Name</span><input type="text" id="name"  name="name" style='margin-left:4px' value={!!$field['name']!!}></div>
												            		<div class="col-md-4" style="margin-top:10%">Description<input type="text" id="description" name="description" style='margin-left:4px' value={!!$field['description']!!}></div>
												            		<div class="col-md-1" style="margin-top:10%">Required
												            		@if($field['required']==1)
												            		<input type="checkbox" id="required" name="required" style='margin-left:2%' value={!!$field['required']!!} checked='checked'></div>
												            		@else
												            		<input type="checkbox" id="required" name="required" style='margin-left:2%' value={!!$field['required']!!}></div>
												            		@endif
												            		<div class="col-md-1" style="display:none"><input id="type" type="text" name="type" value='date'/></div>
											             </div>
										              </div>
									          </div>
									  </div> 
								</div>
						 	  @endif
						 	 
						 	 
						 	  @if($field['type']=='textarea')
							 	   <div class='field'>
							 	 	  	<div class="row" style="background-color:#E6E6E6;width:100%;margin-top:2% ">
								 	  		<div id="title" class="title col-md-2">{!!$field['name']!!}</div>
								 	  		<div id='del' class="glyphicon glyphicon-remove pull-right" style='margin-left:2%'></div>
								 			<div class="col-md-8">
												 <textarea rows="4" cols="50" class="val"></textarea>
												    <div class="toggle-view">
													 	<div class="row" style='margin-bottom:25px'>
															 	  <div class="col-md-4" style="margin-top:10%"><span class="required">Name</span><input type="text" style="width:100%" id="name"  name="name" style='margin-left:4px;width:100px' value={!!$field['name']!!}></div>
												            	  <div class="col-md-4" style="margin-top:10%">Description<input type="text" id='description'  style="width:100%" name="description" style='margin-left:4px;width:100px' value={!!$field['description']!!}></div>
												            	  <div class="col-md-1" style="margin-top:10%">Required
												            	 	@if($field['required']==1)
													            		<input type="checkbox" id="required" name="required" style='margin-left:2%' value={!!$field['required']!!} checked='checked'></div>
													            		@else
													            		<input type="checkbox" id="required" name="required" style='margin-left:2%' value={!!$field['required']!!}></div>
													            		@endif
												            	  <div class="col-md-1" style='margin-left:10%;margin-top:10%'>widget
													            	  <select id='widget' name="widget">
													            	  @if($field['widget']=='')
													            	      <option selected value="none">none</option>
													            	      <option value="tinymce">tinymce</option>
													   			   	  @else
													            	  	   <option selected value="tinymce">tinymce</option>
													            	  	   <option value="none">none</option>
													             	  @endif
													             	  </select>
												             	  </div>
																  <div class="col-md-1" style="display:none"><input id="type" type="text" name="type" value='textarea'/></div>	    
													     </div>
												     </div>
										      </div>
								          </div>
							        </div>
						 	  @endif
						 	
						 	  @if($field['type']=='text')
						 	   <div class='field'>
							 	  	<div class="row" style="background-color:#E6E6E6;width:100% ;margin-top:2%">
							 	  		  <div id="title" class="title col-md-2">{!!$field['name']!!}</div>
							 	  		  <div id='del' class="glyphicon glyphicon-remove pull-right" style='margin-left:2%'></div>
							 			  <div class="col-md-8">
											<input type="text" name="textbox" class="val" />
											         <div class="toggle-view">
													 	  <div class="row" style='margin-bottom:25px'>
											            		<div class="col-md-4" style="margin-top:10%"><span class="required">Name</span><input type="text" style="width:100%" id="name"  name="name"  value={!!$field['name']!!}></div>
											            		<div class="col-md-4" style="margin-top:10%;margin-left:0%">Description<input style="width:100%" type="text" id="description" name="description" value={!!$field['description']!!}></div>
											            		<div class="col-md-1" style="margin-top:10%;margin-left:0%">Required
											            		@if($field['required']==1)
											            		<input type="checkbox" id="required" name="required" value={!!$field['required']!!} checked='checked'></div>
											            		@else
											            		<input type="checkbox" id="required" name="required" value={!!$field['required']!!}></div>
											            		@endif
											            		<div class="col-md-1" style="display:none"><input id="type" type="text" name="type" value='text'/></div>
										            	  </div>
									            	   </div>
								            </div>
								       </div>
								 </div>
						 	  @endif
						 	  @if($field['type']=='file')
						 	  <div class='field'>
					 	  			<div class="row" style="background-color:#E6E6E6;width:100%;margin-top:2% ">
								 	  			<div id="title" class="title col-md-2">{!!$field['name']!!}</div>
								 	  			<div id='del' class="glyphicon glyphicon-remove pull-right" style='margin-left:2%'></div>
							 	  		    	<div class="col-md-8">
													 <div class='val'> @include('cmsgroovel.sections.uploadfile')</div>
													       <div class="toggle-view">
									    				 	  <div class="row" style='margin-bottom:25px'>
												            		<div class="col-md-4" style="margin-top:10%"><span class="required">Name</span><input type="text" id="name"  name="name" style='margin-left:4px' value={!!$field['name']!!}></div>
												            		<div class="col-md-4" style="margin-top:10%;margin-left:10%">Description<input type="text" id="description" name="description" style='margin-left:4px' value={!!$field['description']!!}></div>
												            		<div class="col-md-1" style="margin-top:10%;margin-left:10%">Required
												            		@if($field['required']==1)
												            		<input type="checkbox" id="required" name="required" style='margin-left:2%' value={!!$field['required']!!} checked='checked'></div>
												            		@else
												            		<input type="checkbox" id="required" name="required" style='margin-left:2%' value={!!$field['required']!!}></div>
												            		@endif
												            		<div class="col-md-1" style="display:none"><input id="type" type="text" name="type" value='upload files'/></div>
											            	  </div>
											            	</div>
									           		</div>
								               </div>
								             </div>
								        </div>
							 	  @endif
						    @endforeach
						 @endif
			    </div>
		    </div>
	</div><!-- container-fluid -->
 </div><!-- row form fields -->

<style>
	.title{
	 font-size:1.1em;
	}
	#form-fields div .val{display: none;}
	
	.droppedFields div .val{display: inline-block}
	
	.droppedFields div .txt{display: none}
	
	.ui-draggable-dragging .val{display: none !important}
	
	#form-fields{cursor: pointer;}
	 
	 #del {cursor: pointer;}
	 
	.field{
		margin-left:2%px;
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
    width:100%;
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
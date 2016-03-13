@extends('cmsgroovel.layouts.groovel_admin_content')
@section('content')
<!-- place in header of your html document -->
	<div class="col-sm-12 main">
				<div class="col-md-12 col-md-offset-4">
				   @if(Session::get('msg'))
			             <div>{!!var_dump(Session::get('msg'))!!}</div>
			        @endif
			    </div>
			    	
			    <div id='modal' class="modal fade" style="display: none;" data-keyboard="true" data-backdrop="static" tabindex='-1'>
				  <div class="modal-dialog">
				  	<div class="modal-content">
					 	<div class="modal-header" style='background-color: #E5E4E2'>
					 	 <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					      <h4 class="modal-title">Board Content</h4>
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
						<div id='error' style='display:none'></div>
			
			            <div id='form-modal' class="modal-body">
						 	   {!! Form::open(array('id'=>'content_form','url' => 'admin/content/update','files'=>true)) !!}
			      
			              	   
		                	   {!! Form::hidden('content_id', Session::get('content_edit')['id'], array('id' => 'id')) !!}
		                	   
		                	    {!! Form::hidden('translation_id', Session::get('content_edit')['translation_id'], array('id' => 'translation_id')) !!}
		                	    {!! Form::hidden('duplicate', Session::get('content_edit')['duplicate'], array('id' => 'duplicate')) !!}
		                	     <input id='token' type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
		                	     <input id='action' type="hidden" name="action" value="admin/content/update">
							  	<div style='background-color:#FAFAFA'>
								  	<div class="row">
						            	<div class="form-group" data-toggle="tooltip" title="the title of your content">
						                	<div class="col-md-2">
									    		<label for="title">title</label><span class="required"></span>
										    </div>
										    <div class="col-md-8">
										    	{!!Form::text('title', Session::get('content_edit')['title'],$attributes = array('class' => 'form-control')) !!}
										    </div>
						             	</div>
					            	</div>
					            	<div class="row" style="margin-top:50px">
						            	<div class="form-group" title="the langage of the content will be used in accordance with your extension website for exemple if your site has for extension.fr the contents with langage france will be shown">
						            			   
									     		@if($langages= Session::get('langages'))
										        	<?php $lang=$langages[Session::get('content_edit')['lang']];?>
													<?php $keys=array_keys($langages);?>
													@foreach($keys as $key)
													     @if($lang==$langages[$key])
													      <?php $codelang_selected=$key;?>
													     @endif
										                 @if($lang!=$langages[$key])
										                 	<?php $langage_filter[$key]=$langages[$key];?>
										                 @endif
										             @endforeach
											     @endif
											     <div class="col-md-2">
									    			<label for="langage">langage</label><span class="required"></span>
										   		 </div>
										   		 <div class="col-md-8">
										     		 <select name="langage[]" class="form-control">
														<option value=<?php echo $codelang_selected?>><?php echo $langages[$codelang_selected]?></option>
														<?php $keys=array_keys($langage_filter);?>
														@foreach($keys as $key)
														<option value=<?php echo $key?>><?php echo $langage_filter[$key]?></option>
														@endforeach
										     		</select>
									     		</div>
								        </div>
					             	</div>
					            	<div class="row" style="margin-top:50px">
						            	<div class="form-group">
						            		<div class="col-md-2">
									    		<label for="weight">weight</label><span class="required"></span>
										    </div>
										    <div class="col-md-8">
										    	{!!Form::text('weight',Session::get('content_edit')['weight'], array('data-toggle'=>'tooltip',"title"=>"the biggest value will be set,it means this content will be shown first",'class'=>'form-control','placeholder' => 'weight')) !!}
										    </div>
									   </div>
								   </div>
								   <div class="row" style="margin-top:50px">
						            	<div class="form-group" data-toggle="tooltip" title="the tag is the word that will be used in the search engine to find the content">
						               		<div class="col-md-2">
								    			<label for="tag">tag</label><span class="required"></span>
										    </div>
										    <div class="col-md-8">
										    	 	{!!Form::text('tag', Session::get('content_edit')['tag'], $attributes = array('class' => 'form-control')) !!}
						      			    </div>
						            	</div>
					            	</div>
					            	<div class="row" style="margin-top:50px">
						                <div class="form-group" data-toggle="tooltip" title="the description of your content">
						                	<div class="col-md-2">
								    			<label for="description">description</label><span class="required"></span>
										    </div>
										    <div class="col-md-8">
										    	{!! Form::textarea('description', Session::get('content_edit')['description'], $attributes = array('class' => 'form-control')) !!}
						          		    </div>
						            	</div>
					            	</div>
					            	<div class="row" style="margin-top:50px">
						            	<div class="form-group">
						            		<div class="col-md-3">
									    		<label for="publish">publish content</label>
										    </div>
										    <div class="col-md-8">
										        {!! Form::checkbox('isPublish', Input::old('isPublish'),Session::get('content_edit')['ispublish'], array('data-toggle'=>'tooltip',"title"=>"to publish your content you have to check the box",'class'=>'form-control','placeholder' => 'isPublish')) !!}
										    </div>
									   </div>
								   </div>
				           		</div>
						        @if($node=Session::get('content_edit'))
						            @foreach($node['content']  as $content)
						            <div class="row" style="margin-top:50px">
						                   <div  class="form-group">
						                     	<br/>
						                     	
						                     	  @if($content['type']=='file')
												   <div class="row">
													  <div class="col-md-3" style="margin-left:10px">
													   <label>Files attachments</label>
													   </div>
														<div class="col-md-3">
															   @include('cmsgroovel.sections.uploadfile')
															   <input type="hidden" id="token" value="{{ csrf_token() }}">
														</div> 
												</div>	
						                      	  @elseif($content['type']=='text')
						                      	     <div class="row">
													    <div class="col-md-2" style="margin-left:10px">
								                  		 @if($content['required']==0)
						                         				{!! Form::label('name',$content['name'], array('class' => 'control-label'))!!}
								                  		 @endif
							                    		 @if($content['required']==1)
							                       			{!! Form::label('name',$content['name'], array('class' => 'control-label required'))!!}
								                 		 @endif
														  </div>
								                		 <div class="col-md-8">
								                    		{!!Form::text($content['name'],$content['content'], $attributes = array('class' => 'form-control')) !!}
								                    	 </div>
							                    	   </div>
							                
							                  	  @elseif($content['type']=='textarea')
						                     		@if($content['widget']==-1)
						                     		 <div class="row">
						                     		   	 <div class="col-md-2" style="margin-left:10px">
							                     		 @if($content['required']==0)
						                         			{!! Form::label('name',$content['name'], array('class' => 'control-label'))!!}
								                    	 @endif
							                    		 @if($content['required']==1)
							                     			{!! Form::label('name',$content['name'], array('class' => 'control-label required'))!!}
								                    	 @endif
								                    	 </div>
								                		 <div class="col-md-8">
								                    		{!!Form::textarea($content['name'],$content['content'], $attributes = array('class' => 'form-control')) !!}
								                    	 </div>
							                    	   </div>
						                     		@elseif($content['widget']==11)
						                     		 <div class="row">
							                     		<div class="col-md-2" style="margin-left:10px">
								                     		 @if($content['required']==0)
								                     			{!! Form::label('name',$content['name'], array('class' => 'control-label'))	!!}
								                     		 @endif
								                     		 @if($content['required']==1)
								                     		 	{!! Form::label('name',$content['name'], array('class' => 'control-label required'))	!!}
								                     		 @endif
							                     		</div>
							                    		<div class="col-md-8" style='margin-bottom:50px'>
							                     			<textarea  id="elm1" name={!!$content['name']!!}>{!!$content['content']!!}</textarea>
							                     		</div>
							                     	</div>
							                     	 @endif
							                 
						                     	 @elseif($content['type']=='date')
						                     		<div class="row">
														 <div class="col-md-2" style="margin-left:10px">
														@if($content['required']==0)
						                         	 			{!! Form::label('name',$content['name'], array('class' => 'control-label'))!!}
														@endif
							                    		 @if($content['required']==1)
																{!! Form::label('name',$content['name'], array('class' => 'control-label required'))!!}
								                 		 @endif
												   		 </div>
								                		 <div class="col-md-8">
								                    		{!!Form::input('date',$content['name'],$content['content'], $attributes = array('class' => 'form-control')) !!}
								                    	 </div>
							                    	   </div>
						                     	 @endif
						              		</div>
				                     	</div>	
					                @endforeach
						        @endif
						        <br/>
						        <br/>
						     
						         
						 </div>
						 <div class="modal-footer">
						     <p class='required' style='font-size:15px;margin-right:80%'>Fields are required</p>
			       		
			       			 <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
			       			  {!! Form::submit('Update',array('id'=>'submitForm','class'=>'btn btn-default'))!!}
								 <!-- {!! Form::reset('Reset',array('class'=>'btn btn-default','data-dismiss'=>'modal'))!!}-->
								<!-- {!! Form::submit('Delete',array('class'=>'btn btn-default','data-dismiss'=>'modal'))!!}-->
								
			    	 			{!! Form::close() !!}	
			    	 			<button id="delete" onclick='deleteContents()' class="btn btn-default">Delete</button>
			    	 			
			    	 			<button id="view" onclick='viewContents()' class="btn btn-default">View code</button>
			        	 </div>
					</div>
				  </div>
				</div>	
	</div>
<script>

$(document).ready(function(){
    $('[data-toggle="tooltip"]').tooltip();
});
						                     		

$(document).ready(function() {
	bindFileEvents('content_form');
	$('#modal').modal('show');
});


function viewContents(){
	inputData=document.getElementById('id');
    inputData1=document.getElementById('translation_id');
    args=new Array();
    args['id']=inputData.value;
    args['translation_id']=inputData1.value;
 	   $.ajax({
           type: 'get',
           data : any2url('q',args),
           url: "/admin/content/viewcode",
            success: function(data) {
               alert(data);
            },
           error: function(xhr, textStatus, thrownError) {
              alert(thrownError);
               alert('Something went to wrong.Please Try again later...');
           }
          
       });
	
}



function deleteContents(){
    inputData=document.getElementById('id');
    inputData1=document.getElementById('translation_id');
    args=new Array();
    args['id']=inputData.value;
    args['translation_id']=inputData1.value;
 	   $.ajax({
           type: 'get',
           data : any2url('q',args),
           url: "/admin/content/delete",
            success: function(data) {
               $("#alertmsg").css("color","green");
			   $("#alertmsg").text('content deleted successfully');
			   $("#error").empty();
               $("#popupModal").modal({                    // wire up the actual modal functionality and show the dialog
                   "backdrop"  : "static",
                   "keyboard"  : true,
                   "show"      : true                     // ensure the modal is shown immediately
                 });
               $('#modal').modal('hide');
           },
           error: function(xhr, textStatus, thrownError) {
              alert(thrownError);
               alert('Something went to wrong.Please Try again later...');
           }
          
       });
	
}


$("#submitForm").click(function (event) {
	if(tinymce!=null){
 	 	//force to get filed value by tinymce
 		tinymce.triggerSave();
 	}
	//add token form

	form=$('#content_form').serialize();
	validateContent(form);
	if (!$('#error').text().trim().length){
	    var status=postFiles();
	    if(!status){
			return false;
		}
		form=$('#content_form').serialize();
		postContent(form,'update');
	}
	return false;

}); 


</script>

@stop
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
			               <form method="POST" action="{{url('admin/content/update')}}" accept-charset="UTF-8" id="content_form" enctype="multipart/form-data">
							     {{ csrf_field() }}
					    	     <input id='action' type="hidden" name="action" value="admin/content/update">
		                	     <input id="id" name="content_id" type="hidden" value={!! Session::get('content_edit')['id'] !!}>
		                	   	 <input id="translation_id" name="translation_id" type="hidden" value={!! Session::get('content_edit')['translation_id'] !!}>
		                	     <input id="duplicate" name="duplicate" type="hidden" value= {!!Session::get('content_edit')['duplicate'] !!}>
		     
		     			  	<div style='background-color:#FAFAFA'>
								  	<div class="row">
						            	<div class="form-group" data-toggle="tooltip" title="the title of your content">
						               	    <div class="col-md-2">
									    		<label for="title">title</label><span class="required"></span>
										    </div>
										    <div class="col-md-8">
										    	<input class="form-control" name="title" type="text" value={{ Session::get('content_edit')['title']}}>
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
										    	<input data-toggle="tooltip" title="the biggest value will be set,it means this content will be shown first" class="form-control" placeholder="weight" name="weight" type="text" value={{Session::get('content_edit')['weight']}}>
										    </div>
									   </div>
								   </div>
								   <div class="row" style="margin-top:50px">
						            	<div class="form-group" data-toggle="tooltip" title="the tag is the word that will be used in the search engine to find the content">
						               		<div class="col-md-2">
								    			<label for="tag">tag</label><span class="required"></span>
										    </div>
										    <div class="col-md-8">
										    	 	<input class="form-control" name="tag" type="text" value={{Session::get('content_edit')['tag']}} >
						      			    </div>
						            	</div>
					            	</div>
					            	<div class="row" style="margin-top:50px">
						                <div class="form-group" data-toggle="tooltip" title="the description of your content">
						                	<div class="col-md-2">
								    			<label for="description">description</label><span class="required"></span>
										    </div>
										    <div class="col-md-8">
										    	<textarea class="form-control" name="description" cols="50" rows="10">{{Session::get('content_edit')['description']}} </textarea>
						          		    </div>
						            	</div>
					            	</div>
					            	<div class="row" style="margin-top:50px">
						                <div class="form-group" data-toggle="tooltip" title="uri of your content">
						                	<div class="col-md-2">
								    			<label for="uri">uri</label>
										    </div>
										    <div class="col-md-8">
										    	<input class="form-control" name="uri"type='text' value={{Session::get('content_edit')['uri']}} >
						          		    </div>
						            	</div>
					            	</div>
					            	<div class="row" style="margin-top:50px">
						            	<div class="form-group">
						            	    <div class="col-md-3">
									    		<label for="publish">publish content</label>
										    </div>
										    <div class="col-md-8">
										        <input data-toggle="tooltip" title="to publish your content you have to check the box" class="form-control" placeholder="isPublish" checked={{Session::get('content_edit')['ispublish']}} name="isPublish" type="checkbox">
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
						                         				<label for={{$content['name']}} class='control-label'>{{$content['name']}}</label>
								                  		 @endif
							                    		 @if($content['required']==1)
							                       			<label for={{$content['name']}} class='control-label required'>{{$content['name']}}</label>
								                 		 @endif
														  </div>
								                		 <div class="col-md-8">
								                    		<input class="form-control" name={{$content['name']}}  type="text" value={!!$content['content']!!} >
								                    	 </div>
							                    	   </div>
							                
							                  	  @elseif($content['type']=='textarea')
						                     		@if($content['widget']==-1)
						                     		 <div class="row">
						                     		   	 <div class="col-md-2" style="margin-left:10px">
							                        	 @if($content['required']==0)
						                         				<label for={{$content['name']}} class='control-label'>{{$content['name']}}</label>
								                  		 @endif
							                    		 @if($content['required']==1)
							                       			<label for="{{$content['name']}}" class='control-label required'>{{$content['name']}}</label>
								                 		 @endif
								                    	 </div>
								                		 <div class="col-md-8">
								                    		<textarea name={{$content['name']}}  class="form-control">{!!$content['content']!!}</textarea>
								                    	 </div>
							                    	   </div>
						                     		@elseif($content['widget']==11)
						                     		 <div class="row">
							                     		<div class="col-md-2" style="margin-left:10px">
								                     		 @if($content['required']==0)
						                         				<label for={{$content['name']}} class='control-label'>{!!$content['name']!!}</label>
									                  		 @endif
								                    		 @if($content['required']==1)
								                       			<label for={{$content['name']}} class='control-label required'>{!!$content['name']!!}</label>
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
						                         				<label for={{$content['name']}} class='control-label'>{!!$content['name']!!}</label>
									                  		 @endif
								                    		 @if($content['required']==1)
								                       			<label for={{$content['name']}} class='control-label required'>{!!$content['name']!!}</label>
									                 		 @endif
												   		 </div>
								                		 <div class="col-md-8">
								                    		<input class="form-control" name={{$content['name']}} type="date" value="$content['content']" >
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
			       			    <input id="submitForm" class="btn btn-default" type="submit" value="Update">
			       		 </form>
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
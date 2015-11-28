@extends('cmsgroovel.layouts.groovel_admin_editor')
@section('content')
<!-- place in header of your html document -->



	<div class="col-sm-12 main">
				<div class="col-md-12 col-md-offset-4">
				   @if(Session::get('msg'))
			             <div>{!!var_dump(Session::get('msg'))!!}</div>
			        @endif
			    </div>
			    	
			    <div id='modal' class="modal fade" style="display: none;" data-keyboard="false" data-backdrop="static">
				  <div class="modal-dialog">
				  	<div class="modal-content">
					 	<div class="modal-header" style='background-color: #00FF40'>
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
						<div id='light'></div>
						<div id='fade'></div>
					     <div id='form-modal' class="modal-body">
							<div class="panel-body">
			              	   {!! Form::open(array('id'=>'content_form','url' => 'admin/content/update','files'=>true)) !!}
			      
			              	   
		                	   {!! Form::hidden('content_id', Session::get('content_edit')['id'], array('id' => 'id')) !!}
		                	   
		                	    {!! Form::hidden('translation_id', Session::get('content_edit')['translation_id'], array('id' => 'translation_id')) !!}
		                	    {!! Form::hidden('duplicate', Session::get('content_edit')['duplicate'], array('id' => 'duplicate')) !!}
							   <div style="margin-top: 30px; margin-bottom: 15px;width: 100%; height: 60px; background-color: rgb(152, 251, 152)">
							   <p style="margin-left: 350px;">General settings</p>
							   </div>
				            	<div class="form-group form-inline" data-toggle="tooltip" title="the title of your content">
				                	{!! Form::label('Title', 'Title', array('class' => 'col-md-1 control-label required','style'=>'margin-left: auto')).Form::text('title', Session::get('content_edit')['title'],$attributes = array('class' => 'form-control','style'=>'width:450px;margin-left:146px')) !!}
				            	</div>
				               
				        
				                <div class="form-group form-inline" data-toggle="tooltip" title="the url to access to your content">
				                	{!! Form::label('Url', 'url', array('class' => 'col-md-3 control-label required')).Form::text('url', Session::get('content_edit')['url'], $attributes = array('class' => 'form-control','style'=>'width:450px')) !!}
				            	</div>
				            	
				            	<div class="form-group form-inline" data-toggle="tooltip" title="the tag is the word that will be used in the search engine to find the content">
				                	{!! Form::label('tag', 'tag', array('class' => 'col-md-2 control-label required','style'=>'margin-right:75px')).Form::text('groovelDescription', Session::get('content_edit')['groovelDescription'], $attributes = array('class' => 'form-control','style'=>'width:450px')) !!}
				            	</div>
				            	
				            	<div class="form-group form-inline" title="the langage of the content will be used in accordance with your extension website for exemple if your site has for extension.fr the contents with langage france will be shown">
				            			   
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
									      {!!Form::label('langage', 'langage',array('style'=>'margin-left:13px;margin-right:119px','class'=>'required'))!!}  
							     		 <select name="langage[]" style="margin-right:142px;margin-left:18px" class="form-control">
											<option value=<?php echo $codelang_selected?>><?php echo $langages[$codelang_selected]?></option>
											<?php $keys=array_keys($langage_filter);?>
											@foreach($keys as $key)
											<option value=<?php echo $key?>><?php echo $langage_filter[$key]?></option>
											@endforeach
							     		</select>
						        	</div>
				             
				               <div style="margin-top: 30px; margin-bottom: 15px;width: 100%; height: 60px; background-color: rgb(152, 251, 152)">
							   <p style="margin-left: 350px;">Content</p>
							   </div>
						        @if($node=Session::get('content_edit'))
						            @foreach($node['content']  as $content)
				                  	       <div  class="form-group form-inline">
						                     	<br/>
						                     		@if($content['widget']==-1)
							                     		 @if($content['required']==0)
							                    			{!! Form::label('name',$content['name'], array('class' => 'col-md-3 control-label')).Form::textarea($content['name'],$content['content'], $attributes = array('class' => 'form-control','style'=>'width:450px')) !!}
							                    		 @endif
							                    		 @if($content['required']==1)
							                    		 	{!!Form::label('name',$content['name'], array('class' => 'col-md-3 control-label required')).Form::textarea($content['name'],$content['content'], $attributes = array('class' => 'form-control','style'=>'width:450px')) !!}
							                    		 @endif
						                     		@elseif($content['widget']==11)
						                     		<div class="col-md-3">
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
						                     		@elseif($content['widget']==12)
						                     		<label style='margin-left:20px'>Files attachments</label>
						                     		<div style='margin-left:200px'>
						                     		       @include('cmsgroovel.sections.uploadfile')
						                     		       <input type="hidden" id="token" value="{{ csrf_token() }}">
						                     		 </div>    
						                     		       
						                  		    @endif
				                     		</div>	
					                @endforeach
						        @endif
						        <br/>
						        <br/>
						      <div style="margin-top: 500px; margin-bottom: 15px;width: 100%; height: 60px; background-color: rgb(152, 251, 152)">
							   <p style="margin-left: 350px;">Optional settings</p>
							   </div>
						         <div class="form-group form-inline" id="row_content" style="margin-top:50px;margin-bottom:50px">
							         {!! Form::label('isPublish','Publish',array('style'=>'margin-right: 20px;margin-left: 250px')).Form::checkbox('isPublish', Input::old('isPublish'),Session::get('content_edit')['ispublish'], array('data-toggle'=>'tooltip',"title"=>"to publish your content you have to check the box",'class'=>'form-control','placeholder' => 'isPublish')) !!}
							  	 	     
								 	 {!! Form::label('weight','weight of your content',array('style'=>'margin-right: 20px;margin-left: 150px')).Form::text('weight',Session::get('content_edit')['weight'], array('data-toggle'=>'tooltip',"title"=>"the biggest value will be set,it means this content will be shown first",'class'=>'form-control','placeholder' => 'weight')) !!}
					
							
								 </div>
							  	
				   			</div>
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
	fileEvents();
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
               alert('content deleted successfull');
               $('#modal').modal('hide');
           },
           error: function(xhr, textStatus, thrownError) {
              alert(thrownError);
               alert('Something went to wrong.Please Try again later...');
           }
          
       });
	
}


$("#submitForm").click(function (event) {
	getFileOldList();
	var status=true;
	if(tinymce!=null){
 	 	//force to get filed value by tinymce
 		tinymce.triggerSave();
 	}
	var form=$('#content_form').serialize();
	if(document.getElementById('my-file')!=null){
		document.getElementById('my-file').value='';
	}
	status=validateFiles(storedFiles,filesAlreadyStored);

	if(status){
	     var ajaxData = new FormData();
	   	    for(i=0;i<storedFiles.length;++i){
				    var xhr = new XMLHttpRequest();
				    ajaxData.append("file", storedFiles[i]);
				    var token =  document.getElementById('token').value;
				    ajaxData.append("_token",token);
				    xhr.onreadystatechange = function () {
					  	response = this.responseText;
					  	if(response!=""){
				     	  	var url = JSON.parse(response);
				     	  	if(url['success']==false){
				        	    window.scrollTo(0,0);
						        document.getElementById('light').style.display='block';
						        document.getElementById('light').className='alert alert-danger fade in';
						        document.getElementById('light').innerHTML =  url['errors']['reason'];
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
					  			status= false;
				            }		
						  	urlimg[storedFiles[i]['name']]=url.datas[storedFiles[i]['name']];
					  	}
				  	}
				   // console.log('send file');
				    xhr.open("POST", "/admin/file/upload",false);
		  		    xhr.send(ajaxData);
			    }
	    if(!status){
			return false;
	    }
		var urls=[];	
        var rem= document.getElementById("myfiles");
        if(rem!=null){rem.remove();}
  		var input = document.createElement('input');
		input.type='hidden';
		input.name='myfiles';
        input.id='myfiles';
		for(var filename in urlimg)
		{
         urls.push(urlimg[filename]);
		}
		for(var i=0;i<filesAlreadyStored.length;i++)
		{     urls.push(filesAlreadyStored[i].value);
		}
    	//ajout ancienne image
        input.value=urls;
        if(document.getElementById('list')!=null){
   			document.getElementById('list').insertBefore(input, null);
        }
		form=$('#content_form').serialize();
		$.post('/admin/content/update', form, function (data, textStatus) {
			urlimg={};
			//console.log(data);
			var parsed = JSON.parse(data);
			if(parsed['success']){
				window.scrollTo(0,0);
		        document.getElementById('light').style.display='block';
		        document.getElementById('light').className='alert alert-success fade in';
		        document.getElementById('light').innerHTML ='content has been updated successfully';
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
	}else{
	 return false;	
	}
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
@extends('cmsgroovel.layouts.groovel_admin_content')
@section('content')
<div class="col-md-2" style="margin-top:100px;display:none">
				
		<ul id="form-fields">
		<!-- For title  -->
			<li>
				<div id='title' class="form-group">
	    						<div class="col-md-2">
							    	<label for="title">title</label><span class="required"></span>
							    </div>
							    <div class="col-md-8">
							    	<input type="text" class="form-control" id="title" name='title'/>
							    </div>
				</div>
			 </li>
			 <li>
				<div id='layout' class="form-group">
	    						<div class="col-md-2">
							    	<label for="layout">layout</label><span class="required"></span>
							    </div>
							    <div class="col-md-8">
							    	<input type="text" value="default" class="form-control" id="inputlayout" name='layout' disabled/>
							    </div>
				</div>
			 </li>
			 <li>
				<div id='weight' class="form-group">
	    						<div class="col-md-2">
							    	<label for="title">weight</label>
							    </div>
							    <div class="col-md-8">
							    	<input type="text" class="form-control" id="weight" name='weight'/>
							    </div>
				</div>
				</li>
				<li>
				<div id='langage' class="form-group">
	    						<div class="col-md-2">
							    	<label for="langage">langage</label><span class="required"></span>
							    </div>
							    <div class="col-md-8">
							    	<select id='langage' name='langage' class="form-control"><option value="option1">option1</option></select>
							    </div>
				</div>
				</li>
				<li>
				<div id='tag' class="form-group">
	    						<div class="col-md-2">
							    	<label for="tag">tag</label><span class="required"></span>
							    </div>
							    <div class="col-md-8">
							    	<input type="text" class="form-control" id="tag" name="tag"/>
							    </div>
				</div>
				</li>
				<li>
				<div id='publish' class="form-group">
	    						<div class="col-md-2">
							    	<label for="publish">publish content</label>
							    </div>
							    <div class="col-md-8">
							    	<input id='isPublish' name='isPublish' type="checkbox" class="form-control"/>
							    </div>
				  </div>
				  </li>
				  <li>
				 <div id='description' class="form-group">
	    						<div class="col-md-2">
							    	<label for="description">description</label><span class="required"></span>
							    </div>
							    <div class="col-md-8">
							    	<textarea class="form-control" id="description" name='description'></textarea>
							    </div>
				</div>
				</li>
		<!-- all fields available -->
		
	    		<li class="glyphicon glyphicon-calendar" style='margin-top: 25px;width:100%'><span>Date Field</span>
	    			<div id='date' class="form-group">
	    				<div class='row' style='margin-top:50px;margin-left:5px'>
	    						<div class="col-md-2">
							    	<label for="name">name</label><span class="required"></span>
							    </div>
							    <div class="col-md-8">
							    	<input type="date" class="form-control" id="name" name='name'/>
							    </div>
						 </div>
				    </div>
	    		</li>
				<li class="glyphicon glyphicon-check" style='margin-top: 25px;width:100%'><span>Checkbox</span> 
					<div id='checkbox' class="form-group">
					 	<div class='row' style='margin-top:50px;margin-left:5px'>
	    						<div class="col-md-2">
							    	<label for="name">name</label><span class="required"></span>
							    </div>
							    <div class="col-md-8">
							    	<input id='name' type="checkbox" class="form-control" name='name'/>
							    </div>
					    </div>
				    </div>
				</li>
				<li class="glyphicon glyphicon-th-list" style='margin-top: 25px;width:100%'><span>Radio Group</span>
					<div id='radio' class="form-group">
					       <div class='row' style='margin-top:50px;margin-left:5px'>
	    						<div class="col-md-2">
							    	<label for="name">name</label><span class="required"></span>
							    </div>
							    <div class="col-md-8">
							    	<input id='name' type="radio" class="form-control" name='name'/>
							    </div>
							</div>
				    </div>
				</li>
				<li class="glyphicon glyphicon-pencil" style='margin-top: 25px;width:100%'><span>Rich Text Editor</span>
					<div id='textarea' class="form-group">
						<div class='row' style='margin-top:50px;margin-left:5px'>
	    						<div class="col-md-2">
							    	<label for="name">name</label><span class="required"></span>
							    </div>
							    <div class="col-md-8">
							    	<textarea id='name' rows="4" cols="50" style='overflow:true;width:100%' class="form-control" name='name'></textarea>
							    </div>
					     </div>
				    </div>
				</li>
				<li class="glyphicon glyphicon-list-alt" style='margin-top: 25px;width:100%'><span>Select</span>
					<div id='select' class="form-group">
						<div class='row' style='margin-top:50px;margin-left:5px'>
	    						<div class="col-md-2">
							    	<label for="name">name</label><span class="required"></span>
							    </div>
							    <div class="col-md-8">
							    	<select id='name' name='name' class="form-control"><option value="option1">option1</option></select>
							    </div>
					    </div>
				    </div>
				</li>
				<li class="glyphicon glyphicon-text-width" style='margin-top: 25px;width:100%'><span>Text Field</span>
					<div id='text' class="form-group">
						<div class='row' style='margin-top:50px;margin-left:5px'>
	    						<div class="col-md-2">
							    	<label for="name">name</label><span class="required"></span>
							    </div>
							    <div class="col-md-8">
							    	<input id='name' name='name' type="text" name="textbox" class="form-control" />
							    </div>
						 </div>
				    </div>
				</li>
				<li class="glyphicon glyphicon-upload" style='margin-top: 25px;width:100%'><span>upload files</span>
					<div id='uploadfile' class="form-group">
					    <div class='row' style='margin-top:50px;margin-left:5px'>
	    						<div class="col-md-2">
							    	<label for="name">name</label><span class="required"></span>
							    </div>
							    <div class="col-md-8">
							    	<div id='name'> @include('cmsgroovel.sections.uploadfile')</div>
							    </div>
						 </div>
				    </div>
				</li>
	    </ul>
	</div>
	<div class="col-md-10" style='margin-top: 100px'>
			<div class='row'>
				<div class='col-md-3 col-md-offset-1'>
					 <label class="required">Choose your content template</label>
	    		</div>	
				<div class='col-md-5'>	
				 <select class="form-control" id="a" onchange="showContentType(this.value,&quot;/admin/content/form/view_update&quot;);clearFileOldList()" name="content_types">
					  @foreach(Session::get('content_types') as $content_type)
					  	<option value={{$content_type}}>{{$content_type}}</option>
					  @endforeach
				 </select>
				</div>
			</div>
	</div>
		
    @include('cmsgroovel.sections.loadingwindow')
    <div id='modal' class="modal fade" style="display: none;overflow:scroll" data-keyboard="true" data-backdrop="static" tabindex='-1'>
       <div class="modal-dialog">
     	<div class="modal-content">
		 	<div class="modal-header" style='background-color: #E5E4E2'>
		 	  <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		      <h4 class="modal-title">New content</h4>
		    </div>
			 @if($errors->has()|| Session::get('messages'))
					<div class="span3">
						<div class="col-md-12 col-md-offset-2">
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
			 <input id='token' type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
			 <input id='action' type="hidden" name="action" value="admin/content/add">
			 <input id='content_id' type="hidden" name="content_id">
		
		     <div id='form-modal' class="modal-body">
				<form id="content_form" role="form">	
				
				</form>
			 </div>
			 <div class="modal-footer" style='margin-top:50px'>
			 <p class='required' style='font-size:15px;margin-right:80%'>Fields are required</p>
			  
       			 <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
       			 <input type="submit" id="submitForm" value="Save"  class="btn btn-default" data-dismiss="modal"/>
        	 </div>
		</div>
	  </div>
	</div>

	
	<script>
	
	
	$("#submitForm").click(function (event) {
	 	if(tinymce!=null){
	 	 	//force to get filed value by tinymce
	 		tinymce.triggerSave();
	 	}
	 	$( "#token" ).clone().appendTo( "#content_form" );
	 	$( "#content_id" ).clone().appendTo( "#content_form" );
		form=$('#content_form').serialize();
		validateContent(form);
		if (!$('#error').text().trim().length){
		    var status=postFiles();
		    if(!status){
				return false;
			}
			form=$('#content_form').serialize();
			postContent(form,'add');
		}
		return false;
	}); 


$(document).on('focusin', function(e) {
    if ($(e.target).closest(".mce-window").length) {
        e.stopImmediatePropagation();
    }
});


$( "#modal" ).on( "hidden.bs.modal", function(e) {
	//clear all data problem other wise with tinymce and remove id content otherwise it delete the prev content
	document.getElementById('content_form').innerHTML='';
	$("#content_id").attr("value",'');
	if(tinymce!=null){
		try{
			tinymce.remove();
		}catch(err){

		}
	}
});


 
</script>


@stop

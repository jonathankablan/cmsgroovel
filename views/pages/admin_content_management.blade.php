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
				 <div id='url' class="form-group">
	    						<div class="col-md-2">
							    	<label for="url">url</label><span class="required"></span>
							    </div>
							    <div class="col-md-8">
							    	<input type="text" class="form-control" id="url" name='url'/>
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
							    	<textarea id='name' rows="4" cols="50" style='overflow:true' class="form-control" name='name'></textarea>
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
				<div class='col-md-3 col-md-offset-3'>
					 {!!Form::label('Choose your content template', 'Choose your content template',array('class'=>'required'))!!}  
				</div>	
				<div class='col-md-5'>	
					{!! Form::select('content_types',Session::get('content_types'),'default',
				 array('class' => 'form-control','id'=> 'a','onchange'=>'showContentType(this.value,"/admin/content/form/view_update");clearFileOldList()')) !!}
				</div>
			</div>
	</div>
		
    @include('cmsgroovel.sections.loadingwindow')
    <div id='modal' class="modal fade" style="display: none;overflow:scroll" data-keyboard="false" data-backdrop="static">
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
			<div id='light'></div>
			<div id='fade'></div>
			 <input id='token' type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
			 <input id='action' type="hidden" name="action" value="admin/content/add">
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
	window.document.onkeydown = function (e)
	{
	    if (!e){
	        e = event;
	    }
	    if (e.keyCode == 27){
	        lightbox_close();
	    }
	}
	
	
	$("#submitForm").click(function (event) {
	 	if(tinymce!=null){
	 	 	//force to get filed value by tinymce
	 		tinymce.triggerSave();
	 	}
	 	document.getElementById('content_form').appendChild( document.getElementById('token'));
		form=$('#content_form').serialize();
		validateContent(form);
		if($('#light').children().length==0){
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
	if(tinymce!=null){
		try{
			tinymce.remove();
		}catch(err){

		}
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

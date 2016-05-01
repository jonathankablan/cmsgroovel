@extends('cmsgroovel.layouts.groovel_admin_content_type_management')
@section('content')

<div class="container-fluid" style="margin-top:100px;height:700px">
 <input id='token' type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
<input id='content_type_id' type="hidden" name='content_type_id' value=''>
 <div id='error' style='display:none'></div>
	<div class="col-md-2 col-md-offset-2" style="margin-top:100px">
				
		<ul id="form-fields">
	    		<li class="glyphicon glyphicon-calendar" style='margin-top: 25px'><span>Date Field</span>
	    		 <input type="date" name="textbox"  class="val"/>
		    		 <div class="toggle-view panel">
	            		<div class="row" style='margin-bottom:25px'>
		            		<div class="col-md-4"  style='margin-left:0%'><span class="required">Name</span><input type="text" id="name"  name="name" style='witdh:100%'/></div>
		            		<div class="col-md-4"  style='margin-left:10%'>Description<input type="text" id="description" name="description" style=witdh:100%'/></div>
		            		<div class="col-md-1"  style='margin-left:10%'>Required<input type="checkbox" id="required" name="required"/></div>
		            		<div class="col-md-1" style="display:none"><input id="type" type="text" name="type" value='date'/></div>
		            	</div>
	        		</div>
	    		</li>
				<!--<li class="glyphicon glyphicon-check" style='margin-top: 25px;width:100%'><span>Checkbox</span> <input type="checkbox" name="textbox"  class="val"/>
					<div class="toggle-view panel">
						<div class="row" style='margin-bottom:25px'>
		            		<div class="col-md-4"><span class="required">Name</span><input type="text" id="name"  name="name" style='margin-left:4px'/></div>
		            		<div class="col-md-4">Description<input type="text" id="description" name="description" style='margin-left:4px'/></div>
		            		<div class="col-md-1">Required<input type="checkbox" id="required" name="required" style='margin-left:2px'/></div>
		            		<div class="col-md-1" style="display:none"><input id="type" type="text" name="type" value='checkbox'/></div>
		            	</div>
	            	</div>
				</li>
				-->
				<!-- <li class="glyphicon glyphicon-th-list" style='margin-top: 25px;width:100%'><span>Radio Group</span><input type="radio" name="textbox"  class="val"/>
					<div class="toggle-view panel">
						<div class="row" style='margin-bottom:25px'>
		            		<div class="col-md-4"><span class="required">Name</span><input type="text" id="name"  name="name" style='margin-left:4px'/></div>
		            		<div class="col-md-4">Description<input type="text" id="description" name="description" style='margin-left:4px'/></div>
		            		<div class="col-md-1">Required<input type="checkbox" id="required" name="required" style='margin-left:2px'/></div>
		            		<div class="col-md-1" style="display:none"><input id="type" type="text" name="type" value='radio group'/></div>
		            	</div>
	            	</div>
				</li>
				 -->
				<li class="glyphicon glyphicon-pencil" style='margin-top: 25px'><span>Rich Text Editor</span><textarea rows="4" cols="50" class="val" style='overflow:true'></textarea>
					<div class="toggle-view panel" style='margin-bottom:25px'>
						<div class="row">
		            		<div class="col-md-4" style='margin-left:0%'><span class="required">Name</span><input type="text" id="name"  name="name" style='width:100%'/></div>
		            		<div class="col-md-4" style='margin-left:-5%'>Description<input type="text" id='description' name="description" style='width:100%'/></div>
		            		<div class="col-md-1" style='margin-left:1%'>Required<input id='required' type="checkbox" name="required" /></div>
		            		<div class="col-md-1" style="margin-left:7%"><span style='margin-left:5%'>widget</span><select id='widget' name="widget"><option value="tinymce">tinymce</option><option value="none">none</option></select></div>
							<div class="col-md-1" style="display:none"><input id="type" type="text" name="type" value='textarea'/></div>	            	
		            	</div>
	            	</div>
				</li>
				<!-- <li class="glyphicon glyphicon-list-alt" style='margin-top: 25px;width:100%'><span>Select</span><select class="val"><option value="option1">option1</option></select>
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
				 -->
				<li class="glyphicon glyphicon-text-width" style='margin-top: 25px'><span>Text Field</span><input type="text" name="textbox" class="val" />
					<div class="toggle-view panel">
						<div class="row" style='margin-bottom:25px'>
		            		<div class="col-md-4" style='margin-left:0%;'><span class="required">Name</span><input type="text" id="name"  name="name" style='witdh:100%'/></div>
		            		<div class="col-md-4" style='margin-left:10%'>Description<input type="text" id="description" name="description" style='witdh:100%'/></div>
		            		<div class="col-md-1" style='margin-left:10%'>Required<input type="checkbox" id="required" name="required"/></div>
		            		<div class="col-md-1" style="display:none"><input id="type" type="text" name="type" value='text'/></div>
		            	</div>
	            	</div>
				</li>
				<li class="glyphicon glyphicon-upload" style='margin-top: 25px'><span>upload files</span><div class='val'> @include('cmsgroovel.sections.uploadfile')</div>
					<div class="toggle-view panel">
						<div class="row" style='margin-bottom:25px'>
		            	<div class="col-md-4"><span class="required">Name</span><input type="text" id="name"  name="name" style='witdh:100%'/></div>
		            		<div class="col-md-4" style="margin-left:10%">Description<input type="text" id="description" name="description" style='witdh:100%'/></div>
		            		<div class="col-md-1" style="margin-left:10%">Required<input type="checkbox" id="required" name="required"/></div>
		            		<div class="col-md-1" style="display:none;margin-left:10%"><input id="type" type="text" name="type" value='file'/></div>
		            	</div>
	            	</div>
				</li>
	    </ul>
	</div>

	<!-- where you drag and drop your content -->
	<div class="col-md-8">
		  <div class='row' style='margin-bottom:50px;background-color:#FAFAFA;z-index:2'>
		  	<div class='col-md-2'><button type="button" class="btn btn-success" onclick='saveTemplate()'>Save Template</button></div>
		  	<div class='col-md-2 col-lg-offset-1 col-lg-3'><button type="button" class="btn btn-danger" onclick='deleteTemplate()'>Delete Template</button></div>
		  	<div class='col-md-2'>
		  	<button id='helpinfo' class="btn btn-info" title='You have to drag and drop components in the surface area below, you must put a unique title for each field by clicking on the pencil, menu will toogle and you will fill each field, name is mandatory'>Help info</button>
		   </div>
		  	<!-- <div class='col-md-2'><button type="button" class="btn btn-primary" onclick='previewTemplate()'>Preview Template</button></div> -->
		  </div>
		  <div class='row' style='margin-bottom:50px;background-color:#FAFAFA;z-index:2'>
		   <div class='col-md-1'>
		   <span class="required">Title</span> 
		   </div>
		    <div class='col-md-8'>
				<input class="form-control" placeholder="Title" id="form-title" type="text">
			</div>
		  </div>
		  <div class='row' style='margin-bottom:50px;background-color:#FAFAFA;z-index:2'>
		   <div class='col-md-1'>
		   <span class="required">Layout</span> 
		   </div>
		     @if($layouts!=null)
			<div class='col-md-8' id='type'>
				<select id="form-type" name="type" class='form-control' style='width:50%'>
					@foreach($layouts as $layout)
					<option value=<?php echo $layout?>><?php echo $layout?></option>
					@endforeach
	     		</select>
     		</div>
			@endif
		  </div>
		 
		  
		  
		  
		  
		  
		 <div class='row' style='margin-bottom:50px;background-color:#FAFAFA;z-index:2'>
			 <div class='col-md-12' id="selected-content" style="height:100%">
				<div class="droppedFields" class='background-color:grey' style="height:600px;background-color:#FAFAFA;z-index:2;border: 2px groove rgb(0,0,102);overflow:scroll"></div>
							
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
 $(document).ready(function(){
	    $( "#helpinfo" )
      .tooltip({
        content: $( "#helpinfo" ).attr( "title" ),
        items: 'button'
        })
      .off( "mouseover" )
      .on( "click", function(){
          $( this ).tooltip( "open" );
          return false;
        })
      .attr( "title", "" ).css({ cursor: "pointer" });
	});
</script>
@stop
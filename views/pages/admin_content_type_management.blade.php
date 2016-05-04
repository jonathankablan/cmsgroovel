@extends('cmsgroovel.layouts.groovel_admin_content_type_management')
@section('content')

    <input id='token' type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
	<input id='content_type_id' type="hidden" name='content_type_id' value=''>
	<div class='row'>	 
	 <div id='error' style='display:none'></div>
  	</div>
	<div class='row' style='margin-top:100px'>
		  <div class='col-md-8  col-md-offset-4' style='margin-bottom:50px;background-color:#FAFAFA;z-index:2'>
			   <div class='col-md-1'>
			   <span class="required">Title</span> 
			   </div>
			    <div class='col-md-8'>
					<input class="form-control" placeholder="Title" id="form-title" type="text">
				</div>
		  </div>
	</div>
	<div class='row'>
		  <div class='col-md-8  col-md-offset-4' style='margin-bottom:50px;background-color:#FAFAFA;z-index:2'>
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
	</div>
	  <div class='row'>
          <div class='col-md-8 col-md-offset-4' style='margin-bottom:50px;background-color:#FAFAFA;z-index:2'>
			  	<div class='col-md-2'><button type="button" class="btn btn-success" onclick='saveTemplate()'>Save Template</button></div>
			  	<div class='col-md-2 col-lg-offset-1 col-lg-3'><button type="button" class="btn btn-danger" onclick='deleteTemplate()'>Delete Template</button></div>
			  	<div class='col-md-2'>
			  	<button id='helpinfo' class="btn btn-info" title='You have to drag and drop components in the surface area below, you must put a unique title for each field by clicking on the pencil, menu will toogle and you will fill each field, name is mandatory'>Help info</button>
			   </div>
		  </div>
	 </div>	
	<div class='row'> 
		<div class="col-md-2 col-md-offset-2 col-xs-4" style="margin-top:100px">
			<div id="form-fields">
		    		<div class="glyphicon glyphicon-calendar" style='margin-top: 25px'><span>Date Field</span>
		    		 <input type="date" name="textbox"  class="val"/>
			    		 <div class="toggle-view panel">
		            		<div class="row" style='margin-bottom:25px'>
			            		<div class="col-md-3"  style='margin-left:0%'><span class="required">Name</span><input type="text" id="name"  name="name" style='witdh:100%'/></div>
			            		<div class="col-md-3"  style='margin-left:10%'>Description<input type="text" id="description" name="description" style=witdh:100%'/></div>
			            		<div class="col-md-1"  style='margin-left:10%'>Required<input type="checkbox" id="required" name="required"/></div>
			            		<div class="col-md-1" style="display:none"><input id="type" type="text" name="type" value='date'/></div>
			            	</div>
		        		</div>
		    		</div>
					
					<div class="glyphicon glyphicon-pencil" style='margin-top: 25px'><span>Rich Text Editor</span><textarea rows="4" cols="50" class="val" style='overflow:true'></textarea>
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
								<div class="col-md-1" style="display:none"><input id="type" type="text" name="type" value='textarea'/></div>	            	
			            	</div>
		            	</div>
					</div>
					
					<div class="glyphicon glyphicon-text-width" style='margin-top: 25px'><span>Text Field</span><input type="text" name="textbox" class="val" />
						<div class="toggle-view panel">
							<div class="row" style='margin-bottom:25px'>
			            		<div class="col-md-3" style='margin-left:0%;'><span class="required">Name</span><input type="text" id="name"  name="name" style='witdh:100%'/></div>
			            		<div class="col-md-3" style='margin-left:0%'>Description<input type="text" id="description" name="description" style='witdh:100%'/></div>
			            		<div class="col-md-1" style='margin-left:0%'>Required<input type="checkbox" id="required" name="required"/></div>
			            		<div class="col-md-1" style="display:none"><input id="type" type="text" name="type" value='text'/></div>
			            	</div>
		            	</div>
					</div>
					<div class="glyphicon glyphicon-upload" style='margin-top: 25px'><span>upload files</span><div class='val'> @include('cmsgroovel.sections.uploadfile')</div>
						<div class="toggle-view panel">
							<div class="row" style='margin-bottom:25px'>
			            	<div class="col-md-3"><span class="required">Name</span><input type="text" id="name"  name="name" style='witdh:100%'/></div>
			            		<div class="col-md-3" style="margin-left:0%">Description<input type="text" id="description" name="description" style='witdh:100%'/></div>
			            		<div class="col-md-1" style="margin-left:0%">Required<input type="checkbox" id="required" name="required"/></div>
			            		<div class="col-md-1" style="display:none;margin-left:0%"><input id="type" type="text" name="type" value='file'/></div>
			            	</div>
		            	</div>
					</div>
		    </div>
		</div>
		<!-- where you drag and drop your content -->
		<div class="col-md-8 col-xs-8">
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
	#form-fields div .val{display: none;}
	
	.droppedFields div .val{display: inline-block}
	
	.droppedFields div .txt{display: none}
	
	.ui-draggable-dragging .val{display: none !important}
	
	.field div{cursor: pointer;}
	
	.field{
		margin-left:5%;
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
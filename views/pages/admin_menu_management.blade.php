@extends('cmsgroovel.layouts.groovel_admin_menu')
@section('content')
<!-- schema type
ul li
<ul>
					<li>
						<h3 class='i'>Link A</h3>
					    <ul>
					        <li>
						     	<h3 class='ii'>sub Link A1</h3>
				              	   <ul>
				              	   		<li><h4 class='ii'></>sub sub Link A1.1</h4>
				              	   			<ul>
				              	   				<li>sub sub sub Link</li>
				              	   			
				              	   			</ul>	
				              	   		</li>
				              	   		<li>sub sub Link A1.2</li>
				              	   </ul>
				             </li>
					     </ul>
					</li>
				</ul>
				<ul>		
					<li>
						<h3 class='i'>Link B</h3>
					    <ul>
					        <li>
						     	<h3 class='ii'>sub Link B1</h3>
				              	   <ul>
				              	   		<li>sub sub Link B1.1</li>
				              	   		<li>sub sub Link B1.2</li>
				              	   </ul>
				             </li>
					     </ul>
					</li>
				</ul>		
						
-->
<div class="container-fluid" style="margin-top:100px;height:700px">
 <input id='token' type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
<input id='menu_id' type="hidden" name='menu_id' value=''>
 <div id='light'></div>
<div id='fade'></div>
	

	<!-- where you drag and drop your content -->
	<div class="col-md-12">
		  <div class='row' style='margin-bottom:50px;background-color:#FAFAFA;z-index:2'>
		  	<div class='col-md-1'><button id='save' type="button" class="btn btn-success" onclick='saveMenu()'>Save Menu</button></div>
		  	<div class='col-md-2 col-md-offset-1'><button id='delete' type="button" class="btn btn-danger" onclick='deleteMenu()'>Delete Menu</button></div>
		  </div>
		  <div class='row' style='margin-bottom:50px;background-color:#FAFAFA;z-index:2'>
		   <div class='col-md-1'>
		   <span class="required">Title</span> 
		   </div>
		    <div class='col-md-4'>
				<input class="form-control" placeholder="Title" id="title" type="text">
			</div>
		  </div>
		  <div class='row' style='margin-bottom:50px;background-color:#FAFAFA;z-index:2'>
		   <div class='col-md-1'>
		   <span class="required">Langage</span> 
		   </div>
		    <div class='col-md-4 form-group'>
	     		<select id='langages' class="form-control" name='langages'>
					    <option name='langages'></option>
					    @foreach($langages as $langage)
					    <?php if(!empty($langage)):?>
					    <option value="{!!$langage!!}">{!! $langage !!}</option>
					    <?php endif;?>
					    @endforeach
				</select>
			</div>
		  </div>
		  <div class='row' style='margin-bottom:50px;background-color:#FAFAFA;z-index:2'>
		   <div class='col-md-1'>
		   <span class="required">Layout</span> 
		   </div>
		    <div class='col-md-4 form-group'>
	     		<select id='layouts' class="form-control" name='layouts'>
					    <option name='layouts'></option>
					    @foreach($layouts as $layout)
					    <?php if(!empty($layout)):?>
					    <option value="{!!$layout!!}">{!! $layout !!}</option>
					    <?php endif;?>
					    @endforeach
				</select>
			</div>
		  </div>
		 <div class='row' style='margin-bottom:50px;background-color:#FAFAFA;z-index:2'>
			 <div class='col-md-12' id="selected-content" style="height:100%">
				<div class="droppedFields" class='background-color:grey' style="height:600px;background-color:#FAFAFA;z-index:2;border: 2px groove rgb(0,0,102);overflow:scroll">
				
				<ul class='u'>
					<li>
					   <div class='add-right d row'> 
					   		<div class='col-md-1'>
					    		 <i style="font-size:15px" class="glyphicon glyphicon-plus" style='margin-top:35px' onmouseover="this.style.cursor='pointer'" ></i>
					    	 </div>
					   		<div class='col-md-1'>
					  			    <label for="name">link name</label>
							</div>  
							<div class='col-md-2'>
								    <input type="text" class="form-control" id="name" placeholder="name">
							</div>
							<div class='col-md-1'>
					  			    <label for="url">url</label>
							</div>  
							<div class='col-md-2'>
								    <input type="text" class="form-control" id="url" placeholder="url">
							</div>
					  		<div class='col-md-4'>
									<button id='addMnItem' class="btn btn-info" style='margin-bottom:15px'>Add Item</button>
									<button id='addMnChildItem' class="btn btn-primary" style='margin-bottom:15px'>Add Child Item</button>
									<i style="font-size:15px" class="glyphicon glyphicon-remove" style='margin-top:35px' onmouseover="this.style.cursor='pointer'"></i>
							</div>
						</div>
					</li>
				</ul>
				</div>
			</div>
		</div>
	</div>
</div>

<script>
$("#delete").attr("disabled", "disabled");

					    
$(document).on('click', '#addMnItem', function(){
	if($(this).parents().eq(1).attr("class")=='add-right d row'){
		var ul=createUL('d');
		ul.insertAfter($(this).parents().eq(3));
	}else if($(this).parents().eq(1).attr("class")=='add-right dd row'){
		li=createLI("dd");
	  	li.insertAfter($(this).parents().eq(2));
	}else if ($(this).parents().eq(1).attr("class")=='add-right ddd row'){
		li=createLI("ddd");
		li.insertAfter($(this).parents().eq(2));
	}else if ($(this).parents().eq(1).attr("class")=='add-right dddd row'){
		li=createLI("dddd");
		li.insertAfter($(this).parents().eq(2));
	}
	
});

$(document).on('click', '#addMnChildItem', function(){
	var level=$(this).parents().eq(1).attr("class");
	var li=null;
   if(level=='add-right d row'){
 		var ul=createUL('dd');
      	ul.insertAfter($(this).parents().eq(1));
  }else if(level=='add-right dd row'){
		var ul=createUL('ddd');
		ul.insertAfter($(this).parents().eq(1));
   }else if(level=='add-right ddd row'){	   	   	
		var ul=createUL('dddd');
		ul.insertAfter($(this).parents().eq(1));
   }
});

$(document).on('click','.glyphicon.glyphicon-plus',function () {
	$(this).parents().eq(2).find('ul').toggle();
});

$(document).on('click','.glyphicon.glyphicon-remove',function () {
	$(this).parents().eq(2).remove();
});


</script>


<style>

.add-right{

}

.d{


}
.dd{

}
.ddd{

}
.dddd{

}

</style>	



@stop
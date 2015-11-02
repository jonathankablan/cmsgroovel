@extends('cmsgroovel.layouts.groovel_admin_editor')
@section('content')
<!-- place in header of your html document -->

<div class="col-md-12 main">
	<div id='modal' class="modal fade" style="display: none;" data-keyboard="false" data-backdrop="static">
	  <div class="modal-dialog">
	  	<div class="modal-content">
		 	<div class="modal-header" style='background-color: #00FF40'>
		 	  <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		      <h4 class="modal-title">Board Content Types</h4>
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
			       {!! Form::open(array('id'=>'content_type_form','url' => 'admin/content_type/update', 'method' => 'POST')) !!}
	               {!! Form::hidden('content_type_id', Session::get('content_type_edit')['id'], array('id' => 'id')) !!}
				  
				    <div class="span3">
				    	<div class="col-md-12 form-inline">
				           {!! Form::label('Title', 'Title',array('class'=>'required','style'=>'margin-right:50px')).Form::text('title',  Session::get('content_type_edit')['title'], array('class'=>'form-control','style'=>'width:450px','placeholder' => 'title','readonly')) !!}
				        </div> 
				     </div>       
				    <div class="span3">
			            	<div class="col-md-12">
			            	      	<INPUT type="button" value="Add Fields" onclick="addRow('table_content_types')" />
							       	<INPUT type="button" value="Delete Fields" onclick="deleteRowContentType('table_content_types')" />
								
							
								    <table id="table_content_types" class="line-items editable table table-bordered">
								        <thead class="panel-heading">
								     			<th></th>
									            <th class='required'>FieldName</th>
									            <th>Description</th>
									            <th>type</th>
									            <th>widget</th>
									            <!-- <th>length</th>-->
									            <th>is Nullable?</th>
									            <th>required</th>
									  
									    </thead>
									     <tbody>
									    <?php $types=array('string' => 'string',
												            		'integer' => 'integer',
												            		'double' => 'double',
														            'time' => 'time',
														            'blob'=>'binary',
														             'image'=>'image',
														             'file'=>'file');
										      $types_filter=array();
										      $widgets_filter=array();
										      $fieldWidget;
										      
										      $nulls=['0'=>'No','1'=>'Yes'];
										      $null_filter=array();
										      
										      $requireds=['0'=>'No','1'=>'Yes'];
										      $required_filter=array();
										      
										 ?>
										 
										  
									     @if($node=Session::get('content_type_edit'))
								                @foreach($node['fields']  as $field)
									                @if($field['name']!='groovelDescription')
									                  <tr>
									                     <td class="col-sm-1"> <INPUT type="checkbox" name="chk[]"/></td>
		                        				            <td class="col-sm-4">
							      								{!! Form::text('fieldName[]', $field['name'], array('class'=>'form-control','placeholder' => 'fieldName')) !!}
												            </td>
												             <td class="col-sm-4">
																{!! Form::text('description[]', $field['description'], array('class'=>'form-control','placeholder' => 'description')) !!}
												            </td>
												            
												             <td class="col-sm-3" >
													            
													             @foreach($types as $type)
													                 @if($field['type']!=$type)
													                 	<?php $types_filter[$type]=$type;?>
													                 @endif
													             @endforeach
												                <select name="type_selected[]">
																	<option value=<?php echo $field['type']?>><?php echo $field['type']?></option>
																	@foreach($types_filter as $type)
																	<option value=<?php echo $type?>><?php echo $type?></option>
																	@endforeach
													     		</select>
													          </td>
													         @if($widgets= Session::get('widgets'))
													         	@if ($field['widget']=='')
																         $field['widget']='-1';
																@endif
																<?php $fieldWidget=$widgets[$field['widget']];?>
																<?php $keys=array_keys($widgets);?>
																@foreach($keys as $key)
													                 @if($fieldWidget!=$widgets[$key])
													                 	<?php $widget_filter[$key]=$widgets[$key];?>
													                 @endif
													             @endforeach
														     @endif
													         <td class="col-sm-4" >
												               <select name="widget_selected[]">
																	<option value=<?php echo $field['widget']?>><?php echo $widgets[$field['widget']]?></option>
																	<?php $keys=array_keys($widget_filter);?>
																	@foreach($keys as $key)
																	<option value=<?php echo $key?>><?php echo $widget_filter[$key]?></option>
																	@endforeach
													     		</select>
												            </td>
												      	    <td class="col-sm-4">
															     @foreach($nulls as $key=>$null)
													                 @if($field['isnullable']!=$key)
													                 	<?php $null_filter[$key]=$null;?>
													                 @endif
													             @endforeach
												                <select name="isnullable[]">
																	<option value=<?php echo $field['isnullable']?>><?php echo $nulls[$field['isnullable']]?></option>
																	@foreach($null_filter as $key=>$null)
																	<option value=<?php echo $key?>><?php echo $null?></option>
																	@endforeach
													     		</select>
													            </td>
													            
													             <td class="col-sm-4">
																 @foreach($requireds as $key=>$required)
													                 @if($field['required']!=$key)
													                 	<?php $required_filter[$key]=$required;?>
													                 @endif
													             @endforeach
												                <select name="required[]">
																	<option value=<?php echo $field['required']?>><?php echo $requireds[$field['required']]?></option>
																	@foreach($required_filter as $key=>$required)
																	<option value=<?php echo $key?>><?php echo $required?></option>
																	@endforeach
													     		</select>
													            </td>
													            <?php $null_filter=null?>
													            <?php $required_filter=null?>
													             <?php $widget_filter=null?>
													             <?php $types_filter=null?>
							            					 {!! Form::hidden('field_id[]', $field['id'], array('field_id' => 'field_id')) !!}
					  
									                
											           </tr>
											           @endif
									             @endforeach
									     @endif
									      </tbody>
									  </table>
							   </div>
				     	</div>
						 <!-- <div class="span3">
								<div class="col-md-12">
										{!! Form::submit('Save',array('class'=>'btn btn-default'))!!}
					 			</div>
							</div>
							{!! Form::close() !!}	-->
						</div>
						 <div class="modal-footer">
						   	<p class='required' style='font-size:15px;margin-right:80%'>Fields are required</p>
			       			 <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
			       			 <input type="submit" id="submitForm" value="Save Changes"  class="btn btn-default"/>
			        	 </div>
			         
			       {!! Form::close() !!}
			    </div>
			</div>
		</div>
	</div>
</div>
<script>
$("#submitForm").click(function (event) {
	form=$('#content_type_form').serialize();
	$.post('/admin/content_type/update', form, function (data, textStatus) {
		var parsed = JSON.parse(data);
		if(parsed['success']){
			window.scrollTo(0,0);
	        document.getElementById('light').style.display='block';
	        document.getElementById('light').className='alert alert-success fade in';
	        document.getElementById('light').innerHTML ='content type has been updated successfully';
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
	
});

$(document).ready(function() {
	 $('#modal').modal('show');
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
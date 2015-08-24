@extends('cmsgroovel::layouts.groovel_admin_default')
@section('content')

<div class="col-md-12" style="margin-top:15px">
	<div id='modal' class="modal fade" style="display: none;" data-keyboard="false" data-backdrop="static">
		  <div class="modal-dialog">
		  	<div class="modal-content">
			 	<div class="modal-header" style='background-color: #00FF40'>
			 	  <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			      <h4 class="modal-title">Board Content Types</h4>
			    </div>
				 @if($errors->has()|| Session::get('messages'))
									<div class="span3">
										<div class="col-md-12 col-md-offset-2">
										 
									           @foreach ($errors->all() as $error)
									              <div style="color:#FF0000;">{{ $error }}</div>
									          @endforeach
									     
									       @if(Session::get('messages'))
									             <div>{{var_dump(Session::get('messages'))}}</div>
									        @endif
									    </div>
									</div>
				@endif
			   <div id='light'></div>
				<div id='fade'></div>
		
			     <div id='form-modal' class="modal-body">
			     <div class="panel-body">
				{{Form::open(array('id'=>'content_type_form','url' => 'admin/content_type/add', 'method' => 'post'))}}
					<div class="span3">
						<div class="col-md-12 form-inline">
							{{ Form::label('Title', 'Title', array('class'=>'required','style'=>'margin-right:50px')).Form::text('title', Input::old('title'), array('class'=>'form-control','style'=>'width:450px','placeholder' => 'title')) }}
						</div>
					</div>
					<div class="span3">
						<div class="col-md-10">
							<INPUT type="button" value="Add Fields" onclick="addRow('dataTable')" />
						 
						    <INPUT type="button" value="Delete Fields" onclick="deleteRow('dataTable')" />
						 
						    <table id="dataTable" class="line-items editable table table-bordered">
						        <thead class="panel-heading">
							        	<th></th>
							            <th class='required'>FieldName</th>
							            <th>Description</th>
							            <th>type</th>
							            <th>widget</th>
							            <th>is Nullable?</th>
							            <th>required</th>
							    </thead>
							 
						        <tr>
				          	        <td class="col-sm-1"><INPUT type="checkbox" name="chk[]"/></td>
						            <td class="col-sm-4">
	      								{{ Form::text('fieldName[]', Input::old('fieldName[]'), array('class'=>'form-control','placeholder' => 'fieldName')) }}
						            </td>
						            <td class="col-sm-4">
										{{ Form::text('description[]', Input::old('description[]'), array('class'=>'form-control','placeholder' => 'description')) }}
						            </td>
						            <td class="col-sm-3">
						            {{Form::select('type[]',
								        array('string' => 'String',
								            'integer' => 'Integer',
								            'double' => 'Double',
								            'time' => 'Time',
								            'blob'=>'Binary',
								             'image'=>'Image',
								             'File'=>'File'
								            )
								        );
							    	}}
						            </td>
						              <td class="col-sm-3">
						            {{Form::select('widget[]',Session::get('widgets'));}}
						            </td>
						          <!--     <td class="col-sm-3">
										{{ Form::text('size[]', Input::old('size[]'), array('class'=>'form-control','placeholder' => 'size')) }}
							
						             </td>-->
						            <td class="col-sm-4">
										{{ Form::select('isnullable[]',['0'=>'No','1'=>'Yes']) }}
						            </td>
						            
						             <td class="col-sm-4">
										{{ Form::select('required[]',['0'=>'No','1'=>'Yes']) }}
						            </td>
								          
						        </tr>
						    </table>
						</div>
					</div>
				
	        	  </div><!-- panel body -->
	        	  	<p class='required' style='font-size:15px'>Fields are required</p>
	        	   <div class="modal-footer">
	        			 <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
		       			  <input type="submit" id="submitForm" value="Save Changes"  class="btn btn-default"/>
		           </div>
	        	 {{ Form::close() }}
	        	 
	        	 </div><!-- form modal -->
	 		</div><!-- modal content -->
		 </div><!-- modal diag -->
	</div><!-- modal -->
</div><!-- col -->
<script>
$("#submitForm").click(function (event) {
	form=$('#content_type_form').serialize();
	$.post('/admin/content_type/add', form, function (data, textStatus) {
		var parsed = JSON.parse(data);
		if(parsed['success']){
            window.scrollTo(0,0);
	        document.getElementById('light').style.display='block';
	        document.getElementById('light').className='alert alert-success fade in';
	        document.getElementById('light').innerHTML ='content_type has been added successfully';
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
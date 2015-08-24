@extends('cmsgroovel::layouts.groovel_admin_editor')
@section('content')




   

	<div class="span3">
		<div class="col-md-12 col-md-offset-2" style='margin-top: 50px'>
			 <table id="dataTable" class="line-items editable table table-bordered">
						        <thead class="panel-heading">
							            <th>Choose your content type</th>
							           
							    </thead>
			    <tr>
					 <td class="col-sm-3">
						{{ Form::select('content_types',Session::get('content_types'),'default', array('id'=> 'a','onchange'=>'showContentType(this.value,"http://"+window.location.hostname+"/admin/content/form/view_update");clearFileOldList()')) }}
					</td>
				</tr>
			</table>
		</div>
	</div>
	
    @include('cmsgroovel::sections.loadingwindow')
    <div id='modal' class="modal fade" style="display: none;overflow:scroll" data-keyboard="false" data-backdrop="static">
	  <div class="modal-dialog">
	  	<div class="modal-content">
		 	<div class="modal-header" style='background-color: #00FF40'>
		 	  <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		      <h4 class="modal-title">New content</h4>
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
			 <input id='token' type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
		     <div id='form-modal' class="modal-body">
				<form id="content_form" role="form">	
				</form>
			 </div>
			 <div class="modal-footer">
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
	
	$(document).ready(function() {
		//console.log("ready");
		fileEvents();
		//$("#loading").hide();
		$("#pleaseWaitDiv").modal('hide');
		var divSuccess = document.getElementById('success_message');
		var divError = document.getElementById('error_message');
		if(divSuccess!=null){
			divSuccess.innerHTML =null;
			}
		if(divError!=null){
			divError.innerHTML =null;
		    }
	});

$("#submitForm").click(function (event) {
	getFileOldList();
 	if(tinymce!=null){
 	 	//force to get filed value by tinymce
 		tinymce.triggerSave();
 	}
	var status=true;
	var form=$('#content_form').serialize();
	//console.log(form);
	if(document.getElementById('my-file')!=null){
		document.getElementById('my-file').value='';
		//console.log(storedFiles);
		//console.log(filesAlreadyStored);
		status=validateFiles(storedFiles,filesAlreadyStored);
	}
   // console.log(status);
   
 	if(status){
		// $("#loading").show();
	     var ajaxData = new FormData();
			    for(i=0;i<storedFiles.length;i++){
				    var xhr = new XMLHttpRequest();
				    ajaxData.append("file", storedFiles[i]);
				    xhr.onreadystatechange = function () {
					  	response = this.responseText;
					  	if(response!=""){
			     	  	var url = JSON.parse(response);
			     	  	console.log(url);
			    		if(url['success']){
			    		  	urlimg[storedFiles[i]['name']]=url.datas[storedFiles[i]['name']];
						 // console.log(url.datas);
						 //	console.log(urlimg);
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
			              else if(url['success']==false){
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
					  }
				  	}
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
        document.getElementById('content_form').appendChild( document.getElementById('token'));
        
		form=$('#content_form').serialize();
		$.post('/admin/content/add', form, function (data, textStatus) {
			urlimg={};
			if(textStatus=='success'){

				//console.log(data);
				if(data!=null){
					  var parsed = JSON.parse(data);
	                   if(parsed['success']){
	                        window.scrollTo(0,0);
					        document.getElementById('light').style.display='block';
					        document.getElementById('light').className='alert alert-success fade in';
					        document.getElementById('light').innerHTML ='content has been added successfully';
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
				}else{
					if(tinymce!=null){
			            	tinymce.remove();
					}
					alert('data problems');
				}
			}else{
				if(tinymce!=null){
		            	tinymce.remove();
				}
				alert('something mistake...problems');
			}
			
		 });
		 $("#loading").hide();
 		return false;
	}else{
		 $("#loading").hide();
			
	 return false;	
	}
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

 <div id='modal_contact' class="modal fade"   tabindex='-1'> 
				  <div class="modal-dialog">
				   	<div class="modal-content">
				   	 	<div class="modal-header">
					 	  <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					      <h4 class="modal-title">Contact Form </h4>
					    </div>
					    <div id='light'></div>
						<div id='fade'></div>
				  	<form id='contact_form' class="form-horizontal well" role="form" method="POST" action="{{ url('contact/post') }}">
				 	     <div id='form-modal' class="modal-body">
					  			{{csrf_field()}}	
						 	 	<input style='display:none;' type='text' id='ctrl1' name='ctrl1' value='spamcontroller'>
							 	<input style='display:none;' type='text' id='ctrl2' name='ctrl2' value=''>
				             	<input type='hidden' name='leave_blank'/>
								
								<div class="form-group form-inline">
					                <label class="col-md-2 control-label required" style='margin-right:10px'>username:</label>
					                <div class="col-md-8">
					                    <input type='text' name='username' class="form-control" style='width:100%'/>
					                </div>
	            				</div>
	            				<div class="form-group form-inline">
					                <label class="col-md-2 control-label required" style='margin-right:10px'>email:</label>
					                <div class="col-md-8">
					                    <input type='email' name='email' class="form-control" style='width:100%'/>
					                </div>
	            				</div>
	            				<div class="form-group form-inline">
					                <label class="col-md-2 control-label required" style='margin-right:10px'>subject:</label>
					                <div class="col-md-8">
					                    <input type='text' name='subject' class="form-control" style='width:100%'/>
					                </div>
	            				</div>
	            				<div class="form-group form-inline">
					                <label class="col-md-2 control-label required" style='margin-right:10px'>message:</label>
					                <div class="col-md-9">
					                    <textarea name='message' class="form-control" style='width:100%' rows='10' cols='40'></textarea>
					                </div>
	            				</div>
														   
					     </div>
					      <div class="modal-footer">
					        <div class="row">
					          <div class="col-md-4">
							     <p class='required' style='font-size:15px;margin-right:10%'>Fields are required</p>
							   </div>
							   <div class="col-md-2 col-md-offset-4">
				       			 <input type="submit" id="submitForm" value="Send"  class="btn btn-default"/>
				       			</div>
				       			<div class="col-md-2">
				       			 <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				       		   </div>
			       			</div>
			        	 </div>
			        	 </form>
					</div>
				</div>
</div>
<script>
$("#submitForm").click(function (event) {
	
	var form=$('#contact_form').serialize();
	$.post('/contact/post', form, function (data, textStatus) {
			var parsed = JSON.parse(data);
			if(parsed['success']){
		           window.scrollTo(0,0);
			        document.getElementById('light').style.display='block';
			        document.getElementById('light').className='alert alert-success fade in';
			        document.getElementById('light').innerHTML ='message sent';
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
		  			button.style='margin-left:90px;margin-top:50px;width:100px;height:40px';
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



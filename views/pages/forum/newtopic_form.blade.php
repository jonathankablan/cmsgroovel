   <div id='modal_forum' class="modal fade"  data-keyboard="false" data-backdrop="static">
				  <div class="modal-dialog">
				   	<div class="modal-content">
				   	 	<div class="modal-header">
					 	  <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					      <h4 class="modal-title">New topic </h4>
					    </div>
					    <div id='light_forum'></div>
						<div id='fade_forum'></div>
					     <div id='form-modal' class="modal-body">
					    	{!! Form::open(array('id'=>'topic_form','url' => 'forum/topic/post', 'method' => 'POST', 'class' => 'form-horizontal well ')) !!}
						 	  <input style='display:none;' type='text' id='ctrl1' name='ctrl1' value='spamcontroller'>
							 <input style='display:none;' type='text' id='ctrl2' name='ctrl2' value=''>
				             <input type='hidden' name='leave_blank'/>
				              <input type='hidden' name='forum_id' value={!!$forumid!!}/>
							
								<div class="form-group form-inline">
								  {!! Form::label('subject', 'subject',array('class'=>'required','style'=>'margin-right:65px')).Form::text('subject', Input::old('subject'), array('class'=>'form-control','style'=>'width:450px')) !!}
				         		</div>
								<div class="form-group form-inline">
								 {!! Form::label('message', 'message',array('class'=>'required','style'=>'margin-right:55px')).Form::textarea('message', Input::old('message'), array('class'=>'form-control','style'=>'width:450px')) !!}
								</div>
														   
					     </div>
					      <div class="modal-footer">
						     <p class='required' style='font-size:15px;margin-right:80%'>Fields are required</p>
			       		
			       			 <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
			       			 <input type="submit" id="submitFormTopic" value="Send"  class="btn btn-default"/>
			        	 </div>
			        	   {!! Form::close() !!}
					</div>
				</div>
</div>
<script>
$("#submitFormTopic").click(function (event) {
	var form=$('#topic_form').serialize();
	$.post('/forum/topic/post', form, function (data, textStatus) {
			var parsed = JSON.parse(data);
			if(parsed['success']){
		           window.scrollTo(0,0);
			        document.getElementById('light_forum').style.display='block';
			        document.getElementById('light_forum').style.zIndex='1002';
			        document.getElementById('modal_forum').style.zIndex='1';
			        document.getElementById('light_forum').className='alert alert-success fade_forum in';
			        document.getElementById('light_forum').innerHTML ='message sent';
			        document.getElementById('fade_forum').style.display='block';  
			        a=document.createElement('a');
					a.className='closer';
					a.href='#';
					a.innerHTML='x';
					a.onclick = function(e) {  
						document.getElementById('light_forum').style.display='none';
						document.getElementById('fade_forum').style.display='none';
					    return false;
					};
					document.getElementById('light_forum').appendChild(a);
					button=document.createElement('button');
		  			button.innerHTML='OK';
		  			button.style='margin-left:90px;margin-top:100px;width:100px;height:40px';
		  			button.onclick = function(e) {  
		  				document.getElementById('light_forum').style.display='none';
		  				document.getElementById('fade_forum').style.display='none';
		  			    return false;
		  			};
		  			div=document.createElement('div');
		  			div.id='mess';
		  			document.getElementById('light_forum').appendChild(div);
		  			document.getElementById('mess').appendChild(button);
	         }
	          else if(parsed['success']==false){
	        	  window.scrollTo(0,0);
			        document.getElementById('light_forum').style.display='block';
			        document.getElementById('light_forum').className='alert alert-danger fade_forum in';
			        document.getElementById('light_forum').innerHTML =  parsed['errors']['reason'];
			        document.getElementById('fade_forum').style.display='block';  
			        a=document.createElement('a');
					a.className='closer';
					a.href='#';
					a.innerHTML='x';
					a.onclick = function(e) {  
					document.getElementById('light_forum').style.display='none';
					document.getElementById('fade_forum').style.display='none';
					    return false;
					};
					document.getElementById('light_forum').appendChild(a);
					button=document.createElement('button');
		  			button.innerHTML='OK';
		  			button.style='margin-left:90px;margin-top:50px;width:100px;height:40px';
		  			button.onclick = function(e) {  
		  				document.getElementById('light_forum').style.display='none';
		  				document.getElementById('fade_forum').style.display='none';
		  			    return false;
		  			};
		  			div=document.createElement('div');
		  			div.id='mess';
		  			document.getElementById('light_forum').appendChild(div);
		  			document.getElementById('mess').appendChild(button);
	         }
		 });
		return false;
	
	}); 
</script>

<style>

#fade_forum{
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
#light_forum{
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



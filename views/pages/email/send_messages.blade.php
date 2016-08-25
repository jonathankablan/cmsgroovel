	 <div class="col-sm-4">
        
        
        <div id='modal' class="modal fade" style="display: none" data-keyboard="false" data-backdrop="static">
				  <div class="modal-dialog" style="width: 90%">
				  	<div class="modal-content">
					 	<div class="modal-header" style='background-color:#E5E4E2'>
					 	 <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					      <h4 class="modal-title">Compose Message</h4>
					    </div>
					     @if($errors->has())
					           @foreach ($errors->all() as $error)
					              <div style="color:#FF0000;">{!! $error !!}</div>
					          @endforeach
				        @endif
				       @if(Session::get('messages'))
				             <div>{!!var_dump(Session::get('messages'))!!}</div>
				        @endif
				       <div id='light'></div>
						<div id='fade'></div>
						<form method="POST" action="{{ url('messages/send') }}" accept-charset="UTF-8" id="message_form">
					
			       		<div id='form-modal' class="modal-body" style='height:400px' >
						<!--  form email-->
						{{csrf_field()}}
					
							   <div class="form-group form-inline">
				                @if(Session::get('reply_subject')!=null)
					               	 <label for="subject" class="required" style="margin-right:40px">Subject</label>
					               	 <input class="form-control" style="width:52%" placeholder="your subject" name="subject" type="text" id="subject" value={{Session::get('reply_subject')}}>
				               @endif
				                @if(Session::get('reply_subject')==null)
				           	       	 <label for="subject" class="required" style="margin-right:40px">Subject</label>
					               	 <input class="form-control" style="width:52%" placeholder="your subject" name="subject" type="text" id="subject">
				                @endif
				              </div>
				                <div class="form-group form-inline">
					           	   <div id="search_user_form" action='/admin/search/execute' method='post'>
								        <input id='token' type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
								        <div class="input-group col-md-7">
							               	<label for="recipient" class="required" style="margin-right:10px">To</label>
					                        <div class="input-group-btn">
					                         @if(Session::get('reply_user')!=null)
								              <input class="form-control" style="width:100%" placeholder="pseudo" name="recipient" type="text" id="recipient"  value={{Session::get('reply_user')}}> 
								             @else
								                <input class="form-control" style="width:100%" placeholder="pseudo" name="recipient" type="text" id="recipient">
								             @endif
								              <button id="search_term" name="search_term" class="btn btn-default" ><i class="glyphicon glyphicon-search"></i></button>
								            </div>
							             </div>
										<div id='search-modal' class="modal fade" data-target="search-modal" style="display: none" data-keyboard="true"  data-toggle="modal" data-dismiss="modal" >		     
									     	<div id="searchlist" class="modal-body" style='height:400px;margin-top:11%;width:40%;margin-left:20%'>
											</div>
										</div>
								</div>
				              </div>
				               <div class="form-group form-inline">
				               	<label for="body" style="margin-right:70px">Message</label>
				              	<textarea class="form-control" style="width:100%" placeholder="write here your message" name="body" cols="50" rows="10" id="body"></textarea>
				              </div>
				            </div>
						 <div class="modal-footer">
						     <p class='required' style='font-size:15px'>Fields are required</p>
			       		
			       			 <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
			       			 <input type="submit" id="submitForm" value="Send"  class="btn btn-default" data-dismiss="modal"/>
			        	 </div>
			        	</form>
					</div>
				  </div>
		</div>
          
  
 	</div>
<script type="text/javascript">
$(document).ready(function() { 
	



	$('#search_user_form').on('show.bs.modal', function() {
	});
	
	$('#search_user_form').on('hide.bs.modal', function() {
		 $('#searchlist .list-group-item').remove();
	}); 

	$("#search_term").click(function (event) {
	     form=$(this).serializeArray();
		 $.post('/search/users', {recipient:$('#recipient').val()}, function (data, textStatus) {
			var parsed = JSON.parse(data);
			console.log(parsed);
			users=parsed["users"];
			for(var i= 0; i < users.length; i++)
			{
				$("#searchlist").append(
					 $('<a>').attr('href','#').attr('class','list-group-item').append(
					    $('<span>').append(users[i].pseudo)
					 )
				);
			}
            if(users.length>0){
				$('#searchlist .list-group-item').each(function(event){
			          $(this).click(function (event) {
							 $('#search-modal').modal('hide');
							 $('#searchlist .list-group-item').remove();
							// console.log($(this).text());
							 $('#recipient').val($(this).text());
							 event.stopPropagation();
							
				        });
	
				   });


				 $('#search-modal').modal('show');

				 $('#searchlist .list-group-item').each(function(event){
		          $(this).click(function (event) {
						 $('#search-modal').modal('hide');
						 event.stopPropagation();
						
			        });

			   });
            }


		})
		
  }); 
			 
});


$("#search_user_form").click(function (event) {
	  
	return false;
});



$("#submitForm").click(function (event) {
	form=$('#message_form').serialize();
	$.post('/messages/send', form, function (data, textStatus) {
		var parsed = JSON.parse(data);
		if(parsed['success']){
            window.scrollTo(0,0);
	        document.getElementById('light').style.display='block';
	        document.getElementById('light').className='alert alert-success fade in';
	        document.getElementById('light').innerHTML ='Message has been sent';
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


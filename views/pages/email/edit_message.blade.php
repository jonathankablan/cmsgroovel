@extends('cmsgroovel.layouts.groovel_admin_default')
@section('content')

 <div class="col-sm-4  col-xs-12 col-lg-5">
        <div id='light' style='margin-left: 500px;margin-top:100px'></div>
		<div id='fade'></div>
        
        <div id='modal' class="modal fade" style="display: none" data-keyboard="true" data-backdrop="static" tabindex='-1'>
				  <div class="modal-dialog" style="width: 90%">
				  	<div class="modal-content">
					 	<div class="modal-header" style='background-color: #E5E4E2'>
					 	 <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					      <h4 class="modal-title">Message</h4>
					    </div>
					     @if($errors->has())
					           @foreach ($errors->all() as $error)
					              <div style="color:#FF0000;">{!! $error !!}</div>
					          @endforeach
				        @endif
				       @if(Session::get('messages'))
				             <div>{!!var_dump(Session::get('messages'))!!}</div>
				        @endif
				       <form method="POST" action="url('/messages/reply')" accept-charset="UTF-8" id="message_form">
						{{csrf_field()}}
			       		<div id='form-modal' class="modal-body">
						<!--  form email-->
						    <input id="id" name="message_id" type="hidden">
						
							   <div class="form-group form-inline">
				                 <label for="subject" style="margin-right:65px">Subject</label>
				                 <input class="form-control" style="width:100%" placeholder="subject" readonly="readonly" name="subject" type="text" id="subject" value={{Session::get('message')['subject']}}>
				            
				              </div>
				               <div class="form-group form-inline">
				             	<label for="author" style="margin-right:85px">from</label>
				             	<input class="form-control" style="width:100%" placeholder="author" readonly="readonly" name="author" type="text" id="author" value={{Session::get('message')['author']}}>
				              
				              </div>
				               <div class="form-group form-inline">
					               <label for="body" style="margin-right:60px">Message</label>
					               <textarea class="form-control" style="width:100%;heigth:100%" placeholder="message" name="body" cols="50" rows="10" id="body">{{Session::get('message')['body']}}</textarea>
				              </div>
				            </div>
						 <div class="modal-footer">
						    <div class="row">
						    <button type="button" class="btn btn-default" onclick='deleteMessage()' data-dismiss="modal">Delete</button>
			       			 <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
			       			 <input type="submit" id="submitForm" value="Reply"  class="btn btn-default" data-dismiss="modal"/>
			       			 </div>
			        	 </div>
			        	</form>
					</div>
				  </div>
		</div>
          
  
 	</div>

<script type="text/javascript">
$(document).ready(function() { 
	 $('#modal').modal('show');
});

function deleteMessage(){
    inputData=document.getElementById('id');
    args=new Array();
    args['id']=inputData.value;
 	   $.ajax({
           type: 'get',
           data : any2url('q',args),
           url: "/messages/delete",
            success: function(data) {
            	window.scrollTo(0,0);
      	        document.getElementById('light').style.display='block';
      	        document.getElementById('light').className='alert alert-success fade in';
      	        document.getElementById('light').innerHTML ='Message deleted';
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
      			
      			
           },
           error: function(xhr, textStatus, thrownError) {
              alert(thrownError);
               alert('Something went to wrong.Please Try again later...');
           }
          
       });
	return false;
}


$("#submitForm").click(function (event) {
	form=$('#message_form').serialize();
	$.post('/messages/reply', form, function (data, textStatus) {
		var parsed = JSON.parse(data);
		 window.location.href = parsed.datas.uri;
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
 @stop
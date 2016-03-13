@extends('cmsgroovel.layouts.groovel_admin_default')
@section('content')

 <div class="col-sm-4">
        <div id='light' style='margin-left: 500px;margin-top:100px'></div>
		<div id='fade'></div>
        
        <div id='modal' class="modal fade" style="display: none" data-keyboard="true" data-backdrop="static" tabindex='-1'>
				  <div class="modal-dialog">
				  	<div class="modal-content" style='width:700px;height:600px'>
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
				       
			       		<div id='form-modal' class="modal-body" style='height:400px' >
						<!--  form email-->
						  {!! Form::hidden('message_id', Session::get('message')['id'], array('id' => 'id')) !!}
						{!!Form::open(array('id'=>'message_form','url' => 'messages/reply', 'method' => 'post'))!!}
							   <div class="form-group form-inline">
				                {!! Form::label('subject', 'Subject',array('style'=>'margin-right:65px')).Form::text('subject',Session::get('message')['subject'], array('class'=>'form-control','style'=>'width:450px','placeholder' => 'subject','readonly')) !!}
				              </div>
				               <div class="form-group form-inline">
				                {!! Form::label('author', 'from',array('style'=>'margin-right:85px')).Form::text('author', Session::get('message')['author'], array('class'=>'form-control','style'=>'width:450px','placeholder' => 'author','readonly')) !!}
				              </div>
				               <div class="form-group form-inline">
				                {!! Form::label('body', 'Message',array('style'=>'margin-right:60px')).Form::textarea('body', Session::get('message')['body'], array('class'=>'form-control','style'=>'width:450px;heigth:100px','placeholder' => 'message')) !!}
				              </div>
				            </div>
						 <div class="modal-footer">
						    <button type="button" class="btn btn-default" onclick='deleteMessage()' data-dismiss="modal">Delete</button>
			       			 <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
			       			 <input type="submit" id="submitForm" value="Reply"  class="btn btn-default" data-dismiss="modal"/>
			        	 </div>
			        	  {!! Form::close() !!}
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
	    <div class="row">
		    <div id='light_forum'></div>
			<div id='fade_forum'></div>
		   <div id='dialog'>
		       @include('cmsgroovel.pages.forum.newtopic_form')
		   </div>
	   </div>
   		<div class="row" id="forum" style='margin-top:50px'>
   		  <div class="row">
   		   <div class="col-md-11 col-md-offset-2">
   		  		<h1 class="page-header">Welcome to Forum {!!$forumName!!}</h1> 
   		  	</div>
   		  </div>
          <div class="row" style='margin-bottom:20px'>
          	<div class="col-md-1 col-md-offset-1">
	     	  @if(\Auth::user()!=null)
		  		<a onclick='showModalPopUp()' class='btn btn-default'>Post a new topic</a>
	   		  @else
		  		<a onclick='pleaseConnect()' class='btn btn-default'>Post a new topic</a>
			  @endif
			  </div>
	      </div>
   	               <div class="col-md-10" style='margin-left:50px'>
	                           	 <table class="table table-hover table-bordered"  id="table_topics" style='background:#F2F2F2'>
				                      <thead style='background:#D8D8D8'>
				                        <tr>
				                         <th id="col_topic" class="col-md-1" style='border:1px solid black;'>id</th>
				                          <th id="col_topic" class="col-md-8" style='border:1px solid black;'>Topics</th>
				                          <th id="col_topic" class="col-md-1" style='border:1px solid black;'>replies</th>
				                          <th id="col_topic" class="col-md-4" style='border:1px solid black;'>lastPost</th>
				                        </tr>
				                      </thead>
				                      <tbody  class="list">
				                       @foreach ($topics as $topic)
				                          <tr id="rows_topics">
				                            <td id="row_topic" class="col-md-1"  style='border:1px solid black;' >{!!$topic['topic_id']!!}</td>
				                            <td id="row_topic" class="col-md-3" style='border:1px solid black;' >
				                            {!! HTML::link('/forum/topic/?'.'id='.$topic['topic_id'].'&forumid='.$forumid, $topic['topic'],array('class'=>'forumlink'))!!}</td>
				                             <td id="row_topic" class="col-md-1" style='background:#D8D8D8;border:0.2px solid black;' >{!!$topic['number_answers']!!}</td>
				                            <td id="row_topic" class="col-md-1" style='background:#D8D8D8;border:1px solid black;' >{!!$topic['lastanswer']['pseudo']!!} {!!$topic['lastanswer']['created_at']!!}</td>
				                             @if(Session::get('user_privileges')['role']=='ADMIN')
				                             <td id="del" style='border:1px solid black;' >
				                            {!! HTML::image('groovel/cmsgroovel/groovel/admin/images/del.png', $alt="del", $attributes = array('id' => 'deleteButton','style'=>'width:20px;height:20px','class'=>'btnDeleteTopic')) !!}
				                            </td>
				                            @endif
				                            </tr>
				                          @endforeach
				                        </tbody>
				                    </table>
				    </div>
        </div>    
 
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
 <script>
 
$(document).ready(function() {
	var bcgDiv = document.getElementById("dialog");
	bcgDiv.style.display="none";
});
                  
function showModalPopUp(){
	 var bcgDiv = document.getElementById("dialog");
     bcgDiv.style.display="block";
     $('#modal_forum').modal('show');
}

function pleaseConnect(){
	//alert('Please connect or registerss');
	 window.scrollTo(0,0);
	 //console.log(document.getElementById('light_forum'));
     document.getElementById('light_forum').style.display='block';
     document.getElementById('light_forum').className='alert alert-danger fade_forum in';
     document.getElementById('light_forum').innerHTML =  'Please connect or Register to have an account';
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
    
 </script>             

@stop
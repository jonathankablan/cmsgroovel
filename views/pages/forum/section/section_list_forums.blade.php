       	@if(Session::get('messages'))
             <div>{!!var_dump(Session::get('messages'))!!}</div>
        @endif
       
         <div class="row" style="margin-bottom:50px">
	           @if(Session::get('user_privileges')['role']=='ADMIN') 
	              <div class="col-md-1" style='margin-top:30px'> 
	             {!! HTML::link('/admin/forum/form', 'Create Forum',array('class' => 'btn btn-default'))!!}
	             </div>
	            @endif
         </div>
         <div class="row" class="table-responsive scrollable" >
	         <div class="col-md-12">
	                       	 <table class="table table-striped table-hover table-bordered"  id="table_forums" style='background:#F2F2F2'>
					                      <thead style='background:#D8D8D8'>
					                        <tr>
					                          <th id="col_forum" class="col-md-1 thead" style='border:1px solid black' >id</th>
					                          <th id="col_forum" class="col-md-1 thead" style='border:1px solid black' >name</th>
					                           <th id="col_forum" class="col-md-1 thead" style='border:1px solid black' >description</th>
					                           <th id="col_forum" class="col-md-1 thead" style='border:1px solid black' >subjects</th>
					                           <th id="col_forum" class="col-md-1 thead" style='border:1px solid black' >messages</th>
					                           <th id="col_forum" class="col-md-1 thead" style='border:1px solid black' >last messages</th>
					                            @if(Session::get('user_privileges')['role']=='ADMIN')
					                           <th id="col_forum" class="col-md-1" style='border:1px solid black'></th>
					                           @endif
					                        </tr>
					                      </thead>
					                      <tbody  class="list">
					                      @if(!empty($forums))
					                       @foreach ($forums as $forum)
					                          <tr id="rows_forums">
					                            <td id="row_forum" class="col-md-1"  style='border:1px solid black;' >{!!$forum['forum_id']!!}</td>
					                            <td id="row_forum" class="col-md-1" style='border:1px solid black;' >
					                             @if(!isset($view))
					                            {!! HTML::link('/forum/?forumName='.$forum['forum_name'].'&id='.$forum['forum_id'], $forum['forum_name'],array('class'=>'forumlink'))!!}</td>
					                            @endif
					                            @if(isset($view))
					                             {!! HTML::link('/forum/?forumName='.$forum['forum_name'].'&id='.$forum['forum_id'].'&view='.$view, $forum['forum_name'],array('class'=>'forumlink'))!!}</td>
					                            @endif
					                            <td id="row_forum" class="col-md-1" style='border:1px solid black;' >{!!$forum['forum_description']!!}</td> 
					                            <td id="row_forum" class="col-md-1" style='background:#D8D8D8;border:0.2px solid black;' >{!!$forum['subjects']!!}</td>
					                            <td id="row_forum" class="col-md-1" style='background:#D8D8D8;border:1px solid black;' >{!!$forum['messages']!!}</td>
					                            <td id="row_forum" class="col-md-1" style='background:#D8D8D8;border:1px solid black;' >{!!$forum['lastMessage']['pseudo']!!} {!!$forum['lastMessage']['created_at']!!} </td>
					                             @if(Session::get('user_privileges')['role']=='ADMIN')
					                             <td id="del" class="col-md-1" style='border:1px solid black;' >
					                            {!! HTML::image('groovel/cmsgroovel/groovel/admin/images/del.png', $alt="del", $attributes = array('id' => 'deleteButton','style'=>'width:20px;height:20px','class'=>'btnDeleteForum')) !!}
					                            </td>
					                            @endif
					                            </tr>
					                          @endforeach
					                          @endif
					                        </tbody>
					                    </table>
	        		</div>    
     		</div>
 
 <style>
.forumlink {
    color: #848484;
    text-decoration: none;
     font-size: 17px;
}

.thead {
    color: black;
    text-decoration: none;
    font-weight: bold;
    font-size: 12px;
}
 </style>                

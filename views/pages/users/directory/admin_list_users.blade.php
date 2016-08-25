@extends('cmsgroovel.layouts.groovel_admin_users')
@section('content')
@include('cmsgroovel.pages.email.send_messages')


	 <div style="margin-top:70px">
	   	@if(Session::get('messages'))
             <div>{!!var_dump(Session::get('messages'))!!}</div>
        @endif
       
            <div id="users">
	               <div class="row">
	                    <div class="panel panel-default">
	                        <div class="panel-heading">
	                            <h3 class="panel-title"><i class="fa fa-bar-chart-o"></i> Users</h3>
	                        </div>
	                        <div class="panel-body col-xs-7 col-sm-10 col-md-10">
	                          <div style='margin-bottom: 10px' >
		                         	 <div class="col-md-2 col-sm-3 col-xs-2  hidden-xs"> 
			                        	<input class="search" placeholder="Search" style="height:30px" />
			                        </div>
			                        <div class="col-md-4 col-md-offset-1 col-sm-4 col-sm-offset-1 hidden-xs hidden-sm"> 
								  		<button class="sort" data-sort="username" style="height:30px">
								    		Sort by username
								  		</button>
								  	</div>
						  		</div>
             			  	</div>
             			  	
	            				<table class="table table-hover table-striped table-bordered table-responsive"  id="table_users" style='background-color: #FFFFFF '>
										<thead>
							                 <tr>
						                          <th id="col_user" class="col-xs-1" style='display:none'>id</th>
						                          <th id="col_user" class="col-xs-1 col-sm-1">picture</th>
						                          <th id="col_user" class="col-xs-1 col-sm-1">pseudo</th>
						                          <th id="col_user" class="col-xs-1 col-sm-1">creation date</th>
						                 	</tr>
                        				</thead>
										<tbody aria-relevant="all" aria-live="polite" role="alert" class="list"><tr class="gradeA odd">
											 @foreach ($users as $user)
					                             <tr id="rows_users">
					                            <td id="row_user_id" class="col-md-1" style='display:none'>{!!$user->id!!}</td>
					                            <td id="row_user" class="col-md-1">  
					                             @if($user->picture!=null)
					                            	<img src="/{!!$user->picture!!}" style="width:100%;height:100%" alt="user picture">
											    @endif
					                            </td>
					                            <td id="row_user_pseudo" class="pseudo col-xs-1 col-sm-1">{!!$user->pseudo!!}</td>
					                            <td id="row_user" class="col-xs-1 col-sm-1">{!!$user->created_at!!}</td>
					                      
					                             <td id="view" class="col-md-1">
					                              <button id="sendMessage" class="btn btn-success btnSendUserMessage">Send Message</button>
					                              </td>
					                           </tr>
                         					 @endforeach
          								</tbody>
          							</table>
          							
          							  <ul class="pagination">
						                <ul class="pagination">
						                {!! $users->render() !!}
	               					 	</ul>
	               					 </ul>
	                          </div>
	               </div>
 				</div>
   
        </div>

        
<script>
 var options = {
  valueNames: [ 'pseudo']
};

var usersList = new List('users', options);

$(document).ready(function() { 
	 
	 $('.list #sendMessage').each(function(event){
        $(this).click(function (event) {
        	  $('#recipient').val($(this).parents().eq(1).find('#row_user_pseudo').text());
        	  $('#modal').modal('show');
	     });

	 });
	
})
 </script>     

@stop
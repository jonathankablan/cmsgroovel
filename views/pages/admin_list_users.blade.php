@extends('cmsgroovel.layouts.groovel_admin_users')
@section('content')
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
								  	<div class="col-md-2 col-md-offset-0 col-sm-3 col-xs-2  col-xs-offset-6">      
	           								 {!! HTML::link('/admin/user/form', 'Add new user',array('class' => 'btn btn-default'))!!}
	          						</div>
             			  		</div>
             			  	</div>
             			  	
	            				<table class="table table-hover table-striped table-bordered table-responsive"  id="table_users" style='background-color: #FFFFFF '>
										<thead>
							                 <tr>
						                          <th id="col_user" class="col-xs-1 col-sm-1 hidden-lg hidden-sm hidden-xs">id</th>
						                          <th id="col_user" class="col-xs-1 col-sm-1">picture</th>
						                          <th id="col_user" class="col-xs-1 col-sm-1 ">username</th>
						                          <th id="col_user" class="col-xs-1 col-sm-1 hidden-lg hidden-sm hidden-xs">pseudo</th>
						                          <th id="col_user" class="col-xs-1 col-sm-1 hidden-lg hidden-sm hidden-xs">email</th>
						                           <th id="col_user" class="col-xs-1 col-sm-1 hidden-lg hidden-sm hidden-xs">creation date</th>
						                          <th id="col_user" class="col-xs-1 col-sm-1 hidden-sm hidden-xs">last update</th>
						                          <th id="col_user" class="col-xs-1 col-sm-1 hidden-sm hidden-xs">activate</th>
						                 	</tr>
                        				</thead>
										<tbody aria-relevant="all" aria-live="polite" role="alert" class="list"><tr class="gradeA odd">
											 @foreach ($users as $user)
					                             <tr id="rows_users">
					                            <td id="row_user" class="col-md-1 hidden-lg hidden-sm hidden-xs">{!!$user->id!!}</td>
					                            <td id="row_user" class="col-md-1">  
					                             @if($user->picture!=null)
					                            {!!HTML::image( $user->picture,'',array('width'=>'100%','height'=>'100%'))!!}
					                            @endif
					                            </td>
					                            <td id="row_user" class="username col-xs-1 col-sm-1">{!!$user->username!!}</td>
					                            <td id="row_user" class="pseudo col-xs-1 col-sm-1 hidden-lg hidden-sm hidden-xs">{!!$user->pseudo!!}</td>
					                            <td id="row_user" class="col-xs-1 col-sm-1 hidden-lg hidden-sm hidden-xs">{!!$user->email!!}</td>
					                            <td id="row_user" class="col-xs-1 col-sm-1 hidden-lg hidden-sm hidden-xs">{!!$user->created_at!!}</td>
					                            <td id="row_user" class="col-xs-1 col-sm-1 col-lg-1 hidden-sm hidden-xs">{!!$user->updated_at!!}</td>
					                            <td id="row_user" class="col-xs-1 col-sm-1 col-lg-1 hidden-sm hidden-xs">{!!$user->activate!!}</td>
					             
					                            <td id="edit" class='col-sm-4 col-xs-1 col-lg-1'>
						                            	<span id='editButton' class="glyphicon glyphicon-pencil btnEditUser" aria-hidden="true"></span>
						                        </td>
					                            <td id="del" class="col-sm-4 col-lg-1 col-xs-1">
					                              	<span id='deleteButton' class="glyphicon glyphicon-trash btnDeleteUser" aria-hidden="true"></span>
					                             </td> 
					                             <td id="view" class="col-md-1">
					                              <button id="view" class="btn btn-success btnViewUser">View</button>
					                              </td>
					                               <td id="activate" class="col-md-1">
					                              <button id="activate" class="btn btn-success btnActivateUser hidden-xs">activate user</button>
					                              </td>
					                               <td id="notactivate" class="col-md-1">
					                              <button id="notactivate" class="btn btn-success btnNotActivateUser hidden-xs">block user</button>
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
  valueNames: [ 'username','pseudo']
};

var usersList = new List('users', options);
 </script>     

@stop
@extends('cmsgroovel.layouts.groovel_admin_roles_users')
@section('content')
      
             <div  id='roles' style='margin-top:70px'>
             	@if(Session::get('messages'))
             		<div>{!!var_dump(Session::get('messages'))!!}</div>
       			 @endif
       			 <div id='roles'>
	                <div class="row">
	                    <div class="panel panel-default">
	                        <div class="panel-heading">
	                            <h3 class="panel-title"><i class="fa fa-bar-chart-o"></i> Users Role</h3>
	                        </div>
	                     	<div class="panel-body col-xs-7 col-sm-10 col-md-10">
		                  	  		 <div class='row' style='margin-bottom: 10px' >
			                         	<div class="col-md-2 col-sm-2 col-xs-2  hidden-xs">  
				                        	<input class="search" placeholder="Search" style="height:30px" />
				                        </div>
				                        <div class="col-md-4 col-md-offset-1 col-sm-8 col-sm-offset-1 hidden-xs hidden-sm"> 
									  		<button class="sort" data-sort="name" style="height:30px">
									    		Sort by name
									  		</button>
									  	</div>
									  	<div class="col-md-2 col-md-offset-0 col-sm-4 col-xs-2  col-xs-offset-6">      
			            						{!! HTML::link('/admin/user/role/form', 'Add new user role',array('class' => 'btn btn-default'))!!}
			          					</div>
							  		</div>
						  	   </div>
								<table class="table table-hover table-striped table-bordered table-responsive" id="table_users">
										<thead>
										       <tr>
						                          <th id="col_user"  class="hidden-xs hidden-sm">id</th>
						                          <th id="col_user"  class="col-xs-1 col-sm-1">username</th>
						                          <th id="col_user"  class="col-xs-1 col-sm-1">pseudo</th>
						                          <th id="col_user"  class="col-xs-1 col-sm-1">role</th>
						                          <th id="col_user"  class="hidden-xs hidden-sm">creation date</th>
						                          <th id="col_user"  class="col-xs-1 col-sm-1 hidden-xs">last update</th>
						                      </tr>
                        				</thead>
										<tbody class='list'>
										 <tr class="gradeA odd">
											 @foreach ($users_roles as $user_role)
					                             <tr id="rows_users">
						                            <td id="row_user"  class="hidden-xs hidden-sm">{!!$user_role['id']!!}</td>
						                            <td id="row_user"  class="username col-xs-1 col-sm-1">{!!$user_role['username']!!}</td>
						                             <td id="row_user" class="username col-xs-1 col-sm-1">{!!$user_role['pseudo']!!}</td>
						                             <td id="row_user" class="col-xs-1 col-sm-1">{!!$user_role['role']!!}</td>
						                            <td id="row_user"  class="hidden-xs hidden-sm">{!!$user_role['created_at']!!}</td>
						                            <td id="row_user"  class="col-xs-1 col-sm-1 hidden-xs">{!!$user_role['updated_at']!!}</td>
						                            
						                            <td id="edit" class='col-sm-4 col-xs-1 col-lg-1'>
						                            	<span id='editButton' class="glyphicon glyphicon-pencil btnEditUserRole" aria-hidden="true"></span>
						                            </td>
						                            <td id="del" class="col-sm-4 col-lg-1 col-xs-1">
						                              	<span id='deleteButton' class="glyphicon glyphicon-trash btnDeleteUserRole" aria-hidden="true"></span>
						                             </td> 
						                             
						                         </tr>
                         					 @endforeach
          								</tbody>
          							</table>
          				                <ul class="pagination">
						                {!! $users_roles->render() !!}
	               					 	</ul>
	                    </div>
	                </div>
 				</div>
   			  </div>
	            		
       <script>
 var options = {
  valueNames: [ 'username']
};

var usersList = new List('roles', options);
 </script>   

@stop
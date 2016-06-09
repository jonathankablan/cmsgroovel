@extends('cmsgroovel.layouts.groovel_admin_permissions_users')
@section('content')
	 <div>
       	@if(Session::get('messages'))
             <div>{!!var_dump(Session::get('messages'))!!}</div>
        @endif
             <div id="users" style='margin-top:70px'>
	                <div class="row">
	                    <div class="panel panel-default">
	                        <div class="panel-heading">
	                            <h3 class="panel-title"><i class="fa fa-bar-chart-o"></i> Users Permissions</h3>
	                        </div>
	                        <div class="panel-body col-xs-7 col-sm-10 col-md-10">
	                        	<div class='row' style='margin-bottom: 10px' > 
		                        	<div class="col-md-2 col-sm-2 col-xs-2  hidden-xs">  
		                           		<input class="search" placeholder="Search" style="height:30px" />
		                           	</div>
		                        	 <div class="col-md-4 col-md-offset-1 col-sm-8 col-sm-offset-1 hidden-xs hidden-sm">  
								  		<button class="sort" data-sort="username" style="height:30px">
								    		Sort by name
								  		</button>
							  		</div>
							  		  <div class="col-md-2 col-md-offset-0 col-sm-3 col-xs-2  col-xs-offset-6">      
            							   <a class="btn btn-default" href="{{ url('/admin/user/permissions/form') }}">Add new user permission</a>
									 </div>
        				  		</div>
				             </div>
	          
	            				<table class="table table-hover table-striped table-bordered table-responsive"  id="table_users_permissions" >
										<thead>
								             <tr>
						                          <th id="col_user" class="col-xs-1 col-sm-1 hidden-xs hidden-sm hidden-lg">id</th>
						                          <th id="col_user" class="col-xs-1 col-sm-1">username</th>
						                          <th id="col_user" class="col-xs-1 col-sm-1 hidden-xs hidden-sm hidden-lg">pseudo</th>
						                          <th id="col_user" class="col-xs-1 col-sm-1 hidden-xs hidden-sm">retrieve</th>
						                          <th id="col_user" class="col-xs-1 col-sm-1 hidden-xs hidden-sm">save</th>
						                          <th id="col_user" class="col-xs-1 col-sm-1 hidden-xs hidden-sm">update</th>
						                          <th id="col_user" class="col-xs-1 col-sm-1 hidden-xs hidden-sm">delete</th>
						                          <th id="col_user" class="col-xs-1 col-sm-1 hidden-xs hidden-sm">add</th>
						                          <th id="col_user" class="col-xs-1 col-sm-1 hidden-xs hidden-sm">edit</th>
						                          <th id="col_user" class="col-xs-1 col-sm-1 ">content_types</th>
						                          <th id="col_user" class="col-xs-1 col-sm-1 hidden-xs">owncontent</th>
						                          <th id="col_user" class="col-xs-1 col-sm-1 hidden-xs">othercontent</th>
						                          <th id="col_user" class="col-xs-1 col-sm-1  hidden-xs hidden-sm">last update</th>
						               		</tr>
                        				</thead>
										<tbody class="list">
											 <?php foreach ($users_permissions as $permission):?>
											    <tr id="rows_users">
						                            <td id="row_user" class="col-xs-1 col-sm-1 hidden-xs hidden-sm hidden-lg">{!!$permission['id']!!}</td>
						                            <td id="row_user" class="username col-xs-1 col-sm-1">{!!$permission['username']!!}</td>
						                            <td id="row_user" class="col-xs-1 col-sm-1 hidden-xs hidden-sm hidden-lg">{!!$permission['pseudo']!!}</td>
						                             <td id="row_user" class="col-xs-1 col-sm-1 hidden-xs hidden-sm">@if($permission['retrieve']==1) yes @else no @endif</td>
						                            <td id="row_user" class="col-xs-1 col-sm-1 hidden-xs hidden-sm">@if($permission['save']) yes @else no @endif</td>
						                            <td id="row_user" class="col-xs-1 col-sm-1 hidden-xs hidden-sm">@if($permission['update']) yes @else no @endif</td>
						                            <td id="row_user" class="col-xs-1 col-sm-1 hidden-xs hidden-sm">@if($permission['delete']) yes @else no @endif</td>
						                            <td id="row_user" class="col-xs-1 col-sm-1 hidden-xs hidden-sm">@if($permission['add']) yes @else no @endif</td>
						                            <td id="row_user" class="col-xs-1 col-sm-1 hidden-xs hidden-sm">@if($permission['edit']) yes @else no @endif</td>
						                            <td id="row_user" class="col-xs-1 col-sm-1">{!!$permission['contentTypeName']!!}</td>
						                            <td id="row_user" class="col-xs-1 col-sm-1 hidden-xs">{!!$permission['owncontent']!!}</td>
						                            <td id="row_user" class="col-xs-1 col-sm-1 hidden-xs">{!!$permission['othercontent']!!}</td>
						                            <td id="row_user" class="col-xs-1 col-sm-1  hidden-xs hidden-sm">{!!$permission['updated_at']!!}</td>
						                            
						                            
						                            <td id="edit" class='col-sm-4 col-xs-1 col-lg-1'>
						                            	<span id='editButton' class="glyphicon glyphicon-pencil btnEditUserPermission" aria-hidden="true"></span>
						                            </td>
						                            <td id="del" class="col-sm-4 col-lg-1 col-xs-1">
						                              	<span id='deleteButton' class="glyphicon glyphicon-trash btnDeleteUserPermission" aria-hidden="true"></span>
						                             </td> 
						                         </tr>
					                  		<?php endforeach; ?>
          								</tbody>
          							</table>
          							
          							  <ul class="pagination">
						                <ul class="pagination">
						                {!! $users_permissions->render() !!}
	               					 	</ul>
	               					 </ul>
	           		          </div>
	                	</div>
 				</div>
   
        </div>

       <script>
 var options = {
  valueNames: [ 'username']
};

var usersList = new List('users', options);
 </script>       
@stop
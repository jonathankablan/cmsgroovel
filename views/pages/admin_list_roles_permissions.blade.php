@extends('cmsgroovel.layouts.groovel_admin_permissions_users')
@section('content')
	 <div>
       	@if(Session::get('messages'))
             <div>{!!var_dump(Session::get('messages'))!!}</div>
        @endif
        <div id='error' style='display:none'></div>
             <div id="users" style='margin-top:70px'>
	                <div class="row">
	                    <div class="panel panel-default">
	                        <div class="panel-heading">
	                            <h3 class="panel-title"><i class="fa fa-bar-chart-o"></i> Roles</h3>
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
            							   <a class="btn btn-default" href="{{ url('/admin/roles/permissions/form') }}">Add new role</a>
									 </div>
        				  		</div>
				             </div>
	          
	            				<table class="table table-hover table-striped table-bordered table-responsive"  id="table_users_permissions" >
										<thead>
								             <tr>
						                          <th id="col_user" class="col-xs-1 col-sm-1">role</th>
						                          <th id="col_user" class="col-xs-1 col-sm-1  hidden-xs hidden-sm">last update</th>
						               		</tr>
                        				</thead>
										<tbody class="list">
											 <?php foreach ($roles_permissions as $role):?>
											    <tr id="rows_users">
						                            <td id="row_user" class="col-xs-1 col-sm-1 hidden-xs">{!!$role['role']!!}</td>
						                            <td id="row_user" class="col-xs-1 col-sm-1 hidden-xs">{!!$role['updated_at']!!}</td>
						                              
						                            @if($role['role']!='ADMIN')
						                            <td id="edit" class='col-sm-4 col-xs-1 col-lg-1'>
						                            	<span id='editButton' class="glyphicon glyphicon-pencil btnEditRolePermission" aria-hidden="true"></span>
						                            </td>
						                            <td id="del" class="col-sm-4 col-lg-1 col-xs-1">
						                              	<span id='deleteButton' class="glyphicon glyphicon-trash btnDeleteRolePermission" aria-hidden="true"></span>
						                             </td> 
						                             @else
						                              <td id="edit" class='col-sm-4 col-xs-1 col-lg-1'>
						                            </td>
						                            <td id="del" class="col-sm-4 col-lg-1 col-xs-1">
						                             </td> 
						                             
						                             @endif
						                         </tr>
					                  		<?php endforeach; ?>
          								</tbody>
          							</table>
          							
          							  <ul class="pagination">
						                <ul class="pagination">
						                {!! $roles_permissions->render() !!}
	               					 	</ul>
	               					 </ul>
	           		          </div>
	                	</div>
 				</div>
   
        </div>
      
@stop
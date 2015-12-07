@extends('cmsgroovel.layouts.groovel_admin_permissions_users')
@section('content')
	 <div class="col-md-12">
       	@if(Session::get('messages'))
             <div>{!!var_dump(Session::get('messages'))!!}</div>
        @endif
             <div class="table-responsive scrollable"  id="users" style='margin-top:70px'>
	                <div class="col-md-12">
	                    <div class="panel panel-default">
	                        <div class="panel-heading">
	                            <h3 class="panel-title"><i class="fa fa-bar-chart-o"></i> Users Permissions</h3>
	                        </div>
	                        <div class="panel-body">
	                        	<div class='row' style='margin-bottom: 10px' > 
		                        	<div class="col-md-2">  
		                           		<input class="search" placeholder="Search" style="height:30px" />
		                           	</div>
		                        	 <div class="col-md-2">  
								  		<button class="sort" data-sort="name" style="height:30px">
								    		Sort by name
								  		</button>
							  		</div>
							  		  <div class="col-md-2">      
            							   {!! HTML::link('/admin/user/permissions/form', 'Add new user permission',array('class' => 'btn btn-default'))!!}
         							 </div>
        				  		</div>
				             </div>
	          
	            				<table class="table table-striped table-hover table-bordered"  id="table_users_permissions" >
										<thead>
								             <tr>
						                          <th id="col_user" class="col-md-1">id</th>
						                          <th id="col_user" class="col-md-1">username</th>
						                          <th id="col_user" class="col-md-1">pseudo</th>
						                          <th id="col_user" class="col-md-1">retrieve</th>
						                          <th id="col_user" class="col-md-1">save</th>
						                          <th id="col_user" class="col-md-1">update</th>
						                          <th id="col_user" class="col-md-1">delete</th>
						                          <th id="col_user" class="col-md-1">add</th>
						                          <th id="col_user" class="col-md-1">edit</th>
						                          <th id="col_user" class="col-md-1">content_types</th>
						                          <th id="col_user" class="col-md-1">owncontent</th>
						                          <th id="col_user" class="col-md-1">othercontent</th>
						                          <th id="col_user" class="col-md-1">last update</th>
						               		</tr>
                        				</thead>
										<tbody class="list">
											 <?php foreach ($users_permissions as $permission):?>
											    <tr id="rows_users">
						                            <td id="row_user" class="col-md-1">{!!$permission['id']!!}</td>
						                            <td id="row_user" class="username col-md-1">{!!$permission['username']!!}</td>
						                            <td id="row_user" class="col-md-1">{!!$permission['pseudo']!!}</td>
						                             <td id="row_user" class="col-md-1">@if($permission['retrieve']==1) yes @else no @endif</td>
						                            <td id="row_user" class="col-md-1">@if($permission['save']) yes @else no @endif</td>
						                            <td id="row_user" class="col-md-1">@if($permission['update']) yes @else no @endif</td>
						                            <td id="row_user" class="col-md-1">@if($permission['delete']) yes @else no @endif</td>
						                            <td id="row_user" class="col-md-1">@if($permission['add']) yes @else no @endif</td>
						                            <td id="row_user" class="col-md-1">@if($permission['edit']) yes @else no @endif</td>
						                            <td id="row_user" class="col-md-1">{!!$permission['contentTypeName']!!}</td>
						                            <td id="row_user" class="col-md-1">{!!$permission['owncontent']!!}</td>
						                            <td id="row_user" class="col-md-1">{!!$permission['othercontent']!!}</td>
						                            <td id="row_user" class="col-md-1">{!!$permission['updated_at']!!}</td>
						                            <td id="edit" class="col-md-1">
						                            {!! HTML::image('packages/groovel/cmsgroovel/groovel/admin/images/edit.jpg', $alt="edit", $attributes = array('id' => 'editButton','style'=>'width:20px;height:20px','class'=>'btnEditUserPermission')) !!}
						                            </td>
						                            <td id="del" class="col-md-1">
						                            {!! HTML::image('packages/groovel/cmsgroovel/groovel/admin/images/del.png', $alt="del", $attributes = array('id' => 'deleteButton','style'=>'width:20px;height:20px','class'=>'btnDeleteUserPermission')) !!}
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
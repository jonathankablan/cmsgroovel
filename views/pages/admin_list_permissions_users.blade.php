@extends('cmsgroovel.layouts.groovel_admin_default')
@section('content')
	 <div class="col-md-12 col-md-offset-1">
       	@if(Session::get('messages'))
             <div>{!!var_dump(Session::get('messages'))!!}</div>
        @endif
       
         <h2>Users Permissions board</h2>
      
          <div class="span2">      
            {!! HTML::link('/admin/user/permissions/form', 'Add new user permission',array('class' => 'btn btn-default'))!!}
          </div>
          
            <div class="row" id="users">
	                <div class="col-lg-12">
	                    <div class="panel panel-primary" style='width:1060px'>
	                        <div class="panel-heading">
	                            <h3 class="panel-title"><i class="fa fa-bar-chart-o"></i> Users Permissions</h3>
	                        </div>
	                        <div class="panel-body">
	                        <div style='margin-bottom: 10px' >
		                        	<input class="search" placeholder="Search" style="height:30px" />
							  		<button class="sort" data-sort="username" style="height:30px">
							    		Sort by name
							  		</button>
						  		</div>
	            				<table cellpadding="0" cellspacing="0" border="0" class="table table-hover table-striped table-bordered" id="table_users_permissions" >
										<thead>
											 <tr>
					                           <tr>
						                          <th id="col_user">id</th>
						                          <th id="col_user">username</th>
						                          <th id="col_user">pseudo</th>
						                          <th id="col_user">retrieve</th>
						                          <th id="col_user">save</th>
						                          <th id="col_user">update</th>
						                          <th id="col_user">delete</th>
						                          <th id="col_user">add</th>
						                          <th id="col_user">edit</th>
						                          <th id="col_user">content_types</th>
						                          <th id="col_user">owncontent</th>
						                          <th id="col_user">othercontent</th>
						                          <th id="col_user">last update</th>
						                		</tr>
                        					</tr>
										</thead>
										<tbody aria-relevant="all" aria-live="polite" role="alert" class="list" ><tr class="gradeA odd">
											 <?php foreach ($users_permissions as $permission):?>
											    <tr id="rows_users">
					                            <td id="row_user">{!!$permission['id']!!}</td>
					                            <td id="row_user" class="username">{!!$permission['username']!!}</td>
					                            <td id="row_user">{!!$permission['pseudo']!!}</td>
					                             <td id="row_user">@if($permission['retrieve']==1) yes @else no @endif</td>
					                            <td id="row_user">@if($permission['save']) yes @else no @endif</td>
					                            <td id="row_user">@if($permission['update']) yes @else no @endif</td>
					                            <td id="row_user">@if($permission['delete']) yes @else no @endif</td>
					                            <td id="row_user">@if($permission['add']) yes @else no @endif</td>
					                            <td id="row_user">@if($permission['edit']) yes @else no @endif</td>
					                            <td id="row_user">{!!$permission['contentTypeName']!!}</td>
					                            <td id="row_user">{!!$permission['owncontent']!!}</td>
					                            <td id="row_user">{!!$permission['othercontent']!!}</td>
					                            <td id="row_user">{!!$permission['updated_at']!!}</td>
					                            <td id="edit">
					                            {!! HTML::image('packages/groovel/cmsgroovel/groovel/admin/images/edit.jpg', $alt="edit", $attributes = array('id' => 'editButton','style'=>'width:20px;height:20px','class'=>'btnEditUserPermission')) !!}
					                            <!--<img src='../../public/theme-admin/images/save.png' class='btnSave' style="width:20px;height:20px">-->
					                            </td>
					                            <td id="del">
					                            <!--<img src='../../public/theme-admin/images/del.png' class='btnDelete' style="width:20px;height:20px">-->
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
   
        </div>

       <script>
 var options = {
  valueNames: [ 'username']
};

var usersList = new List('users', options);
 </script>       
@stop
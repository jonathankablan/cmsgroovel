@extends('cmsgroovel.layouts.groovel_admin_roles_users')
@section('content')
	 <div class="col-md-12" style='margin-top:50px'>
       	@if(Session::get('messages'))
             <div>{!!var_dump(Session::get('messages'))!!}</div>
        @endif
             <div class="table-responsive scrollable" id='roles' style='margin-top:50px'>
	                <div class="col-md-12">
	                    <div class="panel panel-default">
	                        <div class="panel-heading">
	                            <h3 class="panel-title"><i class="fa fa-bar-chart-o"></i> Users Role</h3>
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
            							{!! HTML::link('/admin/user/role/form', 'Add new user role',array('class' => 'btn btn-default'))!!}
         							 </div>
        				  		</div>
						  		
						  		
						  	</div>
	            				<table class="table table-striped table-hover table-bordered" id="table_users">
										<thead>
										       <tr>
						                          <th id="col_user"  class="col-md-1">id</th>
						                          <th id="col_user"  class="col-md-1">username</th>
						                          <th id="col_user"  class="col-md-1">pseudo</th>
						                          <th id="col_user"  class="col-md-1">role</th>
						                          <th id="col_user"  class="col-md-1">creation date</th>
						                          <th id="col_user"  class="col-md-1">last update</th>
						                      </tr>
                        				</thead>
										<tbody class='list'>
										 <tr class="gradeA odd">
											 @foreach ($users_roles as $user_role)
					                             <tr id="rows_users">
						                            <td id="row_user"  class="col-md-1">{!!$user_role['id']!!}</td>
						                            <td id="row_user"  class="username col-md-1">{!!$user_role['username']!!}</td>
						                             <td id="row_user" class="username col-md-1">{!!$user_role['pseudo']!!}</td>
						                             <td id="row_user" class="col-md-1">{!!$user_role['role']!!}</td>
						                            <td id="row_user"  class="col-md-1">{!!$user_role['created_at']!!}</td>
						                            <td id="row_user"  class="col-md-1">{!!$user_role['updated_at']!!}</td>
						                            <td id="edit"  class="col-md-1">
						                            {!! HTML::image('packages/groovel/cmsgroovel/groovel/admin/images/edit.jpg', $alt="edit", $attributes = array('id' => 'editButton','style'=>'width:20px;height:20px','class'=>'btnEditUserRole')) !!}
						                            </td>
						                            <td id="del"  class="col-md-1">
						                            {!! HTML::image('packages/groovel/cmsgroovel/groovel/admin/images/del.png', $alt="del", $attributes = array('id' => 'deleteButton','style'=>'width:20px;height:20px','class'=>'btnDeleteUserRole')) !!}
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
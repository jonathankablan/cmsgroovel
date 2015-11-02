@extends('cmsgroovel.layouts.groovel_admin_default')
@section('content')
	 <div class="col-md-12 col-md-offset-1">
       	@if(Session::get('messages'))
             <div>{!!var_dump(Session::get('messages'))!!}</div>
        @endif
       
         <h2>Roles board</h2>
      
          <div class="span2">      
            {!! HTML::link('/admin/user/role/form', 'Add new user role',array('class' => 'btn btn-default'))!!}
          </div>
          
            <div class="row" id='roles'>
	                <div class="col-lg-12">
	                    <div class="panel panel-primary">
	                        <div class="panel-heading">
	                            <h3 class="panel-title"><i class="fa fa-bar-chart-o"></i> Users Role</h3>
	                        </div>
	                        <div class="panel-body">
	                         <div style='margin-bottom: 10px' >
		                        	<input class="search" placeholder="Search" style="height:30px" />
							  		<button class="sort" data-sort="username" style="height:30px">
							    		Sort by name
							  		</button>
						  		</div>
	            				<table cellpadding="0" cellspacing="0" border="0" class="table table-hover table-striped table-bordered" id="table_users">
										<thead>
											 <tr>
					                           <tr>
						                          <th id="col_user">id</th>
						                          <th id="col_user">username</th>
						                          <th id="col_user">pseudo</th>
						                          <th id="col_user">role</th>
						                          <th id="col_user">creation date</th>
						                          <th id="col_user">last update</th>
						                      </tr>
                        					</tr>
										</thead>
										<tbody aria-relevant="all" aria-live="polite" role="alert" class='list'><tr class="gradeA odd">
											 @foreach ($users_roles as $user_role)
					                             <tr id="rows_users">
					                            <td id="row_user">{!!$user_role['id']!!}</td>
					                            <td id="row_user" class='username'>{!!$user_role['username']!!}</td>
					                             <td id="row_user" class='username'>{!!$user_role['pseudo']!!}</td>
					                             <td id="row_user">{!!$user_role['role']!!}</td>
					                            <td id="row_user">{!!$user_role['created_at']!!}</td>
					                            <td id="row_user">{!!$user_role['updated_at']!!}</td>
					                            <td id="edit">
					                            {!! HTML::image('packages/groovel/cmsgroovel/groovel/admin/images/edit.jpg', $alt="edit", $attributes = array('id' => 'editButton','style'=>'width:20px;height:20px','class'=>'btnEditUserRole')) !!}
					                            <!--<img src='../../public/theme-admin/images/save.png' class='btnSave' style="width:20px;height:20px">-->
					                            </td>
					                            <td id="del">
					                            <!--<img src='../../public/theme-admin/images/del.png' class='btnDelete' style="width:20px;height:20px">-->
					                            {!! HTML::image('packages/groovel/cmsgroovel/groovel/admin/images/del.png', $alt="del", $attributes = array('id' => 'deleteButton','style'=>'width:20px;height:20px','class'=>'btnDeleteUserRole')) !!}
					                            </td>
					                          </tr>
                         					 @endforeach
          								</tbody>
          							</table>
          							
          							  <ul class="pagination">
						                <ul class="pagination">
						                {!! $users_roles->render() !!}
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

var usersList = new List('roles', options);
 </script>   

@stop
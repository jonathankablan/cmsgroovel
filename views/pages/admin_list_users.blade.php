@extends('cmsgroovel.layouts.groovel_admin_default')
@section('content')
	 <div class="col-md-12">
       	@if(Session::get('messages'))
             <div>{!!var_dump(Session::get('messages'))!!}</div>
        @endif
       
         <h2>Users board</h2>
      
          <div class="span2">      
            {!! HTML::link('/admin/user/form', 'Add new user',array('class' => 'btn btn-default'))!!}
          </div>
          
            <div class="row" id="users">
	                <div class="col-lg-12">
	                     
	                        <div class="panel-body">
	                          <div style='margin-bottom: 10px' >
		                        	<input class="search" placeholder="Search" style="height:30px" />
							  		<button class="sort" data-sort="username" style="height:30px">
							    		Sort by username
							  		</button>
						  		</div>
	            				<table cellpadding="0" cellspacing="0" border="0" class="table table-hover table-striped table-bordered" id="table_users" style='background-color: #FFFFFF '>
										<thead>
							                 <tr>
						                          <th id="col_user">id</th>
						                          <th id="col_user">picture</th>
						                          <th id="col_user">username</th>
						                          <th id="col_user">pseudo</th>
						                          <th id="col_user">email</th>
						                           <th id="col_user">creation date</th>
						                          <th id="col_user">last update</th>
						                          <th id="col_user">activate</th>
						                 	</tr>
                        				</thead>
										<tbody aria-relevant="all" aria-live="polite" role="alert" class="list"><tr class="gradeA odd">
											 @foreach ($users as $user)
					                             <tr id="rows_users">
					                            <td id="row_user">{!!$user->id!!}</td>
					                            <td id="row_user">  
					                             @if($user->picture!=null)
					                            {!!HTML::image( $user->picture,'',array('width'=>'100%','height'=>'100%'))!!}
					                            @endif
					                            </td>
					                            <td id="row_user" class="username">{!!$user->username!!}</td>
					                            <td id="row_user" class="pseudo">{!!$user->pseudo!!}</td>
					                            <td id="row_user">{!!$user->email!!}</td>
					                            <td id="row_user">{!!$user->created_at!!}</td>
					                            <td id="row_user">{!!$user->updated_at!!}</td>
					                            <td id="row_user">{!!$user->activate!!}</td>
					                            <td id="edit">
					                            {!! HTML::image('packages/groovel/cmsgroovel/groovel/admin/images/edit.jpg', $alt="edit", $attributes = array('id' => 'editButton','style'=>'width:20px;height:20px','class'=>'btnEditUser')) !!}
					                            <!--<img src='../../public/theme-admin/images/save.png' class='btnSave' style="width:20px;height:20px">-->
					                            </td>
					                            <td id="del">
					                            <!--<img src='../../public/theme-admin/images/del.png' class='btnDelete' style="width:20px;height:20px">-->
					                            {!! HTML::image('packages/groovel/cmsgroovel/groovel/admin/images/del.png', $alt="del", $attributes = array('id' => 'deleteButton','style'=>'width:20px;height:20px','class'=>'btnDeleteUser')) !!}
					                            </td>
					                             <td id="view">
					                              <button id="view" class="btn btn-success btnViewUser">View</button>
					                              </td>
					                               <td id="activate">
					                              <button id="activate" class="btn btn-success btnActivateUser">activate user</button>
					                              </td>
					                               <td id="notactivate">
					                              <button id="notactivate" class="btn btn-success btnNotActivateUser">block user</button>
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
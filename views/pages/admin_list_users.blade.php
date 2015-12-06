@extends('cmsgroovel.layouts.groovel_admin_users')
@section('content')
	 <div class="col-md-12" style="margin-top:70px">
       	@if(Session::get('messages'))
             <div>{!!var_dump(Session::get('messages'))!!}</div>
        @endif
             <div class="table-responsive scrollable" id="users">
	                <div class="col-md-12">
	                    <div class="panel panel-default">
	                        <div class="panel-heading">
	                            <h3 class="panel-title"><i class="fa fa-bar-chart-o"></i> Users</h3>
	                        </div>
	                        <div class="panel-body">
	                          <div style='margin-bottom: 10px' >
		                         	 <div class="col-md-2"> 
			                        	<input class="search" placeholder="Search" style="height:30px" />
			                        </div>
			                        <div class="col-md-2"> 
								  		<button class="sort" data-sort="username" style="height:30px">
								    		Sort by username
								  		</button>
								  	</div>
								  	<div class="col-md-2">      
	           								 {!! HTML::link('/admin/user/form', 'Add new user',array('class' => 'btn btn-default'))!!}
	          						</div>
             			  		</div>
             			  	</div>
             			  	
	            				<table class="table table-striped table-hover table-bordered"  id="table_users" style='background-color: #FFFFFF '>
										<thead>
							                 <tr>
						                          <th id="col_user" class="col-md-1">id</th>
						                          <th id="col_user" class="col-md-1">picture</th>
						                          <th id="col_user" class="col-md-1">username</th>
						                          <th id="col_user" class="col-md-1">pseudo</th>
						                          <th id="col_user" class="col-md-1">email</th>
						                           <th id="col_user" class="col-md-1">creation date</th>
						                          <th id="col_user" class="col-md-1">last update</th>
						                          <th id="col_user" class="col-md-1">activate</th>
						                 	</tr>
                        				</thead>
										<tbody aria-relevant="all" aria-live="polite" role="alert" class="list"><tr class="gradeA odd">
											 @foreach ($users as $user)
					                             <tr id="rows_users">
					                            <td id="row_user" class="col-md-1">{!!$user->id!!}</td>
					                            <td id="row_user" class="col-md-1">  
					                             @if($user->picture!=null)
					                            {!!HTML::image( $user->picture,'',array('width'=>'100%','height'=>'100%'))!!}
					                            @endif
					                            </td>
					                            <td id="row_user" class="username col-md-1">{!!$user->username!!}</td>
					                            <td id="row_user" class="pseudo col-md-1">{!!$user->pseudo!!}</td>
					                            <td id="row_user" class="col-md-1">{!!$user->email!!}</td>
					                            <td id="row_user" class="col-md-1">{!!$user->created_at!!}</td>
					                            <td id="row_user" class="col-md-1">{!!$user->updated_at!!}</td>
					                            <td id="row_user" class="col-md-1">{!!$user->activate!!}</td>
					                            <td id="edit" class="col-md-1">
					                            {!! HTML::image('packages/groovel/cmsgroovel/groovel/admin/images/edit.jpg', $alt="edit", $attributes = array('id' => 'editButton','style'=>'width:20px;height:20px','class'=>'btnEditUser')) !!}
					                            </td>
					                            <td id="del" class="col-md-1">
					                            {!! HTML::image('packages/groovel/cmsgroovel/groovel/admin/images/del.png', $alt="del", $attributes = array('id' => 'deleteButton','style'=>'width:20px;height:20px','class'=>'btnDeleteUser')) !!}
					                            </td>
					                             <td id="view" class="col-md-1">
					                              <button id="view" class="btn btn-success btnViewUser">View</button>
					                              </td>
					                               <td id="activate" class="col-md-1">
					                              <button id="activate" class="btn btn-success btnActivateUser">activate user</button>
					                              </td>
					                               <td id="notactivate" class="col-md-1">
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
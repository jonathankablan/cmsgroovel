  <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">            
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="#">Groovel Admin Panel</a>
            </div>
            <div class="collapse navbar-collapse navbar-ex1-collapse">
                <ul class="nav navbar-nav side-nav">
                  <li>
                  <a href="{{ url('/admin/dashboard') }}"><span><i class="glyphicon glyphicon-dashboard"></i></span> Dashboard</a>
                  </li>
		          <li class="dropdown" style='margin-left:60px'>
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown"><span class='glyphicon glyphicon-user'></span>Users<b class="caret"></b></a>
                    <ul class="dropdown-menu">
                        <li class="dropdown dropdown-submenu">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">Manage Users</a>
                            <ul class="dropdown-menu">
                                <li>{!! HTML::link('/admin/users', 'List Users')!!}</li>
			              	 	 <li class="divider"></li>
			              		 <li>{!! HTML::link('/admin/user/form', 'Add new user')!!}</li>
                            </ul>
                            </li>
                             <li class="divider"></li>
                             <li class="dropdown dropdown-submenu">
                             <a href="#" class="dropdown-toggle" data-toggle="dropdown">Manage Users Permissions</a>
			                 
			                   <ul class="dropdown-menu">
				                   <li>{!! HTML::link('/admin/users/permissions', 'List Users permissions')!!}</li>
					           	    <li class="divider"></li>
					            	 <li>{!! HTML::link('/admin/user/permissions/form', 'Add user permissions')!!}</li>
					          	</ul>
					      </li>
			                <li class="divider"></li>
                             <li class="dropdown dropdown-submenu">
			                  <a href="#" class="dropdown-toggle" data-toggle="dropdown">Manage Users Roles </a>
			                   <ul class="dropdown-menu">
				              	 <li>{!! HTML::link('/admin/user/role/form', 'Add user roles')!!}</li>
				              	   <li class="divider"></li>
				              	  <li>{!! HTML::link('/admin/users/roles', 'List Users roles')!!}</li>
				               	</ul>
				              </li>
				         </ul>
		           </li>
		            <li class="dropdown">
		              <a href="#" class="dropdown-toggle" data-toggle="dropdown"><span class='glyphicon glyphicon-wrench'></span>System Kernel<span class="caret"></span></a>
		              <ul class="dropdown-menu" role="menu">
		                       
		                 <li class="dropdown dropdown-submenu">
			                  <a href="#" class="dropdown-toggle" data-toggle="dropdown">System configuration</a>
			                   <ul class="dropdown-menu">
				              	 <li>{!! HTML::link('/admin/config_system', ' Configuration')!!}</li>
				              	</ul>
				         </li>
		                      
		                      <li class="divider"></li>
		               
		               
		               
		               
		               
		                 <li class="dropdown dropdown-submenu">
			                  <a href="#" class="dropdown-toggle" data-toggle="dropdown">Packages Management</a>
			                   <ul class="dropdown-menu">
				              	 <li>{!! HTML::link('/admin/packages', 'List Packages')!!}</li>
				               	</ul>
				         </li>
		                
		                
		                 <li class="divider"></li>
		                <li class="dropdown dropdown-submenu">
			                  <a href="#" class="dropdown-toggle" data-toggle="dropdown">Manage System Pages </a>
			                   <ul class="dropdown-menu">
				              	   <li>{!! HTML::link('/admin/routes', 'List Pages System')!!}</li>
		          		    	   <li class="divider"></li>
				               		<li>{!! HTML::link('/admin/routes/form', 'Add Pages System')!!}</li>
		          		   		</ul>
				        </li>
				        </ul>
		             </li>    
		             
		              <li class="dropdown">
		              <a href="#" class="dropdown-toggle" data-toggle="dropdown"><span class='glyphicon glyphicon-th-list'></span>Forums <span class="caret"></span></a>
		              <ul class="dropdown-menu" role="menu">
		                <!-- <li><a href="./admin/routes">List Routes</a></li>-->
		                <li>{!! HTML::link('/forums/view', 'List all forums')!!}</li>
		              </ul>
		            </li>
		            
		            <li class="dropdown">
		              <a href="#" class="dropdown-toggle" data-toggle="dropdown"><span class='glyphicon glyphicon-book'></span>Blog <span class="caret"></span></a>
		              <ul class="dropdown-menu" role="menu">
		              	<li>
		              	<a href={!! url('/blogs') !!} target="_blank">Blog Home</a>
		              	</li>
		              	<li class="divider"></li>
		                <li>{!! HTML::link('/blog/posts', 'Quick Post')!!}</li>
		              </ul>
		            </li>
		            
		             
		              <!-- <li>{!! HTML::link('/search', 'Search')!!}</li>-->
		             
         	 </ul>
         	 <div class="col-sm-2 col-md-2 col-md-offset-1">
		       <form id='search_form' class="navbar-form" role="search" action='/admin/search/execute' method='post'>
		        <input id='token' type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
		        <div class="input-group">
		            <input id='search' type="text" class="form-control" placeholder="Search" name="srch-term" >
		            <div class="input-group-btn">
		                <button id="srch-term" class="btn btn-default"><i class="glyphicon glyphicon-search"></i></button>
		            </div>
		        </div>
		       </form>
        	</div>
         	  <ul class="nav navbar-nav navbar-right navbar-user" style='margin-right:10px'>
                    <li class="dropdown user-dropdown">
                       <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="glyphicon glyphicon-user"></i>@if(\Auth::user()!=null) {!!\Auth::user()->pseudo!!} @endif<b class="caret"></b></a>
                       <ul class="dropdown-menu">
                            <li>{!! HTML::link('user/view/profile', 'Settings')!!}</li>
                            <li class="divider"></li>
                            <li>   {!! HTML::link('/messages/list', 'Messages')!!}</li>                    
                           <li class="divider"></li>
                          @if (Auth::check())
              				<li>{!! link_to('admin/auth/logout', 'Log out') !!}</li>
     					@endif
                       </ul>
                   </li>
                </ul>
            </div>
          
        </nav>
<!-- <script>
$(document).ready(bindSearch());
</script> -->
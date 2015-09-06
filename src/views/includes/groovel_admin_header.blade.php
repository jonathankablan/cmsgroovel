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
                    <li>{{ HTML::link('/admin/dashboard', 'Dashboard')}}</li>
		            <!-- <li><a href="#">Logs</a></li>-->
		           
		             <li class="dropdown">
		              <a href="#" class="dropdown-toggle" data-toggle="dropdown">Templates <span class="caret"></span></a>
		              <ul class="dropdown-menu" role="menu">
		                <!-- <li><a href="./admin/routes">List Routes</a></li>-->
		                <li>{{ HTML::link('/admin/templates/create', 'Choose Template')}}</li>
		              </ul>
		            </li>
		            
		            
		            <li class="dropdown">
		              <a href="#" class="dropdown-toggle" data-toggle="dropdown">Routes <span class="caret"></span></a>
		              <ul class="dropdown-menu" role="menu">
		                <!-- <li><a href="./admin/routes">List Routes</a></li>-->
		                <li>{{ HTML::link('/admin/routes/user', 'List Routes')}}</li>
		                <li class="divider"></li>
		                <li>{{ HTML::link('/admin/routes/form', 'Add Routes')}}</li>
		               </ul>
		            </li>
		         
		          <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">Contents<b class="caret"></b></a>
                    <ul class="dropdown-menu">
                        <li class="dropdown dropdown-submenu">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">Manage Contents</a>
                            <ul class="dropdown-menu">
                                 <li>{{ HTML::link('/admin/contents', 'List Contents')}}</li>
		                  	   	<li class="divider"></li>
			              	 	<li>{{ HTML::link('/admin/content/form', 'Add new contents')}}</li>
			                </ul>
                            </li>
                             <li class="divider"></li>
                             <li class="dropdown dropdown-submenu">
                             <a href="#" class="dropdown-toggle" data-toggle="dropdown">Manage Content Types</a>
			                 
			                   <ul class="dropdown-menu">
				                   <li>{{ HTML::link('/admin/content_type/form', 'Add new contents type')}}</li>
					           	    <li class="divider"></li>
					            	 <li>{{ HTML::link('/admin/content_types', 'List Content types')}}</li>
					         	</ul>
					      </li>
			            </ul>
		           </li>
		          
		          
		          
		         <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">Users<b class="caret"></b></a>
                    <ul class="dropdown-menu">
                        <li class="dropdown dropdown-submenu">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">Manage Users</a>
                            <ul class="dropdown-menu">
                                <li>{{ HTML::link('/admin/users', 'List Users')}}</li>
			              	 	 <li class="divider"></li>
			              		 <li>{{ HTML::link('/admin/user/form', 'Add new user')}}</li>
                            </ul>
                            </li>
                             <li class="divider"></li>
                             <li class="dropdown dropdown-submenu">
                             <a href="#" class="dropdown-toggle" data-toggle="dropdown">Manage Users Permissions</a>
			                 
			                   <ul class="dropdown-menu">
				                   <li>{{ HTML::link('/admin/users/permissions', 'List Users permissions')}}</li>
					           	    <li class="divider"></li>
					            	 <li>{{ HTML::link('/admin/user/permissions/form', 'Add user permissions')}}</li>
					          	</ul>
					      </li>
			                <li class="divider"></li>
                             <li class="dropdown dropdown-submenu">
			                  <a href="#" class="dropdown-toggle" data-toggle="dropdown">Manage Users Roles </a>
			                   <ul class="dropdown-menu">
				              	 <li>{{ HTML::link('/admin/user/role/form', 'Add user roles')}}</li>
				              	   <li class="divider"></li>
				              	  <li>{{ HTML::link('/admin/users/roles', 'List Users roles')}}</li>
				               	</ul>
				              </li>
				         </ul>
		           </li>
		            <li class="dropdown">
		              <a href="#" class="dropdown-toggle" data-toggle="dropdown">System Kernel <span class="caret"></span></a>
		              <ul class="dropdown-menu" role="menu">
		                       
		                 <li class="dropdown dropdown-submenu">
			                  <a href="#" class="dropdown-toggle" data-toggle="dropdown">System configuration</a>
			                   <ul class="dropdown-menu">
				              	 <li>{{ HTML::link('/admin/config_system', ' Configuration')}}</li>
				              	</ul>
				         </li>
		                      
		                      <li class="divider"></li>
		               
		               
		               
		               
		               
		                 <li class="dropdown dropdown-submenu">
			                  <a href="#" class="dropdown-toggle" data-toggle="dropdown">Packages Management</a>
			                   <ul class="dropdown-menu">
				              	 <li>{{ HTML::link('/admin/packages', 'List Packages')}}</li>
				               	</ul>
				         </li>
		                
		                
		                 <li class="divider"></li>
		                <li class="dropdown dropdown-submenu">
			                  <a href="#" class="dropdown-toggle" data-toggle="dropdown">Manage System Routes </a>
			                   <ul class="dropdown-menu">
				              	   <li>{{ HTML::link('/admin/routes', 'List Routes System')}}</li>
		          		    	   <li class="divider"></li>
				               		<li>{{ HTML::link('/admin/routes/form', 'Add Routes System')}}</li>
		          		   		</ul>
				        </li>
				        </ul>
		             </li>    
		             
		              <li class="dropdown">
		              <a href="#" class="dropdown-toggle" data-toggle="dropdown">Forums <span class="caret"></span></a>
		              <ul class="dropdown-menu" role="menu">
		                <!-- <li><a href="./admin/routes">List Routes</a></li>-->
		                <li>{{ HTML::link('/forums/view', 'List all forums')}}</li>
		              </ul>
		            </li>
		            
		             
		              <li>{{ HTML::link('/search', 'Search')}}</li>
		             
         	 </ul>
         	  <ul class="nav navbar-nav navbar-right navbar-user" style='margin-right:50px'>
                    <li class="dropdown user-dropdown">
                       <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-user"></i>@if(\Auth::user()!=null) {{\Auth::user()->pseudo}} @endif<b class="caret"></b></a>
                       <ul class="dropdown-menu">
                            <li>{{ HTML::link('user/view/profile', 'Settings')}}</li>
                            <li class="divider"></li>
                            <li>   {{ HTML::link('/messages/list', 'Messages')}}</li>                    
                           <li class="divider"></li>
                          @if (Auth::check())
              				<li>{{ link_to('admin/auth/logout', 'Log out') }}</li>
     					@endif
                       </ul>
                   </li>
            </div>
          
        </nav>
                    
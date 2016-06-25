  <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">            
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand hidden-sm" href="/admin">Groovel Admin Panel</a>
            </div>
            <div class="collapse navbar-collapse navbar-ex1-collapse">
                <ul class="nav navbar-nav side-nav">
                  <li>
                  <a href="{{ url('/admin/dashboard') }}"><span><i class="glyphicon glyphicon-dashboard"></i></span> Dashboard</a>
                  </li>
		          <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown"><span class='glyphicon glyphicon-user'></span>Users<b class="caret"></b></a>
                    <ul class="dropdown-menu">
                        <li class="dropdown dropdown-submenu">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">Manage Users</a>
                            <ul class="dropdown-menu">
                                 <li><a href="{{ url('/admin/users') }}">View users</a></li>
			              	 	 <li class="divider"></li>
			               		 <li><a href="{{ url('/admin/user/form') }}">Add new user</a></li>
                            </ul>
                            </li>
                            
			                <li class="divider"></li>
                             <li class="dropdown dropdown-submenu">
			                  <a href="#" class="dropdown-toggle" data-toggle="dropdown">Manage Users Roles </a>
			                   <ul class="dropdown-menu">
				               	  <li><a href="{{ url('/admin/user/role/form') }}">Add user roles</a></li>
				              	  <li class="divider"></li>
				              	  <li><a href="{{ url('/admin/users/roles') }}">View Users roles</a></li>
				               	</ul>
				              </li>
				              <li class="divider"></li>
                             <li class="dropdown dropdown-submenu">
			                  <a href="#" class="dropdown-toggle" data-toggle="dropdown">Manage Roles </a>
			                   <ul class="dropdown-menu">
				               	  <li><a href="{{ url('/admin/roles/permissions/form')  }}">Add roles</a></li>
				              	  <li class="divider"></li>
				              	  <li><a href="{{ url('/admin/roles/permissions') }}">View  roles</a></li>
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
				               	  <li><a href="{{ url('/admin/config_system') }}">Configuration</a></li>
				              	</ul>
				         </li>
	                    <li class="divider"></li>
                        <li class="dropdown dropdown-submenu">
			                  <a href="#" class="dropdown-toggle" data-toggle="dropdown">Packages Management</a>
			                   <ul class="dropdown-menu">
				              	  <li><a href="{{ url('/admin/packages') }}">View Packages</a></li>
				               </ul>
				         </li>
		                
		                
		                <li class="divider"></li>
		                <li class="dropdown dropdown-submenu">
			                  <a href="#" class="dropdown-toggle" data-toggle="dropdown">Manage System Pages </a>
			                   <ul class="dropdown-menu">
				              	   <li><a href="{{ url('/admin/routes') }}">View Pages System</a></li>
		          		    	   <li class="divider"></li>
		          		    	   <li><a href="{{ url('/admin/routes/form') }}">Add Pages System</a></li>
				        		</ul>
				        </li>
				        </ul>
		             </li>    
		             
		              <li class="dropdown">
		              <a href="#" class="dropdown-toggle" data-toggle="dropdown"><span class='glyphicon glyphicon-th-list'></span>Forums <span class="caret"></span></a>
		              <ul class="dropdown-menu" role="menu">
		                  <li><a href="{{ url('/forums/view') }}">View forums</a></li>
		              </ul>
		            </li>
		            
		            <li class="dropdown">
		              <a href="#" class="dropdown-toggle" data-toggle="dropdown"><span class='glyphicon glyphicon-book'></span>Blog <span class="caret"></span></a>
		              <ul class="dropdown-menu" role="menu">
		              	<li><a href="{{ url('/blogs') }}" target="_blank">Blog Home</a></li>
		              	<li class="divider"></li>
		                <li><a href="{{ url('/blog/posts') }}">Quick Post</a></li>
		              </ul>
		            </li>
	      	 </ul>
         	 <div class="col-sm-2 col-md-2 col-md-offset-0 hidden-sm">
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
                   @if (Auth::check())
              			<li><a href="{{ url('/admin/auth/logout') }}">Log out</a></li>
     			   @endif
                </ul>  
         	  <ul class="nav navbar-nav navbar-right navbar-user">
                    <li>
                       <a href="{{ url('/user/view/profile') }}">
                       @if(\Auth::user()!=null) 
	                        @if( \Auth::user()->picture==null)
	                       		<i class="glyphicon glyphicon-user"></i>
	                        @else
	                       	<img src="/{{\Auth::user()->picture}}" alt="user" class="img-circle" style='width:20%;height:20%'>
	                         @endif
	                   @endif
                       @if(\Auth::user()!=null) {!!\Auth::user()->pseudo!!} @endif</a>
                      
                   </li>
                </ul>
            
                <ul class="nav navbar-nav navbar-right navbar-user">
                  <li>
                  <a href="{{ url('/messages/list') }}" style="color:#9d9d9d" >Inbox<span class="badge" style='margin-left:5px'>{!!\Session::get('newmessages')!!}</span></a>
                  </li> 
                 </ul> 
                
	         </div>
          
        </nav>
>
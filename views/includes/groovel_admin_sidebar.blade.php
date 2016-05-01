    <div class="sidebar-nav">
     <div class="navbar navbar-default sidebar-nav" role="navigation" style='margin-top:50px'>
        <div class="navbar-header">
          <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".sidebar-navbar-collapse">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand hidden-sm" href="/admin">More Options</a>
        </div>
        <div class="navbar-collapse collapse sidebar-navbar-collapse">
          <ul class="nav nav-sidebar sidebar-nav" style='list-style: none'>
	            
	                 <li class='menu-sidebar' style="margin-top:60px"><a href="#" id="btn-1" data-toggle="collapse" data-target="#menu" aria-expanded="false">
	                 <span class='glyphicon glyphicon-menu-hamburger'></span>Menu<span class="caret"></span></a>
			             <ul class="nav collapse" role="menu" id='menu'>
			                <li> <a href='/admin/menu/create' ><i class="glyphicon glyphicon-wrench"></i> Create menu</a></li>
			                <li class="divider"></li>
			                <li>
			                <a href='/admin/menu/list' ><i class="glyphicon glyphicon-eye-open"></i>View menus</a></li>
			               </ul>
			          </li>
	                  <li class="dropdown" style='margin-top:40px'>
	                    <a href="#" class="dropdown-toggle" data-toggle="collapse" data-target="#contents"><span class='glyphicon glyphicon-book'></span>Contents<b class="caret"></b></a>
	                    <ul class="nav collapse" id='contents'>
	                        <li class="nav collapse collapse-submenu">
	                            <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="glyphicon glyphicon-wrench"></i>Manage Contents</a>
	                            <ul class="dropdown-menu">
	                                 <li><a href='/admin/contents' ><i class="glyphicon glyphicon-eye-open"></i>View contents</a></li>
	                           	   	<li class="divider"></li>
				              	 	<li>
				              	 		<a href='/admin/content/form' ><i class="glyphicon glyphicon-plus"></i>Add content</a>
				              	 	</li>
				                </ul>
	                         </li>
	                          <li class="divider"></li>
	                          <li class="nav collapse collapse-submenu">
	                             <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="glyphicon glyphicon-wrench"></i>Manage templates</a>
				                 
				                   <ul class="dropdown-menu">
					                   <li><a href='/admin/content_type/form' ><i class="glyphicon glyphicon-plus"></i>Add template</a></li>
						           	    <li class="divider"></li>
						            	 <li>
						            	     <a href='/admin/content_types' ><i class="glyphicon glyphicon-eye-open"></i>View templates</a>
						            	 </li>
						         	</ul>
						      </li>
				            </ul>
			           </li>
	               		<li class="dropdown" style='margin-top:40px'>
	                    	<a href="#" class="dropdown-toggle" data-toggle="collapse" data-target="#pages"><span class='glyphicon glyphicon-file'></span>Pages<b class="caret"></b></a>
				               <ul class="nav collapse" id='pages'>
				                   <li><a href='/admin/pages/form' ><i class="glyphicon glyphicon-plus"></i>Add pages</a></li>
					           	    <li class="divider"></li>
					            	<li><a href='/admin/routes/user' ><i class="glyphicon glyphicon-eye-open"></i>View pages</a></li>
					         	</ul>
	               		</li>
	               		<li class="dropdown" style='margin-top:40px'>
	               			<a href="#" class="dropdown-toggle" data-toggle="collapse" data-target="#layouts"><span class='glyphicon glyphicon-edit'></span>Layout<b class="caret"></b></a>
				               <ul class="nav collapse" id='layouts'>
				                   <li><a href='/admin/layout' ><i class="glyphicon glyphicon-wrench"></i>Configure layout</a></li>
					           	    <li class="divider"></li>
					            	<li>
					            		<a href='/admin/layout/list' ><i class="glyphicon glyphicon-eye-open"></i>View layouts</a>
					            	</li>
					         	</ul>
	               		</li>
	               		 <li class="dropdown" style='margin-top:40px'>
	                    	<a href={!! url('filemanager/index.html') !!} target="_blank"><span class='glyphicon glyphicon-open-file'></span>Files Manager</a>
	               		</li>
	          
	            </ul>
        
        </div><!--/.nav-collapse -->
     </div>
 </div>
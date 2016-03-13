<div class='sidebar'>
            <ul class="sidebar-nav" style='list-style: none'>
            
            	 <li class="dropdown" style='margin-top:10px'>
		              <a href="#" class="dropdown-toggle" data-toggle="dropdown"><span class='glyphicon glyphicon-menu-hamburger'></span>Menu<span class="caret"></span></a>
		              <ul class="dropdown-menu" role="menu">
		                <!-- <li><a href="./admin/routes">List Routes</a></li>-->
		                <li>{!! HTML::link('/admin/menu/create', 'Create menu')!!}</li>
		                <li class="divider"></li>
		                <li>{!! HTML::link('/admin/menu/list', 'List menu')!!}</li>
		               </ul>
		          </li>
                  <li class="dropdown" style='margin-top:40px'>
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown"><span class='glyphicon glyphicon-book'></span>Contents<b class="caret"></b></a>
                    <ul class="dropdown-menu">
                        <li class="dropdown dropdown-submenu">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">Manage Contents</a>
                            <ul class="dropdown-menu">
                                 <li>{!! HTML::link('/admin/contents', 'List Contents')!!}</li>
		                  	   	<li class="divider"></li>
			              	 	<li>{!! HTML::link('/admin/content/form', 'Add new contents')!!}</li>
			                </ul>
                            </li>
                             <li class="divider"></li>
                             <li class="dropdown dropdown-submenu">
                             <a href="#" class="dropdown-toggle" data-toggle="dropdown">Manage Contents Templates</a>
			                 
			                   <ul class="dropdown-menu">
				                   <li>{!! HTML::link('/admin/content_type/form', 'Add new content template')!!}</li>
					           	    <li class="divider"></li>
					            	 <li>{!! HTML::link('/admin/content_types', 'List contents templates')!!}</li>
					         	</ul>
					      </li>
			            </ul>
		           </li>
               		<li class="dropdown" style='margin-top:40px'>
                    	<a href="#" class="dropdown-toggle" data-toggle="dropdown"><span class='glyphicon glyphicon-file'></span>Pages<b class="caret"></b></a>
			               <ul class="dropdown-menu">
			                   <li>{!! HTML::link('/admin/pages/form', 'Add new pages')!!}</li>
				           	    <li class="divider"></li>
				            	<li>{!! HTML::link('/admin/routes/user', 'List Pages')!!}</li>
				         	</ul>
               		</li>
               		<li class="dropdown" style='margin-top:40px'>
               			<a href="#" class="dropdown-toggle" data-toggle="dropdown"><span class='glyphicon glyphicon-edit'></span>Layout<b class="caret"></b></a>
			               <ul class="dropdown-menu">
			                   <li>{!! HTML::link('/admin/layout', 'Configure your layout')!!}</li>
				           	    <li class="divider"></li>
				            	<li>{!! HTML::link('/admin/layout/list', 'List Layouts')!!}</li>
				         	</ul>
               		</li>
               		 <li class="dropdown" style='margin-top:40px'>
                    	<!--  <a href="../filemanager/index.html" class="dropdown-toggle" data-toggle="dropdown">Files Manager<b class="caret"></b></a>-->
                    	<!--  {!! HTML::link('/admin/filemanager', 'Files Manager')!!}-->
                    	
                    	<a href={!! url('filemanager/index.html') !!} target="_blank"><span class='glyphicon glyphicon-open-file'></span>Files Manager</a>
               		</li>
          
            </ul>
       </div> 

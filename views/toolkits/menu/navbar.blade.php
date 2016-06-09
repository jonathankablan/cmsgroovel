  <!-- Navigation -->
    <nav class="navbar navbar-default navbar-custom navbar-fixed-top">
        <div class="container-fluid">
            
            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul id='Menu' class="menu nav navbar-nav"> 
                 @foreach ($menus as $menu)
                   @if($menu['layout']=='blog')
     	            {!!$menu['menu']!!}
     	           @endif
            	 @endforeach
                <li><a onclick='showModalPopUpContact()' href='#'>Contact</a> </li>	
	            <!-- /.navbar-collapse -->
	             @if(\Auth::user()!=null)
	            		<li class="dropdown user-dropdown">
	                       <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="glyphicon glyphicon-user"></i>
	                       @if(\Auth::user()!=null) {!!\Auth::user()->pseudo!!} @endif<b class="caret"></b></a>
	                       <ul class="dropdown-menu">
	                            <li><a href="{{ url('user/view/profile') }}">Settings</a></li>
	                            <li><a href="{{ url('messages/list') }}">Messages</a></li>                   
	                           @if (Auth::check())
	              				<li><a href="{{ url('/admin/auth/logout') }}">Log out</a></li>
	     					  @endif
	                       </ul>
	                   </li>
	                @elseif(\Auth::user()==null) 
	                   <li style='margin-left:400px'><a href="{{ url('admin') }}">Log in or Register</a></li>
	                @endif
	                
	                
	             	<li style='margin-left:50px'>
	                	<form  class="form-inline" role="form" id="languagechoice" name='languagechoice' method="post" action="">
	                	    {{csrf_field()}}
		                    <input type='hidden' name="language" id='lang' value=''>
	                	 
	                    	 <div class="form-group in-line">
							  <select class="form-control" name="lang_choice" id="lang_choice">
							      <option value= 'none' selected></option>
		                		  <option value= 'fr'>FRENCH</option>
		                		  <option value= 'gb'>ENGLISH</option>
		                		  <option value= 'us'>UNITED STATES</option>
							  </select>
							</div>
	                	</form>
	                </li>
	                
	           </ul>
            </div>
        </div>
              
    </nav>

  <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">            
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="#">Welcome @if(\Auth::user()!=null) {!!\Auth::user()->pseudo!!} @endif</a>
            </div>
            <div class="collapse navbar-collapse navbar-ex1-collapse" style='color:#00FF00'>
                
         	  <ul class="nav navbar-nav navbar-right navbar-user">
                    <li class="dropdown user-dropdown">
                       <a href="#" class="dropdown-toggle" data-toggle="dropdown"  style='margin-right:50px'>
                        @if(\Auth::user()!=null) 
	                        @if( \Auth::user()->picture==null)
	                       		<i class="glyphicon glyphicon-user"></i>
	                        @else
	                       	<img src="/{{\Auth::user()->picture}}" alt="user" class="img-circle" style='width:20%;height:20%'>
	                        @endif
                        @endif 
                        @if(\Auth::user()!=null) {!!\Auth::user()->pseudo!!} @endif<b class="caret"></b></a>
                       <ul class="dropdown-menu">
                            <li>{!! HTML::link('user/view/profile', 'Settings')!!}</li>
                            <li class="divider"></li>
                            <li>   {!! HTML::link('/messages/list', 'Messages')!!}</li>                    
                           <li class="divider"></li>
     					  <li>{!! HTML::link('/forums/view', 'Forums')!!}</li>
     					  <li class="divider"></li>
     					  <li>{!! HTML::link('/blogs', 'Blog')!!}</li>
     					   <li class="divider"></li>
                          @if (Auth::check())
              				<li>{!! link_to('admin/auth/logout', 'Log out') !!}</li>
     					@endif
     					
                       </ul>
                   </li>
                  
            </div>
          
        </nav>
                    
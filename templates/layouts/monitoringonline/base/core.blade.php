<!DOCTYPE html>
<html>
    <head>
        @include('monitoringonline.includes.head')
    </head>
<body>
    <!-- menubar -->
    <header>
    <div class="container">
        @include('monitoringonline.includes.header')
       </div>
    </header><!-- /header -->
 
    <!-- content -->
    <div class="page-content">
    	<div class="row">
		 <div class="col-md-2">
		  	<div class="sidebar content-box" style="display: block;">
                <ul class="nav">
                    <!-- Main menu -->
                    <li><a href="#"><i class="glyphicon glyphicon-home"></i> Dashboard</a></li>
                    <li class="#"><a href="stats.html"><i class="glyphicon glyphicon-stats"></i> Statistics (Charts)</a></li>
                    <li><a href="#"><i class="glyphicon glyphicon-list"></i> Alerts</a></li>
                    <li><a href="#"><i class="glyphicon glyphicon-record"></i> Logs</a></li>
                     <li class="submenu">
                         <a href="#">
                            <i class="glyphicon glyphicon-list"></i> Pages
                            <span class="caret pull-right"></span>
                         </a>
                         <!-- Sub menu -->
                         <ul>
                            <li><a href="login.html">Login</a></li>
                            <li><a href="signup.html">Signup</a></li>
                        </ul>
                    </li>
                </ul>
             </div>
		  </div>
		  <div class="col-md-10">

  			<div class="content-box-large">
  				<div class="panel-heading">
					<div class="panel-title">Morris.js Stacked</div>
					
					<div class="panel-options">
						<a href="#" data-rel="collapse"><i class="glyphicon glyphicon-refresh"></i></a>
						<a href="#" data-rel="reload"><i class="glyphicon glyphicon-cog"></i></a>
					</div>
				</div>
  				<div class="panel-body">
  					<div id="hero-area" style="height: 230px;"></div>
  				</div>
  			</div>

  			<div class="content-box-large">
  				<div class="panel-heading">
					<div class="panel-title">Morris.js Monthly growth</div>
					
					<div class="panel-options">
						<a href="#" data-rel="collapse"><i class="glyphicon glyphicon-refresh"></i></a>
						<a href="#" data-rel="reload"><i class="glyphicon glyphicon-cog"></i></a>
					</div>
				</div>
  				<div class="panel-body">
  					<div id="hero-graph" style="height: 230px;"></div>
  				</div>
  			</div>

  			</div>
    </div>
   
 
    <!-- footer -->
    <footer>
        @include('monitoringonline.includes.footer')
    </footer>

  
  {!! HTML::script('monitoringonline/styles/vendors/morris/morris.min.js')!!}
    
    {!! HTML::script('monitoringonline/styles/js/custom.js')!!}
    {!! HTML::script('monitoringonline/styles/js/stats.js')!!}
</body>
</html>
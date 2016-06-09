@extends('cmsgroovel.layouts.groovel_admin_route')
@section('content')
	     <div style="margin-top:70px">
       	@if(Session::get('messages'))
             <div>{!!var_dump(Session::get('messages'))!!}</div>
        @endif
       	<div  id="routes" style='margin-top:50px'>
	                <div class="row">
	                    <div class="panel  panel-default">
	                        <div class="panel-heading">
	                            <h3 class="panel-title"><i class="fa fa-bar-chart-o"></i> Pages</h3>
	                        </div>
	                       
						  	 <div class="panel-body col-xs-7 col-sm-8 col-md-10">
		                         <div class='row' style='margin-bottom: 10px' >
			                         	<div class="col-md-2 col-sm-2 col-xs-2  hidden-xs">  
				                        	<input class="search" placeholder="Search" style="height:30px" />
				                        </div>
				                        <div class="col-md-4 col-md-offset-1 col-sm-8 col-sm-offset-1 hidden-xs hidden-sm"> 
									  		<button class="sort" data-sort="name" style="height:30px">
									    		Sort by name
									  		</button>
									  	</div>
									  	<div class="col-md-2 col-md-offset-0 col-sm-3 col-xs-2  col-xs-offset-6">      
			            						<a class="btn btn-default" href="{{ url('/admin/pages/form') }}">Add page</a>
										</div>
							  		</div>
						  	</div>
						  	
	                           <table class="table table-hover table-striped table-bordered table-responsive"  id="table_routes">
				                      <thead>
				                        <tr>
				                          <th id="col_route" class="col-md-1 hidden-xs hidden-md hidden-sm hidden-lg">id</th>
				                          <th id="col_route" class="col-xs-1 col-sm-1">uri</th>
				                          <th id="col_route" class="col-xs-1 col-sm-1 hidden-xs hidden-sm">name</th>
				                            <th id="col_route" class="col-xs-1 col-sm-1 hidden-xs hidden-sm">page</th>
				                          </tr>
				                      </thead>
				                      <tbody  class="list">
				                       @foreach ($routesAll as $route)
				                          <tr id="rows_routes">
				                            <td id="row_route" class="col-md-1 hidden-xs hidden-md hidden-sm hidden-lg">{!!$route->id!!}</td>
				                            <td id="row_route" class="uri col-xs-1 col-sm-1">{!!$route->uri!!}</td>
				                            <td id="row_route" class="name col-xs-1 col-sm-1 hidden-xs hidden-sm">{!!$route->name!!}</td>
				                            <td id="row_route" class="view col-xs-1 col-sm-1 hidden-xs hidden-sm">{!!$route->view!!}</td>
				                              
				                             <td id="edit" class='col-sm-1 col-xs-1 col-lg-1'>
					                            	<span id='editButton' class="glyphicon glyphicon-pencil btnEditRoute" aria-hidden="true"></span>
					                          </td>
				                            <td id="del" class="col-sm-1 col-lg-1 col-xs-1">
				                              	<span id='deleteButton' class="glyphicon glyphicon-trash btnDeleteRoute" aria-hidden="true"></span>
				                             </td> 
				                          </tr>
				                          @endforeach
				                        </tbody>
				                    </table>
          							  <ul class="pagination">
						                {!! $routesAll->render() !!}
	               					 </ul>
	                     </div>
	                </div>
				</div>
      </div>    
          
 <script>
 var options = {
  valueNames: [ 'name','uri','view']
};

var routesList = new List('routes', options);
 </script>                 


@stop
@extends('cmsgroovel.layouts.groovel_admin_route')
@section('content')
	  <div class="col-md-12" style="margin-top:50px">
       	@if(Session::get('messages'))
             <div>{!!var_dump(Session::get('messages'))!!}</div>
        @endif
       	<div class="table-responsive scrollable" id="routes" style='margin-top:50px'>
	                <div class="col-md-12">
	                    <div class="panel  panel-default">
	                        <div class="panel-heading">
	                            <h3 class="panel-title"><i class="fa fa-bar-chart-o"></i> Routes System</h3>
	                        </div>
	                        <div class="panel-body">
	                        	<div class='rows' style='margin-bottom: 10px' > 
		                        	<div class="col-md-2">  
		                           		<input class="search" placeholder="Search" style="height:30px" />
		                           	</div>
		                        	 <div class="col-md-2">  
								  		<button class="sort" data-sort="name" style="height:30px">
								    		Sort by name
								  		</button>
							  		</div>
							  		  <div class="col-md-2">      
            							{!! HTML::link('/admin/routes/form', 'Add route',array('class' => 'btn btn-default'))!!}
         							 </div>
        				  		</div>
						  	</div>
	                             	 <table class="table table-striped table-hover table-bordered"  id="table_routes">
				                      <thead>
				                        <tr>
				                          <th id="col_route" class="col-md-1">id</th>
				                          <th id="col_route" class="col-md-1">uri</th>
				                          <th id="col_route" class="col-md-1">name</th>
				                            <th id="col_route" class="col-md-1">view</th>
				                          </tr>
				                      </thead>
				                      <tbody  class="list">
				                       @foreach ($routesAll as $route)
				                          <tr id="rows_routes">
				                            <td id="row_route" class="col-md-1">{!!$route->id!!}</td>
				                            <td id="row_route" class="uri col-md-1">{!!$route->uri!!}</td>
				                            <td id="row_route" class="name col-md-1">{!!$route->name!!}</td>
				                            <td id="row_route" class="view col-md-1">{!!$route->view!!}</td>
				                           <td id="del" class="col-md-1">
				                           {!! HTML::image('packages/groovel/cmsgroovel/groovel/admin/images/del.png', $alt="del", $attributes = array('id' => 'deleteButton','style'=>'width:20px;height:20px','class'=>'btnDeleteRoute')) !!}
				                            </td>
				                             <td id="edit" class="col-md-1">
					                           {!! HTML::image('packages/groovel/cmsgroovel/groovel/admin/images/edit.jpg', $alt="edit", $attributes = array('id' => 'editButton','style'=>'width:20px;height:20px','class'=>'btnEditRoute')) !!}
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
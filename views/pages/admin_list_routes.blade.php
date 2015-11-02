@extends('cmsgroovel.layouts.groovel_admin_default')
@section('content')
	  <div class="col-md-12">
       	@if(Session::get('messages'))
             <div>{!!var_dump(Session::get('messages'))!!}</div>
        @endif
       
        <h1 class="page-header">Configure routes</h1>
      
          <div class="span2">      
            {!! HTML::link('/admin/routes/form', 'Add route',array('class' => 'btn btn-default'))!!}
            <!-- {!! HTML::link('/admin/routes/refresh', 'Refresh cache routes',array('class' => 'btn btn-default'))!!}-->
          </div>
         
      
 			<div class="row" id="routes">
	                <div class="col-lg-12">
	                    <div class="panel panel-primary">
	                        <div class="panel-heading">
	                            <h3 class="panel-title"><i class="fa fa-bar-chart-o"></i> Routes System</h3>
	                        </div>
	                        <div class="panel-body">
	                        	<div style='margin-bottom: 10px' >
		                        	<input class="search" placeholder="Search" style="height:30px" />
							  		<button class="sort" data-sort="name" style="height:30px">
							    		Sort by name
							  		</button>
						  		</div>
	                             	 <table class="table table-hover table-bordered"  id="table_routes">
				                      <thead>
				                        <tr>
				                          <th id="col_route" class="col-md-1">id</th>
				                          <th id="col_route" class="col-md-1">uri</th>
				                          <th id="col_route" class="col-md-1">name</th>
				                            <th id="col_route" class="col-md-1">view</th>
				                        <!--  <th id="col_route" class="col-md-1">controller</th>
				                          <th id="col_route" class="col-md-1">method</th>
				                          <th id="col_route" class="col-md-1">action</th>
				                          <th id="col_route" class="col-md-1">view</th>
				                        <th id="col_route" class="col-md-1">before_filter</th>
				                        <th id="col_route" class="col-md-1">after_filter</th>
				                          <th id="col_route" class="col-md-1">type</th>-->
				                       
				                        </tr>
				                      </thead>
				                      <tbody  class="list">
				                       @foreach ($routesAll as $route)
				                          <tr id="rows_routes">
				                            <td id="row_route" class="col-md-1">{!!$route->id!!}</td>
				                            <td id="row_route" class="uri">{!!$route->uri!!}</td>
				                            <td id="row_route" class="name">{!!$route->name!!}</td>
				                            <td id="row_route" class="view">{!!$route->view!!}</td>
				                           <!--  <td id="row_route" class="col-md-1">{!!$route->controller!!}</td>
				                            <td id="row_route" class="col-md-1">{!!$route->method!!}</td>
				                            <td id="row_route" class="col-md-1">{!!$route->action!!}</td>
				                            <td id="row_route" class="col-md-1">{!!$route->view!!}</td>
				                          <td id="row_route" class="col-md-1">{!!$route->before_filter!!}</td>
				                          <td id="row_route" class="col-md-1">{!!$route->after_filter!!}</td>
				                            <td id="row_route" class="col-md-1">{!!$route->type!!}</td>-->
				                            <td id="save">
				                            {!! HTML::image('packages/groovel/cmsgroovel/groovel/admin/images/save.png', $alt="save", $attributes = array('id' => 'editButton','style'=>'width:20px;height:20px','class'=>'btnSaveRoute')) !!}
				                            <!--<img src='../../public/theme-admin/images/save.png' class='btnSave' style="width:20px;height:20px">-->
				                            </td>
				                            <td id="del">
				                            <!--<img src='../../public/theme-admin/images/del.png' class='btnDelete' style="width:20px;height:20px">-->
				                            {!! HTML::image('packages/groovel/cmsgroovel/groovel/admin/images/del.png', $alt="del", $attributes = array('id' => 'deleteButton','style'=>'width:20px;height:20px','class'=>'btnDeleteRoute')) !!}
				                            </td>
				                             <td id="edit">
					                           {!! HTML::image('packages/groovel/cmsgroovel/groovel/admin/images/edit.jpg', $alt="edit", $attributes = array('id' => 'editButton','style'=>'width:20px;height:20px','class'=>'btnEditRoute')) !!}
					                           <!--<img src='../../public/theme-admin/images/save.png' class='btnSave' style="width:20px;height:20px">-->
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
      </div>    
          
 <script>
 var options = {
  valueNames: [ 'name','uri','view']
};

var routesList = new List('routes', options);
 </script>                 


@stop
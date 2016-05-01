@extends('cmsgroovel.layouts.groovel_admin_menu')
@section('content')
	  <div style="margin-top:70px">
	       	@if(Session::get('messages'))
	             <div>{!!var_dump(Session::get('messages'))!!}</div>
	        @endif
	        
	           <div id='menus'>
	                <div class="row">
	                    <div class="panel panel-default">
	                        <div class="panel-heading">
	                            <h3 class="panel-title"><i class="fa fa-bar-chart-o"></i> Menu</h3>
	                        </div>
	                        <div class="panel-body col-xs-7 col-sm-10 col-md-10">
		                  	  		 <div class='row' style='margin-bottom: 10px' >
			                         	<div class="col-md-2 col-sm-3 col-xs-2  hidden-xs">  
				                        	<input class="search" placeholder="Search" style="height:30px" />
				                        </div>
				                        <div class="col-md-4 col-md-offset-1 col-sm-8 col-sm-offset-1 hidden-xs hidden-sm"> 
									  		<button class="sort" data-sort="name" style="height:30px">
									    		Sort by name
									  		</button>
									  	</div>
									  	<div class="col-md-2 col-md-offset-0 col-sm-4 col-xs-2  col-xs-offset-6">      
			            						{!! HTML::link('/admin/menu/create', 'Add new menu',array('class' => 'btn btn-default'))!!}
			          					</div>
							  		</div>
						  	</div>
	            				<table class="table table-hover table-striped table-bordered table-responsive" id="table_menus">
										<thead>
											 <tr>
					                          <th id="col_menu" class="col-xs-1 col-sm-1 hidden-xs hidden-sm">id</th>
					                          <th id="col_menu" class="col-xs-1 col-sm-1">name</th>
					                          <th id="col_menu" class="col-xs-1 col-sm-1">layout</th>
					                          <th id="col_menu" class="col-xs-1 col-sm-1">langage</th>
					                          <th id="col_menu" class="col-xs-1 col-sm-1 hidden-xs hidden-sm">created</th>
					                          <th id="col_menu" class="col-xs-1 col-sm-1 hidden-xs hidden-sm">updated</th>
					           				</tr>
										</thead>
										<tbody class="list">
										 	 @foreach ($menus as $menu)
									              <tr id="rows_menus">
						                            <td id="row_menu"  class="col-xs-1 col-sm-1 hidden-xs hidden-sm">{!!$menu->id!!}</td>
						                            <td id="row_menu" class="col-xs-1 col-sm-1">{!!$menu->name!!}</td>
						                             <td id="row_menu" class="col-xs-1 col-sm-1">{!!$menu->layout!!}</td>
						                            <td id="row_menu" class='name col-xs-1 col-sm-1'>{!!$menu->lang!!}</td>
						                            <td id="row_menu" class="col-xs-1 col-sm-1 hidden-xs hidden-sm">{!!$menu->created_at!!}</td>
						                            <td id="row_menu" class="col-xs-1 col-sm-1 hidden-xs hidden-sm">{!!$menu->updated_at!!}</td>
						                            <td id="edit" class='col-sm-4 col-xs-1 col-lg-1'>
						                            	<span id='editButton' class="glyphicon glyphicon-pencil btnEditMenu" aria-hidden="true"></span>
						                            </td>
						                            <td id="del" class="col-sm-4 col-lg-1 col-xs-1">
						                              	<span id='deleteButton' class="glyphicon glyphicon-trash btnDeleteMenu" aria-hidden="true"></span>
						                             </td> 
						                           </tr>
					                          @endforeach
          								</tbody>
          							</table>
          							  <ul class="pagination">
						                {!! $menus->render() !!}
	               					 </ul>
	                          </div>
	                	</div>
 					</div>
 	   		 </div>
    <script>
 var options = {
  valueNames: [ 'name']
};

var usersList = new List('menus', options);
 </script>  

@stop
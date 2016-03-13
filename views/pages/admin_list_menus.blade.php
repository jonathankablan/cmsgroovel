@extends('cmsgroovel.layouts.groovel_admin_menu')
@section('content')
	  <div class="col-md-12" style="margin-top:70px">
	       	@if(Session::get('messages'))
	             <div>{!!var_dump(Session::get('messages'))!!}</div>
	        @endif
	        
	           <div class="table-responsive scrollable" id='contents'>
	                <div class="col-md-12">
	                    <div class="panel panel-default">
	                        <div class="panel-heading">
	                            <h3 class="panel-title"><i class="fa fa-bar-chart-o"></i> Menu</h3>
	                        </div>
	                        <div class="panel-body">
		                         <div class='row' style='margin-bottom: 10px' >
			                         	<div class="col-md-2">  
				                        	<input class="search" placeholder="Search" style="height:30px" />
				                        </div>
				                        <div class="col-md-2"> 
									  		<button class="sort" data-sort="name" style="height:30px">
									    		Sort by name
									  		</button>
									  	</div>
									  	<div class="col-md-2">      
			            						{!! HTML::link('/admin/menu/create', 'Add new menu',array('class' => 'btn btn-default'))!!}
			          					</div>
							  		</div>
						  	</div>
	            				<table class="table table-striped table-hover table-bordered" id="table_menus">
										<thead>
											 <tr>
					                          <th id="col_menu" class="col-md-1">id</th>
					                          <th id="col_menu" class="col-md-1">name</th>
					                          <th id="col_menu" class="col-md-1">layout</th>
					                          <th id="col_menu" class="col-md-1">langage</th>
					                          <th id="col_menu" class="col-md-1">created</th>
					                          <th id="col_menu" class="col-md-1">updated</th>
					           				</tr>
										</thead>
										<tbody class="list">
										 	 @foreach ($menus as $menu)
									              <tr id="rows_menus">
						                            <td id="row_menu"  class="col-md-1">{!!$menu->id!!}</td>
						                            <td id="row_menu" class="col-md-1">{!!$menu->name!!}</td>
						                             <td id="row_menu" class="col-md-1">{!!$menu->layout!!}</td>
						                            <td id="row_menu" class='name col-md-1'>{!!$menu->lang!!}</td>
						                            <td id="row_menu" class="col-md-1">{!!$menu->created_at!!}</td>
						                            <td id="row_menu" class="col-md-1">{!!$menu->updated_at!!}</td>
						                            <td id="edit" class="col-md-1">
						                            {!! HTML::image('groovel/cmsgroovel/groovel/admin/images/edit.jpg', $alt="edit", $attributes = array('id' => 'editButton','style'=>'width:20px;height:20px','class'=>'btnEditMenu')) !!}
						                            </td>
						                            <td id="del" class="col-md-1">
						                            {!! HTML::image('groovel/cmsgroovel/groovel/admin/images/del.png', $alt="del", $attributes = array('id' => 'deleteButton','style'=>'width:20px;height:20px','class'=>'btnDeleteMenu')) !!}
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
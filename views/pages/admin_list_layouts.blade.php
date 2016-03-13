@extends('cmsgroovel.layouts.groovel_admin_layout')
@section('content')
	  <div class="col-md-12" style="margin-top:70px">
	       	@if(Session::get('messages'))
	             <div>{!!var_dump(Session::get('messages'))!!}</div>
	        @endif
	        
	           <div class="table-responsive scrollable" id='layouts'>
	                <div class="col-md-12">
	                    <div class="panel panel-default">
	                        <div class="panel-heading">
	                            <h3 class="panel-title"><i class="fa fa-bar-chart-o"></i> Layout</h3>
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
							  		</div>
						  	</div>
	            				<table class="table table-striped table-hover table-bordered" id="table_layouts">
										<thead>
											 <tr>
					                          <th id="col_layout" class="col-md-1">id</th>
					                          <th id="col_layout" class="col-md-1">name</th>
					                          <th id="col_layout" class="col-md-1">type</th>
					                          <th id="col_layout" class="col-md-1">langage</th>
					                          <th id="col_layout" class="col-md-1">created</th>
					                          <th id="col_layout" class="col-md-1">updated</th>
					           				</tr>
										</thead>
										<tbody class="list">
										 	 @foreach ($layouts as $layout)
									              <tr id="rows_layouts">
						                            <td id="row_layout"  class="col-md-1">{!!$layout->id!!}</td>
						                            <td id="row_layout" class="col-md-1">{!!$layout->title!!}</td>
						                            <td id="row_layout" class="col-md-1">{!!$layout->layout!!}</td>
						                            <td id="row_layout" class='name col-md-1'>{!!$layout->lang!!}</td>
						                            <td id="row_layout" class="col-md-1">{!!$layout->created_at!!}</td>
						                            <td id="row_layout" class="col-md-1">{!!$layout->updated_at!!}</td>
						                            <td id="edit" class="col-md-1">
						                            {!! HTML::image('groovel/cmsgroovel/groovel/admin/images/edit.jpg', $alt="edit", $attributes = array('id' => 'editButton','style'=>'width:20px;height:20px','class'=>'btnEditLayout')) !!}
						                            </td>
						                            <td id="del" class="col-md-1">
						                            {!! HTML::image('groovel/cmsgroovel/groovel/admin/images/del.png', $alt="del", $attributes = array('id' => 'deleteButton','style'=>'width:20px;height:20px','class'=>'btnDeleteLayout')) !!}
						                            </td>
						                           </tr>
					                          @endforeach
          								</tbody>
          							</table>
          							  <ul class="pagination">
						                {!! $layouts->render() !!}
	               					 </ul>
	                          </div>
	                	</div>
 					</div>
 	   		 </div>
    <script>
 var options = {
  valueNames: [ 'name']
};

var usersList = new List('layouts', options);
 </script>  

@stop
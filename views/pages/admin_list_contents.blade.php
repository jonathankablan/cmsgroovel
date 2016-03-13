@extends('cmsgroovel.layouts.groovel_admin_content')
@section('content')
	  <div class="col-md-12" style="margin-top:70px">
	       	@if(Session::get('messages'))
	             <div>{!!var_dump(Session::get('messages'))!!}</div>
	        @endif
	        
	           <div class="table-responsive scrollable" id='contents'>
	                <div class="col-md-12">
	                    <div class="panel panel-default">
	                        <div class="panel-heading">
	                            <h3 class="panel-title"><i class="fa fa-bar-chart-o"></i> Contents Data</h3>
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
			            						{!! HTML::link('/admin/content/form', 'Add new content',array('class' => 'btn btn-default'))!!}
			          					</div>
							  		</div>
						  	</div>
	            				<table class="table table-striped table-hover table-bordered" id="table_contents">
										<thead>
											 <tr>
					                          <th id="col_content" class="col-md-1">id</th>
					                          <th id="col_content" class="col-md-1">translation_id</th>
					                          <th id="col_content" class="col-md-1">title</th>
					                          <th id="col_content" class="col-md-1" style='display:none'>description</th>
					                          <th id="col_content" class="col-md-1">type</th>
					                          <th id="col_content" class="col-md-1">author</th>
					                          <th id="col_content" class="col-md-1">published</th>
					                          <th id="col_content" class="col-md-1">weight</th>
					                          <th id="col_content" class="col-md-1">langage</th>
					                          <th id="col_content" class="col-md-1">date creation</th>
					                          <th id="col_content" class="col-md-1">last update</th>
					                        
                        					</tr>
										</thead>
										<tbody class="list">
										 	 @foreach ($contents as $content)
									              <tr id="rows_contents">
						                            <td id="row_content"  class="col-md-1">{!!$content->content_id!!}</td>
						                            <td id="row_content" class="col-md-1">{!!$content->translation_id!!}</td>
						                            <td id="row_content" class='name col-md-1'>{!!$content->name!!}</td>
						                            <td id="row_content" class="col-md-1"  style='display:none'>{!!$content->description!!}</td>
						                            <td id="row_content" class="col-md-1">{!!$content->type!!}</td>
						                            <td id="row_content" class="col-md-1">{!!$content->author!!}</td>
						                             <?php if($content->ispublish==1) :?>
						                              <td id="row_content" class="col-md-1">yes</td>
						                            <?php endif; ?>
						                             <?php if($content->ispublish==0) :?>
						                                 <td id="row_content" class="col-md-1">no</td>
						                             <?php endif; ?>
						                            <td id="row_content" class="col-md-1">{!!$content->weight!!}</td>
						                            <td id="row_content" class="col-md-1">{!!$content->lang!!}</td>
						                             <td id="row_content" class="col-md-1">{!!$content->created_at!!}</td>
						                             <td id="row_content" class="col-md-1">{!!$content->updated_at!!}</td>
						                            <td id="edit" class="col-md-1">
						                            {!! HTML::image('groovel/cmsgroovel/groovel/admin/images/edit.jpg', $alt="edit", $attributes = array('id' => 'editButton','style'=>'width:20px;height:20px','class'=>'btnEditContent')) !!}
						                            </td>
						                            <td id="del" class="col-md-1">
						                            {!! HTML::image('groovel/cmsgroovel/groovel/admin/images/del.png', $alt="del", $attributes = array('id' => 'deleteButton','style'=>'width:20px;height:20px','class'=>'btnDeleteContent')) !!}
						                            </td>
						                             <td id="translate" class="col-md-1">
						                            <button id="dump" class="btn btn-success btnTranslateContent">translate in a new langage</button>
						                            </td>
					                            </tr>
					                          @endforeach
          								</tbody>
          							</table>
          							  <ul class="pagination">
						                {!! $contents->render() !!}
	               					 </ul>
	                          </div>
	                	</div>
 					</div>
 	   		 </div>
    <script>
 var options = {
  valueNames: [ 'name']
};

var usersList = new List('contents', options);
 </script>  

@stop
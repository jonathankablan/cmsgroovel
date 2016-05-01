@extends('cmsgroovel.layouts.groovel_admin_content')
@section('content')
	        <div style="margin-top:70px">
	        	   	@if(Session::get('messages'))
	             		<div>{!!var_dump(Session::get('messages'))!!}</div>
	        		@endif
	          <div id='mycontents'>
	                <div class="row">
	                    <div class="panel panel-default">
	                        <div class="panel-heading">
	                            <h3 class="panel-title"><i class="fa fa-bar-chart-o"></i> Contents Data</h3>
	                        </div>
	                        <div class="panel-body col-xs-7 col-sm-10 col-md-10">
		                         <div class='row' style='margin-bottom: 10px' >
			                         	<div class="col-md-2 col-sm-3 col-xs-2  hidden-xs">  
				                        	<input class="search" placeholder="Search" style="height:30px" />
				                        </div>
				                        <div class="col-md-4 col-md-offset-1 col-sm-4 col-sm-offset-1 hidden-xs hidden-sm"> 
									  		<button class="sort" data-sort="name" style="height:30px">
									    		Sort by name
									  		</button>
									  	</div>
									  	<div class="col-md-2 col-md-offset-0 col-sm-3 col-xs-2  col-xs-offset-6">      
			            						{!! HTML::link('/admin/content/form', 'Add new content',array('class' => 'btn btn-default'))!!}
			          					</div>
							  		</div>
						  	</div>
					  		<table class="table table-hover table-striped table-bordered table-responsive" id="table_contents">
										<thead>
											 <tr>
					                          <th id="col_content" class="col-md-1 hidden-xs hidden-md hidden-sm hidden-lg">id</th>
					                          <th id="col_content" class="col-md-1 hidden-xs hidden-md hidden-sm hidden-lg">translation_id</th>
					                          <th id="col_content" class=" name col-xs-1 col-sm-1">name</th>
					                          <th id="col_content" class="col-xs-1 col-sm-1" style='display:none'>description</th>
					                          <th id="col_content" class="col-xs-1 col-sm-1 hidden-xs">type</th>
					                          <th id="col_content" class="col-xs-1 col-sm-1 hidden-xs hidden-md hidden-sm">author</th>
					                          <th id="col_content" class="col-xs-1 col-sm-1 hidden-xs">published</th>
					                          <th id="col_content" class="col-xs-1 col-sm-1 hidden-xs hidden-md hidden-sm">weight</th>
					                          <th id="col_content" class="col-xs-1 col-sm-1 hidden-xs hidden-sm">langage</th>
					                          <th id="col_content" class="col-xs-1 col-sm-1 hidden-xs hidden-md hidden-sm">date creation</th>
					                          <th id="col_content" class="col-xs-1 col-sm-1 hidden-xs hidden-md hidden-sm">last update</th>
					                        
                        					</tr>
										</thead>
										<tbody class='list'>
										 	 @foreach ($contents as $content)
									              <tr id="rows_contents">
						                            <td id="row_content"  class="col-md-1 hidden-xs hidden-md hidden-sm hidden-lg">{!!$content->content_id!!}</td>
						                            <td id="row_content" class="col-md-1 hidden-xs hidden-md hidden-sm hidden-lg">{!!$content->translation_id!!}</td>
						                            <td id="row_content" class='name col-sm-2 col-xs-1'>{!!$content->name!!}</td>
						                            <td id="row_content" class="col-sm-2 col-xs-1"  style='display:none'>{!!$content->description!!}</td>
						                            <td id="row_content" class="col-sm-2 col-xs-1 hidden-xs">{!!$content->type!!}</td>
						                            <td id="row_content" class="col-sm-2 col-xs-1 hidden-xs hidden-md hidden-sm">{!!$content->author!!}</td>
						                             <?php if($content->ispublish==1) :?>
						                              <td id="row_content" class="col-md-1 col-xs-1 hidden-xs">yes</td>
						                            <?php endif; ?>
						                             <?php if($content->ispublish==0) :?>
						                                 <td id="row_content" class="col-md-1 col-xs-1 hidden-xs">no</td>
						                             <?php endif; ?>
						                            <td id="row_content" class="col-sm-1 col-xs-1 hidden-xs hidden-md hidden-sm">{!!$content->weight!!}</td>
						                            <td id="row_content" class="col-sm-1 col-xs-1 hidden-xs hidden-sm">{!!$content->lang!!}</td>
						                             <td id="row_content" class="col-sm-2 col-xs-1 hidden-xs hidden-md hidden-sm">{!!$content->created_at!!}</td>
						                             <td id="row_content" class="col-sm-2 col-xs-1 hidden-xs hidden-md hidden-sm">{!!$content->updated_at!!}</td>
						                             
						                             <td id="edit" class='col-sm-4 col-xs-1 col-lg-1'>
						                            	<span id='editButton' class="glyphicon glyphicon-pencil btnEditContent" aria-hidden="true"></span>
						                            </td>
						                            <td id="del" class="col-sm-4 col-lg-1 col-xs-1">
						                              	<span id='deleteButton' class="glyphicon glyphicon-trash btnDeleteContent" aria-hidden="true"></span>
						                             </td> 
						                             <td id="translate" class="col-sm-4 col-lg-1 col-xs-1">
						                            <button id="dump" class="btn btn-success btnTranslateContent">translate</button>
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

var usersList = new List('mycontents', options);
  
 </script>  

@stop
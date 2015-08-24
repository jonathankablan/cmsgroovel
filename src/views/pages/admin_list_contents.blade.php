@extends('cmsgroovel::layouts.groovel_admin_default')
@section('content')
	 <div class="col-md-12 col-md-offset-2">
	       	@if(Session::get('messages'))
	             <div>{{var_dump(Session::get('messages'))}}</div>
	        @endif
	        <h2>Contents Board</h2>
	          <div class="span2">      
	            {{ HTML::link('/admin/content/form', 'Add new content',array('class' => 'btn btn-default'))}}
	          </div>
	           <div class="row" id='contents'>
	                <div class="col-lg-12">
	                    <div class="panel panel-primary">
	                        <div class="panel-heading">
	                            <h3 class="panel-title"><i class="fa fa-bar-chart-o"></i> Contents Data</h3>
	                        </div>
	                        <div class="panel-body">
	                         <div style='margin-bottom: 10px' >
		                        	<input class="search" placeholder="Search" style="height:30px" />
							  		<button class="sort" data-sort="name" style="height:30px">
							    		Sort by name
							  		</button>
						  		</div>
	            				<table cellpadding="0" cellspacing="0" border="0" class="table table-hover table-striped table-bordered " id="table_contents">
										<thead>
											 <tr>
					                          <th id="col_content">id</th>
					                          <th id="col_content">title</th>
					                          <th id="col_content">type</th>
					                          <th id="col_content">url</th>
					                          <th id="col_content">author</th>
					                          <th id="col_content">published</th>
					                          <th id="col_content">ontop</th>
					                          <th id="col_content">date creation</th>
					                          <th id="col_content">last update</th>
					                        
                        					</tr>
										</thead>
										<tbody class='list'>
										 	 @foreach ($contents as $content)
					                            <tr id="rows_contents">
						                            <td id="row_content" >{{$content->id}}</td>
						                            <td id="row_content" class='name'>{{$content->name}}</td>
						                            <td id="row_content">{{$content->type['name']}}</td>
						                            <td id="row_content">{{$content->url}}</td>
						                            <td id="row_content">{{$content->author['pseudo']}}</td>
						                             <?php if($content->ispublish==1) :?>
						                              <td id="row_content">yes</td>
						                            <?php endif; ?>
						                             <?php if($content->ispublish==0) :?>
						                                 <td id="row_content">no</td>
						                             <?php endif; ?>
						                            <?php if($content->ontop==1) :?>
						                               <td id="row_content">yes</td>
						                            <?php endif; ?>
						                            <?php if($content->ontop==0) :?>
						                               <td id="row_content">no</td>
						                            <?php endif; ?>
						                             <td id="row_content">{{$content->created_at}}</td>
						                             <td id="row_content">{{$content->updated_at}}</td>
						                            <td id="edit">
						                            {{ HTML::image('packages/groovel/cmsgroovel/groovel/admin/images/edit.jpg', $alt="edit", $attributes = array('id' => 'editButton','style'=>'width:20px;height:20px','class'=>'btnEditContent')) }}
						                            <!--<img src='../../public/theme-admin/images/save.png' class='btnSave' style="width:20px;height:20px">-->
						                            </td>
						                            <td id="del">
						                            <!--<img src='../../public/theme-admin/images/del.png' class='btnDelete' style="width:20px;height:20px">-->
						                            {{ HTML::image('packages/groovel/cmsgroovel/groovel/admin/images/del.png', $alt="del", $attributes = array('id' => 'deleteButton','style'=>'width:20px;height:20px','class'=>'btnDeleteContent')) }}
						                            </td>
					                            </tr>
					                          @endforeach
          								</tbody>
          							</table>
          							  <ul class="pagination">
						                {{ $contents->links() }}
	               					 </ul>
	                          </div>
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
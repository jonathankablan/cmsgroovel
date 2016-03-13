@extends('cmsgroovel.layouts.groovel_admin_content_type')
@section('content')
	 <div class="col-md-12">
       	@if(Session::get('messages'))
             <div>{!!var_dump(Session::get('messages'))!!}</div>
        @endif
       
          <div class="span2">      
            {!! HTML::link('/admin/content_type/form', 'Add new content type',array('class' => 'btn btn-default'))!!}
          </div>
          <div class="table-responsive scrollable" id="contenttypes" style='margin-top:50px'>
                   <div class="col-md-12">
	                    <div class="panel panel-default">
	                        <div class="panel-heading">
	                            <h3 class="panel-title"><i class="fa fa-bar-chart-o"></i> Content Types Data</h3>
	                        </div>
	                        <div class="panel-body">
		                        <div style='margin-bottom: 10px' >
			                        	<input class="search" placeholder="Search" style="height:30px" />
								  		<button class="sort" data-sort="name" style="height:30px">
								    		Sort by name
								  		</button>
							  		</div>
							 </div>
	      						<table class="table table-striped table-hover table-bordered" id="table_contents">
										<thead>
											 <tr>
					                           <tr>
						                          <th id="col_content"  class="col-md-1">id</th>
						                          <th id="col_content"  class="col-md-1">title</th>
						                          <th id="col_content"  class="col-md-1">author</th>
						                          <th id="col_content"  class="col-md-1">date creation</th>
						                          <th id="col_content"  class="col-md-1">last update</th>
                        					</tr>
                        					</tr>
										</thead>
										<tbody aria-relevant="all" aria-live="polite" role="alert" class='list'><tr class="gradeA odd">
											 @foreach ($contentTypes as $content)
					                             <tr id="rows_contents">
					                            <td id="row_content"  class="col-md-1">{!!$content->id!!}</td>
					                            <td id="row_content" class='name col-md-1'>{!!$content->name!!}</td>
					                            <td id="row_content"  class="col-md-1">{!!$content->author['pseudo']!!}</td>
					                            <td id="row_content"  class="col-md-1">{!!$content->created_at!!}</td>
					                            <td id="row_content"  class="col-md-1">{!!$content->updated_at!!}</td>
					                            <td id="edit"  class="col-md-1">
					                            {!! HTML::image('groovel/cmsgroovel/groovel/admin/images/edit.jpg', $alt="edit", $attributes = array('id' => 'editButton','style'=>'width:20px;height:20px','class'=>'btnEditContentType')) !!}
					                            </td>
					                            <td id="del"  class="col-md-1">
					                            {!! HTML::image('groovel/cmsgroovel/groovel/admin/images/del.png', $alt="del", $attributes = array('id' => 'deleteButton','style'=>'width:20px;height:20px','class'=>'btnDeleteContentType')) !!}
					                            </td>
					                          </tr>
                         					 @endforeach
          								</tbody>
          							</table>
          							
          							  <ul class="pagination">
						                <ul class="pagination">
						                {!! $contentTypes->render() !!}
	               					 	</ul>
	               					 </ul>
	                    </div>
	                </div>
 				</div>
   
        </div>
       <script>
 var options = {
  valueNames: [ 'name']
};

var usersList = new List('contenttypes', options);
 </script>  

@stop
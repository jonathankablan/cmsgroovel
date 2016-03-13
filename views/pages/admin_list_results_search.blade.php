@extends('cmsgroovel.layouts.groovel_admin_search')
@section('content')
	  <div class="col-md-12" style="margin-top:70px">
	       	@if(Session::get('messages'))
	             <div>{!!var_dump(Session::get('messages'))!!}</div>
	        @endif
	        
	           <div class="table-responsive scrollable" id='contents'>
	                 <div class="col-md-12">
	                    	<table class="table table-striped table-hover table-bordered" id="table_contents">
										<thead>
											 <tr>
					                          <th id="col_content" class="col-md-1">refid</th>
					                          <th id="col_content" class="col-md-1">title</th>
					                          <th id="col_content" class="col-md-1">type</th>
					                          <th id="col_content" class="col-md-1">data</th>
					                          <th id="col_content" class="col-md-1">description</th>
					                          <th id="col_content" class="col-md-1">date creation</th>
					                          <th id="col_content" class="col-md-1">last update</th>
					                        
                        					</tr>
										</thead>
										<tbody class="list">
										    @if($results!=null)
										 	 @foreach ($results as $content)
										 	      <tr id="rows_contents">
						                             <td id="row_content" class="col-md-1">{!!$content['refid']!!}</td>
						                             <td id="row_content" class="col-md-1">{!!$content['title']!!}</td>
						                             <td id="row_content" class="col-md-1">{!!$content['type']!!}</td>
						                             <td id="row_content" class="col-md-1">{!!$content['data']!!}</td>
						                             <td id="row_content" class="col-md-1">{!!$content['description']!!}</td>
						                              <td id="row_content" class="col-md-1">{!!$content['created_at']!!}</td>
						                             <td id="row_content" class="col-md-1">{!!$content['updated_at']!!}</td>
						                             <td id="edit" class="col-md-1">
						                            {!! HTML::image('groovel/cmsgroovel/groovel/admin/images/edit.jpg', $alt="edit", $attributes = array('id' => 'editButton','style'=>'width:20px;height:20px','class'=>'btnSearch')) !!}
						                            </td>
						                           </tr>
					                          @endforeach
					                         @endif
          								</tbody>
          							</table>
          							   <ul class="pagination">
						                {!! $results->render() !!}
	               					 </ul>
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
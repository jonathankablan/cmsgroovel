@extends('cmsgroovel.layouts.groovel_admin_content_type')
@section('content')
	 <div style='margin-top:100px'>
       	@if(Session::get('messages'))
             <div>{!!var_dump(Session::get('messages'))!!}</div>
        @endif
       
         
          <div  id="contenttypes">
                   <div class="row">
	                    <div class="panel panel-default">
	                        <div class="panel-heading">
	                            <h3 class="panel-title"><i class="fa fa-bar-chart-o"></i> Content Types Data</h3>
	                        </div>
	                        <div class="panel-body col-xs-7 col-sm-8 col-md-10">
	                            <div class='row' style='margin-bottom: 10px' >
			                       <div class="col-md-4 col-sm-2 col-xs-2  hidden-xs">  
				                        	<input class="search" placeholder="Search" style="height:30px" />
									  		
									</div>
							         <div class="col-md-4 col-md-offset-1 col-sm-8 col-sm-offset-1 hidden-xs hidden-sm"> 
									  		<button class="sort" data-sort="name" style="height:30px">
									    		Sort by name
									  		</button>
									  </div>  		
								  	 <div class="col-md-2 col-md-offset-0 col-sm-3 col-xs-2  col-xs-offset-6">      
			            		        <a class="btn btn-default" href="{{ url('/admin/content_type/form') }}">Add new content type</a>
							         </div>
							     </div>
							 </div>
	      						<table class="table table-hover table-striped table-bordered table-responsive" id="table_contents">
										<thead>
											 <tr>
					                           <tr>
						                          <th id="col_content"  class="col-xs-1 col-sm-1 hidden-xs hidden-md hidden-sm">id</th>
						                          <th id="col_content"  class="col-xs-1 col-sm-1">title</th>
						                          <th id="col_content"  class="col-xs-1 col-sm-1 hidden-xs hidden-md hidden-sm" >author</th>
						                          <th id="col_content"  class="col-xs-1 col-sm-1 hidden-xs hidden-md hidden-sm">date creation</th>
						                          <th id="col_content"  class="col-xs-1 col-sm-1  hidden-xs hidden-md hidden-sm">last update</th>
                        					</tr>
                        					</tr>
										</thead>
										<tbody aria-relevant="all" aria-live="polite" role="alert" class='list'><tr class="gradeA odd">
											 @foreach ($contentTypes as $content)
					                             <tr id="rows_contents">
					                            <td id="row_content"  class="col-xs-1 col-sm-1 hidden-xs hidden-md hidden-sm">{!!$content->id!!}</td>
					                            <td id="row_content" class='name col-xs-1 col-sm-1'>{!!$content->name!!}</td>
					                            <td id="row_content"  class="col-xs-1 col-sm-1 hidden-xs hidden-md hidden-sm">{!!$content->author['pseudo']!!}</td>
					                            <td id="row_content"  class="col-xs-1 col-sm-1 hidden-xs hidden-md hidden-sm">{!!$content->created_at!!}</td>
					                            <td id="row_content"  class="col-xs-1 col-sm-1  hidden-xs hidden-md hidden-sm">{!!$content->updated_at!!}</td>
					                            
				                                 <td id="edit" class='col-sm-1 col-xs-1 col-lg-1'>
					                            	<span id='editButton' class="glyphicon glyphicon-pencil btnEditContentType" aria-hidden="true"></span>
					                            </td>
					                            <td id="del" class="col-sm-1 col-lg-1 col-xs-1">
					                              	<span id='deleteButton' class="glyphicon glyphicon-trash btnDeleteContentType" aria-hidden="true"></span>
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
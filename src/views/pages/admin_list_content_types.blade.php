@extends('cmsgroovel::layouts.groovel_admin_default')
@section('content')
	 <div class="col-md-12 col-md-offset-2">
       	@if(Session::get('messages'))
             <div>{{var_dump(Session::get('messages'))}}</div>
        @endif
       
         <h2>Content Types board</h2>
      
          <div class="span2">      
            {{ HTML::link('/admin/content_type/form', 'Add new content type',array('class' => 'btn btn-default'))}}
          </div>
          
            <div class="row" id='contenttypes'>
	                <div class="col-lg-12">
	                    <div class="panel panel-primary">
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
	            				<table cellpadding="0" cellspacing="0" border="0" class="table table-hover table-striped table-bordered" id="table_contents">
										<thead>
											 <tr>
					                           <tr>
						                          <th id="col_content">id</th>
						                          <th id="col_content">title</th>
						                          <th id="col_content">author</th>
						                          <th id="col_content">date creation</th>
						                          <th id="col_content">last update</th>
                        					</tr>
                        					</tr>
										</thead>
										<tbody aria-relevant="all" aria-live="polite" role="alert" class='list'><tr class="gradeA odd">
											 @foreach ($contentTypes as $content)
					                             <tr id="rows_contents">
					                            <td id="row_content">{{$content->id}}</td>
					                            <td id="row_content" class='name'>{{$content->name}}</td>
					                            <td id="row_content">{{$content->author['pseudo']}}</td>
					                            <td id="row_content">{{$content->created_at}}</td>
					                            <td id="row_content">{{$content->updated_at}}</td>
					                            <td id="edit">
					                            {{ HTML::image('packages/groovel/cmsgroovel/groovel/admin/images/edit.jpg', $alt="edit", $attributes = array('id' => 'editButton','style'=>'width:20px;height:20px','class'=>'btnEditContentType')) }}
					                            <!--<img src='../../public/theme-admin/images/save.png' class='btnSave' style="width:20px;height:20px">-->
					                            </td>
					                            <td id="del">
					                            <!--<img src='../../public/theme-admin/images/del.png' class='btnDelete' style="width:20px;height:20px">-->
					                            {{ HTML::image('packages/groovel/cmsgroovel/groovel/admin/images/del.png', $alt="del", $attributes = array('id' => 'deleteButton','style'=>'width:20px;height:20px','class'=>'btnDeleteContentType')) }}
					                            </td>
					                          </tr>
                         					 @endforeach
          								</tbody>
          							</table>
          							
          							  <ul class="pagination">
						                <ul class="pagination">
						                {{ $contentTypes->links() }}
	               					 	</ul>
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

var usersList = new List('contenttypes', options);
 </script>  

@stop
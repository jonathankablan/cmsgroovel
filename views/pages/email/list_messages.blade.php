@extends('cmsgroovel.layouts.groovel_admin_messages')
@section('content')
	 <div class="col-md-12" style="margin-top:70px">
	       	@if(Session::get('messages'))
	             <div>{!!var_dump(Session::get('messages'))!!}</div>
	        @endif
	           <div class="row" id='messages'>
	                <div class="col-lg-12">
	                    <div class="panel panel-default">
	                        <div class="panel-heading">
	                            <h3 class="panel-title"><i class="fa fa-bar-chart-o"></i> Messages</h3>
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
			            						{!! HTML::link('/messages/compose', 'Write Message',array('class' => 'btn btn-default'))!!}
			          					</div>
							  		</div>
							  	</div>
	            				<table class="table table-hover table-striped table-bordered " id="table_messages">
										<thead>
											 <tr>
					                          <th id="col_message">id</th>
					                          <th id="col_message">subject</th>
					                          <th id="col_message">author</th>
					                          <th id="col_message">received</th>
					              			</tr>
										</thead>
										<tbody class='list'>
											 @foreach ($messages as $message)
					                            <tr id="rows_messages">
						                            <td id="row_message" >{!!$message->id!!}</td>
						                            <td id="row_message" class='subject'>{!!$message->subject!!}</td>
						                            <td id="row_message">{!!$message->author!!}</td>
						                            <td id="row_message">{!!$message->created_at!!}</td>
						                            <td id="edit">
						                            {!! HTML::image('packages/groovel/cmsgroovel/groovel/admin/images/edit.jpg', $alt="edit", $attributes = array('id' => 'editButton','style'=>'width:20px;height:20px','class'=>'btnEditMessage')) !!}
						                            <!--<img src='../../public/theme-admin/images/save.png' class='btnSave' style="width:20px;height:20px">-->
						                            </td>
						                            <td id="del">
						                            <!--<img src='../../public/theme-admin/images/del.png' class='btnDelete' style="width:20px;height:20px">-->
						                            {!! HTML::image('packages/groovel/cmsgroovel/groovel/admin/images/del.png', $alt="del", $attributes = array('id' => 'deleteButton','style'=>'width:20px;height:20px','class'=>'btnDeleteMessage')) !!}
						                            </td>
					                            </tr>
					                          @endforeach
          								</tbody>
          							</table>
          							  <ul class="pagination">
						                {!! $messages->render() !!}
	               					 </ul>
	                    </div>
	                </div>
 				</div>
 				
	    </div>
    <script>
 var options = {
  valueNames: [ 'subject']
};

var usersList = new List('messages', options);
 </script>  

@stop
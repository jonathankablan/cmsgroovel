@extends('cmsgroovel.layouts.groovel_admin_messages')
@section('content')
	 <div style="margin-top:70px">
	       	@if(Session::get('messages'))
	             <div>{!!var_dump(Session::get('messages'))!!}</div>
	        @endif
	           <div id='messages'>
	                <!-- <div class="col-lg-12 col-sm-8 col-xs-12 col-lg-offset-2 col-md-offset-2 col-xs-offset-3 col-sm-9 col-sm-offset-4 col-xs-offset-0">-->
	                <div class="row">
	                    <div class="panel panel-default">
	                        <div class="panel-heading">
	                            <h3 class="panel-title"><i class="fa fa-bar-chart-o"></i> Messages</h3>
	                        </div>
	                         <div class="panel-body col-xs-7 col-sm-10 col-md-10">
		            	  		<div class='row' style='margin-bottom: 10px' >
			                         	<div class="col-md-2 col-sm-4 col-xs-2  hidden-xs">  
				                        	<input class="search" placeholder="Search" style="height:30px" />
				                        </div>
				                        <div class="col-md-4 col-md-offset-1 col-sm-4 col-sm-offset-1 hidden-xs"> 
									  		<button class="sort" data-sort="subject" style="height:30px">
									    		Sort by subject
									  		</button>
									  	</div>
									  	<div class="col-md-2 col-md-offset-0 col-sm-3 col-xs-2  col-xs-offset-6">      
			            					<a href= action="{{url('messages/compose') }}" class="btn btn-default">Write Message</a>
			          					</div>
							  		</div>
							  	</div>
	            				<table class="table table-hover table-striped table-bordered table-responsive" id="table_messages">
										<thead>
											 <tr>
					                          <th id="col_message" class="hidden-xs hidden-sm col-lg-1">id</th>
					                          <th id="col_message" class='col-xs-1'>subject</th>
					                          <th id="col_message" class="hidden-xs col-sm-1">author</th>
					                          <th id="col_message" class="col-sm-1 col-xs-1">received</th>
					                          <th id="col_message" class="col-sm-1 col-xs-1"></th>
					                          <th id="col_message" class="col-sm-1 col-xs-1"></th>
					              			</tr>
										</thead>
										<tbody class='list'>
											 @foreach ($messages as $message)
					                            <tr id="rows_messages">
						                            <td id="row_message" class="hidden-xs hidden-sm col-lg-1">{!!$message->id!!}</td>
						                            <td id="row_message" class='subject col-sm-2 col-xs-1'>{!!$message->subject!!}</td>
						                            <td id="row_message" class="hidden-xs col-sm-1">{!!$message->author!!}</td>
						                            <td id="row_message" class='col-sm-1 col-xs-1'>{!!$message->created_at!!}</td>
						                            <td id="edit" class='col-sm-4 col-xs-1 col-lg-1'>
						                            	<span id='editButton' class="glyphicon glyphicon-pencil btnEditMessage" aria-hidden="true"></span>
						                            </td>
						                            <td id="del" class="col-sm-4 col-lg-1 col-xs-1">
						                              	<span id='deleteButton' class="glyphicon glyphicon-trash btnDeleteMessage" aria-hidden="true"></span>
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
	    <!-- </div>-->
    <script>
 var options = {
  valueNames: [ 'subject']
};

var usersList = new List('messages', options);
 </script>  

@stop
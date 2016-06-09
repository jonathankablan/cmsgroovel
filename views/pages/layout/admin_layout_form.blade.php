@extends('cmsgroovel.layouts.groovel_admin_layout')
@section('content')
<!-- place in header of your html document -->
<div class='row'>
	<div class="col-sm-12 main" style='margin-top:50px;margin-left:50px'>
				<div class="col-md-12 col-md-offset-4">
				   @if(Session::get('msg'))
			             <div>{!!var_dump(Session::get('msg'))!!}</div>
			        @endif
			    </div>
			   	<div id='error' style='display:none'></div>
		
			    
			    <h1>Your layout:</h1>     
	 	        <form method="POST" action=" {{ url('admin/layout/update') }}" accept-charset="UTF-8" id="layout_form">
                 
                 <input id="id" name="layout_id" type="hidden" value={{ Session::get('layoutid')}}>
              	{{csrf_field()}}
         
                <div class='form-inline'>
                <label for="langage" class='required' style='margin-top:50px;font-size:1.6em'>Langage</label>
		     		<select id='langages' class="form-control" name='langages'>
						    <option name='langages'></option>
						    @foreach($langages as  $key=>$value)
						    	@if($key!=$layouts['lang'])
						    		<option value="{!!$key!!}">{!!$value!!}</option>
						    	@elseif($key==$layouts['lang'])
						    		<option selected='selected'value="{!!$key!!}">{!!$value!!}</option>
						    	@endif
						    @endforeach
						   
						
					</select>
				</div>
				 <div class="form-inline" style='margin-top:30px'>
                      <label for="type" class='required' style='margin-top:50px;font-size:1.6em'>Type</label>
		              <input readonly type='text' id='layoutchoice' name='layoutchoice' class='form-control'size='90' value={!!$layouts['layout']!!}>
				 </div>
				
                 <div class="form-inline" style='margin-top:30px'>
                      <label for="title" class='required' style='margin-top:50px;font-size:1.6em'>Title</label>
		              <input type='text' name='title' class='form-control'size='90' value={!!$layouts['title']!!}>
				 </div>
			  	 <label for="header" class='required' style='margin-top:50px;font-size:1.6em'>Header</label>
			     <div class="form-inline" style='margin-top:30px'>
			              <textarea name='header' cols='100' rows='10'>{!!$layouts['header']!!}</textarea>
				 </div>
				 
				 <label for="footer" class='required' style='margin-top:50px;font-size:1.6em'>Footer</label>
			     <div class="form-group" style='margin-top:30px'>
			              <textarea name='footer' cols='100' rows='10'>{!!$layouts['footer']!!}</textarea>
				 </div>
				 <div class="form-group form-inline">
				  <div class="row">
					  <div class="col-md-2" style="margin-top:50px;font-size:1.6em">
					   <label>Your Logo</label>
					   </div>
						<div class="col-md-3" style="margin-top:50px;">
							   @include('cmsgroovel.sections.picture_layout')
							   <input type="hidden" id="token" value="{{ csrf_token() }}">
						</div> 
					</div>	
				</div>
	
			<button class="btn btn-info" type="submit" id='submitForm'>Update</button>
			</form>
			
	</div>
</div>
<script>
$(document).ready(function() {
	bindFileEvents("layout_form");
});
  
	$("#submitForm").click(function (event) {
		var form=$('#layout_form').serialize();
		validateLayout(form);
		if (!$('#error').text().trim().length){
		    var status=postLayoutFiles();
		    if(!status){
				return false;
			}
			//fix update picture when no new added just keep the last one
	        if($('#logo').attr("value")!=null && $('#myfiles').attr("value")==''){
             	$('#myfiles').attr("value",$('#logo').attr("value"));
            }
			
			form=$('#layout_form').serialize();
			postLayout(form,'update');
		}
		return false;

	});

			     
$('input[type="checkbox"]').on('change', function() {
   $('input[type="checkbox"]').not(this).prop('checked', false);
});





</script>

@stop
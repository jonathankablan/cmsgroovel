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
			       
		     <h1 class='required'>Choose your layout:</h1>     
	 			
	          <form method="POST"  action=" {{ url('admin/layout/add') }}" accept-charset="UTF-8" id="layout_form">
	         	{{csrf_field()}}
		 
		       <input id='layout_id' type="hidden" name="layout_id">
		                 	
         								
			   @foreach ($layouts as $layout)
				   	@if($layout!='vendor' and $layout!='errors') 
				       <div class="form-group">
					     	 <div class="checkbox">
						        <label>
						          <input type="checkbox" name='layoutchoice' value={!!$layout!!}>{!!$layout!!}</input>
						        </label>
						      </div>
						 </div>
					 @endif                      
                 @endforeach	
                 
                <div class='form-inline'>
                <label for="langage" class='required' style='margin-top:50px;font-size:1.6em'>Langage</label>
		     		<select id='langages' class="form-control" name='langages'>
						    <option name='langages'></option>
						    @foreach($langages as $langage)
						    <?php if(!empty($langage)):?>
						    <option value="{!!$langage!!}">{!! $langage !!}</option>
						    <?php endif;?>
						    @endforeach
					</select>
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
                 <div class="form-inline" style='margin-top:30px'>
                      <label for="title" class='required' style='margin-top:50px;font-size:1.6em'>Title</label>
		              <input type='text' name='title' class='form-control'size='90'/>
				 </div>
			  	 <label for="header" class='required' style='margin-top:50px;font-size:1.6em'>Header</label>
			     <div class="form-inline" style='margin-top:30px'>
			              <textarea name='header' cols='100' rows='10'></textarea>
				 </div>
				 
				 <label for="footer" class='required' style='margin-top:50px;font-size:1.6em'>Footer</label>
			     <div class="form-group" style='margin-top:30px'>
			              <textarea name='footer' cols='100' rows='10'></textarea>
				 </div>
				 <input id="submitForm" class="btn btn-info" type="submit" value="Save Changes">			
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
			form=$('#layout_form').serialize();
			postLayout(form,'add');
		}
		return false;

	});

			     
$('input[type="checkbox"]').on('change', function() {
   $('input[type="checkbox"]').not(this).prop('checked', false);
});
</script>

@stop
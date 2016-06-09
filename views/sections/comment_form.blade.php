 <div class="well">
 	<h4>Leave a Comment:</h4>
      	 <form method="POST" action="{{url('comment/post')}}" accept-charset="UTF-8" id="comment_form">
			
         <input name='contenttranslationid' id='contenttranslationid' value={!!$content['contenttranslationid']!!} type='hidden'/>
            
										 
		<div class="form-group">
	 		<textarea id='comment 'name='comment'  class="form-control" rows='3'></textarea>
		</div>
	    @if(\Auth::user()!=null)
           <button type="submit" class="btn btn-primary" id='submitForm'>Submit</button>
		@else
	    	 <button class="btn btn-primary" onclick='pleaseConnect()' id='preventform'>Submit</button>
        @endif
		</form>
 </div>
 
 <div class="well">
 	<h4>Leave a Comment:</h4>
      	{!! Form::open(array('id'=>'comment_form','url' => 'comment/post', 'method' => 'POST')) !!}
         <input name='contenttranslationid' id='contenttranslationid' value={!!$content['contenttranslationid']!!} type='hidden'/>
            
										 
		<div class="form-group">
	 		{!!Form::textarea('comment', Input::old('comment'), array('class'=>'form-control','rows'=>'3')) !!}
		</div>
	    @if(\Auth::user()!=null)
           <button type="submit" class="btn btn-primary" id='submitForm'>Submit</button>
		@else
	    	 <button class="btn btn-primary" onclick='pleaseConnect()' id='preventform'>Submit</button>
        @endif
		{!! Form::close() !!}
 </div>
 
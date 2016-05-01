 @section('uploadfile')
 <div id="dvFiles" class="col-md-4" style="width:100%"> 
	 <label for="my-file" class="input-file-trigger" tabindex="0">Select a picture...</label>
	 <input class="input-file" id="my-file" name="files" type="file">
	  <output id="input_list" class="file-return">
	   <?php if(!empty(Session::get('user_edit')['userpicture'])):?>
	 	          <input type='hidden' id='picture' value={!!Session::get('user_edit')['userpicture']!!}/>
   		<?php endif?> 
	  </output>
	 <output id="old_list" class="file-return">
	 <?php if(Session::get('user_edit')['userpicture']!=null) :?>
	 	         <span id='picture' style='margin-left:10px;width:150px;height:150px;'>
    		          {!! HTML::image(Session::get('user_edit')['userpicture'],$alt='',$attributes = array('style'=>'width:150px;height:150px')) !!}
  		          <a rel="nofollow" href="#" title="Remove" id='picture' onclick=removeFile('picture')>Remove</a>
  		         </span>
      <?php endif;?>
	 </output>
	 <output id="list" class="file-return">
	     
	 </output>
</div>

@show


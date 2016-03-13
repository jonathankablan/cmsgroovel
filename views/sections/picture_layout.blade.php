 @section('uploadfile')
<div class="input-file-container" id="dvFiles"> 
 	 <label for="my-file" class="input-file-trigger" tabindex="0">Select a picture...</label>
	 <input class="input-file" id="my-file" name="files" type="file">
	  <output id="input_list" class="file-return">
	   <?php if($logo!=null):?>
	 	          <input type='hidden' id='logo' value={!!$logo!!}/>
   		<?php endif?> 
	  </output>
	 <output id="old_list" class="file-return">
	 <?php if($logo!=null) :?>
	 	         <span id='logo' style='margin-left:10px;width:150px;height:150px;'>
    		          {!! HTML::image($logo,$alt='',$attributes = array('style'=>'width:150px;height:150px')) !!}
  		          <a rel="nofollow" href="#" title="Remove" id='logo' onclick=removeFile('logo')>Remove</a>
  		         </span>
      <?php endif;?>
	 </output>
	 <output id="list" class="file-return">
	     
	 </output>
</div>

@show


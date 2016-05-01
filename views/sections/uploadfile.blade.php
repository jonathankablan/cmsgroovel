 @section('uploadfile')
 <div class="input-file-container" id="dvFiles" style="width:100%"> 
	 <label for="my-file" class="input-file-trigger" tabindex="0">Select a file...</label>
	 <input class="input-file" id="my-file" name="files[]" type="file" multiple='true'>
	  <output id="input_list" class="file-return">
	   <?php if(!empty($content['content'])):?>
	    @foreach($content['content'] as $name=>$file)
	 	          <input type='hidden' id='{!!$name!!}' value='{!!$file!!}'/>
  		 @endforeach
  		<?php endif?> 
	  </output>
	 <output id="old_list" class="file-return">
	 <?php if(!empty($content['content'])&& $content!=null && array_key_exists('content', $content) && !empty($content['content'])) :?>
	 	   @foreach($content['content'] as $name=>$file)
	 	         <span id='{!!$name!!}' style='margin-left:0px;width:150px;height:150px;'>
    		          {!! HTML::image($file,$alt='',$attributes = array('style'=>'width:150px;height:150px')) !!}
  		          <a rel="nofollow" href="#" title="Remove" id='{!!$name!!}' onclick=removeFile('{!!$name!!}')>Remove</a>
  		         </span>
  		   @endforeach
      <?php endif;?>
	 </output>
	 <output id="list" class="file-return">
	     
	 </output>
	
</div>

 <!-- <div id="loading"><img width="200" height="200" src="/packages/groovel/admin/images/ajax-loader.gif"></img></div>-->
   												 
@show


var storedFiles = [];
var filesAlreadyStored=[];
var max_number =5;
var urlimg=new Object();


function bindFileEvents ($id) {
	var s='#'+$id;
	$node=$(s);
	var fileInput  = $node.find( ".input-file" ),    
    button     =$node.find( ".input-file-trigger" ),
    the_return = $node.find(".file-return");  
	if(button!=null){
		button.bind( "keydown", function(event) {
			if ( event.keyCode == 13 || event.keyCode == 32 ) {  
		        fileInput.focus();  
		    }  
		});
		// action called when label is clicked
		button.bind( "click", function(event) {
			 fileInput.focus();  
			   return false;  
		});
	}
	if(fileInput!=null){
		// when input:file change ,visual return
		fileInput.bind( "change", function(event) {
			  fileSelect($node);
		});
		
	}
}

function validateFiles(files,filesAlreadyStored){
	if((files.length+filesAlreadyStored.length)>max_number){
		   alert("You reached maximum number of 5 files!");
		   return false;
	 }
	
	 for(i=0;i<files.length;i++){
	    	var file=files[i];
	        if (file) {
	    	        var fileSize = 0;
	    	        if (file.size > 1024 * 1024*2){
	    	          fileSize = (Math.round(file.size * 100 / (1024 * 1024)) / 100).toString() + 'MB';
	    	          alert('file size is too big not allowed it is limited to max 2M');
	    	          return false;
	    	        }/*else{
	    	          fileSize = (Math.round(file.size * 100 / 1024) / 100).toString() + 'KB';
	    	        }*/
	    	       
	    	 }
	 }
	return true;
}

function getFileOldList(){
	var list=$('#content_form #input_list');
	if(list.length){
		list.find("input").each(function() {
		      var tab=new Object();
			  tab={'name':$(this).attr('id'),'value':$(this).val()};
			  filesAlreadyStored.push(tab);
			  $(this).remove();
		   });
	}
}


function getUserPictureOldList(){
	var list=$('#user_form #input_list');
	if(list.length){
		list.find("input").each(function() {
		      var tab=new Object();
			  tab={'name':$(this).attr('id'),'value':$(this).val()};
			  filesAlreadyStored.push(tab);
			  $(this).remove();
		   });
	}
}

function clearFileOldList(){
	filesAlreadyStored=[];
	urlimg=new Object();
	storedFiles=[];
}

function removeFile(filename,$node) {
	for(var i=0;i<storedFiles.length;i++) {
		if(storedFiles[i].name === filename) {
			storedFiles.splice(i,1);
			break;
		}
	}
   //delete span it is common with user and contents
	if($node==null && filename!='picture' && filename!='logo'){
		$node=$('#content_form');
	}else if($node==null && filename=='picture'){
		$node=$('#user_form');
	}else if($node==null && filename=='logo'){
		$node=$('#layout_form');
	}

	var output= $node.find('#old_list');
    output.find("span").each(function() {
    	  if($(this).attr('id')==filename){
        	  this.remove();
          }
    });
    
    var output= $node.find('#list');
    output.find("span").each(function() {
      if($(this).attr('id')==filename){
    	  this.remove();
      }
   });
    
    var output= $node.find('#input_list');
    output.find("span").each(function() {
    	if($(this).attr('id')==filename){
        	  this.remove();
        }
   });
    
    var output= $node.find('#input_list');
    output.find("input").each(function() {
    	if($(this).attr('id')==filename){
        	  this.remove();
        }
   });
}

/**select file only image**/
function fileSelect($node) {
  var fileinput= $node.find( ".input-file" );
  var files =fileinput.prop("files");
  // Loop through the FileList and render image files as thumbnails.
    for (var i = 0, f; f = files[i]; i++) {
      // Only process image files.
      if (!f.type.match('image.*')
    		  && !f.type.match('application/pdf')) {
        continue;
      }
      storedFiles.push(f);
      var reader = new FileReader();
      // Closure to capture the file information.
      reader.onload = (function(theFile) {
        return function(e) {
          // Render thumbnail.
          var span = document.createElement('span');
          span.style='margin-left:10px';
          span.id=escape(theFile.name);
          span.innerHTML = ['<img id=',escape(theFile.name), ' style="width:150px;height:150px;" src="', e.target.result,
                            '" title="', escape(theFile.name), '">'].join('');
            
           var a = document.createElement('a');
           var linkText = document.createTextNode("Remove");
           a.appendChild(linkText);
           a.id=escape(theFile.name);
           a.title = "Remove";
           a.href = "#";
           a.rel="nofollow";
           a.onclick=function() {
          	   removeFile(escape(theFile.name),$node);
              };
           span.appendChild(a);
           $node.find('#list').append(span);
           
          
        };
      })(f);
      // Read in the image file as a data URL.
      reader.readAsDataURL(f);
    }
}


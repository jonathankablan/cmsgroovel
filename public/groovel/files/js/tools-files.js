var storedFiles = [];
var filesAlreadyStored=[];
var max_number =5;
var urlimg=new Object();

(function($){

	fileEvents = function() {
		var fileInput  = document.querySelector( ".input-file" ),    
	    button     = document.querySelector( ".input-file-trigger" ),  
	    the_return = document.querySelector(".file-return");  
		
		button.addEventListener( "keydown", function( event ) {  
			    if ( event.keyCode == 13 || event.keyCode == 32 ) {  
			        fileInput.focus();  
			    }  
			});
		   
		// action lorsque le label est cliqué  
		button.addEventListener( "click", function( event ) {  
		   fileInput.focus();  
		   return false;  
		});  
		   
		// affiche un retour visuel dès que input:file change  
		fileInput.addEventListener( "change", function( event ) {    
		   // the_return.innerHTML = this.value;    
			   fileSelect('my-file');
		});  
	}
	
})(jQuery);

function validateFiles(files,filesAlreadyStored){
	if((files.length+filesAlreadyStored.length)>max_number){
		   alert("You reached maximum number of 5 files!");
		   return false;
	 }
	
	 for(i=0;i<files.length;i++){
	    	var file=files[i];
	    	 if (file) {
	    	        var fileSize = 0;
	    	        if (file.size > 1024 * 1024*5){
	    	          fileSize = (Math.round(file.size * 100 / (1024 * 1024)) / 100).toString() + 'MB';
	    	          alert('file size is too big not allowed');
	    	          return false;
	    	        }/*else{
	    	          fileSize = (Math.round(file.size * 100 / 1024) / 100).toString() + 'KB';
	    	        }*/
	    	       
	    	 }
	 }
	return true;
}

function getFileOldList(){
	var list=document.getElementById('input_list');
	if(list!=null){
		var elements=list.getElementsByTagName('input');
		for(var u=0;u<elements.length;u++){
			var tab=new Object();
			tab={'name':elements[u].id,'value':elements[u].value};
			filesAlreadyStored.push(tab);
		}
		document.getElementById('input_list').innerHTML = "";
	}
}

function removeFile(filename) {
	for(var i=0;i<storedFiles.length;i++) {
		if(storedFiles[i].name === filename) {
			storedFiles.splice(i,1);
			break;
		}
	}
   //delete span
    var output= document.getElementById('old_list');
    var spans= output.getElementsByTagName('span');
    console.log(spans);
    for(var i=0;i<spans.length;i++){
    	if(spans[i].id==filename){
    		 spans[i].remove();
    	}
    }
    
  //delete span
    var output= document.getElementById('list');
    var spans= output.getElementsByTagName('span');
    console.log(spans);
    for(var i=0;i<spans.length;i++){
    	if(spans[i].id==filename){
    		 spans[i].remove();
    	}
    }
     
  //delete span
    var input= document.getElementById('input_list');
    var inputs= input.getElementsByTagName('input');
    console.log(inputs);
    for(var i=0;i<inputs.length;i++){
    	if(inputs[i].id==filename){
    		 inputs[i].remove();
    	}
    }
    
    
    var list=document.getElementById('input_list');
	var elements=list.getElementsByTagName('input');
	//bugger supprimer ds le cas ou pas d input
	if(elements.length==0){
		for(var i=0;i<filesAlreadyStored.length;i++){
			if(filesAlreadyStored[i].name==filename){
				filesAlreadyStored.splice(i,1);
				break;
			}
		}
	}
	for(var u=0;u<elements.length;u++){
		console.log(elements[u].id);
		if(elements[u].id==filename){
			elements[u].remove();
			break;
		}
	}
	console.log(filesAlreadyStored);
}

/**select file only image**/
function fileSelect(id) {
  var files = document.getElementById(id).files;
     // Loop through the FileList and render image files as thumbnails.
    for (var i = 0, f; f = files[i]; i++) {
      // Only process image files.
      if (!f.type.match('image.*')) {
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
          	   removeFile(escape(theFile.name),'my-file');
              };
           span.appendChild(a);
           document.getElementById('list').insertBefore(span, null);
           
          
        };
      })(f);
      // Read in the image file as a data URL.
      reader.readAsDataURL(f);
    }
}


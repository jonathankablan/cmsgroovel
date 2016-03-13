function postLayoutFiles(){
	 getFileOldList();
	 var status=true;
	 if($('#layout_form #my-file').length){
		$('#layout_form #my-file').val('');
		status=validateFiles(storedFiles,filesAlreadyStored);
	 }
	 if(status){
		 var ajaxData = new FormData();
		    for(i=0;i<storedFiles.length;i++){
			    var xhr = new XMLHttpRequest();
			    ajaxData.append("file", storedFiles[i]);
			    var token =  document.getElementById('token').value;
			    ajaxData.append("_token",token);
			    xhr.onreadystatechange = function () {
				  	response = this.responseText;
				  	if(response!=""){
		     	  	var url = JSON.parse(response);
	         		if(url['success']){
		    		  	urlimg[storedFiles[i]['name']]=url.datas[storedFiles[i]['name']];
		             }
		              else if(url['success']==false){
		            	 $("#alertmsg").css("color","red");
		                 $("#alertmsg").text('Oops something wrong happen');
		            	 return false;
		             }
				  }
			  	}
		   
			    xhr.open("POST", "/admin/file/upload",false);
			    xhr.send(ajaxData);
		    }
		    
		    var urls=[];
			// if exist already clean it	
	        var rem= $('#layout_form #myfiles');
	        if(rem.length){rem.remove();}
	
	        //create an input files hidden to send to server
	  		var input = document.createElement('input');
			input.type='hidden';
			input.name='myfiles';
	        input.id='myfiles';
			for(var filename in urlimg)
			{
	         urls.push(urlimg[filename]);
			}
			for(var i=0;i<filesAlreadyStored.length;i++)
			{     urls.push(filesAlreadyStored[i].value);
			}
	    	//add files
	        input.value=urls;
	        $('#layout_form #list').append(input);
		    return true;
	}else return false;
}




function validateLayout(form){
	var ajax=	$.ajax({
			  type: 'POST',
			  url:'/admin/layout/validate',
			  data: form,
			  async:false,
			  success:function(data) {
				var parsed=JSON.parse(data);
				  if(parsed['success']==true){
					  $("#alertmsg").css("color","green");
					  $("#alertmsg").text('layout has been added');
					  $("#error").empty();
			    	  return true;
	              }
	               else if(parsed['success']==false){
	            	  $("#alertmsg").css("color","red");
	                  $("#alertmsg").text(parsed['errors']['reason']);
	                  $("#error").text(parsed['errors']['reason']);
	                  return false;
	              }
			  }
			
		  });
	$("#popupModal").modal({                    // wire up the actual modal functionality and show the dialog
        "backdrop"  : "static",
        "keyboard"  : true,
        "show"      : true                     // ensure the modal is shown immediately
      });
	return false;
		}


function postLayout(form,action){
	$.post('/admin/layout/'+action, form, function (data, textStatus) {
		urlimg={};
		if(textStatus=='success'){
			if(data!=null){
				  var parsed = JSON.parse(data);
			      if(parsed['success']){
			       	 $("#layout_id").attr("value",parsed['datas']['id']);
			         $("#alertmsg").css("color","green");
			     	 $("#alertmsg").text('layout has been added');
			     	 $("#error").empty();
                   }
                    else if(parsed['success']==false){
                    	$("#alertmsg").css("color","red");
                    	$("#alertmsg").text(parsed['errors']['reason']);
                    	$("#error").text(parsed['errors']['reason']);
	               }
			}else{
				if(tinymce!=null){
		            	tinymce.remove();
				}
				alert('data problems');
			}
		}else{
			if(tinymce!=null){
	            	tinymce.remove();
			}
			alert('something mistake...problems');
		}
		
	 });
}

/**function edit layout **/

    function EditLayout(){
    var thArray = $("#table_layouts thead tr").map(function(index,elem) {
                  var ret = [];
                  var x = $(this);
                  var cells = x.find('th#col_layout');
                  $(cells, this).each(function () {
                      var d = $(this).val()||$(this).text();
                      ret.push(d);
                  });
                  return ret;
                });

      var tdArray=new Array();
      var parent=$(this).parent().parent();
          $(parent).children('td#row_layout').each(function(i,td) {
              tdArray.push($(this).text());
          });

      var inputData = new Array();
      for (i = 0; i < thArray.length; i++){ 
           inputData[thArray[i]]=tdArray[i];
      }
      $.ajax({
                  type: 'get',
                  data : any2url('q',inputData),
                  dateType:'json',
                  url: "/admin/layout/edit",
                   success: function(data) {
                       var parsed = JSON.parse(data);
                       window.location.href = parsed.datas.uri;
                  },
                  error: function(xhr, textStatus, thrownError) {
                      alert(thrownError);
                      alert('Something went to wrong.Please Try again later...');
                  }
                 
              });
    }

    /**function delete content **/

    function DeleteLayout(){
      var thArray = $("#table_layouts thead tr").map(function(index,elem) {
                  var ret = [];
                  var x = $(this);
                  var cells = x.find('th#col_layout');
                  $(cells, this).each(function () {
                      var d = $(this).val()||$(this).text();
                      ret.push(d);
                  });
                  return ret;
                });

      var tdArray=new Array();
      var parent=$(this).parent().parent();
          $(parent).children('td#row_layout').each(function(i,td) {
              tdArray.push($(this).text());
          });

      var inputData = new Array();
      for (i = 0; i < thArray.length; i++){ 
           inputData[thArray[i]]=tdArray[i];
      }
      $.ajax({
                  type: 'get',
                  data : any2url('q',inputData),
                  url: "/admin/layout/delete",
                   success: function(data) {
                     $("#alertmsg").css("color","green");
 			     	 $("#alertmsg").text('layout deleted successfully');
 			     	 $("#popupModal").modal({                  
 			             "backdrop"  : "static",
 			             "keyboard"  : true,
 			             "show"      : true                    
 			           });
                   },
                  error: function(xhr, textStatus, thrownError) {
                     alert(thrownError);
                      alert('Something went to wrong.Please Try again later...');
                  }
                 
              });
         var par = $(this).parent().parent(); //tr
         par.remove();
        
   }; 
 
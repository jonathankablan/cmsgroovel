function validateUser(form){
var ajax=	$.ajax({
		  type: 'POST',
		  url:'/admin/user/validate',
		  data: form,
		  async:false,
		  success:function(data) {
			var parsed=JSON.parse(data);
            if(parsed['success']==true){
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
return false;
}

function postPicture(){
	 var token = $('#token').val();
	 getFileOldList();
	 var status=true;
	 if($('#user_form #my-file').length){
		$('#user_form #my-file').val('');
		status=validateFiles(storedFiles,filesAlreadyStored);
	 }
	 if(status){
		 var ajaxData = new FormData();
		    for(i=0;i<storedFiles.length;i++){
			    var xhr = new XMLHttpRequest();
			    ajaxData.append("file", storedFiles[i]);
			    ajaxData.append("_token",token);
			    xhr.onreadystatechange = function () {
				  	response = this.responseText;
				  	if(response!=""){
		     	  	var url = JSON.parse(response);
	         		if(url['success']){
		    		  	urlimg[storedFiles[i]['name']]=url.datas[storedFiles[i]['name']];
		             }
		              else if(url['success']==false){
		            	 buildErrorMessage('Oops something wrong happen');
		            	 return false;
		             }
				  }
			  	}
		   
			    xhr.open("POST", "/admin/file/upload",false);
			    xhr.send(ajaxData);
		    }
		    
		    var urls=[];
			// if exist already clean it	
	        var rem= $('#user_form #myfiles');
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
	        $('#user_form #list').append(input);
		    return true;
	}else return false;
}

function postUser(form,action){
	$.post('/admin/user/'+action, form, function (data, textStatus) {
		urlimg={};
		if(textStatus=='success'){
			if(data!=null){
				  var parsed = JSON.parse(data);
				  console.log(parsed);
			      if(parsed['success']){
			    	  $("#error").empty();
			    	  $("#alertmsg").css("color","green");
 					  $("#alertmsg").text('user has been added successfully');
 					  $("#popupModal").modal({                   
 		               	    "backdrop"  : "static",
 		               	    "keyboard"  : true,
 		               	    "show"      : true                     
 		               	  });
 		         	}
                    else if(parsed['success']==false){
                      $("#alertmsg").css("color","red");
    				  $("#alertmsg").text(parsed['errors']['reason']);
    				  $("#error").text(parsed['errors']['reason']);
    				  $("#popupModal").modal({                   
    	               	    "backdrop"  : "static",
    	               	    "keyboard"  : true,
    	               	    "show"      : true                     
    	               	  });
                   }
			}else{
				alert('data problems');
			}
		}else{
			alert('something mistake...problems');
		}
		
	 });
}

 function DeleteUser(){
   var thArray = $("#table_users thead tr").map(function(index,elem) {
               var ret = [];
               var x = $(this);
               var cells = x.find('th#col_user');
               $(cells, this).each(function () {
                   var d = $(this).val()||$(this).text();
                   ret.push(d);
               });
               return ret;
             });

   var tdArray=new Array();
   var parent=$(this).parent().parent();
       $(parent).children('td#row_user').each(function(i,td) {
           tdArray.push($(this).text());
       });

   var inputData = new Array();
   for (i = 0; i < thArray.length; i++){ 
        inputData[thArray[i]]=tdArray[i];
   }
   
   $.ajax({
               type: 'get',
               data : any2url('q',inputData),
               url: "user/delete",
                success: function(data) {
                   alert('user deleted successfull');
               },
               error: function(xhr, textStatus, thrownError) {
                  alert(thrownError);
                   alert('Something went to wrong.Please Try again later...');
               }
              
           });
      var par = $(this).parent().parent(); //tr
      par.remove();
}; 


 function SaveUser(){
 var thArray = $("#table_users thead tr").map(function(index,elem) {
               var ret = [];
               var x = $(this);
               var cells = x.find('th#col_user');
               $(cells, this).each(function () {
                   var d = $(this).val()||$(this).text();
                   ret.push(d);
               });
               return ret;
             });

   var tdArray=new Array();
   var parent=$(this).parent().parent();
       $(parent).children('td#row_user').each(function(i,td) {
           tdArray.push($(this).text());
       });

   var inputData = new Array();
   for (i = 0; i < thArray.length; i++){ 
        inputData[thArray[i]]=tdArray[i];
   }
   
   $.ajax({
               type: 'get',
               data : any2url('q',inputData),
               url: "user/update",
                success: function(data) {
                   alert('user saved successfull');
               },
               error: function(xhr, textStatus, thrownError) {
                   alert(thrownError);
                   alert('Something went to wrong.Please Try again later...');
               }
              
           });
 }

 
 function EditUser(){
	  var thArray = $("#table_users thead tr").map(function(index,elem) {
	                var ret = [];
	                var x = $(this);
	                var cells = x.find('th#col_user');
	                $(cells, this).each(function () {
	                    var d = $(this).val()||$(this).text();
	                    ret.push(d);
	                });
	                return ret;
	              });

	    var tdArray=new Array();
	    var parent=$(this).parent().parent();
	        $(parent).children('td#row_user').each(function(i,td) {
	            tdArray.push($(this).text());
	        });

	    var inputData = new Array();
	    for (i = 0; i < thArray.length; i++){ 
	         inputData[thArray[i]]=tdArray[i];
	    }
	    $.ajax({
	                type: 'get',
	                data : any2url('q',inputData),
	                url: "user/edit",
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


 function ActivateUser(){
 	 var thArray = $("#table_users thead tr").map(function(index,elem) {
          var ret = [];
          var x = $(this);
          var cells = x.find('th#col_user');
          $(cells, this).each(function () {
              var d = $(this).val()||$(this).text();
              ret.push(d);
          });
          return ret;
        });

 		var tdArray=new Array();
 		var parent=$(this).parent().parent();
 		 $(parent).children('td#row_user').each(function(i,td) {
 		     tdArray.push($(this).text());
 		 });
 		
 		var inputData = new Array();
 		for (i = 0; i < thArray.length; i++){ 
 		  inputData[thArray[i]]=tdArray[i];
 		}
 	    $.ajax({
 	                type: 'get',
 	                data : any2url('q',inputData),
 	                url: "user/activate",
 	                 success: function(data) {
 	                	alert('done');
 	                    var parsed = JSON.parse(data);
 	                },
 	                error: function(xhr, textStatus, thrownError) {
 	                    alert(thrownError);
 	                    alert('Something went to wrong.Please Try again later...');
 	                }
 	               
 	            });
 }

 function NotActivateUser(){
 	 var thArray = $("#table_users thead tr").map(function(index,elem) {
          var ret = [];
          var x = $(this);
          var cells = x.find('th#col_user');
          $(cells, this).each(function () {
              var d = $(this).val()||$(this).text();
              ret.push(d);
          });
          return ret;
        });

 		var tdArray=new Array();
 		var parent=$(this).parent().parent();
 		 $(parent).children('td#row_user').each(function(i,td) {
 		     tdArray.push($(this).text());
 		 });
 		
 		var inputData = new Array();
 		for (i = 0; i < thArray.length; i++){ 
 		  inputData[thArray[i]]=tdArray[i];
 		}
 	    $.ajax({
 	                type: 'get',
 	                data : any2url('q',inputData),
 	                url: "user/notactivate",
 	                 success: function(data) {
 	                	 alert('done');
 	                    var parsed = JSON.parse(data);
 	                },
 	                error: function(xhr, textStatus, thrownError) {
 	                    alert(thrownError);
 	                    alert('Something went to wrong.Please Try again later...');
 	                }
 	               
 	            });
 }



 function EditUserRole(){
 var thArray = $("#table_users thead tr").map(function(index,elem) {
               var ret = [];
               var x = $(this);
               var cells = x.find('th#col_user');
               $(cells, this).each(function () {
                   var d = $(this).val()||$(this).text();
                   ret.push(d);
               });
               return ret;
             });

   var tdArray=new Array();
   var parent=$(this).parent().parent();
       $(parent).children('td#row_user').each(function(i,td) {
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
               url: "role/edit",
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


 function DeleteUserRole(){
 	var thArray = $("#table_users thead tr").map(function(index,elem) {
 	              var ret = [];
 	              var x = $(this);
 	              var cells = x.find('th#col_user');
 	              $(cells, this).each(function () {
 	                  var d = $(this).val()||$(this).text();
 	                  ret.push(d);
 	              });
 	              return ret;
 	            });

 	  var tdArray=new Array();
 	  var parent=$(this).parent().parent();
 	      $(parent).children('td#row_user').each(function(i,td) {
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
 	              url: "user/role/edit",
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
 
 

 function ViewUser(){
 	  var thArray = $("#table_users thead tr").map(function(index,elem) {
           var ret = [];
           var x = $(this);
           var cells = x.find('th#col_user');
           $(cells, this).each(function () {
               var d = $(this).val()||$(this).text();
               ret.push(d);
           });
           return ret;
         });

 var tdArray=new Array();
 var parent=$(this).parent().parent();
   $(parent).children('td#row_user').each(function(i,td) {
       tdArray.push($(this).text());
   });

 var inputData = new Array();
 for (i = 0; i < thArray.length; i++){ 
    inputData[thArray[i]]=tdArray[i];
 }
 $.ajax({
           type: 'get',
           data : any2url('q',inputData),
           url: "user/view",
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



 function EditUserProfile(){
 	id=document.getElementById('user').value;
 	var inputData = new Array();
 	inputData['id']=id;
 	$.ajax({
 	                type: 'get',
 	                data : any2url('q',inputData),
 	                url: "profile/edit",
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
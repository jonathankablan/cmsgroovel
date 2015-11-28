
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
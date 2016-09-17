//open a modal window other another
$(document).ready(function (){
	$('#popupModal').on('show.bs.modal', function() {
	 	  	$('#modal').css('opacity', 0.2);
	 	  	$('#modal').css({zIndex: 1040})
	});
	
	$('#popupModal').on('hide.bs.modal', function() {
		 	$('#modal').css('opacity', 1);
	});
})


function DeleteMessage(){
   var thArray = $("#table_messages thead tr").map(function(index,elem) {
                var ret = [];
                var x = $(this);
                var cells = x.find('th#col_message');
                $(cells, this).each(function () {
                    var d = $(this).val()||$(this).text();
                    ret.push(d);
                });
                return ret;
              });

    var tdArray=new Array();
    var parent=$(this).parent().parent();
        $(parent).children('td#row_message').each(function(i,td) {
            tdArray.push($(this).text());
        });

    var inputData = new Array();
    for (i = 0; i < thArray.length; i++){ 
         inputData[thArray[i]]=tdArray[i];
    }
    $.ajax({
                type: 'get',
                data : any2url('q',inputData),
                url: "/messages/delete",
                 success: function(data) {
                	  $("#alertmsg").css("color","green");
					  $("#alertmsg").text('message has been deleted');
					  $("#error").empty();
					  $("#popupModal").modal({                    // wire up the actual modal functionality and show the dialog
					        "backdrop"  : "static",
					        "keyboard"  : true,
					        "show"      : true                     // ensure the modal is shown immediately
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
 
 

 function EditMessage(){
 var thArray = $("#table_messages thead tr").map(function(index,elem) {
               var ret = [];
               var x = $(this);
               var cells = x.find('th#col_message');
               $(cells, this).each(function () {
                   var d = $(this).val()||$(this).text();
                   ret.push(d);
               });
               return ret;
             });

   var tdArray=new Array();
   var parent=$(this).parent().parent();
       $(parent).children('td#row_message').each(function(i,td) {
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
               url: "/messages/edit",
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

 function DeleteForum(){
	   var thArray = $("#table_forums thead tr").map(function(index,elem) {
	               var ret = [];
	               var x = $(this);
	               var cells = x.find('th#col_forum');
	               $(cells, this).each(function () {
	                   var d = $(this).val()||$(this).text();
	                   ret.push(d);
	               });
	               return ret;
	             });

	   var tdArray=new Array();
	   var parent=$(this).parent().parent();
	       $(parent).children('td#row_forum').each(function(i,td) {
	           tdArray.push($(this).text());
	       });

	   var inputData = new Array();
	   for (i = 0; i < thArray.length; i++){ 
	        inputData[thArray[i]]=tdArray[i];
	   }
	   
	   $.ajax({
	               type: 'get',
	               data : any2url('q',inputData),
	               url: "/forum/delete",
	                success: function(data) {
	                   var parsed = JSON.parse(data);
	                   if(parsed['success']==false){
	                	   alert(parsed['errors']['reason']);
	                   }else{
	                	   alert('forum has been deleted');
	                   }
	                
	               },
	               error: function(xhr, textStatus, thrownError) {
	                  alert(thrownError);
	                   alert('Something went to wrong.Please Try again later...');
	               }
	              
	           });
	      var par = $(this).parent().parent(); //tr
	      par.remove();
	}; 

	
	function DeleteTopic(){
		   var thArray = $("#table_topics thead tr").map(function(index,elem) {
		               var ret = [];
		               var x = $(this);
		               var cells = x.find('th#col_topic');
		               $(cells, this).each(function () {
		                   var d = $(this).val()||$(this).text();
		                   ret.push(d);
		               });
		               return ret;
		             });

		   var tdArray=new Array();
		   var parent=$(this).parent().parent();
		       $(parent).children('td#row_topic').each(function(i,td) {
		           tdArray.push($(this).text());
		       });

		   var inputData = new Array();
		   for (i = 0; i < thArray.length; i++){ 
		        inputData[thArray[i]]=tdArray[i];
		   }
		   $.ajax({
		               type: 'get',
		               data : any2url('q',inputData),
		               url: "/forum/topic/delete",
		                success: function(data) {
		                   var parsed = JSON.parse(data);
		                   if(parsed['success']==false){
		                	   alert(parsed['errors']['reason']);
		                   }else{
		                	   alert('topic has been deleted');
		                   }
		                
		               },
		               error: function(xhr, textStatus, thrownError) {
		                  alert(thrownError);
		                   alert('Something went to wrong.Please Try again later...');
		               }
		              
		           });
		      var par = $(this).parent().parent(); //tr
		      par.remove();
		}; 


	
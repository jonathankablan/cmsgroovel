		$(document).delegate("#readmore", "click", function() {
        	  var comments=$(this).parents().eq(0).find('#morecomments');
        	  if(comments.attr('style')=='display:none'){
  	       		comments.attr('style','visible');
  	       	  }else if(comments.attr('style')=='visible'){
  	       		comments.attr('style','display:none');
  		      }
        });
     
         $(document).delegate("#preventform", "click", function(e) {
                e.preventDefault();
       	        return false;
       	 })
			
	     function pleaseConnect(){
                $("#popupModal").modal({                    // wire up the actual modal functionality and show the dialog
	              "backdrop"  : "static",
	              "keyboard"  : true,
	              "show"      : true                     // ensure the modal is shown immediately
	            });
                $("#alertmsg").text('Please register or Login.');
         }

         $(document).delegate("#submitForm", "click", function() {
         	    form=$(this).parents().eq(0).serialize();
         		$.post('/comment/post', form, function (data, textStatus) {
          			var parsed = JSON.parse(data);
         			if(parsed['success']){
         				 $("#alertmsg").text('Comment Posted!');
         				 $("#popupModal").modal({                    // wire up the actual modal functionality and show the dialog
         		              "backdrop"  : "static",
         		              "keyboard"  : true,
         		              "show"      : true                     // ensure the modal is shown immediately
         		        });
         				 $('#comment_form').find('textarea').val(''); //clear all
         				
         	           
         	         }
         	          else if(parsed['success']==false){
         	        	  $("#alertmsg").text('something wrong happen');
         	        	  $("#popupModal").modal({                    // wire up the actual modal functionality and show the dialog
         		              "backdrop"  : "static",
         		              "keyboard"  : true,
         		              "show"      : true                     // ensure the modal is shown immediately
         		          });
         	      		
         	         }
         		 });
         		return false;
          });
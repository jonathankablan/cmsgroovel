 function DeleteUserPermission(){
   var thArray = $("#table_users_permissions thead tr").map(function(index,elem) {
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
               url: "delete/permission",
                success: function(data) {
                   alert('permission deleted successfull');
              },
               error: function(xhr, textStatus, thrownError) {
                  alert(thrownError);
                   alert('Something went to wrong.Please Try again later...');
               }
              
           });
      var par = $(this).parent().parent(); //tr
      par.remove();
}; 
 

function EditUserPermission(){
	  var thArray = $("#table_users_permissions thead tr").map(function(index,elem) {
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
	                url: "permission/edit",
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

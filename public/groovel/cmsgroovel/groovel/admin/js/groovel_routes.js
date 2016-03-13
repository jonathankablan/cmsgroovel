
normalMode = function() {
	var normalFieldMode=['uri','name','view','type','subtype','activate_route'];
	var expertFieldMode=['controller','method','audit_url'];
    for(i = 0; i < expertFieldMode.length; i++){
        document.getElementById(expertFieldMode[i]).style.display = 'none';
	 }
}

expertMode = function() {
	var normalFieldMode=['uri','name','view','type','subtype','activate_route'];
	var expertFieldMode=['controller','method','audit_url'];
    for(i = 0; i < expertFieldMode.length; i++){
        document.getElementById(expertFieldMode[i]).style.display = 'block';
	 }
}



function DeleteRoute(){
    var thArray = $("#table_routes thead tr").map(function(index,elem) {
                var ret = [];
                var x = $(this);
                var cells = x.find('th#col_route');
                $(cells, this).each(function () {
                    var d = $(this).val()||$(this).text();
                    ret.push(d);
                });
                return ret;
              });

    var tdArray=new Array();
    var parent=$(this).parent().parent();
        $(parent).children('td#row_route').each(function(i,td) {
            tdArray.push($(this).text());
        });

    var inputData = new Array();
    for (i = 0; i < thArray.length; i++){ 
         inputData[thArray[i]]=tdArray[i];
    }
    $.ajax({
                type: 'get',
                data : any2url('q',inputData),
                url: "/admin/routes/delete",
                 success: function(data) {
                    alert('route deleted successfull');
                 },
                error: function(xhr, textStatus, thrownError) {
                   alert(thrownError);
                    alert('Something went to wrong.Please Try again later...');
                }
               
            });
       var par = $(this).parent().parent(); //tr
       par.remove();
 }; 


  function SaveRoute(){
  var thArray = $("#table_routes thead tr").map(function(index,elem) {
                var ret = [];
                var x = $(this);
                var cells = x.find('th#col_route');
                $(cells, this).each(function () {
                    var d = $(this).val()||$(this).text();
                    ret.push(d);
                });
                return ret;
              });

    var tdArray=new Array();
    var parent=$(this).parent().parent();
        $(parent).children('td#row_route').each(function(i,td) {
            tdArray.push($(this).text());
        });

    var inputData = new Array();
    for (i = 0; i < thArray.length; i++){ 
         inputData[thArray[i]]=tdArray[i];
    }
    
     $.ajax({
                type: 'get',
                data : any2url('q',inputData),
                url: "/admin/routes/update",
                 success: function(data) {
                    alert('route saved successfull');
                 },
                error: function(xhr, textStatus, thrownError) {
                    alert(thrownError);
                    alert('Something went to wrong.Please Try again later...');
                }
               
            });
  }

  
  function EditRoute(){
	  var thArray = $("#table_routes thead tr").map(function(index,elem) {
	                var ret = [];
	                var x = $(this);
	                var cells = x.find('th#col_route');
	                $(cells, this).each(function () {
	                    var d = $(this).val()||$(this).text();
	                    ret.push(d);
	                });
	                return ret;
	              });

	    var tdArray=new Array();
	    var parent=$(this).parent().parent();
	        $(parent).children('td#row_route').each(function(i,td) {
	            tdArray.push($(this).text());
	        });

	    var inputData = new Array();
	    for (i = 0; i < thArray.length; i++){ 
	         inputData[thArray[i]]=tdArray[i];
	    }
	    $.ajax({
	                type: 'get',
	                data : any2url('q',inputData),
	                url: "/admin/routes/edit",
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

  